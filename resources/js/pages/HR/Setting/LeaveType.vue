<template>
    <v-container fluid grid-list-xl>
       <v-card class="rounded-0" >
           <v-data-table
       :headers="headers"
       :items="leaves"
       class="elevation-1"
       >
     <template v-slot:top>
       <v-toolbar
         flat color="white"
       >
         <v-toolbar-title>Leave Type</v-toolbar-title>
         <v-spacer></v-spacer>
         <v-dialog
           v-model="dialog"
           max-width="500px"
         >
           <template v-slot:activator="{ props }">
               <v-btn color="blue" prepend-icon="mdi-plus-circle" variant="tonal" v-bind="props">
                   add leave
               </v-btn>
           </template>
           <v-card>
             <v-card-title class="text-center">
               <span class="text-h5 text-indigo-accent-2">{{ formTitle }}</span>
             </v-card-title>
             <!-- <v-divider></v-divider> -->
             <v-card-text>
               <v-container>
                     <v-text-field
                       v-model="editedItem.leave_name"
                       label="Leave Name"
                       variant="outlined"
                     ></v-text-field>
               </v-container>
             </v-card-text>

             <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn
                 color="grey-darken-1"
                 variant="tonal"
                 @click="close"
               >
                 Cancel
               </v-btn>
               <v-btn
                 color="blue-darken-1"
                 variant="tonal"
                 @click="save"
               >
                 Save
               </v-btn>
             </v-card-actions>
           </v-card>
         </v-dialog>
       </v-toolbar>
       <v-divider></v-divider>
     </template>
     <template v-slot:[`item.actions`]="{ item }">
       <v-icon
         size="small"
         class="me-2"
         color="green"
         @click="editItem(item)"
       >
         mdi-pencil
       </v-icon>
       <v-icon
         size="small"
         color="red"
         @click="deleteItemConfirm(item)"
       >
         mdi-delete
       </v-icon>
     </template>
   </v-data-table>
       </v-card>
    </v-container>
 </template>

 <script>
import axios from 'axios'
//  import Leave from '../../services/api/leave'
   export default {
     data: () => ({
       dialog: false,
       dialogDelete: false,
       headers: [
         {
           title: 'Name',
           align: 'start',
           sortable: false,
           key: 'leave_name',
         },
         { title: 'Actions', key: 'actions', sortable: false },
       ],
       leaves: [],
       editedIndex: -1,
       editedItem: {
         leave_name: '',
       },
       defaultItem: {
         leave_name: '',
       },
       depts: [],
     }),

     computed: {
       formTitle () {
         return this.editedIndex === -1 ? 'New Leave' : 'Edit Leave'
       },
     },

     watch: {
       dialog (val) {
         val || this.close()
       },
       dialogDelete (val) {
         val || this.closeDelete()
       },
     },

     created () {
       this.getLeave()
     },

     methods: {
        getLeave() {
            axios.get('/api/hr/HR/leave/listTable')
            // Leave.listTable()
            .then(response => {
                this.leaves = response.data.data;
                // console.log("leaves", this.leaves);
            })
            .catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
            })
        },

       editItem (item) {
         this.editedIndex = this.leaves.indexOf(item)
         this.editedItem = Object.assign({}, item)
         this.dialog = true
       },

       deleteItemConfirm (item) {
        // console.log("id", item)
            this.$swal({
                title: "Are you sure?",
                text: "Do you want to delete this item ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "##DC143C",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.value) {
                    axios.delete('/api/hr/HR/leave/delete/'+ item.id)
                    // Leave.deleteLeave(item.id)
                    this.$swal({
                        title: "Success",
                        text: "Delete Successfully!",
                        icon: "success",
                    })
                    this.getLeave();
                    // this.closeDelete()
                }
            })
            .catch(err =>{
                console.log(err.response)
                this.$swal(
                    {
                        title: 'Oops',
                        text:"Fail, something went wrong!",
                        icon: 'error'
                    }
                )
            });
            this.getLeave();
            // this.closeDelete()
       },

       close () {
         this.dialog = false
         this.$nextTick(() => {
           this.editedItem = Object.assign({}, this.defaultItem)
           this.editedIndex = -1
         })
       },

       closeDelete () {
         this.dialogDelete = false
         this.$nextTick(() => {
           this.editedItem = Object.assign({}, this.defaultItem)
           this.editedIndex = -1
         })
       },

       save () {
        if (this.editedIndex > -1) {
            const index = this.editedIndex
            // console.log(this.editedItem.id);
            // Leave.updateLeave(this.editedItem.id, this.editedItem)
            axios.put('/api/hr/HR/leave/update/'+ this.editedItem.id, this.editedItem)
            .then(response =>{
                Object.assign(this.leaves[index], response.data)
                // console.log("data", response.data);
                    this.$swal({
                        title: "Success",
                        text: "Update Successfully!",
                        icon: "success",
                    });
                this.close();
            })
            .catch(err => {
                console.log(err.response)
                this.$swal(
                    {
                        title: 'Oops',
                        text:"Fail, something went wrong!",
                        icon: 'error'
                    }
                )
            })
        } else {
            // console.log(this.editedItem)
            axios.post('/api/hr/HR/leave/create', this.editedItem)
            // Leave.createLeave(this.editedItem)
            .then(res => {
                // console.log(res);
                if (res.data.data == null) {
                    this.$swal({
                        title: "Oops",
                        text: "Fail to create, something went wrong!",
                        icon: "error",
                    });
                }else {
                    this.$swal({
                        title: "Success",
                        text: "Create Successfully!",
                        icon: "success",
                    });
                }
            })
            .catch(err => {
                console.dir(err)
                this.$swal(
                        {
                            title: 'Oops',
                            text:"Fail, something went wrong!",
                            icon: 'error'
                        }
                    )
            })
        }
            this.getLeave()
            this.close()
       },
     },
   }
 </script>
