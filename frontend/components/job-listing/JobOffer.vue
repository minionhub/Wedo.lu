<template>
  <div id="page-content">
    <div id="page-head" class="member-login">
      <img :src="jobOffer.cover_img" alt="image" />
      <div class="container clearfix">
        <div class="row col-sm-12 justi-center">
          <div class="p-detail-box">
            <img
              src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/STEFFEN_logo_def.png"
              alt=""
            />
          </div>
        </div>
      </div>
    </div>

    <div id="container" class="job-content">
      <b-container>
        <b-row class="headline">
          <b-col sm="12" md="7" class="left">
            <h2>{{ jobOffer.job_title }}</h2>
            <p>
              {{ jobOffer.company_name }}
            </p>
          </b-col>
          <b-col sm="12" md="5" class="right text-right">
            <!-- <div class="share">
              <b-dropdown variant="link" no-caret>
                <template slot="button-content">
                  <img src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/boucher/1.svg" alt="link" />
                </template>
                <b-dropdown-item href="#">
                  <img src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/ico_face.png" class="p-2" width="50" />Facebook
                </b-dropdown-item>
                <b-dropdown-item href="#">
                  <img src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/ico_link.png" class="p-2" width="50" />Linkedin
                </b-dropdown-item>
                <b-dropdown-item href="#">
                  <img src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/ico_tw.png" class="p-2" width="50" />Twitter
                </b-dropdown-item>
              </b-dropdown>
            </div> -->
            <div class="apply-now fr">
              <a href="#" class="apply-now desktop">Postulez maintenant</a>
            </div>
          </b-col>
        </b-row>
        <b-row class="p-tab-content">
          <b-col sm="12" lg="7" class="left">
            <div class="tab">
              <div class="title">
                <img
                  src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/boucher/2.svg"
                  alt="link"
                />Description du poste
              </div>
              <div class="content">
                {{ jobOffer.full_description }}
              </div>
            </div>
            <div class="tab desktop">
              <div class="title">
                <img
                  src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/boucher/3.svg"
                  alt=""
                />Postulez maintenant
              </div>
              <div class="content jobboard-form fr">
                <div role="form">
                  <form class="boucher-form">
                    <div class="item">
                      <div class="item-title">Déposer votre candidature</div>
                      <input type="text" placeholder="Nom et prénom" />
                      <input type="email" placeholder="Nom et prénom" />
                    </div>
                    <div class="item">
                      <div class="item-title">Lettre de motivation</div>
                      <textarea rows="4"></textarea>
                    </div>
                    <div class="item">
                      <div class="item-title">CV</div>
                      <p>
                        <input type="file" />
                        <span class="p-file-valid">
                          Aucun fichier sélectionné
                        </span>
                      </p>
                      <p class="py-1">
                        Formats acceptés: .doc, .docx, .pdf, .txt, .odt (Taille
                        max: 2MB)
                      </p>
                    </div>
                    <p>
                      <span class="checkbox">
                        <input type="checkbox" />
                        <span>
                          Je donne mon accord pour que mes données soient
                          transmises par ce formulaire
                        </span>
                      </span>
                      <input type="submit" value="POSTULEZ MAINTENANT" />
                    </p>
                  </form>
                </div>
              </div>
            </div>
          </b-col>
          <b-col sm="12" lg="5" class="right">
            <div class="tab">
              <div class="title">
                <img
                  src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/boucher/4.svg"
                  alt="link"
                />Informations
              </div>
              <div class="content">
                <div class="p-row">
                  <p>Fonction</p>
                  <p>{{ jobOffer.job_title }}</p>
                </div>
                <div class="p-row">
                  <p>Contrat de travail</p>
                  <p>{{ jobOffer.contract_type }}</p>
                </div>
              </div>
            </div>
            <div class="tab">
              <div class="title">
                <img
                  src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/boucher/5.svg"
                  alt="link"
                />Employeur
              </div>
              <div class="content">
                <div class="p-row">
                  <p>Contrat de travail</p>
                  <p>{{ jobOffer.contract_type }}</p>
                </div>
                <div class="p-row">
                  <p>Entreprise</p>
                  <p>{{ jobOffer.contact_person }}</p>
                </div>
                <div class="p-row">
                  <p>Tel</p>
                  <p>
                    <a href="tel:+3523996501">{{ jobOffer.phone }}</a>
                  </p>
                </div>
                <div class="p-row email">
                  <p>Email</p>
                  <p>
                    <a href="mailto:wewantyou@steffen.lu">
                      {{ jobOffer.contact_email }}
                    </a>
                  </p>
                </div>
              </div>
            </div>
            <div class="tab">
              <div class="title">
                <img
                  src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/boucher/6.svg"
                  alt="link"
                />Niveaux de langue requis
              </div>
              <div class="content">
                <div class="p-row">
                  <p>Luxembourgeois</p>
                  <p>{{ jobOffer.level_of_luxembourgish }}</p>
                </div>
                <div class="p-row">
                  <p>Allemand</p>
                  <p>{{ jobOffer.level_of_german }}</p>
                </div>
                <div class="p-row">
                  <p>Français</p>
                  <p>{{ jobOffer.level_of_french }}</p>
                </div>
                <div class="p-row">
                  <p>Anglais</p>
                  <p>{{ jobOffer.level_of_english }}</p>
                </div>
              </div>
            </div>
            <div class="tab">
              <div class="title">
                <img
                  src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/boucher/7.svg"
                  alt="link"
                />Entreprise
              </div>
              <div class="content">
                <div class="p-row">
                  <p>
                    <a href="#">{{ jobOffer.contact_person }}</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="tab location">
              <div class="title">
                <img
                  src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/boucher/8.svg"
                  alt="link"
                />Location
              </div>
              <div class="w-100">
                <WedoMap
                  :lat="jobOffer.map_latitude"
                  :lng="jobOffer.map_longitude"
                  :icon="jobOffer.logo_img"
                  height="350px"
                ></WedoMap>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-container>
    </div>
  </div>
</template>

<script>
import WedoMap from '~/components/WedoMap.vue'

export default {
  components: {
    WedoMap
  },
  props: {
    jobOffer: {
      type: Object,
      default: function() {
        return {}
      }
    }
  }
}
</script>

<style>
@import 'assets/css/joboffer.css';
</style>
