<template>
  <div id="artisans">
    <div class="banner w-100">
      <h1>Annuaire des Artisans</h1>
    </div>

    <b-container>
      <div class="px-5 mb-5 bg-white content">
        <div v-for="(cat, index) in cats" :key="index" class="cat-wrapper">
          <div
            class="py-4 w-100 cat"
            :class="[
              showCat[cat.id] ? 'collapsed' : null,
              index !== 0 ? 'border-top' : null
            ]"
            :aria-expanded="showCat[cat.id] ? 'true' : 'false'"
            :aria-controls="'collapse-content-' + cat.id"
            @click="showCat[cat.id] = !showCat[cat.id]"
          >
            <h2 class="w-100">
              <b-img :src="'/img' + cat.icon" class="mr-3"></b-img>
              {{ cat.name }}
              <v-icon name="angle-right"></v-icon>
            </h2>
          </div>
          <b-collapse
            :id="'collapse-content-' + cat.id"
            v-model="showCat[cat.id]"
            class="pt-3 border-top subcats"
          >
            <b-row>
              <b-col
                v-for="(subcat, sindex) in cat.children"
                :key="index + '-' + sindex"
                class="mb-3 subcat"
                lg="4"
              >
                <b-link :href="'/category/' + subcat.slug">
                  <v-icon name="angle-right"></v-icon>
                  {{ subcat.name + ' (' + subcat.count + ')' }}
                </b-link>
              </b-col>
            </b-row>
          </b-collapse>
        </div>
      </div>
    </b-container>
  </div>
</template>

<script>
import Icon from 'vue-awesome/components/Icon'
import 'vue-awesome/icons/angle-right'

export default {
  components: {
    'v-icon': Icon
  },
  data() {
    return {
      showCat: {},
      cats: []
    }
  },
  asyncData({ params, $axios }) {
    try {
      return $axios.$get('/category/tree').then(res => {
        const cats = res.data
        cats.forEach(cat => {
          cat.children = cat.children.sort((a, b) => {
            return b.count - a.count
          })
        })
        return {
          cats: cats,
          children: cats[0].children
        }
      })
    } catch (e) {}
  },
  methods: {
    async init() {
      const cats = (await this.$axios.$get('/category/tree')).data
      cats.forEach(cat => {
        cat.children = cat.children.sort((a, b) => {
          return b.count - a.count
        })
      })
      this.cats = cats

      this.children = this.cats[0].children
    },
    onClickCat(cat) {
      if (this.showCat[cat]) this.showCat[cat] = false
      else this.showCat[cat] = true
    }
  }
}
</script>

<style>
@import 'assets/css/artisans.css';
</style>
