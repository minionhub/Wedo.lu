<template>
  <div id="page-content">
    <div id="dash-slideshow"></div>
    <div id="container" class="dash-content">
      <div id="dash-child">
        <div class="container pl-5 pr-5 mx-auto text-center">
          <div class="dash-shadow bg-white rounded">
            <div class="p-5">
              <h5 class="title">Tableau de bord</h5>
              <h2 class="title">Bienvenue {{ user.display_name }}</h2>
            </div>
          </div>
        </div>
        <div class="container mt-3 pt-5 pr-5 pl-5">
          <p class="mb-5 user">
            Détails du compte Forfait: <span>{{ main_subscription }}</span>
          </p>
          <div class="row text-center">
            <DashboardPanel
              source="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/dashboard/1.svg"
              value="Mon contenu"
              path="/my-account/my-listings"
              :visible="userRole.content"
            ></DashboardPanel>
            <DashboardPanel
              source="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/dashboard/9.svg"
              value="Ajouter nouvelle entreprise"
              path="/ajouter-votre-annonce/listing?type=company"
              :visible="userRole.company"
            ></DashboardPanel>
            <DashboardPanel
              source="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/dashboard/9.svg"
              value="Ajouter offre d'emploi"
              path="/ajouter-votre-annonce/listing?type=job_offer"
              :visible="userRole.offer"
            ></DashboardPanel>
            <DashboardPanel
              source="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/dashboard/10.svg"
              value="Ajouter promotion"
              path="/my-account/my-listings"
              :visible="userRole.sale"
            ></DashboardPanel>
            <DashboardPanel
              source="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/dashboard/10.svg"
              value="Ajouter événement"
              path="/my-account/my-listings"
              :visible="userRole.event"
            ></DashboardPanel>
            <DashboardPanel
              source="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/dashboard/5.svg"
              value="Mes adresses"
              path="/my-account/addresses"
              :visible="userRole.address"
            ></DashboardPanel>
            <DashboardPanel
              source="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/dashboard/6.svg"
              value="Mes projets"
              path="/devis/my-projects"
              :visible="userRole.project"
            ></DashboardPanel>
            <DashboardPanel
              source="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/dashboard/12.svg"
              value="Voir tous les devis"
              path="/devis/projects"
              :visible="userRole.request"
            ></DashboardPanel>
            <DashboardPanel
              source="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/dashboard/6.svg"
              value="Définir les notifications"
              path="/devis/my-profile"
              :visible="userRole.notification"
            ></DashboardPanel>
            <DashboardPanel
              source="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/dashboard/7.svg"
              value="Changer mot de passe"
              path="/my-account/edit-account"
              :visible="userRole.password"
            ></DashboardPanel>
            <DashboardPanel
              source="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/dashboard/2.svg"
              value="Détails du compte"
              path="/my-account/edit-account"
              :visible="userRole.detail"
            ></DashboardPanel>
            <DashboardPanel
              source="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/dashboard/8.svg"
              value="Déconnexion"
              :visible="userRole.logout"
            ></DashboardPanel>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="css">
@import 'assets/css/style.css';
@import 'assets/css/style.chao.css';
</style>

<script>
import DashboardPanel from '../components/DashboardPanel'
export default {
  middleware: 'auth',
  components: { DashboardPanel },
  data() {
    return {
      userRole: {
        content: false,
        quote: false,
        company: false,
        offer: false,
        sale: false,
        event: false,
        address: false,
        project: false,
        request: false,
        notification: false,
        password: false,
        detail: false,
        logout: false
      },
      main_subscription: ''
    }
  },
  mounted() {
    this.init()
    const userRole = this.user.role.toLowerCase()
    const hasProPackage = this.user.is_pro_user
    const managesCompanies = this.user.manages_companies

    this.userRole.content = true
    this.userRole.quote = true

    if (userRole === 'administrator' || managesCompanies) {
      this.userRole.company = true
      this.userRole.offer = true
      this.userRole.sale = true
      this.userRole.event = true
    }
    if (managesCompanies) this.userRole.address = true

    if (
      userRole === 'administrator' ||
      userRole === 'moderator' ||
      hasProPackage
    )
      this.userRole.request = true
    if (hasProPackage || userRole === 'administrator')
      this.userRole.notification = true

    this.userRole.password = true
    this.userRole.detail = true
    this.userRole.logout = true
  },
  methods: {
    async init() {
      this.main_subscription = (await this.$axios.$get(
        '/user/products/highest'
      )).main

      const projectsByAuthor = (await this.$axios.$post(
        '/project/published/user',
        {
          email: this.user.email
        }
      )).data
      if (projectsByAuthor.data.length > 0) this.userRole.project = true
    },
    logout() {
      this.$auth.logout()
    }
  }
}
</script>
