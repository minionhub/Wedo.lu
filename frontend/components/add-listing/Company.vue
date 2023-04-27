<template>
  <div class="edit-company">
    <div v-if="success" class="row">
      <div class="col-lg-8 mx-auto success-msg mb-4">
        <span>Vos changements ont été sauvegardés. </span>
        <a :href="'/annonce/' + newCompany.slug">Voir →</a>
      </div>
    </div>
    <form @submit.prevent="submit">
      <div class="card p-3">
        <div class="w-100">
          <div class="head d-flex align-items-center">
            <div class="icon-wrapper mr-3">
              <v-icon name="pencil-alt"></v-icon>
            </div>
            Ajouter une fiche
          </div>
          <div class="body">
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
          </div>
        </div>
      </div>

      <div class="card p-3">
        <div class="w-100">
          <div class="head d-flex align-items-center">
            <div class="icon-wrapper mr-3">
              <v-icon name="camera"></v-icon>
            </div>
            Images
          </div>
          <div class="body">
            <WedoImage
              v-model="company.logo_img"
              label="Logo"
              :has-error="!company.logo_img && isSubmitted"
            />

            <WedoImage
              v-model="company.cover_img"
              label="Arrière plan (optionnel)"
            />
            <WedoImageMultiple
              v-model="images"
              label="Images de la galerie (optionnel)"
            />
          </div>
        </div>
      </div>

      <div class="card p-3">
        <div class="w-100">
          <div class="head d-flex align-items-center">
            <div class="icon-wrapper mr-3">
              <v-icon name="phone"></v-icon>
            </div>
            Informations de contact
          </div>
          <div class="body">
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
            <WedoInput
              v-model="company.fax"
              name="fax"
              label="Fax (optionnel)"
            />
            <!-- e-commerce -->
            <WedoInput
              v-model="company.e_commerce"
              name="e_commerce"
              label="E-Commerce (optionnel)"
            />
          </div>
        </div>
      </div>

      <div class="card p-3">
        <div class="w-100">
          <div class="head d-flex align-items-center">
            <div class="icon-wrapper mr-3">
              <v-icon name="share"></v-icon>
            </div>
            Réseaux sociaux
          </div>
          <div class="body">
            <!-- social media -->
            <SocialMedia :input-data="socialMedia" />
          </div>
        </div>
      </div>

      <div class="card p-3">
        <div class="w-100">
          <div class="head d-flex align-items-center">
            <div class="icon-wrapper mr-3">
              <v-icon name="calendar"></v-icon>
            </div>
            Heures d'ouverture
          </div>
          <div class="body">
            <!-- opening hours -->
            <OpeningHours class="mb-3" :input-data="openingHours" />
            <!-- timezone -->
            <WedoSelect
              v-model="company.timezone_id"
              :options="timezones"
              label="Fuseau horaire "
            />
          </div>
        </div>
      </div>

      <div class="card p-3">
        <div class="w-100">
          <div class="head d-flex align-items-center">
            <div class="icon-wrapper mr-3">
              <v-icon name="map-marker"></v-icon>
            </div>
            Adresse
          </div>
          <div class="body">
            <!-- regions -->
            <WedoMultiSelect
              v-model="regionsSelected"
              :options="regions"
              title="Region (optionnel)"
              placeholder="Choisissez une region"
            />
          </div>
        </div>
      </div>

      <div class="card p-3">
        <div class="w-100">
          <div class="head d-flex align-items-center">
            <div class="icon-wrapper mr-3">
              <v-icon name="pencil-alt"></v-icon>
            </div>
            Informations Administratives & Financières
          </div>
          <div class="body">
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
          </div>
        </div>
      </div>

      <div class="card p-3">
        <div class="w-100">
          <div class="head d-flex align-items-center">
            <div class="icon-wrapper mr-3">
              <v-icon name="pencil-alt"></v-icon>
            </div>
            Informations supplémentaires
          </div>
          <div class="body">
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
          </div>
        </div>
      </div>

      <div class="card p-3">
        <div class="w-100">
          <div class="head d-flex align-items-center">
            <div class="icon-wrapper mr-3">
              <v-icon name="user-circle"></v-icon>
            </div>
            Première personne de contact
          </div>
          <div class="body">
            <!-- contact people -->
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
          </div>
        </div>
      </div>

      <div class="card p-3">
        <div class="w-100">
          <div class="head d-flex align-items-center">
            <div class="icon-wrapper mr-3">
              <v-icon name="user-circle"></v-icon>
            </div>
            Première personne de contact
          </div>
          <div class="body">
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
          </div>
        </div>
      </div>

      <div class="card p-3">
        <div class="w-100">
          <div class="head d-flex align-items-center">
            <div class="icon-wrapper mr-3">
              <v-icon name="user-circle"></v-icon>
            </div>
            Première personne de contact
          </div>
          <div class="body">
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
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import Icon from 'vue-awesome/components/Icon'
import 'vue-awesome/icons'
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
    WedoImageMultiple,
    'v-icon': Icon
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
          // company gallery images
          this.images = []

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

          // category options for multi-select
          const cats = (await this.$axios.$get('/category/list')).data
          cats.forEach(cat => {
            this.categories.push({
              value: cat.id,
              text: '— '.repeat(cat.depth) + cat.name
            })
          })

          // region options for region multi-select
          const regions = (await this.$axios.$get('/region')).data
          regions.forEach(region => {
            this.regions.push({ value: region.region_id, text: region.name })
          })
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
            const response = await this.$axios.$post('company', {
              company: company,
              services: services,
              categories: categories,
              people: this.contactPeople
            })
            if (response.status === 'success') {
              this.success = true
              this.newCompany = response.company
              this.$router.push('/annonce/' + this.newCompany.slug)
            }
          } catch (e) {
            console.log(e)
          }
        }
      })
    }
  }
}
</script>

<style>
@import 'assets/css/edit-listing/company.css';
</style>
