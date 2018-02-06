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
        //this.form.dishes = this.menu.dishes;
        Vue.set(this.form, 'dishes', this.menu.dishes);
        this.setupMenuDishes();
    },

    computed: {
        dishesAvailableToAdd() {
            // Get the ids of the dishes currently in the menu
            var currentDishesId = _.map(this.form.dishes, 'id');

            return _.reject(this.dishes, dish => {
                return _.includes(currentDishesId, dish.id);
            })
        }
    },

    methods: {
        /**
         * Setup expires at attribute
         */
        setupMenuDishes() {
            var self = this;
            _.forEach(this.form.dishes, function (dish, key) {
                self.form.dishes[key] = Object.assign({}, self.form.dishes[key], {
                    start_date: Vue.prototype.filters.dishDate(dish.pivot.start_date),
                    end_date: Vue.prototype.filters.dishDate(dish.pivot.end_date),
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
            //var first_date = $("#dates option:first").val();

            this.dishToAdd = Object.assign({}, this.dishToAdd, {
                start_date: '',
                end_date: '',
                starting_quantity: '',
                quantity_remaining: ''
            });

            this.form.dishes.push(this.dishToAdd);

            Vue.set(this, 'dishToAdd','');

            $("#addDishModal").modal('hide');
        },

        removeDish(dish) {
            var index = this.form.dishes.indexOf(dish);
            this.form.dishes.splice(index, 1)
        },

        update() {
            Ifc.put(`/chef/menus/${this.menu.id}`, this.form)
                .then(response => {
                    //this.menu = response.menu;
                    this.form.dishes = response.dishes;
                    Vue.set(this.form, 'dishes', response.dishes);
                    this.setupMenuDishes();
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