import Vue from 'vue'
import { MultiSelect } from 'vue-multiselect'
const VueMultiselect = {
  install(Vue, options) {
    Vue.component('multiselect', MultiSelect)
  }
}
Vue.use(VueMultiselect)
export default VueMultiselect
