<template>
    <v-container fluid grid-list-xl class="pt-0">
        <v-card>
            <v-card-title>Add new terminal</v-card-title>
            <v-container>
                <v-row class="pt-2" variant="outlined">
                    <v-col class="pb-0 py-0 " cols="12" sm="6" md="4">
                        <label for="atm_id">ATM ID</label>
                        <v-icon small color="orange">mdi-star
                        </v-icon>

                        <v-text-field v-model="uses.atm_id" outlined></v-text-field>
                    </v-col>
                    <v-col class="pb-0 py-0 " cols="12" sm="6" md="4">
                        <label for="alias_id">Alias ATM ID</label>
                        <v-text-field v-model="uses.alias_id" label="" outlined></v-text-field>
                    </v-col>
                    <v-col class="pb-0 py-0 " cols="12" sm="6" md="4">
                        <label for="alias_id">Install Date</label>
                        <v-text-field v-model="uses.install_date" type="date" prepend-inner-icon="mdi-calendar"
                            outlined></v-text-field>
                    </v-col>
                    <v-col class="py-0 pb-0" cols="12" sm="6" md="4">
                        <label for="alias_id">Delivery Date</label>

                        <v-text-field v-model="uses.delivery_date" label="" type="date" prepend-inner-icon="mdi-calendar"
                            outlined></v-text-field>
                    </v-col>
                    <v-col class="py-0" cols="12" sm="6" md="4">
                        <label for="alias_id">Take Over Date</label>
                        <v-icon small color="orange">mdi-star
                        </v-icon>
                        <v-text-field v-model="uses.takeover_date" label="" type="date"
                            prepend-inner-icon="mdi-calendar-end" outlined></v-text-field>
                    </v-col>
                    <v-col class="py-0" cols="12" sm="6" md="4">
                        <label for="alias_id">Category</label>
                        <v-icon small color="orange">mdi-star
                        </v-icon>
                        <v-select :items="categories" item-value="id" item-title="category_name" v-model="uses.category_id"
                            label="" outlined></v-select>
                    </v-col>
                    <v-col class="py-0" cols="12" sm="6" md="4">
                        <label for="alias_id">Serial Number</label>
                        <v-icon small color="orange">mdi-star </v-icon>
                        <v-text-field v-model="uses.serial_number" label="" outlined></v-text-field>
                    </v-col>
                    <v-col class="py-0" cols="12" sm="6" md="4">
                        <label for="alias_id">Model</label>
                        <v-icon small color="orange">mdi-star
                        </v-icon>
                        <v-select :items="models" item-value="id" item-title="terminal_model" v-model="uses.model_id"
                            label="" outlined></v-select>
                    </v-col>
                    <v-col class="py-0" cols="12" sm="6" md="4">
                        <label for="alias_id">Warranty Days</label>
                        <v-text-field v-model="uses.warrenty" label="" outlined></v-text-field>
                    </v-col>
                    <v-col class="py-0" cols="12" sm="6" md="4">
                        <label for="alias_id">Status</label>
                        <v-icon small color="orange">mdi-star
                        </v-icon>
                        <v-select :items="statuses" item-value="id" item-title="status" v-model="uses.status_id" label=""
                            outlined></v-select>
                    </v-col>
                    <v-col class="py-0" cols="12" sm="6" md="4">
                        <label for="alias_id">Type</label>
                        <v-icon small color="orange">mdi-star
                        </v-icon>
                        <v-select :items="types" item-value="id" item-title="terminal_type" v-model="uses.type_id" label=""
                            outlined></v-select>
                    </v-col>

                    <v-col class="py-0" cols="12" sm="6" md="4">
                        <label for="alias_id">Android Version</label>
                        <v-text-field v-model="uses.android_version" label="" outlined></v-text-field>
                    </v-col>
                    <v-col class="py-0" cols="12" sm="6" md="6">
                        <label for="alias_id">SiteID</label>
                        <v-icon small color="orange">mdi-star
                        </v-icon>
                        <v-autocomplete :items="banklocations" item-value="id" item-title="siteID" v-model="uses.banklocation_id" label="" clearable></v-autocomplete>
                    </v-col>
                </v-row>
                <v-row class="d-flex justify-end pa-2 mb-2">
                    <v-btn color="blue darken-1" outlinetext style="color:white; margin-left:6px;" @click="addItem">Add</v-btn>
                </v-row>
            </v-container>
            <v-divider></v-divider>
            <v-card-title>Bank information</v-card-title>
            <v-container>
                <v-row>
                    <v-col class="py-0" cols="12" sm="6" md="">
                        <v-text-field  variant="outlined" item-value="id" item-title="siteID" label="Search bank information here"
                            prepend-inner-icon="mdi-magnify" @click="find"></v-text-field>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
        <!-- search bank location  -->
        <v-dialog v-model="dialog" width="70%">
            <v-card>
                <v-data-table :items-per-page="itemsPerPage" :headers="headers" :items="banklocations" :search="search"></v-data-table>
                <v-btn @click="close" style="color: blue;" >Close</v-btn>
            </v-card>
        </v-dialog>
    </v-container>
