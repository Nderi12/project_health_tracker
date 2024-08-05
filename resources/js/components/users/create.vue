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
                                    <h1 class="page-heading text-dark fw-bold fs-3 justify-content-center my-0">Users</h1>
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
											<span class="pt-1 fw-semibold fs-6">Create a new User</span>
											<!--end::Title-->
											</div>
											<!--end::Info-->
										</div>
									</div>
									<div class="card-body">
										<form @submit.prevent="create">
											<div class="form-row">
												<div class="row">
													<!-- First Name -->
													<div class="form-group col-md-12 mb-5">
														<label for="name">First Name</label>
														<input type="text" class="form-control" id="first_name" placeholder="First Name" v-model="first_name" required>	
													</div>

                                                    <!-- Middle name -->
													<div class="form-group col-md-12 mb-5">
														<label for="name">Middle Name</label>
														<input type="text" class="form-control" id="middle_name" placeholder="middle name" v-model="middle_name" required>	
													</div>

                                                    <!-- Last name -->
													<div class="form-group col-md-12 mb-5">
														<label for="name">Last Name</label>
														<input type="text" class="form-control" id="last_name" placeholder="last name" v-model="last_name" required>	
													</div>
                                                    <!-- email -->
													<div class="form-group col-md-12 mb-5">
														<label for="name">Email</label>
														<input type="email" class="form-control" id="email" placeholder="Email address" v-model="email" required>
														
													</div>
                                                    <!-- Phone Number -->
													<div class="form-group col-md-12 mb-5">
														<label for="name">Phone Number</label>
														<input type="text" class="form-control" id="phone_number" placeholder="Phone Number" v-model="phone_number" required>
													</div>

                                                    <!-- Password -->
													<div class="form-group col-md-12 mb-5">
														<label for="name">Password</label>
														<input type="text" class="form-control" id="password" placeholder="Password" v-model="password" required>

                                
													</div>

												</div>
											</div>
											<div class="d-flex justify-content-between">
												<button type="submit" class="btn btn-sm btn-primary" v-if="isSaving === false">Create</button>
												<button type="button" class="btn btn-sm btn-primary" v-else>Creating <span class="spinner-border spinner-border-sm align-middle text-white mr-2"></span></button>
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
					<component :is="footer"></component>
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
import { computed, onMounted, ref, reactive, watch, watchEffect } from 'vue';
import Header from './../include_files/PageHeader.vue';
import SideBar from './../include_files/PageSideBar.vue';
import Footer from './../include_files/PageFooter.vue';

import { initializeComponents } from "@/core/plugins/keenthemes";

import { useRouter, useRoute } from 'vue-router';
import Swal from 'sweetalert2';

const route = useRouter()
const router = useRoute()

const header = computed(() => Header)
const sidebar = computed(() => SideBar)
const footer = computed(() => Footer)

let first_name;
let middle_name;
let last_name;
let email;
let phone_number;
let password;

var errors = {};

const isSaving = ref(false);

onMounted(() => {
	initializeComponents();
})


const create = async ()=> {
        Csrf.getCookie();
        isSaving.value = true;
        http.post(`${baseURL}/create-user/`, {
			'first_name': first_name,
            'middle_name': middle_name,
            'last_name':last_name,
            'email':email,
			'phone_number': phone_number,
            '_method' : 'POST',
        })
        .then(response => {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'User created successfully!',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            }).then(() => {
				isSaving.value = false;
                route.push('/users')
            });
        })
        .catch(error => {
        isSaving.value = false;
		if (error.response.status === 422) {
			errors = error.response.data.errors;
		}
    });
}

const cancel = () => {
	route.push('/users')
}
</script>