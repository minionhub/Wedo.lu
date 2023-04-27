<template>
  <div>
    <div v-if="!isCategory" id="blog-single">
      <!-- Post -->
      <div class="banner">
        <img :src="post.featured_img" alt="Alt Text here" />
      </div>
      <div class="container">
        <div class="headline row">
          <b-col md="8">
            <h2>{{ post.title }}</h2>
            <span class="publish-date">
              Publié le {{ formatDate(post.publish_date) }}
            </span>
          </b-col>

          <b-col md="4" class="text-right">
            <div class="share">
              <div class="icon show">
                <b-dropdown variant="link" no-caret>
                  <template slot="button-content">
                    <img
                      src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/boucher/1.svg"
                      alt="link"
                    />
                  </template>
                  <b-dropdown-item href="#">
                    <img
                      src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/ico_face.png"
                      class="p-2"
                      width="50"
                    />Facebook
                  </b-dropdown-item>
                  <b-dropdown-item href="#">
                    <img
                      src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/ico_link.png"
                      class="p-2"
                      width="50"
                    />Linkedin
                  </b-dropdown-item>
                  <b-dropdown-item href="#">
                    <img
                      src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/ico_tw.png"
                      class="p-2"
                      width="50"
                    />Twitter
                  </b-dropdown-item>
                </b-dropdown>
              </div>
            </div>
          </b-col>
        </div>

        <div class="content">
          <b-row>
            <b-col md="8" sm="12" class="left-content">
              <div class="content-details">
                {{ post.content }}
              </div>

              <div class="mt-5 mb-5">
                <a
                  v-if="post.prevPostSlug"
                  :href="'/' + post.prevPostSlug"
                  class="btn previous-btn"
                >
                  <i class="material-icons mr-1">keyboard_arrow_left</i>
                  Article précédent
                </a>
                <a
                  v-if="post.nextPostSlug"
                  :href="'/' + post.nextPostSlug"
                  class="btn previous-btn float-right"
                >
                  Article suivant
                  <i class="material-icons ml-1">keyboard_arrow_right</i>
                </a>
              </div>
            </b-col>

            <b-col md="4" sm="12" class="mb-5">
              <div class="right-content">
                <div class="category-wrapper">
                  <h2>Catégories</h2>
                  <div class="categories">
                    <a
                      v-for="tag in post.tags"
                      :key="tag.id"
                      :href="'/post-category/' + tag.slug"
                      class="category"
                    >
                      {{ tag.name }}
                    </a>
                  </div>
                </div>

                <div class="article-wrapper">
                  <h2>Plus d'articles</h2>
                  <div class="articles pt-3 pl-3 pr-3">
                    <div
                      v-for="relatedPost in relatedPosts"
                      :key="relatedPost.id"
                      class="article mb-3"
                    >
                      <div class="p-thumbnail">
                        <a :href="relatedPost.slug">
                          <img :src="relatedPost.featured_img" alt="wedo.lu" />
                        </a>
                      </div>
                      <div class="text">
                        <h3>
                          <a :href="relatedPost.slug">
                            {{ relatedPost.title }}
                          </a>
                        </h3>
                        <span class="date">
                          {{ formatDate(relatedPost.publish_date) }}
                        </span>
                        <a
                          :href="'/post-category/' + relatedPost.tags[0].slug"
                          class="tag"
                        >
                          {{ relatedPost.tags[0].name }}
                        </a>
                        <div class="description mobile">
                          <p>
                            {{ ellipse(post.content, 50) }}
                          </p>
                        </div>
                        <div class="bottom mobile">
                          <span class="date">
                            {{ formatDate(relatedPost.publish_date) }}
                          </span>
                          <span class="read-more">En savoir plus</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="w-100 text-center all-articles mb-3">
                    <a href="#">Tous les articles</a>
                  </div>
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </div>
    </div>
    <div v-if="isCategory" id="artisans">
      <!-- Category -->
      <b-container style="margin-top: 300px">
        <div class="px-5 mb-5 bg-white content col-xl-9 mx-auto">
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
  </div>
</template>

<script>
import Icon from 'vue-awesome/components/Icon'
import 'vue-awesome/icons/angle-right'
export default {
  components: {
    'v-icon': Icon
  },
  props: {
    isCategory: Boolean
  },
  data() {
    return {
      post: {},
      relatedPosts: [],
      showCat: {},
      cats: []
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    async init() {
      let check = false
      check = await this.slugCheck()
      console.log('check : ' + check)
      if (check === true) {
        // category API method call
        this.categoryAPI()
        this.isCategory = true
      } else if (check === false) {
        // post API method call
        this.postAPI()
        this.isCategory = false
      }
      console.log('isCategory : ' + this.isCategory)
    },
    // slug check : returns true if slug is a category
    async slugCheck() {
      let isCateg = false
      const cats = (await this.$axios.$get('/category/root')).data

      cats.forEach(cat => {
        if (cat.slug === this.$route.params.slug) {
          isCateg = true
        }
      })

      console.log('slugCheck : ' + isCateg)
      return isCateg
    },
    // post API call
    async postAPI() {
      try {
        const data = await this.$axios.$get(
          '/post/slug/' + this.$route.params.slug
        )
        this.post = data.post
        this.relatedPosts = data.relatedPosts
      } catch (e) {
        return this.$nuxt.error({ statusCode: 404, message: e.message })
      }
    },
    // category API call
    async categoryAPI() {
      const givenSlug = this.$route.params.slug
      console.log('given Slug : ' + givenSlug)
      const cats = (await this.$axios.$get('/category/tree')).data

      const newCat = cats.filter(function(cat) {
        return cat.slug === givenSlug
      })

      console.log(newCat)
      console.log(cats)
      this.cats = newCat
      this.children = this.newCat[0].children
    },
    // click action
    onClickCat(cat) {
      if (this.showCat[cat]) this.showCat[cat] = false
      else this.showCat[cat] = true
    },
    ellipse(string, nLetters) {
      return string.substring(0, nLetters) + '...'
    },
    formatDate(date) {
      date = new Date(date)
      const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      }
      return date.toLocaleDateString('fr-fr', options)
    }
  }
}
</script>

<style>
@import 'assets/css/blog-single.css';
@import 'assets/css/artisans.css';
</style>
