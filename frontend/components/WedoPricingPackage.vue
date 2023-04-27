<template>
  <b-link :to="'/produit/' + to">
    <div class="listing-box-2 free">
      <div class="price-box">
        <h4>{{ title }}</h4>
        <p class="price">{{ price }} €</p>
        <p>
          {{ duration }}
        </p>
      </div>
      <div class="package-content">
        <div v-if="contents.length <= 8">
          <div
            v-for="(content, index) in contents"
            :key="index"
            class="elementor-price-table__feature-inner"
          >
            {{ content }}
          </div>
        </div>
        <div v-else>
          <div
            v-for="(content, index) in contents.slice(0, 8)"
            :key="index"
            class="elementor-price-table__feature-inner"
          >
            {{ content }}
          </div>
          <div class="elementor-price-table__feature-inner features-more">
            <b-link :to="'/produit/' + to"
              >+{{ contents.length - 8 }} Fonctions</b-link
            >
          </div>
        </div>
      </div>
      <div class="btn-order-now">
        <span>Commandez maintenant</span>
      </div>
    </div>
  </b-link>
</template>

<script>
export default {
  name: 'WedoPricingPackage',
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
    },
    duration: {
      type: String,
      default: ''
    }
  },
  methods: {}
}
</script>

<style></style>
