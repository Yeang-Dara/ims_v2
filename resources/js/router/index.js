import { createRouter, createWebHistory } from "vue-router";
// pages
import MainPage from '../pages/MainPage.vue'
import Template from '../Components/core/mainTemplate.vue'
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

// HR
import HR from '../Components/HR/HRmainTemplate.vue'
import HRLogin from '../pages/HR/Authentication/Login.vue'
import HRDashboard from '../pages/HR/Dashboard.vue'
//Employee
import AddEmployee from '../pages/HR/Employee/AddEmployee.vue'
import ManageEmployee from '../pages/HR/Employee/ManageEmployee.vue'
import viewDetail from '../pages/HR/Employee/viewDetail.vue'
import HRProfile from '../pages/HR/Employee/Profile.vue'
//Leave
import ApplyLeave from '../pages/HR/Leave/ApplyLeave.vue'
import ManageLeave from '../pages/HR/Leave/ManageLeave.vue'
import LeaveView from '../pages/HR/Leave/LeaveView.vue'
import MyLeave from '../pages/HR/Leave/MyLeave.vue'
//Setting
import Deparment from '../pages/HR/Setting/Department.vue'
import LeaveType from '../pages/HR/Setting/LeaveType.vue'
import Role from '../pages/HR/Setting/Role.vue'
import Permission from '../pages/HR/Setting/Permission.vue'
import MasterUsers from '../pages/HR/Setting/AdminUsers.vue'


import Bank from '../pages/IMS/admin/Bank.vue'
import Banklocation from '../pages/IMS/admin/Banklocation.vue'

