<template>
  <div class="pb-main-content pb-services-content">
    <div id="pagehead">
      <b-img
        src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/services/banner-services.png"
        class="pagehead-image"
        alt="image"
      ></b-img>
      <b-container class="vh-center">
        <h2>Tarifs &amp; Services</h2>
        <p>Bénéficiez de plus de services avec wedo</p>
      </b-container>
    </div>
    <div class="wrap-content package-option">
      <b-container>
        <div class="pricing-package">
          <b-row class="same-height">
            <b-col
              v-for="(product, index) in subscriptions"
              :key="index"
              class="item"
              sm="6"
              lg="4"
            >
              <WedoPricingPackage
                :title="product.name"
                :price="product.price"
                :contents="product.items"
                :duration="product.duration"
                :to="product.slug"
              ></WedoPricingPackage>
            </b-col>
          </b-row>
        </div>
        <div class="pb-packages">
          <WedoPackage
            v-for="(product, index) in oneTimeProducts"
            :key="index"
            :src="product.image"
            :title="product.name"
            :price="product.price"
            :contents="product.items"
            :duration="product.duration"
            :to="product.slug"
          ></WedoPackage>
        </div>
      </b-container>
    </div>
  </div>
</template>

<script>
import WedoPricingPackage from '~/components/WedoPricingPackage.vue'
import WedoPackage from '~/components/WedoPackage.vue'
export default {
  components: {
    WedoPricingPackage,
    WedoPackage
  },
  data() {
    return {
      query: '',
      products: [],
      subscriptions: [],
      oneTimeProducts: []
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    async init() {
      this.products = await this.$axios.$get('/product')
      this.products = this.products.data
      this.products.forEach(element => {
        element.items = JSON.parse(element.items)
        element.price = '' + element.price
        element.images = JSON.parse(element.images)
        element.image = element.images[0]
        if (element.cycle === 12) {
          element.duration = 'PAR AN'
        } else if (element.cycle === 1) {
          element.duration = 'PAR MOIS'
        } else {
          element.duration = ''
        }
        if (element.status === 0) return
        if (element.primary === 1) this.subscriptions.push(element)
        else {
          this.oneTimeProducts.push(element)
        }
      })
    }
  }
}
</script>

<style>
@import 'assets/css/style.service.css';
@import 'assets/css/custom.service.css';
</style>
