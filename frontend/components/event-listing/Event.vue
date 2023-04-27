<template>
  <div id="annonce" class="paid event">
    <div class="banner">
      <b-img :src="event.cover_img"></b-img>

      <!-- Banner Card -->
      <b-container>
        <div class="card">
          <figure class="mb-4 logo">
            <b-img :src="event.company.logo_img"></b-img>
          </figure>

          <h1 class="mb-5">{{ event.title }}</h1>
          <h2>{{ ellipse(event.full_description, 60) }}</h2>

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
      <b-tab class="demand" href="#event" title="Évènement">
        <b-container>
          <b-row class="pb-5">
            <b-col md="6">
              <div class="custom-card p-3 mb-4">
                <h5>
                  <Icon scale="1" name="view_headline" class="mr-1" />
                  Description
                </h5>
                <p>
                  {{ event.full_description }}
                </p>
              </div>

              <div class="w-100 custom-card p-3">
                <h5>
                  <Icon scale="1" name="map" class="mr-1" />
                  Lieu
                  <b-link
                    class="float-right"
                    :href="
                      'http://maps.google.com/maps?daddr=' +
                        event.map_latitude +
                        ',' +
                        event.map_longitude
                    "
                    >S'y Rendre</b-link
                  >
                </h5>
                <div class="w-100 pt-2">
                  <WedoMap
                    :lat="event.map_latitude"
                    :lng="event.map_longitude"
                    :icon="event.logo_img"
                    height="350px"
                  ></WedoMap>
                </div>
              </div>

              <div class="custom-card p-3 down-counter">
                <h5 class="text-white">
                  <Icon scale="1" name="av_timer" class="mr-1" />
                  L'événement commence dans
                </h5>
                <div class="pt-3">
                  <b-row>
                    <b-col cols="4" class="label">
                      <div class="d-flex align-items-center">
                        <div class="figure text-center mr-2">
                          {{ counter.days }}
                        </div>
                        JOURS
                      </div>
                    </b-col>
                    <b-col cols="4" class="label">
                      <div class="d-flex align-items-center">
                        <div class="figure text-center mr-2">
                          {{ counter.hours }}
                        </div>
                        HEURES
                      </div>
                    </b-col>
                    <b-col cols="4" class="label">
                      <div class="d-flex align-items-center">
                        <div class="figure text-center mr-2">
                          {{ counter.minutes }}
                        </div>
                        MINUTES
                      </div>
                    </b-col>
                  </b-row>
                </div>
              </div>
            </b-col>
            <b-col md="6">
              <div class="custom-card p-3 mb-4">
                <h5>
                  <Icon scale="1" name="layers" class="mr-1" />
                  Organisé par
                </h5>
                <p class="d-flex align-items-center mb-0 pt-2">
                  <b-link :href="'/annonce/' + event.company.slug">
                    <img
                      :src="event.company.logo_img"
                      class="mr-2 object-fit-cover object-position-center rounded-circle"
                      width="30px"
                      height="30px"
                      alt=""
                    />
                    {{ event.company.company_name }}
                  </b-link>
                </p>
              </div>

              <div class="w-100 custom-card p-3">
                <h5>
                  <Icon scale="1" name="insert_photo" class="mr-1" />
                  Bloc de galerie
                </h5>
                <div class="w-100 pt-2">
                  <WedoCarousel
                    :images="
                      typeof event.set_of_images === 'string'
                        ? JSON.parse(event.set_of_images)
                        : event.set_of_images
                    "
                  ></WedoCarousel>
                </div>
              </div>

              <div class="w-100 custom-card p-3">
                <h5>
                  <Icon scale="1" name="view_module" class="mr-1" />
                  Mots-clés
                </h5>
                <div class="w-100 pt-2">
                  <b-row class="service-list">
                    <b-col
                      v-for="service of event.services"
                      :key="'service-' + service.id"
                      cols="6"
                      class="pb-2"
                    >
                      <b-link :href="'/service/' + service.slug">
                        <div class="outlined mr-3">
                          <Icon scale="1" name="bookmark" />
                        </div>

                        <div class="d-inline-flex">{{ service.name }}</div>
                      </b-link>
                    </b-col>
                  </b-row>
                </div>
              </div>
            </b-col>
          </b-row>
        </b-container>
      </b-tab>
      <b-tab
        class="demand"
        href="#participate"
        title="Participer à cet événement"
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
              <div class="w-100 custom-card p-3">
                <h5>
                  <Icon scale="1" name="map" class="mr-1" />
                  Lieu
                  <b-link
                    class="float-right"
                    :href="
                      'http://maps.google.com/maps?daddr=' +
                        event.map_latitude +
                        ',' +
                        event.map_longitude
                    "
                    >S'y Rendre</b-link
                  >
                </h5>
                <div class="w-100 pt-2">
                  <WedoMap
                    :lat="event.map_latitude"
                    :lng="event.map_longitude"
                    :icon="event.logo_img"
                    height="350px"
                  ></WedoMap>
                </div>
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
import WedoMap from '~/components/WedoMap.vue'
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
  name: 'Event',
  components: {
    WedoCarousel,
    WedoMap,
    WedoInput,
    WedoButton,
    WedoCheckbox,
    WedoTextarea,
    Icon
  },
  props: {
    event: {
      type: Object,
      default: function() {
        return {}
      }
    }
  },
  data() {
    return {
      tabIndex: 0,
      tabs: ['#event', '#participate'],
      counter: {
        days: 0,
        hours: 0,
        minutes: 0
      }
    }
  },
  created() {
    this.tabIndex = this.tabs.findIndex(tab => tab === this.$route.hash)
    this.event.date_and_time = '2019-06-27 23:16:24'
    this.initDateCounter()
    setInterval(this.initDateCounter, 1000 * 60)
  },
  methods: {
    ellipse(string, nLetters) {
      return string.substring(0, nLetters) + '...'
    },
    initDateCounter(date) {
      const now = Date.parse(new Date())
      const eventTime = Date.parse(this.event.date_and_time)
      const interval = eventTime - now
      if (interval > 0) {
        const minutes = Math.floor(interval / (1000 * 60))
        const hours = Math.floor(minutes / 60)
        const days = Math.floor(hours / 24)
        this.counter.minutes = minutes % 60
        this.counter.hours = hours % 24
        this.counter.days = days
      }
    }
  }
}
</script>

<style>
@import 'assets/css/annonce.css';
</style>
