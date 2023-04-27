<template>
  <div class="wedo-select">
    <legend>{{ label }}</legend>
    <model-select
      v-model="item"
      :options="options"
      :preselect-first="true"
      editable="false"
      :name="name"
      :placeholder="placeholder"
      @input="updateData"
    >
    </model-select>
    <div v-if="error" class="w-100 text-danger validate-msg">
      <span>Ce champ est obligatoire</span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'WedoSelect',
  props: {
    value: {
      type: [Number, String],
      default: ''
    },
    label: {
      type: String,
      default: ''
    },
    options: {
      type: Array,
      default: function() {
        return []
      }
    },
    name: {
      type: String,
      default: ''
    },
    placeholder: {
      type: String,
      default: ''
    },
    error: {
      type: String,
      default: ''
    },
    initValue: {
      type: Number
    }
  },
  data() {
    return {
      item: this.value
    }
  },
  updated() {
    this.item = this.value
  },
  methods: {
    updateData(item) {
      this.$emit('input', item)
    }
  }
}
</script>

<style>
.wedo-select {
  margin-bottom: 15px;
}

.wedo-select .selection.dropdown,
.wedo-select input.search,
.wedo-select .item {
  line-height: 18px !important;
  padding: 14px 0 !important;
  color: #1d1d23 !important;
  font-size: 14px !important;
  border-radius: 0 !important;
  -webkit-transition: padding 0.25s ease-in-out;
  transition: padding 0.25s ease-in-out;
  border: none !important;
  border-bottom: 1px solid rgba(0, 0, 0, 0.25) !important;
  background: transparent !important;
  font-family: 'Source Sans Pro', sans-serif;
}

.wedo-select .item {
  border: none !important;
}

.wedo-select .ui.dropdown .menu > .item:hover {
  background: #ffa602 !important;
  color: #fff !important;
}

.wedo-select i.dropdown.icon {
  padding: 0.8em 0 !important;
  font-size: 16px !important;
  color: #ffa602 !important;
}

.wedo-select legend {
  font-family: 'Source Sans Pro', sans-serif;
  margin-bottom: 5px;
  line-height: 2;
  color: #565662;
  padding-bottom: 0;
  font-size: 13px;
  font-weight: 700;
}

.validate-msg {
  font-size: 13px;
  padding: 5px;
}
</style>
