<template>
  <div id="my-account">
    <div class="content w-100">
      <b-container class="py-5">
        <b-row>
          <b-col md="4" lg="3" class="sidebar-wrapper">
            <Sidebar></Sidebar>
          </b-col>

          <b-col md="8" lg="9" class="px-5 pb-5 my-listings bg-white">
            <div class="breadcrumbs py-3">
              <b-link href="/dashboard">Dashboard</b-link>
              <span class="separator">&gt;&gt;</span>
              <b-link class="last" href="/my-account/my-listings"
                >Your content</b-link
              >
            </div>
            <div class="edit-listing">
              <Company v-if="type == 'company'" />
              <JobOffer v-else-if="type == 'job_offer'" />
            </div>
          </b-col>
        </b-row>
      </b-container>
    </div>
  </div>
</template>

<script>
import Sidebar from '~/components/my-account/Sidebar.vue'
import Company from '~/components/edit-listing/Company.vue'
import JobOffer from '~/components/edit-listing/JobOffer.vue'

export default {
  middleware: 'auth',
  validate({ query }) {
    const types = ['company', 'job_offer', 'event', 'promotion']
    return types.includes(query.type) && query.id
  },
  components: {
    Sidebar,
    Company,
    JobOffer
  },
  data() {
    return {
      type: '',
      id: 0
    }
  },
  mounted() {
    this.type = this.$route.query.type
    this.id = this.$route.query.id
  }
}
</script>

<style>
@import 'assets/css/my-account.css';
</style>
