<template>
  <b-card>
    <b-link :to="to">
      <b-card-img :src="src"></b-card-img>
    </b-link>
    <div class="card-text">
      <b-link to="/"
        ><h5 class="card-title">{{ title }}</h5></b-link
      >
    </div>
  </b-card>
</template>

<script>
export default {
  name: 'WedoCard',
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
    }
  },
  methods: {}
}
</script>

<style></style>
