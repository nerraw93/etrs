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
    }
}

const mutations = {
    setAnnouncement: (state, announcements) => {
        state.announcements = announcements.data;
    },

    setDraftBatch: (state, batches) => {
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
    async fetchClientAnnouncements({ commit, rootState }, { page = 1, count = 10 }) {
        if (parseInt(rootState.auth.userRole, 10) === 0) {
            const url = `/api/user/announcement/all?page=${page}&count=${count}`
            axios.get(url).then(({ data }) => {
                commit('setAnnouncement', data.notifications)
            })
        }
    },
    async fetchClientDraftBatch({ commit, rootState }, page = '1') {
        const userRole = parseInt(rootState.auth.userRole, 10)
        if (userRole === 0 || userRole === 3) {
            const url = `/api/client/dashboard/batches/draft`
            axios.get(url, { params: { page }}).then(({ data }) => {
                commit('setDraftBatch', data.batches)
            })
        }
    },
    async fetchClientConfirmedBatch({ commit, rootState }, page = '1') {
        const userRole = parseInt(rootState.auth.userRole, 10)
        if (userRole === 0 || userRole === 3) {
            const url = `/api/client/dashboard/batches/confirmed`
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
