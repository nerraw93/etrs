import Vue from 'vue'
import VueCookies from 'vue-cookies'
import axios from 'axios'
import { merge } from "lodash"
Vue.use(VueCookies)

axios.interceptors.request.use((config) => {
    config.headers['Authorization'] = `Bearer ${VueCookies.get('access_token')}`
    config.headers['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content
    return config
}, (error) => {
    return Promise.reject(error)
})

const state = {
    services: [],
    lastPage: 1
}

const getters = {
    getServices: state => {
        return state.services
    },
    getLastPage: state => {
        return state.lastPage
    }
}

const mutations = {
    setServices: (state, services) => {
        state.services = services;

    },
    setLastPage: (state, lastPage) => {
        state.lastPage = lastPage
    }
}

const actions = {
    async addService({}, payload) {
        try {
            const { data } = await axios.post('/api/admin/services/store', payload)
            return data
        } catch (e) {
            const { data } = e.response
            throw data
        }
    },

    async fetchServices({ commit }, payload) {
        let url = '/api/admin/services';

        http.getJSON(`/api/admin/services`, payload)
            .then(({data}) => {
                let {services} = data;
                commit('setServices', services.data);
                commit('setLastPage', services.last_page);
            })
            .catch(error => {
                const { data } = error.response
                reject(error);
            });
    },

    async searchServices({ commit }, { page, clientId, key }) {
        let url = `/api/admin/services/search/${key}`
        let additionalParams = {}

        if (page) {
            additionalParams = { page }
        }

        if (clientId != '')
            additionalParams = merge(additionalParams, { clientId })

        try {
            const { data } = await axios.get(url, {
                params: additionalParams
            })
            commit('setServices', data.services.data)
            commit('setLastPage', data.services.last_page)
        } catch (e) {
            const { data } = e.response
            throw data
        }
    },

    async fetchService({}, payload) {
        try {
            const { data } = await axios.get(`/api/admin/services/details/${payload.code}`)
            return data.service
        } catch (e) {
            const { data } = e.response
            throw data
        }
    },

    async updateService({}, payload) {
        const url = `/api/admin/services/${payload.id}/update`
        try {
            const { data } = await axios.post(url, payload)
            return data.message
        } catch (e) {
            const { data } = e.response
            throw data
        }
    },

    async archiveService({}, payload) {
        try {
            await axios.post(`/api/admin/services/${payload.id}/destroy`)
        } catch (e) {
            const { data } = e.response
            throw data
        }
    },

    async importService({}, formData) {
        try {
            await axios.post('/api/admin/services/import', formData)
        } catch (e) {
            const { data } = e.response
            throw data
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
