var tax_percentage = 9;

Vue.component('food-bag', {
    props: ['user', 'customer', 'kitchen'],

    data() {
        return {
            editingItem: {},
            editingItemQuantity: '',
            deliveryFeeSet: false,
            quantity: 1,
            bagForm: new IfcForm({
                bag: {
                    subtotal: 0,
                    tax: 0,
                    total: 0,
                    kitchen: '',
                    items: [],
                    pickupOrDelivery: 'pickup'
                }
            })
        }
    },

    events: {
        /**
         * Add item to bag
         * @param item
         * @param kitchen
         */
        newItemAddedToBag(item, kitchen) {
            this.addItemToBag(item, kitchen);
        },

        itemRemovedFromBag(item) {
            this.removeItemFromBag(item)
        },

        updatePickupOrDelivery(option) {
            this.$set(this.bagForm.bag, 'pickupOrDelivery', option)

            switch (option) {
                case 'pickup':
                    if (this.deliveryFeeSet) {
                        this.removeDeliveryFee();
                    }
                    break;
                case 'delivery':
                    this.addDeliveryFee();
                    break;
            }
        }
    },

    created() {
        // check if user is defined, if null then we have
        // a guest user, so create a cookie to hold the bag
        // Once user authenticates then we can save the bag to
        // a session and the database, and destroy the cookie


        // if there isn't a cookie, create one
        // this will hold the bag contents
        if (Cookies.get('bag') === undefined) {
            this.createBag();
        } else {
            this.bagForm.bag = this.getBag();
        }
    },

    mounted() {

    },

    computed: {
        dayOfWeek() {
            var d = new Date();

            return d.getDay();
        }
    },

    methods: {
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

                this.updateBag();
            }
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

        updateBag() {
            this.createBag();
        },

        /**
         * Create cookie to hold bag contents
         */
        createBag() {
            Cookies.set('bag', this.bagForm.bag, { expires: 1 });
        },

        /**
         * Get content of bag
         * @returns Json
         */
        getBag() {
            return Cookies.getJSON('bag');
        },

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
            var tax = Decimal.div(Decimal.mul(this.bagForm.bag.subtotal, tax_percentage), 100);

            this.bagForm.bag.tax = Math.round(tax);
        },

        updateTotal() {
            var total = Decimal.add(this.bagForm.bag.subtotal, this.bagForm.bag.tax);

            if (this.deliveryFeeSet) {
                total = Decimal.add(total, this.kitchen.delivery_fee);
            }

            this.bagForm.bag.total = parseInt(total);
        },

        setKitchen(kitchen) {
            console.log(kitchen);
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
                    pickupOrDelivery: 'pickup'
            };

            // reset the cookie
            this.createBag();
        },

        addDeliveryFee() {
            this.deliveryFeeSet = true;

            this.bagForm.bag.total = parseInt(Decimal.add(this.bagForm.bag.total, this.kitchen.delivery_fee));
        },

        removeDeliveryFee() {
            this.deliveryFeeSet = false;

            this.bagForm.bag.total = parseInt(Decimal.sub(this.bagForm.bag.total, this.kitchen.delivery_fee));
        },

        checkout() {
            // save bag to session
            // redirect to checkout page
            Ifc.post('/bag', this.bagForm)
                .then(response => {
                    window.location = response.redirect;
                });
        }
    }
});