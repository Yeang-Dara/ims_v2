<template>
    <v-app>
        <v-app-bar
          app dark color="#1C2E6D"
        >
          <v-app-bar-nav-icon class="text-white" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

          <div class="d-flex align-center toolbar">
            <router-link :to="{ name: 'Dashboard' }" class="text">
                <v-img
                    width="150"
                    cover
                    src="../../../assets/BTI (2).png"
                 ></v-img>
            </router-link>
          </div>
          <v-spacer></v-spacer>
        <v-menu offset-y transition="scale-transition">
            <template v-slot:activator="{ props }">
                <v-btn icon color="white" flat @click="notifications.map(x => x.isActive = false)">
                    <v-badge color="error" overlap v-bind="props">
                        <template v-slot:badge>{{ activeNotificationCount}}</template>
                        <v-icon>mdi-bell</v-icon>
                    </v-badge>
                </v-btn>
            </template>
            <v-card class="mx-auto" min-width="300">
                <v-toolbar
                    color="white"
                    dark
                    >
                    <v-toolbar-title class="text-blue font-weight-bold">Notifications</v-toolbar-title>
                </v-toolbar>
                <v-list two-line class="pa-0">
                    <template v-for="(item, index) in modifiedNotifications">
                        <v-divider v-if="item.isDivider" :key="index" inset></v-divider>
                            <v-list-item v-else :key="item.name" ripple @click="Notification">
                                <template v-slot:prepend>
                                    <v-avatar size="42px">
                                        <span v-if="item.image">
                                            <v-img :src="getImageUrl(item.image)" />
                                        </span>
                                        <!-- <span v-else>
                                            <v-img src="/../../../assets/avatar_female.png" />
                                        </span> -->
                                    </v-avatar>
                                </template>
                                <v-list-item-content>
                                <v-list-item-title class="font-weight-bold">{{ item.last_name }} {{ item.first_name }}</v-list-item-title>
                                <v-list-item-subtitle class="font-weight-bold">{{ formatDate(item.date_request) }}</v-list-item-subtitle>
                                <v-list-item-text>{{ item.reason }}</v-list-item-text>
                                </v-list-item-content>
                            </v-list-item>
                    </template>
                </v-list>
            </v-card>
        </v-menu>
        <v-menu open-on-hover offset-y transition="scale-transition">
            <template v-slot:activator="{ props }">

                <v-btn icon large flat :ripple="false" v-bind="props">
                <v-avatar size="42px">
                    <v-img src="../../../assets/man_avatar.png" />
                    <!-- <span v-if="user.image">
                        <v-img :src="getImageUrl(user.image)"/>
                    </span>
                    <span v-else>
                        <v-img src="../../../assets/man_avatar.png" />
                    </span> -->
                </v-avatar>
                </v-btn>
            </template>
            <v-list>
                <v-list-item color="primary">
                    <v-icon class="text-grey-darken-3">mdi-account-circle</v-icon>
                    <router-link
                    :to="'/Profile/'+ user.id"
                    class="pr-4 ml-2 text-grey-darken-3"
                    style="text-decoration: none"
                    >
                    Profile</router-link
                    >
                </v-list-item>
                <v-list-item color="primary">
                    <v-icon class="text-grey-darken-3">mdi-exit-to-app</v-icon>
                    <span @click="logout" class="pr-4 ml-2 text-grey-darken-3" style="text-decoration: none"
                    >Log Out</span>
                </v-list-item>
            </v-list>
        </v-menu>
        <div class="mt-3 ml-2 mr-2 text-white text-capitalize">
            <p>{{ user.last_name }} {{ user.first_name }}</p>
        </div>
          <!-- <v-btn icon>
            <router-link :to="{ name: 'mainPage' }">
                <v-icon color="white">
                </v-icon>
            </router-link>
            </v-btn> -->
        </v-app-bar>
        <v-navigation-drawer v-model="drawer" app color="grey-darken-2">

        <v-list nav  dense>
                <v-list-item
                    @click="changeRoute('Dashboard', 1)"
                    prepend-icon="mdi-view-dashboard"
                    value="Dashboard"
                    style="font-size: 14px;"
                    :class="[{'active': selectedIndex === 1}, 'item-title' ]"
                >
                {{ ('Dashboard') }}
                </v-list-item>
                <span v-if="user.role_id != 2 && user.role_id != 5 && user.role_id != 6">
                <v-list-group value="Employees">
                <template v-slot:activator="{ props }">
                    <v-list-item
                    v-bind="props"
                    style="font-size: 14px;"
                    prepend-icon="mdi-account-multiple"
                    class="item-title"
                    >{{ ('Employees') }} </v-list-item>
                </template>
                <v-list-item
                        @click="changeRoute('AddEmployee', 2)"
                        value="AddEmployee"
                        style="font-size: 14px;"
                        :class="[{'active': selectedIndex === 2}, 'item-title' ]"
                >{{ ('Add Employee') }}</v-list-item>
                <v-list-item
                        @click="changeRoute('ManageEmployee', 3)"
                        value="ManageEmployee"
                        style="font-size: 14px;"
                        :class="[{'active': selectedIndex === 3}, 'item-title' ]"
                >{{ ('Manage Employee') }}</v-list-item>
                </v-list-group>
            </span>
                <v-list-group value="Leave">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                        v-bind="props"
                        style="font-size: 14px;"
                        prepend-icon="mdi-deskphone"
                        class="item-title"
                        >{{ ('Leaves') }} </v-list-item>
                    </template>
                    <span v-if="user.role_id != 3">
                        <v-list-item
                            @click="changeRoute('ApplyLeave', 4)"
                            value="ApplyLeave"
                            style="font-size: 14px;"
                            :class="[{'active': selectedIndex === 4}, 'item-title' ]"
                        >{{ ('Apply Leave') }}</v-list-item>
                        <v-list-item
                                @click="changeRoute('MyLeave', 12)"
                                value="MyLeave"
                                style="font-size: 14px;"
                                :class="[{'active': selectedIndex === 12}, 'item-title' ]"
                        >{{ ('My Leave') }}</v-list-item>
                    </span>
                    <span v-if="user.role_id != 2">
                        <v-list-item
                                @click="changeRoute('ManageLeave', 5)"
                                value="ManageLeave"
                                style="font-size: 14px;"
                                :class="[{'active': selectedIndex === 5}, 'item-title' ]"
                        >{{ ('Manage Leave') }}</v-list-item>
                        <span v-if="user.role_id != 5">
                            <v-list-item
                                @click="changeRoute('LeaveView', 6)"
                                value="ManageView"
                                style="font-size: 14px;"
                                :class="[{'active': selectedIndex === 6}, 'item-title' ]"
                            >{{ ('Leave View') }}</v-list-item>
                        </span>
                    </span>
                </v-list-group>
                <v-list-group value="Terminals">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                        v-bind="props"
                        prepend-icon="mdi-warehouse"
                        class="item-title"
                        style="font-size: 14px;"
                        >{{ ('Terminals') }} </v-list-item>
                    </template>
                        <v-list-item
                            @click="changeRoute('atm_page', 13)"
                            value="atm_page"
                            style="font-size: 14px;"
                            :class="[{'active': selectedIndex === 13}, 'item-title' ]"
                        >{{ ('List Terminal') }}</v-list-item>
                        <v-list-item
                                @click="changeRoute('addnewatm_page', 14)"
                                value="addnewatm_page"
                                style="font-size: 14px;"
                                :class="[{'active': selectedIndex === 14}, 'item-title' ]"
                        >{{ ('New Terminal') }}</v-list-item>
                </v-list-group>
                <v-list-item
                    @click="changeRoute('order_page', 15)"
                    value="order_page"
                    style="font-size: 14px;"
                    prepend-icon="mdi-home-plus"
                    :class="[{'active': selectedIndex === 15}, 'item-title' ]"
                >{{ ('Incoming Machine') }}</v-list-item>
                <span v-if=" user.role_id == 1 || user.role_id == 4">
                    <v-list-group value="Setting">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                        v-bind="props"
                        style="font-size: 14px;"
                        prepend-icon="mdi-cog"
                        class="item-title"
                        >{{ ('Setting') }} </v-list-item>
                    </template>
                    <v-list-item
                            @click="changeRoute('Department', 7)"
                            value="Department"
                            style="font-size: 14px;"
                            :class="[{'active': selectedIndex === 7}, 'item-title' ]"
                    >{{ ('Department') }}</v-list-item>
                    <v-list-item
                            @click="changeRoute('LeaveType', 8)"
                            value="LeaveType"
                            style="font-size: 14px;"
                            :class="[{'active': selectedIndex === 8}, 'item-title' ]"
                    >{{ ('Leave Type') }}</v-list-item>
                    <v-list-item
                            @click="changeRoute('Position', 9)"
                            value="Position"
                            style="font-size: 14px;"
                            :class="[{'active': selectedIndex === 9}, 'item-title' ]"
                    >{{ ('Position') }}</v-list-item>
                    <v-list-item
                            @click="changeRoute('MasterUsers', 11)"
                            value="MasterUsers"
                            style="font-size: 14px;"
                            :class="[{'active': selectedIndex === 11}, 'item-title' ]"
                    >{{ ('Master Users') }}</v-list-item>
                    <v-list-group value="bank">
                        <template v-slot:activator="{ props }">
                        <v-list-item
                        v-bind="props"
                        class="item-title"
                        style="font-size: 14px;"
                        >{{ ('Banks Master') }} </v-list-item>
                    </template>
                    <v-list-item
                            @click="changeRoute('bank_page', 16)"
                            value="bank_page"
                            style="font-size: 14px;"
                            :class="[{'active': selectedIndex === 16}, 'item-title' ]"
                    >{{ ('List Banks') }}</v-list-item>
                    <v-list-item
                            @click="changeRoute('banklocation_page', 17)"
                            value="banklocation_page"
                            style="font-size: 14px;"
                            :class="[{'active': selectedIndex === 17}, 'item-title' ]"
                    >{{ ('Bank Location') }}</v-list-item>
                    </v-list-group>
                    <v-list-item
                            @click="changeRoute('engineer_page', 18)"
                            value="engineer_page"
                            style="font-size: 14px;"
                            :class="[{'active': selectedIndex === 18}, 'item-title' ]"
                    >{{ ('Engineers Master') }}</v-list-item>
                    <v-list-item
                            @click="changeRoute('Site_page', 19)"
                            value="Site_page"
                            style="font-size: 14px;"
                            :class="[{'active': selectedIndex === 19}, 'item-title' ]"
                    >{{ ('Site Master') }}</v-list-item>
                    <v-list-group value="terminal">
                        <template v-slot:activator="{ props }">
                        <v-list-item
                        v-bind="props"
                        style="font-size: 14px;"
                        class="item-title"
                        >{{ ('Terminal Master') }} </v-list-item>
                    </template>
                    <v-list-item
                            @click="changeRoute('bank_page', 16)"
                            value="bank_page"
                            style="font-size: 14px;"
                            :class="[{'active': selectedIndex === 16}, 'item-title' ]"
                    >{{ ('Type') }}</v-list-item>
                    <v-list-item
                            @click="changeRoute('banklocation_page', 17)"
                            value="banklocation_page"
                            style="font-size: 14px;"
                            :class="[{'active': selectedIndex === 17}, 'item-title' ]"
                    >{{ ('Model') }}</v-list-item>
                    </v-list-group>
                </v-list-group>
                </span>
                <v-list-item
                    @click="changeRoute('report_page', 18)"
                    prepend-icon="mdi-calendar-export"
                    value="Report"
                    style="font-size: 14px;"
                    :class="[{'active': selectedIndex === 18}, 'item-title' ]"
                >
                {{ ('Report') }}
                </v-list-item>
                <v-list-item
                    @click="changeRoute('spare_part_page', 19)"
                    prepend-icon="mdi-toolbox"
                    value="Spare parts"
                    style="font-size: 14px;"
                    :class="[{'active': selectedIndex === 19}, 'item-title' ]"
                >
                {{ ('Spare parts') }}
                </v-list-item>
                <v-list-item
                    @click="changeRoute('ticketRecord', 2)"
                    prepend-icon="mdi-ticket-percent"
                    value="Ticket Record"
                    style="font-size: 14px;"
                    :class="[{'active': selectedIndex === 2}, 'item-title' ]"
                >
                {{ ('Ticket Record') }}
                </v-list-item>
        </v-list>
        </v-navigation-drawer>

        <!-- page -->
      <v-main>
        <div class="content">
            <breadcrumbs />
            <router-view></router-view>
        </div>
      </v-main>
    </v-app>
