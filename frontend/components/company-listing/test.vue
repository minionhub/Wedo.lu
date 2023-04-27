<template>
  <div id="annonce" class="paid">
    <div class="banner">
      <b-img class="cover" :src="company.cover_img"></b-img>

      <b-container>
        <b-row>
          <b-col>
            <b-img :src="company.logo_img" class="logo"></b-img>
          </b-col>
        </b-row>
        <b-row>
          <b-col md="6">
            <h1 class="pt-3 pb-2 m-0">{{ company.company_name }}</h1>
            <h2 class="py-3 m-0">{{ company.short_desc }}</h2>
          </b-col>
          <b-col md="6" class="share">
            <div class="text-right">
              <b-link class="btn call-btn mr-2" :href="'tel:' + company.phone">
                <b-img class="mr-3" src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/company/phone.svg"></b-img>
                Appeler
              </b-link>
              <b-link href="#contact" class="btn contact-btn">
                <b-img class="mr-3" src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/company/envelop.svg"></b-img>
                Contacter
              </b-link>
            </div>
          </b-col>
          <b-col cols="12">
            <div class="pt-3 detail-wrapper">
              <div
                class="detail-item mb-3 mr-2 d-inline-flex align-items-center"
              >
                <img
                  src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_info_time.png"
                  class="mr-2"
                />
                Heures d'ouverture
              </div>
              <div
                class="detail-item mb-3 mr-2 d-inline-flex align-items-center"
              >
                <img
                  src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_info_location.png"
                  class="mr-2"
                />
                {{ company.houseNbr ? company.houseNbr + ', ' : '' }}
                {{ company.street ? company.street + ', ' : '' }}
                {{ company.city ? company.city + ', ' : '' }}
              </div>
              <div
                class="detail-item mb-3 mr-2 d-inline-flex align-items-center"
              >
                <img
                  src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_info_fax.png"
                  class="mr-2"
                />
                {{ company.fax }}
              </div>
              <div
                class="detail-item mb-3 mr-2 d-inline-flex align-items-center"
              >
                <img
                  src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_info_call.png"
                  class="mr-2"
                />
                {{ company.phone }}
              </div>
              <div
                class="detail-item mb-3 mr-2 d-inline-flex align-items-center"
              >
                <img
                  src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_info_email.png"
                  class="mr-2"
                />
                {{ company.contact_email }}
              </div>
            </div>
          </b-col>
        </b-row>
      </b-container>
      <!-- Banner Card -->
      <!-- <b-container>
        <div class="card">
          <figure class="mb-4 logo">
            <b-img :src="company.logo_img"></b-img>
          </figure>

          <h1>{{ company.company_name }}</h1>
          <h2>{{ company.short_desc }}</h2>

          <div class="share">
            <b-link class="btn call-btn mr-2" :href="'tel:' + company.phone">
              <b-img class="mr-3" src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/company/phone.svg"></b-img>
              Appeler
            </b-link>
            <b-link class="btn contact-btn">
              <b-img class="mr-3" src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/company/envelop.svg"></b-img>
              Contacter
            </b-link>
          </div>
        </div>
      </b-container> -->
    </div>

    <b-container class="pt-3">
      <b-tabs
        v-model="tabIndex"
        content-class="pt-5"
        nav-wrapper-class="nav-wrapper"
        fill
      >
        <b-tab class="profile">
          <template slot="title">
            <div class="d-block mb-1">
              <img
                src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_nav_description.png"
              />
            </div>
            À propos de nous
          </template>

          <div class="w-100 bg-white custom-collapse">
            <div
              v-b-toggle.company-desc
              class="collapse-toggle w-100 px-4 py-2 d-flex align-items-center"
            >
              <img
                class="pr-3"
                src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_description.png"
              />
              À propos de {{ company.company_name }}
            </div>
            <b-collapse visible id="company-desc">
              <div class="p-4">
                {{ company.full_description }}
              </div>
            </b-collapse>
          </div>

          <div class="w-100 bg-white custom-collapse">
            <div
              v-b-toggle.company-desc
              class="collapse-toggle w-100 px-4 py-2 d-flex align-items-center"
            >
              <img
                class="pr-3"
                src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_time.png"
              />
              Heures d'ouverture de {{ company.company_name }}
            </div>
            <b-collapse visible id="company-desc">
              <div class="p-4">
                {{ company.full_description }}
              </div>
            </b-collapse>
          </div>

          <b-container>
            <!-- Details (Email, phone, fax, location, url) -->
            <ContactCard
              class="mb-5"
              :street="company.street"
              :house-nbr="company.houseNbr"
              :contact-email="company.contact_email"
              :website-url="company.website_url"
              :fax="company.fax"
              :phone="company.phone"
            >
            </ContactCard>

            <!-- Carousel -->
            <WedoCarousel
              class="mb-5"
              :images="
                typeof company.set_of_images === 'string'
                  ? JSON.parse(company.set_of_images)
                  : company.set_of_images
              "
            ></WedoCarousel>

            <!-- Full description -->
            <div class="full-desc p-5 custom-card mb-5">
              <h2>{{ 'À propos de ' + company.company_name }}</h2>
              <div v-html="company.full_description"></div>
            </div>

            <!-- Languages, Facilities, Regions, Payment methods -->
            <b-row class="array-wrapper">
              <b-col md="6" class="mb-5 border-right">
                <h2>Langues parlées:</h2>
                <ul class="row mb-0">
                  <li
                    v-for="(lang, index) of company.spoken_languages"
                    :key="'lang-' + index"
                    class="col-lg-6"
                  >
                    {{ lang }}
                  </li>
                </ul>
              </b-col>
              <b-col md="6" class="mb-5">
                <h2>Facilités:</h2>
                <ul class="row mb-0">
                  <li
                    v-for="(facility, index) of company.facilities"
                    :key="'facility' + index"
                    class="col-lg-6"
                  >
                    {{ facility }}
                  </li>
                </ul>
              </b-col>
              <b-col md="6" class="mb-5 border-right">
                <h2>Modes de paiement acceptés:</h2>
                <ul class="row mb-0">
                  <li
                    v-for="(method, index) of company.accepted_payment_methods"
                    :key="'method' + index"
                    class="col-lg-6"
                  >
                    {{ paymentMethods[method] }}
                  </li>
                </ul>
              </b-col>
              <b-col md="6" class="mb-5">
                <h2>Régions d'activité:</h2>
                <ul class="row mb-0">
                  <li
                    v-for="(region, index) of company.regions"
                    :key="'region-' + index"
                    class="col-lg-6"
                  >
                    <b-link href="#">{{ region.name }}</b-link>
                  </li>
                </ul>
              </b-col>
            </b-row>
          </b-container>

          <div class="w-100 bg-white border-top border-bottom">
            <b-container>
              <!-- Opening hours -->
              <div class="w-100 py-5 border-bottom">
                <b-row class="working-hours">
                  <b-col sm="4">
                    <h2>Heures d'ouverture:</h2>
                  </b-col>
                  <b-col sm="8" class="border-left">
                    <b-row
                      v-for="(weekDay, index) of weekDays"
                      :key="'hourw-' + index"
                      class="mb-3"
                    >
                      <b-col
                        cols="3"
                        sm="4"
                        md="5"
                        lg="6"
                        class="pl-5 text-capitalize"
                      >
                        {{ weekDaysFr[index] }}
                      </b-col>
                      <b-col
                        v-if="company.opening_hours[weekDay].type == 0"
                        cols="9"
                        sm="8"
                        md="7"
                        lg="6"
                        class="hours"
                      >
                        <span
                          v-for="hour in company.opening_hours[weekDay]
                            .intervals"
                          :key="hour.type"
                          class="hour px-2"
                        >
                          {{ hour[0] + ' - ' + hour[1] }}
                        </span>
                      </b-col>
                      <b-col
                        v-else-if="company.opening_hours[weekDay].type == 1"
                        cols="9"
                        sm="8"
                        md="7"
                        lg="6"
                      >
                        <span class="hour px-2">
                          Ouvert toute la journée
                        </span>
                      </b-col>
                      <b-col
                        v-else-if="company.opening_hours[weekDay].type == 2"
                        cols="9"
                        sm="8"
                        md="7"
                        lg="6"
                      >
                        <span class="hour px-2">
                          Fermé toute la journée
                        </span>
                      </b-col>
                      <b-col
                        v-else-if="company.opening_hours[weekDay].type == 3"
                        cols="9"
                        sm="8"
                        md="7"
                        lg="6"
                      >
                        <span class="hour px-2">
                          Uniquement sur rendez-vous
                        </span>
                      </b-col>
                    </b-row>
                  </b-col>
                </b-row>
              </div>

              <!-- Contact People -->
              <div class="contact-people w-100 py-5">
                <h2>Personnes de contact chez {{ company.company_name }}:</h2>
                <b-row>
                  <b-col
                    v-for="agent in company.contact_people"
                    :key="'agent-' + agent.id"
                    md="3"
                    class="text-center"
                  >
                    <h3>{{ agent.first_name }} {{ agent.last_name }}</h3>
                    <!-- <p>{{ agent.role }}</p> -->
                    <p>
                      <b-link :href="'tel:' + agent.phone">
                        {{ agent.phone }}
                      </b-link>
                    </p>
                  </b-col>
                </b-row>
              </div>
            </b-container>
          </div>

          <div class="w-100 pt-5">
            <b-container>
              <div class="w-100 border-bottom">
                <h2>En savoir plus sur {{ company.company_name }}:</h2>
                <b-row>
                  <b-col lg="6" class="mb-5">
                    <!-- Keywords -->
                    <div class="w-100 custom-card p-5">
                      <h2>Nos activités et services</h2>
                      <div class="service-list">
                        <p
                          v-for="(service, index) of company.services"
                          :key="'service-' + index"
                          class="mb-4"
                        >
                          <b-link :href="'/service/' + service.slug">
                            <div class="outlined mr-3">
                              <Icon scale="1" name="bookmark" />
                            </div>

                            <div class="d-inline-flex">{{ service.name }}</div>
                          </b-link>
                        </p>
                      </div>
                    </div>
                  </b-col>

                  <b-col lg="6" class="mb-5">
                    <!-- Other information -->
                    <div class="w-100 custom-card p-5">
                      <h2>Informations administratives et financières</h2>
                      <div class="financial-info">
                        <p class="border-top py-3">
                          <span>N° Nace</span>
                          <span class="float-right">{{
                            company.codeNace
                          }}</span>
                        </p>
                        <p class="border-top py-3">
                          <span>N° Registre du Commerce</span>
                          <span class="float-right">
                            {{ company.commercialRegisterCode }}
                          </span>
                        </p>
                        <p class="border-top py-3">
                          <span>N° TVA International</span>
                          <span class="float-right">
                            {{ company.internationalTVAnbr }}
                          </span>
                        </p>
                        <p class="border-top py-3">
                          <span>N° TVA National</span>
                          <span class="float-right">
                            {{ company.nationalTVAnbr }}
                          </span>
                        </p>
                        <p class="border-top py-3">
                          <span>Capital</span>
                          <span class="float-right">
                            {{ company.shareCapital }}
                          </span>
                        </p>
                        <p class="border-top py-3">
                          <span>Nombre de salariés</span>
                          <span class="float-right">
                            {{ company.employeeNbr }}
                          </span>
                        </p>
                        <p class="border-top py-3">
                          <span>Date de fondation</span>
                          <span class="float-right">
                            {{ company.foundationDate }}
                          </span>
                        </p>
                      </div>
                    </div>
                  </b-col>
                </b-row>
              </div>

              <!-- Brands -->
              <div class="w-100 border-bottom py-5 brand-list mb-5">
                <b-row>
                  <b-col lg="3" md="4">
                    <h2>Produits et marques:</h2>
                  </b-col>
                  <b-col lg="9" md="8">
                    <h4
                      v-for="brand in company.brands"
                      :key="'brand-' + brand"
                      class="d-inline-block border-right px-3 mb-3"
                    >
                      {{ brand }}
                    </h4>
                  </b-col>
                </b-row>
              </div>

              <!-- Certificates -->
              <div class="w-100 custom-card px-5 pt-5 pb-3 certifications">
                <b-row>
                  <b-col lg="3" md="4">
                    <h2>Nos certifications:</h2>
                  </b-col>
                  <b-col lg="9" md="8">
                    <h4
                      v-for="(certificate, index) of company.certifications"
                      :key="'cert-' + index"
                      class="d-inline-block border-right px-3 mb-3"
                    >
                      {{ certificate }}
                    </h4>
                  </b-col>
                </b-row>
              </div>
            </b-container>
          </div>
        </b-tab>

        <b-tab>
          <template slot="title">
            <div class="d-block mb-1">
              <img
                src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_nav_promotion.png"
              />
            </div>
            Promotions
            <!-- <span class="items-count">{{ company.promotions.length }}</span> -->
          </template>
          <b-container class="pb-5">
            <b-row>
              <b-col
                v-for="(promotion, index) of company.promotions"
                :key="'promotion-' + index"
                lg="4"
                class="mb-4"
              >
                <b-link :href="'/annonce/' + promotion.slug">
                  <div class="promo-wrapper">
                    <img :src="promotion.cover_img" alt="Alt text here" />
                    <div class="overlay"></div>
                    <div class="title">{{ promotion.title }}</div>
                  </div>
                </b-link>
              </b-col>
            </b-row>
          </b-container>
        </b-tab>

        <b-tab>
          <template slot="title">
            <div class="d-block mb-1">
              <img
                src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_nav_job.png"
              />
            </div>
            Offres d'emploi
            <!-- <span class="items-count">{{ company.job_offers.length }}</span> -->
          </template>
          <b-container class="pb-5">
            <b-row>
              <b-col
                v-for="(offer, index) of company.job_offers"
                :key="'offer-' + index"
                lg="4"
                class="mb-4"
              >
                <b-link :href="'/annonce/' + offer.slug">
                  <div class="promo-wrapper">
                    <img :src="offer.cover_img" alt="Alt text here" />
                    <div class="overlay"></div>
                    <div class="title">{{ offer.job_title }}</div>
                  </div>
                </b-link>
              </b-col>
            </b-row>
          </b-container>
        </b-tab>

        <b-tab>
          <template slot="title">
            <div class="d-block mb-1">
              <img
                src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_nav_event.png"
              />
            </div>
            Événements
            <!-- <span class="items-count">{{ company.events.length }}</span> -->
          </template>
          <b-container class="pb-5">
            <b-row>
              <b-col
                v-for="(event, index) of company.events"
                :key="'event-' + index"
                lg="4"
                class="mb-4"
              >
                <b-link :href="'/annonce/' + event.slug">
                  <div class="promo-wrapper">
                    <img :src="event.cover_img" alt="Alt text here" />
                    <div class="overlay"></div>
                    <div class="title">{{ event.title }}</div>
                  </div>
                </b-link>
              </b-col>
            </b-row>
          </b-container>
        </b-tab>

        <template slot="tabs">
          <b-nav-item href="#contact">
            <div class="d-block mb-1">
              <img
                src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_nav_map.png"
              />
            </div>
            Map
          </b-nav-item>

          <b-nav-item href="#contact">
            <div class="d-block mb-1">
              <img
                src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_nav_service.png"
              />
            </div>
            Nos services
            <!-- <span class="items-count">{{ company.events.length }}</span> -->
          </b-nav-item>
        </template>
      </b-tabs>
    </b-container>

    <!-- Map, contact form -->
    <div id="contact" class="w-100 mt-5 profile-map position-relative">
      <WedoMap
        :lat="company.map_latitude"
        :lng="company.map_longitude"
        :icon="company.logo_img"
        height="700px"
        width="100%"
      ></WedoMap>
      <b-container>
        <ContactForm :company-name="company.company_name"></ContactForm>
      </b-container>
    </div>
  </div>
