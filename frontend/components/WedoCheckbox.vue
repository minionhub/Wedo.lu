<template>
  <b-form-checkbox
    class="wedo-checkbox"
    required
    :value="value"
    @input="updateData"
  >
    {{ label }}
  </b-form-checkbox>
</template>

<script>
export default {
  name: 'WedoCheckbox',
  props: {
    name: {
      type: String,
      default: ''
    },
    label: {
      type: String,
      default: ''
    },
    value: {
      type: String,
      default: ''
    },
    error: {
      type: String,
      default: ''
    }
  },
  methods: {
    updateData(value) {
      this.$emit('input', value)
    }
  }
}
</script>

<style>
.wedo-checkbox {
  margin-bottom: 25px;
}

.wedo-checkbox label {
  font-size: 13px;
  line-height: 24px;
  color: #565d62;
  font-weight: 400;
  font-family: 'Open Sans', sans-serif;
}
.custom-control-input:checked ~ .custom-control-label::before {
  background-color: #ffa602;
  border-color: #ffa602;
}
</style>
