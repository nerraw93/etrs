import VueRouter from 'vue-router'
import store from '@/store'

//** Guest pages
import Login from '@/pages/auth/Login'
import NewPassword from '@/pages/auth/NewPassword'
import ResetPassword from '@/pages/auth/ResetPassword'

//** Admin pages
import Orders from '@/pages/admin/Orders'
import Services from '@/pages/admin/services/Index'
import ServiceDetails from '@/pages/admin/services/Details'

//** Client pages
import StaffDetails from '@/pages/staff/Details'
import ClientOrders from '@/pages/client-batch-orders/Index'
import Staff from '@/pages/staff/Index'
import StaffOrders from '@/pages/client-batch-orders/Index'

import Dashboard from '@/pages/Dashboard'
import Clients from '@/pages/clients/Index'
import ClientDetails from '@/pages/clients/Details'
import Processors from '@/pages/Processors'
import System from '@/pages/System'
import Settings from '@/pages/Settings'
import Patients from '@/pages/patients/Index'
import PatientDetails from '@/pages/patients/Details'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'dashboard',
            component: Dashboard,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/clients',
            name: 'clients',
            component: Clients,
            meta: {
                requiresAuth: true,
                forAdmin: true
            }
        },
        {
            path: '/clients/:code',
            name: 'client_details',
            component: ClientDetails,
            meta: {
                requiresAuth: true,
                forAdmin: true
            }
        },
        {
            path: '/services',
            name: 'services',
            component: Services,
            meta: {
                requiresAuth: true,
                forAdmin: true
            }
        },
        {
            path: '/services/:code',
            name: 'service_details',
            component: ServiceDetails,
            meta: {
                requiresAuth: true,
                forAdmin: true
            }
        },
        {
            path: '/processors',
            name: 'processors',
            component: Processors,
            meta: {
                requiresAuth: true,
                forAdmin: true
            }
        },
        {
            path: '/system-configurations',
            name: 'system',
            component: System,
            meta: {
                requiresAuth: true,
                forAdmin: true
            }
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                guest: true
            }
        },
        {
            path: '/orders',
            name: 'orders',
            component: Orders,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/new-password/:token',
            name: 'resetPass',
            component: NewPassword,
            meta: {
                guest: true
            }
        },
        {
            path: '/settings',
            name: 'settings',
            component: Settings,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/patients',
            name: 'patients',
            component: Patients,
            meta: {
                requiresAuth: true,
                forAdmin: false
            },
            props: true
        },
        {
            path: '/patients/:code',
            name: 'patient_details',
            component: PatientDetails,
            meta: {
                requiresAuth: true,
                forAdmin: false
            }
        },
        {
            path: '/staff',
            name: 'staff',
            component: Staff,
            meta: {
                requiresAuth: true,
                forAdmin: false
            }
        },
        {
            path: '/staff/:code',
            name: 'staff_details',
            component: StaffDetails,
            meta: {
                requiresAuth: true,
                forAdmin: false
            }
        },
        {
            path: '/client-orders',
            name: 'client-orders',
            component: ClientOrders,
            meta: {
                requiresAuth: true
            },
            props: true
        },
        {
            path: '/staff-orders',
            name: 'staff-orders',
            component: StaffOrders,
            meta: {
                requiresAuth: true
            }
        },
    ]
})

router.beforeEach((to, from, next) => {
    let authToken = store.getters['auth/getAccessToken']
    let userRole = store.getters['auth/getUserRole']

    if (to.meta.requiresAuth) {
        if (authToken == null || userRole == null) {
            next({ path: '/login' })
        } else if (to.meta.forAdmin) {

            if (userRole == 10) {
                next()
            } else {
                next({ path: '/' })
            }
        } else {
            next()
        }
    } else if (to.meta.guest) {

        if (!authToken || !userRole) {
            next()
        } else {
            next({ path: '/' })
        }
    }
})

export default router
