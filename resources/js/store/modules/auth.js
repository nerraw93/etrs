import Vue from 'vue'
import VueCookies from 'vue-cookies'
import axios from 'axios'
import { CLIENT_ID, CLIENT_SECRET, GRANT_TYPE } from '../../utils/constants'

Vue.use(VueCookies)

const state = {
    accessToken: VueCookies.get('access_token'),
    refreshToken: VueCookies.get('refresh_token'),
    userName: VueCookies.get('user_name'),
    userRole: VueCookies.get('user_role'),
    me: {},
}

const getters = {
    getAccessToken: state => state.accessToken,
    getRefreshToken: state => state.refreshToken,
    getUserName: state => state.userName,
    getUserRole: state => state.userRole,
    isAdmin: state => parseInt(state.userRole, 10) === 10,
    me(state)
    {
        return state.me;
    }
}

const mutations = {
    setAccessToken: (state, accessToken) => {
        state.accessToken = accessToken
    },
    setRefreshToken: (state, refreshToken) => {
        state.refreshToken = refreshToken
    },
    setUserName: (state, userName) => {
        state.userName = userName
    },
    setUserRole: (state, userRole) => {
        state.userRole = userRole
    },
    setMe(state, user)
    {
        state.me = user
    }
}

const actions = {
    async login({ commit }, payload) {
        try {
            /**
            * Set client id, grant type and client secret
            * as part of the login payload
            */
            payload.grant_type = GRANT_TYPE
            payload.client_id = CLIENT_ID
            payload.client_secret = CLIENT_SECRET

            const { data } = await axios.post('/api/auth/login', payload)

            /**
            * Set cookies
            */
            VueCookies.set('access_token', data.access_token)
            VueCookies.set('refresh_token', data.refresh_token)
            VueCookies.set('user_name', data.logged_in_user.username)
            VueCookies.set('user_role', data.logged_in_user.role)
            VueCookies.set('user_id', data.logged_in_user.id)
            VueCookies.set('auth_user', data.logged_in_user)

            /**
            * Call mutations so it can be used by the app
            */
            commit('setAccessToken', data.access_token);
            commit('setRefreshToken', data.refresh_token);
            commit('setUserName', data.logged_in_user.username);
            commit('setUserRole', data.logged_in_user.role);


        } catch (e) {
            const { data } = e.response
            throw data
        }
    },

    logout({ state }) {
        VueCookies.remove('access_token')
        VueCookies.remove('refresh_token')
        VueCookies.remove('auth_user')

        state.accessToken = null;
        state.refreshToken = null;
    },

    /**
    * Get user data
    * @param  {[type]} state [description]
    * @return {[type]}       [description]
    */
    me({commit})
    {
        return new Promise((resolve, reject) => {
            http.getJSON(`/api/user/me`)
            .then(({data}) => {
                let {user} = data;
                commit('setMe', user);
                resolve(data);
            })
            .catch(error => {
                reject(error);
            });
        });
    },
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
