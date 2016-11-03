Vue.component('kitchen-list', {
    props: ['kitchens'],

    data() {
        return {

        }
    },

    created() {

    },

    computed: {

    },

    methods: {
        getHref(kitchen) {
            return `/kitchens/${kitchen.slug}`;
        }
    }
});