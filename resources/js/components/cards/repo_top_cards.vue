<template>
  <div class="row m-0">
    <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mb-3">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"></div>
              Branches
            </div>
            <div class="col-auto">
              <div class="fas fa-code-branch fa-2x text-secondary-300" style="color: green;"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-auto mt-5">
              <div class="h6 mb-0 font-weight-bold text-primary" v-if="!hasData">KSH. <span class="spinner-border spinner-border-sm align-middle text-black mr-2"></span></div>
              <div class="h6 mb-0 font-weight-bold text-primary" v-else>{{ repoHealthStatus.all.totalCommits }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mb-3">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"></div>
              Commits
            </div>
            <div class="col-auto">
              <div class="fas fa-code-commit fa-2x text-primary-300"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-auto mt-5">
              <div class="h6 mb-0 font-weight-bold text-primary" v-if="!hasData">KSH. <span class="spinner-border spinner-border-sm align-middle text-black mr-2"></span></div>
              <div class="h6 mb-0 font-weight-bold text-primary" v-else>{{ repoHealthStatus.all.totalCommits }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mb-3">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"></div>
              Total Deployments
            </div>
            <div class="col-auto">
              <div class="fas fa-circle-play fa-2x text-primary" style="color: red;"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-auto mt-5">
              <div class="h6 mb-0 font-weight-bold text-primary" v-if="!hasData">KSH. <span class="spinner-border spinner-border-sm align-middle text-black mr-2"></span></div>
              <div class="h6 mb-0 font-weight-bold text-primary" v-else>{{ repoHealthStatus.all.totalCommits }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import {
  baseURL,
  http,
  Csrf,
} from "../../boot";
import { computed, onMounted, ref, reactive, watch, watchEffect } from 'vue';

import { initializeComponents } from "@/core/plugins/keenthemes";

import {useStore} from "vuex";
import { useRouter, useRoute } from 'vue-router';
import Swal from 'sweetalert2';

const store = useStore()
const route = useRoute()

let name;
const hasData = ref(false);

const id = route.params.id

const repoHealthStatus = reactive({
    all: '',
});

onMounted(() => {
	initializeComponents();
  repoHealthStatus.all = computed(() => store.getters['user/getRepoHealthStatus'])
  hasData.value = repoHealthStatus.all != null;
  //   store.dispatch('user/fetchSingleRepository', id).then(() => {
	// });
})
</script>