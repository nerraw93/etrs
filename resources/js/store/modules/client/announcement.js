import Vue from 'vue';
import { get, filter } from 'lodash';

/**
 * Client announcement store
 *
 * @author {goper}
 */
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
        allItems: [],
        limitItems: 3,
        allAnnouncements: [],
        full: {},
        unRead: [],
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
        fill(state, announcements)
        {
            state.allItems = announcements;
            state.items = [];

            // Filter notifications to show only 3
            for (let announcement of announcements) {
                if (state.limitItems > state.items.length) {
                    state.items.push(announcement);
                }
            }
        },

        /**
         * Fill all announcements
         * @param  {[type]} state         [description]
         * @param  {[type]} announcements [description]
         * @return {[type]}               [description]
         */
        fillAllNotifications(state, {notifications, data})
        {
            state.allAnnouncements = notifications;
            state.full = data;
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
        fetchUnread({ commit })
        {
            return new Promise(( resolve, reject ) => {

                http.getJSON(`/api/user/announcement/unread`)
                    .then(({data}) => {
                        let {notifications} = data;
                        commit('fill', notifications);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },

        /**
         * Fetch all announcements
         *
         * @param  {Object} commit
         * @return {Promise}
         * @author {goper}
         */
        fetchAll({commit})
        {
            return new Promise(( resolve, reject ) => {

                http.getJSON(`/api/user/announcement/all`, {page: 'all'})
                    .then(({data}) => {
                        let {notifications} = data;
                        commit('fillAllNotifications', {notifications, data});
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
        updateMarkAsRead({commit, dispatch}, id = 0)
        {
            if (id == 0)
                id = 'all'; // Update all if id is not set

            return new Promise((resolve, reject) => {
                http.postJSON(`/api/user/announcement/update/read`, {id})
                    .then(({data}) => {
                        dispatch('fetchAll');
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
         * Announcement getters
         *
         * @param  {State} state the state to use
         * @return {Array}
         * @author {goper}
         */
        items(state)
        {
            return state.items;
        },

        /**
         * Get all announcements
         * @param  {[type]} state
         * @return {array}
         */
        allItems(state)
        {
            return state.allItems;
        },

        /**
         * Get unread announcements count
         * @param  {[type]} state [description]
         * @return {integer}       [description]
         */
        unReadCount(state)
        {
            return filter(state.allAnnouncements, function(item) { if (item.read_at === null || item.read_at == '') return item }).length;
        },

        /**
         * Get all announcements
         * @param  {[type]} state
         * @return {[type]}
         */
        allAnnouncements(state)
        {
            return state.allAnnouncements;
        },

        /**
         * Get all announcements
         * @param  {[type]} state
         * @return {[type]}
         */
        full(state)
        {
            return state.full;
        },
    }
};
