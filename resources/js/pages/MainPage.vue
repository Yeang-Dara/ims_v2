<template>
    <v-layout>
        <v-navigation-drawer width="600" color="#001133" theme="dark" permanent>
            <div class="text-center pa-16 text-uppercase">
               <h1>
                    Welcome to BTI Portal
               </h1>
            </div>
            <div class="text-center">
                <v-btn color="#3E3D83" size="large"  class="text-white font-weight-bold">
                        <router-link :to="{ name: 'Login' }" class="text-white text-decoration-none">
                            Log in
                        </router-link>
                </v-btn>
            </div>

        </v-navigation-drawer>
        <v-main>
            <div class="d-flex flex-row-reverse ">
                <v-sheet max-width="200" class="ma-2 pa-2">
                    <v-img
                        :width="300"
                        cover
                        src="../../assets/BTI-Payments.png"
                    ></v-img>
                </v-sheet>
            </div>
            <v-sheet>
                <v-img
                        cover
                        src="../../assets/backgroud_mainpage.jpg"
                ></v-img>
            </v-sheet>
        </v-main>
    </v-layout>
</template>
