<template>
  <div id="claim" class="claim-submitted">
    <img
      class="claim-bkg"
      src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/claim-submitted.jpg"
      alt="Alt text here"
    />
    <b-container>
      <div class="content text-center">
        <img
          class="mb-5"
          src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/success-icon.svg"
          alt="Alt text here"
        />
        <h1>
          Nous avons bien reçu votre proclamation qui est en attente de
          validation
        </h1>
        <p>Annonce à proclamer</p>
        <a :href="'/annonce/' + company.slug" class="company">{{
          company.company_name
        }}</a>
        <p>Proclamé par</p>
        <h4>{{ user.first_name }} {{ user.last_name }}</h4>
        <p>État de la demande de proclamation</p>
        <h4>en attente</h4>
        <p>Soumis le</p>
        <h4 class="mb-4">{{ formatDate(new Date()) }}</h4>
        <a href="/" class="select-btn">OK</a>
      </div>
    </b-container>
  </div>
</template>

<script>
export default {
  middleware: 'auth',
  validate({ query }) {
    return query.listing_id && query.claim_id
  },
  data() {
    return {
      company: {}
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    async init() {
      try {
        const result = (await this.$axios.get(
          '/company/id/' + this.$route.query.listing_id
        )).data
        this.company = result.company
      } catch (e) {
        return this.$nuxt.error({ statusCode: 404, message: e.message })
      }
    },
    formatDate(date) {
      date = new Date(date)
      const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      }
      return date.toLocaleDateString('fr-fr', options)
    }
  }
}
</script>

<style>
@import 'assets/css/claim.css';
</style>
