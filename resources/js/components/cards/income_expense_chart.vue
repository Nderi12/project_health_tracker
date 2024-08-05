<template>
  <!--begin::Card widget 4-->
  <div class="card card-flush shadow h-md-auto mb-5 mb-xl-10">
    <!--begin::Header-->
    <div class="card-header pt-5">
      <!--begin::Title-->
      <div class="card-title d-flex flex-column">
        <!--begin::Info-->
        <div class="d-flex align-items-center">
          <!--begin::Title-->
          <span class="pt-1 fw-semibold fs-6">Income Vs. Expense Chart</span>
          <!--end::Title-->
        </div>
        <!--end::Info-->
      </div>
      <!--end::Title-->
    </div>
    <!--end::Header-->
    <!--begin::Card body-->
    <div class="card-body d-flex align-items-end px-0 pb-0">
      <!--begin::Chart-->
      <div id="kt_card_widget_6_chart" class="w-100" style="height: 280px">
        <Line :data="chartData" :options="chartOptions" />
      </div>
      <!-- <div id="kt_card_widget_6_chart" class="w-100" style="height: 280px" v-else>
        <h5 class="text-center">Loading Chart... <span class="spinner-border spinner-border-sm align-middle text-black mr-2"></span></h5>
      </div> -->
      <!--end::Chart-->
    </div>
    <!--end::Card body-->
  </div>
  <!--end::Card widget 4-->
</template>

<script>
import { baseURL, http, Csrf } from "../../boot";
import { Chart as ChartJS, LinearScale, PointElement, LineElement, Tooltip, Legend } from "chart.js";
import axios from "axios";
import { Line } from 'vue-chartjs'

ChartJS.register(LinearScale, PointElement, LineElement, Tooltip, Legend)

export default {
  name: "Income Vs. Expense Chart",
  components: {
    Line,
  },
  data() {
    return {
      chartData: {
        labels: [],
        datasets: [],
      },
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        bezierCurve: true,
      },
    };
  },
  methods: {
    // Fetch data from API and map it to chartData
    getChartData() {
      this.chartData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        datasets: [
          {
            label: 'Income',
            borderColor: 'green',
            data: [1000, 1500, 2000, 1800, 2200], // Your income data
          },
          {
            label: 'Expense',
            borderColor: 'red',
            data: [500, 600, 700, 750, 800], // Your expense data
          },
        ]
      };
    },
  },
  mounted() {
    this.getChartData();
    console.log(this.chartData);
    },
};
</script>
