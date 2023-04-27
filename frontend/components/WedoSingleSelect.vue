<template>
  <div class="wedo-singleselect">
    <legend>{{ title }}</legend>
    <multiselect
      v-model="item"
      :options="options"
      :selected-options="items"
      :close-on-select="true"
      track-by="name"
      label="text"
      :preselect-first="false"
      :allow-empty="false"
      @input="updateData"
    >
    </multiselect>
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect'

export default {
  name: 'WedoSingleSelect',
  components: {
    Multiselect
  },
  props: {
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
    items: {
      type: Object,
      default: function() {
        return {}
      }
    },
    selectedItems: {
      type: Array,
      default: function() {
        return []
      }
    },
    lastSelectItem: {
      type: Array,
      default: function() {
        return []
      }
    }
  },
  data() {
    return {
      item: { name: 'Pas de date fixée', text: 'Pas de date fixée' }
    }
  },
  computed: {
    state() {
      return false
    }
  },
  mounted() {},
  methods: {
    updateData(value) {
      this.$emit('input', value)
    }
  }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
.multiselect__tag {
  background: #ffa602;
  font-size: 16px;
}
.multiselect__tags {
  border: unset;
  border-bottom: 2px solid #7e7e89;
}
.multiselect__tag-icon:focus,
.multiselect__tag-icon:hover {
  background: none;
}
.multiselect__tag-icon:after {
  color: white;
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
.multiselect__option--selected.multiselect__option--highlight {
  background: #ffa602 !important;
}
.wedo-singleselect .selection.dropdown,
.wedo-singleselect input.search,
.wedo-singleselect .item {
  line-height: 18px !important;
  color: #1d1d23 !important;
  font-size: 16px !important;
  border-radius: 0 !important;
  -webkit-transition: padding 0.25s ease-in-out;
  transition: padding 0.25s ease-in-out;
  border: none !important;
  border-bottom: 1px solid rgba(0, 0, 0, 0.25) !important;
  background: transparent !important;
  padding-bottom: 4px !important;
}

.wedo-singleselect .item {
  border: none !important;
}

.wedo-singleselect .ui.dropdown .menu > .item:hover {
  background: #ffa602 !important;
  color: #fff !important;
}

.wedo-singleselect i.dropdown.icon {
  padding: 0.8em 0 !important;
  font-size: 16px !important;
  color: #ffa602 !important;
}

.wedo-singleselect legend {
  font-family: 'Source Sans Pro', sans-serif;
  margin-bottom: 5px;
  line-height: 2;
  color: #565662;
  padding-bottom: 0;
  font-size: 12px;
  font-weight: 700;
}
</style>
