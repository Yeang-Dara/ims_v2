<template>
    <v-container fluid grid-list-xl>
        <div class="d-flex flex-row mb-6">
            <div class="ma-2 pa-2 d-flex" style="width:200px;">
                <!-- <v-date-picker></v-date-picker> -->
                <v-text-field
                    v-model="filters.date"
                        class="pr-1"
                        label="Date"
                        :readonly="isLoading"
                        variant="solo"
                        :disabled="NonData"
                        :rules="[v => !!v || 'Date is required']"
                        required outlined
                        density="compact"
                        color="blue" autocomplete="false" type="date"
                        />
            </div>
            <div class="ma-2 pa-2 d-flex ">
                <v-btn color="indigo-darken-1">QRSever</v-btn>
            </div>
            <div class="ma-2 pa-2 d-flex me-auto">
                <v-btn @click="clearFilters" color="indigo-darken-2" :disabled="NonData">Clear</v-btn>
            </div>
        </div>
            <v-row>
                <v-col cols="12" sm="3" md="3">
                    <v-card class="QRList">
                        <v-list>
                            <v-list-item :style="{ fontSize: 'smaller', fontWeight: 'bold', color: '#3c519c' }" >QRServers</v-list-item>
                            <v-list-item
                                v-for="(item, i) in items"
                                :key="i"
                                :value="item"
                                color="primary"
                                density="compact"
                            >
                                <v-list-item-title :style="{ fontSize: 'smaller' }" v-text="item.text">
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
                                :items="filteredData"
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
        dialog: false,
        file: null,
        expanded: [],
        headers: [
            {
            title: 'Date',
            align: 'start',
            // sortable: false,
            key: 'date',
          },
          { title: 'Time', align: 'start', key: 'time'},
          { title: 'Message', key: 'log_message'},
        ],
        datas: [],
        search: '',
        filters: {
            date: '',
            time: '',
        },
        filteredData: [], // Store filtered data
        items: [
            { text: 'Real-Time'},
            { text: 'Audience' },
            { text: 'Conversions'},
        ],
     }),
     created() {
        this.getData();
    },
    watch: {
        shouldDisplayContent: {
            handler(newValue) {
                // Open the dialog if shouldDisplayContent is false (no datas)
                if (!newValue) {
                    this.openFileDialog();
                }
            },
        // immediate: true, // Trigger the handler immediately on component creation
        },
    },
    computed: {
        shouldDisplayContent() {
            return this.datas && this.datas.length > 0;
        },
        filteredData() {
            return this.datas.filter(item => {
                const itemDateTime = new Date(`${item.date} ${item.time}`);
                const filterDateTime = new Date(`${this.filters.date} ${this.filters.time}`);

                  // Format dates to compare
                const itemDate = itemDateTime.toLocaleDateString();
                const filterDate = filterDateTime.toLocaleDateString();
                // Check date if applicable
                const dateMatches = !this.filters.date || itemDate === filterDate;
                // Check time if applicable
                const timeMatches = !this.filters.time ||
                (itemDateTime.getHours() === filterDateTime.getHours() &&
                itemDateTime.getMinutes() === filterDateTime.getMinutes());

                return dateMatches && timeMatches;
            });
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
        openFileDialog() {
        this.dialog = true;
        },
        formatTime() {
            // Ensure that the input value is always formatted as 'HH:mm'
            this.filters.time = this.formattedTime;
        },
        clearFilters() {
            this.filters.date = '';
            this.filters.time = '';
        },
        handleFileUpload(event) {
            this.file = event.target.files[0];
        // Perform further processing with the uploaded CSV file
        },
        upload() {
            const formData = new FormData();
            formData.append('file', this.file);
            console.log(this.file)
            axios.post('/api/Log/clientLog/upload-file', formData)
            .then(res => {
                console.log(res.data)
                setTimeout(function() {
                        alert('Uploaded successfuly...');
                }, 3000);
            })
            this.dialog = false;
            setTimeout(function() {
                        window.location.reload();
            }, 4000);
        },
        getData() {
            axios.get('/api/Log/clientLog/getData')
            .then(response => {
                if (response.data && Array.isArray(response.data.data)) {
                    this.datas = response.data.data;
                    console.log(this.datas);
                } else {
                    console.log('Invalid data structure received from the server');
                }
            })
            .catch(error => {
                console.log(error);
            })
        },
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


