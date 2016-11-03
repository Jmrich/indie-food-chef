Vue.component('menu-edit', {
    props: ['user', 'chef', 'menu', 'sections', 'dishes', 'dates'],

    data() {
        return {
            dishToAdd: '',
            form: new IfcForm({
                menu: {
                    name: '',
                    description: '',
                    is_active: '',
                    is_archived: ''
                },

                sections: [],

                dishes: []
            })
        }
    },

    created() {

    },

    mounted() {
        //this.form.sections = this.sections;
        this.form.dishes = this.menu.dishes;
        //this.setupDishes();
    },

    computed: {

    },

    methods: {
        /**
         * Setup expires at attribute
         */
        setupDishes() {
            var self = this;
            _.forEach(this.form.dishes, function (dish, key) {
                Vue.set(self.dishes, key, {
                    expires_at: dish.pivot.expires_at,
                    starting_quantity: dish.pivot.starting_quantity,
                    quantity_remaining: dish.pivot.quantity_remaining
                });
            });
        },

        /**
         * Remove section
         */
        removeSection(section) {
            var index = this.form.sections.indexOf(section);
            this.form.sections.splice(index, 1)
        },

        /**
         * Add a new section to the menu
         */
        addDishToMenu() {
            var first_date = $("#dates option:first").val();

            this.dishToAdd = Object.assign({}, this.dishToAdd, {
                pivot: {
                    expires_at: first_date,
                    quantity: ''
                },
                start_date: first_date,
                end_date: first_date,
                starting_quantity: '',
                quantity_remaining: ''
            });

            this.form.dishes.push(this.dishToAdd);

            this.dishToAdd = '';

            $("#addDishModal").modal('hide');
        },

        removeDish(dish) {
            var index = this.form.dishes.indexOf(dish);
            this.form.dishes.splice(index, 1)
        },

        update() {
            Ifc.put(`/chef/menus/${this.menu.id}`, this.form)
                .then(response => {
                    this.menu = response.menu;
                    this.form.dishes = response.dishes;
                });
        },

        dishFilter(dish) {
            // check if the id of the dish in the collection matches
            // the id of the current dish

            return ! _.some(this.form.dishes, ['id', dish.id]);
        },

        areDatesEqual(date, exp_date) {
            return date == exp_date;
        }
    }
});