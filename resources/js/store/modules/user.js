import { baseURL, http, Csrf, getUserDataFromLocalStorage, setUserDataToLocalStorage, getCurrentUser, setAuth, getAuth, } from "../../boot";
import { useRouter } from 'vue-router'
import routes from '../../router/index'
import { resolve } from "chart.js/helpers";
const router = useRouter()
const state = () => ({
    currentUser: [],
    // currentUser: JSON.parse(localStorage.getItem('CurrentUser')) || {},
    userData: JSON.parse(localStorage.getItem('UserData')) || {},
    isAuthenticated: 'false',

    // Repositories
    allRepositoriesLinks:[],
    repositoriesEndpoint:`${baseURL}/repositories`,
    allRepositories:[],
    singleRepository:[],
    repoHealthStatus:[]
})

const getters = {
    // Auth
    getAuth: state => state.isAuthenticated,
    getCurrentUser: state => state.currentUser,

    // Repositories
    getAllRepositoriesLinks: state => state.allRepositoriesLinks,
    getRepositoriesEndpoint: state => state.repositoriesEndpoint,
    getAllRepositories: state => state.allRepositories,
    getSingleRepository: state => state.singleRepository,
    getRepoHealthStatus: state => state.repoHealthStatus
}

const mutations = {
    // Auth
    updateAuth(state, data) {
        state.isAuthenticated = data
    },
    updateCurrentUser(state, data) {
        state.currentUser = data
    },

    // Repositories
    updateRepositoriesLink(state, data){
        state.allRepositoriesLinks = data
    },
    updateRepositoriesEndpoint(state, data){
        state.repositoriesEndpoint = data
    },
    updateRepositories(state, data){
        state.allRepositories = data
    },
    updateSingleRepository(state, data){
        state.singleRepository = data
    },
    updateRepoHealthStatus(state, data){
        state.repoHealthStatus = data
    }
}

