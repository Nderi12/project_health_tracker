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
                                    <h1 class="page-heading text-dark fw-bold fs-3 justify-content-center my-0">Repository</h1>
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
							<div class="row m-0">
								<div class="col-xl-4">
									<div class="card mt-3">
										<div class="col mt-5">
											<table class="table table-row-borderless align-middle gy-4 gs-9">
												<tbody>
													<tr class="mb-5">
														<th class="w-25"><b> Name: </b></th>
														<td>{{ singleRepositoryItem.all.name }}</td>
													</tr>
													<tr class="mb-5">
														<th class="w-25"><b> Status: </b></th>
														<td><StatusBadge :status="singleRepositoryItem.all.status" /></td>
													</tr>
													<tr class="mb-5">
														<th class="w-25"><b> URL: </b></th>
														<td>{{ singleRepositoryItem.all.url }}</td>
													</tr>
													<tr class="mb-5">
														<th class="w-25"><b> Description: </b></th>
														<td>{{ singleRepositoryItem.all.description ?? 'N/A'}}</td>
													</tr>
													<tr class="mb-5">
														<th class="w-25"><b> Created on: </b></th>
														<td>{{ Date(singleRepositoryItem.all.created_at) }}</td>
													</tr>
													<tr class="mb-5">
														<th class="w-25"><b> Last updated on: </b></th>
														<td>{{ Date(singleRepositoryItem.all.updated_at) }}</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="col-xl-8">
									<div class="card mt-3" v-if="singleRepositoryItem.all !== ''">
										<div class="card-body">                                    
											<nav>
												<div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
													<button class="nav-link active" id="nav-health-tab" data-bs-toggle="tab" data-bs-target="#nav-health" type="button" role="tab" aria-controls="nav-health" aria-selected="false">Health Check</button>
													<button class="nav-link" id="nav-branches-tab" data-bs-toggle="tab" data-bs-target="#nav-branches" type="button" role="tab" aria-controls="nav-branches" aria-selected="false"> Branches ({{ singleRepositoryItem.all.branches.length }})</button>
												</div>
											</nav>
											<div class="tab-content" id="nav-tabContent">
												<div class="tab-pane fade show active" id="nav-health" role="tabpanel" aria-labelledby="nav-health-tab">
													<div class="row mb-5 g-5 g-xl-10">
														<h3 class="mb-5 mt-20">Dashboard</h3>
														<component :is="repoCards"></component>
														<!-- <bar-chart :data="barChartData"></bar-chart> -->
													</div>
												</div>
												<div class="tab-pane fade" id="nav-branches" role="tabpanel" aria-labelledby="nav-branches-tab">
													<div class="col mt-5">
														<div class="scrollable-table">
															<table class="table table-row-striped align-middle gy-4 gs-9" v-if="singleRepositoryItem.all.branches.length !== 0 && singleRepositoryItem.all.branches !== null">
																<thead class="border-bottom border-gray-200 fs-6 text-gray-600 fw-bolder bg-light bg-opacity-75">
																	<tr>
																		<td>#</td>
																		<td>name</td>
																		<td>Total commits</td>
																	</tr>
																</thead>
																<tbody class="fw-bold text-gray-600">
																	<!--begin::Table row-->
																	<tr v-for="(value) in singleRepositoryItem.all.branches" :key="value.id">
																		<td>{{ value.id }} </td>
																		<td>{{ value.name }} </td>
																		<td>{{ value.commits.length }} </td>
																	</tr>
																	<!--end::Table row-->
																</tbody>
															</table>
															<div class="text-center my-20" v-else>
																<h4>Branches not found</h4>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="card" v-else>
										<div class="card-body">
											<div class="text-center my-20">
												<h4>Fetching repository info... <span class="spinner-border spinner-border-sm align-middle text-gray-600 mr-2"></span></h4>
											</div>
										</div>
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
import RepoCards from '../cards/repo_top_cards.vue'

import { initializeComponents } from "@/core/plugins/keenthemes";

import {useStore} from "vuex";
import { useRouter, useRoute } from 'vue-router';
import Swal from 'sweetalert2';

const store = useStore()
const route = useRoute()

const header = computed(() => Header)
const sidebar = computed(() => SideBar)
const footer = computed(() => Footer)
const repoCards = computed(() => RepoCards)

let name;
const isProcessing = ref(false);

const id = route.params.id

const singleRepositoryItem = reactive({
    all: '',
});

onMounted(() => {
	initializeComponents();
    store.dispatch('user/fetchSingleRepository', id).then(() => {
		singleRepositoryItem.all = computed(() => store.getters['user/getSingleRepository'])
		repoHealthStatus.all = computed(() => store.getters['user/getRepoHealthStatus'])
		setBarChartData();
	});
})

// Chart data state
const barChartData = reactive({
  labels: [],
  datasets: [
    {
      label: 'Commits per Branch',
      backgroundColor: '#f87979',
      data: [],
    },
  ],
});

// Function to set chart data
const setBarChartData = () => {
  if (singleRepositoryItem.all.healthStatus) {
    barChartData.labels = Object.keys(singleRepositoryItem.all.healthStatus.branchCommits);
    barChartData.datasets[0].data = Object.values(singleRepositoryItem.all.healthStatus.branchCommits);
  }
};
</script>
<style scoped>
	.scrollable-table {
		max-height: 300px; /* Adjust the height as needed */
		overflow-y: auto;
	}

	.bar-chart {
		width: 100%;
		height: 400px; /* Adjust the height as needed */
	}
</style>