<template>

    <div>
        <component :is="header"></component>
        <slot/>

        <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
            <!--begin::Post-->
            <div class="content flex-row-fluid" id="kt_content">
                <!--begin::Billing History-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header card-header-stretch border-bottom border-gray-200">
                        <!--begin::Title-->
                        <div class="card-title">
                            <h3 class="fw-bolder m-0">My Profile</h3>
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Card header-->

                    <!--begin::Table container-->
                    <div class="card-body">
                        <!--begin::Alert-->
                        <div class="alert alert-warning">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column">
                                <!--begin::Title-->
                                <h4 class="mb-1 text-dark fw-normal text-center">Note the details indicated here MUST match the information on the ETC or MTC application form submitted during registration.</h4>
                                <!--end::Title-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Alert-->

                        <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mb-9 p-6" v-if="errorMessage">
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-bold"><div class="fs-6 text-gray-700">{{ errorMessage }}</div></div>
                            </div>
                        </div>

                        <div class="notice d-flex bg-light-success rounded border-danger border border-dashed mb-9 p-6" v-if="successMessage">
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-bold"><div class="fs-6 text-gray-700">{{ successMessage }}</div></div>
                            </div>
                        </div>

                        <div v-if="customer_type==2">
                            <!--begin::Input group-->
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group input-group-solid mb-5">
                                <span class="input-group-text" id="basic-addon3">@</span>
                                <input type="email" class="form-control" id="email" aria-describedby="basic-addon3" v-model="profile.email" @input="inputChange"/>
                            </div>
                        </div>

                        <!--begin::Input group-->
                        <label for="email" class="form-label">Document Type</label>
                        <select class="form-select mb-5" aria-label="Select Document Type" v-model="id_document_type" @input="inputChange">
                            <option disabled value="">Select Document Type</option>
                            <option v-if="customer_type==1" value="1">National ID</option>
                            <option v-if="customer_type==1" value="2">Passport No.</option>
                            <option v-if="customer_type==2" value="3">KRA PIN.</option>
                        </select>
                        <small class="p-0 m-0 text-danger">{{ errors.id_document_type }}</small>

                        <label for="id_document_number">
                            <span v-if="id_document_type===1">National ID</span>
                            <span v-if="id_document_type===2">Passport No.</span>
                            <span v-if="id_document_type===3">KRA PIN.</span>
                        </label>
                        <input type="text" class="form-control col-sm-12 col-xs-12 mb-5" id="id_document_number" aria-describedby="basic-addon3" v-model="id_document_number" @input="inputChange"/>
                        <small class="p-0 m-0 text-danger">{{ errors.id_document_number }}</small>

<!--                        <button type="button" :disabled="isUpdatingProfile" class="btn btn-lg btn-primary mb-8 w-100" @click="updateProfile">-->
<!--                            <span v-if="!isUpdatingProfile">Update</span>-->
<!--                            <span class="" v-if="isUpdatingProfile">Please wait...-->
<!--									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>-->
<!--                        </button>-->

                        <!--begin::Input group-->
                        <label for="basic-url" class="form-label mt-8">Phone Number</label>
                        <input type="text" class="form-control mb-5" id="phone_number" aria-describedby="basic-addon3" v-model="phone_number" placeholder="Enter Phone Number (eg. 254 ...)" @input="inputChange"/>
                        <small class="p-0 m-0 text-danger">{{ errors.phone_number }}</small>

                        <button v-if="otpNotSent && formUpdated" type="button" :disabled="isWorking" class="btn btn-lg btn-primary w-100" id="send_otp_btn" @click="sendOTP">
                            <span v-if="!isWorking">Request OTP and Save Changes</span>
                            <span class="" v-if="isWorking">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>

                        <div v-if="otpSent" class="input-group input-group-solid mb-5">
                            <span class="input-group-text" id="basic-addon3">OTP Code</span>
                            <input type="text" class="form-control" id="otp_code" aria-describedby="basic-addon3" v-model="phone_otp"/>
                            <small class="p-0 m-0 text-danger">{{ errors.phone_otp }}</small>
                        </div>
                        <button v-if="otpSent" type="button" :disabled="isWorking" class="btn btn-lg btn-primary w-100 mb-5" @click="verifyOTP">
                            <span v-if="!isWorking">Verify OTP and Update</span>
                            <span class="" v-if="isWorking">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    <!--end::Table container-->

                </div>
                <!--end::Billing Address-->
            </div>
            <!--end::Post-->
        </div>

        <component :is="footer"></component>
        <slot/>
    </div>


</template>

<script setup>
import { computed, ref, onMounted,watch, reactive } from 'vue'
import Header from './include_files/HeaderLoggedIn';
import Footer from './include_files/Footer';
import {useStore} from "vuex";
import { useRouter } from 'vue-router'
import moment from 'moment'
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
const router = useRouter()
const store = useStore()

const isFetchingProfile = ref(false);
const isFetchingCustomer = ref(false);
let errorMessage = ref('')
const successMessage = ref('')
let errors = ref({})
const phone_otp = ref(null)
const password = ref(null)
const isWorking = ref(false)
const otpNotSent = ref(true)
const otpSent = ref(false)
const phoneVerified=ref(false)
const isUpdatingProfile=ref(false)
const customer_type=ref(1)

