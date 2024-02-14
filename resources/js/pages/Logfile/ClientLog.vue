<template>
    <v-container fluid grid-list-xl>
        <div class="d-flex flex-row mb-6">
            <v-card class="d-flex flex-row mb-0">
                <div class="ma-2 pa-2 " style="width:200px;">
                    <label for="atm_id">Date<a style="color: red;">*</a></label>
                    <v-text-field v-model="filters.date" class="pr-1" variant="outlined" label="" :disabled="NonData"
                        :rules="[v => !!v || 'Date is required']" required density="compact" color="blue"
                        autocomplete="false" type="date" />
                </div>
                <div class="ma-2 pa-2" style="width:200px;">
                    <label for="atm_id">From Time<a style="color: blue;">*</a></label>
                    <v-text-field v-model="filters.from_time" class="pr-1" label="" :value="formattedFromTime"
                        :disabled="NonData" variant="outlined" outlined density="compact" color="blue" autocomplete="false"
                        type="time" @input="formatTime"/>
                </div>
                <div class="ma-2 pa-2" style="width:200px;">
                    <label for="atm_id">To Time<a style="color: blue;">*</a></label>
                    <v-text-field v-model="filters.to_time" class="pr-1" label="" :value="formattedToTime"
                        :disabled="NonData" variant="outlined" required outlined density="compact" color="blue"
                        autocomplete="false" type="time" @input="formatTime" />
                </div>
                <div class="mt-8 pa-3 d-flex me-auto">
                    <v-btn @click="clearFilters" color="indigo-darken-1" :disabled="NonData">Clear</v-btn>
                </div>
            </v-card>
            <div class="ml-2">
                <v-card subtitle="Search Option">
                    <v-radio-group v-model="choose" inline :disabled="NonData">
                        <v-radio class="ma-2" label="Scan" value="scan"></v-radio>
                        <v-radio class="ma-2" label="Device Status" value="device"></v-radio>
                        <div class="ma-2 pa-3">
                            <v-btn class="pa-2" color="indigo-darken-1" @click="searchData"
                                :disabled="searchDisabled || NonData">Search</v-btn>
                        </div>
                    </v-radio-group>
                </v-card>
            </div>
        </div>
        <div class="ma-0 pb-2">
            <v-row class="d-flex justify-end">
                <v-col>
                    <div class="ma-2 pa-3">
                        <v-dialog v-model="dialog" persistent width="400">
                            <template v-slot:activator="{ props }">
                                <v-btn type="submit" color="green" prepend-icon="mdi-file-import" v-bind="props">
                                    import
                                </v-btn>
                            </template>
                            <v-card>
                                <v-card-title>
                                    <span class="text-h5">Import file</span>
                                </v-card-title>
                                <v-card-text>
                                    <v-container>
                                        <v-file-input label="File input" variant="outlined" accept=".txt"
                                            @change="handleFileUpload" :loading="isUploading"></v-file-input>
                                    </v-container>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="grey" variant="flat" @click="dialog = false">
                                        Close
                                    </v-btn>
                                    <v-btn color="blue-darken-1" variant="flat" @click="upload">
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </div>
                </v-col>
                <v-col cols="12" sm="4" md="4">
                    <v-select v-model="time" label="Times" :items="list_time" variant="solo" item-title="time"
                        :disabled="NonData" density="comfortable" clearable @update:modelValue="handleTimeChange">
                    </v-select>
                </v-col>
            </v-row>
        </div>
        <span v-if="shouldDisplayContent">
            <v-card class="rounded-0 mx-auto">
                <v-data-table v-model:search="search" :headers="headers" :items="filteredData" class="elevation-1 table"
                    item-value="name">
                    <template v-slot:top>
                        <v-toolbar flat>
                            <v-spacer></v-spacer>
                            <v-text-field class="ma-2 search" v-model="search" density="compact" variant="solo"
                                append-inner-icon="mdi-magnify" label="Search" hide-details></v-text-field>
                        </v-toolbar>
                    </template>
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
        <v-dialog v-model="dialog1">
            <div class="text-center">
                <v-progress-circular :size="70" :width="7" color="primary" indeterminate></v-progress-circular>
            </div>
        </v-dialog>
    </v-container>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        dialog1: false,
        file: null,
        choose: '',
        time: null,
        isUploading: false,
        expanded: [],
        headers: [
            {
                title: 'Date',

                width: '70px',
                key: 'date',
            },
            { title: 'Time',  key: 'time', width:'70px'},
            { title: 'Thread',  key: 'thread',width:'70px' },
            { title: 'Code', key: 'code',width:'30px' },
            { title: 'Message', key: 'log_message', width:'30%'},
        ],
        datas: [],
        search_data: [],
        search: '',
        filters: {
            date: '',
            from_time: '',
            to_time: '',
        },
        list_time: [
            { title: 'time' }
        ],
        list_device: [],
        filteredData: [], // Store filtered data
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
            let filteredData = [];

            // Check if search_data is available and push it to filteredData if so
            if (this.search_data) {
                filteredData.push(...this.search_data);
            }

            // Check if list_device is available and push it to filteredData if so
            if (this.list_device) {
                filteredData.push(...this.list_device);
            }

            // If neither search_data nor list_device is available, filter datas and push filtered items to filteredData
            if (this.filters.from_time) {
                filteredData = this.datas.filter(item => {
                    const itemDateTime = new Date(`${item.date} ${item.time}`);
                    const filterFromDateTime = new Date(`${this.filters.date} ${this.filters.from_time}`);
                    const filterToDateTime = new Date(`${this.filters.date} ${this.filters.to_time}`);

                    // Format dates to compare
                    const itemDate = itemDateTime.toLocaleDateString();

                    // Check date if applicable
                    const dateMatches = !this.filters.date ||
                        itemDate === filterFromDateTime.toLocaleDateString() ||
                        itemDate === filterToDateTime.toLocaleDateString();

                    // Check time if applicable
                    const fromTimeMatches = !this.filters.from_time || itemDateTime >= filterFromDateTime;
                    const toTimeMatches = !this.filters.to_time || itemDateTime <= filterToDateTime;

                    return dateMatches && fromTimeMatches && toTimeMatches;
                });
            }

            return filteredData;

        },

        displayedData() {
            return this.search_data;
        },

        formattedFromTime() {
            // Extract 'HH:mm' from the time string
            const timeParts = this.filters.from_time.split(':');
            return timeParts.slice(0, 2).join(':');
        },
        formattedToTime() {
            // Extract 'HH:mm' from the time string
            const timeParts = this.filters.to_time.split(':');
            return timeParts.slice(0, 2).join(':');
        },

        NonData() {
            return this.datas.length === 0;
        },

        searchDisabled() {
            // Disable search button if either 'from_time' or 'to_time' is not selected
            return this.filters.from_time || this.filters.to_time;
        }

    },

    methods: {
        openFileDialog() {
            this.dialog = true;
        },
        formatTime() {
            // Ensure that the input value is always formatted as 'HH:mm'
            this.filters.from_time = this.formattedFromTime;
            this.filters.to_time = this.formattedToTime;
        },
        clearFilters() {
            this.filters.date = '';
            this.filters.from_time = '';
            this.filters.to_time = '';
            this.choose = '';
            this.time = '';
            this.search_data = '';
            this.list_device = '';
            this.list_time = '';
        },
        handleFileUpload(event) {
            this.file = event.target.files[0];
        },
        upload() {
            const formData = new FormData();
            formData.append('file', this.file);
            console.log(this.file)
            this.dialog1 = true,
                axios.post('/api/Log/clientLog/upload-file', formData)
                    .then(res => {
                        console.log(res.status)
                        if(res.status==200){
                            this.dialog1 = false;
                        }
                        setTimeout(function () {
                            alert('Uploaded successfuly...');
                        });
                    })
            this.dialog = false;
                setTimeout(function() {
                        window.location.reload();
                    }, 5000);
        },

        getData() {
            this.dialog1 = true;
            axios.get('/api/Log/clientLog/getData')
                .then(response => {
                    if (response.data && Array.isArray(response.data.data)) {
                        this.datas = response.data.data;
                        this.dialog1 = false;
                    } else {
                        console.log('Invalid data structure received from the server');
                    }
                })
                .catch(error => {
                    console.log(error);
                })
        },

        searchData() {
            if (this.choose === 'scan') {
                axios.post('/api/Log/clientLog/list-qr', { date: this.filters.date })
                    .then(res => {
                        if (!res.data.data || res.data.data.length === 0) {
                            alert("Data is empty!");
                        } else {
                            this.list_time = res.data.data;
                            console.log(this.list_time);
                            alert("Now, you can select time!");
                        }
                    })
                    .catch(err => {
                        console.log(err);
                    });

            }
            else if (this.choose === 'device') {
                Promise.all([
                    axios.post('/api/Log/clientLog/device-time', { date: this.filters.date }),
                    axios.post('/api/Log/clientLog/list-device', { date: this.filters.date })
                ])
                    .then(([deviceRes, listRes]) => {
                        if (deviceRes.data.data.length === 0 || listRes.data.data.length === 0) {
                            // If either deviceRes.data.data or listRes.data.data is empty
                            alert("Data is empty!");
                        } else {
                            this.list_device = deviceRes.data.data;
                            this.list_time = listRes.data.data;
                            alert("If you want detail time. Please select time!")
                        }

                    })
                    .catch(err => {
                        console.log(err);
                    });
            }
            else {
                alert("Please select Search Option!");
            }
        },

        handleTimeChange() {
            const endpoint = this.choose === 'scan' ? '/api/Log/clientLog/qrServer' : '/api/Log/clientLog/search-device';

            axios.post(endpoint, { time: this.time, date: this.filters.date })
                .then(response => {
                    this.search_data = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                })
        }
    },
}
</script>

<style>
.table td {
    font-size: x-small !important;
    height: 0 !important;
    /* padding: 1px!important; */
}

.table th {
    font-size: small !important;
    height: 0 !important;
    background-color: #3c519c !important;
    color: white !important;
    border: 0.1px solid rgb(230, 228, 228) !important;
}

.table td {
    border: 0.1px solid rgb(230, 228, 228) !important;
    border-collapse: collapse !important;
}

.see-more-link {
    color: blue;
    cursor: pointer;
    text-decoration: underline;
}

/* add */


</style>


