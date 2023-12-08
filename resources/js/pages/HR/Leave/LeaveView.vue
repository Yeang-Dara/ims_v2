<template>
    <v-container fluid grid-list-xl>
        <div class="d-flex mb-6">
            <div class="ma-2 pa-2" style="width:200px;">
                    <v-select
                    v-model="filter.year"
                    label="Year"
                    density="compact"
                    :items="[2023, 2024]"
                    variant="solo"
                    clearable
                    ></v-select>
            </div>
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
            <div class="ma-2 pa-2 me-auto" style="width:300px;">
                <v-text-field
                    :loading="loading"
                    density="compact"
                    variant="solo"
                    label="Search a employee"
                    append-inner-icon="mdi-magnify"
                    single-line
                    hide-details
                    v-model="search"
                    @input="getAtten()"
                    @click:append-inner="onClick"
                ></v-text-field>
            </div>
            <div class="ma-2 pa-2">
                <v-menu open-on-hover>
                    <template v-slot:activator="{ props }">
                        <v-btn color="green" class="ma-2 pa-2" prepend-icon="mdi-file-export" v-bind="props">
                            export
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item color="primary" @click="generatePDFm(month)">
                            <v-list-item-title>Export to PDF By Month</v-list-item-title>
                        </v-list-item>
                        <!-- <v-list-item color="primary" @click="generatePDFy">
                            <v-list-item-title>Export to PDF By Year</v-list-item-title>
                        </v-list-item> -->
                        <v-list-item @click="Export">
                            <v-list-item-title>Export to CSV</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </div>

        </div>
        <v-card class="rounded-0" >
            <v-data-table
            :headers="headers"
            :items="filteredItems"
            :search="search"
            item-key="name"
            class="elevation-1 custom-table"
            >
            <template v-slot:item.name="{ item }">
                {{ item.raw.last_name }} {{ item.raw.first_name }}
            </template>
            <template v-slot:item.year="{ item}">
                {{ formatYear(item.raw.created_at) }}
            </template>
            <template v-slot:item.credit_sl="{ item }">
                <span v-if="item.raw.leave_id == 1">
                    {{ item.raw.credit_leave }}
                </span>
                <span v-else>
                    {{ 0 }}
                </span>
            </template>
            <template v-slot:item.credit_al="{ item }">
                <span v-if="item.raw.leave_id == 2">
                    {{ item.raw.credit_leave }}
                </span>
                <span v-else>
                    {{ 0 }}
                </span>
            </template>
            <template v-slot:item.credit_ul="{ item }">
                <span v-if="item.raw.leave_id == 3">
                    {{ item.raw.credit_leave }}
                </span>
                <span v-else>
                    {{ 0 }}
                </span>
            </template>
            <template v-slot:item.sl_token="{ item }">
                <span v-if="item.raw.leave_id == 1" class="text-red">
                    {{ item.raw.leaves_taken }}
                </span>
                <span v-else>
                    {{ 0 }}
                </span>
            </template>
            <template v-slot:item.al_token="{ item }">
                <span v-if="item.raw.leave_id == 2" class="text-red">
                    {{ item.raw.leaves_taken }}
                </span>
                <span v-else>
                    {{ 0 }}
                </span>
            </template>
            <template v-slot:item.ul_token="{ item }">
                <span v-if="item.raw.leave_id == 3" class="text-red">
                    {{ item.raw.leaves_taken }}
                </span>
                <span v-else>
                    {{ 0 }}
                </span>
            </template>
            <template v-slot:item.sl="{ item }">
                <span v-if="item.raw.leave_id == 1" class="text-blue">
                    {{ item.raw.leave_balance }}
                </span>
                <span v-else>
                    {{ 0 }}
                </span>
            </template>
            <template v-slot:item.al="{ item }">
                <span v-if="item.raw.leave_id == 2" class="text-blue">
                    {{ item.raw.leave_balance }}
                </span>
                <span v-else>
                    {{ 0 }}
                </span>
            </template>
            <template v-slot:item.ul="{ item }">
                <span v-if="item.raw.leave_id == 3" class="text-blue">
                    {{ item.raw.leave_balance }}
                </span>
                <span v-else>
                    {{ 0 }}
                </span>
            </template>
            </v-data-table>
        </v-card>
    </v-container>
</template>

