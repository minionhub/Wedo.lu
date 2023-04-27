<template>
  <div id="page-content">
    <b-modal id="step_popup" class="step_popup_section" size="lg">
      <template slot="modal-header">
        <!-- Emulate built in modal header close button action -->
        <button
          type="button"
          class="close"
          data-dismiss="modal"
          @click="closeStepModal"
        ></button>
        <h4 class="modal-title">Obtenez un devis en 3 étapes simples</h4>
      </template>
      <ul class="step_middle_section">
        <li>
          <span class="step_number">1</span>
          <h4>Choisir une catégorie</h4>
          <span class="icon_pop"
            ><img
              src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/svg/ico_popup_catefory.svg"
              alt="#"
          /></span>
        </li>
        <li>
          <span class="step_number">2</span>
          <h4>Saisir les détails</h4>
          <span class="icon_pop"
            ><img
              src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/svg/ico_popup_details.svg"
              alt="#"
          /></span>
        </li>
        <li>
          <span class="step_number">3</span>
          <h4>Recevoir vos devis</h4>
          <span class="icon_pop"
            ><img
              src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/svg/ico_popup_quotes.svg"
              alt="#"
          /></span>
        </li>
      </ul>
      <div slot="modal-footer">
        <a class="btn_gotit" href="#" @click="closeStepModal"
          >D'accord, j'ai compris</a
        >
      </div>
    </b-modal>
    <div class="devis-content">
      <b-row class="wrap-content clearfix">
        <b-col xl="2" lg="4" md="4" class="filter">
          <div class="inner-filter">
            <div class="regions-item">
              <div id="regions-sub" class="regions-sub">
                <p
                  v-for="(cat, index) of cats"
                  :key="index"
                  @click="scrollDown"
                >
                  <b-link
                    :href="'/devis/' + cat.slug"
                    @click.prevent="onChangeCategory(index)"
                  >
                    <span>
                      <b-img
                        :src="cat.icon"
                        class="devis-sidebar-svg"
                        :class="catIdSelected === cat.id ? 'selected' : null"
                        alt="language"
                      />
                    </span>
                    <span>{{ cat.label }}</span>
                    <span>
                      <i class="material-icons align-middle"
                        >keyboard_arrow_right</i
                      >
                    </span>
                  </b-link>
                </p>
              </div>
            </div>
          </div>
        </b-col>
        <b-col xl="10" lg="8" md="8" class="subcats">
          <div class="search mb-5">
            <b-input-group>
              <b-form-input
                v-model="query"
                placeholder="ex : Carrelage, peinture d’intérieur..."
                @focus="onFocusSearch"
                @blur="onBlurSearch"
                @input="onInputSearch"
              ></b-form-input>
              <b-input-group-append>
                <b-button variant="outline-success">rechercher</b-button>
              </b-input-group-append>
            </b-input-group>

            <div v-if="isFocused" class="w-100 result">
              <p v-for="(subcat, index) of resultSearch" :key="index">
                <b-link :href="subcat.href">{{ subcat.label }}</b-link>
              </p>
            </div>
          </div>

          <div>
            <ul class="subcategory-list row">
              <li
                v-for="(subcat, index) of subcats"
                :key="index"
                class="col-xl-4 col-lg-6 col-md-12 mb-3"
              >
                <b-link
                  :href="
                    '/devis/quote/' + subcat.cat_slug + '/' + subcat.sub_slug
                  "
                  class="link-orange"
                >
                  <i
                    class="material-icons align-bottom"
                    style="font-size: 18px; color: #FFA601"
                    :href="subcat.href"
                    >keyboard_arrow_right</i
                  >
                  {{ subcat.label }}
                </b-link>
              </li>
            </ul>
          </div>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
