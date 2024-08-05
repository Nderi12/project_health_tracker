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
                                    <h1 class="page-heading text-dark fw-bold fs-3 justify-content-center my-0">Setting</h1>
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
											<span class="pt-1 fw-semibold fs-6">Create a new setting</span>
											<!--end::Title-->
											</div>
											<!--end::Info-->
										</div>
									</div>
									<div class="card-body">
										<form @submit.prevent="create">
											<div class="form-row">
												<div class="row">
													<div class="col-12">
														<div class="form-group col-md-12 mb-5">
															<label for="name">Name</label>
															<input type="text" class="form-control" id="name" placeholder="Name" v-model="name" required>
														</div>
													</div>
													<div class="form-group col-md-12 mb-5">
														<label class="form-label">Type</label>
														<select class="form-select" v-model="type" required>
															<option value="single">Single</option>
															<option value="multiple">Multiple</option>
														</select>
													</div>
													<div class="col-12">
														<div class="form-group col-md-12 mb-5">
															<label for="description">Description</label>
															<input type="text" class="form-control" id="description" placeholder="Description" v-model="description" required>
														</div>
													</div>
												</div>
											</div>
											<button type="submit" class="btn btn-primary" v-if="isSaving === false">Create</button>
											<button type="button" class="btn btn-primary" v-else>Creating <span class="spinner-border spinner-border-sm align-middle text-white mr-2"></span></button>
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
import StatusBadge from '../../components/Customs/status-badge.vue';

import { initializeComponents } from "@/core/plugins/keenthemes";

import {useStore} from "vuex";
import { useRouter, useRoute } from 'vue-router';
import Swal from 'sweetalert2';

const store = useStore()
const router = useRoute()

const header = computed(() => Header)
const sidebar = computed(() => SideBar)
const footer = computed(() => Footer)

let name;
let description;
let type;

const isSaving = ref(false);

onMounted(() => {
	initializeComponents();
})

const create = async ()=> {
        Csrf.getCookie();
        isSaving.value = true;
        http.post(`${baseURL}/create-settings/`, {
            'name': name,
            'type' : type,
            'description' : description,
            '_method' : 'POST',
        })
        .then(response => {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Setting created successfully!',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            }).then(() => {
                router.push('/settings')
            });
        })
        .catch(error => {
        isSaving.value = false;
        console.error(error);
        // handle error
    });
}

</script>