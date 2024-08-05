<template>

	<!--begin::App-->
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<!--begin::Page-->
		<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
			<!--begin::Header-->
			<component :is="header"></component>
			<slot/>			
			<!--end::Header-->
			<!--begin::Wrapper-->
			<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
				<!--begin::Sidebar-->
				<component :is="sidebar"></component>
				<slot/>
				<!--end::Sidebar-->
				<!--begin::Main-->
				<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
					<!--begin::Content wrapper-->
					<div class="d-flex flex-column flex-column-fluid">
						<!--begin::Toolbar-->
						<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
							<!--begin::Toolbar container-->
							<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
								<!--begin::Page title-->
								<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
									<!--begin::Title-->
                                    <h1 class="page-heading text-dark fw-bold fs-3 justify-content-center my-0">User</h1>
									<!--end::Title-->
									<!--begin::Breadcrumb-->
									<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
										<!--begin::Item-->
										<li class="breadcrumb-item text-muted">
											<a href="#0" class="text-muted text-hover-primary">Home</a>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-400 w-5px h-2px"></span>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item text-muted">Dashboards</li>
										<!--end::Item-->
									</ul>
									<!--end::Breadcrumb-->
								</div>
								<!--end::Page title-->
								<div class="d-flex align-items-center gap-2 gap-lg-3">
									<!--begin::Primary button-->
									
									<!--end::Primary button-->
								</div>
							</div>
							<!--end::Toolbar container-->
						</div>
						<!--end::Toolbar-->
						<!--begin::Content-->
						<div id="kt_app_content" class="app-content flex-column-fluid">
							<div id="kt_app_content_container" class="app-container container-xxl">
								<div class="card">
									<div class="card-header pt-5">
										<div class="card-title d-flex flex-column">
											<!--begin::Info-->
											<div class="d-flex align-items-center">
											<!--begin::Title-->
											<span class="pt-1 fw-semibold fs-6">Edit User</span>
											<!--end::Title-->
											</div>
											<!--end::Info-->
										</div>
									</div>
									<div class="card-body text-center p-19" v-if="isLoading">
										<h4>Fetching user... <span class="spinner-border spinner-border-sm align-middle text-gray-600 mr-2"></span></h4>
									</div>
									<div class="card-body" v-else>
										<form @submit.prevent="update">
                                            <div class="form-row">
												<div class="row">
													<!-- First Name -->
													<div class="form-group col-md-12 mb-5">
														<label for="name">First Name</label>
														<input type="text" class="form-control" id="first_name" placeholder="First Name" v-model="first_name">
														<div v-if="errors.first_name">
															<div v-for="error in errors.first_name" :key="error" class="text-danger">* {{ error }}</div>
														</div>
													</div>
                                                    <!-- Middle name -->
													<div class="form-group col-md-12 mb-5">
														<label for="name">Middle Name</label>
														<input type="text" class="form-control" id="middle_name" placeholder="middle name" v-model="middle_name">
														<div v-if="errors.middle_name">
															<div v-for="error in errors.middle_name" :key="error" class="text-danger">* {{ error }}</div>
														</div>
													</div>
                                                    <!-- Last name -->
													<div class="form-group col-md-12 mb-5">
														<label for="name">Last Name</label>
														<input type="text" class="form-control" id="last_name" placeholder="last name" v-model="last_name">
														<div v-if="errors.last_name">
															<div v-for="error in errors.last_name" :key="error" class="text-danger">* {{ error }}</div>
														</div>
													</div>
                                                    <!-- email -->
													<div class="form-group col-md-12 mb-5">
														<label for="name">Email</label>
														<input type="email" class="form-control" id="email" placeholder="Email address" v-model="email">
														<div v-if="errors.email">
															<div v-for="error in errors.email" :key="error" class="text-danger">* {{ error }}</div>
														</div>
													</div>
                                                    <!-- Phone Number -->
													<div class="form-group col-md-12 mb-5">
														<label for="name">Phone Number</label>
														<input type="text" class="form-control" id="phone_number" placeholder="Phone Number" v-model="phone_number">
														<div v-if="errors.phone_number">
															<div v-for="error in errors.phone_number" :key="error" class="text-danger">* {{ error }}</div>
														</div>
													</div>
                                                    <!-- Password -->
													<div class="form-group col-md-12 mb-5">
														<label for="name">Password</label>
														<input type="password" class="form-control" id="password" placeholder="Password" v-model="password">
														<div v-if="errors.password">
															<div v-for="error in errors.password" :key="error" class="text-danger">* {{ error }}</div>
														</div>
													</div>

												</div>
											</div>
											<div class="d-flex justify-content-between">
												<button type="submit" class="btn btn-primary" v-if="isEditing === false">Update</button>
												<button type="button" class="btn btn-primary" v-else>Updating <span class="spinner-border spinner-border-sm align-middle text-white mr-2"></span></button>
												<button type="button" class="btn btn-danger" @click="cancel">Cancel</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!--end::Content-->
					</div>
					<!--end::Content wrapper-->
					<!--begin::Footer-->
					<!-- <component :is="footer"></component> -->
					<Footer />
					<slot/>			
					<!--end::Footer-->
				</div>
				<!--end:::Main-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Page-->
	</div>
	<!--end::App-->

</template>
<script setup>
import {
  baseURL,
  http,
  Csrf,
} from "../../boot";
import { computed, onMounted, ref, reactive } from 'vue';
import Header from './../include_files/PageHeader.vue';
import SideBar from './../include_files/PageSideBar.vue';
import Footer from './../include_files/PageFooter.vue';

import { initializeComponents } from "@/core/plugins/keenthemes";

import {useStore} from "vuex";
import { useRoute, useRouter } from 'vue-router';
import Swal from 'sweetalert2';

const store = useStore()
const router = useRoute()
const route = useRouter()

const header = computed(() => Header)
const sidebar = computed(() => SideBar)
const footer = computed(() => Footer)

const first_name = ref('')
const middle_name = ref('')
const last_name = ref('')
const email = ref('')
const phone_number = ref('')
const password = ref('')

const isEditing = ref(false);
const isLoading = ref(true);
const hasData = ref(false);

const id = router.params.id

const singleUser = reactive({
	all: '',
})

var errors = {};

onMounted(() => {
	initializeComponents();
	store.dispatch('user/fetchSingleUser', id).then(() => {
		singleUser.all = computed(() => store.getters['user/getSingleUser'])
		first_name.value = singleUser.all.first_name;
		middle_name.value = singleUser.all.middle_name;
		last_name.value = singleUser.all.last_name;
		email.value = singleUser.all.email;
		phone_number.value= singleUser.all.phone_number;
		password.value =singleUser.all.password;

		isLoading.value = false;
		hasData.value = singleUser.all != null;
	});
})


const update = async ()=> {
        Csrf.getCookie();
        isEditing.value = true;
        http.post(`${baseURL}/update-user/${id}`, {
            'first_name':first_name.value,
			'middle_name': middle_name.value,
            'last_name': last_name.value,
            'email' : email.value,
            'phone_number' : phone_number.value,
			'password':password.value,
            '_method' : 'PATCH',
        })
        .then(response => {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'User updated successfully!',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            }).then(() => {
				isEditing.value = false
                route.push('/users')
            });
        })
        .catch(error => {
        isEditing.value = false;
        if (error.response.status === 422) {
			errors = error.response.data.errors;
		}
    });
}

const cancel = () => {
	route.push('/users')
}

</script>