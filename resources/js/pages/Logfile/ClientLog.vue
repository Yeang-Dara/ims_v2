<template>
    <v-container fluid grid-list-xl>
        <div class="d-flex flex-row mb-6">
            <div class="ma-2 pa-2 d-flex" style="width:200px;">
                <v-select
                    label="Issue Type"
                    v-model="filters.issue"
                    :items="issues"
                    clearable
                    variant="solo"
                    density="compact"
                >
                </v-select>
            </div>
            <div class="ma-2 pa-2 d-flex me-auto" style="width:200px;">
                <v-select
                    label="Alias ATM ID"
                    v-model="filters.terminal_id"
                    :items="terminals"
                    clearable
                    variant="solo"
                    density="compact"
                >
                </v-select>
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
                                <v-file-input label="File input" variant="outlined" accept=".csv" @change="handleFileUpload"></v-file-input>
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
                            @click="importCsv"
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
           :custom-filter="customFilter"
           :headers="headers"
           :items="Tickets"
           :search="search"
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
            title: 'Ticket ID',
            align: 'start',
            sortable: false,
            key: 'ticket_id',
          },
          { title: 'ATM ID', align: 'start', key: 'atm_id'},
          { title: 'Alias ATM ID', align: 'start', key: 'terminal_id'},
          { title: 'ATM Type', align: 'start', key: 'atm_type'},
          { title: 'Diagnosis', align: 'start', key: 'diagnosis'},
          { title: 'Call Date', align: 'start', key: 'created_time'},
          { title: 'Issue Type', align: 'start', key: 'issue'},
          { title: '', key: 'data-table-expand' }
        ],
        tickets: [],
        search: '',
        filters: {
            issue: '',
            terminal_id: '',
        },
     }),
     computed: {
        Tickets() {
            // search
            if (this.search) {
                let searchRegex = new RegExp(this.search, 'i');
                this.tickets = this.tickets.filter(item => searchRegex.test(item.atm_id) || searchRegex.test(item.atm_type));
            }
            // filter
            if(!this.filters.issue  && !this.filters.terminal_id) {
                return this.tickets;
            }
            else if (this.filters.issue) {
                return this.tickets.filter(item => item.issue=== this.filters.issue);
            }
            else {
                return this.tickets.filter(item => item.terminal_id=== this.filters.terminal_id);
            }
        },
     },
     created() {
        this.getTickets();
    },
     methods: {
        handleFileUpload(event) {
            this.file = event.target.files[0];
        // Perform further processing with the uploaded CSV file
        },
        importCsv() {
            const formData = new FormData();
            formData.append('file', this.file);
            console.log(this.file)
            axios.post('/api/ticket/import', formData)
            .then(res => {
                console.log(res.data)
                setTimeout(function() {
                        alert('Uploaded successfuly...');
                }, 3000);
            })
            this.dialog = false;
        },
        getTickets() {
            axios.get('/api/tickets')
                .then(response => {
                    this.tickets = response.data;
                    // console.log(this.tickets);
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
        font-size: small!important;
        height: 0!important;
        /* padding: 1px!important; */
    }

    .table th{
        font-size: small!important;
        height: 0!important;
        background-color: #3c519c!important;
        color: white!important;
    }

    .table td {
        border: 0.1px solid rgb(230, 228, 228)!important;
        border-collapse: collapse!important;
    }
</style>


