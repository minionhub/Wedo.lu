<template>
  <div id="annonce" class="paid">
    <div class="banner">
      <b-img class="cover" :src="company.cover_img"></b-img>

      <b-container>
        <b-row>
          <b-col class="logo-wrapper">
            <b-img :src="company.logo_img" class="logo"></b-img>
          </b-col>
        </b-row>
        <b-row>
          <b-col md="6">
            <h1 class="pt-3 pb-2 m-0">{{ company.company_name }}</h1>
            <h2 class="py-3 m-0">{{ company.short_desc }}</h2>
          </b-col>
          <b-col md="6" class="share">
            <div class="text-right share-btn-group">
              <b-link class="btn call-btn mr-2" :href="'tel:' + company.phone">
                <b-img
                  class="mr-3"
                  src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/company/phone.svg"
                ></b-img>
                Appeler
              </b-link>
              <b-link href="#contact" class="btn contact-btn">
                <b-img
                  class="mr-3"
                  src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/company/envelop.svg"
                ></b-img>
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

          <div class="w-100 mb-4 bg-white custom-collapse">
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
            <b-collapse id="company-desc" visible>
              <div class="px-4 py-3">
                {{ company.full_description }}
              </div>
            </b-collapse>
          </div>

          <b-row>
            <b-col lg="6">
              <div class="w-100 mb-4 bg-white custom-collapse">
                <div
                  v-b-toggle.company-hours
                  class="collapse-toggle w-100 px-4 py-2 d-flex align-items-center"
                >
                  <img
                    class="pr-3"
                    src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_time.png"
                  />
                  Heures d'ouverture de {{ company.company_name }}
                </div>
                <b-collapse id="company-hours" visible>
                  <div class="px-4 py-3">
                    <div
                      v-for="(weekDay, index) of weekDays"
                      :key="'hourw-' + index"
                      class="hours-wrapper"
                    >
                      <b-row>
                        <b-col cols="3" class="text-capitalize week-day">
                          {{ weekDaysFr[index] }}
                        </b-col>
                        <b-col
                          v-if="company.opening_hours[weekDay].type == 0"
                          cols="9"
                          class="hours text-right"
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
                          class="hours text-right"
                        >
                          <span class="hour px-2">
                            Ouvert toute la journée
                          </span>
                        </b-col>
                        <b-col
                          v-else-if="company.opening_hours[weekDay].type == 2"
                          cols="9"
                          class="hours text-right"
                        >
                          <span class="hour px-2">
                            Fermé toute la journée
                          </span>
                        </b-col>
                        <b-col
                          v-else-if="company.opening_hours[weekDay].type == 3"
                          cols="9"
                          class="hours text-right"
                        >
                          <span class="hour px-2">
                            Uniquement sur rendez-vous
                          </span>
                        </b-col>
                      </b-row>
                    </div>
                  </div>
                </b-collapse>
              </div>
            </b-col>

            <b-col lg="6">
              <div class="w-100 mb-4 bg-white custom-collapse">
                <div
                  v-b-toggle.company-images
                  class="collapse-toggle w-100 px-4 py-2 d-flex align-items-center"
                >
                  <img
                    class="pr-3"
                    src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_gallery.png"
                  />
                  Galerie de {{ company.company_name }}
                </div>
                <b-collapse id="company-images" visible>
                  <div>
                    <WedoCarousel
                      :images="
                        typeof company.set_of_images === 'string'
                          ? JSON.parse(company.set_of_images)
                          : company.set_of_images
                      "
                    ></WedoCarousel>
                  </div>
                </b-collapse>
              </div>
            </b-col>
          </b-row>

          <div class="w-100 mb-4 bg-white custom-collapse">
            <div
              v-b-toggle.company-people
              class="collapse-toggle w-100 px-4 py-2 d-flex align-items-center"
            >
              <img
                class="pr-3"
                src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_contact.png"
              />
              Personnes de contact chez {{ company.company_name }}
            </div>
            <b-collapse id="company-people" visible>
              <div class="px-4 py-3">
                <div
                  v-for="agent in company.contact_people"
                  :key="'agent-' + agent.id"
                  class="person text-center mr-3"
                >
                  <div class="py-2 px-3">
                    <p class="person-name mt-3">
                      {{ agent.name }}
                    </p>
                    <p class="person-position">
                      {{ agent.position }}
                    </p>
                  </div>
                  <div class="person-phone">
                    <img
                      class="mr-2"
                      src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_btn_call.png"
                    />
                    <b-link :href="'tel:' + agent.phone">
                      {{ agent.phone }}
                    </b-link>
                  </div>
                </div>
              </div>
            </b-collapse>
          </div>

          <div class="w-100 mb-4 bg-white custom-collapse">
            <div
              v-b-toggle.company-other
              class="collapse-toggle w-100 px-4 py-2 d-flex align-items-center"
            >
              <img
                class="pr-3"
                src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_description.png"
              />
              Informations générales sur {{ company.company_name }}
            </div>
            <b-collapse id="company-other" visible>
              <div class="px-4 py-3">
                <b-row>
                  <b-col lg="4" class="info-item-wrapper">
                    <div class="info-item">
                      <div class="info-head p-3">Nous parlons</div>
                      <div class="info-body px-3">
                        <p
                          v-for="(lang, index) of company.spoken_languages"
                          :key="'lang-' + index"
                          class="info-sub-item m-0 py-3"
                        >
                          <Icon scale="1" name="check" class="mr-1" />
                          {{ lang }}
                        </p>
                      </div>
                    </div>
                  </b-col>

                  <b-col lg="4" class="info-item-wrapper">
                    <div class="info-item">
                      <div class="info-head p-3">Facilités</div>
                      <div class="info-body px-3">
                        <p
                          v-for="(facility, index) of company.facilities"
                          :key="'facility' + index"
                          class="info-sub-item m-0 py-3"
                        >
                          <Icon scale="1" name="check" class="mr-1" />
                          {{ facility }}
                        </p>
                      </div>
                    </div>
                  </b-col>

                  <b-col lg="4" class="info-item-wrapper">
                    <div class="info-item">
                      <div class="info-head p-3">
                        Modes de paiement acceptés
                      </div>
                      <div class="info-body px-3">
                        <p
                          v-for="(method,
                          index) of company.accepted_payment_methods"
                          :key="'method' + index"
                          class="info-sub-item m-0 py-3"
                        >
                          <Icon scale="1" name="check" class="mr-1" />
                          {{ paymentMethods[method] }}
                        </p>
                      </div>
                    </div>
                  </b-col>
                </b-row>
              </div>
            </b-collapse>
          </div>

          <div class="w-100 mb-4 bg-white custom-collapse">
            <div
              v-b-toggle.company-finance
              class="collapse-toggle w-100 px-4 py-2 d-flex align-items-center"
            >
              <img
                class="pr-3"
                src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_description.png"
              />
              Plus d'informations sur {{ company.company_name }}
            </div>
            <b-collapse id="company-finance" visible>
              <div class="px-4 py-3">
                <b-row>
                  <b-col lg="4" class="info-item-wrapper">
                    <div class="info-item">
                      <div class="info-head p-3">
                        Informations administratives et financières
                      </div>
                      <div class="info-body px-3">
                        <div
                          class="info-sub-item m-0 py-3 d-flex justify-content-space-between"
                        >
                          <p>N° Nace</p>
                          <p class="text-right">
                            {{ company.codeNace }}
                          </p>
                        </div>
                        <div
                          class="info-sub-item m-0 py-3 d-flex justify-content-space-between"
                        >
                          <p>N° Registre du Commerce</p>
                          <p class="text-right">
                            {{ company.commercialRegisterCode }}
                          </p>
                        </div>
                        <div
                          class="info-sub-item m-0 py-3 d-flex justify-content-space-between"
                        >
                          <p>N° TVA International</p>
                          <p class="text-right">
                            {{ company.internationalTVAnbr }}
                          </p>
                        </div>
                        <div
                          class="info-sub-item m-0 py-3 d-flex justify-content-space-between"
                        >
                          <p>N° TVA National</p>
                          <p class="text-right">
                            {{ company.nationalTVAnbr }}
                          </p>
                        </div>
                        <div
                          class="info-sub-item m-0 py-3 d-flex justify-content-space-between"
                        >
                          <p>Capital</p>
                          <p class="text-right">
                            {{ company.shareCapital }}
                          </p>
                        </div>
                        <div
                          class="info-sub-item m-0 py-3 d-flex justify-content-space-between"
                        >
                          <p>Nombre de salariés</p>
                          <p class="text-right">
                            {{ company.employeeNbr }}
                          </p>
                        </div>
                        <div
                          class="info-sub-item m-0 py-3 d-flex justify-content-space-between"
                        >
                          <p>Date de fondation</p>
                          <p class="text-right">
                            {{ company.foundationDate }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </b-col>

                  <b-col lg="4" class="info-item-wrapper">
                    <div class="info-item">
                      <div class="info-head p-3">Nos activités et services</div>
                      <div class="info-body px-3 services-wrapper">
                        <div class="services">
                          <p
                            v-for="(service, index) of company.services"
                            :key="'service-' + index"
                            class="info-sub-item m-0 py-3"
                          >
                            <b-link :href="'/service/' + service.slug">
                              {{ service.name }}
                            </b-link>
                          </p>
                        </div>
                      </div>
                    </div>
                  </b-col>
                </b-row>
              </div>
            </b-collapse>
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
          <div class="pb-5">
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
            <div
              v-if="company.promotions.length <= 0"
              class="text-center no-result"
            >
              <div class="w-100 text-center mb-3">
                <Icon scale="3" name="frown-open" />
              </div>
              <p>Oups, aucun résultat trouvé pour votre recherche.</p>
            </div>
          </div>
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
          <div class="pb-5">
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
            <div
              v-if="company.job_offers.length <= 0"
              class="text-center no-result"
            >
              <div class="w-100 text-center mb-3">
                <Icon scale="3" name="frown-open" />
              </div>
              <p>Oups, aucun résultat trouvé pour votre recherche.</p>
            </div>
          </div>
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
          <div class="pb-5">
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
            <div
              v-if="company.events.length <= 0"
              class="text-center no-result"
            >
              <div class="w-100 text-center mb-3">
                <Icon scale="3" name="frown-open" />
              </div>
              <p>Oups, aucun résultat trouvé pour votre recherche.</p>
            </div>
          </div>
        </b-tab>

        <template slot="tabs">
          <b-nav-item
            id="map-spy"
            href="#contact"
            @click="onClickTabNav('map-spy')"
          >
            <div class="d-block mb-1">
              <img
                src="https://wedo.lu/wp-content/themes/Wedo-lystings/assets/images/ico_nav_map.png"
              />
            </div>
            Map
          </b-nav-item>

          <b-nav-item
            id="service-spy"
            href="#company-finance"
            @click="onClickTabNav('service-spy')"
          >
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
    <div id="contact" class="w-100 profile-map position-relative">
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
// import ContactCard from '~/components/company-listing/ContactCard.vue'
import Icon from 'vue-awesome/components/Icon'
import 'vue-awesome/icons'

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
    // ContactCard,
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
  },
  updated() {
    this.onClickTabNav()
  },
  methods: {
    onClickTabNav(id) {
      if (process.client) {
        const tabLinks = document.querySelectorAll(
          '.nav-wrapper .nav-item a.nav-link'
        )
        const $this = this
        tabLinks.forEach(tabLink => {
          tabLink.addEventListener('click', e => {
            if (e.currentTarget.parentNode.id === 'service-spy') {
              $this.tabIndex = 0
            }
            tabLinks.forEach(link => {
              link.classList.remove('active')
            })
            e.currentTarget.classList.add('active')
          })
        })
      }
    }
  }
}
</script>

<style>
@import 'assets/css/annonce.css';
</style>
