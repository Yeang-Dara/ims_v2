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
                <v-btn color="green" class="ma-2 pa-2" prepend-icon="mdi-file-export">
                        export
                </v-btn>
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
            <template v-slot:expanded-row="{ item }">
                    <tr>
                    <th :colspan="2" class="text-center">
                        Time Create
                    </th>
                    <th :colspan="4" class="text-center">
                        Action Taken
                    </th>
                    <th :colspan="2" class="text-center">
                        ATM Down
                    </th>
                </tr>
                <tr>
                    <td :colspan="2" class="text-center">
                        {{ item.raw.created_time }}
                    </td>
                    <td :colspan="4">
                        {{ item.raw.action_taken }}
                    </td>
                    <td :colspan="2" class="text-center">
                        {{ item.raw.atm_down}}
                    </td>
                </tr>
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
        issues: [
            'Application Error',
            'Camera Error',
            'Camera Issue',
            'Card Jammed',
            'Card Reader Error',
            'Cash Rejected and Torn',
            'Cash stack',
            'Connection Error',
            'EPP Error',
            'Error amount',
            'Error Cassette',
            'Feed Wheel Spoil',
            'FIL Error',
            'Unable to open safe door',
            'PC Error',
            'Picker Error',
            'PM',
            'Receipt jam',
            'Restore image firmware',
            'Safe door',
            'Shutter Error',
            'Show Black Screen',
            'Stacker Error',
            'Stuck Screen',
            'error cant deposit'
        ],
        terminals: [
            "AE3ATM01",
            "AE3CRM01",
            "AMKATM89",
            "AMKATM90",
            "ANSVSR-C001",
            "ASNASN-A001",
            "ASNCPV-A001",
            "ASNTAN1-A001",
            "ASNTAN2-A001",
            "ASNVSR-A001",
            "ATM00001",
            "ATMSHA1-A001",
            "ATMSHA2-A001",
            "BKATM001",
            "BKCRM001",
            "BKMSTD-A001",
            "BMCBMC-A001",
            "BMCCRM01",
            "BMCPOP-A001",
            "BTBBTB-C001",
            "BTBCRM01",
            "BTBPSN-A001",
            "BTIBTI-A001",
            "CCM1280003",
            "CCM1280004",
            "CCM1280005",
            "CCM1280006",
            "CCM1280007",
            "CCM1280008",
            "CCM1280008",
            "CCM1280009",
            "CCM1280010",
            "CCM1280011",
            "CCM1280012",
            "CCM1280013",
            "CCM1280014",
            "CCM1280015",
            "CCM1280016",
            "CCM1280017",
            "CCM1280018",
            "CCM1280019",
            "CCM1280020",
            "CCM1280021",
            "CCM1280022",
            "CCM1280023",
            "CCM1280024",
            "CCVDCF-A001",
            "CCVLKH-A001",
            "CRM00001",
            "IMATM001",
            "IMCRM001",
            "KADKAD-A001",
            "KCHKCH-A001",
            "KCHMDT-A001",
            "KHHKHH-A001",
            "KOKKOK-A001",
            "KPCCRM01",
            "KPSKPS-A001",
            "KPTCHH-A001",
            "KPTKPT-A001",
            "KPTKTR-A001",
            "KRTKRT-A001",
            "KSPKSP-A001",
            "KSVKSV-A001",
            "KTBKTB-A001",
            "KTHKTH-A001",
            "KTMKTM-A001",
            "MDKMDK-A001",
            "MEMMEM-A001",
            "MKPMKP-A001",
            "MRSMRS-A001",
            "OKDCRM01",
            "OMCOMC-A001",
            "PALPAL-A001",
            "PBCATM01",
            "PBCCRM01",
            "PDKIOM-A001",
            "PNPAEON1-C001",
            "PNPBBU-C001",
            "PNPBKM-A001",
            "PNPBKT-A001",
            "PNPBNC-C001",
            "PNPCAP-C001",
            "PNPCAR-A001",
            "PNPCCV-A001",
            "PNPCKD-C001",
            "PNPCKM-A001",
            "PNPDAK",
            "PNPEGN-C001",
            "PNPFFM-A001",
            "PNPGRM-A001",
            "PNPHAR-A001",
            "PNPMBC-A001",
            "PNPMTT-A001",
            "PNPNUM-C001",
            "PNPPDK-A001",
            "PNPPDK-C001",
            "PNPPEH-C001",
            "PNPPNP-A001",
            "PNPPNP-A002",
            "PNPPNP-C001",
            "PNPPPM-C001",
            "PNPPSC-A001",
            "PNPPSM-C001",
            "PNPRSK-A001",
            "PNPSMC-C001",
            "PNPSTM-C001",
            "PNPTKK-C001",
            "PPT Chbar Obpov",
            "PPT Prey Key",
            "PRHPRH-A001",
            "PRVPRV-A001",
            "PSCNRD-A001",
            "PSTPST-A001",
            "PSZATM01",
            "PSZCRM01",
            "PTT Kampong Chhnang",
            "PTT Phdao Chum 1",
            "PTT Phdao-Chum 2",
            "PTT Pich Nil",
            "PTT Prek Phnov",
            "PTT Seang Nam",
            "PTT Siem Reap",
            "PTT Takeo City",
            "PTT_Klaing Leu",
            "PUKPUK-A001",
            "RTKRTK-A001",
            "SHVATM01",
            "SHVCRM01",
            "SHVSHV-A001",
            "SKNSKN-A001",
            "SNGSNG-C001",
            "SRPNMK-A001",
            "SRPSRP-A001",
            "SSATM001",
            "SSCRM001",
            "STRSTR-A001",
            "SVRSVR-A001",
            "TAKATS-A001",
            "TAKTAK-A001",
            "TCATM001",
            "TCCRM001",
            "TKATM001",
            "TKCRM001",
            "TKOCRM01",
            "TTLHCF-A001",
            "TTLKFR-A001",
            "VSR371-A001",
            "VSRKMA-A001",
            "WPATM001",
            "WPCRM001"
        ],
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


