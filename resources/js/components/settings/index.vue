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
                                    <h1 class="page-heading text-dark fw-bold fs-3 justify-content-center my-0">Settings</h1>
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
									<router-link :to="{ name: 'create-setting' }" class="btn btn-sm fw-bold btn-primary"
										>Create Setting</router-link
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
										<span class="pt-1 fw-semibold fs-6">Settings' List</span>
										<!--end::Title-->
										</div>
										<!--end::Info-->
									</div>
								</div>
								<div class="card-body" v-if="settingsList.all.length > 0">
									<div class="form-outline mb-5">
										<input type="search" id="search-form" v-model="searchQuery" @input="searchFn" class="form-control" placeholder="Search" aria-label="Search" />
									</div>
									<!--begin::Table container-->
									<div class="table-responsive">
										<!--begin::Table-->
											<table class="table table-row-bordered align-middle gy-4 gs-9">
												<thead class="border-bottom border-gray-200 fs-6 text-gray-600 fw-bolder bg-light bg-opacity-75">
													<tr>
														<td>#</td>
														<td>Name</td>
														<td>Description</td>
														<td>Action</td>
													</tr>
												</thead>
												<tbody class="fw-bold text-gray-600">
													<!--begin::Table row-->
													<tr v-for="(setting, index) in paginatedList" :key="setting.id">                                            
														<td>{{ index+1 }} </td>
														<td>{{ setting.name }} </td>
														<td>{{ setting.description }}</td>
														<td>
															<router-link :to="{ name: 'view-setting', params: { id: setting.id } }" class="btn btn-sm fw-bold btn-primary m-3"><i class="fa fa-eye"></i></router-link>
															<router-link :to="{ name: 'edit-setting', params: { id: setting.id } }" class="btn btn-sm fw-bold btn-primary m-3"><i class="fa fa-edit"></i></router-link>
														</td>
													</tr>
													<!--end::Table row-->
												</tbody>
											</table>
										<!--end::Table-->
										<!-- <pagination :page_links="page_links" @pagenavigate="navigateToPage" :loadingPage="navigationLoading"></pagination> -->
									</div>
									<!--end::Table container-->
								</div>
								<div class="card-body text-center" v-else>
									<h4>Fetching settings... <span class="spinner-border spinner-border-sm align-middle text-gray-600 mr-2"></span></h4>
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

import { initializeComponents } from "@/core/plugins/keenthemes";

import {useStore} from "vuex";
import { useRouter } from 'vue-router'
import Swal from 'sweetalert2';

const store = useStore()
const isSearching = ref(false)

const page = ref(1);
const pageSize = ref(10);
const totalPages = ref(0);

let searchQuery;

onMounted(() => {
	initializeComponents();
    store.dispatch('user/fetchSettings');
})

const settingsList = reactive({
    all: ''
})


const header = computed(() => Header)
const sidebar = computed(() => SideBar)
const footer = computed(() => Footer)

setTimeout(() => {
	settingsList.all = computed(() => store.getters['user/getAllSettings'])
	isLoading.value = false;
}, 2000);

const paginatedList = computed(() => {
	totalPages.value = Math.ceil(settingsList.all.length / pageSize.value);
    const startIndex = (page.value - 1) * pageSize.value;
    const endIndex = Math.min(startIndex + pageSize.value, settingsList.all.length);

	return settingsList.all.slice(startIndex, endIndex);
});

function nextPage() {
	if (page.value < totalPages.value) {
		return page.value++;
	}
}

function prevPage() {
	if (page.value > 1) {
		return page.value--;
	}
}

const searchFn = async ()=> {
        Csrf.getCookie();
        isSearching.value = true;
        http.post(`${baseURL}/search-settings/`, {
            'query': searchQuery,
            '_method' : 'POST',
        })
        .then(response => {
			settingsList.all = computed(() => response.data)
        })
        .catch(error => {
        isSearching.value = false;
        console.error(error);
        // handle error
    });
}

</script>
