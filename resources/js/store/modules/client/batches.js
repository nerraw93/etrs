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
        items: [],
        itemsPaginate: {
            data: []
        },
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
        fill(state, { batches })
        {
            state.itemsPaginate = batches;
            state.items = batches.data;
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
         * Fetch batches
         *
         * @param  {Function} commit                        the commit method to use
         * @param  {Object} [payload={}]                    the payload
         * @return {Promise}
         * @author {goper}
         */
        fetch({commit}, {payload})
        {
            return new Promise((resolve, reject) => {
                let url = `/api/client/batch`;

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

                        commit('fill', data);
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
                http.getJSON(`/api/client/batch/${data.id}/details`, data)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        /**
         * Update batch
         *
         * @param  {[type]} commit
         * @param  {Object} [payload={}]
         * @return {[type]}
         */
        update({commit}, {data})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/client/batch/${data.id}/update`, data)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        updateOrder({commit}, {data})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/client/batch/order/${data.id}/update`, data)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        updateOrderStatus({commit}, {data})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/client/batch/order/${data.id}/update/status`, data)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        /**
         * Store batch
         * @param  {[type]} commit [description]
         * @param  {[type]} data   [description]
         * @return {[type]}        [description]
         */
        store({commit}, {data})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/client/batch/store`, data)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        /**
         * Store batch order
         * @param  {[type]} commit
         * @param  {[type]} data
         * @return {[type]}
         */
        storeOrder({commit}, {data})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/client/batch/order/store`, data)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        // Delete batch
        delete({commit}, {data})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/client/batch/${data}/destroy`)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        // Delete order
        deleteOrder({commit}, {data})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/client/batch/order/${data}/destroy`)
                    .then(({data}) => {
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
                http.postJSON(`/api/client/batch/${data}/done`)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        setToConfirmed({commit}, {data})
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/client/batch/${data}/confirmed`)
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

        paginate(state)
        {
            return state.itemsPaginate;
        },
    }
};
