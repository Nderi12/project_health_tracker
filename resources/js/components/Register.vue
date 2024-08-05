<template>
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <!--begin::Logo-->
                <a href="#0" class="mb-12">
                    <img alt="Logo" src="./git-flow.png" class="" />
                </a>

                <!--end::Logo-->
                <!--begin::Wrapper-->
                <div class="w-lg-600px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->
                    <form @submit.prevent="postNewRegistration" class='form w-100'>
                        <!--begin::Heading-->
                        <div class="mb-10 text-center">
                            <!--begin::Title-->
                            <h1 class="text-dark mb-3 fw-normal">Create an Account</h1>
                            <!--end::Title-->
                            <!--begin::Link-->
                            <div class="text-gray-400 fw-normal fs-4">Already have an account?
                                <router-link :to="{name: 'login'}" class="link-primary fw-bolder">Sign in here</router-link></div>
                            <!--end::Link-->
                        </div>
                        <!--end::Heading-->

                        <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mb-9 p-6" v-if="errorMessage">
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-bold"><div class="fs-6 text-gray-700">{{ errorMessage }}</div></div>
                            </div>
                        </div>


                        <!--begin::Input group-->
                        <div class="row fv-row mb-7">
                            <!--begin::Col-->
                            <div class="col-xl-12">
                                <label class="form-label fw-bold text-dark fs-7">Select Account Type</label>
                                <!--begin::Select-->
                                <select v-model="registration.account_type" class="form-select form-select-solid" required>
                                    <option disabled value="">Select Account Type</option>
                                    <option  value="1"> Individual </option>
                                    <option value="2"> Corporate </option>
                                </select>
                                <!--end::Select-->
                                <small class="p-0 m-0 text-danger">{{ errors.account_type }}</small>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Separator-->
                        <div class="d-flex align-items-center mb-5 mt-20" v-if="registration.account_type === '2'">
                            <div class="border-bottom border-gray-300 w-100"></div>
                            <span class="fw-bold text-gray-400 fs-7 mx-2 w-100"> <center>Company Details</center></span>
                            <div class="border-bottom border-gray-300 w-100"></div>
                        </div>
                        <!--end::Separator-->

                        <!--begin::Input group-->
                        <div class="row fv-row mb-7" v-if="registration.account_type === '2'">
                            <!--begin::Col-->
                            <div class="col-xl-6">
                                <label class="form-label required fw-bold text-dark fs-7">Company Name</label>
                                <input v-model="registration.company_name" class="form-control form-control-lg form-control-solid" type="text" placeholder="" autocomplete="off" required />
                                <small class="p-0 m-0 text-danger">{{ errors.company_name}}</small>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-xl-6">
                                <label class="form-label required fw-bold text-dark fs-7">Company Email</label>
                                <input v-model="registration.company_email" class="form-control form-control-lg form-control-solid" type="email" placeholder="" autocomplete="new-password" required />
                                <small class="p-0 m-0 text-danger">{{  errors.company_email }}</small>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row fv-row mb-7" v-if="registration.account_type === '2'">
                            <!--begin::Col-->
                            <div class="col-xl-6">
                                <label class="form-label fw-bold required text-dark fs-7">Physical Address</label>
                                <input v-model="registration.company_physical_address" class="form-control form-control-lg form-control-solid" type="text" placeholder="" autocomplete="off" required />
                                <small class="p-0 m-0 text-danger">{{  errors.company_physical_address }}</small>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-xl-6">
                                <label class="form-label fw-bcompany_postal_addressold required text-dark fs-7">Postal Address</label>
                                <input v-model="registration.company_postal_address" class="form-control form-control-lg form-control-solid" type="text" placeholder="" autocomplete="off" required />
                                <small class="p-0 m-0 text-danger">{{  errors.company_postal_address }}</small>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Separator-->
                        <div class="d-flex align-items-center mb-5 mt-20" v-if="registration.account_type === '2'">
                            <div class="border-bottom border-gray-300 mw-50 w-100"></div>
                            <span class="fw-bold text-gray-400 fs-7 mx-2 w-100 center"> <center>Contact Person</center></span>
                            <div class="border-bottom border-gray-300 mw-50 w-100"></div>
                        </div>
                        <!--end::Separator-->

                        <div  v-if="registration.account_type !== '' ">

                            <!--begin::Input group-->
                            <div class="row fv-row mb-7">
                                <!--begin::Col-->
                                <div class="col-xl-6">
                                    <label class="form-label fw-bold text-dark required fs-7">First Name</label>
                                    <input v-model="registration.first_name" class="form-control form-control-lg form-control-solid" type="text" placeholder="" autocomplete="off" required />
                                    <small class="p-0 m-0 text-danger">{{ errors.first_name }}</small>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-xl-6">
                                    <label class="form-label fw-bold text-dark fs-7">Middle Name (optional)</label>
                                    <input v-model="registration.middle_name" class="form-control form-control-lg form-control-solid" type="text" placeholder="" autocomplete="off" />
                                    <small class="p-0 m-0 text-danger">{{ errors.middle_name}}</small>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row fv-row mb-7">
                                <!--begin::Col-->
                                <div class="col-xl-6">
                                    <label class="form-label fw-bold required text-dark fs-7">Last Name</label>
                                    <input v-model="registration.last_name" class="form-control form-control-lg form-control-solid" type="text" placeholder="" autocomplete="off" required />
                                    <small class="p-0 m-0 text-danger">{{ errors.last_name}}</small>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-xl-6">
                                    <label class="form-label fw-bold text-dark required fs-7">Gender</label>
                                    <!--begin::Select-->
                                    <select v-model="registration.gender" class="form-select form-select-solid" required>
                                        <option value="">Select Gender</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                    <!--end::Select-->
                                    <small class="p-0 m-0 text-danger">{{ errors.gender }}</small>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div v-if="registration.account_type === '1'" class="row fv-row mb-7">
                                <!--begin::Col-->
                                <div class="col-xl-12">
                                    <label class="form-label fw-bold text-dark required fs-7">Select Document Type</label>
                                    <!--begin::Select-->
                                    <select v-model="registration.id_document_type" class="form-select form-select-solid" required>
                                        <option disabled value="">Select Document Type</option>
                                        <option value="1">Register with National ID</option>
                                        <option value="2">Register with  Passport No.</option>
                                    </select>
                                    <!--end::Select-->
                                    <small class="p-0 m-0 text-danger"></small>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div v-if="registration.account_type === '1'" class="row fv-row mb-7">
                                <!--begin::Col-->
                                <div class="col-xl-12" v-if="registration.id_document_type !== ''">
                                    <label class="form-label required fw-bold text-dark fs-7" v-if="registration.id_document_type === '1'">Enter National ID</label>
                                    <label class="form-label required fw-bold text-dark fs-7" v-if="registration.id_document_type === '2'">Enter Passport No.</label>
                                    <input v-model="registration.id_document_number" class="form-control form-control-lg form-control-solid" type="text" autocomplete="new-password" required />
                                    <small class="p-0 m-0 text-danger">{{ errors.id_document_number}}</small>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div v-if="registration.account_type === '2'" class="row fv-row mb-7">
                                <!--begin::Col-->
                                <div class="col-xl-12">
                                    <label class="form-label required fw-bold text-dark fs-7">Company KRA PIN</label>
                                    <input v-model="registration.id_document_number" class="form-control form-control-lg form-control-solid" type="text" autocomplete="new-password" required />
                                    <small class="p-0 m-0 text-danger">{{ errors.id_document_number}}</small>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row fv-row mb-7">
                                <!--begin::Col-->
                                <div class="col-xl-12">
                                    <label class="form-label required fw-bold text-dark fs-7">Phone Number</label>
                                    <input v-model="registration.phone_number" class="form-control form-control-lg form-control-solid" type="text" autocomplete="new-password" placeholder="Phone Number (254 722...)" required />
                                    <small class="p-0 m-0 text-danger">{{ errors.phone_number }}</small>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row fv-row mb-7">
                                <!--begin::Col-->
                                <div class="col-xl-6">
                                    <label class="form-label required fw-bold text-dark fs-7">Password</label>
                                    <input v-model="registration.password" class="form-control form-control-lg form-control-solid" type="password" autocomplete="new-password" required />
                                    <small class="p-0 m-0 text-danger">{{ errors.password}}</small>
                                    <!--end::Input wrapper-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-xl-6">
                                    <label class="form-label required fw-bold text-dark fs-7">Confirm Password</label>
                                    <input v-model="registration.password_confirmation" class="form-control form-control-lg form-control-solid" type="password" autocomplete="new-password" required />
                                    <small class="p-0 m-0 text-danger">{{ errors.password_confirmation}}</small>
                                </div>
                                <!--end::Col-->
                                <!--begin::Hint-->
                                <div class="" v-if="submitErrors.password.length > 0">{{ submitErrors.password }}</div>
                                <div class="text-muted">Use 8 or more characters with a mix of letters and numbers.</div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <label class="form-check form-check-custom form-check-solid form-check-inline">
                                    <input v-model="registration.terms" class="form-check-input" type="checkbox" required />
                                    <span class="form-check-label fw-bold text-gray-700 fs-6">I Agree to the
									<a target="_blank" href="terms-and-conditions-for-ETC-and-MTC-users.pdf" class="ms-1 link-primary">Terms & Conditions</a>.</span>
                                </label>
                                <small class="p-0 m-0 text-danger">{{ errors.terms }}</small>
                            </div>
                            <!--end::Input group-->
                            <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mb-9 p-6" v-if="errorMessage">
                                <div class="d-flex flex-stack flex-grow-1">
                                    <div class="fw-bold"><div class="fs-6 text-gray-700">{{ errorMessage }}</div></div>
                                </div>
                            </div>
                            <!--begin::Actions-->
                            <div class="text-center pb-10">
                                <button type="submit" :disabled="isWorking" id="kt_sign_up_submit" class="btn btn-lg btn-primary">
                                    <span class="indicator-label" v-if="!isWorking">Submit</span>
                                    <span class="" v-if="isWorking">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                            <!--end::Actions-->

                        </div>

                    </form>
                    <!--end::Form-->

                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <div class="d-flex flex-center flex-column-auto p-10">
                <!--begin::Links-->
                <div class="d-flex align-items-center fw-bold fs-6">
                    Built by <a target="_blank" href="https://mobi-tyres.co.ke/" class="text-primary text-hover-primary px-2">MOBI TYRES</a>
                </div>
                <!--end::Links-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
