<template>
  <div id="my-account">
    <div class="content w-100">
      <b-container class="py-5">
        <b-row>
          <b-col md="4" lg="3" class="sidebar-wrapper">
            <Sidebar></Sidebar>
          </b-col>

          <b-col md="8" lg="9" class="px-5 pb-5 edit-address">
            <nuxt-child />
          </b-col>
        </b-row>
      </b-container>
    </div>
  </div>
</template>

<script>
import Sidebar from '~/components/my-account/Sidebar.vue'

export default {
  middleware: 'auth',
  components: {
    Sidebar
  },
  data: function() {
    return {
      title: 'Adresses'
    }
  }
}
</script>

<style>
@import 'assets/css/my-account.css';
</style>