</template>

<script>
import WedoCarousel from '~/components/WedoCarousel.vue'
import WedoMap from '~/components/WedoMap.vue'
// import WedoInput from '~/components/WedoInput.vue'
// import WedoButton from '~/components/WedoButton.vue'
// import WedoSelect from '~/components/WedoSelect.vue'
// import WedoCheckbox from '~/components/WedoCheckbox.vue'
import ContactForm from '~/components/company-listing/ContactForm.vue'
import ContactCard from '~/components/company-listing/ContactCard.vue'
import Icon from 'vue-awesome/components/Icon'
import 'vue-awesome-material-icons/icons/backspace_outlined'
import 'vue-awesome-material-icons/icons/view_module'
import 'vue-awesome-material-icons/icons/map'
import 'vue-awesome-material-icons/icons/email'

export default {
  name: 'PaidCompany',
  components: {
    WedoCarousel,
    WedoMap,
    // WedoInput,
    // WedoButton,
    // WedoSelect,
    // WedoCheckbox,
    ContactForm,
    ContactCard,
    Icon
  },
  props: {
    company: {
      type: Object,
      default: function() {
        return {}
      }
    }
  },
  data() {
    return {
      tabIndex: 0,
      tabs: ['#profil', '#demander', '#promotions', '#offers', '#events'],
      languages: '',
      weekDays: [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday'
      ],
      weekDaysFr: [
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi',
        'dimanche'
      ],
      timeOptions: [
        { value: '08:00 - 09:00', text: '08:00 - 09:00' },
        { value: '09:00 - 10:00', text: '09:00 - 10:00' },
        { value: '10:00 - 11:00', text: '10:00 - 11:00' },
        { value: '11:00 - 12:00', text: '11:00 - 12:00' },
        { value: '12:00 - 13:00', text: '12:00 - 13:00' },
        { value: '13:00 - 14:00', text: '13:00 - 14:00' },
        { value: '14:00 - 15:00', text: '14:00 - 15:00' },
        { value: '15:00 - 16:00', text: '15:00 - 16:00' },
        { value: '16:00 - 17:00', text: '16:00 - 17:00' },
        { value: '17:00 - 18:00', text: '17:00 - 18:00' },
        { value: '18:00 - 19:00', text: '18:00 - 19:00' }
      ],
      paymentMethods: {
        bankTransfer: 'Virement bancaire',
        creditCard: 'Carte de crédit'
      }
    }
  },
  created() {
    this.tabIndex = this.tabs.findIndex(tab => tab === this.$route.hash)
    if (this.company) {
      console.log(this.company.services)
      this.company.set_of_images = JSON.parse(this.company.set_of_images)
      this.company.social_networks = JSON.parse(this.company.social_networks)
      this.company.brands = JSON.parse(this.company.brands)
      this.company.accepted_payment_methods = JSON.parse(
        this.company.accepted_payment_methods
      )
      this.company.spoken_languages = JSON.parse(this.company.spoken_languages)
      this.company.certifications = JSON.parse(this.company.certifications)
      this.company.facilities = JSON.parse(this.company.facilities)
      this.company.opening_hours = JSON.parse(this.company.opening_hours)
      let languages = ''
      this.company.spoken_languages.forEach((lang, index) => {
        if (index !== 0) languages += ', '
        languages += lang
      })
      this.languages = languages
    }
  }
}
</script>

<style>
@import 'assets/css/annonce.css';
</style>
