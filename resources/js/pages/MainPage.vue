<template>
<v-app>
    <v-toolbar
      dark
      height="100"
      color="#2D3643"
    >
    <div class="d-flex align-center toolbar">
        <v-img
        :width="300"
        cover
        src="../assets/bti_logo.jpg"
        ></v-img>
    </div>
    <v-spacer></v-spacer>

    <div class="text-white mr-5">
        <h1>BTI PORTAL</h1>
    </div>
    </v-toolbar>
    <v-main>
        <v-container
          class="d-flex justify-center align-center text-h5"
          style="min-height: 300px;"
        >
        <v-list justify="center" align="center">
            <v-list-item class="mb-5 font-weight-bold">
                Menu
            </v-list-item>
            <v-list-item class="mb-5">
                    <v-btn color="#3E3D83" size="large"  class="text-white font-weight-bold">
                        <router-link :to="{ name: 'incedent' }" class="text-white text-decoration-none">
                            Ticket Incedent
                        </router-link>
                    </v-btn>
                <!-- </router-link> -->
            </v-list-item>
            <v-list-item class="mb-5">
                <v-btn color="#3E3D83" size="large"  class="text-white font-weight-bold">
                    hr system
                </v-btn>
            </v-list-item>
            <v-list-item class="mb-5">
                <v-btn color="#3E3D83" size="large"  class="text-white font-weight-bold">
                    <router-link :to="{ name: 'inventory' }" class="text-white text-decoration-none">
                        invetory system
                    </router-link>
                </v-btn>
            </v-list-item>
        </v-list>

        </v-container>
    </v-main>
</v-app>
</template>
