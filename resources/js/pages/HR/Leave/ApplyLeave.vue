<template>
    <v-container fluid grid-list-xl>
        <v-card rounded="lg" class="ml-10 mr-10 mb-5">
                <v-table>
                    <thead class="bg-indigo-accent-1">
                        <tr>
                            <th class="text-left text-white">
                            Leave Type
                            </th>
                            <th class="text-left text-white">
                            Leave Remaining
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(re, index) in remain" :key="index">
                        <td>{{ re.leave_name}}</td>

                        <td>{{ re.leave_balance}}</td>
                    </tr>
                    </tbody>
                </v-table>
        </v-card>
        <v-card>
            <v-form>
            <div class="pb-4">
                <v-card-title>Apply Leave</v-card-title>
            </div>

            <v-container>
                <v-form
                    v-model="form"
                    @submit.prevent="onSubmit(user)"
                >
                <v-row class="pt-2">
                    <v-col class="pb-0 py-0" cols="12" sm="4">
                        <label for="name">Employee Name<a style="color: red;">*</a></label>
                        <v-text-field
                        v-model="fullName"
                        type="name"
                        variant="outlined"
                        prepend-inner-icon="mdi-account"
                        required
                        ></v-text-field>
                    </v-col>
                    <v-col class="pb-0 py-0 " cols="12" sm="4">
                        <label for="accept_id">Reporting Line<a style="color:blue;">*</a></label>
                        <v-select
                        v-model="atten.accept_id"
                        :items="users"
                        :readonly="isLoading"
                        item-value="user_id"
                        item-title="full_name"
                        variant="outlined"
                        required
                        clearable
                        ></v-select>
                    </v-col>
                    <v-col class="pb-0 py-0 " cols="12" sm="4">
                        <label for="approve_id">Approver<a style="color: red;">*</a></label>
                        <v-select
                        v-model="atten.approve_id"
                        :items="dr"
                        type="name"
                        :readonly="isLoading"
                        item-value="user_id"
                        item-title="full_name"
                        variant="outlined"
                        required
                        clearable
                        ></v-select>
                    </v-col>
                    <v-col class="pb-0 py-0 " cols="12" sm="6">
                        <label for="leave_annual_id">Leave Type<a style="color: red;">*</a></label>
                        <v-select
                        v-model="atten.leave_annual_id"
                        :items="leaves"
                        :readonly="isLoading"
                        item-value="id"
                        item-title="leave_name"
                        variant="outlined"
                        :rules="[v => !!v || 'leave type is required']"
                        required
                        ></v-select>
                    </v-col>
                    <v-col class="pb-0 py-0 " cols="12" sm="6">
                        <label for="shiftime">Shift Time<a style="color: red;">*</a></label>
                        <v-select
                        v-model="atten.shiftime"
                        :items="days"
                        :readonly="isLoading"
                        variant="outlined"
                        required
                        ></v-select>
                    </v-col>
                    <v-col class="pb-0 py-0 " cols="12" sm="4">
                        <label for="date_request">Date Request<a style="color: red;">*</a></label>
                        <v-text-field
                        class="pr-1"
                        v-model="atten.date_request"
                        :readonly="isLoading"
                        variant="outlined"
                        :rules="[v => !!v || 'Start date is required']"
                        required outlined dense
                        color="blue" type="date"
                        :value="new Date().toISOString().substr(0, 10)"/>
                    </v-col>
                    <v-col class="pb-0 py-0 " cols="12" sm="4">
                        <label for="from_date">From<a style="color: red;">*</a></label>
                        <v-text-field
                        class="pr-1"
                        v-model="atten.from_date"
                        :readonly="isLoading"
                        variant="outlined"
                        :rules="[v => !!v || 'Start date is required']"
                        required outlined dense
                        color="blue" autocomplete="false" type="date" />
                    </v-col>
                    <v-col class="pb-0 py-0 " cols="12" sm="4">
                        <label for="to_date">To<a style="color: red;">*</a></label>
                        <v-text-field
                        class="pr-1"
                        v-model="atten.to_date"
                        :readonly="isLoading"
                        variant="outlined"
                        :rules="[v => !!v || 'Start date is required']"
                        required outlined dense
                        color="blue" autocomplete="false" type="date" />
                    </v-col>
                    <v-col class="pb-0 py-0 " cols="12" sm="6">
                        <label for="reason">Reason<a style="color: blue;">*</a></label>
                        <v-textarea
                            v-model="atten.reason"
                            variant="outlined"
                            :readonly="isLoading"
                            rows="2"
                            row-height="20"
                            autocomplete="false">
                        </v-textarea>
                    </v-col>
                    <v-col class="pb-0 py-0 " cols="12" sm="6">
                        <label for="attachment">File Input<a style="color: blue;">*</a></label>
                        <v-file-input
                            v-model="atten.attachment"
                            type="file"
                            accept="image/*"
                            variant="outlined"
                            :readonly="isLoading"
                            @change="onFileChange"></v-file-input>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-btn
                        color="blue"
                        class="me-4 font-weight-bold"
                        :disabled="!form"
                        :loading="isLoading"
                        type="submit"
                        >
                        submit
                        </v-btn>
                    </v-col>
                </v-row>
                </v-form>
            </v-container>
        </v-form>
        </v-card>

    </v-container>
