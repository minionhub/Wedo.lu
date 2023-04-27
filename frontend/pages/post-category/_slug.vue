<template>
  <div id="archive-page">
    <div class="container">
      <div class="row title">
        <h1 class="text-center w-100">Category : {{ tagName }}</h1>
      </div>

      <div class="row posts">
        <div
          v-for="post in posts"
          :key="post.id"
          class="col-md-12 post-wrapper p-0"
        >
          <b-link :href="'/' + post.slug">
            <img
              :src="post.featured_img"
              alt="Alt text here"
              class="w-100 feature-img"
            />
          </b-link>

          <div class="content-wrapper d-block w-100">
            <h2 class="post-title w-100 mt-3 mb-3">
              <a :href="'/' + post.slug">{{ post.title }}</a>
            </h2>
            <div class="w-100 post-info">
              <div class="tips">
                <a :href="'/post-category/' + post.tags[0].slug">{{
                  post.tags[0].name
                }}</a>
                <span>{{ post.tags.length }}</span>
              </div>
              <span class="publish-date">
                {{ formatDate(post.publish_date) }}
              </span>
            </div>
            <p class="post-content">
              {{ ellipse(post.content, 140) }}
            </p>
            <a :href="'/' + post.slug" class="read-more">Read More</a>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div class="mt-3 mb-5">
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="center"
          :hide-goto-end-buttons="true"
          @change="onChangePage"
        >
          <i slot="prev-text" class="material-icons">chevron_left</i>
          <i slot="next-text" class="material-icons">chevron_right</i>
        </b-pagination>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentPage: 1,
      totalRows: 100,
      perPage: 21,
      posts: [],
      tagName: ''
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    async init() {
      try {
        const response = await this.$axios.$get(
          '/post/tag/slug/' +
            this.$route.params.slug +
            '?page=' +
            this.currentPage
        )
        const result = response.data
        this.posts = result.data
        this.totalRows = result.total
        this.perPage = result.per_page
        this.tagName = response.tagName
      } catch (e) {
        return this.$nuxt.error({ statusCode: 404, message: e.message })
      }
    },
    onChangePage(page) {
      this.currentPage = page
      this.init()
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
@import 'assets/css/sf-ui-display/style.css';
@import 'assets/css/archive.css';
</style>
