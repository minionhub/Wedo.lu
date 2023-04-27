<template>
  <div class="full-width">
    <b-modal
      id="confirm-modal"
      hide-header
      ok-only
      ok-title="Fermer"
      ok-variant="secondary"
    >
      <template slot="modal-title"> </template>
      <div class="d-block text-center">
        <p>Les réglages des notifications ont été mis à jour</p>
      </div>
    </b-modal>
    <div id="content" class="site-content">
      <div id="quote-page-head">
        <figure class="page-head-image">
          <b-img
            src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/profile/skill-banner.png"
          ></b-img>
        </figure>
        <div class="container">
          <div class="description">
            <h1>Recevoir des demandes de devis pour vos competences</h1>
          </div>
        </div>
      </div>
      <div class="quote-wrapper">
        <b-row>
          <b-col lg="12" center class="notification-box">
            <p>
              Choisir vos compétences <span class="dash">-</span> Fournir votre
              adresse e-mail <span class="dash">-</span> Recevoir des
              notifications
            </p>
          </b-col>
        </b-row>
        <b-form id="update_profile_meta" class="update-profile" novalidate>
          <b-container fluid class="default-sidebar">
            <b-row class="same-height1">
              <b-col id="sidebar" lg="3" sm="4" class="sidebar-nav">
                <nav id="sidebar-navigation">
                  <ul>
                    <li v-for="(cat, index) of cats" :key="index">
                      <a
                        class="category-select"
                        @click="onChangeCategory(index)"
                      >
                        <span class="icon"
                          ><img
                            :src="cat.icon"
                            alt="language"
                            class="devis-sidebar-svg"
                        /></span>
                        <span>{{ cat.label }}</span>
                        <input
                          type="hidden"
                          class="category-slug"
                          value="construction"
                        />
                      </a>
                    </li>
                  </ul>
                </nav>
              </b-col>
              <b-col id="main" lg="9" sm="8">
                <div class="box1 categories-wrapper">
                  <ul class="list-unstyled skill-list">
                    <li class="full-width">
                      <label class="switch">
                        <input
                          v-model="resetStatus"
                          type="checkbox"
                          @click="onResetSkills()"
                        />
                        <span class="slider round"></span>
                      </label>
                      Select All / Unselect All
                    </li>
                    <b-form-checkbox-group
                      id="checkbox-group-2"
                      v-model="skills"
                      name="flavour-2"
                    >
                      <li v-for="(subcat, index) of subcats" :key="index">
                        <label class="label-container">
                          <b-form-checkbox :value="subcat.id">{{
                            subcat.label
                          }}</b-form-checkbox>
                        </label>
                      </li>
                    </b-form-checkbox-group>
                  </ul>
                </div>
              </b-col>
            </b-row>
            <b-row class="notification-wrapper">
              <b-col sm="12">
                <div class="notification-form">
                  <label
                    >Adresse email supplémentaire pour les notifications
                  </label>
                  <b-form-input
                    v-model="email"
                    placeholder="Votre adresse email"
                    class="update"
                  ></b-form-input>
                </div>
              </b-col>
            </b-row>
            <b-row>
              <b-col sm="12">
                <div class="notification-form text-right">
                  <b-link to="/dashboard" class="btn btn-orange"
                    >Retour tableau de bord</b-link
                  >
                  <b-button
                    class="btn btn-orange"
                    style="border-color: unset;"
                    @click="saveSkills"
                    >sauvegarder</b-button
                  >
                </div>
              </b-col>
            </b-row>
          </b-container>
        </b-form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      query: '',
      subCategories: [],
      mainCat: {},
      catIdSelected: null,
      subcats: [],
      cats: [],
      viewCats: [],
      resetStatus: false,
      skills: [],
      selectedIndex: 0,
      email: ''
    }
  },
  watch: {
    skills(newVal, oldVal) {
      this.cats[this.selectedIndex].skills = newVal
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    async init() {
      this.email = this.user.email_project_notifications
      const allCats = (await this.$axios.$get('/project/categories/')).data
      const allSubcats = (await this.$axios.$get('/project/subcategories/'))
        .data
      allCats.forEach(cat => {
        this.cats.push({
          id: cat.category_id,
          label: cat.category_name,
          slug: cat.category_slug,
          icon: '/img' + cat.category_icon,
          checkedAll: 0,
          subcats: allSubcats
            .filter(subcat => {
              return subcat.category_id === cat.category_id
            })
            .map(subcat => {
              return {
                id: subcat.subcategory_id,
                sub_slug: subcat.subcategory_slug,
                cat_id: subcat.category_id,
                cat_slug: cat.category_slug,
                label: subcat.subcategory_name,
                href: '#'
              }
            })
        })
      })

      this.catIdSelected = this.cats[0].id
      this.subcats = this.cats[0].subcats

      this.$axios
        .$post('/project/notifications/', {
          user: this.user.id
        })
        .then(response => {
          this.cats.forEach(cat => {
            response['notifications for all categories']
              .filter(category => {
                return category.category_id === cat.id
              })
              .map(category => {
                cat.skills = category.notifications
              })
          })
          this.skills = this.cats[0].skills
        })
    },
    onChangeCategory(index) {
      this.selectedIndex = index
      this.subcats = this.cats[index].subcats
      this.catIdSelected = this.cats[index].id
      this.skills = this.cats[index].skills
      if (this.cats[index].checkedAll === 1) this.resetStatus = true
      else this.resetStatus = false
    },
    onResetSkills() {
      if (this.resetStatus === true) {
        this.skills = []
        this.cats[this.selectedIndex].checkedAll = 2
      } else {
        this.subcats.forEach(subcat => {
          this.skills.push(subcat.id)
        })
        this.cats[this.selectedIndex].checkedAll = 1
      }
      this.cats[this.selectedIndex].skills = this.skills
    },
    async saveSkills() {
      let allSkills = []
      this.cats.forEach(cat => {
        if (cat.skills === null) return
        if (cat.skills === undefined) return
        if (typeof cat.skills === 'number') allSkills.push(cat.skills)
        else allSkills.push(...cat.skills)
      })
      if (this.email === '') this.email = null

      allSkills = []
      const data = {
        save: 1,
        email: this.email,
        user: this.user.id,
        notifications: allSkills
      }

      await this.$axios
        .$post('/project/notifications/', data)
        .then(response => {
          if (response.status === 'success') this.$bvModal.show('confirm-modal')
        })
    }
  }
}
</script>

<style>
@import 'assets/css/template.css';
@import 'assets/css/style.profile.css';
.container-fluid {
  text-align: left;
}
#confirm-modal {
  top: 100px !important;
}
#confirm-modal button {
  background-color: #faab1b !important;
  border: unset;
}
</style>
