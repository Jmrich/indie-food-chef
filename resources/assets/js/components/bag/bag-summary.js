Vue.component('bag-summary', {
    props: ['customer', 'user', 'cards', 'addresses'],

    data() {
        return {
            showAddCardForm: false,
            addressCollection: this.addresses,
            defaultAddress: '',
            bagForm: new IfcForm({
                bag: {
                    subtotal: 0,
                    tax: 0,
                    total: 0,
                    kitchen: '',
                    items: [],
                    pickupOrDelivery: ''
                },
                pickupOrDelivery: '',
                deliveryAddress: ''
            })

        }
    },

    created() {
        // get the bag
        this.getBag();

        var self = this;

        Bus.$on('updateAddresses', () => {
            self.$http.get('/addresses').then(response => {
                Vue.set(self, 'addressCollection', response.data);
                //this.addresses = response.data;
            }, error => {
            });
        });

        this.setDefaultAddress();
    },

    events: {

    },

    computed: {
        kitchenUrl() {
            return `/kitchens/${this.bagForm.bag.kitchen.slug}`;
        },

        showAddressSection() {
            return this.bagForm.bag.pickupOrDelivery == 'delivery'
        },

        delivering() {
            return this.bagForm.bag.pickupOrDelivery == 'delivery'
        },
    },

    methods: {
        getBag() {
            this.$http.get('/bag/current')
                .then(response => {
                    this.$set(this.bagForm, 'bag', response.data);
                });
        },

        modifyOrder() {
            window.location = this.kitchenUrl;
        },

        placeOrder() {
            // update the address in the bag
            if(this.delivering) {
                Vue.set(this.bagForm, 'deliveryAddress', this.defaultAddress.formatted_address);
            }

            Ifc.post('/orders', this.bagForm)
                .then(response => {
                    // remove the cookie
                    Cookies.remove('bag');

                    window.location = response.redirect;
                }, response => {

                })
        },

        showCardForm() {
            this.showAddCardForm = true;
        },

        hideCardForm() {
            this.showAddCardForm = false;
        },

        setDefaultAddress() {
            var defaultAddress = _.find(this.addressCollection, (address) => {return address.default; });

            Vue.set(this, 'defaultAddress', defaultAddress);
        }

        /*updateAddresses() {
            this.$http.get('/addresses').then((response) => {
                console.log('update hit');
                //this.addresses = response.json();
                this.$set('addresses', response.data);
            }, (response) => {
            });
        }*/
    }
});