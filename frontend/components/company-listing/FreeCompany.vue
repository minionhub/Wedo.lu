<template>
  <div id="annonce" class="free">
    <div class="w-100 bg-gray banner border-top border-bottom">
      <b-container>
        <b-row>
          <b-col lg="7">
            <h1 class="mb-5 d-block">
              <b-img :src="company.logo_img" class="mr-4" height="55px"></b-img>
              {{ company.company_name }}
            </h1>
            <div class="full-desc" v-html="company.full_description"></div>
          </b-col>
          <b-col lg="5">
            <b-link class="btn call-btn mr-1" :href="'tel:' + company.phone">
              <b-img
                class="mr-1"
                src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/company/phone.svg"
              ></b-img>
              Appeler
            </b-link>
            <b-link class="btn contact-btn mr-1">
              <b-img
                class="mr-1"
                src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/company/envelop.svg"
              ></b-img>
              Contacter
            </b-link>
            <b-link class="btn owner-btn" @click.prevent="onClickClaim">
              <b-img
                class="mr-1"
                src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/company/hand.svg"
              ></b-img>
              Proclamer
            </b-link>
          </b-col>
        </b-row>
      </b-container>
    </div>
    <b-container>
      <ContactCard
        class="mt-5"
        :street="company.street"
        :house-nbr="company.houseNbr"
        :contact-email="company.contact_email"
        :website-url="company.website_url"
        :fax="company.fax"
        :phone="company.phone"
      >
      </ContactCard>
    </b-container>
    <div class="w-100 profile-map mt-5 position-relative">
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
import WedoMap from '~/components/WedoMap.vue'
import ContactForm from '~/components/company-listing/ContactForm.vue'
import ContactCard from '~/components/company-listing/ContactCard.vue'

export default {
  name: 'FreeCompany',
  components: {
    WedoMap,
    ContactForm,
    ContactCard
  },
  props: {
    company: {
      type: Object,
      default: function() {
        return {}
      }
    }
  },
  methods: {
    onClickClaim() {
      if (!this.loggedIn) {
        this.$router.push({
          path: '/ajouter-votre-annonce'
        })
      } else {
        this.$router.push({
          path: '/claim-business',
          query: {
            listing_id: this.company.listing_id
          }
        })
      }
    }
  }
}
</script>

<style>
@import 'assets/css/annonce.css';

#annonce.free .banner {
  background-color: #f1f1f1;
  padding: 75px 0;
}
</style>
