<template>
  <v-container fluid grid-list-xl>
    <div class="d-flex justify-start mb-6">
        <div class="ma-2 pa-2">
            <v-text-field
                v-model="filter.start"
                variant="solo"
                density="compact"
                label="Start Date"
                type="date"
                autocomplete="false"
            ></v-text-field>
        </div>
        <div class="ma-2 pa-2">
            <v-text-field
                v-model="filter.end"
                label="End Date"
                density="compact"
                variant="solo"
                type="date"
            ></v-text-field>
        </div>
    </div>
    <v-card class="rounded-0" >
        <v-data-table
        :headers="headers"
        :items="filteredItems"
        class="elevation-1"
        >
        <template v-slot:item.name="{ item }">
            {{ item.raw.user_name }}
        </template>
        <template v-slot:item.date_request="{ item }">
            {{ item.raw.date_request }}
        </template>
        <template v-slot:item.from_date="{ item }">
            {{ item.raw.from_date }}
        </template>
        <template v-slot:item.to_date="{ item }">
            {{ item.raw.to_date }}
        </template>
        <template v-slot:item.day="{ item }">
            {{ item.raw.leave_duration }}
        </template>
        <template v-slot:item.status = "{ item }">
            <span v-if="item.raw.status_id == 1">
                <v-chip
                class="ma-2"
                color="blue"
                >
                    {{ item.raw.status_name }}
                </v-chip>
            </span>
            <span v-if="item.raw.status_id == 2">
                <v-chip
                class="ma-2"
                color="blue"
                >
                    {{ item.raw.status_name }}
                </v-chip>
            </span>
            <span v-if="item.raw.status_id == 3">
                <v-chip
                class="ma-2"
                color="green"
                >
                    {{ item.raw.status_name }}
                </v-chip>
            </span>
            <span v-if="item.raw.status_id == 4">
                <v-chip
                class="ma-2"
                color="red"
                >
                    {{ item.raw.status_name }}
                </v-chip>
            </span>
        </template>
        <template v-slot:item.actions="{ item }">
            <v-btn
                    class="ma-2"
                    color="blue"
                    small
                    @click="editItem(item.raw)"
                  >
                    Detail
            </v-btn>
        </template>
        <template v-slot:top>
            <v-dialog v-model="dialog" max-width="800px">
                <v-card >
                    <v-card-title class="text-center">
                        <span class="text-h5 text-indigo-accent-2">Leave Approval/Rejection</span>
                    </v-card-title>
                    <div class="ml-4">
                        <v-chip prepend-icon="mdi-account-circle"  color="blue"  text-color="white" >
                            {{ editedItem.user_name }}
                        </v-chip>
                    </div>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12" sm="6" md="6">
                                    <v-text-field
                                        v-model="editedItem.accept_name"
                                        label="Reporting Line"
                                        type="name"
                                        variant="outlined"
                                        readonly
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="6">
                                    <span v-if="editedItem.approve_name">
                                        <v-text-field
                                        v-model="editedItem.approve_name"
                                        label="Approver"
                                        type="name"
                                        variant="outlined"
                                        readonly
                                    ></v-text-field>
                                    </span>
                                </v-col>
                                <v-col cols="12" sm="12" md="12">
                                    <span v-if="editedItem.attachment">
                                        <v-card variant="outlined" class="mx-auto" max-width="800">
                                            <v-img
                                                height="800"
                                                :src="getImageUrl(editedItem.attachment)"
                                            ></v-img>
                                        </v-card>
                                    </span>
                                </v-col>
                                <v-col cols="12" sm="12" md="12">
                                    <span v-if="editedItem.reason">
                                        <v-text-field
                                            v-model="editedItem.reason"
                                            label="Leave Reason"
                                            variant="outlined"
                                            readonly
                                        ></v-text-field>
                                    </span>
                                </v-col>
                                <v-col cols="12" sm="12" md="12">
                                    <v-text-field
                                        v-model="editedItem.desc_reject"
                                        label="Reject Reason"
                                        variant="outlined"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <span class="mr-2">
                            <v-btn
                            color="grey-darken-1"
                            variant="tonal"
                            @click="close"
                            >
                            Cancel
                        </v-btn>
                        </span>
                        <span v-if="editedItem.status_id == 2 || editedItem.status_id == 1">
                            <span v-if="user.role_id == 3">
                                <v-btn
                                    class="ma-2"
                                    color="success"
                                    variant="tonal"
                                    small
                                    @click="approve(editedItem)"
                                >
                                        Approve
                                </v-btn>
                                <v-btn
                                    class="ma-2"
                                    color="red"
                                    small
                                    dark
                                    variant="tonal"
                                    @click="reject(editedItem)"
                                >
                                    reject
                                </v-btn>
                            </span>
                        </span>
                        <span v-if="editedItem.status_id == 1">
                            <span v-if="user.role_id != 3">
                                <v-btn
                                    class="ma-2"
                                    color="success"
                                    small
                                    variant="tonal"
                                    @click="accept(editedItem)"
                                >
                                    Approve
                                </v-btn>
                                <v-btn
                                class="ma-2"
                                color="red"
                                small
                                dark
                                variant="tonal"
                                @click="reject(editedItem)"
                                >
                                reject
                            </v-btn>
                            </span>
                        </span>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </template>
    </v-data-table>
    </v-card>
  </v-container>
