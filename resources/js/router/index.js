import { createRouter, createWebHistory } from "vue-router";
// pages
import MainPage from '../pages/MainPage.vue'
import Template from '../Components/core/mainTemplate.vue'
import notFound from '../Components/notFound.vue'
import Dashboard from '../pages/Dashboard.vue'
import TicketRecord from '../pages/TicketRecord.vue'
//Employee

// IMS
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
import Type from '../pages/IMS/admin/Type.vue'
import Model from '../pages/IMS/admin/Model.vue'
import Category from '../pages/IMS/admin/Category.vue'
import Warehouse from '../pages/IMS/admin/Warehouse.vue'
import Status from '../pages/IMS/admin/Status.vue'
import Allterminal from '../pages/IMS/admin/Allterminal.vue'
import Updateterminal from '../pages/IMS/admin/Updateterminal.vue'
import Viewdetailterminal from '../pages/IMS/admin/Viewdetailterminal.vue'
import Order from '../pages/IMS/admin/Order.vue'

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

// log
import ClientLog from '../pages/Logfile/ClientLog.vue'
import QRScan from '../pages/Logfile/QRScanClientLog.vue'

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
                path : 'order',
                name : 'order_page',
                component : Order
            },
            {
                path : 'addnewatm',
                name : 'addnewatm_page',
                component : Addnewatm
            },
            {
                path : 'client_log',
                name : 'clientLog',
                component :ClientLog
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
                path : 'report',
                name : 'report_page',
                component : Report
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
              },
              {
                path:'Type',
                name: 'Type_page',
                component: Type
              },
              {
                path:'Model',
                name: 'Model_page',
                component: Model
              },
              {
                path:'Category',
                name: 'category_page',
                component: Category
              },
              {
                path:'Warehouse',
                name: 'warehouse_page',
                component: Warehouse
              },
              {
                path:'Status',
                name: 'status_page',
                component: Status
              },
              {
                path:'Allterminal',
                name: 'allterminal_page',
                component: Allterminal
              },
              {
                path:'Updateterminal/:id',
                name: 'updateterminal_page',
                component: Updateterminal
              },
              {
                path:'Viewdetailterminal/:id',
                name: 'viewdetailterminal_page',
                component: Viewdetailterminal
              },
              {
                path:'QRScan_ClientLog',
                name: 'QRScan',
                component: QRScan
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
