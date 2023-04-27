<style>
@import 'assets/css/style.chao.css';
.validate-msg {
  min-height: 25px;
  font-weight: 600;
}

#quote-page #main .quote-form legend {
  display: block;
  font-family: 'Open Sans', sans-serif !important;
  font-size: 18px;
  font-weight: 600;
  color: #171717;
  margin-bottom: 0px;
}

#quote-page #main .quote-form input[type='text'] {
  border-bottom: solid 2px #7e7e89;
  padding-bottom: 8px;
}

.wedo-input {
  margin-bottom: 0px !important;
}

.wedo-input input:focus {
  border-bottom: 1px solid #ffa602 !important;
  padding-left: 5px !important;
}

#quote-page #main .quote-form textarea {
  border-radius: 0px;
}

.wedo-textarea textarea:focus {
  border: 1px solid #ffa602 !important;
}

.container-fluid {
  padding-top: 0px;
}

.wedo-textarea legend {
  line-height: unset !important;
}

.wedo-checkbox label {
  font-size: 16px !important;
  font-weight: 400 !important;
  padding-left: 25px;
  letter-spacing: 0.4px;
}

#sidebar ul li:last-child {
  border-bottom: 1px solid #d1d1d1 !important;
}

.wedo-select .selection.dropdown,
.wedo-select input.search,
.wedo-select .item {
  padding: 10px 0 !important;
}

.wedo-select .selection.dropdown,
.wedo-select input.search,
.wedo-select .item {
  font-size: 16px !important;
}

.check_err_msg {
  margin: -20px 0 5px 45px;
}

.wedo-textarea legend {
  min-height: 54px;
}

.wedo-checkbox {
  margin-bottom: 0px;
}

.wedo-checkbox label {
  font-size: 13px;
  line-height: 24px;
  color: #565d62;
  font-weight: 400;
  font-family: 'Open Sans', sans-serif;
}

.custom-control-input:checked ~ .custom-control-label::before {
  background-color: #ffa602;
  border-color: #ffa602;
}

.validate-msg {
  margin-top: 5px;
}

.select-err-msg {
  margin-bottom: 8px;
  margin-left: 5px;
  margin-top: 0px;
}

.multiselect__tags {
  font-size: 16px;
  padding-left: 0px !important;
  padding-bottom: 1px !important;
  color: #7e7e89;
}

.multiselect__tags .multiselect__input {
  border-bottom: none !important;
  padding-bottom: 2px !important;
  margin-bottom: 0px !important;
  font-size: 14px;
}

.multiselect__tags .multiselect__tag {
  margin-bottom: 0px;
}

.multiselect__placeholder {
  color: #7e7e89;
  margin-bottom: 0px;
}

.region-title {
  margin-bottom: 0px !important;
  line-height: 2;
}

.region-validate-err {
  margin-bottom: 8px;
  margin-left: 5px;
  margin-top: 0px;
}

.multiselect__single {
  padding-left: 0px;
}

.description-section {
  padding-right: 5px !important;
}

.fileupload-section {
  padding-left: 5px !important;
}

.wedo-checkbox label {
  margin-bottom: 0px !important;
}

/* Responsive */

@media screen and (max-width: 1198px) {
  .image-label {
    min-height: 50px;
  }
  .wedo-textarea legend {
    min-height: 80px;
  }
}

@media screen and (max-width: 991px) {
  #quote-page #main {
    padding-left: 17px;
    border-left: none;
  }
}

@media screen and (max-width: 767px) {
  #header .navbar-brand img {
    height: 40px !important;
  }
  #quote-page .banner .container {
    -webkit-transform: translate(0, 0);
    -ms-transform: translate(0, 0);
    transform: translate(0, 0);
    position: static;
    margin-top: -120px;
    margin-bottom: 22px;
    text-align: center;
  }
  #quote-page .banner .banner-bkg {
    min-height: 290px;
  }
  #quote-page .banner .container .description {
    padding: 23px;
  }
  .box1 {
    padding: 20px !important;
  }
  .mobile img {
    width: 30px !important;
  }
}
</style>

