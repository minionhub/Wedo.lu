<template>
  <div>
    <Header />
    <nuxt />
    <Footer />
  </div>
</template>

<script>
import Header from '~/components/Header.vue'
import Footer from '~/components/Footer.vue'
export default {
  components: {
    Footer,
    Header
  }
}
</script>

<style>
html {
  scroll-behavior: smooth;
}
</style>
