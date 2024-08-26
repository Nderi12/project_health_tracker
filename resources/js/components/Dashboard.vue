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
						<!--begin::Content-->
						<div id="kt_app_content" class="app-content flex-column-fluid">
							<!--begin::Content container-->
							<div id="kt_app_content_container" class="app-container container-xxl">
								<div class="row mb-5 g-5 g-xl-10">
									<h3 class="mb-5 mt-20">Dashboard</h3>
									<component :is="topCards"></component>
								</div>
								<div class="row mb-5 g-5 g-xl-10">
									<h3 class="mb-5 mt-20">Health Statistics</h3>
									<component :is="IncomeExpenseChart"></component>
								</div>
							</div>
							<!--end::Content container-->
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
import { computed, onMounted } from 'vue';
import Header from './include_files/PageHeader.vue';
import SideBar from './include_files/PageSideBar.vue';
import Footer from './include_files/PageFooter.vue';
import TopCards from './cards/dashboard_top_cards.vue';
import IncomeExpenseChart from './cards/income_expense_chart.vue';
import ProductsListCard from './cards/dashboard_products_list.vue';

import { initializeComponents } from "@/core/plugins/keenthemes";

import {useStore} from "vuex";
import { useRouter } from 'vue-router'
import Swal from 'sweetalert2';

const store = useStore()
const router = useRouter()

onMounted(() => {
	initializeComponents();	
})

const header = computed(() => Header)
const sidebar = computed(() => SideBar)
const footer = computed(() => Footer)
const topCards = computed(() => TopCards)
const incomeExpenseChart = computed(() => IncomeExpenseChart)
const productsListCards = computed(() => ProductsListCard)

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
