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
								<h1 class="text-dark fw-normal mb-3">Verify Phone Number</h1>
								<!--end::Title-->
								<!--begin::Link-->
								<div class="text-gray-400 fw-light fs-4">Enter phone number verification code below.</div>
								<!--end::Link-->
							</div>
							<!--begin::Heading-->

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

							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<!--begin::Label-->
								<label class="form-label fs-6 fw-bolder text-dark">Verification Code</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input class="form-control form-control-lg form-control-solid mb-3" type="text" v-model="phone_otp" name="phone_otp" autocomplete="new-password" required />
                                <small class="p-0 m-0 text-danger"></small>
								<span class="fs-7 fw-normal text-gray-400">Didn't receive after a minute?</span>
                                <a href="#0" class="link-primary fs-7 fw-normal" @click="resendPhoneOtp"> Resend</a>

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
import { ref, watchEffect} from 'vue';
import { useRouter } from 'vue-router'
import {useStore} from "vuex";
const router = useRouter()
const store = useStore()

const errorMessage = ref('')
const successMessage = ref('')
const isWorking =ref(false)
const phone_otp = ref('');

watchEffect(() => {
    if (phone_otp.value) successMessage.value = ''
})

const resendPhoneOtp = () => {
    store.dispatch('user/resendPhoneOtp')
        .then(res => {
            successMessage.value = res.data.message
        })
        .catch(err => err)
}

const handleSubmit = (e) => {
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
	                errorMessage.value = false
                    router.go({name: 'dashboard'})
                }
            })
            .catch(error => {
                isWorking.value = false
                errorMessage.value = error.response
				successMessage.value = false
            })
    }
}
</script>