<template>
  <div id="quote-page" class="w-100">
    <div class="banner">
      <b-img
        class="banner-bkg"
        src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/quote/banner.jpg"
        alt="banner image"
      ></b-img>
      <b-container>
        <div class="description">
          <div class="title text-center">
            <b-img
              class="icon"
              src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/quote/spade.png"
              alt="banner image"
            ></b-img>
            <h1>{{ project.sub_category_name }}</h1>
            <hr />
            <h2 class="text-center">
              Recevez jusqu’à 6 devis gratuits d’entreprises de construction au
              Luxembourg
            </h2>
            <p class="text-center">
              Souhaitez-vous obtenir plusieurs devis, pour des travaux
              d’assainissement, de la part de professionnels près de chez vous ?
              Remplissez le formulaire ci-dessous et nos experts se chargeront
              de vous contacter sous 48 heures.
            </p>
          </div>
        </div>
      </b-container>
    </div>
    <b-container fluid>
      <b-row>
        <b-col id="sidebar" lg="3" md="4">
          <div class="widget">
            <h2>Comment ça marche</h2>
            <div class="content">
              <ul class="list1">
                <li class="clearfix step-wrapper">
                  <figure class="icon">
                    <b-img
                      class="icon"
                      src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/icons/settings-icon.svg"
                      alt="icon"
                    ></b-img>
                  </figure>
                  <div class="step-details">
                    <h3>Étape 1</h3>
                    <p>Choisir une catégorie</p>
                  </div>
                </li>
                <li class="clearfix step-wrapper">
                  <figure class="icon">
                    <b-img
                      class="icon"
                      src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/icons/doc-icon.svg"
                      alt="icon"
                    ></b-img>
                  </figure>
                  <div class="step-details">
                    <h3>Étape 2</h3>
                    <p>Saisir les détails</p>
                  </div>
                </li>
                <li class="clearfix step-wrapper">
                  <figure class="icon">
                    <b-img
                      class="icon"
                      src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/icons/sent-icon.svg"
                      alt="icon"
                    ></b-img>
                  </figure>
                  <div class="step-details">
                    <h3>Étape 3</h3>
                    <p>Recevoir vos devis</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </b-col>
        <b-col id="main" lg="9" md="8">
          <form
            data-vv-scope="quote"
            class="quote-form"
            @submit.prevent="createProject"
          >
            <div class="box1">
              <h2>Déscription de mon projet</h2>
              <hr />
              <b-row>
                <b-col md="12">
                  <WedoInput
                    v-model="quote.title"
                    v-validate="{ required: true }"
                    name="title"
                    label="Titre du projet"
                    style="marginBottom: 50px !important"
                    placeholder="Ex: Construction d’un batiment industriel"
                    :error="errors.first('quote.title')"
                  ></WedoInput>
                </b-col>
              </b-row>
              <b-row>
                <b-col lg="6" class="mb-4">
                  <div class="form-group h-100 mb-0">
                    <label class="description-label"
                      >Décrivez brièvement votre projet (type de construction,
                      type de projet, surface, ...)</label
                    >
                    <b-form-textarea
                      v-model="quote.description"
                      v-validate="{ required: true }"
                      style="resize: none"
                      label=""
                      :rows="5"
                      placeholder="Décrivez votre project ici.."
                      class="mb-0"
                    ></b-form-textarea>
                  </div>
                </b-col>

                <b-col lg="6" class="mb-4">
                  <!-- <div class="form-group h-100 d-flex mb-0 flex-wrap">
                    <label class="image-label w-100"
                      >Expliquer votre projet en rajoutant une image ou un
                      document.
                    </label>
                    <div
                      class="fileupload-container w-100 d-flex align-items-end"
                    >
                      <input
                        id="sp-upload"
                        type="file"
                        name="upload[]"
                        multiple
                        class="fileupload-input custom-file-input"
                      />
                    </div>
                  </div> -->
                  <WedoFileProject
                    v-model="quote.files"
                    name="files"
                    label="Expliquer votre projet en rajoutant une image ou un document."
                  >
                  </WedoFileProject>
                </b-col>
              </b-row>
              <b-row>
                <b-col md="6">
                  <label class="region-title">Région(s) d'activité </label>
                  <multiselect
                    v-model="quote.region"
                    :options="regionOptions"
                    :selected-options="selectedRegions"
                    :close-on-select="true"
                    track-by="name"
                    label="text"
                    :multiple="true"
                    :taggable="true"
                    @select="onSelect"
                  >
                  </multiselect>
                  <div
                    class="w-100 text-danger validate-msg region-validate-err"
                  >
                    <span>{{ region_error }}</span>
                  </div>
                  <WedoSingleSelect
                    v-model="quote.intervention"
                    name="quote.intervention"
                    title="Début d'intervention"
                    :options="interventionOptions"
                  ></WedoSingleSelect>
                  <div class="w-100 text-danger validate-msg select-err-msg">
                    <span>{{ intervention_error }}</span>
                  </div>
                  <WedoInput
                    id="quote-form-email"
                    v-model="quote.email"
                    v-validate="{ required: true, email: true }"
                    name="quote.email"
                    label="Adresse email"
                    placeholder="Adresse email"
                    :error="errors.first('quote.email')"
                  ></WedoInput>
                  <div class="w-100 text-danger validate-msg select-err-msg">
                    <span></span>
                  </div>
                  <WedoInput
                    id="quote-form-address"
                    v-model="quote.address"
                    v-validate="{ required: true }"
                    name="quote.address"
                    label="Adresse des travaux"
                    placeholder="Adresse des travaux"
                    :error="errors.first('quote.address')"
                  ></WedoInput>
                </b-col>
                <b-col md="6">
                  <WedoInput
                    id="quote-form-name"
                    v-model="quote.name"
                    v-validate="{ required: true }"
                    style="height: 109px"
                    name="quote.name"
                    label="Votre nom"
                    placeholder="Votre nom"
                    :error="errors.first('quote.name')"
                  ></WedoInput>
                  <WedoInput
                    id="quote-form-phone"
                    v-model="quote.phone"
                    v-validate="{ required: true }"
                    style="height: 109px"
                    name="phone"
                    label="Numéro de téléphone"
                    placeholder="Numéro de téléphone"
                    :error="errors.first('quote.phone')"
                  ></WedoInput>
                  <WedoLanguageSelect
                    v-model="quote.language"
                    name="quote.language"
                    title="Je souhaite être contacté en"
                    :options="languageOptions"
                  ></WedoLanguageSelect>
                </b-col>
              </b-row>
            </div>
            <b-row>
              <b-col lg="7" class="float-left">
                <b-form-checkbox
                  v-model="quote.check1"
                  class="wedo-checkbox"
                  value="value1"
                >
                  Je donne mon consentement pour que mes données soient
                  transmises par ce formulaire
                </b-form-checkbox>
                <div class="w-100 text-danger validate-msg check_err_msg">
                  <span v-if="quote.check1 !== 'value1'">{{
                    check_error1
                  }}</span>
                </div>
                <b-form-checkbox
                  v-model="quote.check2"
                  class="wedo-checkbox"
                  value="value2"
                >
                  En soumettant ce formulaire, j'accepte que les informations
                  saisies soient utilisées dans le cadre de la demande de devis
                  et dans la relation commerciale qui peut en découler
                </b-form-checkbox>
                <div class="w-100 text-danger validate-msg check_err_msg">
                  <span v-if="quote.check2 !== 'value2'">{{
                    check_error2
                  }}</span>
                </div>
              </b-col>
              <b-col lg="5" class="text-right">
                <WedoButton value="Envoyer" :disabled="false"></WedoButton>
              </b-col>
            </b-row>
          </form>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import WedoInput from '~/components/WedoInput.vue'