</template>

<script>
import axios from 'axios';
// import leave from '../../services/api/leave'
// import Atten from '../../services/api/attendance'
// import Role from '../../services/api/role'
import { mapActions } from 'vuex';

export default {
    name: 'ApplyLeave',
    data: () => ({
        form: false,
        isLoading: false,
        errors: {},
        error: false,
        processing:false,
        users: [
            {title: 'full_name'}
        ],
        roles: [],
        atten: {
            user_id: '',
            accept_id: '',
            approve_id: '',
            leave_annual_id: '',
            date_request: new Date().toISOString().substr(0, 10),
            from_date: '',
            to_date: '',
            reason: '',
            shiftime: '',
            attachment: null,
        },
        leaves: [
            { title: 'leave_name' }
        ],
        days: ['Morning', 'Afternoon','Full Day'],
        remain: [],
        user: {},
        dr: [
            {title: 'full_name'}
        ],
        id: '',
        imageFile: null,
        imageUrl: null,
    }),
    computed: {
        fullName() {
            return this.user.last_name + ' ' + this.user.first_name;
        },
        NameFull() {
            return function(user) {
                return user.first_name + ' ' + user.last_name;
            }
        }
    },
    mounted() {
        this.getRole();
        this.getEmployee();
        this.getDirector();
        const token = localStorage.getItem("token");
        const auth = {
            headers: {
                Authorization: `Bearer ${token}`
            }
        };
        axios.get('/api/user', auth)
            .then(res => {
                this.user = res.data
                console.log(this.user);
                axios.post('/api/hr/HR/attendance/remaining/'+ this.user.id)
                // Atten.Remaining(this.user.id)
                .then(res => {
                    this.remain = res.data.data
                    console.log("remain", this.remain)
                })
                axios.get('/api/hr/HR/leave_annual/getLeaveStaff/'+ this.user.id)
                // leave.filterLeave(this.user.id)
                .then(res => {
                    this.leaves = res.data
                    console.log("test", this.leaves)
                }).catch(err=> {
                    console.log(err)
                })
            })
    },
    methods: {
        ...mapActions({
            createAtten: "attendances/createAtten",
            applyLeave: "attendances/applyLeave"
        }),

        onFileChange(event) {
            this.imageFile = event.target.files[0];
        },
        getEmployee() {
            axios.get('/api/hr/HR/role/Users')
            // Role.Users()
           .then(response => {
               this.users = response.data.data;
            //    console.log("users", this.users);
           })
           .catch(error => {
               if (error.response.status === 422) {
                   this.errors = error.response.data.errors;
               }
           })
        },

        getDirector(){
            axios.get('/api/hr/HR/role/Directors')
            // Role.Directors()
            .then(res => {
                this.dr = res.data.data;
            })
        },

        getRole() {
            axios.get('/api/hr/HR/role/listTable')
        //    Role.listTable()
           .then(response => {
               this.roles = response.data.data;
            //    console.log("role", this.roles);
           })
           .catch(error => {
               if (error.response.status === 422) {
                   this.errors = error.response.data.errors;
               }
           })
       },
            async onSubmit(user) {
                // const formData = new FormData();
                if (!this.form) return

                this.isLoading = true

                setTimeout(() => (this.isLoading = false), 2000)
                let i = {}
                this.atten.user_id = user.id
                i = this.atten
                try {
                    const formData = new FormData();
                    formData.append('attachment', this.imageFile);
                    formData.append('user_id', this.atten.user_id);
                    formData.append('leave_annual_id', this.atten.leave_annual_id);
                    formData.append('date_request', this.atten.date_request);
                    formData.append('from_date', this.atten.from_date);
                    formData.append('to_date', this.atten.to_date);
                    formData.append('approve_id', this.atten.approve_id);
                    formData.append('accept_id', this.atten.accept_id);
                    formData.append('reason', this.atten.reason);
                    formData.append('shiftime', this.atten.shiftime);

                    this.$swal({
                        title: "Are you sure?",
                        text: "Do you want to save record ?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "##DC143C",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes",
                    }).then((result) => {
                        if (result.value) {
                            this.applyLeave(formData);
                        }
                    }).catch(err => {
                        this.error=true
                        this.processing = false
                        console.log("create error", err);
                        this.$swal(
                            {
                                title: 'Oops',
                                text:"Fail, something went wrong!",
                                icon: 'error'
                            }
                        )
                    })
                } catch (error) {
                    console.error(error);
                }
            }

    }

}
</script>

<style scoped>

</style>
