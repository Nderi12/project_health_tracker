<template>

	<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
		<!--begin::Logo-->
		<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
			<!--begin::Logo image-->
			<!-- <a href="#0">
				<img alt="Logo" src="./git-flow.png" class="h-50px app-sidebar-logo-default" />
				<img alt="Logo" src="./git-flow.png" class="h-50px app-sidebar-logo-minimize" />
			</a> -->
			<!--end::Logo image-->
			<!--begin::Sidebar toggle-->
			<div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
				<!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
				<span class="svg-icon svg-icon-2 rotate-180">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor" />
						<path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor" />
					</svg>
				</span>
				<!--end::Svg Icon-->
			</div>
			<!--end::Sidebar toggle-->
		</div>
		<!--end::Logo-->
		<!--begin::sidebar menu-->
		<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
			<!--begin::Menu wrapper-->
			<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
				<!--begin::Menu-->
				<div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">

					<!--begin:Menu item-->
					<div class="menu-item pt-5">
						<!--begin:Menu content-->
						<div class="menu-content">
							<span class="menu-heading fw-bold text-uppercase fs-7">DASHBOARD</span>
						</div>
						<!--end:Menu content-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div class="menu-item here show">
						<!--begin:Menu link-->
						<a class="menu-link" href="/dashboard" :class="{ 'active': currentRouteName === 'dashboard' }">
							<span class="menu-icon">
								<!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
								<span class="svg-icon svg-icon-2">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
										<rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="currentColor" />
										<rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="currentColor" />
										<rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="currentColor" />
									</svg>
								</span>
								<!--end::Svg Icon-->
							</span>
							<router-link :to="{ name: 'dashboard' }" class="nav-link"><span>Dashboard</span></router-link>
						</a>
						<!--end:Menu link-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div class="menu-item pt-5">
						<!--begin:Menu content-->
						<div class="menu-content">
							<span class="menu-heading fw-bold text-uppercase fs-7">REPOSITORIES</span>
						</div>
						<!--end:Menu content-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div data-kt-menu-trigger="click" class="menu-item menu-accordion" :class="{ 'hover show': isActiveRoute(['repositories', 'view-repository', ]) }">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
								<span class="svg-icon svg-icon-2">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor" />
										<rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor" />
									</svg>
								</span>
								<!--end::Svg Icon-->
							</span>
							<span class="menu-title">GITHUB</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin:Menu sub-->
						<div class="menu-sub menu-sub-accordion">
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" :class="{ 'active': isActiveRoute(['repositories', 'view-repository']) }">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<router-link :to="{ name: 'repositories' }" class="nav-link"><span>Repositories</span></router-link>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div class="menu-item pt-5">
						<!--begin:Menu content-->
						<div class="menu-content">
							<span class="menu-heading fw-bold text-uppercase fs-7">SETTINGS</span>
						</div>
						<!--end:Menu content-->
					</div>
					<!--end:Menu item-->
					<!--begin:Menu item-->
					<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
						<!--begin:Menu link-->
						<span class="menu-link">
							<span class="menu-icon">
								<!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
								<span class="svg-icon svg-icon-2">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor" />
										<rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor" />
									</svg>
								</span>
								<!--end::Svg Icon-->
							</span>
							<span class="menu-title">SETTINGS</span>
							<span class="menu-arrow"></span>
						</span>
						<!--end:Menu link-->
						<!--begin:Menu sub-->
						<div class="menu-sub menu-sub-accordion">
							<!--begin:Menu item-->
							<div class="menu-item">
								<!--begin:Menu link-->
								<a class="menu-link" href="#0">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<router-link :to="{ name: 'settings' }" class="nav-link"><span>Settings</span></router-link>
								</a>
								<!--end:Menu link-->
							</div>
							<!--end:Menu item-->
						</div>
						<!--end:Menu sub-->
					</div>
					<!--end:Menu item-->

				</div>
				<!--end::Menu-->
			</div>
			<!--end::Menu wrapper-->
		</div>
		<!--end::sidebar menu-->
		<!--begin::Footer-->
		<div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
			<a @click="showAlert" class="btn btn-flex flex-center btn-custom btn-secondary overflow-hidden text-nowrap px-0 h-40px w-100" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="200+ in-house components and 3rd-party plugins">
				<span class="btn-label">Live Reports</span>
				<!--begin::Svg Icon | path: icons/duotune/general/gen005.svg-->
				<span class="svg-icon btn-icon svg-icon-2 m-0">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z" fill="currentColor" />
						<rect x="7" y="17" width="6" height="2" rx="1" fill="currentColor" />
						<rect x="7" y="12" width="10" height="2" rx="1" fill="currentColor" />
						<rect x="7" y="7" width="6" height="2" rx="1" fill="currentColor" />
						<path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
					</svg>
				</span>
				<!--end::Svg Icon-->
			</a>
		</div>
		<!--end::Footer-->
	</div>

</template>

<script setup>
import { computed, onMounted } from 'vue'
import {useStore} from "vuex";
import { useRouter } from 'vue-router'
import { initializeComponents } from "@/core/plugins/keenthemes";

const cl =  console.log;
const router = useRouter()
const store = useStore()

const logout = () => {
    store.dispatch('user/logout')
    .then(res => {
        router.push({ name: 'login'})
    })
    .catch(err => err)
}

onMounted(() => {
	initializeComponents();
    store.dispatch('user/fetchUserProfile')
})

const userName = computed(() => store.getters['user/getCurrentUser'].first_name + ' ' +  store.getters['user/getCurrentUser'].last_name)
const userPhoneNumber = computed(() => store.getters['user/getCurrentUser'].phone_number)
const userEmail = computed(() => store.getters['user/getCurrentUser'].company_email)

const showAlert = () => {
	Swal.fire({
		position: 'center',
		icon: 'warning',
		title: 'This feature is coming soon...',
		showConfirmButton: false,
		timer: 3000,
		timerProgressBar: true,
	});
}

// Get the current route name
const currentRouteName = computed(() => router.currentRoute.value.name)

const isActiveRoute = (routeNames) => {
	return routeNames.includes(router.currentRoute.value.name);
}

</script>
