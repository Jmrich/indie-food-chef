Vue.component('kitchen-show', {
    props: ['kitchen', 'menus', 'menu-sections', 'dishes', 'hours', 'user', 'customer'],

    data() {
        return {
            pickupOrDelivery: '',
            editingItem: {},
            editingItemQuantity: '',
            quantity: 1,
            bagForm: new IfcForm({
                bag: {
                    subtotal: 0,
                    tax: 0,
                    total: 0,
                    kitchen: '',
                    items: [],
                    pickupOrDelivery: '',
                    deliveryFeeSet: '',
                }
            })
        }
    },

    created() {
        //this.setupDishes();

        // if there isn't a cookie, create one
        // this will hold the bag contents
        if (Cookies.get('bag') === undefined) {
            // set to pickup as default
            Vue.set(this.bagForm.bag, 'pickupOrDelivery', 'pickup');

            this.createBag();
        } else {
            this.bagForm.bag = this.getBag();
        }
    },

    computed: {
        dayOfWeek() {
            var d = new Date();

            return d.getDay();
        }
    },

    methods: {
        dayHasPassed (day) {
            var today = (new Date()).getDay();
            return day < today;
        },

        hasCutoffTimePassed(menu) {
            // Lets make sure the cutoff time for the menu hasn't passed
            // if they are placing an order for the same day
            if (menu.day_of_week == this.$root.dayOfWeek) {
                var now = moment().format('HH:mm:ss');

                return now > menu.cutoff_time;
            }
        },

        areDishesEmpty(dishes) {
            return _.isEmpty(dishes);
        },

        addItemToBag(item, kitchen) {
            // Set kitchen if not already set
            if (this.bagForm.bag.kitchen == '') {
                this.setKitchen(kitchen);
            }

            // Let's verify that they are adding items from the same kitchen
            if (! this.verifyKitchenIsTheSame(item, this.bagForm.bag.kitchen)) {
                // Ask user if they would like to clear the bag
                // since the kitchens aren't the same
                var prompt = 'You are trying to add an item from a different kitchen. Would you like to clear the current order?';

                var user_prompt = confirm(prompt);

                if (user_prompt == true) {
                    // clear the bag and continue
                    this.clearBag();
                    this.setKitchen(kitchen)
                }
            }

            // push item to bag object
            this.bagForm.bag.items.push({
                id: item.id,
                name: item.name,
                price: item.price,
                description: item.description,
                menu_id: item.pivot.menu_id,
                notes: item.notes,
                quantity: item.quantity
            });

            // clear the quantity
            //this.quantity = 1;

            this.updateSubTotal();

            this.updateBag();
        },

        editItemInBag(item, index) {
            // find a way to show the module that the item
            // belongs to
            var modal = 'dish-modal-'+ item.menu_id + '-' + item.id;
            // set editingItem to current item
            this.editingItem = item;
            this.editingItemQuantity = item.quantity;

            $('#edit-item').appendTo('body').modal('show');
        },

        updateItem() {
            if (this.editingItemQuantity != this.editingItem.quantity) {
                this.updateSubTotal();
            }

            this.updateBag();

            // hide the modal
            $('#edit-item').modal('hide');
        },

        removeItemFromBag(item) {
            var response = confirm("Are you sure you would like to remove " + item.name);

            if (response == true) {
                var index = this.bagForm.bag.items.indexOf(item);
                this.bagForm.bag.items.splice(index, 1);

                this.updateSubTotal();

                this.updateBag();
            }
        },

        updateDeliveryOption() {
            //this.$set(this.bagForm.bag, 'pickupOrDelivery', this.pickupOrDelivery);

            this.updateBag();

            switch (this.bagForm.bag.pickupOrDelivery) {
                case 'pickup':
                    if (this.bagForm.bag.deliveryFeeSet) {
                        this.removeDeliveryFee();
                    }
                    break;
                case 'delivery':
                    this.addDeliveryFee();
                    break;
            }
        },

        updateBag() {
            this.createBag();
        },

        /**
         * Create cookie to hold bag contents
         */
        createBag() {
            var inFifteenMinutes = new Date(new Date().getTime() + 15 * 60 * 1000);

            Cookies.set('bag', this.bagForm.bag, { expires: inFifteenMinutes });
        },

        /**
         * Get content of bag
         * @returns Json
         */
        getBag() {
            return Cookies.getJSON('bag');
        },

        /**
         * Update the subtotal
         *
         */
        updateSubTotal() {
            var subtotal = 0;

            _.each(this.bagForm.bag.items, function (item) {
                var quantity = parseInt(item.quantity);

                if (quantity > 1) {
                    for (var i=0; i<quantity;i++) {
                        subtotal = Decimal.add(subtotal, item.price);
                    }
                } else {
                    subtotal = Decimal.add(subtotal, item.price);
                }
            });

            this.bagForm.bag.subtotal = parseInt(subtotal);

            // update other totals after updating subtotal
            this.updateTaxTotal();

            this.updateTotal();
        },

        updateTaxTotal() {
            var tax = Decimal.div(Decimal.mul(this.bagForm.bag.subtotal, this.kitchen.tax_rate), 100);

            this.bagForm.bag.tax = Math.round(tax);
        },

        updateTotal() {
            var total = Decimal.add(this.bagForm.bag.subtotal, this.bagForm.bag.tax);

            if (this.bagForm.bag.deliveryFeeSet) {
                total = Decimal.add(total, this.kitchen.delivery_fee);
            }

            this.bagForm.bag.total = parseInt(total);
        },

        setKitchen(kitchen) {
            this.bagForm.bag.kitchen = {
                id: kitchen.id,
                slug: kitchen.slug,
                name: kitchen.name,
                delivers: kitchen.delivers,
                delivery_fee: kitchen.delivery_fee
            };
        },

        verifyKitchenIsTheSame(item, kitchen) {
            return item.kitchen_id == kitchen.id;
        },

        clearBag() {
            // reset the bag
            this.bagForm.bag = {
                subtotal: 0,
                tax: 0,
                total: 0,
                kitchen: '',
                items: [],
                pickupOrDelivery: ''
            };

            // reset the cookie
            this.createBag();
        },

        addDeliveryFee() {
            this.bagForm.bag.deliveryFeeSet = true;

            this.bagForm.bag.total = parseInt(Decimal.add(this.bagForm.bag.total, this.kitchen.delivery_fee));

            this.updateBag();
        },

        removeDeliveryFee() {
            this.bagForm.bag.deliveryFeeSet = false;

            this.bagForm.bag.total = parseInt(Decimal.sub(this.bagForm.bag.total, this.kitchen.delivery_fee));

            this.updateBag();
        },

        checkout() {
            // save bag to session
            // redirect to checkout page
            Ifc.post('/bag', this.bagForm)
                .then(response => {
                    window.location = response.redirect;
                });
        },

        setupDishes() {
            var self = this;
            _.forEach(this.menus, function (menu, menu_key) {
                _.forEach(menu.dishes, function (dish, dish_key) {
                    Vue.set(dish, 'notes', '');

                    Vue.set(dish, 'quantity', 1);
                });
            });
        },

        getPickupOrDelivery(option) {
            if (this.bagForm.bag.pickupOrDelivery == '') {
                Vue.set(this.bagForm.bag, 'pickupOrDelivery', 'pickup');

                this.updateBag();
            }

            return this.bagForm.bag.pickupOrDelivery == option;
        },

        menuHasDishes(menu) {
            return menu.dishes.length > 0;
        }
    }
});