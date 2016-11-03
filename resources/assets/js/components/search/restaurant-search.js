Vue.component('restaurant-search', {

    props: [],

    data() {
        return {
            address: ''
        }
    },
    
    mounted() {
    },

    events: {

    },
    
    computed: {
        
    },
    
    methods: {
        restaurantSearch() {

            this.address = $('#address').val();

            window.location = this.buildQueryString(this.address)
        },

        buildQueryString(address) {
            return window.URI('/search').search({address: address}).toString()
        },
    }
});