const actions = {
    async paymentRequest(context, payload) {
        await Csrf.getCookie()
        return new Promise((resolve, reject) => {
                http.post(`${baseURL}/mpesa-top-up`, payload)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => reject(error))
            })

    },
    async registerUser(context, payload) {
        await Csrf.getCookie()
        return new Promise((resolve, reject) => {
                http.post(`${baseURL}/register`, payload)
                    .then(response => {
                        setUserDataToLocalStorage(response.data.user)
                        // context.commit('updateUserDetails', response.data.user)
                        resolve(response.data.data)
                    })
                    .catch(error => reject(error))
            })

    },
    async verificationCode(context, payload){
        await Csrf.getCookie()
        return new Promise((resolve, reject) => {
            http.post(`${baseURL}/verify-phone-otp`, payload)
                .then(response => {
                    resolve(response.data.message)
                    if(!response.data.message.includes('Failed')) {
                        context.commit('updateAuth', true)
                        setAuth(true)
                        context.dispatch('fetchUserProfile')
                    }
                })
                .catch(error => {
                    reject(error)
                })
        })
    },
    async loginUser(context, payload) {
        await Csrf.getCookie()
        return new Promise((resolve, reject) => {
            http.post(`${baseURL}/login`, payload)
            .then(response => {
                if (response.data.user !== null && response.data.status === 1) {
                    context.dispatch('fetchUserProfile')
                    setAuth(true)
                    context.commit('updateAuth', true)
                    resolve(response.data)
                }else {
                    context.commit('updateAuth', false)
                    resolve(response.data)
                }
            }).catch(error => reject(error))
        })
    },
    getEditUserData(context, payload) {
        return new Promise((resolve, reject) => {
            http.get(`${baseURL}/user/${payload.id}`, payload)
                .then(response => {
                    context.commit('updateUserEditDetails', response.data.user)
                    resolve(response.data.user)
                }).catch(error => {
                reject(error)
            })
        })
    },
    getEditAuthenticatedUserData(context, payload) {
        return new Promise((resolve, reject) => {
            http.get(`${baseURL}/user`, payload)
                .then(response => {
                    resolve(response.data)
                }).catch(error => {
                reject(error)
            })
        })
    },
    async editUserData(context, payload) {
        await Csrf.getCookie()
        return new Promise((resolve, reject) => {
            http.post(`${baseURL}/edit-repository/${payload.id}`, payload)
                .then(response => {
                    context.commit('updateUserEditDetails', response.data.user)
                    resolve(response.data.message)
                }).catch(error => {
                reject(error)
            })
        })
    },
    async verifyUserPhoneOtp(context, payload) {
        await Csrf.getCookie()
        return new Promise((resolve, reject) => {
            http.post(`${baseURL}/send-phone-otp`, payload)
                .then(response => {
                    resolve(response.data)
                }).catch(error => {
                reject(error)
            })
        })
    },
    async updatePhoneNumber(context, payload) {
        await Csrf.getCookie()
        return new Promise((resolve, reject) => {
            http.post(`${baseURL}/update-phone`, payload)
                .then(response => {
                    resolve(response.data)
                }).catch(error => {
                reject(error)
            })
        })
    },
    async updateRepositoryProfile(context, payload) {
        await Csrf.getCookie()
        return new Promise((resolve, reject) => {
            http.post(`${baseURL}/update-repository-profile`, payload)
                .then(response => {
                    resolve(response.data)
                }).catch(error => {
                reject(error)
            })
        })
    },
    resendPhoneOtp() {
        return new Promise((resolve, reject) => {
            http.get(`${baseURL}/resend-phone-otp`)
                .then(response => {
                    resolve(response)
                }).catch(error => {
                reject(error)
            })
        })
    },
    async sendResetPasswordCode(context, payload) {
        await Csrf.getCookie()
        return new Promise((resolve, reject) => {
            http.post(`${baseURL}/send-reset-code`, payload)
                .then(response => {
                    context.commit('updateResetPwdPhoneNumber', payload.phone_number)
                    resolve(response)
                }).catch(error => {
                reject(error)
            })
        })
    },
    async resetPassword(context, payload) {
        await Csrf.getCookie()
        return new Promise((resolve, reject) => {
            http.post(`${baseURL}/update-password`, payload)
                .then(response => {
                    resolve(response)
                    return response
                }).catch(error => {
                reject(error)
            })
        })
    },

    // Users
    fetchUserProfile(context, payload) {
        return new Promise((resolve, reject) => {
            http.get(`${baseURL}/user`, payload)
                .then(response => {
                    setUserDataToLocalStorage(response.data)
                    context.commit('updateCurrentUser', response.data)
                    resolve(response)
                }).catch(error => {
                reject(error)
            })
        })
    },
    fetchUsers(context, payload) {
        return new Promise((resolve, reject) => {
            http.get(`${baseURL}/users`, payload)
                .then(response => {
                    context.commit('updateAllUsers', response.data.users)
                    resolve(response)
                }).catch(error => {
                reject(error)
            })
        })
    },

    // Repositories
    async fetchRepository(context, id) {
        await Csrf.getCookie()
        return new Promise((resolve, reject) => {
            http.get(`${baseURL}/repositories/${id}`)
                .then(response => {
                    resolve(response)
                }).catch(error => {
                reject(error)
            })
        })
    },
    async fetchRepositories(context, payload) {
        await Csrf.getCookie()
        return new Promise((resolve, reject) => {
            http.get(`${baseURL}/repositories`, payload)
                .then(response => {
                    context.commit('updateRepositories', response.data.repositories)
                    context.commit('updateRepositoriesLink', response.data.page_links)
                    resolve(response)
                    return response.data.repositories
                }).catch(error => {
                reject(error)
            })
        })
    },
    async fetchSingleRepository(context, payload) {
        await Csrf.getCookie()
        return new Promise((resolve, reject) => {
            http.get(`${baseURL}/repositories/${payload}`, payload)
                .then(response => {
                    context.commit('updateSingleRepository', response.data.repository)
                    context.commit('updateRepoHealthStatus', response.data.healthStatus)
                    resolve(response)
                    return response.data.repository
                }).catch(error => {
                    reject(error)
                })
        })
    },
    async syncRepositories(context, payload) {
        await Csrf.getCookie()
        return new Promise((resolve, reject) => {
            http.post(`${baseURL}/repositories/sync`)
                .then(response => {
                    resolve(response)
                    return response
                }).catch(error => {
                    reject(error)
                })
        })
    },

    logout(context, payload) {
        return new Promise((resolve, reject) => {
            http.get(`${baseURL}/logout`, payload)
                .then(response => {
                    localStorage.clear()
                    context.commit('updateAuth', false)
                    context.commit('updateRepositories', false)
                    context.commit('updateRepositoriesLink', false)
                    context.commit('updateProductsLink', false)
                    context.commit('updateCurrentUser', null)
                    context.commit('updateResetPwdPhoneNumber', false)
                    resolve(response)
                }).catch(error => {
                reject(error)
            })
        })
    },
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
