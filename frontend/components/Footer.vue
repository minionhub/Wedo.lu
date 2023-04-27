<template>
  <footer>
    <div class="top pt-5">
      <b-container>
        <b-row>
          <b-col lg="5">
            <figure>
              <b-link href="/">
                <b-img
                  src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/logo.svg"
                  class="logo"
                  alt="wedo.lu"
                ></b-img>
              </b-link>
            </figure>
            <hr class="hr-orange mt-4 mb-4" />
            <p class="mt-3 mb-3 desc">
              wedo.lu est une initiative de la Fédération des Artisans. La
              Fédération des Artisans regroupe les entreprises artisanales
              légalement établies sur le territoire luxembourgeois. L’artisanat
              luxembourgeois compte 7.000 entreprises avec quelque 90.000
              salariés.
            </p>
          </b-col>
          <b-col lg="7" xl="6" offset-xl="1">
            <b-row>
              <b-col md="12">
                <p class="footer-heading">Réseaux sociaux</p>
                <b-link
                  class="mr-4 social-link"
                  href="https://www.facebook.com/Wedo-Luxembourg-166724430664536/"
                >
                  <b-img
                    src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/social-icons/facebook.svg"
                  ></b-img>
                </b-link>
                <b-link
                  class="mr-4 social-link"
                  href="https://twitter.com/wedolu"
                >
                  <b-img
                    src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/social-icons/twitter.svg"
                  ></b-img>
                </b-link>
                <b-link
                  class="mr-4 social-link"
                  href="https://www.youtube.com/channel/UCsjCxxnttFK1CTzg1uXNSxw/"
                >
                  <b-img
                    src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/social-icons/youtube.svg"
                  ></b-img>
                </b-link>
                <b-link
                  class="mr-4 social-link"
                  href="https://plus.google.com/114712727205236930196"
                >
                  <b-img
                    src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/social-icons/google.svg"
                  ></b-img>
                </b-link>
                <b-link
                  class="mr-4 social-link"
                  href="https://www.linkedin.com/company/wedolu/"
                >
                  <b-img
                    src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/social-icons/linkedin.svg"
                  ></b-img>
                </b-link>
                <b-link
                  class="mr-4 social-link"
                  href="https://www.instagram.com/wedolu/"
                >
                  <b-img
                    src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/social-icons/instagram.svg"
                  ></b-img>
                </b-link>
                <b-link
                  class="mr-4 social-link"
                  href="https://pinterest.com/wedolu"
                >
                  <b-img
                    src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/social-icons/pinterest.svg"
                  ></b-img>
                </b-link>
              </b-col>
            </b-row>
            <b-row class="pt-4">
              <b-col md="4" class="pr-0">
                <p class="footer-heading">
                  À PROPOS
                </p>
                <ul class="footer-links ml-0 pl-0">
                  <li>
                    <b-link href="/nous-contacter">Nous contacter</b-link>
                  </li>
                  <li>
                    <b-link href="/post-category/presse">Presse</b-link>
                  </li>
                  <li>
                    <b-link
                      href="/conditions-generales-dutilisation-volet-particuliers-utilisateurs"
                      >CGU - Volet particuliers</b-link
                    >
                  </li>
                  <li>
                    <b-link href="/conditions-generales-dutilisation-2"
                      >CGU - Volet entrepreneurs</b-link
                    >
                  </li>
                  <li>
                    <b-link href="/mentions-legales">Mentions légales</b-link>
                  </li>
                </ul>
              </b-col>
              <b-col md="4" class="pr-0">
                <p class="footer-heading">
                  DÉCOUVRIR
                </p>
                <ul class="footer-links ml-0 pl-0">
                  <li>
                    <b-link href="/annuaire-des-artisans"
                      >Annuaire Artisans</b-link
                    >
                  </li>
                  <li>
                    <b-link href="/devis">Obtenir un devis</b-link>
                  </li>
                  <li>
                    <b-link href="/evenements">Évènements</b-link>
                  </li>
                  <li>
                    <b-link href="/jobboard">Job Board</b-link>
                  </li>
                  <li>
                    <b-link href="/blog">Blog</b-link>
                  </li>
                </ul>
              </b-col>
              <b-col md="4" class="pr-0">
                <p class="footer-heading">
                  ESPACE ARTISAN
                </p>
                <ul class="footer-links ml-0 pl-0">
                  <li>
                    <b-link href="/my-account">Accueil artisan</b-link>
                  </li>
                  <li>
                    <b-link href="/service-et-tarifs">Services & tarifs</b-link>
                  </li>
                  <li>
                    <b-link href="/ajouter-votre-annonce"
                      >Inscription artisan</b-link
                    >
                  </li>
                  <li>
                    <b-link href="/aide-faq">Aide / FAQ</b-link>
                  </li>
                </ul>
              </b-col>
            </b-row>
          </b-col>
        </b-row>
        <hr class="mt-5 bg-dark" />
        <b-row class="pt-4 pb-4">
          <b-col md="12" class="plus-desc">
            <p>
              Vous souhaitez vous faciliter le quotidien au Luxembourg? Utilisez
              le meilleur site de devis wedo.lu!
            </p>
            <b-collapse id="desc-collapse">
              <p>
                Wedo.lu est le nouvel annuaire des entreprises au Luxembourg,
                regroupant l’ensemble des entreprises et artisans membres de la
                Fédération des Artisans.
              </p>
              <p>
                En effet, notre service de pages jaunes en ligne, permet de
                trouver le bon fournisseur en quelques clics seulement et de le
                contacter par téléphone, email ou même par fax.
              </p>
              <p>
                Souhaitez-vous savoir comment faire et comparer rapidement un
                devis pour vos travaux? Utilisez simplement notre service de
                devis en ligne sur fixe ou mobile.
              </p>
              <p>
                Obtenez dès maintenant jusqu’à 6 devis gratuits pour tous vos
                travaux de plomberie, d’électricité, de peinture ou bien encore
                pour l’installation d’une nouvelle cuisine équipée ou véranda.
              </p>
              <p>
                Nos artisans, hautement qualifiés, s’engagent à vous répondre
                sous 24 heures pour discuter des détails ou pour fixer un
                rendez-vous en vue d’établir un devis.
              </p>
            </b-collapse>
          </b-col>
          <b-col md="12" class="text-center">
            <b-button v-b-toggle.desc-collapse class="plus-btn">
              Montrer Plus
            </b-button>
          </b-col>
        </b-row>
      </b-container>
    </div>
    <div class="bottom p-3">
      <b-container>
        <b-row>
          <b-col md="12" class="text-right text-white">
            © wedo.lu, 2018
          </b-col>
        </b-row>
      </b-container>
    </div>
    <b-button id="back-to-top" @click="backToTop">
      <i class="material-icons">keyboard_arrow_up</i>
    </b-button>
  </footer>
