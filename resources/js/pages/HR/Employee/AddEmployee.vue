<template>
    <v-container fluid grid-list-xl>
        <v-card color="#E8EAF6">
        <v-form ref="form" @submit.prevent="submitHandler" >
            <v-card-title>Create New Employee</v-card-title>
            <v-container>
                <v-row>
                    <v-col cols="12" sm="4">
                        <v-text-field
                        v-model="user.last_name"
                        :rules="lastnNameRules"
                        label="Last Name"
                        variant="solo"
                        prepend-inner-icon="mdi-account"
                        required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-text-field
                        v-model="user.first_name"
                        :rules="FirstnameRules"
                        label="First Name"
                        variant="solo"
                        prepend-inner-icon="mdi-account"
                        required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-text-field
                        v-model="user.name"
                        :rules="UsernameRules"
                        label="User Name"
                        variant="solo"
                        prepend-inner-icon="mdi-account"
                        required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-radio-group
                            v-model="user.gender"
                            :rules="[rules.gender]"
                            inline
                            >
                            <v-radio
                                label="Male"
                                value="Male"
                                color="blue"
                            ></v-radio>
                            <v-radio
                                label="Female"
                                value="Female"
                                color="blue"
                            ></v-radio>
                        </v-radio-group>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-select
                        v-model="user.family_status"
                        :items="status"
                        item-value="id"
                        item-title="dept_name"
                        label="Family Status"
                        variant="solo"
                        required
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                        v-model="user.password"
                        :rules="passwordRules"
                        label="Password"
                        variant="solo"
                        :append-inner-icon="visible ? 'mdi-eye' : 'mdi-eye-off'"
                        :type="visible ? 'text' : 'password'"
                        prepend-inner-icon="mdi-lock"
                        required
                        @click:append-inner="visible = !visible"
                        ></v-text-field>
                        <div class="error" v-if="errors.password">
                            {{ errors.password }}
                        </div>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="user.con_password"
                            label="Confirm Password"
                            variant="solo"
                            prepend-inner-icon="mdi-lock"
                            :rules="[v => user.password === v || 'Passwords do not match']"
                            :type="showConfirmPassword ? 'text' : 'password'"
                            :append-inner-icon="showConfirmPassword ? 'mdi-eye' : 'mdi-eye-off'"
                            @click:append="showConfirmPassword = !showConfirmPassword"
                            required
                        ></v-text-field>
                        <div class="error" v-if="errors.password">
                            {{ errors.password}}
                         </div>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                        v-model="user.email"
                        label="E-mail"
                        variant="solo"
                        prepend-inner-icon="mdi-email"
                        required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                        <v-text-field
                        v-model="user.phone"
                        :rules="[rules.phone]"
                        label="Phone"
                        variant="solo"
                        @input="formatPhoneNumber"
                        prepend-inner-icon="mdi-phone"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12">
                        <v-text-field
                            v-model="user.address"
                            :rules="[v => !!v || 'Address is required']"
                            label="Address"
                            prepend-inner-icon="mdi-map-marker"
                            variant="solo"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-text-field
                        class="pr-1"
                        label="Start Date"
                        v-model="user.start_date"
                        variant="solo"
                        :rules="[v => !!v || 'Start date is required']"
                        autocomplete="false"
                        required outlined dense
                        type="date" />
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-select
                        v-model="user.dept_id"
                        :rules="[v => !!v || 'Department is required']"
                        :items="depts"
                        item-value="id"
                        item-title="dept_name"
                        label="Department"
                        variant="solo"
                        required
                        ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-select
                        v-model="user.role_id"
                        :items="roles"
                        item-value="id"
                        item-title="role_name"
                        label="Position"
                        variant="solo"
                        required
                        ></v-select>
                    </v-col>
                </v-row>
            </v-container>
            <v-divider></v-divider>
            <v-card-title>Family Information</v-card-title>
            <v-container>
                <v-row>
                <v-col cols="12" sm="6">
                        <v-text-field
                        v-model="user.family_phone"
                        :rules="[rules.phone]"
                        label="Family Phone Number"
                        variant="solo"
                        @input="formatPhoneNumber"
                        prepend-inner-icon="mdi-phone"
                        ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                        <v-text-field
                        v-model="user.family_name"
                        label="Family Name"
                        variant="solo"
                        prepend-inner-icon="mdi-account"
                        required
                        ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                        <v-text-field
                        v-model="user.family_member"
                        label="Family Member"
                        variant="solo"
                        prepend-inner-icon="mdi-account"
                        required
                        ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                        <v-btn
                        color="blue"
                        class="me-4"
                        type="submit"
                        @click="add"
                        >
                        submit
                        </v-btn>
                </v-col>
            </v-row>
            </v-container>
        </v-form>
    </v-card>
    </v-container>
</template>

<script>
import axios from 'axios';
import { mapActions, mapGetters } from 'vuex';
// import Staff from '../../services/api/employee'
// import Dept from '../../services/api/department'
// import Role from '../../services/api/role'

