<template>
  <div id="my-account">
    <div v-if="!user">
      <p
        v-if="errorMsg"
        class="d-flex align-items-center justify-content-left p-2 account-error"
      >
        <v-icon name="exclamation-circle" class="mr-3"></v-icon>
        <b>ERREUR :&nbsp;</b>
        {{ errorMsg }}
      </p>
      <p
        v-if="isPwdReset"
        class="d-flex align-items-center justify-content-left p-2 account-success"
      >
        <i class="fa fa-check-circle mr-3"></i>
        Votre mot de passe a été réinitialisé avec succès.
      </p>
      <b-container>
        <b-row>
          <b-col lg="6">
            <div class="form-wrapper shadow-custom">
              <h2>Connexion</h2>
              <form data-vv-scope="login" @submit.prevent="login">
                <WedoInput
                  v-model="loginForm.email"
                  v-validate="{ required: true, email: true }"
                  name="login.email"
                  label="Adresse de messagerie *"
                  :error="errors.first('login.email')"
                ></WedoInput>

                <WedoInput
                  v-model="loginForm.password"
                  v-validate="{ required: true }"
                  name="login.password"
                  label="Mot de passe *"
                  type="password"
                  :error="errors.first('login.password')"
                ></WedoInput>

                <b-row>
                  <div class="col-sm-12 col-md-6">
                    <WedoButton
                      value="Connexion"
                      :disabled="errors.any('login')"
                    ></WedoButton>
                  </div>

                  <div
                    id="remember"
                    class="checkbox-wrapper col-sm-12 col-md-6"
                  >
                    <label>
                      <input type="checkbox" />
                      <span>Se souvenir de moi</span>
                    </label>
                  </div>
                </b-row>

                <div class="w-100 forget-passwd mt-3">
                  <a href="/my-account/lost-password">Mot de passe perdu ?</a>
                </div>
              </form>
            </div>
          </b-col>

          <b-col lg="6">
            <div class="form-wrapper shadow-custom">
              <h2>S'inscrire</h2>
              <form data-vv-scope="register" @submit.prevent="register">
                <WedoInput
                  v-model="registerForm.name"
                  v-validate="{ required: true }"
                  name="name"
                  label="Nom et prénom *"
                  :error="errors.first('register.name')"
                ></WedoInput>

                <WedoInput
                  v-model="registerForm.email"
                  v-validate="{ required: true, email: true }"
                  name="email"
                  label="Adresse de messagerie *"
                  :error="errors.first('register.email')"
                ></WedoInput>

                <WedoInput
                  v-model="registerForm.password"
                  v-validate="{
                    required: true,
                    min: 12,
                    max: 50,
                    regex: /^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/
                  }"
                  name="password"
                  label="Mot de passe *"
                  type="password"
                  :error="errors.first('register.password')"
                ></WedoInput>

                <div class="w-100 checkbox">
                  <label>
                    <input
                      v-validate="{ required: true }"
                      name="terms"
                      type="checkbox"
                    />
                    <span>
                      J’ai lu et j’accepte les
                      <b-link href="#">conditions générales de vente</b-link>et
                      les
                      <b-link href="#"
                        >conditions générales de volet
                        particuliers/utilisateurs</b-link
                      >
                    </span>
                    <div
                      v-show="errors.has('register.terms')"
                      class="validate-msg text-danger w-100"
                    >
                      {{ errors.first('register.terms') }}
                    </div>
                  </label>
                </div>

                <div class="w-100 checkbox">
                  <label>
                    <input
                      v-validate="{ required: true }"
                      name="secret"
                      type="checkbox"
                    />
                    <span>
                      J'accepte que mes données personnelles soient traitées
                      conformément à la
                      <b-link href="#">notice de confidentialié</b-link>publiée
                      par FDA Services sàrl.
                    </span>
                    <div
                      v-show="errors.has('register.secret')"
                      class="validate-msg text-danger w-100"
                    >
                      {{ errors.first('register.secret') }}
                    </div>
                  </label>
                </div>

                <WedoButton
                  value="S'inscrire"
                  :disabled="errors.any('register')"
                ></WedoButton>
              </form>
            </div>
          </b-col>
        </b-row>
      </b-container>
    </div>
    <div v-if="user">
      <!-- <div class="banner w-100">
        <b-img
          class="w-100"
          src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/my-account/banner.jpg"
          alt="banner image"
        ></b-img>
        <b-container>
          <h2 class="text-center m-0">{{ title }}</h2>
        </b-container>
      </div> -->

      <div class="content w-100">
        <b-container class="py-5">
          <b-row>
            <b-col md="4" lg="3" class="sidebar-wrapper">
              <Sidebar></Sidebar>
            </b-col>

            <b-col md="8" lg="9" class="p-5 edit-address">
              <div class="breadcrumbs py-3">
                <a target="_self" href="/dashboard" class="">Dashboard</a>
                <span class="separator">&gt;&gt;</span>
                <a target="_self" href="/my-account/addresses" class="last"
                  >Mon compte</a
                >
              </div>
              <div v-if="user.is_professional == 0">
                <h5>
                  Bonjour <b>{{ username }}</b> (vous n'êtes pas
                  <b>{{ username }}</b> ? Déconnexion)
                </h5>
                <p>
                  À partir de votre tableau de bord, vous pouvez visualiser vos
                  commandes récentes, gérer vos adresses de livraison et de
                  facturation ainsi que changer votre mot de passe et les
                  détails de votre compte.
                </p>
              </div>
              <div v-else class="package-option">
                <div class="container">
                  <div class="pricing-package">
                    <h2>Your package <span>Expert</span></h2>
                    <div class="listing-box">
                      <b-row>
                        <b-col md="5" sm="4">
                          <div class="price-box">
                            <h4>{{ subscription.slug }}</h4>
                            <p class="price show-no-tax">
                              <span class="amount"
                                >{{ subscription.price }} €</span
                              >
                              <span class="subscription-details"
                                >/ Year (excl. VAT)</span
                              >
                            </p>
                          </div>
                        </b-col>
                        <b-col md="7" sm="8">
                          <div
                            v-for="(item, index) of subscription.items"
                            :key="index"
                            class="feature-inner"
                          >
                            {{ item }}
                          </div>
                        </b-col>
                      </b-row>
                    </div>
                    <hr />
                    <h2>Choisir une autre forfait</h2>
                    <b-row class="other-package">
                      <b-col
                        v-for="(item, index) of otherPackages"
                        :key="index"
                        sm="4"
                        class="item"
                      >
                        <div class="listing-box-2">
                          <div class="price-box">
                            <h4>{{ item.name }}</h4>
                            <p class="price show-no-tax">
                              ‎<span class="amount"
                                >{{ item.price }}&nbsp;<span
                                  class="woocommerce-Price-currencySymbol"
                                  >€</span
                                ></span
                              >
                            </p>

                            <span class="subscription-details"
                              >/ An (HTVA)</span
                            >
                            <b-link
                              :to="'/produit/' + item.slug"
                              class="buttons button-2"
                            >
                              Sélectionner
                            </b-link>
                          </div>
                          <div
                            v-for="(feature, index) of item.items"
                            :key="index"
                            class="feature-inner"
                          >
                            {{ feature }}
                          </div>
                        </div>
                      </b-col>
                    </b-row>
                  </div>
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
import Icon from 'vue-awesome/components/Icon'
import 'vue-awesome/icons'
import WedoInput from '~/components/WedoInput.vue'
import WedoButton from '~/components/WedoButton.vue'
import Sidebar from '~/components/my-account/Sidebar.vue'

