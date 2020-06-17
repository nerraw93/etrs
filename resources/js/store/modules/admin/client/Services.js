import Vue from 'vue';
import { get, omit, merge, isUndefined, pick } from 'lodash';

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
        clientServices: [],
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
            state.clientServices = payload.data;
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
        fetch({commit}, {id, sourceId, path = ''})
        {
            return new Promise((resolve, reject) => {

                if (path == '') {
                    path = `/api/admin/client/${id}/${sourceId}/services`, {id: id};
                }

                http.getJSON(path)
                    .then(({data}) => {
                        commit('fill', data.services);
                        commit('saveClientId', id);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        /**
         * Update client service price
         *
         * @param  {[type]} commit
         * @param  {Object} [payload={}]
         * @return {[type]}
         */
        update({commit, state, dispatch}, {service})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/admin/client/${state.clientId}/${service.source_id}/services/${service.id}/update`, service)
                    .then(({data}) => {


                        dispatch('fetch', {id: state.clientId, sourceId: service.source_id});
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
        store({commit, dispatch, state}, {services, sourceId})
        {
            // Get service_id and price!
            let servicesData = [];
            for (let service of services) {
                servicesData.push(pick(service, ['id', 'price']));
            }

            return new Promise((resolve, reject) => {
                http.postJSON(`/api/admin/client/${state.clientId}/${sourceId}/services/store`, {
                    user_id: state.clientId,
                    services: servicesData,
                    source_id: sourceId,
                })
                    .then(({data}) => {
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
         * @param  {[type]} service [description]
         * @return {[type]}         [description]
         */
        archive({commit, state, dispatch}, {service})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/admin/client/${state.clientId}/${service.source_id}/services/${service.id}/destroy`)
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
         *Get client services
         * @param  {object} state
         * @return {array}
         */
        services(state)
        {
            return state.clientServices;
        },

    }
};
