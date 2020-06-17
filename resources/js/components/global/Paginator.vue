<template>
    <div class="pagination-controls mt-2" v-show="data.data ? data.data.length > 0 : false">
        <b-button
            type="is-danger"
            :disabled="disablePrev"
            @click="previous">
            Previous
        </b-button>
        <b-button
            type="is-danger"
            :disabled="disableNext"
            @click="next">
            Next
        </b-button>
    </div>
</template>
<script>


export default {

    /**
     * Properties
     *
     * @type {Object}
     */
    props: {
        data: {
            required: true,
            default: () => { data: [] }
        },
        fetchBySearch: {
            required: false,
            default: false,
            type: Boolean
        },
        returnpageonly: {
            required: false,
            default: false
        },
        page: {
            type: Number,
            required: false
        }
    },

    /**
     * Data
     * @return {object}
     */
    data() {
        return {
            currentPage: this.page ? this.page : 1,
            currentSearchPage: 1
        }
    },

    /**
     * Computed
     * @type {Object}
     */
    computed: {

        path() {
            return this.data.path;
        },

        getCurrentSearchPage() {
            if (!this.fetchBySearch) {
                this.currentSearchPage = 1;
            }

            return this.currentSearchPage;
        },

        disablePrev() {
            if (this.fetchBySearch) {
                return this.currentSearchPage === 1;
            }

            return this.currentPage === 1 || this.page === 1;
        },

        disableNext() {
            if (this.fetchBySearch) {
                return this.currentSearchPage === this.data.last_page;
            }

            return this.currentPage === this.data.last_page || this.page === this.data.last_page;
        }
    },

    /**
     * Methods
     * @type {Object}
     */
    methods: {

        /**
         * Previous page
         * @return {void}
         */
        previous()
        {
            let previousPage
            if (this.fetchBySearch) {
                previousPage = this.getCurrentSearchPage - 1;
                this.currentSearchPage = previousPage;
            } else {
                if (this.page) {
                    previousPage = this.page - 1;
                } else {
                    previousPage = this.currentPage - 1;
                }
                
                this.currentPage = previousPage;
            }
            
            let path = this.path + '?page=' + previousPage;

            if (this.returnpageonly)
                path = previousPage

            this.$emit('previous', path);
        },

        /**
         * Next page
         * @return {void}
         */
        next()
        {
            let nextPage;
            if (this.fetchBySearch) {
                nextPage = this.getCurrentSearchPage + 1;
                this.currentSearchPage = nextPage;
            } else {
                if (this.page) {
                    nextPage = this.page + 1;
                } else {
                    nextPage = this.currentPage + 1;
                }
                this.currentPage = nextPage;
            }
            
            let path = this.path + '?page=' + nextPage;

            if (this.returnpageonly)
                path = nextPage
                
            this.$emit('next', path);
        },
    }
}
</script>
