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
              <b-link href="/dashboard">Tableau de bord</b-link>
              <span class="separator">&gt;&gt;</span>
              <b-link class="last" href="/my-account/my-listings"
                >Mon contenu</b-link
              >
            </div>
            <div class="account-content my-content">
              <table class="table-block job-manager-jobs">
                <thead>
                  <tr>
                    <th class="list_logo">photo</th>
                    <th class="job_title">Nom</th>
                    <th class="listing_type">Type de listing</th>
                    <th class="date">Date de publication</th>
                    <!-- <th class="expires text-center">Listing Expires</th> -->
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(listing, index) of listings" :key="index">
                    <td class="list_logo">
                      <img
                        :src="listing.data.logo_img"
                        width="32"
                        height="32"
                      />
                    </td>
                    <td class="job_title">
                      <a href="#">
                        {{ listing.data.title }}
                      </a>
                      <ul class="job-dashboard-actions">
                        <li>
                          <a
                            :href="
                              '/my-account/my-listings/listing?type=' +
                                listing.listing_type +
                                '&id=' +
                                listing.listing_id
                            "
                            class="job-dashboard-action-edit"
                            >Edit</a
                          >
                        </li>
                        <li>
                          <a href="#" class="job-dashboard-action-delete">
                            Delete
                          </a>
                        </li>
                      </ul>
                    </td>
                    <td class="listing_type">
                      {{ listingTypes[listing.listing_type] }}
                    </td>
                    <td class="date text-capitalize">
                      {{ formatDate(listing.data.created_at) }}
                    </td>
                    <!-- <td class="expires text-center text-capitalize">
                    {{ listing.expireAt }}
                  </td> -->
                  </tr>
                </tbody>
              </table>

              <!-- Pagination -->
              <div class="mt-3">
                <b-pagination
                  v-model="currentPage"
                  :total-rows="totalRows"
                  :per-page="perPage"
                  align="center"
                  :hide-goto-end-buttons="true"
                  @change="onChangePage"
                >
                  <i slot="prev-text" class="material-icons">chevron_left</i>
                  <i slot="next-text" class="material-icons">chevron_right</i>
                </b-pagination>
              </div>
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
      title: 'Mon contenu',
      listings: [],
      listingTypes: {
        company: 'Company',
        job_offer: 'Job Offer',
        event: 'Event',
        promotion: 'Promotion'
      },
      currentPage: 1,
      totalRows: 100,
      perPage: 21
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    async init() {
      const response = (await this.$axios.$get(
        '/listing/user?page=' + this.currentPage
      )).listings
      this.listings = response.data
      this.totalRows = response.total
      this.perPage = response.per_page
    },
    formatDate(date) {
      if (date === null || typeof date === 'undefined') return '-'
      date = new Date(date)
      const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      }
      return date.toLocaleDateString('fr-fr', options)
    },
    onChangePage(page) {
      this.currentPage = page
      this.init()
    }
  }
}
</script>

<style>
@import 'assets/css/my-account.css';
</style>
