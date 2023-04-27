<template>
  <b-form-group class="wedo-textarea" :label="label">
    <b-form-textarea
      :placeholder="placeholder"
      :name="name"
      :value="value"
      :rows="rows"
      @input="updateData"
    ></b-form-textarea>
    <div v-if="error" class="w-100 text-danger validate-msg">
      <span>Ce champ est obligatoire</span>
    </div>
  </b-form-group>
</template>

<script>
export default {
  name: 'WedoTextarea',
  props: {
    label: {
      type: String,
      default: ''
    },
    placeholder: {
      type: String,
      default: ''
    },
    name: {
      type: String,
      default: ''
    },
    rows: {
      type: Number,
      default: 4
    },
    error: {
      type: String,
      default: ''
    },
    value: {
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
.wedo-textarea {
  margin-bottom: 15px;
}

.wedo-textarea legend {
  font-family: 'Source Sans Pro', sans-serif;
  margin-bottom: 5px;
  line-height: 2;
  color: #565662;
  padding-bottom: 0;
  font-size: 13px;
  font-weight: 700;
}

.wedo-textarea textarea {
  line-height: 18px;
  padding: 14px 0;
  color: #1d1d23;
  font-size: 14px;
  -webkit-transition: padding 0.25s ease-in-out;
  transition: padding 0.25s ease-in-out;
  border-radius: 0;
  border: none;
  border-bottom: 1px solid rgba(0, 0, 0, 0.25);
  height: auto;
}

.wedo-textarea textarea:focus {
  border-color: #ffa602;
  box-shadow: 0px 1px 0px 0px #ffa602;
  padding-left: 5px;
}
</style>
