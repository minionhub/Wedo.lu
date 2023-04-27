<template>
  <b-col md="3">
    <div class="product-wrapper d-block w-100">
      <b-link :to="to">
        <img
          src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/placeholder.png"
          alt="Alt text here"
          width="100%"
        />
        <div class="overlay-price">{{ price }} €</div>
        <div class="overlay-name">{{ title }}</div>
      </b-link>
      <b-link to="/#">
        <div class="add-to-cart">
          <i class="material-icons">add_shopping_cart</i>
        </div>
      </b-link>
    </div>
  </b-col>
</template>

<script>
export default {
  name: 'WedoProduct',
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
    image: {
      type: String,
      default: ''
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
