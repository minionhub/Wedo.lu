<template>
  <div>
    <PaidCompany
      v-if="
        listingType === 'company' &&
          listing.is_premium_listing &&
          listingStatus === 'published'
      "
      :company="listing"
    ></PaidCompany>
    <FreeCompany
      v-else-if="
        listingType === 'company' &&
          !listing.is_premium_listing &&
          listingStatus === 'published'
      "
      :company="listing"
    ></FreeCompany>
    <JobOffer
      v-else-if="listingType === 'job_offer' && listingStatus === 'published'"
      :job-offer="listing"
    />
    <Event
      v-else-if="listingType === 'event' && listingStatus === 'published'"
      :event="listing"
    />
    <Promotion
      v-else-if="listingType === 'promotion' && listingStatus === 'published'"
      :promotion="listing"
    />
  </div>
</template>

<script>
import PaidCompany from '~/components/company-listing/PaidCompany.vue'
import FreeCompany from '~/components/company-listing/FreeCompany.vue'
import JobOffer from '~/components/job-listing/JobOffer.vue'
import Event from '~/components/event-listing/Event.vue'
import Promotion from '~/components/promotion-listing/Promotion.vue'

export default {
  validate({ params }) {
    return params.slug != null
  },
  components: {
    PaidCompany,
    FreeCompany,
    JobOffer,
    Event,
    Promotion
  },
  data() {
    return {
      listing: {},
      listingType: '',
      listingStatus: '',
      isListingBlocked: 0
    }
  },
  async mounted() {
    try {
      const data = await this.$axios.$get('/listing/' + this.$route.params.slug)
      this.listing = data.listing
      this.listingType = data.listingType
      this.listingStatus = data.listingStatus
      this.isListingBlocked = data.isListingBlocked
      if (data.listingStatus === 'draft' || data.isListingBlocked === 1)
        return this.$nuxt.error({ statusCode: 404 })
    } catch (e) {
      return this.$nuxt.error({ statusCode: 404, message: e.message })
    }
  }
}
</script>
