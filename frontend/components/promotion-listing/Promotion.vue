<template>
  <div id="annonce" class="paid event">
    <div class="banner">
      <b-img :src="promotion.cover_img"></b-img>

      <!-- Banner Card -->
      <b-container>
        <div class="card">
          <figure class="mb-4 logo">
            <b-img :src="promotion.company.logo_img"></b-img>
          </figure>

          <h1 class="mb-5">{{ promotion.title }}</h1>
          <h2>{{ ellipse(promotion.full_description, 60) }}</h2>

          <div class="share">
            <b-link class="btn contact-btn">
              <b-img
                class="mr-3"
                src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/company/envelop.svg"
              ></b-img>
              Contacter
            </b-link>
          </div>
        </div>
      </b-container>
    </div>

    <b-tabs
      v-model="tabIndex"
      content-class="pt-5"
      nav-wrapper-class="nav-wrapper"
      nav-class="container"
      fill
    >
      <b-tab class="demand" href="#event" title="La promotion">
        <b-container>
          <b-row class="pb-5">
            <b-col md="6">
              <div class="w-100 custom-card p-3">
                <h5>
                  <Icon scale="1" name="insert_photo" class="mr-1" />
                  Bloc de galerie
                </h5>
                <div class="w-100 pt-2">
                  <WedoCarousel
                    :images="
                      typeof promotion.set_of_images === 'string'
                        ? JSON.parse(promotion.set_of_images)
                        : promotion.set_of_images
                    "
                  ></WedoCarousel>
                </div>
              </div>
            </b-col>

            <b-col md="6">
              <div class="custom-card p-3 mb-4">
                <h5>
                  <Icon scale="1" name="layers" class="mr-1" />
                  Entreprise:
                </h5>
                <p class="d-flex align-items-center mb-0 pt-2">
                  <b-link :href="'/annonce/' + promotion.company.slug">
                    <img
                      :src="promotion.company.logo_img"
                      class="mr-2 object-fit-cover object-position-center rounded-circle"
                      width="30px"
                      height="30px"
                      alt=""
                    />
                    {{ promotion.company.company_name }}
                  </b-link>
                </p>
              </div>

              <div class="custom-card p-3">
                <h5>
                  <Icon scale="1" name="view_headline" class="mr-1" />
                  Prix
                </h5>
                <p>
                  {{ promotion.price }}
                </p>
              </div>

              <div class="custom-card p-3">
                <h5>
                  <Icon scale="1" name="view_headline" class="mr-1" />
                  La Promotion
                </h5>
                <p>
                  {{ promotion.full_description }}
                </p>
              </div>
            </b-col>
          </b-row>
        </b-container>
      </b-tab>
      <b-tab
        class="demand"
        href="#participate"
        title="Profitez de la promotion"
      >
        <b-container>
          <b-row class="pb-5">
            <b-col md="6">
              <div class="custom-card p-3">
                <h5>
                  <Icon scale="1" name="email" class="mr-1" />
                  Contact Form
                </h5>
                <form action="" class="w-100 pt-2">
                  <WedoInput label="Votre nom"></WedoInput>
                  <WedoInput label="Votre adresse email"></WedoInput>
                  <WedoTextarea label="Votre message?"></WedoTextarea>
                  <WedoCheckbox
                    label="Je donne mon consentement pour que mes données soient transmises par ce formulaire"
                  ></WedoCheckbox>
                  <WedoButton
                    value="Envoyer message"
                    class="btn-block"
                  ></WedoButton>
                </form>
              </div>
            </b-col>
            <b-col md="6">
              <div class="custom-card p-3 mb-4">
                <h5>
                  <Icon scale="1" name="layers" class="mr-1" />
                  Entreprise:
                </h5>
                <p class="d-flex align-items-center mb-0 pt-2">
                  <b-link :href="'/annonce/' + promotion.company.slug">
                    <img
                      :src="promotion.company.logo_img"
                      class="mr-2 object-fit-cover object-position-center rounded-circle"
                      width="30px"
                      height="30px"
                      alt=""
                    />
                    {{ promotion.company.company_name }}
                  </b-link>
                </p>
              </div>
            </b-col>
          </b-row>
        </b-container>
      </b-tab>
    </b-tabs>
  </div>
</template>

<script>
import WedoCarousel from '~/components/WedoCarousel.vue'
import WedoInput from '~/components/WedoInput.vue'
import WedoButton from '~/components/WedoButton.vue'
import WedoCheckbox from '~/components/WedoCheckbox.vue'
import WedoTextarea from '~/components/WedoTextarea.vue'
import Icon from 'vue-awesome/components/Icon'
import 'vue-awesome/icons'
import 'vue-awesome-material-icons/icons/backspace_outlined'
import 'vue-awesome-material-icons/icons/view_module'
import 'vue-awesome-material-icons/icons/map'
import 'vue-awesome-material-icons/icons/email'

export default {
  name: 'Promotion',
  components: {
    WedoCarousel,
    WedoInput,
    WedoButton,
    WedoCheckbox,
    WedoTextarea,
    Icon
  },
  props: {
    promotion: {
      type: Object,
      default: function() {
        return {}
      }
    }
  },
  data() {
    return {
      tabIndex: 0,
      tabs: ['#promotion', '#participate']
    }
  },
  created() {
    this.tabIndex = this.tabs.findIndex(tab => tab === this.$route.hash)
  },
  methods: {
    ellipse(string, nLetters) {
      return string.substring(0, nLetters) + '...'
    }
  }
}
</script>

<style>
@import 'assets/css/annonce.css';
</style>
