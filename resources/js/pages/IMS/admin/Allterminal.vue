<template>
    <v-main style="padding: 20px 20px 20px 20px; background-color: #f2f7ff">
        <v-row style="padding: 10px; height: 90%">
            <v-card class="rounded-0" width="100%">
                <v-card
                    class="d-flex align-center rouned-0"
                    height="65px"
                    style="padding: 15px"
                    outlined
                >
                    <v-card-text style="font-size: 20px; text-align: start">
                        ALL TERMINALS INFORMATION
                    </v-card-text>
                 
                </v-card>
                <v-card flat class="mt-2">
                    <template v-slot:text>
                        <div class="d-flex align-end">
                            <v-spacer></v-spacer>
                            <v-text-field
                                clearable
                                v-model="search"
                                label="Search"
                                prepend-inner-icon="mdi-magnify"
                                single-line
                                variant="outlined"
                                hide-details
                                width="70px"
                            ></v-text-field>
                        </div>
                    </template>
                    <v-data-table
                        :items-per-page="itemsPerPage"
                        :headers="headers"
                        :items="banklocations"
                        :search="search"
                    >
                        <template v-slot:[`item.actions`]="{ item }">
                            <router-link :to="'/portal/viewdetailterminal/'+item.id">
                                <v-icon size="small"
                                    class="me-2"
                                    color="blue">mdi-eye
                                </v-icon>
                            </router-link>
                            <router-link :to="'/portal/updateterminal/'+item.id">
                                <v-icon size="small"
                                    class="me-2"
                                    color="orange">mdi-pencil
                                </v-icon>
                            </router-link> 
                               
                        </template>
                    </v-data-table>
                </v-card>
            </v-card>
        </v-row>
    </v-main>
</template>

<script scope>
import axios from "axios";
export default {
    data() {
        return {
            itemsPerPage: 10,
            search: "",
            headers: [
                {
                    align: "start",
                    key: "atm_id",
                    sortable: false,
                    title: "ATM ID",
                },
                {
                    key: "serial_number",
                    title: "Serail Number",
                },
                {
                    key: "terminal_type",
                    title: "Type",
                },
                {
                    key: "terminal_model",
                    title: "Model",
                },
                {
                    key: "customer_name",
                    title: "Bank",
                },
                {
                    key: "siteID",
                    title: "Site ID",
                },
                {
                    key: "site_name",
                    title: "Site Name",
                },
                {
                    key: "address",
                    title: "address",
                },
                { title: "Actions", key: "actions", class: " white--text" },
            ],
            banklocations: [],
        };
    },
    computed: {
      
    },
    watch: {
      
    },
    created() {
        this.getbanklocation();
    },

    methods: {
        getbanklocation() {
            axios
                .get("/api/IMS/terminal/get")
                .then((Response) => {
                    this.banklocations = Response.data;
                    console.log("all",this.banklocations);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
  
    },
    mounted: function(){
    },
};
</script>
