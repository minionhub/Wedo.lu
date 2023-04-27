<template>
  <div class="full-width">
    <div id="content" class="site-content">
      <div class="quote-wrapper">
        <b-container fluid class="default-sidebar">
          <b-row>
            <b-col id="sidebar" lg="3">
              <div class="text-center sent-wrapper">
                <figure>
                  <b-img
                    src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/icons/sent-icon2.svg"
                    alt="image"
                  ></b-img>
                </figure>
                <h2>C'est parti!</h2>
                <p>
                  Votre demande de devis sera analysée. Vous allez bientôt être
                  contacté par des artisans professionnels.
                </p>
              </div>
            </b-col>
            <b-col id="main" lg="9" class="quotes-sub-category">
              <h2>Besoin d'autre devis?</h2>
              <b-row>
                <b-col
                  v-for="(card, index) of subCategories"
                  :key="index"
                  sm="6"
                >
                  <WedoCard
                    src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/projects/Assurances-luxembourg.png"
                    :to="
                      '/devis/quote/' +
                        mainCat.category_slug +
                        '/' +
                        card.subcategory_slug
                    "
                    :title="card.subcategory_name"
                  >
                  </WedoCard>
                </b-col>
              </b-row>
            </b-col>
          </b-row>
        </b-container>
      </div>
    </div>
  </div>
</template>

<script>
import WedoCard from '~/components/WedoCard.vue'
export default {
  components: {
    WedoCard
  },
  data() {
    return {
      query: '',
      subCategories: [],
      mainCat: {}
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    async init() {
      this.subCategory = await this.$axios.$get(
        '/project/submitted/' + this.$route.query.skill
      )

      this.subCategories = this.subCategory.subcategories

      const catId = this.subCategories[0].category_id
      this.mainCat = await this.$axios.$get('/project/categories/' + catId)
      this.mainCat = this.mainCat.data
    }
  }
}
</script>

<style>
@import 'assets/css/style.jupiter.css';
@import 'assets/css/template.css';

.container-fluid {
  padding-top: 50px !important;
}
</style>
