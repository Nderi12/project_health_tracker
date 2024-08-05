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
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->
                    <form class='form w-100'>
                        <!--begin::Heading-->
                        <div class="text-center mb-10">
                            <!--begin::Title-->
                            <h1 class="text-dark fw-normal mb-3">Forgot your password?</h1>
                            <!--end::Title-->
                            <!--begin::Link-->
                            <div class="text-gray-400 fw-light fs-4">Enter your email address below.</div>
                            <!--end::Link-->
                        </div>
                        <!--begin::Heading-->

                        <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mb-9 p-6" v-if="errorMessage">
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-bold"><div class="fs-6 text-gray-700">{{ errorMessage }}</div></div>
                            </div>
                        </div>

                        <div class="notice d-flex bg-light-success rounded border-success border border-dashed mb-9 p-6" v-if="successMessage">
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-bold"><div class="fs-6 text-gray-700">{{ successMessage }}</div></div>
                            </div>
                        </div>

                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="form-label fs-6 fw-bolder text-dark">Your Email Address</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-lg form-control-solid" type="email" placeholder="Email Address" v-model="email" autocomplete="new-password" required />
                            <small class="p-0 m-0 text-danger"></small>
                            Go back? <router-link :to="{path:'/'}" class="link-primary fs-6 fw-normal"> Login</router-link>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <!--begin::Submit button-->
                            <button type="submit" :disabled="isWorking" class="btn btn-lg btn-primary w-100 mb-5" @click="sendResetPasswordCode">
                                <span class="" v-if="!isWorking">Submit</span>
                                <span class="" v-if="isWorking">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Submit button-->

                            <!--begin::Wrapper-->
                            <div class="mb-2 mt-2">
                                <!--begin::Label-->
                                <label class="form-label fw-bolder text-dark fs-6 mb-0"></label>
                                <!--end::Label-->
                                <!--begin::Link-->
                                Built by <a target="_blank" href="https://mobi-tyres.co.ke/" class="text-primary fw-bold text-hover-primary px-2">MOBI TYRES</a>
                                <!--end::Link-->
                            </div>
                            <!--end::Wrapper-->
                            
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->

</template>
<script setup>
import { ref } from 'vue';
import {useStore} from "vuex";
import { useRouter } from 'vue-router'
const router = useRouter()
const store = useStore()

const phone_number = ref('')
const isWorking = ref(false)
const successMessage = ref('')
const errorMessage = ref('')


const sendResetPasswordCode = (e) => {
    e.preventDefault()
    successMessage.value = ''
    errorMessage.value = ''
    if (phone_number.value.length > 0) {
        isWorking.value = true
        store.dispatch('user/sendResetPasswordCode', { phone_number: phone_number.value.replace(/ /g,'')})
            .then(response => {
                isWorking.value = false
                if (response.data.success) {
                    successMessage.value = response.data.message
                    setTimeout(() => { router.push({name: 'updatePassword'} )}, 2000)
                }
                else {
                    errorMessage.value = response.data.message
                }
            })
            .catch(error => {
                isWorking.value = false
                if (error.response !== undefined) {
                    errorMessage.value = error.response.data.message !== undefined ? error.response.data.message : ''
                    errors.value = error.response.data.errors
                }
            })
    }
}
</script>
