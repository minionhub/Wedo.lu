<template>
  <div class="wedo-multiselect">
    <legend>{{ title }}</legend>
    <multiselect
      v-model="items"
      :options="options"
      :close-on-select="true"
      track-by="value"
      label="text"
      :preselect-first="true"
      :multiple="true"
      :taggable="taggable"
      :placeholder="placeholder"
      @tag="addTag"
      @input="onSelect"
    >
    </multiselect>
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect'

export default {
  name: 'WedoMultiSelect',
  components: {
    Multiselect
  },
  props: {
    value: {
      type: Array,
      default: function() {
        return []
      }
    },
    title: {
      type: String,
      default: ''
    },
    options: {
      type: Array,
      default: function() {
        return []
      }
    },
    placeholder: {
      type: String,
      default: 'Select option'
    },
    taggable: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      items: this.value,
      newId: -1
    }
  },
  methods: {
    onSelect(event) {
      this.$emit('input', this.items)
    },
    addTag(tagName) {
      this.options.push({ value: this.newId, text: tagName })
      this.items.push({ value: this.newId, text: tagName })
      this.newId--
    }
  }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
.multiselect__tag {
  background: #ffa602;
  font-size: 14px;
  font-family: 'Source Sans Pro', sans-serif;
}
.multiselect__tag-icon:focus,
.multiselect__tag-icon:hover {
  background: none;
}
.multiselect__tag-icon:after {
  color: white;
}
.wedo-multiselect {
  margin-bottom: 15px;
}
.multiselect__option--highlight {
  background: #ffa602;
}
.multiselect__option--highlight:after {
  display: none;
}
.multiselect__select:before {
  border-color: #ffa602 transparent transparent;
}
.wedo-multiselect .selection.dropdown,
.wedo-multiselect input.search,
.wedo-multiselect .item {
  line-height: 18px !important;
  color: #1d1d23 !important;
  font-size: 14px !important;
  border-radius: 0 !important;
  -webkit-transition: padding 0.25s ease-in-out;
  transition: padding 0.25s ease-in-out;
  border: none !important;
  border-bottom: 1px solid rgba(0, 0, 0, 0.25) !important;
  background: transparent !important;
  padding-bottom: 4px !important;
}

.wedo-multiselect .item {
  border: none !important;
}

.wedo-multiselect .ui.dropdown .menu > .item:hover {
  background: #ffa602 !important;
  color: #fff !important;
}

.wedo-multiselect i.dropdown.icon {
  padding: 0.8em 0 !important;
  font-size: 16px !important;
  color: #ffa602 !important;
}

.wedo-multiselect legend {
  font-family: 'Source Sans Pro', sans-serif;
  margin-bottom: 5px;
  line-height: 2;
  color: #565662;
  padding-bottom: 0;
  font-size: 13px;
  font-weight: 700;
}

.wedo-multiselect .multiselect__tags-wrap {
  display: inline-block;
}

.wedo-multiselect .multiselect__tags {
  min-height: 38px !important;
  transition: padding 0.25s ease-in-out;
  border: none !important;
  border-bottom: 1px solid rgba(0, 0, 0, 0.25) !important;
  border-radius: 0 !important;
  padding-left: 0 !important;
}

.wedo-multiselect .multiselect__tag {
  margin-bottom: 3px !important;
  padding: 5px 26px 5px 10px;
  border-radius: 0;
  font-family: 'Source Sans Pro', sans-serif;
}

.wedo-multiselect input {
  font-size: 14px;
  border: none !important;
  font-family: 'Source Sans Pro', sans-serif;
}

.wedo-multiselect .multiselect__content {
  font-size: 14px;
  font-family: 'Source Sans Pro', sans-serif;
  color: #565d62;
}

.wedo-multiselect .multiselect__placeholder {
  font-size: 14px;
  color: #1d1d23;
  font-family: 'Source Sans Pro', sans-serif;
}
</style>
