<template>
  <div class="edit-company">
    <div v-if="success" class="row">
      <div class="col-lg-8 mx-auto success-msg mb-4">
        <span>Vos changements ont été sauvegardés. </span>
        <a :href="'/annonce/' + newCompany.slug">Voir →</a>
      </div>
    </div>
    <form @submit.prevent="submit">
      <!-- company name -->
      <WedoInput
        v-model="company.company_name"
        v-validate="{ required: true }"
        name="company_name"
        label="Nom de la société"
        :error="errors.first('company_name')"
      />
      <!-- categories -->
      <WedoMultiSelect
        v-model="categoriesSelected"
        :options="categories"
        title="Catégories (optionnel)"
        placeholder="Choisissez une catégorie"
      />
      <!-- services and keywords -->
      <WedoMultiSelect
        v-model="servicesSelected"
        :taggable="true"
        :options="services"
        title="Mots-clés pour vos activités et services (optionnel)"
      />
      <!-- short description -->
      <WedoInput
        v-model="company.short_desc"
        name="short_desc"
        label="Brève description de l'entreprise. (optionnel)"
      />
      <!-- full description -->
      <WedoTextarea
        v-model="company.full_description"
        v-validate="{ required: true }"
        name="full_description"
        label="Description de l'entreprise"
        :error="errors.first('full_description')"
      />
      <!-- street -->
      <WedoInput
        v-model="company.street"
        v-validate="{ required: true }"
        name="street"
        label="Votre rue"
        :error="errors.first('street')"
      />
      <!-- postal code -->
      <WedoInput
        v-model="company.zip_code"
        v-validate="{ required: true }"
        name="zip_code"
        label="Code postal & localité"
        :error="errors.first('zip_code')"
      />
      <!-- latitude and longitude -->
      <WedoMapEx v-model="position" />

      <h3 class="group-title">IMAGES</h3>
      <WedoImage
        v-model="company.logo_img"
        label="Logo"
        :has-error="!company.logo_img && isSubmitted"
      />
      <WedoImage v-model="company.cover_img" label="Arrière plan (optionnel)" />
      <WedoImageMultiple
        v-model="images"
        label="Images de la galerie (optionnel)"
      />

      <h3 class="group-title">INFORMATIONS DE CONTACT</h3>
      <!-- email -->
      <WedoInput
        v-model="company.contact_email"
        v-validate="{ required: true, email: true }"
        name="contact_email"
        label="Email"
        :error="errors.first('contact_email')"
      />
      <!-- phone number -->
      <WedoInput
        v-model="company.phone"
        name="phone"
        label="Téléphone (optionnel)"
      />
      <!-- company website url -->
      <WedoInput
        v-model="company.website_url"
        name="website_url"
        label="Site web (optionnel)"
      />
      <!-- fax -->
      <WedoInput v-model="company.fax" name="fax" label="Fax (optionnel)" />
      <!-- e-commerce -->
      <WedoInput
        v-model="company.e_commerce"
        name="e_commerce"
        label="E-Commerce (optionnel)"
      />
      <!-- social media -->
      <SocialMedia :input-data="socialMedia" />
      <!-- opening hours -->
      <OpeningHours class="mb-3" :input-data="openingHours" />
      <!-- timezone -->
      <WedoSelect
        v-model="company.timezone_id"
        :options="timezones"
        label="Fuseau horaire "
      />

      <h3 class="group-title">ADRESSE</h3>
      <!-- regions -->
      <WedoMultiSelect
        v-model="regionsSelected"
        :options="regions"
        title="Region (optionnel)"
        placeholder="Choisissez une region"
      />

      <h3 class="group-title">
        DÉTAILS D'INSCRIPTION INFORMATIONS ADMINISTRATIVES & FINANCIÈRES
      </h3>
      <WedoInput
        v-model="company.codeNace"
        name="codeNace"
        label="N° Nace (optionnel)"
      />
      <WedoInput
        v-model="company.commercialRegisterCode"
        name="commercialRegisterCode"
        label="N° Registre du Commerce (optionnel)"
      />
      <WedoInput
        v-model="company.internationalTVAnbr"
        name="internationalTVAnbr"
        label="N° TVA International (optionnel)"
      />
      <WedoInput
        v-model="company.nationalTVAnbr"
        name="nationalTVAnbr"
        label="N° TVA National (optionnel)"
      />
      <WedoInput
        v-model="company.revenue"
        name="revenue"
        label="Chiffre d'affaires (optionnel)"
      />
      <WedoInput
        v-model="company.shareCapital"
        name="shareCapital"
        label="Capital (optionnel)"
      />
      <WedoInput
        v-model="company.employeeNbr"
        name="employeeNbr"
        label="Nombre d'employés"
      />
      <WedoInput
        v-model="company.foundationDate"
        name="foundationDate"
        label="Date de fondation (optionnel)"
      />

      <h3 class="group-title">INFORMATIONS SUPPLÉMENTAIRES</h3>
      <WedoInput
        v-model="company.additionalDetails"
        name="additionalDetails"
        label="Détails (optionnel)"
      />
      <!-- brands and products -->
      <WedoMultiSelect
        v-model="brandsSelected"
        :taggable="true"
        :options="brands"
        title="Produits et marques (optionnel)"
      />
      <!-- Payment methods -->
      <WedoMultiSelect
        v-model="paymentMethodsSelected"
        :taggable="true"
        :options="paymentMethods"
        title="Modes de paiement acceptés (optionnel)"
      />
      <WedoMultiSelect
        v-model="languagesSelected"
        :taggable="true"
        :options="languages"
        title="Langues parlées (optionnel)"
      />
      <WedoMultiSelect
        v-model="certificatesSelected"
        :taggable="true"
        :options="certificates"
        title="Certifications (optionnel)"
      />
      <WedoMultiSelect
        v-model="facilitiesSelected"
        :taggable="true"
        :options="facilities"
        title="Facilités (optionnel)"
      />

      <!-- contact people -->
      <h3 class="group-title">PREMIÈRE PERSONNE DE CONTACT</h3>
      <WedoInput
        v-model="contactPeople[0].name"
        label="Nom et prénom (optionnel)"
      />
      <WedoInput
        v-model="contactPeople[0].position"
        label="Fonction (optionnel)"
      />
      <WedoInput
        v-model="contactPeople[0].phone"
        label="Numéro de tel (optionnel)"
      />

      <h3 class="group-title">DEUXIÈME PERSONNE DE CONTACT</h3>
      <WedoInput
        v-model="contactPeople[1].name"
        label="Nom et prénom (optionnel)"
      />
      <WedoInput
        v-model="contactPeople[1].position"
        label="Fonction (optionnel)"
      />
      <WedoInput
        v-model="contactPeople[1].phone"
        label="Numéro de tel (optionnel)"
      />

      <h3 class="group-title">TROISIÈME : PERSONNE DE CONTACT</h3>
      <WedoInput
        v-model="contactPeople[2].name"
        label="Nom et prénom (optionnel)"
      />
      <WedoInput
        v-model="contactPeople[2].position"
        label="Fonction (optionnel)"
      />
      <WedoInput
        v-model="contactPeople[2].phone"
        label="Numéro de tel (optionnel)"
      />

      <button
        type="submit"
        :disabled="errors.any()"
        class="save-btn btn btn-block mt-3"
      >
        Sauvegarder
      </button>
    </form>
  </div>
