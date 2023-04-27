<template>
  <div id="board-page">
    <!-- Banner -->
    <div class="banner blog-banner">
      <div class="inner-content">
        <h1>Nos conseils</h1>
        <p>
          Toutes les informations dont vous avez besoin pour développer vos
          projets sont ici.
        </p>
      </div>
    </div>
    <!-- Banner -->

    <div class="board-content">
      <div class="row wrap-content clearfix">
        <!-- Left block -->
        <div class="filter blog-filter col-lg-3 col-md-4">
          <div class="inner-filter">
            <p
              class="title"
              aria-expanded="true"
              aria-controls="blog-category"
              :class="showCategoryFilter ? 'collapsed' : null"
              @click="showCategoryFilter = !showCategoryFilter"
            >
              Tous nos conseils
            </p>

            <!-- Category -->
            <b-collapse id="blog-category" v-model="showCategoryFilter">
              <div class="item category">
                <label
                  v-for="tag in tags"
                  :key="tag.id"
                  :class="filterOptions.tags.includes(tag.id) ? 'active' : null"
                >
                  {{ tag.name }}
                  <input
                    v-model="filterOptions.tags"
                    type="checkbox"
                    :value="tag.id"
                  />
                </label>
              </div>
            </b-collapse>
            <!-- Category -->

            <p
              class="title"
              aria-expanded="true"
              aria-controls="articles"
              :class="showArticles ? 'collapsed' : null"
              @click="showArticles = !showArticles"
            >
              Articles importants
            </p>

            <!-- Articles -->
            <b-collapse id="articles" v-model="showArticles">
              <div class="item pb-0">
                <div class="featured-articles">
                  <!-- Article -->
                  <div
                    v-for="post in postsImportant"
                    :key="post.id"
                    class="article"
                  >
                    <div class="wrapper">
                      <h3>
                        <a :href="post.slug">
                          {{ post.title }}
                        </a>
                      </h3>
                      <div class="bottom-text">
                        <span class="date">{{
                          formatDate(post.publish_date)
                        }}</span>
                        <a
                          :href="/post-category/ + post.tags[0].slug"
                          class="tag"
                          >{{ post.tags[0].name }}</a
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </b-collapse>
            <!-- Articles -->
          </div>
        </div>
        <!-- Left block -->

        <!-- Right block -->
        <div class="right-content col-lg-9 col-md-8">
          <div class="inner-right-content">
            <!-- Search form -->
            <div class="search-form">
              <form id="blog-search-form" class="clearfix">
                <input
                  v-model="query"
                  type="text"
                  placeholder="Que recherchez vous ?"
                  class="keyword"
                />
                <button @click.prevent="filterOptions.title = query">
                  Recherche
                </button>
              </form>
            </div>
            <!-- Search form -->

            <!-- Posts -->
            <div id="ajax_load_content">
              <div class="outer-posts">
                <div class="row posts">
                  <!-- Post item -->
                  <div
                    v-for="post in posts"
                    :key="post.id"
                    class="col-xl-4 col-sm-6 item"
                  >
                    <div class="wrapper">
                      <a
                        :href="'/post-category/' + post.tags[0].slug"
                        class="tag"
                        >{{ post.tags[0].name }}</a
                      >
                      <a :href="post.slug">
                        <div class="img-wrap">
                          <img :src="post.featured_img" alt="Alt text here." />
                        </div>
                        <div class="bottom-text">
                          <h3>
                            {{ post.title }}
                          </h3>
                          <!-- <div class="description">
                            <p>
                              {{ ellipse(post.content, 100) }}
                            </p>
                          </div> -->
                          <div class="bottom">
                            <span class="date">{{
                              formatDate(post.publish_date)
                            }}</span>
                            <!-- <span class="read-more">En savoir plus</span> -->
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Pagination -->
              <div class="mt-3">
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
            <!-- Posts -->
          </div>
        </div>
        <!-- Right block -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showCategoryFilter: true,
      showArticles: true,
      currentPage: 1,
      totalRows: 100,
      perPage: 21,
      tags: [],
      posts: [],
      postsImportant: [],
      query: '',
      filterOptions: {
        title: '',
        tags: []
      }
    }
  },
  watch: {
    'filterOptions.title': function() {
      this.onChangeFilterOptions()
    },
    'filterOptions.tags': function() {
      this.onChangeFilterOptions()
    }
  },
  mounted() {
    this.init()
    this.fetchPosts()
  },
  methods: {
    async init() {
      this.tags = (await this.$axios.$get('/tag')).data
      this.postsImportant = (await this.$axios.$get('/post/important')).data
    },
    async fetchPosts() {
      const data = (await this.$axios.$post(
        '/post/filter?page=' + this.currentPage,
        this.filterOptions
      )).data
      this.posts = data.data
      this.totalRows = data.total
      this.perPage = data.per_page
    },
    onChangeFilterOptions() {
      this.currentPage = 1
      this.fetchPosts()
    },
    onChangePage(page) {
      this.currentPage = page
      this.fetchPosts()
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
@import 'assets/css/board.css';
#blog-category label.active:hover {
  color: white !important;
}
</style>
