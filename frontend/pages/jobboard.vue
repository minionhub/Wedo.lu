<template>
  <div id="board-page">
    <!-- Banner -->
    <div class="banner jobboard-banner">
      <div class="inner-content">
        <h1>Job Board</h1>
        <p>Les dernières offres d'emploi dans l'artisanat Luxembourgeoi</p>
      </div>
    </div>
    <!-- Banner -->

    <div class="board-content jobboard-content">
      <b-row class="wrap-content clearfix">
        <!-- Left block -->
        <b-col lg="3" md="4" class="filter">
          <div class="inner-filter">
            <p class="title">Filtres de recherche</p>

            <div class="contract-item">
              <p
                class="collapse-toggle"
                aria-expanded="true"
                aria-controls="tax-sub"
                :class="showContractFilter ? 'collapsed' : null"
                @click="showContractFilter = !showContractFilter"
              >
                <span class="toggle-label" role="button">
                  Contrat de travail
                  <div
                    v-if="filterOptions.contract_type.length > 0"
                    class="badge"
                  >
                    {{ filterOptions.contract_type.length }}
                  </div>
                  <i class="material-icons">chevron_right</i>
                </span>
              </p>

              <b-collapse
                id="tax-sub"
                v-model="showContractFilter"
                class="tax-sub"
              >
                <p>
                  <label class="wrap-checkbox">
                    Tous les contrats
                    <input
                      type="checkbox"
                      :checked="filterOptions.contract_type.length == 0"
                      :disabled="filterOptions.contract_type.length == 0"
                      @change="onCheckContractAll"
                    />
                    <span class="checkmark"></span>
                  </label>
                </p>
                <p v-for="contract in contracts" :key="contract.value">
                  <label class="wrap-checkbox">
                    {{ contract.label }}
                    <input
                      v-model="filterOptions.contract_type"
                      type="checkbox"
                      :value="contract.value"
                    />
                    <span class="checkmark"></span>
                  </label>
                </p>
              </b-collapse>
            </div>

            <div class="category-item">
              <p
                class="collapse-toggle"
                aria-expanded="true"
                aria-controls="category-sub"
                :class="showCategoryFilter ? 'collapsed' : null"
                @click="showCategoryFilter = !showCategoryFilter"
              >
                <span class="toggle-label">
                  Catégories
                  <div v-if="filterOptions.categories.length > 0" class="badge">
                    {{ filterOptions.categories.length }}
                  </div>
                  <i class="material-icons">chevron_right</i>
                </span>
              </p>

              <b-collapse
                id="category-sub"
                v-model="showCategoryFilter"
                class="category-sub"
              >
                <p>
                  <label class="wrap-checkbox checkbox-svg">
                    <input
                      type="checkbox"
                      :checked="filterOptions.categories.length == 0"
                      :disabled="filterOptions.categories.length == 0"
                      @change="onCheckCatAll"
                    />
                    <img
                      class="svg"
                      src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/icons/ico_categ_all.svg"
                      alt="Alt text here."
                    />
                    Toutes les catégories
                    <span class="checkmark"></span>
                  </label>
                </p>
                <p v-for="cat in cats" :key="'cat-' + cat.id">
                  <label class="wrap-checkbox checkbox-svg">
                    <input
                      v-model="filterOptions.categories"
                      type="checkbox"
                      :value="cat.id"
                    />
                    <img
                      class="svg"
                      :src="'/img' + cat.icon"
                      alt="Alt text here."
                    />
                    {{ cat.name }}
                    <span class="checkmark"></span>
                  </label>
                </p>
              </b-collapse>
            </div>

            <div class="regions-item">
              <p
                class="collapse-toggle"
                aria-expanded="true"
                aria-controls="regions-sub"
                :class="showRegionFilter ? 'collapsed' : null"
                @click="showRegionFilter = !showRegionFilter"
              >
                <span class="toggle-label">
                  Villes
                  <div v-if="filterOptions.regions.length > 0" class="badge">
                    {{ filterOptions.regions.length }}
                  </div>
                  <i class="material-icons">chevron_right</i>
                </span>
              </p>

              <b-collapse
                id="regions-sub"
                v-model="showRegionFilter"
                class="regions-sub"
              >
                <p>
                  <label class="wrap-checkbox">
                    Toutes les régions
                    <input
                      type="checkbox"
                      :checked="filterOptions.regions.length == 0"
                      :disabled="filterOptions.regions.length == 0"
                      @change="onCheckRegionAll"
                    />
                    <span class="checkmark"></span>
                  </label>
                </p>
                <p v-for="region in regions" :key="region.region_id">
                  <label class="wrap-checkbox">
                    {{ region.name }}
                    <input
                      v-model="filterOptions.regions"
                      type="checkbox"
                      :value="region.region_id"
                    />
                    <span class="checkmark"></span>
                  </label>
                </p>
              </b-collapse>
            </div>
          </div>
        </b-col>
        <!-- Left block -->

        <!-- Right block -->
        <b-col lg="9" md="8" class="right-content">
          <div class="inner-right-content">
            <!-- Search form -->
            <div class="search-form">
              <form id="blog-search-form" class="clearfix">
                <input
                  v-model="query"
                  type="text"
                  placeholder="Que recherchez vous ?"
                  class="keyword"
                  @keydown.enter.prevent="filterOptions.query = query"
                />
                <button @click.prevent="filterOptions.query = query">
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
                    v-for="jobOffer in jobOffers"
                    :key="jobOffer.listing_id"
                    class="col-xl-4 col-sm-6 item"
                  >
                    <div class="wrapper">
                      <a href="#" class="tag">{{ jobOffer.company_name }}</a>
                      <a :href="'/annonce/' + jobOffer.slug">
                        <div class="img-wrap">
                          <img :src="jobOffer.cover_img" alt="Alt text here." />
                        </div>
                        <div class="bottom-text">
                          <h3>{{ jobOffer.job_title }}</h3>
                          <div class="outer-location">
                            <p class="location">
                              {{ jobOffer.region[0] }}
                            </p>
                            <p class="location location-more">
                              +{{ jobOffer.region.length - 1 }}
                            </p>
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
        </b-col>
        <!-- Right block -->
      </b-row>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showContractFilter: true,
      showCategoryFilter: true,
      showRegionFilter: true,
      contracts: [
        { value: 'CDI', label: 'CDI' },
        { value: 'CDD', label: 'CDD' },
        { value: 'Intership', label: 'Internship' }
      ],
      cats: [],
      regions: [],
      currentPage: 1,
      perPage: 21,
      totalRows: 0,
      filterOptions: {
        query: '',
        contract_type: [],
        categories: [],
        regions: []
      },
      query: '',
      jobOffers: []
    }
  },
  watch: {
    'filterOptions.query': function() {
      this.onChangeFilterOptions()
    },
    'filterOptions.contract_type': function() {
      this.onChangeFilterOptions()
    },
    'filterOptions.categories': function() {
      this.onChangeFilterOptions()
    },
    'filterOptions.regions': function() {
      this.onChangeFilterOptions()
    }
  },
  mounted() {
    this.init()
    this.fetchJobOffers()
  },
  methods: {
    async init() {
      this.cats = (await this.$axios.$get('/category/root')).data
      this.regions = (await this.$axios.$get('/region/')).data
    },
    onCheckContractAll(e) {
      if (e.target.checked) this.filterOptions.contract_type = []
    },
    onCheckCatAll(e) {
      if (e.target.checked) this.filterOptions.categories = []
    },
    onCheckRegionAll(e) {
      if (e.target.checked) this.filterOptions.regions = []
    },
    onChangeFilterOptions() {
      this.currentPage = 1
      this.fetchJobOffers()
    },
    onChangePage(page) {
      this.currentPage = page
      this.fetchJobOffers()
    },
    async fetchJobOffers() {
      if (this.filterOptions.query === '') {
        const options = {}
        options.contracts = this.filterOptions.contract_type
        options.title = this.filterOptions.query
        options.categories = this.filterOptions.categories
        options.regions = this.filterOptions.regions
        const data = (await this.$axios.$post(
          '/joboffer/filter?page=' + this.currentPage,
          options
        )).data
        this.jobOffers = data.data
        this.totalRows = data.total
        this.perPage = data.per_page
      } else {
        const options = {}
        options.query = this.filterOptions.query
        if (
          typeof this.filterOptions.contract_type !== 'undefined' &&
          this.filterOptions.contract_type.length > 0
        )
          options.contract_type = this.filterOptions.contract_type
        if (
          typeof this.filterOptions.categories !== 'undefined' &&
          this.filterOptions.categories.length > 0
        )
          options.categories = this.filterOptions.categories
        if (
          typeof this.filterOptions.regions !== 'undefined' &&
          this.filterOptions.regions.length > 0
        )
          options.regions = this.filterOptions.regions
        const data = (await this.$axios.$post(
          '/search/joboffer/?page=' + this.currentPage,
          options
        )).data
        this.jobOffers = data.data
        this.totalRows = data.total
        this.perPage = data.per_page
      }
    }
  }
}
</script>

<style>
@import 'assets/css/board.css';
</style>
