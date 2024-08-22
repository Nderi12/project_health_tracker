<template>
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <!--begin::Logo-->
                <a href="#0" class="mb-12">
                    <!-- <img alt="Logo" src="./git-flow.png" class="" style="height: 150px; width: 150px;" /> -->
                </a>
                <!--end::Logo-->
                <!--begin::Wrapper-->
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->
                    <form class='form w-100'>
                        <!--begin::Heading-->
                        <div class="text-center mb-10">
                            <!--begin::Title-->
                            <h1 class="text-dark fw-normal mb-3">Login</h1>

                            <!--end::Title-->
                            <!--begin::Link-->
                            <div class="text-gray-400 fw-light fs-4">Enter your email address and password below</div>
                            <!--end::Link-->
                        </div>

                        <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed mb-9 p-6" v-if="errorMessage">
                            <div class="d-flex flex-stack flex-grow-1">
                                <div class="fw-bold"><div class="fs-6 text-gray-700">{{ errorMessage }}</div></div>
                            </div>
                        </div>

                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="form-label fs-6 fw-bolder text-dark">Email Address</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-lg form-control-solid" type="email" placeholder="Email Address" v-model="email" autocomplete="new-password" required />
                            <div class="invalid-feedback d-block">{{ errors.email }}</div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack mb-2">
                                <!--begin::Label-->
                                <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                                <!--end::Label-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Input-->
                            <input class="form-control form-control-lg form-control-solid" type="password" placeholder="Password" v-model="password" autocomplete="new-password" required />
                            <div class="invalid-feedback d-block">{{ errors.password }}</div>
                            <!--end::Input-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack mb-2 mt-2">
                                <!--begin::Label-->
                                <label class="form-label fw-bolder text-dark fs-6 mb-0"></label>
                                <!--end::Label-->
                                <!--begin::Link-->
                                <router-link :to="{path:'/forgot-password'}" class="link-primary fs-6 fw-normal">Forgot Password ?</router-link>
                                <!--end::Link-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <!--begin::Submit button-->
                            <button type="submit" :disabled="isWorking" class="btn btn-lg btn-primary w-100 mb-5" @click="login">
                                <span v-if="!isWorking">Continue</span>
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
                                Built by <a target="_blank" href="#" class="text-primary fw-bold text-hover-primary px-2">Just A Dev</a>
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
import { ref, watchEffect, computed } from 'vue';
import {useStore} from "vuex";
import { useRouter } from 'vue-router'
const store = useStore()
const router = useRouter()
const cl = console.log;

const errorMessage = ref('')
let errors = ref({})
const isWorking = ref(false)
const email = ref(null)
const password = ref(null)

const auth = computed(() => store.getters['user/getAuth'])

watchEffect(() => {
    if (email.value) errorMessage.value = ''
    if (password.value) errorMessage.value = ''
})

const login = (e) => {
    e.preventDefault()
    if (/\s/g.test(password.value)){
        errorMessage.value = 'Password should not be null'
    }else
    if (email.value !== null && password.value !== null ) {
        isWorking.value = true
        store.dispatch('user/loginUser', { email: email.value.replace(/ /g,'') , password: password.value })
            .then(response => {
                isWorking.value = false
                if (response.status === 2) {
                    errorMessage.value = response.message + 'Redirecting to Verify Your phone'
                    setTimeout(() => {router.push({ name: 'verifyPhone'})}, 1000)
                } else if (response.status === 0) {
                    errorMessage.value = response.message
                } else if (response.status === 1){
                    router.go({name: 'dashboard'})
                }
            })
            .catch(error => {
                if (error.response !== undefined) {
                    errorMessage.value = error.response.data.message !== undefined ? error.response.data.message : ''
                    errors.value = error.response.data.errors
                }
                isWorking.value = false
            })
    }else{
        errorMessage.value = 'Email and Password should not be null'
    }
}
</script>