</template>

<script>
export default {
  mounted() {
    this.init()
  },
  methods: {
    init() {
      if (process.client) {
        window.onscroll = function() {
          if (
            document.body.scrollTop > 100 ||
            document.documentElement.scrollTop > 100
          ) {
            document.getElementById('back-to-top').classList.add('show')
          } else {
            document.getElementById('back-to-top').classList.remove('show')
          }
        }
      }
    },
    backToTop() {
      if (process.client) {
        document.documentElement.scrollTop = 0
      }
    }
  }
}
</script>

<style>
#back-to-top {
  position: fixed;
  bottom: 30px;
  right: 30px;
  display: flex;
  padding: 10px;
  background: #fff;
  border-radius: 50%;
  border: none;
  box-shadow: 0 5px 33px rgba(0, 0, 0, 0.2);
  opacity: 0;
  transition: all 0.3s;
}

#back-to-top.show {
  opacity: 1;
}

#back-to-top i {
  color: #000;
}

#back-to-top:hover {
  background-color: #ffa600;
  transform: translateY(-10px);
}

#back-to-top:hover i {
  color: #fff;
}

footer .top {
  background-color: #efefef;
}

footer .bottom {
  background-color: #525353;
  font-family: 'Open Sans', sans-serif;
  font-size: 14px;
}

footer .logo {
  max-width: 200px;
}

footer .hr-orange {
  background-color: #faa31a;
}

footer .desc {
  font-family: 'Open Sans', sans-serif;
  font-weight: 400;
  font-size: 13px;
  color: #565d62;
}

footer .footer-heading {
  font-size: 14px;
  font-family: 'Montserrat', sans-serif;
  color: #010101 !important;
  text-transform: uppercase;
  font-weight: 900;
}

footer .social-link img {
  height: 20px;
}

footer ul {
  list-style: none;
}

footer .footer-links li a {
  margin-bottom: 10px;
  font-size: 14px;
  font-family: 'Source Sans Pro', sans-serif;
  font-weight: 500;
  color: #000;
}

footer .plus-desc p {
  font-size: 13px;
  font-family: 'Source Sans Pro', sans-serif;
  font-weight: 400 !important;
  color: #565d62;
  margin-bottom: 2rem;
}

footer .plus-btn {
  font-family: 'Source Sans Pro', sans-serif;
  font-size: 16px;
  font-weight: 600;
  color: #ffffff;
  border-radius: 5px;
  background-color: #525353;
  padding: 7px 31px;
}
</style>
