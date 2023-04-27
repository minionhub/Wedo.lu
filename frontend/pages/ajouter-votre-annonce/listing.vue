<template>
  <div id="add-listing" class="py-5">
    <b-container>
      <b-row>
        <b-col lg="8" md="12" class="p-0 mx-auto">
          <Company v-if="type == 'company'" />
          <JobOffer v-else-if="type == 'job_offer'" />
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import Company from '~/components/add-listing/Company.vue'
import JobOffer from '~/components/add-listing/JobOffer.vue'

export default {
  middleware: 'auth',
  validate({ query }) {
    const types = ['company', 'job_offer', 'event', 'promotion']
    return types.includes(query.type)
  },
  components: {
    Company,
    JobOffer
  },
  data() {
    return {
      type: ''
    }
  },
  mounted() {
    this.type = this.$route.query.type
  }
}
</script>

<style>
@import 'assets/css/add-listing.css';
</style>