</template>

<script>
import OpeningHours from '~/components/edit-listing/OpeningHours.vue'
import SocialMedia from '~/components/edit-listing/SocialMedia.vue'
import WedoMapEx from '~/components/edit-listing/WedoMapEx.vue'
import WedoInput from '~/components/WedoInput.vue'
import WedoTextarea from '~/components/WedoTextarea.vue'
import WedoMultiSelect from '~/components/WedoMultiSelect.vue'
import WedoSelect from '~/components/WedoSelect.vue'
import WedoImage from '~/components/WedoImage.vue'
import WedoImageMultiple from '~/components/WedoImageMultiple.vue'

export default {
  middleware: 'auth',
  components: {
    OpeningHours,
    SocialMedia,
    WedoMapEx,
    WedoInput,
    WedoMultiSelect,
    WedoSelect,
    WedoTextarea,
    WedoImage,
    WedoImageMultiple
  },
  data() {
    return {
      timezones: [],
      company: {},
      categoriesSelected: [],
      categories: [],
      servicesSelected: [],
      services: [],
      images: [],
      regionsSelected: [],
      regions: [],
      brands: [],
      brandsSelected: [],
      paymentMethods: [],
      paymentMethodsSelected: [],
      languages: [],
      languagesSelected: [],
      certificates: [],
      certificatesSelected: [],
      facilities: [],
      facilitiesSelected: [],
      contactPeople: [
        { name: '', position: '', phone: '' },
        { name: '', position: '', phone: '' },
        { name: '', position: '', phone: '' }
      ],

      position: {
        lat: 49.5071099,
        lng: 6.2838762,
        street_number: '',
        route: '',
        locality: '',
        administrative_area_level_1: '',
        country: '',
        postal_code: ''
      },
      openingHours: {
        Monday: { type: 0, intervals: [] },
        Tuesday: { type: 0, intervals: [] },
        Wednesday: { type: 0, intervals: [] },
        Thursday: { type: 0, intervals: [] },
        Friday: { type: 0, intervals: [] },
        Saturday: { type: 2, intervals: [] },
        Sunday: { type: 2, intervals: [] }
      },
      socialMedia: [],
      success: false,
      newCompany: {},
      hasLogo: false,
      isSubmitted: false
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    async init() {
      if (this.id !== 0) {
        try {
          // company information
          this.company = (await this.$axios.$get(
            '/company/id/' + this.$route.query.id
          )).company
          this.position = {
            lat: this.company.map_latitude,
            lng: this.company.map_longitude,
            street_number: this.company.houseNbr,
            route: this.company.street,
            locality: this.company.city,
            administrative_area_level_1: '',
            country: '',
            postal_code: this.company.zip_code
          }
          // company gallery images
          this.images = JSON.parse(this.company.set_of_images)

          // timezone options for multi-select
          const timezones = (await this.$axios.$get('/timezone')).data
          timezones.forEach(timezone => {
            this.timezones.push({ value: timezone.id, text: timezone.name })
          })

          // service options for multi-select tag input
          const services = (await this.$axios.$get('/service')).data
          services.forEach(service => {
            this.services.push({ value: service.id, text: service.name })
          })
          this.company.services.forEach(service => {
            this.servicesSelected.push({
              value: service.id,
              text: service.name
            })
          })

          // category options for multi-select
          const cats = (await this.$axios.$get('/category/list')).data
          cats.forEach(cat => {
            this.categories.push({
              value: cat.id,
              text: '— '.repeat(cat.depth) + cat.name
            })

            this.company.categories.forEach(catCompany => {
              if (catCompany.id === cat.id)
                this.categoriesSelected.push({
                  value: cat.id,
                  text: '— '.repeat(cat.depth) + cat.name
                })
            })
          })

          // region options for region multi-select
          const regions = (await this.$axios.$get('/region')).data
          const companyRegionIds = JSON.parse(this.company.region)
          regions.forEach(region => {
            this.regions.push({ value: region.region_id, text: region.name })
            companyRegionIds.forEach(regionId => {
              if (regionId === region.region_id)
                this.regionsSelected.push({
                  value: region.region_id,
                  text: region.name
                })
            })
          })

          // brands
          const brands = JSON.parse(this.company.brands)
          brands.forEach(brand => {
            this.brands.push({ value: brand, text: brand })
            this.brandsSelected.push({ value: brand, text: brand })
          })

          // payment methods
          const paymentMethods = JSON.parse(
            this.company.accepted_payment_methods
          )
          paymentMethods.forEach(method => {
            this.paymentMethods.push({ value: method, text: method })
            this.paymentMethodsSelected.push({ value: method, text: method })
          })

          const languages = JSON.parse(this.company.spoken_languages)
          languages.forEach(language => {
            this.languages.push({ value: language, text: language })
            this.languagesSelected.push({ value: language, text: language })
          })

          const certificates = JSON.parse(this.company.certifications)
          certificates.forEach(certificate => {
            this.certificates.push({ value: certificate, text: certificate })
            this.certificatesSelected.push({
              value: certificate,
              text: certificate
            })
          })

          const facilities = JSON.parse(this.company.facilities)
          facilities.forEach(facility => {
            this.facilities.push({ value: facility, text: facility })
            this.facilitiesSelected.push({ value: facility, text: facility })
          })

          this.company.contact_people.forEach((person, index) => {
            this.contactPeople[index] = person
          })

          this.openingHours = JSON.parse(this.company.opening_hours)
          this.socialMedia = JSON.parse(this.company.social_networks)
        } catch (e) {}
      }
    },
    submit() {
      this.isSubmitted = true

      this.$validator.validateAll().then(async () => {
        if (
          this.company.logo_img === null ||
          typeof this.company.logo_img === 'undefined'
        ) {
          this.hasLogo = false
          return
        }
        if (!this.errors.any()) {
          try {
            const company = {
              listing_id: this.company.listing_id,
              logo_img: await (async () => {
                if (!this.company.logo_img.startsWith('data:'))
                  return this.company.logo_img
                const response = await this.$axios.$post('image', {
                  image: this.company.logo_img
                })
                return response.url
              })(),
              cover_img: await (async () => {
                if (typeof this.company.cover_img === 'undefined') return null
                if (!this.company.cover_img.startsWith('data:'))
                  return this.company.cover_img
                const response = await this.$axios.$post('image', {
                  image: this.company.cover_img
                })
                return response.url
              })(),
              full_description: this.company.full_description,
              contact_email: this.company.contact_email,
              region: (() => {
                const regions = []
                this.regionsSelected.forEach(region => {
                  regions.push(region.value)
                })
                return JSON.stringify(regions)
              })(),
              company_name: this.company.company_name,
              short_desc: this.company.short_desc,
              street: this.company.street,
              houseNbr: this.position.street_number,
              zip_code: this.company.zip_code,
              city: this.position.locality,
              map_longitude: this.position.lng,
              map_latitude: this.position.lat,
              set_of_images: await (async () => {
                const images = []
                for (let i = 0; i < this.images.length; i++) {
                  if (!this.images[i].startsWith('data:'))
                    images.push(this.images[i])
                  else {
                    const response = await this.$axios.$post('image', {
                      image: this.images[i]
                    })
                    images.push(response.url)
                  }
                }
                return JSON.stringify(images)
              })(),
              phone: this.company.phone,
              website_url: this.company.website_url,
              fax: this.company.fax,
              e_commerce: this.company.e_commerce,
              social_networks: JSON.stringify(this.socialMedia),
              codeNace: this.company.codeNace,
              commercialRegisterCode: this.company.commercialRegisterCode,
              internationalTVAnbr: this.company.internationalTVAnbr,
              nationalTVAnbr: this.company.nationalTVAnbr,
              revenue: this.company.revenue,
              shareCapital: this.company.shareCapital,
              employeeNbr: this.company.employeeNbr,
              foundationDate: this.company.foundationDate,
              additionalDetails: this.company.additionalDetails,
              brands: (() => {
                const brands = []
                this.brands.forEach(brand => {
                  brands.push(brand.text)
                })
                return JSON.stringify(brands)
              })(),
              opening_hours: JSON.stringify(this.openingHours),
              accepted_payment_methods: (() => {
                const paymentMethods = []
                this.paymentMethodsSelected.forEach(method => {
                  paymentMethods.push(method.text)
                })
                return JSON.stringify(paymentMethods)
              })(),
              spoken_languages: (() => {
                const languages = []
                this.languagesSelected.forEach(lang => {
                  languages.push(lang.text)
                })
                return JSON.stringify(languages)
              })(),
              certifications: (() => {
                const certificates = []
                this.certificatesSelected.forEach(cert => {
                  certificates.push(cert.text)
                })
                return JSON.stringify(certificates)
              })(),
              facilities: (() => {
                const facilities = []
                this.facilitiesSelected.forEach(item => {
                  facilities.push(item.text)
                })
                return JSON.stringify(facilities)
              })(),
              timezone_id: this.company.timezone_id,
              user_id: this.user.id
            }

            const services = []
            this.servicesSelected.forEach(service => {
              services.push({ id: service.value, name: service.text })
            })

            const categories = []
            this.categoriesSelected.forEach(cat => {
              categories.push(cat.value)
            })
            const response = await this.$axios.$put(
              'company/' + company.listing_id,
              {
                company: company,
                services: services,
                categories: categories,
                people: this.contactPeople
              }
            )
            if (response.status === 'success') {
              this.success = true
              this.newCompany = response.company
              document.documentElement.scrollTop = 0
            }
          } catch (e) {}
        }
      })
    }
  }
}
</script>

<style>
@import 'assets/css/edit-listing/company.css';
</style>
