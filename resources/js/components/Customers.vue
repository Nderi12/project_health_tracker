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
                                    <h1 v-if="customerList.all.success === false" class="page-heading text-dark fw-bold fs-3 justify-content-center my-0">Customers - <span class="text-gray-600">USSD (0 found)</span></h1>
                                    <h1 v-if="customerList.all.length > 0 && customerList.all.success !== false" class="page-heading text-dark fw-bold fs-3 justify-content-center my-0">Customers - <span class="text-gray-600">USSD</span></h1>
                                    <h1 v-if="customerList.all.length === 0 && customerList.all.success !== false" class="page-heading text-dark fw-bold fs-3 justify-content-center my-0 text-gray-500">Customers... <span class="spinner-border spinner-border-sm align-middle text-gray-600 mr-2"></span></h1>
									<!--end::Title-->
								</div>
								<!--end::Page title-->
							</div>
							<!--end::Toolbar container-->
						</div>
						<!--end::Toolbar-->
						<!--begin::Content-->
						<div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-bordered align-middle gy-4 gs-9">
                                    <thead class="border-bottom border-gray-200 fs-6 text-gray-600 fw-bolder bg-light bg-opacity-75">
                                        <tr>
                                            <td>Name</td>
                                            <td>Identification</td>
                                            <td>Phone Number</td>
                                            <td>Toll Acount ID(s)</td>
                                            <td>USSD Activated</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-bold text-gray-600">
                                        <!--begin::Table row-->
                                        <tr v-for="(singleCustomer) in customerList.all" :key="singleCustomer.id">
                                            <td>
                                                {{ singleCustomer.full_name }} - <span :class="singleCustomer.account_type == 'Individual' ? 'badge badge-light-primary' : 'badge badge-light-info'" class="p-1"><small class="">{{ singleCustomer.account_type }}</small></span>
                                                <br>
                                                <span v-if="singleCustomer.service_request_id!=null && singleCustomer.status!=9" @click="viewServiceRequest(singleCustomer.customer_id)" class="badge badge-light-warning mt-1">Support Request Active</span>
                                                <span v-if="singleCustomer.status==9" class="badge badge-light-danger mt-1">Account Archived</span>

                                            </td>
                                            <td>{{ singleCustomer.id_document_type }} : {{ singleCustomer.id_document_number }} - {{ singleCustomer.company_name }} </td>
                                            <td>{{ singleCustomer.phone_number }}</td>
                                            <td>{{ singleCustomer.toll_account_id }}</td>
                                            <td>
                                                <a>{{ moment(singleCustomer.created_at).format("MMM DD, YYYY") }}</a>
                                                <span class="text-gray-400"> -- {{ singleCustomer.created_at_diff }}</span>
                                            </td>

                                            <td>
                                                <button class="btn btn-sm btn-light-primary" @click="viewCustomer(singleCustomer)"><i class="fa fa-eye"></i></button>
                                            </td>
                                        </tr>
                                        <!--end::Table row-->
                                    </tbody>
                                </table>
                                <!--end::Table-->
                                <pagination :page_links="page_links" @pagenavigate="navigateToPage" :loadingPage="navigationLoading"></pagination>

                                <div class="modal fade" :id="'kt_customer_view_modal'" tabindex="-1" aria-hidden="true">
                                    <!--begin::Modal dialog-->
                                    <div class="modal-dialog modal-dialog-centered modal-lg">

                                        <div v-if="customers.singleCustomerDynamic===''" class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-muted">Fetching Customer <span><span class="spinner-border spinner-border-sm align-middle ms-2"></span></span></h5>

                                                <!--begin::Close-->
                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                                    <span class="svg-icon svg-icon-2x"></span>
                                                </div>
                                                <!--end::Close-->
                                            </div>
                                        </div>

                                        <!--begin::Modal content-->
                                        <div v-if="customers.singleCustomerDynamic!==''" class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">View Customer
                                                </h5>

                                                <!--begin::Close-->
                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                                    <i class="fa fa-times"></i>
                                                </div>
                                                <!--end::Close-->
                                            </div>
                                            <!--begin::Modal body-->
                                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                                <div class="row mt-5">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="customer">Full Name</label>
                                                            <p class="text-black mt-1">{{customers.singleCustomerDynamic.full_name}}
                                                                <a href="#0" :class="customers.singleCustomerDynamic.account_type == 'Individual' ? 'badge-light-primary' : 'badge-light-info'" class="badge">{{ customers.singleCustomerDynamic.account_type }}</a>
                                                                <span v-if="customers.singleCustomerDynamic.status==9" class="badge badge-light-danger mt-1">Account Archived</span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="customer">Phone Number</label>
                                                            <p class="text-black mt-1">{{(customers.singleCustomerDynamic.phone_number??'N/A')}}</p>
                                                            <span v-if="customers.singleCustomerDynamic.phone_number_verified_at==null" class="badge badge-warning">Unverified</span>
                                                            <span v-if="customers.singleCustomerDynamic.phone_number_verified_at!=null" class="badge badge-primary">Verified at : {{moment(customers.singleCustomerDynamic.phone_number_verified_at).format("MMM DD, YYYY") }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="customer">Gender</label>
                                                            <p class="text-black mt-1">{{customers.singleCustomerDynamic.gender}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-5">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="customer">{{customers.singleCustomerDynamic.id_document_type}}</label>
                                                            <p class="text-black mt-1">{{(customers.singleCustomerDynamic.id_document_number??'N/A')}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="customer">Toll Account ID(s)</label>
                                                            <p class="text-black mt-1">{{(customers.singleCustomerDynamic.toll_account_id??'N/A')}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-5">
                                                    <div class="col-md-4" v-if="customers.singleCustomerDynamic.account_type=='Corporate'">
                                                        <div class="form-group">
                                                            <label for="customer">Company Name</label>
                                                            <p class="text-black mt-1">{{(customers.singleCustomerDynamic.company_name??'N/A') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4" v-if="customers.singleCustomerDynamic.account_type=='Corporate'">
                                                        <div class="form-group">
                                                            <label for="customer">Company Email</label>
                                                            <p class="text-black mt-1">{{(customers.singleCustomerDynamic.company_email??'N/A') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4" v-if="customers.singleCustomerDynamic.account_type=='Corporate'">
                                                        <div class="form-group">
                                                            <label for="customer">Company Physical Address</label>
                                                            <p class="text-black mt-1">{{(customers.singleCustomerDynamic.company_physical_address??'N/A') }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4" v-if="customers.singleCustomerDynamic.account_type=='Corporate'">
                                                        <div class="form-group">
                                                            <label for="customer">Company Postal Address</label>
                                                            <p class="text-black mt-1">{{(customers.singleCustomerDynamic.company_postal_address??'N/A') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Modal body-->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal" :id="'kt_application_view_modal_btn_'+customers.singleCustomerDynamic.id">Close</button>
                                            </div>
                                        </div>
                                        <!--end::Modal content-->
                                    </div>
                                    <!--end::Modal dialog-->
                                </div>

                            </div>
                            <!--end::Table container-->
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
import { computed, onMounted, ref, reactive, watch, watchEffect } from 'vue';
import Header from './include_files/PageHeader.vue';
import SideBar from './include_files/PageSideBar.vue';
import Footer from './include_files/PageFooter.vue';

import { initializeComponents } from "@/core/plugins/keenthemes";

import {useStore} from "vuex";
import { useRouter } from 'vue-router'
import moment from 'moment'
import Swal from 'sweetalert2';
import Pagination from './include_files/PaginationLinks.vue';

const store = useStore()
const router = useRouter()
// const swal =

const isWorking = ref(false)
const isSearching = ref(false)
let errorMessage = ref('')
let successMessage=ref('')
let success=ref(false)
let error=ref(false)
let errors = ref({})
const fullPage = ref(true);
let formContainer = ref(null);

onMounted(() => {
	initializeComponents();
    store.dispatch('user/fetchCustomers');
})

const customerList = reactive({
    all: '',
})

const header = computed(() => Header)
const sidebar = computed(() => SideBar)
const footer = computed(() => Footer)

customerList.all = computed(() => store.getters['user/getAllCustomers'])
const page_links = computed(() => store.getters['user/getAllCustomersLinks'])
const navigationLoading=ref(false)

const customers = reactive({
	search:'',
	singleCustomerDynamic: ''
})

const showStatus= ref(false)
const exportExcel = async () => {
	// isbuidingPDFId.value = appId
	// isbuidingPDF.value = true
	store.dispatch('user/exportApplicationsExcel', {})
	.then(response => {
		// isbuidingPDF.value = false
		// isbuidingPDFId.value = ''
	})
	.catch(error => {
		// isbuidingPDF.value = false
		errorMessage.value = error.response.data.message !== undefined ? error.response.data.message : ''
		errors.value = error.response.data.errors
	})
}

const searchCustomers = async () => {
	isSearching.value = true
	store.dispatch("user/fetchApplications", reactive({search: customers.search, filter:applicationsFilter }))
	.then(response => {
        context.commit('updateAllApplicationsLinks',response.data.page_links);
		// customers.isSearching = false
		isSearching.value = false
		// console.log(response.data.applications)
		// customerList.all=''
		// if(response.data.applications==''){
		// 	alert("no applications")
		// 	customerList.all=response.data.applications
		// }
	})
	.catch(error => {
		// customers.isSearching = false
		isSearching.value = false
		errorMessage.value = error.response.data.message !== undefined ? error.response.data.message : ''
		errors.value = error.response.data.errors
	})
}

const navigateToPage=async (page)=>{
    // showLoader()
    navigationLoading.value=true
    store.commit("user/updateCustomersEndpoint",page)
    store.dispatch('user/fetchCustomers').then(e=>{
        navigationLoading.value=false;
        // hideLoader()
    }).catch(err=>{
        navigationLoading.value=false;
        // hideLoader()
    })
}

const viewCustomer=async (singleCustomer)=>{
    errorMessage.value = ''
    successMessage.value = ''
    customers.singleCustomerDynamic = ''
    $('#kt_customer_view_modal').modal('show');
    store.dispatch('user/fetchCustomer',singleCustomer.customer_id).then(result=>{
        customers.singleCustomerDynamic = result.data
        singleCustomer = result.data
    })
}

const showAlert = () => {
	Swal.fire({
		position: 'top-end',
		icon: 'info',
		title: 'Hello world!',
		showConfirmButton: false,
		timer: 2000,
		timerProgressBar: true,
	});
}

</script>
