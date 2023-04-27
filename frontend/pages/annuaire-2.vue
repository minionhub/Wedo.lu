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
          v-for="company in companies"
          :key="'company' + company.listing_id"
          class="company"
        >
          <b-row>
            <b-col lg="8">
              <b-link :href="'/annonce/' + company.slug">
                <div class="title mb-5">
                  <b-img class="logo" :src="company.logo_img"></b-img>
                  <h2>{{ company.company_name }}</h2>
                </div>
              </b-link>
              <h5 class="desc pb-1">
                {{ company.short_desc }}
              </h5>
              <hr class="my-4" />
              <div class="keywords mb-4">
                <h6
                  v-for="(service, index) of company.services.slice(0, 3)"
                  :key="'service-' + index"
                >
                  <b-link :href="'/service/' + service.slug">{{
                    service.name
                  }}</b-link>
                </h6>
              </div>
            </b-col>
            <b-col lg="4" class="contacts mb-4">
              <p>
                <v-icon name="map-marker-alt" class="mr-2"></v-icon>
                {{ company.houseNbr + ' ' + company.city }}
              </p>
              <p>
                <v-icon name="phone" class="mr-2"></v-icon>
                <b-link :href="'tel:' + company.phone">
                  {{ company.phone }}
                </b-link>
              </p>
              <p>
                <v-icon name="envelope" class="mr-2"></v-icon>
                <b-link :href="'mailto:' + company.contact_email">
                  {{ company.contact_email }}
                </b-link>
              </p>
              <p>
                <v-icon name="globe" class="mr-2"></v-icon>
                <b-link :href="company.website_url">
                  {{ company.website_url }}
                </b-link>
              </p>
              <p class="pl-0">
                <span
                  :class="
                    company.opening_hours.isOpened
                      ? 'text-success'
                      : 'text-danger'
                  "
                >
                  {{ company.opening_hours.stateString }}
                </span>
                <span v-if="company.opening_hours.nextString">
                  {{ ', ' + company.opening_hours.nextString }}
                </span>
              </p>
            </b-col>
          </b-row>
          <b-row class="gallery">
            <b-col md="10">
              <b-row>
                <b-col
                  v-for="(image, index) of company.set_of_images"
                  :key="'image-' + index"
                  md="4"
                  class="img-wrapper"
                >
                  <img :src="image" alt="" />
                </b-col>
              </b-row>
            </b-col>
            <b-col md="2" class="company-link pt-4">
              <b-link :href="'/annonce/' + company.slug">
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
  validate({ query }) {
    return query.search_keywords
  },
  components: {
    'v-icon': Icon
  },
  data() {
    return {
      currentPage: 1,
      totalRows: 100,
      perPage: 20,
      companies: [],
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
  watch: {
    '$route.query.search_keywords': function() {
      this.init()
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    async init() {
      // try {
      const response = (await this.$axios.$post(
        '/search/company?page=' + this.currentPage,
        {
          query: this.$route.query.search_keywords
        }
      )).hits
      console.log(response)
      this.totalRows = response.total
      this.perPage = response.per_page
      Object.values(response.data).map(company => {
        company.set_of_images = JSON.parse(company.set_of_images)
        company.opening_hours = this.formatOpeningHours(
          JSON.parse(company.opening_hours)
        )
      })
      this.companies = response.data
      // } catch (e) {
      // return this.$nuxt.error({ statusCode: 404, message: e.message })
      // }
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
    }
  }
}
</script>

<style>
@import 'assets/css/company-category.css';
</style>