import WedoFileProject from '~/components/WedoFileProject.vue'
import WedoButton from '~/components/WedoButton.vue'
import WedoSingleSelect from '~/components/WedoSingleSelect.vue'
import WedoLanguageSelect from '~/components/WedoLanguageSelect.vue'
import Multiselect from 'vue-multiselect'
export default {
  components: {
    WedoInput,
    WedoFileProject,
    WedoButton,
    WedoSingleSelect,
    WedoLanguageSelect,
    Multiselect
  },
  data() {
    return {
      quote: {
        title: '',
        description: '',
        date: '',
        email: '',
        phone: '',
        files: '',
        address: '',
        check1: '',
        check2: '',
        intervention: {
          name: '-1',
          text: 'Pas de date fixée'
        },
        language: {
          name: 'fr',
          text: 'Français'
        },
        region: []
      },
      category: {
        main: '',
        sub: ''
      },
      project: {
        sub_category_name: '',
        sub_cat_id: ''
      },
      subCategory: {},
      regionOptions: [],
      interventionOptions: [],
      languageOptions: [],
      options: {},
      selectedRegions: [],
      lastSelectedItem: {},
      description_error: '',
      check_error1: '',
      check_error2: '',
      region_error: '',
      intervention_error: '',
      date_error: '',
      formValidation: true
    }
  },
  async validate({ params, $axios, error }) {
    if (params.main_cat != null) {
      let cat = null
      let subCat = null
      try {
        cat = (await $axios.$get('/project/categories/slug/' + params.main_cat))
          .data
        if (
          typeof cat.category_id === 'undefined' ||
          cat.category_id === null
        ) {
          return false
        } else {
          subCat = (await $axios.$get(
            '/project/subcategories/slug/' + params.sub_cat
          )).subcategory[0]
          if (
            typeof subCat.subcategory_id === 'undefined' ||
            subCat.subcategory_id === null
          ) {
            return false
          } else {
            return true
          }
        }
      } catch (e) {
        return false
      }
    } else {
      return true
    }
  },
  watch: {
    'quote.description': function() {
      this.description_error = ''
      if (this.quote.description === '')
        this.description_error = 'Vous devez fournir une déscription'
    },
    'quote.region': function() {
      this.region_error = ''
      if (this.quote.region.length === 0) {
        this.region_error = 'Ce champ est obligatoire'
      }
    },
    'quote.intervention': function() {
      this.intervention_error = ''
      if (this.quote.intervention.name === this.interventionOptions[0].name) {
        this.intervention_error = 'Ce champ est obligatoire'
      }
    }
  },
  mounted() {
    this.category.main = this.$route.params.main_cat
    this.category.sub = this.$route.params.sub_cat
    this.init()
  },
  methods: {
    async init() {
      this.subCategory = await this.$axios.$get(
        '/project/subcategories/slug/' + this.category.sub
      )
      this.subCategory = this.subCategory.subcategory
      this.project.sub_category_name = this.subCategory[0].subcategory_name
      this.project.sub_cat_id = this.subCategory[0].subcategory_id

      this.options = (await this.$axios.$get('/region')).data

      this.options.forEach(region => {
        this.regionOptions.push({
          name: region.region_id,
          text: region.name
        })
      })

      const interventions = (await this.$axios.$get('/project/starttime')).data
      interventions.sort((a, b) => {
        return a.key - b.key
      })
      interventions.forEach(item => {
        this.interventionOptions.push({
          name: item.key,
          text: item.text
        })
      })

      const languages = (await this.$axios.$get('/language')).language
      languages.forEach(lang => {
        this.languageOptions.push({
          name: lang.code,
          text: lang.name
        })
      })
    },
    onSelect(items, lastSelectedItem) {
      console.log(items)
      this.selectedRegions = items
    },
    createProject() {
      this.description_error = ''
      this.check_error1 = ''
      this.check_error2 = ''
      this.region_error = ''
      this.intervention_error = ''
      let validation = true
      if (this.quote.check1 !== 'value1') {
        this.check_error1 = 'Obligatoire'
        validation = false
      }
      if (this.quote.check2 !== 'value2') {
        this.check_error2 = 'Obligatoire'
        validation = false
      }
      if (this.quote.description === '') {
        this.description_error = 'Vous devez fournir une déscription'
        validation = false
      }
      if (this.quote.region.length === 0) {
        this.region_error = 'Ce champ est obligatoire'
        validation = false
      }
      if (this.quote.intervention.name === this.interventionOptions[0].name) {
        this.intervention_error = 'Ce champ est obligatoire'
        validation = false
      }
      this.$validator.validateAll('quote').then(async () => {
        console.log(this.errors.any())
        if (!this.errors.any() && validation) {
          try {
            const regions = []
            this.quote.region.forEach(region => {
              regions.push(region.name)
            })
            const files = []
            this.quote.files.forEach(file => {
              files.push(file.name)
            })
            const data = {
              title: this.quote.title,
              description: this.quote.description,
              author_name: this.quote.name,
              author_phone: this.quote.phone,
              author_email: this.quote.email,
              attached_files: files,
              project_address: this.quote.address,
              author_prefers_to_be_contacted_in: this.quote.language.name,
              website_language: 'fr',
              region: regions,
              start_time: this.quote.intervention.name,
              subcategory_id: this.subCategory[0].category_id
            }
            const response = await this.$axios.$post('/project', data)
            if (response.status === 'success') {
              if (typeof this.quote.files === 'object') {
                for (const file of this.quote.files) {
                  const formData = new FormData()
                  formData.append('file', file)
                  formData.append('user_id', response.project.author_id)
                  formData.append('project_id', response.project.project_id)
                  await this.$axios.$post('/file/project', formData, {
                    headers: {
                      'Content-Type': 'multipart/form-data'
                    }
                  })
                }
              }
              this.$router.push({
                path: '/devis/project-success',
                query: {
                  skill: this.subCategory[0].subcategory_id
                }
              })
            }
          } catch (e) {
            this.errorMsg = 'Identifiant ou e-mail non valide.'
          }
        }
      })
    }
  }
}
</script>
