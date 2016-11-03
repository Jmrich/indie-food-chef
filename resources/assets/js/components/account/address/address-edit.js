Vue.component('address-edit', {
    props: ['user', 'customer', 'address'],

    data() {
        return {
            form: new IfcForm({
                id: '',
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
        Bus.$on('editAddress', (address) => {
            self.setAddressValues(address);

            $('#editAddress').appendTo('body').modal('show');
        })
    },

    computed: {
        addressUrl() {
            return `/addresses/${this.form.id}`;
        }
    },

    methods: {
        updateAddress() {
            Ifc.put(this.addressUrl, this.form)
                .then(response => {
                    Bus.$emit('updateAddresses');

                    $('#editAddress').modal('toggle');
                }, error => {

                });
        },
        
        setAddressValues(address) {
            Vue.set(this.form, 'id', address.id);
            Vue.set(this.form, 'address', address.address);
            Vue.set(this.form, 'address_line_2', address.address_line_2);
            Vue.set(this.form, 'city', address.city);
            Vue.set(this.form, 'state', address.state);
            Vue.set(this.form, 'zip', address.zip);
            Vue.set(this.form, 'country', address.country);
        }
    }
});