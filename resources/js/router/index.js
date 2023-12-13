import { createRouter, createWebHistory } from "vue-router";
// pages
import MainPage from '../pages/MainPage.vue'
import mainTemplate from '../Components/core/mainTemplate.vue'
import notFound from '../Components/notFound.vue'
import Dashboard from '../pages/Dashboard.vue'
import TicketRecord from '../pages/TicketRecord.vue'
//Employee

// IMS
import Inventory from '../Components/Navigation.vue'
import IMSDashboard from '../pages/IMS/admin/DashBoard.vue'
import Users from '../pages/IMS/admin/Users.vue'
import Adduser from '../pages/IMS/admin/AddUser.vue'
import Order from '../pages/IMS/admin/Order.vue'
import ATM from '../pages/IMS/admin/ATM.vue'
import Addnewatm from '../pages/IMS/admin/Addnewatm.vue'
import Viewdetail from '../pages/IMS/admin/Viewdetail.vue'
import Report from '../pages/IMS/admin/Report.vue'
import Updateatm from '../pages/IMS/admin/Updateatm.vue'
import Profile from '../pages/IMS/admin/Profile.vue'
import Sparepart from '../pages/IMS/admin/Sparepart.vue'
import Bank from '../pages/IMS/admin/Bank.vue'
import Banklocation from '../pages/IMS/admin/Banklocation.vue'
import Engineer from '../pages/IMS/admin/Engineer.vue'
import Site from '../pages/IMS/admin/Site.vue'

const routes = [
    {
        path: '/',
        name: 'mainPage',
        component: MainPage,
    },
    {
        path: '/incedent',
        name :'incedent',
        component : mainTemplate,
        redirect : '/incedent/dashboard',
        children: [
            {
                path: 'dashboard',
                name: 'Dashboard',
                component: Dashboard,
                meta: {
                    breadcrumb: [
                        { name: 'Dashboard' }
                      ]
                }
            },
            {
                path: 'ticket_record',
                name: 'ticketRecord',
                component: TicketRecord,
            }
        ]
    },
    // IMS
    {
        path: '/inventory-sys',
        name: 'inventory',
        component: Inventory,
        redirect: '/inventory-sys/dashboard',
        children: [
            {
                path : 'dashboard',
                name : 'dashboard',
                component : IMSDashboard,
                props: true
            },
            {
                path : 'users',
                name : 'users_page',
                component : Users,
                props: true
            },
            {
                path : 'adduser',
                name : 'adduser_page',
                component : Adduser,
                props: true
            },
            {
                path : 'order',
                name : 'order_page',
                component : Order
            },
            {
                path : 'atm',
                name : 'atm_page',
                component : ATM
            },
            {
                path : 'addnewatm',
                name : 'addnewatm_page',
                component : Addnewatm
            },
            {
                path : 'viewdetail/:id',
                name : 'viewdetail_page',
                component : Viewdetail
            },
            {
                path : 'report',
                name : 'report_page',
                component : Report
            },
            {
                path : 'update/:id',
                name : 'update_page',
                component : Updateatm
            },
            {
                path : 'profile',
                name : 'profile_page',
                component : Profile
              },
              {
                path : 'spare_part',
                name : 'spare_part_page',
                component : Sparepart
              },
              {
                path:'bank',
                name:'bank_page',
                component: Bank
              },
              {
                path: 'Banklocation',
                name: 'banklocation_page',
                component: Banklocation
              },
              {
                path: 'Engineer',
                nam: 'engineer_page',
                component: Engineer
              },
              {
                path:'Site',
                name: 'Site_page',
                component: Site
              }

        ]
    },
    //notFound
    {
        path: '/:pathMatch(.*)*',
        component: notFound,
        // meta: {
        //     allowAnonymous: true,
        //     requiresAuth: false
        // }
    }
]
const router = createRouter({
    history: createWebHistory(),
    routes,
})

// router.beforeEach((to, from) => {
//     if (to.meta.requiresAuth && !localStorage.getItem('token')){
//         return { name: 'Login'}
//     }

//     if (to.meta.requiresAuth == false && localStorage.getItem('token')){
//         return { name: 'Dashboard'}
//     }
// })



export default router
