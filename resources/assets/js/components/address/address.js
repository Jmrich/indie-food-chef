Vue.component('address', {
    props: ['user', 'customer', 'addresses'],

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

    }
});