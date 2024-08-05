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
									<router-link :to="{ name: 'create-user' }" class="btn btn-sm fw-bold btn-primary"
										>Create User</router-link
									>
									<!--end::Primary button-->
								</div>
							</div>
							<!--end::Toolbar container-->
						</div>
						<!--end::Toolbar-->
						<!--begin::Content-->
						<div id="kt_app_content" class="app-content flex-column-fluid">
							<div class="card m-5">
								<div class="card-header pt-5">
									<div class="card-title d-flex flex-column">
										<!--begin::Info-->
										<div class="d-flex align-items-center">
										<!--begin::Title-->
										<span class="pt-1 fw-semibold fs-6">Users List</span>
										<!--end::Title-->
										</div>
										<!--end::Info-->
									</div>
								</div>
								
								<div class="card-body" >
									<div class="form-outline mb-5">
										<input type="search" id="search-form" v-model="searchQuery" @input="searchFn" class="form-control" placeholder="Search" aria-label="Search" />
									</div>
									<div class="card-body text-center p-19" v-if="isLoading">
								
								<h4>Fetching Users... <span class="spinner-border spinner-border-sm align-middle text-gray-600 mr-2"></span></h4>
							</div>
							<div class="card-body text-center p-19" v-else-if="!hasData">
								<!-- Show message when no data is available -->
								<h4>No User found.</h4>
							</div>
									<!-- Show data -->
									<!--begin::Table container-->
									<div class="table-responsive" v-else-if="usersList.all.data.length > 0">
										<!--begin::Table-->
											<table class="table table-row-bordered align-middle gy-4 gs-9">
												<thead class="border-bottom border-gray-200 fs-6 text-gray-600 fw-bolder bg-light bg-opacity-75">
													<tr>
														<td>#</td>
														<td>First Name</td>
														<td>Last Name</td>
                                                        <td>Email</td>
                                                        <td>Phone Number</td>
														<td>Status</td>
														<td>Action</td>
													</tr>
												</thead>
												<tbody class="fw-bold text-gray-600">
													<!--begin::Table row-->
													<tr v-for="(user, index) in usersList.all.data" :key="user.id">                                            
														<td>{{ index+1 }} </td>
														<td>{{ user.first_name }} </td>
                                                        <td>{{ user.last_name }} </td>
                                                        <td>{{ user.email }} </td>
                                                        <td>{{ user.phone_number}} </td>
														<td><span :class="badgeClass(user.status)">{{badgeText(user.status)}}</span></td>
														<td>
															<router-link :to="{ name: 'edit-user', params: { id: user.id } }" class="btn btn-sm fw-bold btn-primary m-3"><i class="fa fa-edit"></i></router-link>
															<router-link :to="{ name: 'view-user', params: { id: user.id } }" class="btn btn-sm fw-bold btn-primary m-1"><i class="fa fa-eye"></i></router-link>
															<button class="btn btn-sm btn-success" v-if="user.status === 2" @click="enableUser(user.id)"><i class="fa fa-check"></i></button>
															<button class="btn btn-sm btn-danger" v-if="user.status === 1" @click="disableUser(user.id)"><i class="fa fa-cancel"></i></button>
														</td>
													</tr>
													<!--end::Table row-->
												</tbody>
											</table>
										<!--end::Table-->
										<pagination :page_links="page_links" @pagenavigate="navigateToPage" :loadingPage="navigationLoading"></pagination>
									</div>
									<!--end::Table container-->
								</div>
							</div>
						</div>
						<!--end::Content-->
					</div>
					<!--end::Content wrapper-->
					<!--begin::Footer-->
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
import { baseURL, http, Csrf, } from "../../boot";
import { computed, onMounted, ref, reactive, watch, watchEffect } from 'vue';
import Header from './../include_files/PageHeader.vue';
import SideBar from './../include_files/PageSideBar.vue';
import Footer from './../include_files/PageFooter.vue';
import Pagination from './../include_files/PaginationLinks.vue';

import { initializeComponents } from "@/core/plugins/keenthemes";

import {useStore} from "vuex";

const store = useStore()
const isLoading = ref(true);
const hasData = ref(false);

const page_links = computed(() => store.getters['user/getAllUsersLinks'])
const navigationLoading=ref(false)

let searchQuery;

const usersList = reactive({
    all: ''
})

onMounted(() => {
	initializeComponents();
    store.dispatch('user/fetchUsers').then(() => {
		usersList.all = computed(() => store.getters['user/getAllUsers']);
		isLoading.value = false;
		hasData.value = usersList.all.data.length > 0;
	});
})

const header = computed(() => Header)
const sidebar = computed(() => SideBar)
const footer = computed(() => Footer)

const navigateToPage=async (page)=>{
	console.log(page)
    // showLoader()
    navigationLoading.value=true
    store.commit("user/updateUsersEndpoint", page)
    store.dispatch('user/fetchUsers').then(e=>{
        navigationLoading.value=false;
    }).catch(err=>{
        navigationLoading.value=false;
    })
}

const badgeText = (status) => {
	switch (status) {
		case true:
			return 'Active';
		case false:
			return 'Inactive';
		default:
			return 'Status'
	}
}

const badgeClass = (status) => {
	switch (status) {
		case true:
			return 'badge badge-success';
		case false:
			return 'badge badge-danger';
		default:
			return 'badge badge-warning'
	}
}

const enableUser = async (id)=> {
		Csrf.getCookie();
		Swal.fire({
		  title: 'Are you sure?',
		  text: "Are you sure want to enable this User!",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#50CD89',
		  cancelButtonColor: '#707070',
		  confirmButtonText: 'Enable'
		}).then((result) => {
		  if (result.value) {
			http.post(`${baseURL}/activate-user/${id}`, {
					'_method': 'POST'
				}).then(response => {
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'User enabled successfully.',
						showConfirmButton: false,
						timer: 2000,
						timerProgressBar: true,
					}).then(() => {
						store.dispatch('user/fetchUsers').then(() => {
							usersList.all = computed(() => store.getters['user/getAllUsers']);
							isLoading.value = false;
							hasData.value = usersList.all.data.length > 0;
						});
					});
				})
				.catch(error => {
				console.error(error);
				// handle error
			});
			
		  }
		});
}

const disableUser = async (id)=> {
	Csrf.getCookie();
	Swal.fire({
		title: 'Are you sure?',
		text: "Are you sure want to disable this User!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#707070',
		confirmButtonText: 'Disable'
	}).then((result) => {
		if (result.value) {
		http.post(`${baseURL}/disable-user/${id}`, {
				'_method': 'POST'
			}).then(response => {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'User disabled successfully.',
					showConfirmButton: false,
					timer: 2000,
					timerProgressBar: true,
				}).then(() => {
					store.dispatch('user/fetchUsers').then(() => {
						usersList.all = computed(() => store.getters['user/getAllUsers']);
						isLoading.value = false;
						hasData.value = usersList.all.data.length > 0;
					});
				});
			})
			.catch(error => {
			console.error(error);
			// handle error
		});
		
		}
		});
}
const searchFn = async ()=> {
        Csrf.getCookie();
		isLoading.value = true;
        http.post(`${baseURL}/search-user/`, {
            'query': searchQuery,
            '_method' : 'POST',
			page: page.value,
			pageSize: pageSize.value,
        })
        .then(response => {
			usersList.all = computed(() => response.data)
			isLoading.value = false;
        })
        .catch(error => {
			isLoading.value = false;
        	console.error(error);
        	// handle error
    });
}

</script>
