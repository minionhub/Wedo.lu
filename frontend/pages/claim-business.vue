<template>
  <div id="claim">
    <div class="banner">
      <b-container>
        <h1>Tarification</h1>
      </b-container>
    </div>

    <div class="content py-5">
      <b-container>
        <h2>Choisissez un Forfait</h2>
        <div class="packages">
          <div
            v-for="product of subscriptions"
            :key="product.id"
            class="package-wrapper text-center"
            :class="product.slug === 'expert' ? 'brand' : null"
          >
            <div class="package">
              <h3 class="title mt-4 pb-2">{{ product.name }}</h3>
              <p class="price">{{ product.price }} &euro;</p>
              <p class="unit mb-3">HTVA PAR AN</p>
              <b-button
                class="select-btn btn-block mb-4"
                @click="onClickClaim(product.id)"
              >
                Sélectionner
              </b-button>
              <hr />
              <div class="items text-left">
                <p
                  v-for="(item, index) of JSON.parse(product.items)"
                  :key="'item' + index"
                  class="item"
                >
                  {{ item }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </b-container>
    </div>
  </div>
</template>

<script>
export default {
  middleware: 'auth',
  validate({ query }) {
    return query.listing_id
  },
  data() {
    return {
      subscriptions: []
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    async init() {
      const response = (await this.$axios.get('/product')).data
      const subscriptions = []
      response.data.forEach(product => {
        if (product.product_type_id === 1) subscriptions.push(product)
      })
      this.subscriptions = subscriptions.sort((a, b) => {
        return b.price - a.price
      })
    },
    async onClickClaim(id) {
      const product = this.subscriptions.filter(item => {
        return item.id === id
      })[0]
      if (product.price <= 0) {
        const result = (await this.$axios.post('/claim', {
          company_id: this.$route.query.listing_id
        })).data
        if (result.status === 'success') {
          this.$router.push({
            path: 'claim-submitted',
            query: {
              listing_id: this.$route.query.listing_id,
              claim_id: result.claim_id
            }
          })
        }
      }
    }
  }
}
</script>

<style>
@import 'assets/css/claim.css';
</style>
