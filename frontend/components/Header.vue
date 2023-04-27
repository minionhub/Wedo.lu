<template>
  <div id="header-wrapper" class="fixed-top">
    <cookies-notice
      v-if="this.cookie !== 'wedo-cookie'"
      class="m-0 p-0"
      style="border: 0"
    ></cookies-notice>
    <b-navbar
      id="header"
      toggleable="lg"
      type="white"
      variant="light"
      class="navbar navbar-light bg-light to bg-white"
      style="font-size: small; font-family: 'source sans pro',sans-serif; height: 89px;"
    >
      <div class="d-flex" style="align-items: center;">
        <b-link class="hamburger mobile px-2" @click="showMenu = true">
          <v-icon name="bars"></v-icon>
        </b-link>
        <b-navbar-brand id="header_logo" href="/">
          <b-img
            class="p-2"
            src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/logo.svg"
            alt="logo"
          />
        </b-navbar-brand>
      </div>
      <div
        class="mobile menu bg-white d-block"
        :class="showMenu ? 'show' : null"
      >
        <div
          class="w-100 p-3 border-bottom"
          style="height: fit-content;"
          @click="showMenu = false"
        >
          <v-icon name="times" scale="2"></v-icon>
        </div>
        <div class="w-100">
          <b-link class="d-block p-3" href="/devis">Demander un devis</b-link>
          <b-link class="d-block p-3" href="/annuaire-des-artisans">
            Trouver un pro
          </b-link>
          <b-link class="d-block p-3" href="/jobboard">Offres d’emploi</b-link>
          <b-link class="d-block p-3" href="/blog">Conseils</b-link>
        </div>
      </div>
      <b-collapse
        id="nav-collapse"
        class="desktop"
        style="background-color: #ffffff"
        is-nav
      >
        <b-navbar-nav>
          <b-nav-form>
            <div
              class="row my-auto nav-search ml-5"
              style="white-space: nowrap"
            >
              <b-img
                src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/baseline-search-24px.svg"
                width="20px"
                style="color: #1d1d23"
                alt="search"
                @click.prevent="searchCompany"
              />
              <input
                v-model="query"
                class="form-control col-auto pl-2"
                type="search"
                placeholder="Que cherchez-vous?"
                style="font-size: 12px; line-height: 18px; font-weight: 400; font-family: 'source sans pro', sans-serif; border: none; color: #1d1d23"
                aria-label="Search"
                @keydown.enter.prevent="searchCompany"
              />
            </div>
          </b-nav-form>
        </b-navbar-nav>
        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <ul class="navbar-nav ml-auto" style="white-space:nowrap;">
            <li class="nav-item my-auto">
              <b-link class="nav-link" href="/devis" style="color: #484848"
                >Demander un devis</b-link
              >
            </li>
            <li class="nav-item my-auto">
              <b-link
                class="nav-link"
                href="/annuaire-des-artisans"
                style="color: #484848"
              >
                Trouver un pro
              </b-link>
            </li>
            <li class="nav-item my-auto">
              <b-link class="nav-link" href="/jobboard" style="color: #484848"
                >Offres d'emploi</b-link
              >
            </li>
            <li class="nav-item my-auto">
              <b-link class="nav-link" href="/blog" style="color: #242429"
                >Conseils</b-link
              >
            </li>
            <li v-if="!user" class="nav-item my-auto flex-list">
              <ul class="list-unstyled" style="padding: 0px">
                <li style="padding: 0px; margin-right: 0px">
                  <b-link
                    class="nav-link"
                    href="/my-account"
                    style="color: #484848; font-size: 13px"
                  >
                    <b-img
                      src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/baseline-perm_identity-24px.svg"
                      class="align-middle"
                      style="font-size: 1.2vw;"
                      alt="identity"
                    />
                    Connectez-vous</b-link
                  >
                </li>
                <li style="padding: 1px; margin-right: 0px">
                  <b-link
                    class="nav-link"
                    href="/my-account"
                    style="color: #484848"
                  >
                    S'inscrire
                  </b-link>
                </li>
              </ul>
            </li>
            <li
              v-if="user"
              class="nav-item my-auto p-0"
              style="margin-right: 0; padding-right: 0;"
            >
              <b-dropdown
                size="lg"
                variant="link"
                toggle-class="dd-toggle"
                class="custom-dd"
                no-caret
              >
                <template slot="button-content">
                  <b-img
                    id="useravatar"
                    width="32px"
                    src="https://secure.gravatar.com/avatar/628967d7b30a16f52270c24a75e30ac6?s=96&d=mm&r=g"
                    style="border-radius: 50%; margin-right: 5px;"
                  ></b-img>
                  {{ user.display_name }}
                </template>
                <b-dropdown-item href="/dashboard">
                  Tableau de Bord
                </b-dropdown-item>
                <b-dropdown-item href="/my-account">Mon compte</b-dropdown-item>
                <b-dropdown-item href="/my-account/my-listings">
                  Mon contenu
                </b-dropdown-item>
                <b-dropdown-item href="/my-account/subscriptions">
                  Mes forfaits
                </b-dropdown-item>
                <b-dropdown-item href="/my-account/addresses">
                  Mes adresses
                </b-dropdown-item>
                <b-dropdown-item href="/my-account/edit-account">
                  Détails du compte
                </b-dropdown-item>
                <b-dropdown-item @click.prevent="logout">
                  Déconnexion
                </b-dropdown-item>
              </b-dropdown>
            </li>
            <li
              class="nav-item my-auto p-0"
              style="margin-right: 0; padding-right: 0"
            >
              <language-selector></language-selector>
            </li>
            <li class="nav-item my-auto">
              <b-link href="/ajouter-votre-annonce">
                <button
                  class="btn pt-3 pb-3 pr-4 pl-4 text-white button btn-secondary btn-lg"
                >
                  <svg class="svg-whitecircle" viewBox="0 0 100 100">
                    <circle
                      cx="50"
                      cy="50"
                      r="35"
                      fill="none"
                      stroke-width="8"
                    ></circle>
                    <line
                      x1="32.5"
                      y1="50"
                      x2="67.5"
                      y2="50"
                      stroke-width="8"
                    ></line>
                    <line
                      x1="50"
                      y1="32.5"
                      x2="50"
                      y2="67.5"
                      stroke-width="8"
                    ></line></svg
                  >Inscription artisan
                </button>
              </b-link>
            </li>
          </ul>
        </b-navbar-nav>
      </b-collapse>
      <div class="mobile">
        <b-link v-if="!user" class="nav-link" href="/my-account">
          <b-img
            src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/baseline-perm_identity-24px.svg"
            style="width: 30px;"
            alt="identity"
          />
        </b-link>

        <b-dropdown
          v-if="user"
          size="lg"
          variant="link"
          class="custom-dd-m"
          no-caret
        >
          <template slot="button-content">
            <b-img
              id="useravatarmobile"
              src="https://secure.gravatar.com/avatar/628967d7b30a16f52270c24a75e30ac6?s=96&d=mm&r=g"
              style="border-radius: 50%; margin-right: 5px;"
            ></b-img>
          </template>
          <b-dropdown-item href="/dashboard">Tableau de Bord</b-dropdown-item>
          <b-dropdown-item href="/my-account">Mon compte</b-dropdown-item>
          <b-dropdown-item href="/my-account/my-listings">
            Mon contenu
          </b-dropdown-item>
          <b-dropdown-item href="/my-account/my-bookmarks">
            Favoris
          </b-dropdown-item>
          <b-dropdown-item href="/my-account/subscriptions">
            Abonnements
          </b-dropdown-item>
          <b-dropdown-item href="/my-account/addresses">
            Adresses
          </b-dropdown-item>
          <b-dropdown-item href="/my-account/edit-account">
            Détails du compte
          </b-dropdown-item>
          <b-dropdown-item href="#" @click.prevent="logout">
            Déconnexion
          </b-dropdown-item>
        </b-dropdown>

        <language-selector></language-selector>
        <b-link class="nav-link" href="/ajouter-votre-annonce">
          <b-img
            src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/baseline-add_circle_outline-24px.svg"
            style="width: 30px;"
            alt="add"
          />
        </b-link>
      </div>
    </b-navbar>
  </div>