</template>

<script>
import moment from 'moment'
// import Atten from '../../services/api/attendance'
import axios from 'axios'

export default {
        name: 'ManageLeave',
        computed: {
            filteredItems() {
                return this.attens.filter((item) => {
                    const itemDate = new Date(item.date_request); // or whatever the date property is named
                    return (
                        !this.filter.start||
                        !this.filter.end ||
                        (itemDate >= new Date(this.filter.start) && itemDate <= new Date(this.filter.end))
                    );
                });
            },
        },
        data: () => ({
            dialog: false,
            dialogDelete: false,
            selectedType: '',
            imageUrl: null,
            menu1: false,
            menu2: false,
            filter: {
                start: null,
                end: null,
            },
            headers: [
            {
                title: 'User Name',
                align: 'start',
                sortable: false,
                key: 'name',
            },
            { title: 'Leave Type', key: 'leave_name' },
            { title: 'Duration', key: 'day' },
            { title: 'Shift Time', key: 'shiftime' },
            { title: 'Date Request', key: 'date_request' },
            { title: 'Form Date', key: 'from_date' },
            { title: 'To Date', key: 'to_date' },
            { title: 'Status', key: 'status' ,align: 'center', sortable: false},
            { title: '', key: 'actions',  align: 'center', sortable: false },
            ],
            attens: [],
            user: {},
            em: "",
            admin:{},
            editedIndex: -1,
            editedItem: {
                status_id: '',
                approve_name: '',
                accept_name: '',
                desc_reject: '',
                attachment: ''
            },
            defaultItem: {
                accept_id:'',
                desc_reject: '',
            }
        }),
        watch: {
            dialog (val) {
                val || this.close()
            },
            dialogDelete (val) {
                val || this.closeDelete()
            },
        },
        async created () {
            // this.getAtten();
            await axios.get('api/user', this.auth)
                .then(res => {
                    this.user = res.data
                    console.log('user', this.user)
                    Atten.approveLeave(this.user.id)
                        .then(async res => {
                            this.attens = res.data.data
                            console.log('this atten', this.attens)
                        })
                });
        },
        methods: {
            getAtten() {
                Atten.dataTable()
                .then(async res => {
                    this.attens = res.data.data.data
                    console.log('this atten', this.attens)
                })
            },
            formatDate(date) {
                return moment(date).format('Do MMM')
            },
            dayCount(from_date, to_date) {
                const start = new Date(from_date)
                const end = new Date(to_date)
                const millisecondsPerDay = 24 * 60 * 60 * 1000
                const days = Math.round(Math.abs((start.getTime() - end.getTime()) / millisecondsPerDay))
                return days;
            },
            editItem  (item) {
                this.editedIndex = this.attens.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
                console.log("data", this.attens)
            },
            getImageUrl(attachment) {
                return `/storage/${attachment}`;
            },
            approve(item) {
                Atten.approve(item)
                    .then(res => {
                    this.attens = res.data;
                    console.log("new attendance", this.attens);
                    this.$swal({
                        title: "Success",
                        text: "Approved Successfully!",
                        icon: "success",
                    });
                })
                this.close();
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
            },

            accept(item) {
                Atten.pending(item).then(res => {
                    this.attens = res.data;
                    // console.log("new attendance", this.attens);
                    this.$swal({
                        title: "Success",
                        text: "Approved Successfully!",
                        icon: "success",
                    });
                });
                this.close();
                setTimeout(function() {
                        window.location.reload();
                    }, 2000);
            },
            reject(item) {
                Atten.reject(item)
                .then(res => {
                        this.attens = res.data;
                        console.log("reject", this.attens);
                        if (res.data.status == 422) {
                            this.$swal({
                                title: "Oops",
                                text: "Fail to rejected something went wrong!",
                                icon: "error",
                            });
                        }else {
                            this.$swal({
                                title: "Success",
                                text: "Rejected Successfully!",
                                icon: "success",
                            });
                        }
                 }).catch (err =>{
                    console.log(err.response)
                    this.$swal(
                            {
                                title: 'Oops',
                                text:"Fail to rejected, something went wrong!",
                                icon: 'error'
                            }
                        )
                 })
                 this.close();
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
            },

            close () {
                this.dialog = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },
        }
    }
</script>