export default {
    name: 'AddEmployee',
    data: () => ({
      visible: false,
      showConfirmPassword: false,
      errors: [],
      error: false,
      phoneNumberError: '',
      processing:false,
      user: {
        name: '',
        last_name: '',
        password: '',
        con_password: '',
        email: '',
        phone: '',
        address: '',
        start_date: '',
        dept_id: null,
        role_id: null,
        gender: '',
        family_member: '',
        family_name: '',
        family_phone: '',
        family_status: ''
      },
      depts: [
        {title: 'dept_name'}
      ],
      roles: [
      {title: 'role_name'}
      ],
      status: [
        'Single',
        'Married',
      ],
      passwordRules: [
                v => !!v || 'Password is required',
                v => (v && v.length >= 6) || 'Password must be 6  characters or more!',
        ],
        lastnNameRules: [
            v => !!v || 'Last Name is required',
            v => (v && v.length <= 10) || 'Last Name must be less than 10 characters',
            v => (v && /[^0-9]/.test(v)) || 'Last name can not contain digits.'
        ],
      FirstnameRules: [
            v => !!v || 'Fist Name is required',
            v => (v && /[^0-9]/.test(v)) || 'Last name can not contain digits.',
            v => (v && v.length <= 20) || 'First name must be less than 10 characters',
        ],
        UsernameRules: [
            v => !!v || 'User Name is required',
            v => (v && /[^0-9]/.test(v)) || 'Last name can not contain digits.',
            v => (v && v.length <= 20) || 'User name must be less than 20 characters',
        ],
        rules: {
            email: v => !!(v || '').match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/) || 'Please enter a valid email',
            gender: v => !!v || 'Gender is required',
            length: len => v => (v || '').length >= len || `Invalid character length, required ${len}`,
            password: v => !!(v || '').match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/) ||
            'Password must contain an upper case letter, a numeric character, and a special character',
            required: v => !!v || 'This field is required',
            // phone: v => !!(v || '').match(/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{3})$/) || 'Phone number needs to be at least 9 digits.',
            phone: v => {
                const phoneNumberPattern = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{3})$/;
                const phoneNumberPattern2 = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

                if (phoneNumberPattern.test(v) || phoneNumberPattern2.test(v)) {
                    return true;
                } else if (!v) {
                    return 'Phone number is required.';
                } else if (v.length < 9) {
                    return 'Phone number needs to be at least 9 digits.';
                } else {
                    return 'Phone number is not valid.';
                }
            }
        },
    }),
    computed: {
        userName() {
            return `${this.user.first_name}${this.user.last_name.charAt(0).toLowerCase()}`
        },
        fullName() {
            return `${this.user.first_name}${this.user.last_name.charAt(0).toLowerCase()}`
        }
    },
    watch: {
        userName() {
            this.user.name = this.userName;
        },
        fullName() {
            this.user.email = `${this.fullName.toLowerCase()}@btipayments.com.sg`;
        }
    },
    mounted() {
      this.FilterDept();
      this.FilterRole();
    },
    methods: {
        ...mapActions('employees', ['createEmployee']),
        formatPhoneNumber() {
            let formattedValue = this.user.phone.replace(/\D/g, ''); // Remove non-digit characters
            let formattedFamilyPhone = this.user.family_phone.replace(/\D/g, ''); // Remove non-digit characters

            if (formattedValue.length >= 9) {
                formattedValue = formattedValue.replace(/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{3})$/, '$1 $2 $3');
            }
            if (formattedValue.length <= 10) {
                formattedValue = formattedValue.replace(/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/, '$1 $2 $3');
            }

            if (formattedFamilyPhone.length >= 9) {
                formattedFamilyPhone = formattedFamilyPhone.replace(/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{3})$/, '$1 $2 $3');
            }
            if (formattedFamilyPhone.length <= 10) {
                formattedFamilyPhone = formattedFamilyPhone.replace(/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/, '$1 $2 $3');
            }

            this.user.phone = formattedValue;
            this.user.family_phone = formattedFamilyPhone;
        },
        FilterDept() {
            axios.get('/api/hr/HR/department/Deptall').then(res => {
                this.depts = res.data.data
                console.log("test", this.depts)
            }).catch(err=> {
                console.log(err)
            })
        },
        FilterRole() {
            axios.get('/api/hr/HR/role/listTable').then(res => {
                this.roles = res.data.data
                console.log("role", this.roles)
            }).catch(err=> {
                console.log(err)
            })
        },
        hide_success: function (event) {
            window.setInterval(() => {
                this.error = false;
            }, 10000)
        },
        validate() {
          if (this.$refs.form.validate()) {
            this.snackbar = true;
          }
        },
        submitHandler(){
            if (this.$refs.form.validate()){
                this.loading = true
            setTimeout(()=> {
                this.loading = false
            },1000)
            }
        },
        add() {
            this.processing = true
            // console.log(this.user)
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
                    this.error = false;
                    this.createEmployee(this.user)
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
        },
        validate() {
          if (this.$refs.form.validate()) {
            this.snackbar = true;
          }
        },
        submitHandler(){
        if (this.$refs.form.validate()){
            this.loading = true
          setTimeout(()=> {
            this.loading = false
          },1000)
        }
      }
    }
}
</script>

<style>
::v-deep .v-alert {
  width: 300px;
  margin-top: 20px;
  position: fixed;
  right: 0%;
  z-index: 1;
  top: 50px;

}
</style>
