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
							<div class="card m-5" v-if="singleSettingItem.all !== '' && singleSettingItem.all.length !== 0">
								<div class="card-header pt-5">
                                    <div class="d-flex align-items-center gap-2 gap-lg-3" v-if="singleSettingItem.all !== '' && singleSettingItem.all.length !== 0">
                                        <!--begin::Primary button-->
                                        <button class="btn btn-sm fw-bold btn-primary" @click="createSettingValue(id)">Add setting value</button>
                                        <!--end::Primary button-->
                                    </div>
								</div>
								<div class="card-body">                                    
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-setting-tab" data-bs-toggle="tab" data-bs-target="#nav-setting" type="button" role="tab" aria-controls="nav-setting" aria-selected="true">Setting Information</button>
                                            <button class="nav-link" id="nav-setting-values-tab" data-bs-toggle="tab" data-bs-target="#nav-setting-values" type="button" role="tab" aria-controls="nav-setting-values" aria-selected="false">Setting Values</button>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-setting" role="tabpanel" aria-labelledby="nav-setting-tab">
                                            <div class="col mt-5">
                                                <table class="table table-row-bordered align-middle gy-4 gs-9">
                                                    <tbody>
                                                        <tr class="mb-5">
                                                            <th class="w-25"><b> Name: </b></th>
                                                            <td>{{ singleSettingItem.all.name }}</td>
                                                        </tr>
                                                        <tr class="mb-5">
                                                            <th class="w-25"><b> Description: </b></th>
                                                            <td>{{ singleSettingItem.all.description }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nav-setting-values" role="tabpanel" aria-labelledby="nav-setting-values-tab">
                                            <div class="col mt-5">
                                                <table class="table table-row-bordered align-middle gy-4 gs-9">
                                                    <thead class="border-bottom border-gray-200 fs-6 text-gray-600 fw-bolder bg-light bg-opacity-75">
                                                        <tr>
                                                            <td>#</td>
                                                            <td>Name</td>
                                                            <td>Action</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="fw-bold text-gray-600">
                                                        <!--begin::Table row-->
                                                        <tr v-for="(value) in settingValueItems.all" :key="value.id">                                            
                                                            <td>{{ value.id }} </td>
                                                            <td>{{ value.name }} </td>
                                                            <td>
                                                                <button class="btn btn-sm fw-bold btn-primary m-3">Edit</button>
                                                            </td>
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
								</div>
							</div>
                            <div class="card text-center" v-else>
                                <div class="card-body">
                                    <h4>Fetching Setting... <span class="spinner-border spinner-border-sm align-middle text-gray-600 mr-2"></span></h4>
                                </div>
                            </div>
						</div>
						<!--end::Content-->
					</div>
					<!--end::Content wrapper-->
                    <!--begin::create laundry task modal-->
                    <div class="modal fade" :id="'kt_create_setting_value_modal'" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-lg modal-dialog">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Create a new setting value</h5>

                                    <!--begin::Close-->
                                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-times"></i>
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--begin::Modal body-->
                                <div class="modal-body">
                                    <form @submit.prevent="saveSettingValue()">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group col-md-12 mb-5">
                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control" id="name" placeholder="Name" v-model="name" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button type="submit" class="btn btn-success align-items-start" v-if="isProcessing === false">Create</button>
														<button type="button" class="btn btn-success" v-else>Creating <span class="spinner-border spinner-border-sm align-middle text-white mr-2"></span></button>
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal" :id="'kt_application_view_modal_btn_'+id">Close</button>
                                        </div>
                                    </form>

                                </div>
                                <!--end::Modal body-->
                            </div>
                            <!--end::Modal content-->
                        </div>
                        <!--end::Modal dialog-->
                    </div>
                    <!--end::create laundry task modal-->
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

let name;
const isProcessing = ref(false);

const id = route.params.id

onMounted(() => {
	initializeComponents();
    store.dispatch('user/fetchSingleSetting', id);
    store.dispatch('user/fetchSettingValue', id);
})

const singleSettingItem = reactive({
    all: '',
})

const settingValueItems = reactive({
    all: '',
})

singleSettingItem.all = computed(() => store.getters['user/getSingleSetting'])
settingValueItems.all = computed(() => store.getters['user/getAllSettingValue'])

const createSettingValue=async (id)=>{
    $('#kt_create_setting_value_modal').modal('show');
}

const saveSettingValue = async ()=> {
        Csrf.getCookie();
        isProcessing.value = true;
        http.post(`${baseURL}/create-setting-values/`, {
            'setting_id' : singleSettingItem.all.id,
            'name': name,
        })
        .then(response => {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Setting value created successfully!',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            }).then(() => {
                // close modal
                $('#kt_create_task_modal').modal('hide');
                location.reload()
            });
        })
        .catch(error => {
        isProcessing.value = false;
        console.error(error);
        // handle error
    });
}

</script>