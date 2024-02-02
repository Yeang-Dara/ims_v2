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
            <div class="ma-2 pa-2" style="width:200px;">
                <v-text-field
                    v-model="filters.from_time"
                    class="pr-1"
                    label="From Time"
                    :value="formattedFromTime"
                    :disabled="NonData"
                    :readonly="isLoading"
                    variant="solo"
                    :rules="[v => !!v || 'Time is required']"
                    required
                    outlined
                    density="compact"
                    color="blue"
                    autocomplete="false"
                    type="time"
                    @input="formatTime"
                />
            </div>
            <div class="ma-2 pa-2 d-flex " style="width:200px;">
                <v-text-field
                    v-model="filters.to_time"
                    class="pr-1"
                    label="To Time"
                    :value="formattedToTime"
                    :disabled="NonData"
                    :readonly="isLoading"
                    variant="solo"
                    :rules="[v => !!v || 'Time is required']"
                    required
                    outlined
                    density="compact"
                    color="blue"
                    autocomplete="false"
                    type="time"
                    @input="formatTime"
                />
            </div>
            <div class="ma-2 pa-2 d-flex me-auto">
                <v-btn @click="clearFilters" color="indigo-darken-1" :disabled="NonData">Clear</v-btn>
            </div>
            <div class="ma-2 pa-2">
                <v-dialog v-model="dialog" persistent width="400">
                    <template v-slot:activator="{ props }">
                        <v-btn type="submit" color="green" class="ma-2 pa-2"  prepend-icon="mdi-file-import" v-bind="props">
                            import
                        </v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="text-h5">Import file</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-file-input label="File input" variant="outlined" accept=".txt" @change="handleFileUpload" :loading="isUploading"></v-file-input>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="grey"
                            variant="flat"
                            @click="dialog = false"
                        >
                            Close
                        </v-btn>
                        <v-btn
                            color="blue-darken-1"
                            variant="flat"
                            @click="upload"
                        >
                            Save
                        </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
    </div>
    <span v-if="shouldDisplayContent">
        <v-card class="rounded-0 mx-auto" >
           <v-data-table
            v-model:search="search"
            :headers="headers"
            :items="filteredData"
            class="elevation-1 table"
            item-value="name"
           >
            <template v-slot:top>
                <v-toolbar
                flat
                >
                <v-spacer></v-spacer>
                <v-text-field
                    class="ma-2 search"
                    v-model="search"
                    density="compact"
                    variant="solo"
                    append-inner-icon="mdi-magnify"
                    label="Search"
                    hide-details
                ></v-text-field>
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
        <v-dialog v-model="dialog1" >
            <div class="text-center">
                <v-progress-circular
                :size="70"
                :width="7"
                color="primary"
                indeterminate
            ></v-progress-circular>
            </div>
           
        </v-dialog>
    </v-container>
 </template>

 <script>
   export default {
     data: () => ({
        dialog: false,
        dialog1:false,
        file: null,
        isUploading:false,
        expanded: [],
        headers: [
            {
            title: 'Date',
            align: 'start',
            width: '150px',
            key: 'date',
          },
          { title: 'Time', align: 'start', key: 'time'},
          { title: 'Thread', align: 'start', key: 'thread'},
          { title: 'Code', align: 'start', key: 'code'},
          { title: 'Message', key: 'log_message'},
        ],
        datas: [],
        search: '',
        filters: {
            date: '',
            from_time: '',
            to_time: '',
        },
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
            return this.datas.filter(item => {
                // const itemDateTime = new Date(`${item.date} ${item.time}`);
                // const filterDateTime = new Date(`${this.filters.date} ${this.filters.time}`);

                //   // Format dates to compare
                // const itemDate = itemDateTime.toLocaleDateString();
                // const filterDate = filterDateTime.toLocaleDateString();
                // // Check date if applicable
                // const dateMatches = !this.filters.date || itemDate === filterDate;
                // // Check time if applicable
                // const timeMatches = !this.filters.time ||
                // (itemDateTime.getHours() === filterDateTime.getHours() &&
                // itemDateTime.getMinutes() === filterDateTime.getMinutes());

                // return dateMatches && timeMatches;
                const itemDateTime = new Date(`${item.date} ${item.time}`);
                const filterStartDateTime = new Date(`${this.filters.date} ${this.filters.from_time}`);
                const filterEndDateTime = new Date(`${this.filters.date} ${this.filters.to_time}`);

                // Check if itemDateTime is within the specified time range
                const isWithinRange = !this.filters.startTime || !this.filters.endTime ||
                    (itemDateTime >= filterStartDateTime && itemDateTime <= filterEndDateTime);

                return isWithinRange;
            });
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
            this.dialog1=true,
            axios.post('/api/Log/clientLog/upload-file', formData)
            .then(res => {
                console.log(res.data)
                this.dialog1=false,
                setTimeout(function() {
                        alert('Uploaded successfuly...');
                },3000);
             
            })
            this.dialog = false;
            this.getData();
    
        },
        getData() {
            this.dialog1= true;
            axios.get('/api/Log/clientLog/getData')
            .then(response => {
                if (response.data && Array.isArray(response.data.data)) {
                    this.datas = response.data.data;
                    console.log(this.datas);
                    this.dialog1 = false;
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
        font-size: x-small!important;
        height: 0!important;
        /* padding: 1px!important; */
    }

    .table th{
        font-size: small!important;
        height: 0!important;
        background-color: #3c519c!important;
        color: white!important;
        border: 0.1px solid rgb(230, 228, 228)!important;
    }

    .table td {
        border: 0.1px solid rgb(230, 228, 228)!important;
        border-collapse: collapse!important;
    }

    .see-more-link {
        color: blue;
        cursor: pointer;
        text-decoration: underline;
    }
</style>


