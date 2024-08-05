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
									<!-- <router-link :to="{ name: 'create-laundromats' }" class="btn btn-sm fw-bold btn-primary"
										>Create Laundromat</router-link
									> -->
									<!--end::Primary button-->
								</div>
							</div>
							<!--end::Toolbar container-->
						</div>
						<!--end::Toolbar-->
						<!--begin::Content-->
						<div id="kt_app_content" class="app-content flex-column-fluid">
							<div class="card m-5" v-if="singleUserItem.all !== '' && singleUserItem.all.length !== 0">
								<div class="card-header pt-5">
                                    <div class="d-flex align-items-center gap-2 gap-lg-3" v-if="singleUserItem.all.status == 0 && singleUserItem.all !== '' && singleUserItem.all.length !== 0">
                                        <!--begin::Primary button-->
                                        <button class="btn btn-sm fw-bold btn-success" @click="enableUser(id)">Enable</button>
                                        <!--end::Primary button-->
                                    </div>
								</div>
								<div class="card-body">                                    
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-candidate-tab" data-bs-toggle="tab" data-bs-target="#nav-candidate" type="button" role="tab" aria-controls="nav-candidate" aria-selected="true">Candidate Description</button>
                                            <button class="nav-link" id="nav-applications-tab" data-bs-toggle="tab" data-bs-target="#nav-applications" type="button" role="tab" aria-controls="nav-applications" aria-selected="false">Candidate Applications - <span>{{ singleCandidateItem.all.job_applications.length }}</span> </button>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-candidate" role="tabpanel" aria-labelledby="nav-candidate-tab">
                                            <div class="col mt-5">
                                                <table class="table table-row-bordered align-middle gy-4 gs-9">
                                                    <tbody>
                                                        <tr class="mb-5">
                                                            <th class="w-25"><b> Name: </b></th>
                                                            <td>{{ singleUserItem.all.first_name + ' ' + singleUserItem.all.middle_name + ' ' + singleUserItem.all.last_name + '' }}
                                                            </td>
                                                        </tr>
														<tr class="mb-5">
                                                            <th class="w-25"><b> Status: </b></th>
                                                            <td><StatusBadge :status="singleUserItem.all.status" /></td>
                                                        </tr>
                                                        <tr class="mb-5">
                                                            <th class="w-25"><b> Phone Number: </b></th>
                                                            <td>{{ singleUserItem.all.phone_number}}</td>
                                                        </tr>
                                                        <tr class="mb-5">
                                                            <th class="w-25"><b> Email Address: </b></th>
															<td>{{ singleUserItem.all.email}}</td>
                                                        </tr>
                            
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                    </div>
								</div>
							</div>
                            <div class="card" v-else>
                                <div class="card-body">
                                    <div class="text-center my-20">
										<h4>Fetching user info... <span class="spinner-border spinner-border-sm align-middle text-gray-600 mr-2"></span></h4>
									</div>
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
import {
  baseURL,
  http,
  Csrf,
} from "../../boot";
import { computed, onMounted, ref, reactive, watch, watchEffect } from 'vue';
import Header from './../include_files/PageHeader.vue';
import SideBar from './../include_files/PageSideBar.vue';
import Footer from './../include_files/PageFooter.vue';
import StatusBadge from '../../components/Customs/status-badge.vue';

import { initializeComponents } from "@/core/plugins/keenthemes";

import {useStore} from "vuex";
import { useRouter, useRoute } from 'vue-router';
import Swal from 'sweetalert2';

const store = useStore()
const route = useRoute()

const header = computed(() => Header)
const sidebar = computed(() => SideBar)
const footer = computed(() => Footer)

let first_name;
let middle_name;
let last_name;
let email;
let phone_number;
let password;

const isProcessing = ref(false);

const id = route.params.id

onMounted(() => {
	initializeComponents();
    store.dispatch('user/fetchSingleUser', id);
})

const singleUserItem = reactive({
    all: '',
})

setTimeout(() => {
	singleUserItem.all = computed(() => store.getters['user/getSingleUser'])
}, 2000);


const enableUser = async (id)=> {
		Csrf.getCookie();
		Swal.fire({
		  title: 'Are you sure?',
		  text: "Are you sure want to enable this user",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Enable'
		}).then((result) => {
		  if (result.value) {
			http.post(`${baseURL}/activate-user/${id}`, {
					'_method': 'POST'
				}).then(response => {
					Swal.fire(
					'Enabled!',
					'User enabled successfully!',
					'success'
					).then(() => {
						store.dispatch('user/fetchSingleUser', id);
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
		text: "Are you sure want to disable this user",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Disable'
	}).then((result) => {
		if (result.value) {
		http.post(`${baseURL}/disable-user/${id}`, {
				'_method': 'POST'
			}).then(response => {
				Swal.fire(
				'Enabled!',
				'User disabled successfully!',
				'success'
				).then(() => {
					// close modal
					store.dispatch('user/fetchSingleUser ', id);
				});
			})
			.catch(error => {
			console.error(error);
			// handle error
		});
		
		}
		});
}

</script>