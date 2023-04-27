<template>
  <b-form-group
    class="wedo-input"
    :class="hideLabel ? 'hide-label' : null"
    :label="label"
  >
    <b-form-input
      :id="id"
      :type="type"
      :placeholder="placeholder"
      :name="name"
      :value="value"
      @input="updateData"
    ></b-form-input>
    <div v-if="error" class="w-100 text-danger validate-msg">
      <span>Ce champ est obligatoire</span>
    </div>
  </b-form-group>
</template>

<script>
export default {
  name: 'WedoInput',
  props: {
    id: {
      type: String,
      default: ''
    },
    label: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      default: 'text'
    },
    placeholder: {
      type: String,
      default: ''
    },
    name: {
      type: String,
      default: ''
    },
    value: {
      type: [String, Number],
      default: ''
    },
    error: {
      type: String,
      default: ''
    },
    hideLabel: {
      type: Boolean,
      default: false
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
.wedo-input {
  margin-bottom: 25px !important;
}

.wedo-input.hide-label legend {
  opacity: 0 !important;
}

.wedo-input legend {
  font-family: 'Source Sans Pro', sans-serif;
  margin-bottom: 5px;
  line-height: 2;
  color: #565662;
  padding-bottom: 0;
  font-size: 13px;
  font-weight: 700;
}

.wedo-input input {
  line-height: 18px;
  padding: 14px 0;
  color: #1d1d23;
  font-size: 14px;
  -webkit-transition: padding 0.25s ease-in-out;
  transition: padding 0.25s ease-in-out;
  border: none;
  border-bottom: 1px solid rgba(0, 0, 0, 0.25);
  height: auto;
  font-family: 'Source Sans Pro', sans-serif;
}

.wedo-input input:focus {
  border-color: #ffa602;
  box-shadow: 0px 1px 0px 0px #ffa602;
  padding-left: 5px;
}
</style>
