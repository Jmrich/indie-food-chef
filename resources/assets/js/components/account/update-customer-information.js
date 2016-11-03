Vue.component('update-customer-information', {
    props: ['user', 'customer'],

    data() {
        return {
            form: new IfcForm({
                name: '',
                email: ''
            })
        }
    },

    created() {

    },

    mounted() {
        this.form.name = this.user.name;
        this.form.email = this.user.email;
    },

    computed: {
    },

    methods: {
        update() {
            Ifc.put('/account/profile', this.form)
                .then(() => {
                    Bus.$emit('updateUser');
                })
        }
    }
});