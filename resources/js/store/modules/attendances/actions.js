// import api from '../../../services/api'
import Swal from 'sweetalert2';
import router from '../../../router';

const actions = {
    async createAtten({ commit }, data) {
        console.log(data);
        return await api.createAtte(data)
            .then(({ data }) => {
                console.log("create attendance", data);
                commit("CREATE_ATTENDANCE", data);
                if (data.data == null) {
                    Swal.fire({
                        title: "Oops",
                        text: "Fail to create, something went wrong!",
                        icon: "error",
                    });
                }else {
                    Swal.fire({
                        title: "Success",
                        text: "Create Successfully!",
                        icon: "success",
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                    // router.push('/manageEmployee');
                }
            })
            .catch((err) => {
                console.log("create error", err);
                Swal.fire({
                    title: "Oops",
                    text: "Fail to create, something went wrong!",
                    icon: "error",
                });
            });
    },

    async applyLeave({ commit }, data) {
        console.log(data);
        return await api.Apply(data, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
            .then(({ data }) => {
                console.log("create attendance", data);
                commit("CREATE_ATTENDANCE", data);
                if (data.data == null) {
                    Swal.fire({
                        title: "Oops",
                        text: "Fail to create, something went wrong!",
                        icon: "error",
                    });
                }else {
                    Swal.fire({
                        title: "Success",
                        text: "Create Successfully!",
                        icon: "success",
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                    // router.push('/manageEmployee');
                }
            })
            .catch((err) => {
                console.log("create error", err);
                Swal.fire({
                    title: "Oops",
                    text: "Fail to create, something went wrong!",
                    icon: "error",
                });
            });
    },

    // async getEmployees({ commit }) {
    //     return await api.getEmployees()
    //     .then((res) => {
    //         console.log("All employee", res.data);
    //         commit("SET_EMPLOYEES", res.data)
    //     })
    // }
}

export default actions;
