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
                        BANK INFORMATION
                    </v-card-text>
                    <v-dialog v-model="dialog" max-width="500px">
                        <template v-slot:activator="{ props }">
                            <v-btn color="primary" class="mb-2" v-bind="props">New Bank</v-btn>
                        </template>
                        <v-card>
                            <v-card-title
                                style="
                                    background-color: blue;
                                    text-align: center;
                                    color: white;
                                "
                                >{{ formTitle }}</v-card-title
                            >
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col>
                                            <v-text-field
                                                v-model="editedItem.customer_name"
                                                label="Bank Name"
                                            >
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="blue-darken-1"
                                    variant="text"
                                    @click="closedialog"
                                >
                                    Close
                                </v-btn>
                                <v-btn
                                    color="blue-darken-1"
                                    variant="text"
                                    @click="savebank"
                                >
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
                            <v-text-field
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
                        :items="banks"
                        :search="search"
                    >
                        <template v-slot:[`item.created_at`]="{ item }">
                            {{ formatDate(item.created_at) }}
                        </template>
                        
                        <template v-slot:[`item.actions`]="{ item }">
                            <v-btn small color="cyan" class="mr-1">
                                <v-icon
                                    small
                                    @click="editItem(item)"
                                    color="white"
                                >
                                    mdi-pencil
                                </v-icon>
                            </v-btn>
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
export default {
    data(){
        return{
            dialog: false,
            itemsPerPage: 10,
            search: "",
            headers: [
                {
                    align: "start",
                    key: "customer_name",
                    sortable: false,
                    title: "Bank Name",
                },
                { title: "Created At", key: "created_at", class: " white--text" },
                { title: "Actions", key: "actions", class: " white--text",
                },
            ],
            banks: [],
            editedIndex: -1,
            editedItem:{
                customer_name:'',
            },
            defaultItem: {
                customer_name: '',
            },
        };
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "Add new bank" : "Update bank information";
        },
    },
    watch: {
        dialog(val) {
            val || this.closedialog();
        },
    },
    created() {
        this.getBank();
    },

    methods: {
        getBank() {
            axios
                .get("/api/IMS/customer/getallcustomer")
                .then((Response) => {
                    this.banks = Response.data;
                    console.log(this.banks);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        
        closedialog() {
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            });
        },
        formatDate(value) {
            return moment(value).format("DD-MM-YYYY");
        },
        editItem(item) {
            this.editedIndex = 1
           
            this.editedItem = Object.assign({}, item)
            this.dialog = true
            const {reactive, toRaw} = Vue
            const foo = reactive({item})
            const qux = toRaw(foo)
            console.log(qux);
        },
        savebank(){
            if(this.editedIndex > -1){
                Object.assign(this.banks[this.editedIndex], this.editedItem)
                console.log(this.editedItem.customer_name);
            }


        }
        
    },
};
</script>
