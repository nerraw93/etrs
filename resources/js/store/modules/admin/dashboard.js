import Vue from 'vue'
import VueCookies from 'vue-cookies'
import axios from 'axios'
import { merge } from 'lodash'

Vue.use(VueCookies)

axios.interceptors.request.use((config) => {
    config.headers['Authorization'] = `Bearer ${VueCookies.get('access_token')}`
    config.headers['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content
    return config
}, (error) => {
    return Promise.reject(error)
})

const state = {
    announcements: [],
    draftBatch: [],
    totalDraftOrders: 0,
    confirmedBatch: [],
    totalConfirmedOrders: 0,
    announcementsFullData: [],
    confirmBatchCurrentPage: 1,
    draftBatchCurrentPage: 1,
}

const getters = {
    getDraftBatch: state => {
        return state.draftBatch
    },
    getTotalDraftOrders: state => {
        return state.totalDraftOrders
    },
    getConfirmedBatch: state => {
        return state.confirmedBatch
    },
    getTotalConfirmedOrders: state => {
        return state.totalConfirmedOrders
    },
    getAdminAnnouncementList: state => {
        return state.announcementsFullData;
    },
    getAdminAnnouncements: state => {
        return state.announcements;
    },
}

const mutations = {
    setAnnouncement: (state, announcements) => {
        state.announcementsFullData = announcements;
        state.announcements = announcements;

    },

    setDraftBatch: (state, batches) => {
        confirmBatchCurrentPage: 1,
        state.draftBatchCurrentPage = batches.current_page
        const newData = batches.data.map(obj => {
            obj.totalCost = obj.orders.reduce( (acc, orderObj) => {
                const price = orderObj.services.reduce((orderAcc, serviceObj) => {
                    return orderAcc + serviceObj.service.price
                }, 0)
                return acc + price
            }, 0);
            obj.status = 'Draft'
            return obj
        })
        state.totalDraftOrders = batches.total
        state.draftBatch = newData
    },

    setConfirmedBatch: (state, batches) => {
        state.confirmBatchCurrentPage = batches.current_page
        const newData = batches.data.map(obj => {
            obj.totalCost = obj.orders.reduce( (acc, orderObj) => {
                const price = orderObj.services.reduce((orderAcc, serviceObj) => {
                    return orderAcc + serviceObj.service.price
                }, 0)
                return acc + price
            }, 0);
            obj.status = 'Confirmed'
            return obj
        })
        state.totalConfirmedOrders = batches.total
        state.confirmedBatch = newData
    }
}

const actions = {

    async fetchAdminAnnouncements({ commit, rootState }) {
        if (parseInt(rootState.auth.userRole, 10) === 10) {
            let url = `/api/admin/announcement`;
            axios.get(url).then(({ data }) => {
                commit('setAnnouncement', data.announcements)
            })
        }
    },

    async fetchAdminDraftBatch({ commit, rootState }, page = '1') {
        if (parseInt(rootState.auth.userRole, 10) === 10) {
            const url = `/api/admin/dashboard/batches/draft`
            axios.get(url, { params: { page }}).then(({ data }) => {
                commit('setDraftBatch', data.batches)
            })
        }
    },

    async fetchAdminConfirmedBatch({ commit, rootState }, page = '1') {
        if (parseInt(rootState.auth.userRole, 10) === 10) {
            const url = `/api/admin/dashboard/batches/confirmed`
            axios.get(url, { params: { page }}).then(({ data }) => {
                commit('setConfirmedBatch', data.batches)
            })
        }
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
