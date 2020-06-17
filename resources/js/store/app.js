import Vue from 'vue';

export default {

    /**
     * Namespace module
     *
     * @type {Boolean}
     * @author {goper}
     */
    namespaced: true,

    /**
     * State
     *
     * @type {Object}
     * @author {goper}
     */
    state: {
        isLoading: false,
    },

    /**
     * Mutations
     *
     * @type {Object}
     * @author {goper}
     */
    mutations: {

        /**
         * Fill items
         *
         * @param  {State} state                                the state to use
         * @param  {Object} payload                             the payload
         * @return {void}
         * @author {goper}
         */
        setLoading(state, payload)
        {
            state.isLoading = payload;
        },

    },

    /**
     * Actions
     *
     * @type {Object}
     * @author {goper}
     */
    actions: {

        /**
         * Fetch dispatchers
         *
         * @param  {Function} commit                        the commit method to use
         * @param  {Object} [payload={}]                    the payload
         * @return {Promise}
         * @author {goper}
         */
        toggleLoading({commit}, isLoading)
        {
            commit('setLoading', isLoading);
        },

    },

    /**
     * Getters
     *
     * @type {Object}
     * @author {goper}
     */
    getters: {

        /**
         * Loading status getters
         *
         * @param  {State} state                            the state to use
         * @return {Array}
         * @author {goper}
         */
        isLoading(state)
        {
            return state.isLoading;
        },

    }
};
