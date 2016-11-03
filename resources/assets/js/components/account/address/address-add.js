Vue.component('address-add', {
    props: ['user', 'customer'],

    data() {
        return {
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

    },

    computed: {

    },

    methods: {
        add() {
            Ifc.post(`/addresses`, this.form)
                .then(response => {
                    $('#addAddress').modal('hide');

                    Bus.$emit('updateAddresses')
                }, error => {
                    console.log('some error')
                });
        }
    }
});