import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import VueCookies from 'vue-cookies';

import app from './app';

// router
import router from '@/router';

// Modules
import auth from '@/store/modules/auth';

// Admin store modules/data
import processor from '@/store/modules/processor';
import service from '@/store/modules/service';
import dispatcher from './modules/Dispatcher';
import sources from './modules/admin/system/sources';
import patientType from './modules/admin/system/PatientTypes';
import ipWhitelist from './modules/admin/system/IPWhitelist';
import globalPrefix from './modules/admin/system/GlobalPrefix';
import patients from './modules/client/patients';
import details from './modules/client/settings/Details';
import password from './modules/client/settings/Password';
import clinicians from './modules/client/settings/Clinicians';
import staff from './modules/client/staff';
import announcements from './modules/admin/system/Announcements';
import adminDashboard from './modules/admin/dashboard';
import adminBatchOrders from './modules/admin/orders';

// Client store modules/data
import client from '@/store/modules/client';
import clientSources from './modules/admin/client/Sources';
import clientDashboard from './modules/client/dashboard';
import clientOrders from './modules/client/orders';
import clientBatches from './modules/client/batches';
import clientServices from './modules/admin/client/Services';
import clientServicesList from './modules/client/services';


// Staff store modules/data
import staffOrders from './modules/staff/orders';

// User store data
import userAnnouncement from '@store/modules/client/announcement';

Vue.use(Vuex)

/**
* This line of code is used to intercept errors on calling the api
* if the oauth access_token is expired when consuming the api
* it should be handled by axios on the vuex calls (since all API
* calls are done on vuex) thus removing the cookie and logging the
* user out immediately
*/
const errorResponseHandler = (error) => {
    if (error.response.status === 401) {
        VueCookies.remove('access_token')
        VueCookies.remove('refresh_token')
        VueCookies.remove('user_name')
        VueCookies.remove('user_role')
        
        alert('Your session has expired.')
    }

    return Promise.reject(error)
}

axios.interceptors.response.use(
    response => response,
    errorResponseHandler
)

export default new Vuex.Store({
    modules: {
        app,

        auth,
        processor,
        service,
        dispatcher,
        sources,
        patientType,
        patients,
        details,
        password,
        clinicians,
        staff,

        //** Admin stores data
        clientServices,
        ipWhitelist,
        globalPrefix,
        announcements,
        clientSources,
        adminDashboard,
        adminBatchOrders,

        //** Client stores
        client,
        clientOrders,
        clientSources,
        clientDashboard,
        clientBatches,
        clientServicesList,

        //** Staff */
        staffOrders,

        //** User stores
        userAnnouncement,
    }
})
