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
                        :rules="[v => !!v || 'Date is required']"
                        required outlined dense
                        color="blue" autocomplete="false" type="date"
                        @input="filterData"
                        />
            </div>
            <div class="ma-2 pa-2 d-flex " style="width:200px;">
                <v-text-field
                v-model="filters.time"
                    class="pr-1"
                    label="Time"
                    :value="filters.time"
                    :readonly="isLoading"
                    variant="solo"
                    :rules="[v => !!v || 'Time is required']"
                    required outlined dense color="blue"
                    autocomplete="false"
                    type="time"
                    @input="filterData"
                />
            </div>
            <div class="ma-2 pa-2 d-flex me-auto">
                <v-btn @click="clearFilters" color="indigo-darken-1">Clear</v-btn>
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
                                <v-file-input label="File input" variant="outlined" accept=".txt" @change="handleFileUpload"></v-file-input>
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
          { title: 'Thread', align: 'start', key: 'thread'},
          { title: 'Code', align: 'start', key: 'code'},
          { title: 'Message', key: 'log_message'},
        ],
        datas: [],
        search: '',
        filters: {
            date: '',
            time: '',
        },
        filteredData: [], // Store filtered data
     }),
     created() {
        this.getData();
    },
     methods: {
        filterData() {
            const filterDateTime = new Date(`${this.filters.date} ${this.filters.time}`);

            this.filteredData = this.datas.filter(item => {
                const itemDateTime = new Date(`${item.date} ${item.time}`);
                return (
                (!this.filters.date || itemDateTime.toISOString().includes(this.filters.date)) &&
                (!this.filters.time || itemDateTime.toISOString().includes(this.filters.time))
                );
            });
        },
        clearFilters() {
            this.filters.date = '';
            this.filters.time = '';
            this.filteredData = this.datas;
        },
        handleFileUpload(event) {
            this.file = event.target.files[0];
        // Perform further processing with the uploaded CSV file
        },
        upload() {
            const formData = new FormData();
            formData.append('file', this.file);
            console.log(this.file)
            axios.post('/api/upload-file', formData)
            .then(res => {
                console.log(res.data)
                setTimeout(function() {
                        alert('Uploaded successfuly...');
                }, 3000);
            })
            this.dialog = false;
        },
        getData() {
            axios.get('/api/getData')
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
        customFilter(value, query, item) {
            if (!this.filters.issue) {
                return true;
            }
            else {
                return value.issue=== this.filters.issue;
            }
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


