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
        announcements: {},
        data: {},
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
            state.items = payload.data;
            state.sources = payload;
        },

        setAnnouncement(state, {announcements, data})
        {
            state.announcements = announcements;
            state.data = data;
        }
    },

    /**
     * Actions
     *
     * @type {Object}
     * @author {goper}
     */
    actions: {

        /**
         * Fetch admin announcements
         *
         * @param  {Function} commit                        the commit method to use
         * @param  {Object} [payload={}]                    the payload
         * @return {Promise}
         * @author {goper}
         */
        fetch({ commit, rootState }, { page = 1, count = 5 })
        {
            if (parseInt(rootState.auth.userRole, 10) === 10) {
                return new Promise(( resolve, reject ) => {
                    http.getJSON(`/api/admin/announcement?page=${page}&count=${count}`)
                        .then(({data}) => {
                            let {announcements} = data;
                            commit('setAnnouncement', { announcements, data });
                        })
                        .catch(error => {
                            reject(error);
                        });
                });
            }
        },

        /**
         * Update announcement
         *
         * @param  {[type]} commit
         * @param  {Object} [payload={}]
         * @return {[type]}
         */
        update({commit}, data)
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/admin/announcement/${data.id}/update`, data)
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
                http.postJSON(`/api/admin/announcement/store`, data)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        /**
         * Delete announcement - admin
         * @param  {[type]} commit [description]
         * @param  {[type]} id     batch_id
         * @return {[type]}        [description]
         */
        delete({commit}, id)
        {
            return new Promise((resolve, reject) => {
                http.postJSON(`/api/admin/announcement/${id}/destroy`)
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

        getAnnouncements(state)
        {
          return state.announcements
        }

    }
};
