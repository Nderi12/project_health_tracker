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
                                    <h1 class="page-heading text-dark fw-bold fs-3 justify-content-center my-0">Repositories</h1>
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
									<!-- <router-link  class="btn btn-sm fw-bold btn-primary"
										>Sync Repos</router-link
									> -->
									<button class="btn btn-sm fw-bold btn-primary" @click="syncRepos"> Sync Repos </button>
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
										<span class="pt-1 fw-semibold fs-6">Repositories' List</span>
										<!--end::Title-->
										</div>
										<!--end::Info-->
									</div>
								</div>
								<div class="card-body">
									<div class="form-outline mb-5">
										<input type="search" id="search-form" v-model="searchQuery" @input="searchFn" class="form-control" placeholder="Search" aria-label="Search" />
									</div>
									<div class="text-center my-20" v-if="isLoading">
										<h4>Fetching repositories... <span class="spinner-border spinner-border-sm align-middle text-gray-600 mr-2"></span></h4>
									</div>

									<!--begin::Table container-->
									<div class="table-responsive" v-else-if="repositoriesList.all.data.length > 0">
									<!--begin::Table-->
										<table class="table table-row-bordered align-middle gy-4 gs-9">
											<thead class="border-bottom border-gray-200 fs-6 text-gray-600 fw-bolder bg-light bg-opacity-75">
												<tr>
													<td>#</td>
													<td>Name</td>
													<td>URL</td>
													<td>Description</td>
													<td>Action</td>
												</tr>
											</thead>
											<tbody class="fw-bold text-gray-600">
												<!--begin::Table row-->
												<tr v-for="(repository) in paginatedList" :key="repository.id">                                            
													<td>{{ repository.id }}</td>
													<td><router-link :to="{ name: 'view-repository', params: { id: repository.id } }">{{ repository.name }}</router-link> </td>
													<td>{{ repository.url }} </td>
													<td>{{ repository.description ?? 'Unavailable' }} </td>
													<td>
														<router-link :to="{ name: 'view-repository', params: { id: repository.id } }" class="btn btn-sm fw-bold btn-primary m-3"><i class="fa fa-eye"></i></router-link>
													</td>
												</tr>
												<!--end::Table row-->
											</tbody>
										</table>
									<!--end::Table-->
										<nav v-if="totalPages > 1">
											<ul class="pagination">
												<li class="page-item" :class="{ disabled: page === 1 }">
													<a class="page-link" href="#" @click.prevent="prevPage">Previous</a>
												</li>

												<li class="page-item" v-for="p in totalPages" :key="p" :class="{ active: p === page }">
													<a class="page-link" href="#" @click.prevent="page = p">{{ p }}</a>
												</li>

												<li class="page-item" :class="{ disabled: page === totalPages }">
													<a class="page-link" href="#" @click.prevent="nextPage">Next</a>
												</li>
											</ul>
										</nav>
									</div>
									<!--end::Table container-->
									<div class="text-center my-20" v-else>
										<h4>Repositories not found</h4>
									</div>
								</div>
								<!-- <div class="card-body text-center" v-else-if="isLoading === true && repositoriesList.all.data.length === 0">
									<h4>No Repositories Available</h4>
								</div> -->
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
import { computed, ref, onMounted, reactive } from 'vue';
import Header from './../include_files/PageHeader.vue';
import SideBar from './../include_files/PageSideBar.vue';
import Footer from './../include_files/PageFooter.vue';

import { initializeComponents } from "@/core/plugins/keenthemes";

import {useStore} from "vuex";

const store = useStore()

const isLoading = ref(true);

const page = ref(1);
const pageSize = ref(10);
const totalPages = ref(0);

let searchQuery;

onMounted(() => {
	initializeComponents();
    store.dispatch('user/fetchRepositories').then(() => {
		repositoriesList.all = computed(() => store.getters['user/getAllRepositories'])
		isLoading.value = false;
	});
})

const repositoriesList = reactive({
    all: '',
})

const header = computed(() => Header)
const sidebar = computed(() => SideBar)
const footer = computed(() => Footer)

const paginatedList = computed(() => {
	totalPages.value = Math.ceil(repositoriesList.all.data.length / pageSize.value);
    const startIndex = (page.value - 1) * pageSize.value;
    const endIndex = Math.min(startIndex + pageSize.value, repositoriesList.all.data.length);

	return repositoriesList.all.data.slice(startIndex, endIndex);
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
		isLoading.value = true;
        http.post(`${baseURL}/search-repositories/`, {
            'query': searchQuery,
            '_method' : 'POST',
			page: page.value,
			pageSize: pageSize.value,
        })
        .then(response => {
			repositoriesList.all = computed(() => response.data)
			isLoading.value = false;
        })
        .catch(error => {
			isLoading.value = false;
        	console.error(error);
        	// handle error
    });
}

const syncRepos = async ()=> {
	Csrf.getCookie();
	store.dispatch('user/syncRepositories')
			.then(response => {
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Sync process initiated successfully!',
						showConfirmButton: false,
						timer: 2000,
						timerProgressBar: true,
					});
				});
}

</script>
