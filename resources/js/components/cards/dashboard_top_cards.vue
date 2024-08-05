<template>
  <div class="row m-0">
    <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mb-3">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"></div>
              INCOME
            </div>
            <div class="col-auto">
              <div class="fas fa-arrow-up fa-2x text-secondary-300" style="color: green;"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-auto mt-5">
              <div class="h6 mb-0 font-weight-bold text-primary" v-if="!hasData">KSH. <span class="spinner-border spinner-border-sm align-middle text-black mr-2"></span></div>
              <div class="h6 mb-0 font-weight-bold text-primary" v-else>{{ formatCurrency(income) }}</div>
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
              PURCHASES
            </div>
            <div class="col-auto">
              <div class="fas fa-credit-card fa-2x text-primary-300"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-auto mt-5">
              <div class="h6 mb-0 font-weight-bold text-primary" v-if="!hasData">KSH. <span class="spinner-border spinner-border-sm align-middle text-black mr-2"></span></div>
              <div class="h6 mb-0 font-weight-bold text-primary" v-else>{{ formatCurrency(purchases) }}</div>
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
              COST OF SALE
            </div>
            <div class="col-auto">
              <div class="fas fa-arrow-down fa-2x text-warning-300" style="color: red;"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-auto mt-5">
              <div class="h6 mb-0 font-weight-bold text-primary" v-if="!hasData">KSH. <span class="spinner-border spinner-border-sm align-middle text-black mr-2"></span></div>
              <div class="h6 mb-0 font-weight-bold text-primary" v-else>{{ formatCurrency(costOfSale) }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { baseURL, http, Csrf } from "../../boot";
import axios from "axios";


export default {
  name: "Top Dashboard",
  data() {
    return {
        hasData: false,
        income: '0',
        purchases: '0',
        costOfSale: '0',
    };
  },
  methods: {
    // Fetch data from API and map it to chartData
    async getDashboardData() {
      await Csrf.getCookie()
      http.post(`${baseURL}/top-cards`).then((response) => {
          this.income = response.data.income
          this.costOfSale = response.data.costOfSale
          this.purchases = response.data.purchases
          this.hasData = true
        })
        .catch((error) => {
          console.error(error);
        });
    },
    formatCurrency(value) {
      // Check if the value is defined and not null
      if (value !== undefined && value !== null) {
        // Format the value as currency
        const formattedValue = new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'KES', // Use the appropriate currency code
          minimumFractionDigits: 2,
        }).format(value);

        return formattedValue;
      } else {
        // If the value is not defined or is null, return a default value
        return 'Ksh. 0.00';
      }
    }
  },
  created() {
    this.getDashboardData();
  },
};
</script>