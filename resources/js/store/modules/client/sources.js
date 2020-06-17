import Vue from 'vue';
import { get, omit, merge, isUndefined } from 'lodash';

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
        sources: {},
        items: [],
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
        fill(state, payload)
        {
            state.items = payload;
            state.sources = payload;
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
         * Fetch sources
         *
         * @param  {Function} commit                        the commit method to use
         * @param  {Object} [payload={}]                    the payload
         * @return {Promise}
         * @author {goper}
         */
        fetch({commit}, payload = {})
        {
            return new Promise((resolve, reject) => {
                http.getJSON('/api/client/sources')
                    .then(({data}) => {
                        let {sources} = data;
                        commit('fill', sources);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        /**
         * Update source
         *
         * @param  {[type]} commit
         * @param  {Object} [payload={}]
         * @return {[type]}
         */
        update({commit}, {data})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/admin/system/source/${data.id}/update`, data)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        store({commit}, {data})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/admin/system/source/store`, data)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        delete({commit}, {data})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/admin/system/source/${data}/destroy`)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
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
         * source getter
         *
         * @param  {State} state                            the state to use
         * @return {Array}
         * @author {goper}
         */
        items(state)
        {
            return state.items;
        },

        data(state)
        {
            return state.sources;
        },

    }
};
