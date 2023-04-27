<template>
  <div id="productfree-page">
    <b-container>
      <b-row>
        <b-col md="6">
          <div class="img-placeholder d-block">
            <b-img :src="product.image" alt="Alt text here"></b-img>
          </div>
        </b-col>
        <b-col md="6">
          <div class="product-info d-block">
            <div class="w-100 d-block product-summary">
              <h1 class="title">{{ product.name }}</h1>
              <p class="price">€ {{ product.price }}</p>
              <b-row>
                <b-col v-if="product.can_be_bought_in_quantities === 1" sm="2">
                  <b-form-input
                    v-model="quantity"
                    type="number"
                    class="quantity"
                    min="1"
                  ></b-form-input>
                </b-col>
                <b-col sm="10">
                  <WedoButton value="Inscrivez-vous maintenant"></WedoButton>
                </b-col>
              </b-row>
            </div>
            <div class="w-100 d-block description-tab">
              <ul class="nav nav-tabs">
                <li class="active">
                  <a data-toggle="tab" href="#description" class="active"
                    >Description</a
                  >
                </li>
              </ul>

              <div class="tab-content">
                <div id="description" class="tab-pane fade in active">
                  <p v-for="(item, index) in product.items" :key="index">
                    <i class="material-icons">keyboard_arrow_right</i>{{ item }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </b-col>
      </b-row>
      <b-row class="related-products">
        <b-col md="12">
          <h2 class="related-heading">Produits apparentés</h2>
        </b-col>
        <WedoProduct
          v-for="(prod, index) in otherProducts"
          :key="index"
          :price="prod.price"
          :title="prod.name"
          :to="'/produit/' + prod.slug"
          :image="prod.image"
        ></WedoProduct>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import WedoButton from '~/components/WedoButton.vue'
import WedoProduct from '~/components/WedoProduct.vue'

export default {
  components: {
    WedoButton,
    WedoProduct
  },
  data() {
    return {
      query: '',
      product: {},
      otherProducts: [],
      quantity: 1
    }
  },
  watch: {
    quantity(newVal, oldVal) {
      if (newVal === 0) {
        this.quantity = oldVal
      }
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    async init() {
      this.product = (await this.$axios.$get(
        '/product/slug/' + this.$route.params.slug
      )).data[0]
      if (this.product.status === 0) {
        return this.$nuxt.error({ statusCode: 404, message: 'Page Not Found' })
      }
      this.product.items = JSON.parse(this.product.items)
      this.product.images = JSON.parse(this.product.images)
      this.product.image = this.product.images[0]
      const products = (await this.$axios.$get('/product')).data
      products.forEach(element => {
        if (element.slug !== this.$route.params.slug) {
          element.image = JSON.parse(element.images)[0]
          this.otherProducts.push(element)
        }
      })
      this.otherProducts = this.otherProducts.slice(0, 4)
      this.otherProducts.forEach(element => {
        element.price = '' + element.price
      })
    }
  }
}
</script>
<style>
@import 'assets/css/style.chao.css';
.img-placeholder img {
  width: 100%;
}
.quantity {
  height: 52px;
}
</style>
