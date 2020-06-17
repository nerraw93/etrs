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
        clincians: {},
        items: [],
        list: [],
        all: [],
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
            state.clincians = payload;
            state.list = payload.clinicians.data;
        },

        fillAll(state, {clinicians})
        {
            state.all = clinicians;
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
         * Fetch clincianss
         *
         * @param  {Function} commit                        the commit method to use
         * @param  {Object} [payload={}]                    the payload
         * @return {Promise}
         * @author {goper}
         */
        fetch({commit}, payload = {})
        {
            return new Promise((resolve, reject) => {
                http.getJSON('/api/client/settings/clinician')
                    .then(({data}) => {
                        commit('fill', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        /**
         * Fetch all clincianss
         *
         * @param  {Function} commit                        the commit method to use
         * @param  {Object} [payload={}]                    the payload
         * @return {Promise}
         * @author {goper}
         */
        fetchAll({commit}, payload = {})
        {
            return new Promise((resolve, reject) => {
                http.getJSON('/api/client/settings/clinician', { page: 'all' })
                    .then(({data}) => {
                        commit('fillAll', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        /**
         * Update clincians
         *
         * @param  {[type]} commit
         * @param  {Object} [payload={}]
         * @return {[type]}
         */
        update({commit}, {data})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/client/settings/clinician/${data.id}/update`, data)
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
                http.postJSON(`/api/client/settings/clinician/store`, data)
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
                http.postJSON(`/api/client/settings/clinician/${data}/destroy`)
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
         * clincians getter
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
            return state.clincians;
        },

        list(state)
        {
            return state.list;
        },

        all(state)
        {
            return state.all;
        },
    }
};