const phone_number = ref(null)
const id_document_type = ref(null)
const id_document_number = ref(null)
const c_email=ref(null)

const profile=reactive({
    email: '',
    id_document_type:id_document_type,
    id_document_number:id_document_number,
    phone_number:phone_number
})

onMounted(() => {
    getCustomerProfile()
})

const getCustomerProfile=()=>{
    store.dispatch('user/getEditAuthenticatedUserData')
        .then(response => {
            isWorking.value = false
            if (response) {
                profile.email=response.company_email
                profile.id_document_number=response.id_document_number
                profile.id_document_type=response.id_document_type
                phone_number.value=response.phone_number
                customer_type.value=response.account_type
            } else if (response.success) {
            }
        })
        .catch(error => {
            if (error.response !== undefined) {
                errorMessage.value = error.response.data.message !== undefined ? error.response.data.message : ''
                errors.value = error.response.data.errors
            }
            isWorking.value = false
        })
}

const header = computed(() => Header)
const footer = computed(() => Footer)
const formUpdated=ref(false)

const sendOTP = (e) => {
    e.preventDefault()
    if (phone_number.value !== null ) {
        isWorking.value = true
        store.dispatch('user/verifyUserPhoneOtp', { phone_number: phone_number.value })
            .then(response => {
                isWorking.value = false
                if (!response.success) {
                    errorMessage.value = response.message
                    // setTimeout(() => {router.push({ name: 'verifyPhone'})}, 1000)
                } else if (response.success) {
                    document.getElementById('phone_number').setAttribute('readonly',true)
                    document.getElementById('send_otp_btn').setAttribute('disabled',true)
                    otpSent.value=true
                    otpNotSent.value=false
                }
            })
            .catch(error => {
                if (error.response !== undefined) {
                    errorMessage.value = error.response.data.message !== undefined ? error.response.data.message : ''
                    errors.value = error.response.data.errors
                }
                isWorking.value = false
            })
    }
}
const verifyOTP = (e) => {
    e.preventDefault()
    const regex = /^\d+$/
    if (regex.test(phone_otp.value) && phone_otp.value.length > 0) {
        isWorking.value = true
        store.dispatch('user/verificationCode', {phone_otp: phone_otp.value})
            .then(response => {
                isWorking.value = false
                errorMessage.value = response
                if (!response.includes('Failed')) {
                    successMessage.value = response
                    otpSent.value=false
                    errorMessage.value = false
                    store.dispatch('user/updateCustomerProfile',profile).then(res=>{
                        console.log(res)
                        if(res.success){
                            successMessage.value=res.message
                        }else{
                            errorMessage.value=res.message
                        }
                        otpNotSent.value=true
                        otpSent.value=false
                        isWorking.value=false
                    }).catch(err =>{
                        if (err.response !== undefined) {
                            isWorking.value = false
                            errorMessage.value = err.response.data.message !== undefined ? err.response.data.message : ''
                            errors.value = err.response.data.errors
                        }
                        successMessage.value=false
                        otpNotSent.value=true
                        otpSent.value=false
                        isWorking.value=false
                    })
                }
            })
            .catch(error => {
                isWorking.value = false
                errorMessage.value = error.response
                successMessage.value = false
            })
    }
}

const updateProfile= (e) => {
    e.preventDefault()
    isUpdatingProfile.value=true
    store.dispatch('user/updateCustomerProfile', profile)
        .then(response => {
            isWorking.value = false
            if (!response.success) {
                isUpdatingProfile.value=false
                errorMessage.value=response.message
            } else if (response.success) {
                isUpdatingProfile.value=false
                successMessage.value=response.message
            }
        })
        .catch(error => {
            if (error.response !== undefined) {
                isWorking.value = false
                errorMessage.value = error.response.data.message !== undefined ? error.response.data.message : ''
                errors.value = error.response.data.errors
            }
            isWorking.value = false
        })
}
const userPhoneNumber = computed(() => (store.getters['user/getCurrentUser'].phone_number ?? ''))
const userEmail = computed(() => (store.getters['user/getCurrentUser'].company_email ?? ''))
const userAccountType = computed(() => (store.getters['user/getCurrentUser'].account_type ?? ''))
const userDocumentType = computed(() => (store.getters['user/getCurrentUser'].id_document_type ?? ''))
const userDocumentNumber = computed(() => (store.getters['user/getCurrentUser'].id_document_number ?? ''))
const inputChange=()=>{
    if(customer_type.value===2) {
        if (profile.email.value != userEmail.value) {
            formUpdated.value = true
        } else {
            formUpdated.value = false
        }
    }
    if(profile.phone_number.value!=userPhoneNumber){
        formUpdated.value=true
    }else{
        formUpdated.value=false
    }
    if(profile.id_document_type.value!=userDocumentType){
        formUpdated.value=true
    }else{
        formUpdated.value=false
    }
    if(profile.id_document_number.value!=userDocumentNumber){
        formUpdated.value=true
    }else{
        formUpdated.value=false
    }
}

</script>
