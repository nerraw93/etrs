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
        clientSources: [],
        items: [],
        clientId: 0,
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
            state.clientSources = payload.data;
        },

        saveClientId(state, payload)
        {
            state.clientId = payload;
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
         * Fetch ip_whitelist
         *
         * @param  {Function} commit                        the commit method to use
         * @param  {Object} [payload={}]                    the payload
         * @return {Promise}
         * @author {goper}
         */
        fetch({commit}, {id, path = ''})
        {
            return new Promise((resolve, reject) => {

                if (path == '') {
                    path = `/api/admin/client/${id}/sources`, {id: id};
                }

                http.getJSON(path)
                    .then(({data}) => {
                        commit('fill', data.sources);
                        commit('saveClientId', id);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        /**
         * Update client source price
         *
         * @param  {[type]} commit
         * @param  {Object} [payload={}]
         * @return {[type]}
         *
        update({commit, state, dispatch}, {source})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/admin/client/${state.clientId}/sources/${source.id}/update`, source)
                    .then(({data}) => {


                        dispatch('fetch', {id: state.clientId});
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        /**
         * Store
         * @param  {[type]} commit
         * @param  {[type]} data
         * @return {[type]}
         */
        store({commit, dispatch, state}, {source, price})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/admin/client/${state.clientId}/sources/store`, {
                    user_id: state.clientId,
                    source_id: source.id
                })
                    .then(({data}) => {
                        dispatch('fetch', {id: state.clientId});
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        /**
         * [archive description]
         * @param  {[type]} commit  [description]
         * @param  {[type]} source [description]
         * @return {[type]}         [description]
         */
        archive({commit, state, dispatch}, {source})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/admin/client/${state.clientId}/sources/${source.id}/destroy`)
                    .then(({data}) => {
                        dispatch('fetch', {id: state.clientId});
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
         * Dispatcher getter
         *
         * @param  {State} state                            the state to use
         * @return {Array}
         * @author {goper}
         */
        items(state)
        {
            return state.items;
        },

        /**
         *Get client sources
         * @param  {object} state
         * @return {array}
         */
        sources(state)
        {
            return state.clientSources;
        },

    }
};
