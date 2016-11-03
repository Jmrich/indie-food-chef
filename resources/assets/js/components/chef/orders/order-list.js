Vue.component('order-list', {
    props: ['user', 'chef', 'orders'],

    data() {
        return {
            form: new IfcForm({

            })
        }
    },

    created() {

    },

    computed: {

    },

    methods: {
        complete(order) {
            return order.is_complete == 1;
        },

        pending(order) {
            return order.is_complete == 0;
        }
    }
});