export default {
  components: {
    WedoInput,
    WedoButton,
    Sidebar,
    'v-icon': Icon
  },
  data() {
    return {
      loginForm: {
        email: '',
        password: ''
      },
      registerForm: {
        name: '',
        email: '',
        password: ''
      },
      errorMsg: null,
      title: 'Mon compte',
      isPwdReset: false,
      username: '',
      subscription: {},
      otherPackages: []
    }
  },
  mounted() {
    this.isPwdReset = localStorage.getItem('resetPwd') === 'success'
    if (this.isPwdReset) {
      localStorage.removeItem('resetPwd')
    }
    this.init()
    if (this.user) {
      this.getSubscription()
    }
  },
  methods: {
    init() {
      if (this.user) {
        this.$router.push({ path: '/dashboard' })
        this.username = this.user.display_name
      }
    },
    async getSubscription() {
      const slug = await this.$axios.$get('/user/products/highest')
      if (slug.status === 'success') {
        this.subscription = (await this.$axios.$get(
          '/product/slug/' + slug.main
        )).data[0]
        this.subscription.items = JSON.parse(this.subscription.items)
      }
      const allPackages = (await this.$axios.$get('/product')).data
      allPackages.forEach(item => {
        item.items = JSON.parse(item.items)
        if (item.id !== this.subscription.id) this.otherPackages.push(item)
      })
      this.otherPackages = this.otherPackages.splice(0, 1)
    },
    login() {
      this.$validator.validateAll('login').then(async () => {
        if (!this.errors.any()) {
          try {
            await this.$auth.login({
              data: this.loginForm
            })
          } catch (e) {
            if (e.response.data.error === 'User is blocked')
              this.errorMsg = "l'utilisateur a été bloqué par l'administration"
            else
              this.errorMsg = 'identifiants non valides. Mot de passe oublié?'
          }
        }
      })
    },
    register() {
      this.$validator.validateAll('register').then(async () => {
        if (!this.errors.any()) {
          try {
            await this.$axios.post('register', this.registerForm)
            this.$auth.login({
              data: {
                email: this.registerForm.email,
                password: this.registerForm.password
              }
            })
          } catch (e) {
            if (e.response.data.errors.exist) {
              this.errorMsg =
                'Un compte est déjà enregistré avec votre adresse e-mail. Veuillez vous connecter.'
            } else {
              this.errorMsg = 'Validation error.'
            }
          }
        }
      })
    }
  }
}
</script>

