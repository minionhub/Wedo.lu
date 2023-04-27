<template>
  <div id="main-page">
    <div class="banner w-100">
      <b-img
        class="w-100"
        src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/main-page/banner.jpg"
        alt="banner image"
      ></b-img>
    </div>

    <div class="intro">
      <b-container>
        <div class="search-box bg-white">
          <h2 class="text-center">wedo.lu vous présente</h2>
          <h3 class="text-center">les meilleurs Artisans du Luxembourg</h3>
          <b-form>
            <b-row>
              <b-col lg="8">
                <input
                  v-model="query"
                  placeholder="Que recherchez vous ?"
                  class="w-100"
                  style="outline:none;"
                  @keydown.enter.prevent="searchCompany"
                />
              </b-col>
              <b-col lg="4">
                <b-button class="btn-block" @click.prevent="searchCompany"
                  >Trouver un artisan</b-button
                >
              </b-col>
            </b-row>
          </b-form>
        </div>

        <div class="row intro-items">
          <b-col md="2"></b-col>
          <b-col md="4">
            <a href="devis">
              <div class="intro-item text-center">
                <b-img
                  src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/main-page/doc.svg"
                  alt="link icon"
                ></b-img>
                <p class="pt-2">Demander un devis</p>
              </div>
            </a>
          </b-col>
          <b-col md="4">
            <a href="jobboard">
              <div class="intro-item text-center">
                <b-img
                  src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/main-page/pin.svg"
                  alt="link icon"
                ></b-img>
                <p class="pt-2">Offres d'emplois</p>
              </div>
            </a>
          </b-col>
          <b-col md="2"></b-col>
        </div>
      </b-container>
    </div>

    <div class="projects">
      <b-container>
        <h2 class="text-center">
          Trouvez le bon partenaire<br />
          pour tous vos projets sur wedo.lu
        </h2>

        <b-row class="mb-5 mt-5">
          <b-col md="3" sm="6" class="text-center pr-2 pl-2 mb-3">
            <b-img
              class="mb-3"
              src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/main-page/marker.svg"
            ></b-img>
            <p>
              3.000 entreprises artisanales près de chez vous
            </p>
          </b-col>
          <b-col md="3" sm="6" class="text-center pr-2 pl-2 mb-3">
            <b-img
              class="mb-3"
              src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/main-page/clock.svg"
            ></b-img>
            <p>
              Le moyen rapide et efficace de trouver le bon partenaire pour
              votre projet
            </p>
          </b-col>
          <b-col md="3" sm="6" class="text-center pr-2 pl-2 mb-3">
            <b-img
              class="mb-3"
              src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/main-page/bookmark.svg"
            ></b-img>
            <p>
              Des entreprises qualifiées qui offrent toutes les garanties
              légales
            </p>
          </b-col>
          <b-col md="3" sm="6" class="text-center pr-2 pl-2 mb-3">
            <b-img
              class="mb-3"
              src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/main-page/search.svg"
            ></b-img>
            <p>
              Découvrez les jobs et les carrières dans l’artisanat
              luxembourgeois
            </p>
          </b-col>
        </b-row>

        <div class="categories shadow-custom">
          <h2 class="text-center mb-5">Nos catégories</h2>
          <b-row v-if="cats.length">
            <b-link
              v-for="(cat, index) in cats"
              :key="index"
              :href="cat.slug"
              class="col-md-6 category text-center"
            >
              <b-img class="mb-3" :src="'/img' + cat.icon"></b-img>
              <p>{{ cat.name }}</p>
            </b-link>
          </b-row>
          <b-row
            v-if="!cats.length"
            style="padding-top:300px; padding-bottom: 300px"
          >
            <h1 class="mx-auto">Categories can't be loaded right now</h1>
          </b-row>
        </div>

        <div class="call-to-action shadow-custom">
          <b-row>
            <b-col lg="9">
              <p>Vous avez des travaux à réaliser?</p>
            </b-col>
            <b-col lg="3">
              <b-link class="btn btn-block pull-right" href="devis">
                Demander un devis
              </b-link>
            </b-col>
          </b-row>
        </div>
      </b-container>
    </div>

    <div class="partners pt-5 pb-5 bg-white">
      <h2 class="text-center">Les partenaires de l'artisanat</h2>
      <div class="text-center">
        <b-link class="p-3" href="http://www.fpme.lu">
          <b-img
            src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/main-page/fiduciaire.png"
          ></b-img>
        </b-link>
        <b-link class="p-3" href="https://www.fda.lu">
          <b-img
            src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/main-page/fda.png"
          ></b-img>
        </b-link>
        <b-link class="p-3" href="http://www.robin.lu/">
          <b-img
            src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/main-page/mpme.png"
          ></b-img>
        </b-link>
      </div>
    </div>

    <div class="call-to-action shadow-custom">
      <b-container>
        <b-row>
          <b-col lg="9">
            <p>Vous avez des travaux à réaliser?</p>
          </b-col>
          <b-col lg="3">
            <b-link class="btn btn-block pull-right" href="devis">
              Demander un devis
            </b-link>
          </b-col>
        </b-row>
      </b-container>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showCat: {},
      cats: [],
      query: ''
    }
  },
  asyncData({ params, $axios }) {
    return $axios
      .$get('/category/root')
      .then(res => {
        const cats = res.data
        console.log(cats)
        return {
          cats: cats
        }
      })
      .catch(error => {
        if (error.response) {
          console.log(error.response.data)
          console.log(error.response.status)
          console.log(error.response.headers)
        } else if (error.request) {
          console.log(error.request)
        } else {
          console.log('Error', error.message)
        }
        console.log(error.config)
      })
  },
  methods: {
    async init() {},
    searchCompany() {
      if (typeof this.query === 'undefined' || this.query === '') return

      this.$router.push({
        path:
          '/annuaire-2?search_keywords=' +
          this.query +
          '&tab=search-form&type=place'
      })
    }
  }
}
</script>
<style lang="css">
@import 'assets/css/main-page.css';
</style>