export default {
  async validate({ params, $axios, error, catIdSelected }) {
    if (params.slug != null) {
      let cat = null
      try {
        cat = (await $axios.$get('/project/categories/slug/' + params.slug))
          .data
        if (
          typeof cat.category_id === 'undefined' ||
          cat.category_id === null
        ) {
          return false
        } else {
          return true
        }
      } catch (e) {
        return false
      }
    } else {
      return true
    }
  },
  data() {
    return {
      query: '',
      isFocused: false,
      resultSearch: [],
      catIdSelected: null,
      subcats: [],
      cats: []
    }
  },
  mounted() {
    if (
      this.$cookies.get('devis_modal_shown') !== 'undefined' &&
      this.$cookies.get('devis_modal_shown') !== 1
    ) {
      this.$cookies.set('devis_modal_shown', '1')
      this.$bvModal.show('step_popup')
    }

    this.init()
  },
  methods: {
    async init() {
      const allCats = (await this.$axios.$get('/project/categories/')).data
      const allSubcats = (await this.$axios.$get('/project/subcategories/'))
        .data
      allCats.forEach(cat => {
        this.cats.push({
          id: cat.category_id,
          label: cat.category_name,
          slug: cat.category_slug,
          icon: '/img' + cat.category_icon,
          subcats: allSubcats
            .filter(subcat => {
              return subcat.category_id === cat.category_id
            })
            .map(subcat => {
              return {
                id: subcat.sub_category_id,
                sub_slug: subcat.subcategory_slug,
                cat_id: subcat.category_id,
                cat_slug: cat.category_slug,
                label: subcat.subcategory_name,
                href: '#'
              }
            })
        })
      })
      if (this.$route.params.slug != null) {
        const catActive = this.cats.filter(cat => {
          return cat.slug === this.$route.params.slug
        })[0]
        this.catIdSelected = catActive.id
        this.subcats = catActive.subcats
        // this.cats.indexOf(cat => {
        //   if (cat.category_slug === this.$route.params.slug) {
        //     this.catIdSelected = cat.id
        //     this.subcats = this.cats[index].subcats
        //   } else {
        //     this.catIdSelected = this.cats[0].id
        //     this.subcats = this.cats[0].subcats
        //   }
        // })
      } else {
        this.catIdSelected = this.cats[0].id
        this.subcats = this.cats[0].subcats
      }
    },
    onChangeCategory(index) {
      this.subcats = this.cats[index].subcats
      this.catIdSelected = this.cats[index].id
    },
    onFocusSearch() {
      if (this.resultSearch.length > 0) this.isFocused = true
    },
    onBlurSearch() {
      this.isFocused = false
    },
    onInputSearch() {
      this.resultSearch = []

      this.cats.forEach(cat => {
        cat.subcats.forEach(subcat => {
          const label = subcat.label.toLowerCase()
          const query = this.query.toLowerCase()
          if (label.lastIndexOf(query) >= 0) {
            this.resultSearch.push(subcat)
          }
        })
      })

      if (this.resultSearch.length > 0) this.isFocused = true
      else this.isFocused = false
    },
    closeStepModal() {
      this.$bvModal.hide('step_popup')
    },
    scrollDown() {
      if (window.innerWidth < 768) {
        window.scrollBy(
          0,
          this.$el.querySelector('#regions-sub').clientHeight - window.scrollY
        )
      }
    }
  }
}
</script>

<style>
@import 'assets/css/step.modal.css';
.devis-content .subcats {
  padding: 65px 90px;
}

.devis-content .subcategory-list li {
  font-family: 'Open Sans', sans-serif;
  font-size: 15px;
  color: #5c5c68;
  font-weight: 300;
}

.devis-content .search {
  position: relative;
}

.devis-content .search input {
  font-size: 16px;
  border: 1px solid #888;
  border-top-left-radius: 15px !important;
  border-bottom-left-radius: 15px !important;
  padding: 18px;
  height: auto;
}

.devis-content .search button {
  border-radius: 0 15px 15px 0;
  background-color: #ffa602;
  color: #fefefe;
  text-transform: uppercase;
  font-size: 14px;
  font-weight: 700;
  padding-left: 50px;
  padding-right: 50px;
}

.devis-content .search .result {
  max-height: 300px;
  overflow-y: scroll;
  position: absolute;
  left: 0;
  top: calc(100% + 15px);
  padding: 10px 15px 5px;
  border: 1px solid rgba(0, 0, 0, 0.5);
  background: #fff;
  z-index: 100;
}

.devis-content .search .result a {
  font-size: 15px;
  color: #888;
}

.devis-content .search .result a:hover {
  color: rgb(255, 166, 1);
}

.devis-content .search .result a:last-child {
  margin-bottom: 0 !important;
}

.devis-content .selected {
  filter: invert(60%) sepia(98%) saturate(1120%) hue-rotate(357deg)
    brightness(102%) contrast(105%);
}

@media screen and (max-width: 991px) {
  .devis-content .subcats {
    padding: 50px;
  }

  .devis-content .search button {
    padding-left: 20px;
    padding-right: 20px;
  }
}

@media screen and (max-width: 576px) {
  .devis-content .subcats {
    padding: 20px;
  }
}
</style>
