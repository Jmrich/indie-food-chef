Vue.component('update-password', {
    props: ['user'],

    data() {
        return {
            form: new IfcForm({
                current_password: '',
                password: '',
                password_confirmation: ''
            })
        }
    },

    created() {

    },

    computed: {

    },

    methods: {
        update() {
            Ifc.put('/account/password', this.form)
        }
    }
});