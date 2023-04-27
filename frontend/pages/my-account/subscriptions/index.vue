<template>
  <div id="my-account">
    <div class="content w-100">
      <b-container class="py-5">
        <b-row>
          <b-col md="4" lg="3" class="sidebar-wrapper">
            <Sidebar></Sidebar>
          </b-col>
          <b-col md="8" lg="9" class="px-5 pb-5 my-listings bg-white">
            <div class="breadcrumbs py-3">
              <b-link href="/dashboard">Dashboard</b-link>
              <span class="separator">&gt;&gt;</span>
              <b-link class="last" href="/my-account/subscriptions"
                >Mes forfaits</b-link
              >
            </div>
            <div class="account-content my-content">
              <table class="table-block job-manager-jobs subscription">
                <thead>
                  <tr>
                    <th v-if="show_company">Société</th>
                    <th>Forfait</th>
                    <th class="job_title">Statut</th>
                    <th class="listing_type">Prochain paiement</th>
                    <th class="date">Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in subscriptions" :key="index">
                    <td v-if="show_company" data-title="Société">
                      {{ item.company_name }}
                    </td>
                    <td data-title="Forfait">{{ item.product_name }}</td>
                    <td data-title="Statut">{{ formatStatus(item.status) }}</td>
                    <td data-title="Prochain paiement">
                      {{ formatExpires(item.expires) }}
                    </td>
                    <td data-title="Total">
                      {{ item.product_price }} € /
                      {{ formatCycle(item.product_cycle) }}
                    </td>
                    <td class="order-actions">
                      <a class="button view" href="#">Affichage</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </b-col>
        </b-row>
      </b-container>
    </div>
  </div>
</template>
<script>
import Sidebar from '~/components/my-account/Sidebar.vue'
export default {
  middleware: 'auth',
  components: {
    Sidebar
  },
  data: function() {
    return {
      subscriptions: [],
      companies: [],
      show_company: false
    }
  },
  mounted() {
    this.getAllSubscriptions()
    this.getAllCompanies()
  },
  methods: {
    async getAllSubscriptions() {
      this.subscriptions = (await this.$axios.$get('/user/products/main/')).main
    },
    async getAllCompanies() {
      this.companies = (await this.$axios.$get(
        '/user/companies/' + this.user.id
      )).companies_ids
      if (this.companies.length > 1) {
        this.show_company = true
      } else {
        this.show_company = false
      }
    },
    formatStatus(val) {
      if (val === 1) return 'Actif'
      else return 'Inactive'
    },
    formatExpires(val) {
      if (val === null) return '-'
      return val
    },
    formatCycle(val) {
      if (val === 12) return 'Année'
      else return 'Mois'
    }
  }
}
</script>
<style>
@import 'assets/css/my-account.css';
.subscription tbody tr .button {
  padding: 8px 28px;
  color: #ffa602;
  background: #f3f4f5 !important;
  border-radius: 2px;
  border: none;
}
@media screen and (max-width: 768px) {
  .subscription thead {
    display: none;
  }
  .subscription tr {
    display: block;
  }
  .subscription tr td {
    display: block;
    text-align: right !important;
  }
  .subscription tr td::before {
    content: attr(data-title) ': ';
    font-weight: 700;
    float: left;
  }
  .subscription tr td.order-actions {
    text-align: center !important;
  }
  .subscription tr td.order-actions::before {
    content: '';
  }
  .subscription tr td.order-actions .button {
    float: none;
    margin: 0.125em 0.25em 0.125em 0;
    display: block;
  }
}
</style>
