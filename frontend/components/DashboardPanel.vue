<template>
  <div
    v-if="visible === true"
    class="col-sm-6 col-md-4 mb-4"
    @click="clickFunc()"
  >
    <b-link :href="path" class="w-100 h-100">
      <div class="hover-panel dash-shadow rounded-lg">
        <div class="hover-card-child my-auto pt-5 pb-4">
          <b-img
            :src="source"
            style="height: 50px; width: 60px;"
            alt="img"
          ></b-img>
          <p class="mt-3 dash-font">{{ value }}</p>
        </div>
      </div>
    </b-link>
  </div>
</template>

<script>
export default {
  name: 'DashboardPanel',
  props: {
    source: {
      type: String,
      default: ''
    },
    value: {
      type: String,
      default: ''
    },
    path: {
      type: String,
      default: ''
    },
    visible: {
      type: Boolean,
      default: true
    }
  },
  methods: {
    clickFunc() {
      if (this.value === 'Déconnexion') this.$auth.logout()
    }
  }
}
</script>

<style lang="css">
@import 'assets/css/style.css';
@import 'assets/css/style.chao.css';
</style>
