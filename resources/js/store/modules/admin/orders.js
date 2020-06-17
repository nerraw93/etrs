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
        orders: {
            data: []
        },
        items: {},
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
        fill(state, {batches})
        {
            state.items = batches;
            state.orders = batches.data;
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
         * Fetch orders
         *
         * @param  {Function} commit                        the commit method to use
         * @param  {Object} [payload={}]                    the payload
         * @return {Promise}
         * @author {goper}
         */
        fetch({commit}, {payload})
        {
            return new Promise((resolve, reject) => {
                let url = '/api/admin/batch'

                if (payload.page) {
                    url += `?page=${payload.page}`
                }
                if (payload.count) {
                    url += `&count=${payload.count}`
                }
                if (payload.status) {
                    url += `&status=${payload.status}`
                }
                if (payload.search) {
                    url += `&search=${payload.search}`
                }

                http.getJSON(url)
                    .then(({data}) => {
                        //let {orders} = data;
                        commit('fill', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        /*
        search({commit}, {payload})
        {
            return new Promise((resolve, reject) => {
                let url = `/api/admin/batch/${payload.key}`
                if (payload.page) {
                    url += `?page=${payload.page}`
                }

                http.getJSON(url)
                    .then(({data}) => {
                        let {orders} = data;
                        commit('fill', orders);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        */

        filterPages({commit}, {payload})
        {
            return new Promise((resolve, reject) => {
                let url = `/api/admin/batch/?pages=${payload.key}`
                if (payload.page) {
                    url += `?page=${payload.page}`
                }

                http.getJSON(url)
                    .then(({data}) => {
                        //let {orders} = data;
                        commit('fill', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        filterStatus({commit}, {payload})
        {
            return new Promise((resolve, reject) => {
                let url = `/api/admin/batch/?status=${payload.key}`
                if (payload.page) {
                    url += `?page=${payload.page}`
                }

                http.getJSON(url)
                    .then(({data}) => {
                        //let {orders} = data;
                        commit('fill', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        setToDone({commit}, {data})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/admin/batch/${data}/done`)
                    .then(({data}) => {
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
                http.getJSON(`/api/client/order/${data.id}/details`, data)
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
                http.postJSON(`/api/client/order/${data.id}/update`, data)
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
                http.postJSON(`/api/client/order/store`, data)
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
                http.postJSON(`/api/client/order/${data}/archive`)
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
            return state.orders;
        },

    }
};