<script>
// import Atten from '../../services/api/attendance'
import { excelParser} from './CSVFile'
import { generatePDF } from './PdfFileByMonth'

  export default {
    name: 'LeaveView',
    computed: {
        filteredItems() {
            if (this.search) {
            let searchRegex = new RegExp(this.search, 'i');
            this.attens = this.attens.filter(item => {
                return searchRegex.test(item.last_name) || searchRegex.test(item.first_name);
            });
}
            return this.attens.filter((item) => {
                const itemDate = new Date(item.month); // or whatever the date property is named
                const itemYear = new Date(item.created_at).getFullYear(); // extract the year from the date
                // const itemMonth = itemDate.getMonth(); // extract the month from the date (note: month is zero-indexed)
                return (
                    (!this.filter.start || itemDate >= new Date(this.filter.start)) && // check if start filter is not set or item date is greater than or equal to the start filter
                    (!this.filter.end || itemDate <= new Date(this.filter.end)) && // check if end filter is not set or item date is less than or equal to the end filter
                    (!this.filter.year || itemYear === this.filter.year) // compare the year to the filter value
                    // (!this.filter.month || itemMonth === parseInt(this.filter.month) - 1) // compare the month to the filter value
                );
            });
        },
    },
    data: () => ({
        loaded: false,
        loading: false,
        headers: [
            [
                {
                    title: 'Employee',
                    key: 'em',
                    align: 'center',
                    sortable: false,
                    colspan: 3,
                },
                {
                    title: 'Entitle Leave',
                    key: 'leave',
                    align: 'center',
                    sortable: false,
                    colspan: 3,
                },
                {
                    title: 'Taken Leave',
                    key: 'taken',
                    align: 'center',
                    sortable: false,
                    colspan: 3,
                },
                {
                    title: 'Balance',
                    key: 'balance',
                    align: 'center',
                    sortable: false,
                    colspan: 3,
                    variant:"secondary"
                },
            ],
            [
                    {
                    title: 'Name',
                    align: 'start',
                    sortable: false,
                    key: 'name',
                },
                { title: 'Department', align: 'center', key: 'sort_name', sortable: false, },
                // { title: 'Month', align: 'center', key: 'month' },
                { title: 'Year', align: 'center', key: 'year',sortable: false, },
                { title: 'SL', key: 'credit_sl' ,sortable: false,},
                { title: 'AL', key: 'credit_al',sortable: false, },
                { title: 'UL', key: 'credit_ul' ,sortable: false,},
                { title: 'SL', key: 'sl_token',sortable: false, },
                { title: 'AL', key: 'al_token', sortable: false, },
                { title: 'UL', key: 'ul_token' , sortable: false,},
                { title: 'SL', key: 'sl' , sortable: false,},
                { title: 'AL', key: 'al' , sortable: false,},
                { title: 'UL', key: 'ul', sortable: false, },
            ]
        ],
        depts: [],
        attens: [],
        leaves: null,
        data: [],
        filter: {
                year: null,
                month: null,
                start: null,
                end: null,
        },
        month: '',
    }),
    mounted() {
        // this.getAtten();
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth() + 1;

        this.month = `${currentYear}-${currentMonth.toString().padStart(2, '0')}-01`;
    },
    methods: {
        onClick () {
            this.loading = true

            setTimeout(() => {
            this.loading = false
            this.loaded = true
            }, 2000)
        },
        generatePDFm(item) {
            console.log(item)
            Atten.month_export(item)
                .then((response) => {
                    const data = response.data.data;
                    console.log('data', data);
                    // Add content to the PDF
                    generatePDF(data);
                })
                .catch((error) => {
                    if (error.response) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        Export() {
            Atten.leaveView()
                .then((response) => {
                    const data = response.data.data;
                    console.log(data);
                    excelParser().exportDataFromJSON(data, null, null);
                })
                .catch((error) => {
                if (error.response) {
                    this.errors = error.response.data.errors;
                }
                });
        },
        getAtten() {
            Atten.leaveView()
            .then(res => {
                this.attens = res.data.data;
                console.log("attendance", this.attens);
            })
        },
        formatMonth(dateString) {
            const d = new Date(dateString)
            return d.toLocaleString('default', { month: 'long' })
        },
        formatYear(dateString) {
            const d = new Date(dateString)
            return d.getFullYear()
        },

        Pdf() {
            this.$router.push('/pdf');
        }
    },
  };
</script>

<style>
.custom-table th{
    border: 0.1px solid rgb(230, 228, 228);
    border-collapse: collapse;
    background-color: #f2f2ff!important;
    color: rgb(7, 7, 7)!important;
}

.custom-table td {
    border: 0.1px solid rgb(230, 228, 228);
    border-collapse: collapse;
}

.custom-table thead {
    border: 0.1px solid rgb(230, 228, 228);
}

</style>
