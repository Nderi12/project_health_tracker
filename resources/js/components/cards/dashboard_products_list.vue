<template>
    <div class="row m-0">
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mb-3">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"></div>
                POSTED JOBS
              </div>
              <div class="col-auto">
                <div class="fas fa-briefcase fa-2x text-secondary-300"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-auto">
                <small class="text-primary font-weight-bold">Initiated:</small> <div class="h6 mb-0 font-weight-bold text-primary">{{ initiatedToday }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mb-3">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"></div>
                APPLICATIONS
              </div>
              <div class="col-auto">
                <div class="fas fa-file-word fa-2x text-primary-300"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-auto">
                <small class="text-primary font-weight-bold">Initiated:</small> <div class="h6 mb-0 font-weight-bold text-primary">{{ initiatedYesterday }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mb-3">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"></div>
                RESUME ALERTS
              </div>
              <div class="col-auto">
                <div class="fas fa-bell fa-2x text-warning-300"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-auto">
                <small class="text-primary font-weight-bold">Initiated:</small> <div class="h6 mb-0 font-weight-bold text-primary">{{ initiatedThisWeek }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mb-3">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"></div>
                SHORTLISTED
              </div>
              <div class="col-auto">
                <div class="fas fa-user-circle fa-2x text-success-300"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-auto">
                <small class="text-primary font-weight-bold">Initiated:</small> <div class="h6 mb-0 font-weight-bold text-primary">{{ initiatedThisMonth }}</div>
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
    name: "User distribution per Network",
    data() {
      return {
          initiatedToday: '--',
          completedToday: '--',
          confirmedToday: '--',
          initiatedYesterday: '--',
          completedYesterday: '--',
          confirmedYesterday: '--',
          initiatedThisWeek: '--',
          completedThisWeek: '--',
          confirmedThisWeek: '--',
          initiatedThisMonth: '--',
          completedThisMonth: '--',
          confirmedThisMonth: '--',
      };
    },
    methods: {
      // Fetch data from API and map it to chartData
      async getDashboardData() {
        await Csrf.getCookie()
        http.post(`${baseURL}/topup-cards`).then((response) => {
            this.initiatedToday = response.data.initiatedToday
            this.completedToday = response.data.completedToday
            this.confirmedToday = response.data.confirmedToday
            this.initiatedYesterday = response.data.initiatedYesterday
            this.completedYesterday = response.data.completedYesterday
            this.confirmedYesterday = response.data.confirmedYesterday
            this.initiatedThisWeek = response.data.initiatedThisWeek
            this.completedThisWeek = response.data.completedThisWeek
            this.confirmedThisWeek = response.data.confirmedThisWeek
            this.initiatedThisMonth = response.data.initiatedThisMonth
            this.completedThisMonth = response.data.completedThisMonth
            this.confirmedThisMonth = response.data.confirmedThisMonth
          })
          .catch((error) => {
            console.error(error);
          });
      },
  
      getYesterdayDate() {
        let today = new Date();
        let previousDay = new Date(today);
        previousDay.setDate(today.getDate() - 1);
  
        this.yesterday = previousDay.toISOString().slice(0, 10)
      }
    },
    created() {
      this.getDashboardData();
    },
  };
  </script>