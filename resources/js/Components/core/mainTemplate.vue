<template>
    <v-app>
        <v-app-bar
          app dark color="#1C2E6D"
        >
          <v-app-bar-nav-icon class="text-white" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

          <div class="d-flex align-center toolbar">
            <router-link :to="{ name: 'Incident_Dashboard' }" class="text">
                Incident Tracking
            </router-link>
          </div>
          <v-spacer></v-spacer>
          <v-btn icon>
            <router-link :to="{ name: 'mainPage' }">
                <v-icon color="white">
                    <!-- <router-link :to="{ name: 'mainPage' }"> -->
                        mdi-export
                    <!-- </router-link> -->
                </v-icon>
            </router-link>
            </v-btn>
        </v-app-bar>
        <v-navigation-drawer v-model="drawer" app color="grey-darken-2">
        <div>
          <router-link :to="{ name: 'Incident_Dashboard' }">
            <v-img
            width="260"
              cover
                src="../../assets/0-1.jpg"
                ></v-img>
          </router-link>

        </div>

        <v-list nav>
                <v-list-item
                    @click="changeRoute('Incident_Dashboard', 1)"
                    prepend-icon="mdi-view-dashboard"
                    value="Incident_Dashboard"
                    :class="[{'active': selectedIndex === 1}, 'item-title' ]"
                >
                {{ ('Dashboard') }}
                </v-list-item>
                <v-list-item
                    @click="changeRoute('ticketRecord', 2)"
                    prepend-icon="mdi-ticket-percent"
                    value="Ticket Record"
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

export default {
      name: "incident",
      data: () => ({
            selectedIndex: 1,
            isLoggedIn: false,
            drawer: null,
            loading: false,
            loaded: false,

      }),
      methods: {
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
      },
  };
  </script>
  <style>
  .navbar {
    display: flex;
    align-items: center;
    width: 100%;

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

  </style>