<style>
@import 'assets/css/sign-in-up.css';
@import 'assets/css/my-account.css';
#my-account .container {
  padding: 20px 0 !important;
}
.validate-msg {
  font-size: 13px;
  padding: 5px;
}
.edit-address {
  padding-top: 15px !important;
}
.edit-address p {
  font-size: 16px !important;
}
.package-option .pricing-package h2 {
  margin-bottom: 40px;
}
.pricing-package h2 span {
  font-weight: 700;
}
.pricing-package h2 {
  font-weight: 600 !important;
}
.price-box {
  text-align: center;
  padding: 10px;
}
.price-box h4 {
  line-height: 25px;
}
.pricing-package .price-box h4 {
  font-family: 'Open Sans', sans-serif;
  font-size: 23px;
  font-weight: 600;
  text-align: center;
  color: #626061;
  margin-top: -10px;
  margin-bottom: 30px;
  text-transform: uppercase;
}
.pricing-package .price-box .price {
  font-family: 'Open Sans', sans-serif;
  font-size: 40px !important;
  font-weight: 600 !important;
  color: #ff9503 !important;
  display: flex;
  line-height: 30px;
  text-align: center;
  justify-content: center;
  margin-top: -6px;
}
.subscription-details {
  font-family: 'Open Sans', sans-serif;
  font-size: 13px;
  font-weight: 600 !important;
  text-align: center;
  color: #171717;
  display: block;
  margin-top: 10px;
}
.pricing-package .feature-inner {
  padding-left: 15px;
  font-size: 13px;
  line-height: normal;
  margin-bottom: 15px;
  margin-top: 20px;
  letter-spacing: 0;
  color: #616161;
  padding: 0;
  text-align: left;
  font-family: 'Open Sans', sans-serif;
  position: relative;
}
.pricing-package .feature-inner::before {
  content: '';
  position: absolute;
  top: 0;
  left: -15px;
  width: 10px;
  height: 10px;
  background-color: #ccccd4;
  border-radius: 50%;
  margin-top: 5px;
}
.pricing-package hr {
  border: solid 1px #d1d1d1;
  margin-top: 60px !important;
  margin-bottom: 60px !important;
}
.pricing-package h2 {
  font-family: 'Open Sans', sans-serif !important;
  font-size: 24px !important;
  font-weight: 600 !important;
  color: #171717 !important;
  margin-bottom: 54px;
}
.package-option .pricing-package h2 {
  margin-bottom: 54px;
}
.pricing-package .other-package .item {
  padding-right: 5px;
  padding-left: 5px;
}
.pricing-package .other-package .item:nth-child(1) {
  order: 0;
}
.listing-box-2 {
  min-height: 100%;
  background-color: #fff;
  border: solid 1px #d1d1d1;
}
.pricing-package .item {
  margin-bottom: 32px;
}
.pricing-package .listing-box-2 {
  border-top: 10px solid #5c5c68;
  position: relative;
  padding: 42px 10px 42px 10px;
}
.pricing-package .listing-box-2 .price-box {
  position: relative;
}
.listing-box-2 .price-box {
  border-bottom: solid 1px #d1d1d1;
  margin-bottom: 30px;
}
.button-2 {
  background: #ffa600;
  color: #fff;
}
.buttons.button-2:hover {
  background: black;
  color: #fff;
}
.buttons.button-2 {
  font-size: 13px;
  font-weight: 400;
  padding: 15px 40px;
  display: inline-block;
  -webkit-transition: all 0.2s ease;
  transition: all 0.2s ease;
  overflow: hidden;
  border-radius: 2px;
  line-height: 18px;
}
.pricing-package .buttons.button-2 {
  font-family: 'Source Sans Pro', sans-serif;
  font-size: 16px;
  font-weight: bold;
  letter-spacing: 0.4px;
  margin-bottom: 33px;
  width: 100%;
  text-align: center;
  padding-left: 0;
  padding-right: 0;
  margin-top: 25px;
}
.pricing-package .price-box .price {
  font-family: 'Open Sans', sans-serif;
  font-size: 40px;
  font-weight: 600 !important;
  color: #ff9503;
  display: flex;
  text-align: center;
  justify-content: center;
  margin-top: -6px;
  line-height: 30px !important;
  margin-bottom: 20px;
}
.subscription-details {
  font-family: 'Open Sans', sans-serif;
  font-size: 13px;
  font-weight: 600 !important;
  text-align: center;
  color: #171717;
  display: block;
  margin-top: 20px;
}
.pricing-package .other-package .subscription-details {
  display: inline;
}
.price-box {
  padding: 0;
}
.listing-box .feature-inner {
  margin-left: 25px;
}
.other-package .feature-inner {
  margin-left: 15px;
}
@media (min-width: 425px) {
  #remember {
    text-align: right;
  }
}
</style>
