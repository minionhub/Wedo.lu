<template>
  <div class="package">
    <div class="image">
      <b-link :to="'/produit/' + to">
        <b-img :src="src"></b-img>
      </b-link>
    </div>
    <div class="text">
      <h3>
        <b-link :to="'/produit/' + to">{{ title }}</b-link>
      </h3>
      <span class="woocommerce-Price-amount amount"
        >{{ price }}&nbsp;<span class="woocommerce-Price-currencySymbol"
          >€</span
        ></span
      >
      <div class="description">
        <strong>Haute performance pour votre site web :</strong>
        <div class="elementor-price-table__feature-inner">
          {{ contents[0] }}
        </div>
        <div class="elementor-price-table__feature-inner features-more">
          <b-link :to="'/produit/' + to"
            >+{{ contents.length - 1 }} Fonctions</b-link
          >
        </div>
        <b-link :to="'/produit/' + to" class="btn-order-now"
          >Commandez maintenant</b-link
        >
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'WedoPackage',
  props: {
    id: {
      type: String,
      default: ''
    },
    label: {
      type: String,
      default: ''
    },
    src: {
      type: String,
      default: ''
    },
    to: {
      type: String,
      default: ''
    },
    title: {
      type: String,
      default: ''
    },
    price: {
      type: String,
      default: ''
    },
    contents: {
      type: Array,
      default: function() {
        return []
      }
    }
  },
  methods: {}
}
</script>

<style>
.description strong {
  font-weight: 600;
}
</style>