</template>
<script setup>
import { ref, reactive, watch, watchEffect } from 'vue';
import { useRouter } from 'vue-router'
import {useStore} from "vuex";
const router = useRouter()
const store = useStore()

const registration = reactive({
    account_type: '',
    company_name: '',
    company_email: '',
    company_physical_address: '',
    company_postal_address: '',
    id_document_type: '',
    id_document_number: '',
    first_name: '',
    middle_name: '',
    last_name: '',
    gender: '',
    phone_number: "",
    password: "",
    password_confirmation: "",
    terms: false
})
const isWorking = ref(false)
let errorMessage = ref('')
let errors = ref({})
let submitErrors = reactive({email: [], password: []})

watch(registration, () => {
    if (registration.password_confirmation.length > 0) {
        registration.password !== registration.password_confirmation ? errorMessage.value = 'Password don\'t match' : errorMessage.value = ''
    } else if (registration.password_confirmation.length === 0){
        errorMessage.value = ''
    }
})

watchEffect(() => {
    if (registration.password.length > 0 && registration.password.length <= 7) {
        errorMessage.value = 'password length should be greater than 8'
    } else if (registration.password.length >= 8) {
        errorMessage.value = ''
    }
})

const postNewRegistration = async () => {
    if(registration.terms === true && registration.password.length >= 8) {
        errorMessage.value = ''
        isWorking.value = true
        const finalForm = {
            account_type: registration.account_type,
            company_name: registration.company_name,
            company_email: registration.company_email,
            company_physical_address: registration.company_physical_address,
            company_postal_address: registration.company_postal_address,
            id_document_type: registration.id_document_type,
            id_document_number: registration.id_document_number,
            first_name: registration.first_name,
            middle_name: registration.middle_name,
            last_name: registration.last_name,
            gender: registration.gender,
            phone_number: registration.phone_number,
            password: registration.password,
            password_confirmation: registration.password_confirmation,
            terms: true
        }

        store.dispatch('user/registerUser', finalForm)
            .then(response => {
                isWorking.value = false
                router.push({name: 'verifyPhone'})
            })
            .catch(error => {
                isWorking.value = false
                errorMessage.value = error.response.data.message !== undefined ? error.response.data.message : ''
                errors.value = error.response.data.errors
            })

    }
}
</script>
