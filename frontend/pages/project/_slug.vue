<template>
  <div class="single-project single">
    <b-modal id="project_contact_popup" hide-footer hide-header>
      <div class="d-block text-center">
        <h4 class="modal-  text-center">
          Avez-vous déjà contacté le client d'une autre manière que via notre
          formulaire de contact ?
        </h4>
      </div>
      <button
        class="btn buttons button-2 first-contact"
        type="button"
        @click="confirm"
      >
        <b>Oui</b>, j'ai déjà contacté le client
      </button>
      <button
        class="btn buttons button-2 use-contact-form"
        type="button"
        @click="cancel"
      >
        <b>Non</b>, j'aimerais utiliser le formulaire de contact
      </button>
    </b-modal>
    <b-modal id="contact-form-popup" hide-footer hide-header>
      <div class="project-box contact-form">
        <h3 class="box-heading">
          <img
            src="https://devis.wedo.lu/wp-content/themes/wpfreelance-child/images/ico_contact.svg"
          />Contact
        </h3>
        <div class="popup-form-project form-project">
          <b-form>
            <div class="item information">
              <b-row>
                <b-col sm="6">
                  <b-form-group
                    id="input-group-1"
                    label="Prénom "
                    label-for="input-1"
                  >
                    <b-form-input
                      id="input-1"
                      v-model="form.email"
                      required
                      placeholder="Prénom "
                    ></b-form-input>
                  </b-form-group>
                </b-col>
                <b-col sm="6">
                  <b-form-group
                    id="input-group-1"
                    label="Nom"
                    label-for="input-1"
                  >
                    <b-form-input
                      id="input-1"
                      v-model="form.email"
                      required
                      placeholder="Nom"
                    ></b-form-input>
                  </b-form-group>
                </b-col>
                <b-col sm="6">
                  <b-form-group
                    id="input-group-1"
                    label="Numéro de téléphone"
                    label-for="input-1"
                  >
                    <b-form-input
                      id="input-1"
                      v-model="form.email"
                      required
                      placeholder="Numéro de téléphone"
                    ></b-form-input>
                  </b-form-group>
                </b-col>
                <b-col sm="6">
                  <b-form-group
                    id="input-group-1"
                    label="Email"
                    label-for="input-1"
                  >
                    <b-form-input
                      id="input-1"
                      v-model="form.email"
                      required
                      placeholder="Email"
                    ></b-form-input>
                  </b-form-group>
                </b-col>
              </b-row>
            </div>
            <div class="item message">
              <b-row>
                <b-col sm="12">
                  <b-form-group
                    id="input-group-1"
                    label="Votre message"
                    label-for="input-1"
                  >
                    <b-form-textarea
                      id="textarea"
                      v-model="form.description"
                      placeholder="Enter something..."
                    ></b-form-textarea>
                  </b-form-group>
                </b-col>
              </b-row>
            </div>
            <div class="item">
              <label>Joindre un fichier (optionel)</label>
              <p></p>
              <div class="wrap-input-file">
                <span class="">
                  <b-form-file
                    v-model="form.file"
                    class="mt-3"
                    plain
                  ></b-form-file
                ></span>
              </div>
            </div>
            <div class="item condition">
              <b-form-checkbox
                id="checkbox-1"
                v-model="form.status"
                name="checkbox-1"
                value="accepted"
                unchecked-value="not_accepted"
              >
                Je donne mon accord pour que mes données soient transmises par
                ce formulaire.
              </b-form-checkbox>
            </div>
            <div class="cancel">
              <a href="#"
                ><img
                  src="https://devis.wedo.lu/wp-content/themes/wpfreelance-child/images/ico_popup_close.svg"
                />
                Annuler</a
              >
            </div>
            <div class="submit">
              <WedoButton value="Envoyer"></WedoButton>
            </div>
          </b-form>
        </div>
      </div>
    </b-modal>
    <div class="quote-wrapper">
      <div class="page-head">
        <b-container>
          <b-row>
            <b-col sm="7">
              <span class="project-status">{{
                formatStatus(project.status)
              }}</span>
              <h2>{{ project.title }}</h2>
              <p v-html="getDuration(project.publish_date)"></p>
            </b-col>
            <b-col sm="5">
              <div class="float-right admin-act">
                <Button
                  v-if="visibleContact"
                  class="btn buttons button-2"
                  @click="showContactForm"
                  >Contact</Button
                >
                <Button
                  v-if="visibleDelete"
                  class="btn buttons button-2 delBtn"
                  @click="deleteProject"
                  >Archive</Button
                >
                <Button
                  class="btn buttons button-2"
                  @click="showSimilarProjects"
                  >Voir les demandes similaires</Button
                >
              </div>
            </b-col>
          </b-row>
        </b-container>
      </div>
      <div class="employer-details">
        <b-container>
          <b-row>
            <b-col sm="7">
              <div class="project-box">
                <h3 class="box-heading">
                  <b-img
                    src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/project/ico_description.png"
                    alt=""
                  >
                  </b-img>
                  Détails de l'offre
                </h3>
                <div class="line-wrap">
                  <div class="line">
                    <p>Métier requis</p>
                    <span> {{ subCategory.subcategory_name }} </span>
                  </div>
                  <div class="line">
                    <p>Catégories</p>
                    <span> {{ category.category_name }} </span>
                  </div>
                  <div class="line">
                    <span>
                      {{ project.description }}
                    </span>
                  </div>
                  <div v-if="attached_files.length > 0" class="line">
                    <div class="list-attach">
                      <p>Fichiers</p>
                      <span v-for="(file, index) in attached_files" :key="index"
                        ><b-img
                          src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/project/ico_btn_attach.png"
                          alt=""
                        ></b-img>
                        <b-link class="text-color" :to="file" download="">{{
                          file.split('/')[file.split('/').length - 1]
                        }}</b-link></span
                      >
                    </div>
                  </div>
                </div>
              </div>
              <div class="project-box contact-form desktop">
                <h3 class="box-heading">
                  <img
                    src="https://devis.wedo.lu/wp-content/themes/wpfreelance-child/images/ico_contact.svg"
                  />Contact
                </h3>
                <div class="popup-form-project form-project">
                  <b-form>
                    <div class="item information">
                      <b-row>
                        <b-col sm="6">
                          <b-form-group
                            id="input-group-1"
                            label="Prénom "
                            label-for="input-1"
                          >
                            <b-form-input
                              id="input-1"
                              v-model="form.email"
                              required
                              placeholder="Prénom "
                            ></b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col sm="6">
                          <b-form-group
                            id="input-group-1"
                            label="Nom"
                            label-for="input-1"
                          >
                            <b-form-input
                              id="input-1"
                              v-model="form.email"
                              required
                              placeholder="Nom"
                            ></b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col sm="6">
                          <b-form-group
                            id="input-group-1"
                            label="Numéro de téléphone"
                            label-for="input-1"
                          >
                            <b-form-input
                              id="input-1"
                              v-model="form.email"
                              required
                              placeholder="Numéro de téléphone"
                            ></b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col sm="6">
                          <b-form-group
                            id="input-group-1"
                            label="Email"
                            label-for="input-1"
                          >
                            <b-form-input
                              id="input-1"
                              v-model="form.email"
                              required
                              placeholder="Email"
                            ></b-form-input>
                          </b-form-group>
                        </b-col>
                      </b-row>
                    </div>
                    <div class="item message">
                      <b-row>
                        <b-col sm="12">
                          <b-form-group
                            id="input-group-1"
                            label="Votre message"
                            label-for="input-1"
                          >
                            <b-form-textarea
                              id="textarea"
                              v-model="form.description"
                              placeholder="Enter something..."
                            ></b-form-textarea>
                          </b-form-group>
                        </b-col>
                      </b-row>
                    </div>
                    <div class="item">
                      <label>Joindre un fichier (optionel)</label>
                      <p></p>
                      <div class="wrap-input-file">
                        <span class="">
                          <b-form-file
                            v-model="form.file"
                            class="mt-3"
                            plain
                          ></b-form-file
                        ></span>
                      </div>
                    </div>
                    <div class="item condition">
                      <b-form-checkbox
                        id="checkbox-1"
                        v-model="form.status"
                        name="checkbox-1"
                        value="accepted"
                        unchecked-value="not_accepted"
                      >
                        Je donne mon accord pour que mes données soient
                        transmises par ce formulaire.
                      </b-form-checkbox>
                    </div>
                    <WedoButton value="Envoyer"></WedoButton>
                  </b-form>
                </div>
              </div>
            </b-col>
            <b-col sm="5">
              <div class="project-box">
                <h3 class="box-heading">
                  <img
                    src="https://devis.wedo.lu/wp-content/themes/wpfreelance-child/images/project/ico_client.png"
                    alt=""
                  />
                  Informations client
                </h3>
                <div class="line-wrap">
                  <div class="line">
                    <p>Nom du client:</p>
                    <span>{{ project.author_name }}</span>
                  </div>
                  <div class="line">
                    <p>Adresse email :</p>
                    <span>{{ project.author_email }}</span>
                  </div>
                  <div class="line">
                    <p>Numéro de téléphone:</p>
                    <span>{{ project.author_phone }}</span>
                  </div>
                  <div class="line">
                    <p>Préfère être contacté en:</p>
                    <span>{{ project.author_prefers_to_be_contacted_in }}</span>
                  </div>
                  <div class="line">
                    <p>Adresse des travaux:</p>
                    <span>{{ project.project_address }}</span>
                  </div>
                  <div class="line">
                    <p>Région:</p>
                    <span>{{ region }}</span>
                  </div>
                  <div class="line">
                    <p>Début d'intervention</p>
                    <span>{{ project.start_time }}</span>
                  </div>
                </div>
              </div>
              <div class="customer-contacted">
                <p class="message">
                  {{ changeFormatOffer(project.number_of_offers) }}
                </p>
              </div>
            </b-col>
          </b-row>
          <b-row>
            <b-col sm="7">
              <div class="project-box contact-form mobile">
                <h3 class="box-heading">
                  <img
                    src="https://devis.wedo.lu/wp-content/themes/wpfreelance-child/images/ico_contact.svg"
                  />Contact
                </h3>
                <div class="popup-form-project form-project">
                  <b-form>
                    <div class="item information">
                      <b-row>
                        <b-col sm="6">
                          <b-form-group
                            id="input-group-1"
                            label="Prénom "
                            label-for="input-1"
                          >
                            <b-form-input
                              id="input-1"
                              v-model="form.email"
                              required
                              placeholder="Prénom "
                            ></b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col sm="6">
                          <b-form-group
                            id="input-group-1"
                            label="Nom"
                            label-for="input-1"
                          >
                            <b-form-input
                              id="input-1"
                              v-model="form.email"
                              required
                              placeholder="Nom"
                            ></b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col sm="6">
                          <b-form-group
                            id="input-group-1"
                            label="Numéro de téléphone"
                            label-for="input-1"
                          >
                            <b-form-input
                              id="input-1"
                              v-model="form.email"
                              required
                              placeholder="Numéro de téléphone"
                            ></b-form-input>
                          </b-form-group>
                        </b-col>
                        <b-col sm="6">
                          <b-form-group
                            id="input-group-1"
                            label="Email"
                            label-for="input-1"
                          >
                            <b-form-input
                              id="input-1"
                              v-model="form.email"
                              required
                              placeholder="Email"
                            ></b-form-input>
                          </b-form-group>
                        </b-col>
                      </b-row>
                    </div>
                    <div class="item message">
                      <b-row>
                        <b-col sm="12">
                          <b-form-group
                            id="input-group-1"
                            label="Votre message"
                            label-for="input-1"
                          >
                            <b-form-textarea
                              id="textarea"
                              v-model="form.description"
                              placeholder="Enter something..."
                            ></b-form-textarea>
                          </b-form-group>
                        </b-col>
                      </b-row>
                    </div>
                    <div class="item">
                      <label>Joindre un fichier (optionel)</label>
                      <p></p>
                      <div class="wrap-input-file">
                        <span class="">
                          <b-form-file
                            v-model="form.file"
                            class="mt-3"
                            plain
                          ></b-form-file
                        ></span>
                      </div>
                    </div>
                    <div class="item condition">
                      <b-form-checkbox
                        id="checkbox-1"
                        v-model="form.status"
                        name="checkbox-1"
                        value="accepted"
                        unchecked-value="not_accepted"
                      >
                        Je donne mon accord pour que mes données soient
                        transmises par ce formulaire.
                      </b-form-checkbox>
                    </div>
                    <WedoButton value="Envoyer"></WedoButton>
                  </b-form>
                </div>
              </div>
            </b-col>
          </b-row>
        </b-container>
      </div>
    </div>
  </div>