</template>

<script>
import axios from 'axios';
export default {
      name: "MainTemplate",
      data: () => ({
            selectedIndex: 1,
            drawer: null,
            loading: false,
            loaded: false,
            notifications: [],
            user: {},
      }),
      computed: {
        activeNotificationCount() {
             return this.notifications.filter(x => x.active).length;
         },

        modifiedNotifications() {
            const modifiedList = [];

            for (let i = 0; i < this.notifications.length; i++) {
                modifiedList.push(this.notifications[i]);

                if (i !== this.notifications.length - 1) {
                modifiedList.push({ isDivider: true });
                }
            }

            return modifiedList;
        },
      },
      mounted() {
        this.startTimer()
        document.addEventListener('mousemove', this.resetTimer)
        document.addEventListener('keypress', this.resetTimer)
        // console.log(localStorage)
        this.isLoggedIn = !!localStorage.getItem("token");
        const token = localStorage.getItem("token");

// Create an auth object with headers containing the token
        const auth = {
            headers: {
                Authorization: `Bearer ${token}`
            }
        };
        axios.get('/api/user', auth)
            .then(res => {
                this.user = res.data
                if (this.user.role_id  == 2) {
                    this.$router.push('/hr-sys/applyLeave');
                }
                axios.get('/api/hr/HR/staff/notification/' + this.user.id)
                // Staff.Notification(this.user.id)
                .then(res => {
                    this.notifications = res.data
                    console.log(this.notifications)
                })
            })
            .catch(error => {
                localStorage.removeItem("token");
                this.$router.push('/hr-sys/login-hr');
            })

            const count = this.activeNotificationCount;
            console.log(count);
      },
      methods: {
        logout () {
            localStorage.removeItem("token");
            this.$router.push('/');
        },
        formatDate(time) {
            const formattedDate = moment(time).format('ddd, MMM D');
            return formattedDate;
        },
        startTimer() {
            this.timer = setTimeout(() => {
                alert('Session expired. You will be logged out.');
                localStorage.removeItem("token");
                this.$router.push('/hr-sys/login-hr');
            }, 1800000) // 30 minutes in milliseconds
        },
        resetTimer() {
            clearTimeout(this.timer)
            this.startTimer()
        },
        Profile() {
            this.$router.push({ name: 'Profile', params: {id: this.user.id} } );
        },
        changeRoute(routeName, selectedIndex) {
          const vm = this;

          vm.selectedIndex = selectedIndex;

          return vm.$router.push({ name: routeName });
        },
        onClick () {
            this.loading = true

            setTimeout(() => {
            this.loading = false
            this.loaded = true
            }, 2000)
        },

        Notification() {
            this.$router.push('/hr-sys/manangeLeave');
        },

        getImageUrl(attachment) {
                return `/storage/${attachment}`;
            },
      },
  };
  </script>
  <style>
  .navbar {
    display: flex;
    align-items: center;
    width: 100%;
    /* font-size: 8px; */

  }
  .toolbar-menu-item {
    padding-left: 5px;
  }
  .toolbar {
    font-weight: bold;
    font-size: 18px;
  }
  .text {
    padding-left: 15px;
    color: white;
    text-decoration:none;
  }
  .content {
    background-color: #E8EAF6;
    width: 100%;
    height: 100%;
  }
/*
  .v-list {
    font-size: 8px;
  } */

  </style>
