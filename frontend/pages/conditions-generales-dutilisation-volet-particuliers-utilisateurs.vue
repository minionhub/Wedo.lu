<template>
  <div id="editable-html" v-html="html"></div>
</template>

<script>
export default {
  data() {
    return {
      html: '',
      pageName: 'conditions-1'
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    async init() {
      this.html = (await this.$axios.$get('/page/' + this.pageName)).page
    }
  }
}
</script>

<style>
@import 'assets/css/editable.css';
</style>
