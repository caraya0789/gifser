try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.Vue = require('vue');



const searchApp = new Vue({
    el: '#search',
    data: {
    	results: [],
    	query:'',
    	searching: false,
    	formError: false,
        more: true,
        loading: false,
        page: 1
    },
    methods: {
    	search: function(e) {
            e.preventDefault();
    		if(this.query == '') {
    			this.formError = true;
    			return;
    		}

    		this.formError = false;
    		this.searching = true;
            this.page = 1;
            this.more = true;

    		let q = encodeURIComponent( this.query );
    		
    		axios.get(`/api/search?q=${q}`).then(res => {
				this.results = res.data;
			}).finally(() => {
				this.searching = false;
			});
    	},
        loadmore: function(e) {
            e.preventDefault();

            this.loading = true;
            this.page++;

            let q = encodeURIComponent( this.query );
            
            axios.get(`/api/search?q=${q}&p=${this.page}`).then(res => {
                if(!res.data.length) {
                    this.more = false;
                } else {
                    this.results = [
                        ...this.results,
                        ...res.data
                    ]
                }
            }).finally(() => {
                this.loading = false;
            })
        },
        add_favorite: function(i) {
            axios.get(`/api/favorite?id=${this.results[i].id}`);
            this.results[i].favorite = !this.results[i].favorite;
            return false;
        }
    }
});

