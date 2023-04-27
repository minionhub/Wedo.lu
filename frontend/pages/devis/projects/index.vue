<template>
  <div v-if="projects_role" class="quote-wrapper">
    <b-container fluid>
      <b-row>
        <b-col lg="9" offset-lg="3" md="8" offset-md="4" class="col">
          <div class="search-form">
            <b-form class="full" @submit.prevent="filter">
              <b-form-input
                v-model="filters.query"
                placeholder="Que cherchez vous?"
              ></b-form-input>
              <WedoButton value="Rechercher"></WedoButton>
            </b-form>
          </div>
        </b-col>
      </b-row>
      <b-row class="">
        <b-col id="sidebar" lg="3" md="4">
          <h2>Filtres de recherche</h2>
          <b-form-group>
            <b-form-checkbox
              v-for="(category, index) in categories"
              :key="index"
              v-model="selectedCategories"
              :value="category.category_id"
              name="flavour-3a"
            >
              {{ category.category_name }}
            </b-form-checkbox>
          </b-form-group>
        </b-col>
        <b-col id="main" lg="9" md="8">
          <div class="submitted-requests">
            <p class="text-right results">
              Il y a {{ pagination.totalRows }} projets
            </p>
            <ul id="ajax_result" class="quotes-list">
              <WedoProject
                v-for="(project, index) in projects"
                :key="index"
                :link="'/project/' + project.slug"
                :title="project.title"
                :description="project.description"
                :email="project.author_email"
                :date="getDuration(project.publish_date)"
                :status="project.status"
              ></WedoProject>
            </ul>
          </div>
          <!-- Pagination -->
          <div class="mt-3">
            <b-pagination
              v-model="pagination.currentPage"
              :total-rows="pagination.totalRows"
              :per-page="pagination.perPage"
              align="center"
              :hide-goto-end-buttons="true"
              @change="onChangePage"
            >
              <i slot="prev-text" class="material-icons">chevron_left</i>
              <i slot="next-text" class="material-icons">chevron_right</i>
            </b-pagination>
          </div>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>
<script>
import WedoButton from '~/components/WedoButton.vue'
import WedoProject from '~/components/WedoProject.vue'
export default {
  middleware: 'auth',
  components: {
    WedoButton,
    WedoProject
  },
  data() {
    return {
      selectedCategories: [],
      categories: [],
      allProjects: [],
      projects: [],
      pagination: {
        totalRows: 100,
        perPage: 10,
        currentPage: 1
      },
      filters: {
        query: '',
        categories: []
      },
      projects_role: false,
      query: ''
    }
  },
  watch: {
    selectedCategories(newVal, oldVal) {
      this.selectedCategories = newVal
      this.filters.categories = newVal
      this.filter()
    }
  },
  mounted() {
    if (this.user.manages_companies) {
      this.projects_role = true
    } else if (
      this.user.role === 'Moderator' ||
      this.user.role === 'Administrator'
    ) {
      this.projects_role = true
    } else {
      this.$nuxt.error({ statusCode: 404, message: 'Error' })
      this.projects_role = false
    }
    this.init()
  },
  methods: {
    async init() {
      this.categories = (await this.$axios.$get('/project/categories')).data
      if (this.$route.query.skill === undefined) {
        this.allProjects = (await this.$axios.$get(
          '/project/published?page=' + this.pagination.currentPage
        )).data
      } else if (typeof this.$route.query.skill === 'string') {
        this.allProjects = (await this.$axios.$post(
          '/projects/subcategories?page=' + this.pagination.currentPage,
          {
            subcategories: [this.$route.query.skill]
          }
        )).projects
      } else {
        this.allProjects = (await this.$axios.$post(
          '/projects/subcategories?page=' + this.pagination.currentPage,
          {
            subcategories: this.$route.query.skill
          }
        )).projects
      }
      this.projects = this.allProjects.data
      this.pagination.perPage = this.allProjects.per_page
      this.pagination.totalRows = this.allProjects.total
    },
    onChangePage(page) {
      this.pagination.currentPage = page
      this.filter()
    },
    async getProjectsByCategories() {
      try {
        const data = (await this.$axios.$post(
          '/projects/published/categories',
          this.filters
        )).projects
        this.projects = data.data
        this.pagination.totalRows = data.total
        this.pagination.currentPage = data.current_page
      } catch (e) {
        this.projects = []
        this.pagination.currentPage = 1
        this.pagination.totalRows = 0
      }
    },
    async filter() {
      if (this.filters.query === '' && this.filters.categories.length <= 0) {
        this.init()
      } else if (
        this.filters.query === '' &&
        this.filters.categories.length > 0
      ) {
        this.getProjectsByCategories()
      } else {
        const response = await this.$axios.$post(
          '/project/search/published?page=' + this.pagination.currentPage,
          this.filters
        )
        this.projects = response.hits.data
        this.pagination.totalRows = response.totalHits
      }
    },
    getDuration(date) {
      const pubDate = new Date(date)
      const nowDate = new Date()
      const days = Math.round(nowDate - pubDate) / (1000 * 60 * 60 * 24)
      if (days < 7) {
        if (days > 1) return 'Enregistré il y a ' + days + ' jours'
        else return 'Enregistré il y a ' + days + ' jour'
      }
      if (days > 7 && days < 31) {
        const weeks = Math.round(days / 7)
        if (weeks > 1) return 'Enregistré il y a ' + weeks + ' semaines'
        else return 'Enregistré il y a ' + weeks + ' semaine'
      }
      if (days > 31 && days < 365) {
        const months = Math.round(days / 31)
        if (months > 1) return 'Enregistré il y a ' + months + ' mois'
        else return 'Enregistré il y a ' + months + ' moi'
      }
      if (days > 365) {
        const years = Math.round(days / 365)
        if (years > 1) return 'Enregistré il y a ' + years + ' ans'
        else return 'Enregistré il y a ' + years + ' an'
      }
    }
  }
}
</script>
<style>
@import 'assets/css/style.projects.css';
@import 'assets/css/style.projects-child.css';
</style>
