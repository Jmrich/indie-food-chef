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
        completedOrders() {
            return this.orders.filter((order) => {
                return order.is_complete == 1;
            })
        },

        pendingOrders() {
            return this.orders.filter((order) => {
                return order.is_complete == 0;
            })
        }
    },

    methods: {
        orderUrl(order) {
            return `/chef/orders/${order.id}`
        },
        complete(order) {
            return order.is_complete == 1;
        },

        pending(order) {
            return order.is_complete == 0;
        }
    }
});