<template>
  <b-button
    class="pt-3 pb-3 pr-5 pl-5 text-white button"
    size="lg"
    type="submit"
    :disabled="disabled"
    @click="clicked"
  >
    {{ value }}
  </b-button>
</template>

<script>
export default {
  name: 'WedoButton',
  props: {
    value: {
      type: String,
      default: 'text'
    },
    disabled: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    clicked() {
      this.$emit('click')
    }
  }
}
</script>

<style>
.button {
  background-color: orange !important;
  border-color: orange !important;
  font-size: 13px !important;
  line-height: 18px !important;
  font-weight: 400 !important;
  font-family: 'Source Sans Pro', sans-serif !important;
  border-radius: 2px !important;
}
.button:hover {
  background-color: black !important;
  border-color: black !important;
}
.button:focus {
  border-color: orange !important;
  border: none !important;
  box-shadow: none !important;
}
</style>
