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
								<h1 class="text-dark fw-normal mb-3">Set New Password</h1>
								<!--end::Title-->
								<!--begin::Link-->
								<div class="text-gray-400 fw-light fs-4">Enter verification code and new password below.</div>
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
								<label class="form-label fs-6 fw-bolder text-dark">Verification Code</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid mb-3" type="text" v-model="reset.otp" autocomplete="new-password" required />
                                <small class="p-0 m-0 text-danger"></small>
								<span class="fs-7 fw-normal text-gray-400">Didn't receive after a minute?</span>
								<router-link :to="{path:'/forgot-password'}" class="link-primary fs-6 fw-normal"> Resend</router-link>
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
								<input class="form-control form-control-lg form-control-solid" v-model="reset.new_password" type="password" autocomplete="new-password" required />
                                <div class="invalid-feedback d-block"></div>
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-stack mb-2">
									<!--begin::Label-->
									<label class="form-label fw-bolder text-dark fs-6 mb-0">Confirm Password</label>
									<!--end::Label-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid" type="password" v-model="reset.new_password_confirmation" autocomplete="new-password" required />
                                <div class="invalid-feedback d-block"></div>
								<!--end::Input-->
							</div>
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="text-center">
								<!--begin::Submit button-->
								<button type="submit" :disabled="isWorking" class="btn btn-lg btn-primary w-100 mb-5" @click="handleSubmit">
									<span class="" v-if="!isWorking">Submit</span>
									<span class="" v-if="isWorking">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
								<!--end::Submit button-->
							</div>
							<!--end::Actions-->
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
import { ref, watch, reactive, watchEffect, onMounted} from 'vue';
import { VueTelInput } from 'vue-tel-input';
import 'vue-tel-input/dist/vue-tel-input.css';
import { useRouter } from 'vue-router'
import {useStore} from "vuex";
const router = useRouter()
const store = useStore()

const reset = reactive({
    phone_number: store.getters['user/getResetPwdPhoneNumber'],
    otp: '',
    new_password: '',
    new_password_confirmation: ''
})

const errorMessage = ref('')
const successMessage = ref('')
const isWorking =ref(false)
const phone = ref(null);


watch(reset, () => {
    if (reset.new_password_confirmation.length > 0) {
        reset.new_password !== reset.new_password_confirmation ? errorMessage.value = 'Password don\'t match' : errorMessage.value = ''
    } else if (reset.new_password_confirmation.length === 0){
        errorMessage.value = ''
    }
})

watchEffect(() => {
    if (reset.new_password.length > 0 && reset.new_password.length <= 7) {
        errorMessage.value = 'password length should be greater than 8'
    } else if (reset.new_password.length >= 8) {
        errorMessage.value = ''
    }
})

const handleSubmit = (e) => {
    // e.preventDefault()
    if (reset.new_password.length >= 8) {
		isWorking.value = true
		store.dispatch('user/resetPassword', { phone_number: store.getters['user/getResetPwdPhoneNumber'],  otp: reset.otp,  new_password: reset.new_password, new_password_confirmation: reset.new_password_confirmation })
		.then(response => {
			if (response.data.success) {
				isWorking.value = false
				successMessage.value = response.data.message
				setTimeout(() => { router.push( {name: 'login'} )}, 3000)
			}
			else {
				isWorking.value = false
				errorMessage.value = response.data.message
			}

		}).catch(err => {
			if (err.response !== undefined) {
				errorMessage.value = err.response.data.message !== undefined ? err.response.data.message : ''
				errors.value = err.response.data.errors
			}
			isWorking.value = false
		})
    }
	else{
		alert("Error")
	}
}
</script>