</template>
<script>
import Swal from "sweetalert2";
import axios from 'axios';
export default {
    data: () => ({
        types: [],
        dialog: false,
        categories: [],
        banklocations: [],
        models: [],
        statuses: [],
        success: false,
        error: false,
        noData: true,
        Rules: [
            v => !!v || 'is required',
        ],
        test:{},
        dataID: {},
        uses: {
            atm_id: '',
            serial_number: '',
            alias_id: '',
            install_date: '',
            delivery_date: '',
            takeover_date: '',
            android_version: '',
            model_id: '',
            type_id: '',
            banklocation_id: '',
            category_id: '',
            status_id: '',
            warrenty: '',
        },
        editedItem: {
                site_name_id: "",
                bank_name_id:"",
                siteID:"",
                address:"",
         
            },
        headers: [
            {
                align: "start",
                key: "customer_name",
                sortable: false,
                title: "Bank Name",
            },
            {
                key: "site_name",
                title: "Site Name",
            },
            {
                key: "siteID",
                title: "Site ID",
            },
            {
                key: "address",
                title: "address",
            },
            { title: "", key: "actions", class: " white--text" },
        ],
    }),
    watch:{
        dialog(val) {
            val || this.close();
        },
    },
    methods: {
        hide_success: function (event) {
            console.log('Hide')
            window.setInterval(() => {
                this.success = false;
                this.error = false;
            }, 5000)
        },
        addItem() {
            console.log(this.uses);
        },
        find() {
            this.dialog = true;
        },
        close(){
            this.dialog= false;
        },
    },
    mounted: function () {
        if (alert) {
            this.hide_success();
        }

        axios.get("/api/IMS/categorie/allcategory")
            .then((Response) => {
                this.categories = Response.data.data;
                console.log("category", this.categories);
            })
            .catch((error) => {
                console.log(error);
            });
        axios.get("/api/IMS/terminaltype/allterminaltype")
            .then((Response) => {
                this.types = Response.data;
                console.log("type", this.types);
            })
            .catch((error) => {
                console.log(error);
            });

        axios.get("/api/IMS/terminalmodel/getallmodel")
            .then((Response) => {
                this.models = Response.data;
                console.log("model", this.models);
            })
            .catch((error) => {
                console.log(error);
            });

        axios.get("/api/IMS/status/all")
            .then((Response) => {
                this.statuses = Response.data;
                console.log("status", this.statuses);
            })
            .catch((error) => {
                console.log(error);
            });
        axios.get("/api/IMS/banklocation/getall")
            .then((Response) => {
                this.banklocations = Response.data;
                console.log("location", this.banklocations);
            })
            .catch((error) => {
                console.log(error);
            });
    }
}
</script>
<style scoped>
::v-deep .v-alert {
    width: 300px;
    margin-top: 20px;
    position: fixed;
    right: 0%;
    z-index: 1;
    top: 50px;
}

.v-text-field .prepend-inner-icon {
    color: blue;
}
</style>