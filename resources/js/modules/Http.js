import qs from 'qs';
import Vue from 'vue';
import axios from 'axios';
import merge from 'lodash/merge';
import VueCookies from 'vue-cookies';

Vue.use(VueCookies);

export default class Http
{
    constructor(crsf = null, baseURL = '')
    {

        // Make sure that crsf is supplied
        if (crsf == null) {
            crsf = document.head.querySelector('meta[name="csrf-token"]').content;
        }
        this.crsf = crsf;
        this.headers = {};

        this.driver = axios.create({
            baseURL,
            headers: {
                'X-CSRF-TOKEN': this.crsf,
                'Authorization': `Bearer ${VueCookies.get('access_token')}`
            }
        });
    }

    /**
     * Add default headers
     *
     * @param  {Object} [headers={}]                        the headers to load
     * @return {Http}
     * @author {goper}
     */
    withHeaders(headers = {})
    {
        for (var key in headers) {
            this.driver.defaults.headers[key] = headers[key];
        }
        return this;
    }

    /**
     * Post
     *
     * @param   {String} url                                the url where to post in
     * @param   {Object} data                               the data to post
     * @param   {Object} [config={}]                        the custom settings for the post request
     * @return  {Promise}
     * @author  {goper}
     */
    post(url, data = {}, config = {})
    {
        this.interceptor();
        return new Promise((resolve, reject) => {
            axios.post(url, qs.stringify(data), config)
                .then(xhr => resolve(xhr))
                .catch(error => reject(error.response));
        });
    }

    /**
     * Post with JSON response
     *
     * @param   {String} url                                the url where to post in
     * @param   {Object} data                               the data to post
     * @param   {Object} [config={}]                        the custom settings for the post request
     * @return  {Promise}
     * @author  {goper}
     */
    postJSON(url, data = {}, config = {})
    {
        return this.post(url, data, merge(config, {responseType: 'json'}));
    }

    /**
     * Get
     *
     * @param   {String} url                                the url where to request
     * @param   {Object} data                               the data to attach to the request
     * @param   {Object} [config={}]                        the custom settings for the post request
     * @return  {Promise}
     * @author  {goper}
     */
    get(url, data = {}, config = {})
    {
        this.interceptor();
        return new Promise((resolve, reject) => {
            axios.get(url, merge(config, {params: data}))
                .then(xhr => resolve(xhr))
                .catch(error => reject(error.response));
        });
    }

    /**
     * Get with JSON response
     *
     * @param   {String} url                                the url where to request
     * @param   {Object} data                               the data to attach to the request
     * @param   {Object} [config={}]                        the custom settings for the post request
     * @return  {Promise}
     * @author  {goper}
     */
    getJSON(url, data = {}, config = {})
    {
        return this.get(url, data, merge(config, {responseType: 'json'}));
    }

    /**
     * Axios interceptor - update headers - fix for 401 error without `refresh`
     * @return {void}
     */
    interceptor()
    {
        axios.interceptors.request.use((config) => {
            config.headers['Authorization'] = `Bearer ${VueCookies.get('access_token')}`
            config.headers['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content

            return config
        }, (error) => {

            return Promise.reject(error)
        });
    }
}