const routes = [
    {
        path: '/',
        name: 'mainPage',
        component: MainPage,
    },
    {
        path: '/portal',
        name :'portal',
        component : Template,
        redirect : '/portal/dashboard',
        children: [
            {
                path: 'dashboard',
                name: 'Dashboard',
                component: Dashboard,
                meta: {
                    requiresAuth: true,
                    breadcrumb: [
                        { name: 'Dashboard' }
                    ]
                }
            },
            {
                path: 'Profile/:id',
                name: 'Profile',
                component: HRProfile,
                meta: {
                    requiresAuth: true,
                },
            },
            {
                path: 'AddEmployee',
                name: 'AddEmployee',
                component: AddEmployee,
                meta: {
                    requiresAuth: true,
                    breadcrumb: [
                        { name: 'Dashboard', href: 'Dashboard' },
                        { name: 'Add Employee' }
                    ]
                },
            },
            {
                path: 'manageEmployee',
                name: 'ManageEmployee',
                component: ManageEmployee,
                meta: {
                    requiresAuth: true,
                    breadcrumb: [
                        { name: 'Dashboard', href: 'Dashboard' },
                        { name: 'Manage Employee' }
                    ]
                },
            },
            {
                path: 'manageEmployee/viewDetail/:id',
                name: 'ViewDetail',
                component: viewDetail,
                meta: {
                    requiresAuth: true,
                    breadcrumb: [
                        { name: 'Dashboard', href: 'Dashboard' },
                        { name: 'ManageEmployee', href: 'ManageEmployee' },
                        { name: 'ViewDetail'}
                  ]
                },
            },
            {
                path: 'applyLeave',
                name: 'ApplyLeave',
                component: ApplyLeave,
                meta: {
                    requiresAuth: true,
                    breadcrumb: [
                        { name: 'Dashboard', href: 'Dashboard' },
                        { name: 'Apply Leave' }
                    ]
                }
            },
            {
                path: 'manangeLeave',
                name: 'ManageLeave',
                component: ManageLeave,
                meta: {
                    requiresAuth: true,
                    breadcrumb: [
                        { name: 'Dashboard', href: 'Dashboard' },
                        { name: 'Manage Leave' }
                    ]
                }
            },
            {
                path: 'leaveView',
                name: 'LeaveView',
                component: LeaveView,
                meta: {
                    requiresAuth: true,
                    breadcrumb: [
                        { name: 'Dashboard', href: 'Dashboard' },
                        { name: 'Leave View' }
                    ]
                }
            },
            {
                path: 'department',
                name: 'Department',
                component: Deparment,
                meta: {
                    requiresAuth: true,
                    breadcrumb: [
                        { name: 'Dashboard', href: 'Dashboard' },
                        { name: 'Department' }
                    ]
                }
            },
            {
                path: 'leave_type',
                name: 'LeaveType',
                component: LeaveType,
                meta: {
                    requiresAuth: true,
                    breadcrumb: [
                        { name: 'Dashboard', href: 'Dashboard' },
                        { name: 'Leave Type' }
                    ]
                }
            },
            {
                path: 'my_leave',
                name: 'MyLeave',
                component: MyLeave,
                meta: {
                    requiresAuth: true,
                    breadcrumb: [
                        { name: 'Dashboard', href: 'Dashboard' },
                        { name: 'My Leave' }
                    ]
                }
            },
            {
                path: 'position',
                name: 'Position',
                component: Role,
                meta: {
                    requiresAuth: true,
                    breadcrumb: [
                        { name: 'Dashboard', href: 'Dashboard' },
                        { name: 'Position' }
                    ]
                }
            },
            {
                path: 'master_user',
                name: 'MasterUsers',
                component: MasterUsers,
                meta: {
                    requiresAuth: true,
                    breadcrumb: [
                        { name: 'Dashboard', href: 'Dashboard' },
                        { name: 'MasterUsers' }
                    ]
                }
            },
            {
                path: 'ticket_record',
                name: 'ticketRecord',
                component: TicketRecord,
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
                name : 'ims_dashboard',
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
              }
        ]
    },
    {
        path: '/hr-sys/login-hr',
        name : 'Login',
        component : HRLogin,
            meta: {
                    allowAnonymous: true,
                    requiresAuth: false
            }
    },
    // {
    //     path: '/hr-sys',
    //     name: 'hr',
    //     component: HR,
    //     redirect: '/hr-sys/dashboard',
    //     children: [
    //         {
    //             path: 'dashboard',
    //             name: 'HR_Dashboard',
    //             component: HRDashboard,
    //             meta: {
    //                 requiresAuth: true,
    //                 // breadcrumb: [
    //                 //     { name: 'Dashboard' }
    //                 //   ]
    //             }
    //         },

    //     ]
    // },
    //notFound
    {
        path: '/:pathMatch(.*)*',
        component: notFound,
        meta: {
            allowAnonymous: true,
            requiresAuth: false
        }
    }
]
const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from) => {
    if (to.meta.requiresAuth && !localStorage.getItem('token')){
        return { name: 'Login'}
    }

    if (to.meta.requiresAuth == false && localStorage.getItem('token')){
        return { name: 'Dashboard'}
    }
})
// Set an item in localStorage with an expiration time
function setItemWithExpiration(key, value, expiration) {
    const item = {
      value: value,
      expiration: new Date().getTime() + expiration // expiration is in milliseconds
    };
    localStorage.setItem(key, JSON.stringify(item));
    setTimeout(() => {
      localStorage.removeItem(key);
    }, expiration);
  }
// Get an item from localStorage and remove it if it has expired
function getItemWithExpiration(key) {
    const item = localStorage.getItem(key);
    if (item) {
      const { value, expiration } = JSON.parse(item);
      if (new Date().getTime() > expiration) {
        localStorage.removeItem(key);
        return null;
      }
      return value;
    }
    return null;
}
// Set an item with an expiration time of 1 minute (60 seconds)
setItemWithExpiration('key', 'value', 60 * 1000);
  const value = getItemWithExpiration('key');
  if (value) {
    console.log(value);
  } else {
    console.log('Item has expired or does not exist');
  }

export default router