</template>
<script>
import Icon from 'vue-awesome/components/Icon'
import 'vue-awesome/icons/bars'
import 'vue-awesome/icons/times'
import LanguageSelector from '../components/LanguageSelector'
import CookiesNotice from './CookiesNotice'
export default {
  name: 'Header',
  components: {
    'v-icon': Icon,
    'language-selector': LanguageSelector,
    'cookies-notice': CookiesNotice
  },
  data() {
    this.cookie = this.$cookies.get('wedo-cookie')
    return {
      showMenu: false,
      query: ''
    }
  },
  methods: {
    logout() {
      this.$auth.logout()
    },
    searchCompany() {
      if (typeof this.query === 'undefined' || this.query === '') return
      this.$router.push({
        path: '/annuaire-2',
        query: { search_keywords: this.query }
      })
    }
  }
}
</script>
<style lang="css">
@import 'assets/css/style.css';
@import 'assets/css/style.chao.css';
@import 'assets/css/header.css';

.navbar {
  width: 100%;
  z-index: 999;
}
#header-wrapper {
  width: 100%;
}
@media (max-width: 360px) {
  #useravatarmobile {
    width: 28px;
  }
}
@media (min-width: 361px) {
  #useravatarmobile {
    width: 32px;
  }
}
.svg-whitecircle {
  height: 20px;
  padding-right: 4px;
  margin-top: -1px;
  stroke: white;
}
.btn-lg {
  padding-top: 13px !important;
  padding-right: 40px !important;
  padding-bottom: 13px !important;
  padding-left: 35px !important;
  font-size: 13px !important;
  font-weight: 400 !important;
}
</style>
