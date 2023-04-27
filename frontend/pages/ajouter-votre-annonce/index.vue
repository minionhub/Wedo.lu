<template>
  <div id="page-content" class="annonce-page" style="padding-top: 120px">
    <div
      id="accountConfirmationForm-big-container"
      class="container-fluid col-12 p-lg-5 text-center"
      style="background-image: url('https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/members-after.jpg'); background-size: cover;"
    >
      <div
        id="whitePanel"
        class="container mx-auto col-lg-12 bg-white p-0 mx-5"
        style="border: solid 1px #D1D1D1D1;"
      >
        <div class="py-5">
          <h1
            id="whitePanel-title-member"
            class="pb-5 bg-white"
            style="font-family: 'Open Sans', sans-serif; font-weight: 600; color: #171717;"
          >
            Pour les membres: Activez votre <br />compte sur wedo.lu
          </h1>
          <p
            id="whitePanel-description"
            class="px-xl-5 px-lg-5 mx-auto"
            style="text-align: center; font-family: 'Open Sans', sans-serif; font-weight: 400; font-size: 16px; line-height: 24px; color: #171717;"
          >
            Wedo.lu est une initiative de la Fédération des Artisans. En tant
            qu’entreprise membre vous êtes automatiquement référencée dans notre
            annuaire professionnel. La procédure pour prendre en main votre
            compte entreprise est la suivante :
          </p>
        </div>
        <div id="whitePanel-ul" class="container py-5">
          <ul
            class="login-steps group clearfix p-0"
            style="list-style-type: none;"
          >
            <li>
              <span class="number">1</span>
              <figure>
                <b-img
                  src="https://wedo.lu/wp-content/uploads/2018/05/interface.svg"
                  alt="interface"
                />
              </figure>
              <p>
                Cliquez
                <b-link
                  href="#"
                  data-toggle="modal"
                  data-target="#sign-up-modal"
                  class="open-register-btn"
                  >ici pour s’inscrire</b-link
                >
                et créer votre compte d'utilisateur.
              </p>
            </li>
            <li>
              <span class="number">2</span>
              <figure>
                <b-img
                  src="https://wedo.lu/wp-content/uploads/2018/05/icon38-1.svg"
                  alt="icon38 1"
                />
              </figure>
              <p>
                Retournez vers
                <b-link target="_blank" href="https://www.wedo.lu/"
                  >l’annuaire</b-link
                >
                et recherchez votre entreprise.
              </p>
            </li>
            <li>
              <span class="number">3</span>
              <figure>
                <b-img
                  src="https://wedo.lu/wp-content/uploads/2018/05/icon39-1.svg"
                  alt="icon39 1"
                />
              </figure>
              <p>Cliquez sur «proclamer».</p>
            </li>
            <li>
              <span class="number">4</span>
              <figure>
                <b-img
                  src="https://wedo.lu/wp-content/uploads/2018/05/icon40-1.svg"
                  alt="icon40 1"
                />
              </figure>
              <p>Sélectionnez votre formule.</p>
            </li>
            <li>
              <span class="number">5</span>
              <figure>
                <b-img
                  src="https://wedo.lu/wp-content/uploads/2018/05/icon41-1.svg"
                  alt="icon41 1"
                />
              </figure>
              <p>
                Après vérification de notre part votre entreprise sera liée à
                votre compte d'utilisateur.
              </p>
            </li>
          </ul>
        </div>
        <div class="container py-3 px-0">
          <hr class="mx-xl-5" />
          <div class="row col-10 mx-auto px-0 pt-3">
            <div class="col-lg-6 col-md-12 px-0 text-left">
              <h5
                style="color: #171717; font-size: 14px; line-height: 28px; font-weight: 600; font-family: 'open sans', sans-serif;"
              >
                Que peux-je faire?
              </h5>
              <p
                class="pt-3"
                style="color: #5c5c68; font-size: 20px; line-height: 32px; font-weight: 400; font-family: 'open sans', sans-serif;"
              >
                Avec ce login vous pouvez éditer le contenu de votre page
                entreprise et choisir votre formule d’engagement sur wedo.lu
                (free, start, pro, expert).
              </p>
            </div>
            <div class="col-lg-6 col-md-12 text-left">
              <h5
                style="color: #171717; font-size: 14px; line-height: 28px; font-weight: 600; font-family: 'open sans', sans-serif;"
              >
                Regarder la vidéo
              </h5>
              <figure class="pt-3">
                <iframe
                  id="video_player"
                  src="https://player.vimeo.com/video/270407712"
                  width="400"
                  height="176"
                  frameborder="0"
                  allowfullscreen=""
                ></iframe>
              </figure>
            </div>
          </div>
        </div>
        <div
          class="container-fluid p-0 mx-auto w-100 bg-white shadow-lg card rounded-0 m-0"
          style="border: solid 1px #D1D1D1D1;"
        >
          <div class="row col-12 mx-auto py-5">
            <div id="whitePanel-search-bar" class="col-md-9 pl-xl-5">
              <input
                v-model="query"
                class="form-control"
                style="font-family: 'Open Sans', sans-serif; font-size: 16px; line-height: 30px; color: #7e7e89; font-weight: 400"
                type="search"
                placeholder="Rechercher mon entreprise"
                aria-label="Que cherchez vous?"
                @keydown.enter.prevent="searchCompany"
              />
            </div>
            <div class="col-md-3 mt-md-0 pl-xl-0 text-left" style="">
              <button
                id="whitePanel-search-btn"
                class="button-yellow btn btn-lg px-xl-3 py-3"
                style="font-family: 'Source Sans Pro', sans-serif; font-weight: 400; font-size: 13px; line-height: 16px;"
                @click.prevent="searchCompany"
              >
                Recherche
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      id="accountConfirmationForm-container"
      class="container-fluid pb-0 pt-sm-0 col-12 p-lg-5 px-sm-0 text-center"
    >
      <div
        id="accountConfirmationForm"
        class="container mx-auto col-xl-9 col-lg-12 px-xl-0 px-sm-0 my-md-5"
      >
        <div class="py-5">
          <h1
            id="whitePanel-title-non-member"
            class="pb-3"
            style="font-family: 'Open Sans', sans-serif; color: #171717;"
          >
            Pour les non-membres: Rejoignez l'organisation<br />
            de l'artisanat au Luxembourg
          </h1>
          <p
            class=""
            style="font-family: 'Open Sans', sans-serif; font-weight: 400; font-size: 16px; line-height: 24px; color: #171717;"
          >
            wedo.lu est une initiative de la Fédération des Artisans pour ses
            membres. Contactez-nous pour découvrir les nombreux avantages liés à
            une affiliation à la Fédération des Artisans ou complétez
            directement le formulaire ci-joint pour obtenir une proposition
            d’affiliation.
          </p>
          <hr class="ml-5 mr-5 mt-5" />
        </div>
        <div class="row text-left">
          <div class="col-md-6 col-sm-12">
            <p
              class="mr-5 mt-5"
              style="font-family: 'Source Sans Pro', sans-serif; font-weight: 600; font-size: 18px; line-height: 26px; color: #171717;"
            >
              Entreprise :
            </p>
            <input
              class="form-control mr-5 p-0"
              style="font-family: 'Open Sans', sans-serif; font-size: 16px; line-height: 30px; color: #7e7e89; font-weight: 400"
              type="text"
              placeholder="Entreprise"
              aria-label="entreprise"
            />
            <p
              class="mr-5 mt-5"
              style="font-family: 'Source Sans Pro', sans-serif; font-weight: 600; font-size: 18px; line-height: 26px; color: #171717;"
            >
              Nombre De Salariés :
            </p>
            <input
              class="form-control mr-5 p-0"
              style="font-family: 'Open Sans', sans-serif; font-size: 16px; line-height: 30px; color: #7e7e89; font-weight: 400"
              type="text"
              placeholder="Nombre De Salariés"
              aria-label="Nombre De Salariés"
            />
            <p
              class="mr-5 mt-5"
              style="font-family: 'Source Sans Pro', sans-serif; font-weight: 600; font-size: 18px; line-height: 26px; color: #171717;"
            >
              Téléphone :
            </p>
            <input
              class="form-control mr-5 p-0"
              style="font-family: 'Open Sans', sans-serif; font-size: 16px; line-height: 30px; color: #7e7e89; font-weight: 400"
              type="text"
              placeholder="Téléphone"
              aria-label="Téléphone"
            />
          </div>
          <div class="col-md-6 col-sm-12">
            <p
              class=" mr-5 mt-5"
              style="font-family: 'Source Sans Pro', sans-serif; font-weight: 600; font-size: 18px; line-height: 26px; color: #171717;"
            >
              Secteur d'activité :
            </p>
            <input
              class="form-control  mr-5 p-0"
              style="font-family: 'Open Sans', sans-serif; font-size: 16px; line-height: 30px; color: #7e7e89; font-weight: 400"
              type="text"
              placeholder="Secteur d'activité"
              aria-label="Secteur d'activité"
            />
            <p
              class=" mr-5 mt-5"
              style="font-family: 'Source Sans Pro', sans-serif; font-weight: 600; font-size: 18px; line-height: 26px; color: #171717;"
            >
              Personne De Contact :
            </p>
            <input
              class="form-control  mr-5 p-0"
              style="font-family: 'Open Sans', sans-serif; font-size: 16px; line-height: 30px; color: #7e7e89; font-weight: 400"
              type="text"
              placeholder="Personne De Contact"
              aria-label="Personne De Contact"
            />
            <p
              class=" mr-5 mt-5"
              style="font-family: 'Source Sans Pro', sans-serif; font-weight: 600; font-size: 18px; line-height: 26px; color: #171717;"
            >
              Email :
            </p>
            <input
              class="form-control  mr-5 p-0"
              style="font-family: 'Open Sans', sans-serif; font-size: 16px; line-height: 30px; color: #7e7e89; font-weight: 400"
              type="email"
              placeholder="Email"
              aria-label="Email"
            />
            <div class=" mr-5 p-2 mt-5 align-baseline">
              <label
                ><input
                  type="checkbox"
                  style="font-family: 'Open Sans', sans-serif; font-weight: 400; font-size: 16px; line-height: 24px; color: #171717;"
                />
                Je donne mon consentement pour que mes données soient transmises
                par ce formulaire</label
              >
            </div>
          </div>
          <div class="row ml-2">
            <button
              class="button-yellow btn btn-lg mt-5 pl-5 pr-5 pt-3 pb-3"
              style="font-family: 'Source Sans Pro', sans-serif; font-weight: 400; font-size: 13px; line-height: 16px;"
              type="submit"
            >
              Envoyer
            </button>
          </div>
          <div class="col-12">
            <hr class="px-5 mt-5" />
          </div>
        </div>
      </div>
    </div>

    <div
      class="container-fluid py-0 col-12 mb-5 shadow bg-white text-center"
      style="border: solid 1px #d1d1d1;"
    >
      <div class="container mx-auto col-xl-6 col-lg-10 col-md-12 p-0 mx-5">
        <div class="py-5">
          <h1
            style="font-family: 'Open Sans', sans-serif; font-weight: 600; font-size: 40px; line-height: 50px; color: #171717;"
          >
            Contact nouveaux membres
          </h1>
          <hr id="contact-hr" class="my-5" />
          <div id="contact-info" class="row mx-auto">
            <div class="col-md-6 col-sm-12 mx-sm-auto px-xl-0 px-sm-5">
              <div class="row">
                <div class="col-md-4 col-sm-12 mx-sm-auto">
                  <b-img
                    src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/icon37.svg"
                    class="img-fluid"
                    alt=""
                  />
                </div>
                <div class="col-md-8 col-sm-12 mx-sm-auto px-0">
                  <p
                    style="font-family: 'Source Sans Pro', sans-serif; font-weight: 600; font-size: 22px; line-height: 28px; color: #000; text-align: left"
                  >
                    Max Frank
                  </p>
                  <p
                    style="font-family: 'Open Sans', sans-serif; font-weight: 400; font-size: 16px; line-height: 26px; color: #7e7e89; text-align: left"
                  >
                    Fédération des Artisans
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-12 mx-sm-auto px-xl-0 px-sm-5">
              <div class="row">
                <div class="col-md-6 col-sm-12 mx-sm-auto px-0">
                  <b-link
                    href="#"
                    class="link-orange"
                    style="font-family: 'Open Sans', sans-serif; font-weight: 400; font-size: 14px; line-height: 28px;"
                    ><i class="material-icons my-auto">phone</i>
                    424511-22</b-link
                  >
                </div>
                <div class="col-md-6 col-sm-12 mx-sm-auto px-0">
                  <b-link
                    href="#"
                    class="link-orange"
                    style="font-family: 'Open Sans', sans-serif; font-weight: 400; font-size: 14px; line-height: 28px;"
                    ><i class="material-icons my-auto">mail_outline</i>
                    m.frank@fda.lu</b-link
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AjouterVotreAnnonce',
  data() {
    return {
      query: ''
    }
  },
  methods: {
    searchCompany() {
      if (typeof this.query === 'undefined' || this.query === '') return

      this.$router.push({
        path:
          '/annuaire-2?search_keywords=' +
          this.query +
          '&tab=search-form&type=place'
      })
    }
  }
}
</script>

<style scoped>
@import 'assets/css/style.css';
</style>
