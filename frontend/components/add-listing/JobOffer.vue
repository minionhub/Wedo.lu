<template>
  <div class="edit-job">
    <div v-if="success" class="row">
      <div class="col-lg-8 mx-auto success-msg mb-4">
        <span>Vos changements ont été sauvegardés. </span>
        <a :href="'/annonce/' + newJob.slug">Voir →</a>
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
            <WedoSelect
              v-model="job.category_id"
              v-validate="{ required: true }"
              :options="categories"
              name="category"
              label="Catégories general"
              :error="errors.first('category')"
              placeholder="Activités artisanales diverses"
            />
            <WedoInput
              v-model="job.job_title"
              v-validate="{ required: true }"
              name="job_title"
              label="Fonction"
              :error="errors.first('job_title')"
            />
            <WedoSelect
              v-model="job.contract_type"
              :options="contractTypes"
              label="Contrat de travail"
            />
            <WedoTinymce
              v-model="job.full_description"
              v-validate="{ required: true }"
              name="full_description"
              label="Description"
              :error="errors.first('full_description')"
            />
          </div>
        </div>
      </div>

      <div class="card p-3">
        <div class="w-100">
          <div class="head d-flex align-items-center">
            <div class="icon-wrapper mr-3">
              <v-icon name="user-tie"></v-icon>
            </div>
            Employeur
          </div>
          <div class="body">
            <WedoInput
              v-model="job.company_name"
              v-validate="{ required: true }"
              name="company_name"
              label="Entreprise"
              :error="errors.first('company_name')"
            />
            <!-- regions -->
            <WedoMultiSelect
              v-model="regionsSelected"
              :options="regions"
              title="Region (optionnel)"
              placeholder="Choisissez une region"
            />

            <WedoImage
              v-model="job.logo_img"
              label="Logo"
              :has-error="!job.logo_img && isSubmitted"
            />
            <WedoImage
              v-model="job.cover_img"
              label="Grande image arrière plan pour le profil (optionnel)"
            />

            <WedoInput
              v-model="job.contact_email"
              v-validate="{ required: true, email: true }"
              name="contact_email"
              label="Contact Email"
              :error="errors.first('contact_email')"
            />
            <WedoInput
              v-model="job.website_url"
              name="website_url"
              label="Website (optionnel)"
            />
            <WedoInput
              v-model="job.phone"
              name="phone"
              label="Phone Number (optionnel)"
            />

            <!-- latitude and longitude -->
            <WedoMapEx v-model="position" />

            <WedoInput
              v-model="job.contact_person"
              name="contact_person"
              label="Personne de contact (optionnel)"
            />

            <WedoFile v-model="job.pdf" name="pdf" label="Pdf (optionnel)" />

            <WedoInput
              v-model="job.payment"
              name="payment"
              label="Paiement (optionnel)"
            />
            <WedoSelect
              v-model="job.company_id"
              v-validate="{ required: true }"
              :options="companies"
              name="company"
              label="Fiche liée à l'entreprise:"
              :error="errors.first('company')"
            />

            <WedoSelect
              v-model="job.level_of_luxembourgish"
              :options="langLevels"
              label="Luxembourgeois (optionnel)"
            />
            <WedoSelect
              v-model="job.level_of_german"
              :options="langLevels"
              label="Allemand (optionnel)"
            />
            <WedoSelect
              v-model="job.level_of_french"
              :options="langLevels"
              label="Français (optionnel)"
            />
            <WedoSelect
              v-model="job.level_of_english"
              :options="langLevels"
              label="Anglais (optionnel)"
            />

            <WedoInput
              v-model="job.company_social_security_number"
              name="company_social_security_number"
              label="Numéro matricule de l'entreprise (optionnel)"
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
import WedoTinymce from '~/components/WedoTinymce.vue'
import WedoFile from '~/components/WedoFile.vue'
import WedoInput from '~/components/WedoInput.vue'
import WedoSelect from '~/components/WedoSelect.vue'
import WedoMultiSelect from '~/components/WedoMultiSelect.vue'
import WedoImage from '~/components/WedoImage.vue'
import WedoMapEx from '~/components/edit-listing/WedoMapEx.vue'

