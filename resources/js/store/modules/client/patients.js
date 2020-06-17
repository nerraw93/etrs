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
        patients: {},
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
            state.patients = payload;
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
         * Fetch patients
         *
         * @param  {Function} commit                        the commit method to use
         * @param  {Object} [payload={}]                    the payload
         * @return {Promise}
         * @author {goper}
         */
        fetch({commit}, {payload})
        {
            return new Promise((resolve, reject) => {
                let url = '/api/client/patient'
                if (payload.page) {
                    url += `?page=${payload.page}`
                }

                http.getJSON(url)
                    .then(({data}) => {
                        let {patients} = data;
                        commit('fill', patients);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        search({commit}, {payload})
        {
            return new Promise((resolve, reject) => {
                let url = `/api/client/patient/search/${payload.key}`
                if (payload.page) {
                    url += `?page=${payload.page}`
                }

                http.getJSON(url)
                    .then(({data}) => {
                        let {patients} = data;
                        commit('fill', patients);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        details({commit}, {data})
        {
            return new Promise((resolve, reject) => {
                http.getJSON(`/api/client/patient/${data.id}/details`, data)
                    .then(({data}) => {
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
                http.postJSON(`/api/client/patient/${data.id}/update`, data)
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
                http.postJSON(`/api/client/patient/store`, data)
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
                http.postJSON(`/api/client/patient/${data}/archive`)
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
            return state.patients;
        },

    }
};
