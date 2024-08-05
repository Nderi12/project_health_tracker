<template>
  <span :class="badgeClass">{{ badgeText }}</span>
</template>

<script>
export default {
  name: 'StatusBadge',
  props: {
    status: {
      type: Number,
      required: true
    }
  },
  computed: {
    badgeText() {
      switch (this.status) {
        case 1:
          return 'Active';
        case 2:
          return 'Rider Assigned';
        case 3:
          return 'Picked Up from Customer';
        case 4:
          return 'Dropped off at Laundromat';
        case 5:
          return 'Cleaning In Progress';
        case 6:
          return 'Assigned to Rider';
        case 7:
          return 'Picked Up from Laundromat';
        case 8:
          return 'Dropped off to Customer';
        default:
          return 'Inactive';
      }
    },
    badgeClass() {
      switch (this.status) {
        case 1:
        case 3:
        case 5:
        case 6:
        case 7:
          return 'badge badge-warning';
        case 2:
        case 4:
        case 8:
          return 'badge badge-danger';
        default:
          return 'badge badge-warning';
      }
    }
  }
}
</script>

<style>
  /* Add your badge styles here */
</style>
