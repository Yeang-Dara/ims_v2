<template>
    <v-main style="padding: 20px 20px 20px 20px; background-color: #f2f7ff">
        <v-row style="padding: 10px; height: 90%">
            <v-card class="rounded-0" width="100%">
                <v-card class="d-flex align-center rouned-0" height="65px" style="padding: 15px" outlined>
                    <v-card-text style="font-size: 20px; text-align: start">
                        INCOMING MACHINE INFORMATION
                    </v-card-text>
                    <v-dialog v-model="dialog" max-width="700px">
                        <template v-slot:activator="{ props }">
                            <v-btn color="primary" class="mb-2" v-bind="props">New Incoming</v-btn>
                        </template>
                        <v-card>
                            <v-card-title style="
                                  background-color: blue;
                                  text-align: center;
                                  color: white;
                              ">{{ formTitle }}</v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" md="6" sm="12">
                                            <v-select
                                                :items="banks"
                                                item-value="id"
                                                item-title="customer_name"
                                                v-model="editedItem.customer_id"
                                                label="Bank Name"
                                                variant="outlined">
                                            </v-select>
                                        </v-col>
                                        <v-col cols="12" md="6" sm="12">
                                            <v-select :items="types" item-value="id" item-title="terminal_type"
                                                v-model="editedItem.type_id" label="Type" variant="outlined">
                                            </v-select>
                                        </v-col>
                                        <v-col cols="12" md="6" sm="12">
                                            <v-select :items="model" item-value="id" item-title="terminal_model"
                                                 v-model="editedItem.model_id" variant="outlined"  label="Model">
                                            </v-select>
                                        </v-col>
                                        <v-col cols="12" md="6" sm="12">
                                            <v-text-field variant="outlined" v-model="editedItem.quantity" label="Quantity">

                                            </v-text-field>
                                        </v-col>
                                        <v-col cols="12" md="6" sm="12">
                                            <v-select :items="statuses" item-value="id" item-title="status" variant="outlined" v-model="editedItem.status_id"
                                                label="Status">
                                            </v-select>
                                        </v-col>
                                        <v-col cols="12" md="6" sm="12">
                                            <v-select :items="warehouses" item-value="id" item-title="warehouse_name" variant="outlined" v-model="editedItem.warehouse_id"
                                                label="Warehouse">
                                            </v-select>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="red-darken-1" variant="text" @click="closedialog">
                                    Close
                                </v-btn>
                                <v-btn color="blue-darken-1" variant="text" @click="savesite">
                                    Save
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-card>
                <v-card flat class="mt-2">
                    <template v-slot:text>
                        <div class="d-flex align-end">
                            <v-spacer></v-spacer>
                            <v-text-field v-model="search" label="Search" prepend-inner-icon="mdi-magnify" single-line
                                variant="outlined" hide-details width="70px"></v-text-field>
                        </div>
                    </template>
                    <v-data-table :items-per-page="itemsPerPage" :headers="headers" :items="banklocations" :search="search">
                        <template v-slot:[`item.actions`]="{ item }">
                            <v-icon small @click="editItem(item)" color="cyan">
                                mdi-pencil
                            </v-icon>
                            <!-- <v-icon
                                  small
                                  @click="deleteItem(item)"
                                  color="red"
                              >
                                  mdi-delete
                              </v-icon> -->
                        </template>
                    </v-data-table>
                </v-card>
            </v-card>
        </v-row>
    </v-main>
</template>

<script scope>
import axios from "axios";
import moment from "moment";
import Swal from "sweetalert2";
export default {
    data() {
        return {
            dialog: false,
            itemsPerPage: 10,
            search: "",
            headers: [
                {
                    align: "start",
                    key: "customer_name",
                    sortable: false,
                    title: "Order For",
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
                    key: "quantity",
                    title: "Quantity",
                },
                {
                    key: "status",
                    title: "Status",
                },
                {
                    key: "warehouse_name",
                    title: "Warehouse",
                },
                { title: "Actions", key: "actions", class: " white--text" },
            ],
            banklocations: [],
            types: [
                { title: 'terminal_type' }
            ],
            model: [
                { title: 'terminal_model' }
            ],

            banks: [
                { title: 'customer_name' }
            ],
            statuses:[
                {title:'status'}
            ],
            editedIndex: -1,
            editedItem: {
                customer_id:"",
                model_id:"",
                type_id:"",
                warehouse_id:"",
                status_id:"",
                quantity:"",
            },
            // defaultItem: {
            //     customer_id:"",
            //     model_id:"",
            //     type_id:"",
            //     warehouse_id:"",
            //     status_id:"",
            //     quantity:"",
            // },
        };
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1
                ? "Add new incoming machine"
                : "Update imcoming machine information";
        },
    },
    watch: {
        dialog(val) {
            val || this.closedialog();
        },

    },
    created() {
        this.getbanklocation();
    },

    methods: {
        getbanklocation() {
            axios
                .get("/api/IMS/order/getorder")
                .then((Response) => {
                    this.banklocations = Response.data;
                    console.log(this.banklocations);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        closedialog() {
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },

        editItem(item) {
            this.editedIndex = this.banklocations.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
            console.log('data', this.banklocations)
        },
        savesite() {
            if (this.editedIndex > -1) {
                Object.assign(this.banklocations[this.editedIndex], this.editedItem)
                // axios.put("/api/IMS/banklocation/updatebanklocation/" + this.editedItem.id, this.editedItem)
                //     .then((Response) => {
                //         if (Response.status == 200) {
                //             Swal.fire({
                //                 title: Response.data.message,
                //                 icon: "success",
                //             });
                //             this.closedialog();
                //             console.log(Response.data);
                //         }
                //     })
                    // .catch((error) => {
                    //     Swal.fire({
                    //         title: error.response.data.message,
                    //         position: "top",
                    //         showConfirmButton: false,
                    //         timer: 1500
                    //     });
                    // });
                    console.log(this.editedItem);
            }
            else {
                axios.post("/api/IMS/order/addorder", this.editedItem)
                    .then((Response) => {
                            Swal.fire({
                                title: Response.data.message,
                                icon: "success",
                            });
                            this.closedialog();
                            console.log(Response.data);
                    })
                    .catch((error) => {
                        Swal.fire({
                            title: error.response.data.message,
                            position: "top",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });
            }
            this.getbanklocation();
        },
        deleteItem(item) {

        }
    },
    mounted: function () {
        this.banks = axios.get("/api/IMS/customer/getallcustomer")
            .then((Response) => {
                this.banks = Response.data;
                console.log(this.banks);
            })
            .catch((error) => {
                console.log(error);
            });

     this.type = axios.get("/api/IMS/terminaltype/allterminaltype")
            .then((Response) => {
                this.types = Response.data;
                console.log(this.types);
            })
            .catch((error) => {
                console.log(error);
            });
        axios.get("/api/IMS/terminalmodel/getallmodel")
            .then((Response) => {
                this.model = Response.data;
                console.log("model", this.model);
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
            axios
                .get("/api/IMS/warehouse/getallwarehouse")
                .then((Response) => {
                    this.warehouses = Response.data;
                    console.log(this.warehouses);
                })
                .catch((error) => {
                    console.log(error);
                });
    },
};
</script>