export default {
  components: {
    WedoTinymce,
    WedoFile,
    WedoInput,
    WedoSelect,
    WedoMultiSelect,
    WedoImage,
    WedoMapEx,
    'v-icon': Icon
  },
  data() {
    return {
      job: {},
      categories: [],
      contractTypes: [],
      regions: [],
      regionsSelected: [],
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
      langLevels: [],
      companies: [],
      success: false,
      newJob: {},
      hasLogo: false,
      isSubmitted: false
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    async init() {
      try {
        // category options for multi-select
        const cats = (await this.$axios.$get('/category/list')).data
        cats.forEach(cat => {
          this.categories.push({
            value: cat.id,
            text: '— '.repeat(cat.depth) + cat.name
          })
        })

        this.contractTypes = [
          { value: 'CDI', text: 'CDI' },
          { value: 'CDD', text: 'CDD' },
          { value: 'Internship', text: 'Internship' }
        ]

        this.langLevels = [
          { value: 'NotRequired', text: 'Non requis' },
          { value: 'A1', text: 'A1 Débutant' },
          { value: 'A2', text: 'A2 Élémentaire' },
          { value: 'B1', text: 'B1 Intermédiaire' },
          { value: 'B2', text: 'B2 Intermédiaire supérieur' },
          { value: 'C1', text: 'C1 Compétence opérationnelle' },
          { value: 'C2', text: 'C2 Compétence effective ou avancée' },
          { value: 'C3', text: 'C3 Langue maternelle' }
        ]

        // region options for region multi-select
        const regions = (await this.$axios.$get('/region')).data
        regions.forEach(region => {
          this.regions.push({ value: region.region_id, text: region.name })
        })

        const companies = (await this.$axios.$get(
          '/company/user/' + this.user.id
        )).data
        companies.forEach(company => {
          this.companies.push({
            value: company.listing_id,
            text: company.company_name
          })
        })
      } catch (e) {
        console.log(e)
      }
    },
    submit() {
      this.isSubmitted = true

      this.$validator.validateAll().then(async () => {
        if (
          this.job.logo_img === null ||
          typeof this.job.logo_img === 'undefined'
        ) {
          this.hasLogo = false
          return
        }
        if (!this.errors.any()) {
          try {
            const job = {
              logo_img: await (async () => {
                if (!this.job.logo_img.startsWith('data:'))
                  return this.job.logo_img
                const response = await this.$axios.$post('image', {
                  image: this.job.logo_img
                })
                return response.url
              })(),
              cover_img: await (async () => {
                if (typeof this.job.cover_img === 'undefined') return null
                if (!this.job.cover_img.startsWith('data:'))
                  return this.job.cover_img
                const response = await this.$axios.$post('image', {
                  image: this.job.cover_img
                })
                return response.url
              })(),
              full_description: this.job.full_description,
              contact_email: this.job.contact_email,
              region: (() => {
                const regions = []
                this.regionsSelected.forEach(region => {
                  regions.push(region.value)
                })
                return JSON.stringify(regions)
              })(),
              job_title: this.job.job_title,
              contract_type: this.job.contract_type,
              pdf: await (async () => {
                if (typeof this.job.pdf === 'object') {
                  const formData = new FormData()
                  formData.append('file', this.job.pdf)
                  const url = (await this.$axios.$post('/file', formData, {
                    headers: {
                      'Content-Type': 'multipart/form-data'
                    }
                  })).url
                  return url
                }
                return this.job.pdf
              })(),
              payment: this.job.payment,
              website_url: this.job.website_url,
              phone: this.job.phone,
              map_longitude: this.position.lng,
              map_latitude: this.position.lat,
              company_name: this.job.company_name,
              company_social_security_number: this.job
                .company_social_security_number,
              contact_person: this.job.contact_person,
              level_of_luxembourgish: this.job.level_of_luxembourgish,
              level_of_german: this.job.level_of_german,
              level_of_french: this.job.level_of_french,
              level_of_english: this.job.level_of_english,
              category_id: this.job.category_id,
              company_id: this.job.company_id,
              user_id: this.user.id
            }
            console.log(job)
            const response = await this.$axios.$post('joboffer', {
              joboffer: job
            })
            if (response.status === 'success') {
              this.success = true
              this.newJob = response.joboffer
              document.documentElement.scrollTop = 0
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
@import 'assets/css/edit-listing/joboffer.css';
</style>
