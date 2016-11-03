/**
 * Ifc root
 */
module.exports = {
    /**
     * The application's data.
     */
    data: {
        user: Ifc.user,
        customer: Ifc.customer,
        chef: Ifc.chef
    },


    /**
     * The component has been created by Vue.
     */
    created() {
        var self = this;

        Bus.$on('updateUser', () => {
            self.getUser();

            self.user.userable_type == 'customer' ? self.updateCustomer() : self.updateChef();
        })
    },


    /**
     * Prepare the application.
     */
    mounted() {
    },

    computed: {
        dayOfWeek() {
            var d = new Date();

            return d.getDay();
        }
    },


    events: {
        /*
         * Update the current user of the application.
         */
        updateUser() {
            this.getUser();

            this.user.userable_type == 'customer' ? this.updateCustomer() : this.updateChef();
        },
    },


    methods: {
        /*
         * Get the current user of the application.
         */
        getUser() {
            this.$http.get('/user/current')
                .then(response => {
                    this.user = response.data;
                });
        },

        updateCustomer() {
            this.$http.get('/customer/current')
                .then(response => {
                    this.customer = response.data;
                });
        },

        updateChef() {
            this.$http.get('/chef/current')
                .then(response => {
                    this.chef = response.data;
                });
        }
    },
};
