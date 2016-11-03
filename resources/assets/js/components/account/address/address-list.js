Vue.component('address-list', {
    props: ['user', 'customer', 'addresses'],

    data() {
        return {
            editingItem: {},
            addressCollection: this.addresses,
            form: new IfcForm({
                address: '',
                address_line_2: '',
                city: '',
                state: '',
                zip: '',
                country: ''
            })
        }
    },

    created() {
        var self = this;
        Bus.$on('updateAddresses', () => {
            self.getAddresses();
        });
    },

    computed: {
        isAddressObjectEmpty() {
            return Object.keys(this.addresses).length;
        }
    },

    methods: {
        getAddresses() {
            this.$http.get('/addresses').then(response => {
                // success callback
                Vue.set(this, 'addressCollection', response.data);

            }, (response) => {
                // error callback
            });
        },

        removeAddress(address) {
            var prompt = confirm('Are you sure you would like to remove this address?');

            if (prompt) {
                Ifc.delete(`/addresses/${address.id}`, this.form)
                    .then((response) => {
                        console.log(response);
                    }, error => {
                        console.log('some error')
                    });

                this.getAddresses();
            }
        },

        showEditAddress(address) {
            Bus.$emit('editAddress', address);
        },
    }
});