<template>
    <v-container fluid grid-list-xl>
        <div class="d-flex flex-row mb-6">
            <div class="ma-2 pa-2 d-flex" style="width:200px;">
                <!-- <v-date-picker></v-date-picker> -->
                <v-text-field
                    v-model="filters.date"
                        class="pr-1"
                        label="Date"
                        variant="solo"
                        :rules="[v => !!v || 'Date is required']"
                        required outlined
                        density="compact"
                        color="blue" autocomplete="false" type="date"
                        />
            </div>
            <div class="ma-2 pa-2 d-flex ">
                <v-btn color="indigo-darken-1" @click="scanQR">QR Server</v-btn>
            </div>
        </div>
            <v-row>
                <v-col cols="12" sm="3" md="3">
                    <v-card class="QRList">
                        <v-list>
                            <v-list-item :style="{ fontSize: 'smaller', fontWeight: 'bold', color: '#3c519c' }" >QRServers</v-list-item>
                            <v-list-item
                                v-for="(item, i) in list_time"
                                :key="i"
                                :value="item"
                                color="primary"
                                density="compact"
                                @click="handleItemClick(item)"
                            >
                                <v-list-item-title :style="{ fontSize: 'smaller' }" v-text="item.time">
                                </v-list-item-title>
                                <!-- <v-divider></v-divider> -->
                            </v-list-item>
                        </v-list>
                    </v-card>
                </v-col>
                <v-col cols="12" sm="9" md="9">
                    <span v-if="shouldDisplayContent">
                        <v-card class="rounded-5 mx-auto pa-2" >
                            <v-data-table
                                v-model:search="search"
                                :headers="headers"
                                :items="datas"
                                class="table"
                                item-value="name"
                            >
                            </v-data-table>
                        </v-card>
                    </span>
                    <span v-else>
                    <!-- Optional: Message or content to display when there is no data -->
                    <p>No data available.</p>
                    <p class="text-blue">
                        Please click import button.
                    </p>
                    </span>
                </v-col>
            </v-row>
    </v-container>
 </template>

 <script>
   export default {
     data: () => ({
        headers: [
            {
            title: 'Date',
            align: 'start',
            // sortable: false,
            width: '150px',
            key: 'date',
          },
          { title: 'Time', align: 'start', key: 'time'},
          { title: 'Message', key: 'log_message'},
        ],
        datas: [],
        search: '',
        filters: {
            date: '',
        },
        filteredData: [], // Store filtered data
        list_time: {
            time: '',
        }
     }),
    computed: {
        shouldDisplayContent() {
            return this.datas && this.datas.length > 0;
        },

        formattedTime() {
            // Extract 'HH:mm' from the time string
            const timeParts = this.filters.time.split(':');
            return timeParts.slice(0, 2).join(':');
        },

        NonData() {
            return this.datas.length === 0;
        }

    },
     methods: {
        scanQR(){
            axios.post('/api/Log/clientLog/list-qr', { date: this.filters.date })
            .then(res => {
                this.list_time = res.data.data;
                console.log(this.list_time);
            })
            .catch(err => {
                console.log(err);
            })
        },

        handleItemClick(item) {
            console.log('Clicked item:', item);
            axios.post('/api/Log/clientLog/qrServer', { time: item.time, date: this.filters.date })
            .then(response => {
                    this.datas = response.data.data;
                    console.log(item.time, this.filters.date);
            })
            .catch(error => {
                console.log(error);
            })
        }
     },
   }
 </script>

<style>
    .table td{
        font-size: small!important;
        /* height: 2 !important; */
        padding: 4px !important;
    }

    .table th{
        font-size: 16px !important;
        height: 0 !important;
        padding: 6px !important ;
        background-color: #3c519c!important;
        color: white!important;
        border: 0.1px solid rgb(230, 228, 228)!important;
    }

    .table td {
        border: 0.1px solid rgb(230, 228, 228)!important;
        border-collapse: collapse!important;
        font-family: 'Consolas', monospace;
    }

    .see-more-link {
        color: blue;
        cursor: pointer;
        text-decoration: underline;
    }

    .QRList {
        font-size: 16px !important;
    }
</style>


