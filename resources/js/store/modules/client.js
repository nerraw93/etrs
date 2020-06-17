import Vue from 'vue'
import VueCookies from 'vue-cookies'
import axios from 'axios'

Vue.use(VueCookies)

axios.interceptors.request.use((config) => {
    config.headers['Authorization'] = `Bearer ${VueCookies.get('access_token')}`
    config.headers['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content
    return config
}, (error) => {
    return Promise.reject(error)
})

const state = {
    clients: [],
    lastPage: 1,
    selectedClient: {},
}

const getters = {
    getClients: state => {
        return state.clients
    },
    getLastPage: state => {
        return state.lastPage
    },
    selectedClient(state) {
        return state.selectedClient
    }
}

const mutations = {
    setClients: (state, clients) => {
        state.clients = clients
    },
    setLastPage: (state, lastPage) => {
        state.lastPage = lastPage
    },
    setSelectedClient(state, client) {
        state.selectedClient = client
    },
}

const actions = {
    async addClient({}, payload) {
        try {
            const { data } = await axios.post('/api/admin/client/store', payload)
            return data
        } catch (e) {
            const { data } = e.response
            throw data
        }
    },

    async updateClient({}, payload) {
        try {
            const { data } = await axios.post(`/api/admin/client/${payload.id}/update`, payload)
            return data
        } catch (e) {
            const { data } = e.response
            throw data
        }
    },

    async fetchClients({ commit }, payload) {
        let url = '/api/admin/client'

        if (payload.page) {
            url += `?page=${payload.page}`
        }

        try {
            const { data } = await axios.get(url)
            commit('setClients', data.clients.data)
            commit('setLastPage', data.clients.last_page)
        } catch (e) {
            const { data } = e.response
            throw data
        }
    },

    async searchClients({ commit }, payload) {
        let url = `/api/admin/client/search/${payload.key}`

        if (payload.page) {
            url += `?page=${payload.page}`
        }

        try {
            const { data } = await axios.get(url)
            commit('setClients', data.clients.data)
            commit('setLastPage', data.clients.last_page)
            return data
        } catch (e) {
            const { data } = e.response
            throw data
        }
    },

    async archiveClient({}, payload) {
        try {
            await axios.post(`/api/admin/client/${payload.id}/destroy`)
        } catch (e) {
            const { data } = e.response
            throw data
        }
    },

    async fetchClient({commit}, payload) {
        try {
            const { data } = await axios.get(`/api/admin/client/details/${payload.code}`)
                commit('setSelectedClient', data.client)
                return data.client
        } catch (e) {
            const { data } = e.response
            throw data
        }
    },

    async updatePayment({ commit }, payload) {
        const url = `/api/admin/client/payment_mode/${payload.code}/update`
        const params = {
            id: payload.id,
            payment_mode: payload.payment_mode
        }

        try {
            const { data } = await axios.post(url, params)
            commit('setSelectedClient', data.client)
            return data.client
        } catch (e) {
            const { data } = e.response
            throw data
        }
    },

    async updateDispatchMode({ commit }, payload) {
        const url = `/api/admin/client/dispatcher/${payload.code}/update`
        const params = {
            id: payload.id,
            dispatcher_id: payload.dispatcher_id
        }

        return axios.post(url, params)
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