</template>
<script>
import WedoButton from '~/components/WedoButton.vue'
export default {
  middleware: 'auth',
  components: {
    WedoButton
  },
  data() {
    return {
      form: {
        email: '',
        name: '',
        description: '',
        file: '',
        status: '',
        food: null,
        checked: []
      },
      project: {},
      attached_files: [],
      category: {},
      subCategory: [],
      region: '',
      visibleContact: true,
      visibleDelete: false
    }
  },
  async validate({ params, $axios, error }) {
    if (params.slug != null) {
      let item = null
      try {
        item = (await $axios.$get('/project/slug/' + params.slug)).project[0]
        if (
          typeof item.project_id === 'undefined' ||
          item.project_id === null
        ) {
          return false
        } else {
          return true
        }
      } catch (e) {
        return false
      }
    } else {
      return false
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    async init() {
      this.project = (await this.$axios.$get(
        '/project/slug/' + this.$route.params.slug
      )).project[0]

      this.project.start_time = (await this.$axios.$get(
        'project/starttime/key/' + this.project.start_time
      )).data[0].text

      this.project.author_prefers_to_be_contacted_in = (await this.$axios.$get(
        'language/code/' + this.project.author_prefers_to_be_contacted_in
      )).language[0].name

      if (this.project.author_id === this.user.id) {
        this.visibleDelete = true
        this.visibleContact = false
      } else {
        this.visibleContact = true
        this.visibleDelete = false
      }
      this.showModal()
      // check auth if can show project or not
      if (
        this.user.manages_companies === 1 &&
        (this.project.status === '"draft"' ||
          this.project.status === '"archived"' ||
          this.project.status === '"blocked"')
      ) {
        this.$nuxt.error({ statusCode: 404, message: 'Error' })
      } else if (
        this.user.manages_companies === 1 &&
        this.project.status === '"published"'
      ) {
        this.projects_role = true
      } else if (
        this.user.role === 'Moderator' ||
        this.user.role === 'Administrator'
      ) {
        this.projects_role = true
      } else if (
        this.user.manages_companies === 0 &&
        this.user.id === this.project.author_id &&
        this.project.status === '"published"'
      ) {
        this.projects_role = true
      } else {
        this.$nuxt.error({ statusCode: 404, message: 'Error' })
        this.projects_role = false
      }
      this.attached_files = JSON.parse(
        this.project.attached_files
      ).attached_files

      // get category by project id
      this.category = (await this.$axios.$get(
        '/project/' + this.project.project_id + '/categories'
      )).categories[0]

      // get sub category by project id
      this.subCategory = (await this.$axios.$get(
        '/project/' + this.project.project_id + '/subcategories'
      )).subcategories[0]

      // get region by project id
      this.region = (await this.$axios.$get(
        '/region/' + JSON.parse(this.project.region)[0]
      )).region.name
    },
    async showModal() {
      const checkedOffer = await this.$axios.$get(
        '/project/' + this.project.project_id + '/contacted/' + this.user.id
      )
      if (
        checkedOffer.contacted === 'No' &&
        this.project.author_id !== this.user.id
      ) {
        this.$root.$emit('bv::show::modal', 'project_contact_popup', '#btnShow')
      }
    },
    async confirm() {
      this.project = (await this.$axios.$put(
        '/project/contact/' + this.project.project_id + '/' + this.user.id
      )).project
      this.project.start_time = (await this.$axios.$get(
        'project/starttime/key/' + this.project.start_time
      )).data[0].text

      this.project.author_prefers_to_be_contacted_in = (await this.$axios.$get(
        'language/code/' + this.project.author_prefers_to_be_contacted_in
      )).language[0].name
      this.$bvModal.hide('project_contact_popup')
    },
    cancel() {
      this.$bvModal.hide('project_contact_popup')
    },
    showContactForm() {
      this.$bvModal.show('contact-form-popup')
    },
    getDuration(date) {
      const pubDate = new Date(date)
      const nowDate = new Date()
      const days = Math.round(nowDate - pubDate) / (1000 * 60 * 60 * 24)
      if (days < 7) {
        if (days > 1) return 'Publié il y a <b>' + days + ' jours</b>'
        else return 'Publié il y a <b>' + days + ' jour</b>'
      }
      if (days > 7 && days < 31) {
        const weeks = Math.round(days / 7)
        if (weeks > 1) return 'Publié il y a <b>' + weeks + ' semaines</b>'
        else return 'Publié il y a <b>' + weeks + ' semaine</b>'
      }
      if (days > 31 && days < 365) {
        const months = Math.round(days / 31)
        if (months > 1) return 'Publié il y a <b>' + months + ' mois</b>'
        else return 'Publié il y a <b>' + months + ' moi</b>'
      }
      if (days > 365) {
        const years = Math.round(days / 365)
        if (years > 1) return 'Publié il y a <b>' + years + ' ans</b>'
        else return 'Publié il y a <b>' + years + ' an</b>'
      }
    },
    changeFormatOffer(offer) {
      if (offer === 0) return 'Soyez le premier à contacter le client'
      return 'Le client a été contacté ' + offer + " fois jusqu'à présent"
    },
    formatStatus(status) {
      if (this.project.status === '"draft"') {
        return 'Brouillon'
      } else if (this.project.status === '"published"') {
        return 'Ouvert'
      } else {
        return 'Archivé'
      }
    },
    async showSimilarProjects() {
      const subcategories = (await this.$axios.$get(
        '/project/' + this.project.project_id + '/subcategories'
      )).subcategories
      const params = []
      subcategories.forEach(item => {
        params.push(item.subcategory_id)
      })
      this.$router.push({
        path: '/devis/projects',
        query: { skill: params }
      })
    },
    async deleteProject() {
      await this.$axios
        .$delete('/project/' + this.project.project_id)
        .then(response => {
          this.$router.push({ path: '/devis/my-projects' })
        })
    }
  }
}
</script>
<style>
@import 'assets/css/template.css';
@import 'assets/css/style.project.css';
.delBtn {
  background-color: #5c5c68 !important;
}
.admin-act {
  text-align: right;
}
</style>
