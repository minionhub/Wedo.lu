<template>
  <div id="company-category">
    <b-container>
      <p class="mb-4 total">
        <v-icon name="eye" class="mr-2"></v-icon>
        Wedo.lu a trouvé {{ totalRows }} entreprises pour Entrepreneur de
        construction et de génie civil
      </p>
      <div class="companies">
        <div
          v-for="listing in listings"
          :key="'listing-' + listing.data.listing_id"
          class="company"
        >
          <b-row>
            <b-col lg="8">
              <b-link :href="'/annonce/' + listing.data.slug">
                <div class="title mb-5">
                  <b-img class="logo" :src="listing.data.logo_img"></b-img>
                  <h2>{{ listing.data.title }}</h2>
                </div>
              </b-link>
              <h5 class="desc pb-1">
                {{ ellipse(listing.data.desc, 100) }}
              </h5>
              <hr class="my-4" />
              <div class="keywords mb-4">
                <h6
                  v-for="(service, index) of listing.data.services.slice(0, 3)"
                  :key="'service-' + index"
                >
                  <b-link :href="'/service/' + service.slug">{{
                    service.name
                  }}</b-link>
                </h6>
              </div>
            </b-col>
            <b-col lg="4" class="contacts mb-4">
              <p v-if="listing.data.houseNbr">
                <v-icon name="map-marker-alt" class="mr-2"></v-icon>
                {{ listing.data.houseNbr + ' ' + listing.data.city }}
              </p>
              <p v-if="listing.data.phone">
                <v-icon name="phone" class="mr-2"></v-icon>
                <b-link :href="'tel:' + listing.data.phone">
                  {{ listing.data.phone }}
                </b-link>
              </p>
              <p v-if="listing.data.contact_email">
                <v-icon name="envelope" class="mr-2"></v-icon>
                <b-link :href="'mailto:' + listing.data.contact_email">
                  {{ listing.data.contact_email }}
                </b-link>
              </p>
              <p v-if="listing.data.website_url">
                <v-icon name="globe" class="mr-2"></v-icon>
                <b-link :href="listing.data.website_url">
                  {{ listing.data.website_url }}
                </b-link>
              </p>
              <p v-if="listing.data.opening_hours" class="pl-0">
                <span
                  :class="
                    listing.data.opening_hours.isOpened
                      ? 'text-success'
                      : 'text-danger'
                  "
                >
                  {{ listing.data.opening_hours.stateString }}
                </span>
                <span v-if="listing.data.opening_hours.nextString">
                  {{ ', ' + listing.data.opening_hours.nextString }}
                </span>
              </p>
            </b-col>
          </b-row>
          <b-row class="gallery">
            <b-col md="10">
              <b-row>
                <b-col
                  v-for="(image, index) of listing.data.set_of_images"
                  :key="'image-' + index"
                  md="4"
                  class="img-wrapper"
                >
                  <img :src="image" alt="" />
                </b-col>
              </b-row>
            </b-col>
            <b-col md="2" class="company-link pt-4">
              <b-link :href="'/annonce/' + listing.data.slug">
                <div class="icon-wrapper mb-2">
                  <v-icon name="angle-right"></v-icon>
                </div>
                Voir plus
              </b-link>
            </b-col>
          </b-row>
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
    </b-container>
  </div>
</template>

<script>
import Icon from 'vue-awesome/components/Icon'
import 'vue-awesome/icons'

export default {
  components: {
    'v-icon': Icon
  },
  data() {
    return {
      currentPage: 1,
      totalRows: 100,
      perPage: 20,
      listings: [],
      weekDays: [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
      ],
      weekDaysFr: [
        'dimanche',
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi'
      ],
      labels: {
        open: 'Ouvre',
        close: 'Ferme',
        opened: 'Ouvert',
        closed: 'Fermé',
        tomorrow: 'demain',
        at: ' à ',
        byAppointment: 'Uniquement sur rendez-vous',
        openAllDay: 'Ouvert toute la journée'
      }
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    async init() {
      try {
        const response = (await this.$axios.$get(
          '/listing/service/' +
            this.$route.params.slug +
            '?page=' +
            this.currentPage
        )).listings
        this.totalRows = response.total
        this.perPage = response.per_page
        response.data.map(listing => {
          listing.data.set_of_images = JSON.parse(listing.data.set_of_images)
          if (listing.data.opening_hours) {
            listing.data.opening_hours = this.formatOpeningHours(
              JSON.parse(listing.data.opening_hours)
            )
          }
        })
        this.listings = response.data
      } catch (e) {
        return this.$nuxt.error({ statusCode: 404, message: e.message })
      }
    },
    onChangePage(page) {
      this.currentPage = page
      this.init()
    },
    formatOpeningHours(openingHours) {
      const now = new Date()
      const weekDay = now.getDay()
      const time = now.getHours()
      const data = openingHours[this.weekDays[weekDay]]
      let isOpened = false
      let stateString = this.labels.closed
      let nextString = ''
      switch (data.type) {
        case 0:
          let i = 0
          for (i = 0; i < data.intervals.length; i++) {
            if (
              time >= parseInt(data.intervals[i][0]) &&
              time <= parseInt(data.intervals[i][1])
            ) {
              isOpened = true
              stateString = this.labels.opened
              nextString =
                this.labels.close + this.labels.at + data.intervals[i][1]
              break
            }
          }
          if (isOpened) break
          if (i < data.intervals.length - 1) {
            nextString =
              this.labels.open + this.labels.at + data.intervals[i + 1][0]
          } else {
            nextString = this.formatNextString(openingHours, weekDay, isOpened)
          }
          break
        case 1:
          isOpened = true
          stateString = this.labels.openAllDay
          break
        case 2:
          isOpened = false
          stateString = this.labels.closed
          nextString = this.formatNextString(openingHours, weekDay, isOpened)
          break
        case 3:
          isOpened = true
          stateString = this.labels.byAppointment
          break
      }
      return {
        isOpened: isOpened,
        stateString: stateString,
        nextString: nextString
      }
    },
    formatNextString(openingHours, weekDay, isOpened) {
      let index = weekDay + 1
      while (index !== weekDay) {
        index = index % 7
        const weekDayStr =
          index === weekDay + 1
            ? this.labels.tomorrow
            : this.weekDaysFr[index].toLowerCase()
        const data = openingHours[this.weekDays[index]]
        switch (data.type) {
          case 0:
            return isOpened
              ? ''
              : this.labels.open +
                  ' ' +
                  weekDayStr +
                  this.labels.at +
                  data.intervals[0][0]
          case 1:
            if (isOpened) break
            else
              return (
                this.labels.open + ' ' + weekDayStr + this.labels.at + '00:00'
              )
          case 2:
            if (isOpened)
              return (
                this.labels.close + ' ' + weekDayStr + this.labels.at + '00:00'
              )
            else break
        }
        index++
      }
      return ''
    },
    ellipse(string, nLetters) {
      if (string.length <= nLetters) return string
      return string.substring(0, nLetters) + '...'
    }
  }
}
</script>

<style>
@import 'assets/css/company-category.css';
</style>
