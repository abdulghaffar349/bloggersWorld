export default {
    components: {
        Pagination: () => import('laravel-vue-pagination')
    },
    data() {
        return {
            posts: [],
            isLoading: false,
            paginationData: null,
            searchQuery: ''
        }
    },
    computed: {
        _searchQuery() {
            return this.searchQuery
        }
    },
    watch: {
        _searchQuery(newVal, oldVal) {
            this.getPosts()
        }
    },
    created() {
        this.isLoading = true;
        this.getPosts();
    },

    methods: {
        async getPosts(page) {
            this.isLoading = true
            if (typeof page === 'undefined') {
                page = 1;
            }
            const response = await axios.get(this.getUrl(page))
            this.posts = response.data.data
            delete response.data['data'];
            this.paginationData = response.data
            this.isLoading = false
        },
    }
}
