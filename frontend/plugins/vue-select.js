import Vue from 'vue'
import { ModelSelect } from 'vue-search-select'
import { MultiSelect } from 'vue-multiselect'
const VueSelect = {
  install(Vue, options) {
    Vue.component('model-select', ModelSelect)
    Vue.component('multiselect', MultiSelect)
  }
}
Vue.use(VueSelect)
export default VueSelect
