<template>
  <div>
    <div class="breadcrumbs py-3">
      <b-link href="/dashboard">Tableau de bord</b-link>
      <span class="separator">&gt;&gt;</span>
      <b-link class="last" href="/my-account/addresses">Mes adresses</b-link>
    </div>
    <b-row class="mb-4">
      <b-col xl="8" lg="6" class="d-flex align-items-center">
        <h2 class="desc">Mes adresses</h2>
      </b-col>
      <b-col xl="4" lg="6">
        <model-select
          v-model="companyId"
          class="company-filter"
          :options="companies"
          @input="fetchAddresses"
        ></model-select>
      </b-col>
    </b-row>
    <b-row class="addresses-wrapper">
      <b-col xl="4" lg="6">
        <div class="address-wrapper new-address">
          <b-link href="/my-account/addresses/address">
            <div class="address">
              <div class="new-link w-100">
                <h6 class="plus-sign text-center">+</h6>
                <h6 class="text-center">Add Address</h6>
              </div>
            </div>
          </b-link>
        </div>
      </b-col>
      <b-col
        v-for="address of addresses"
        :key="'address-' + address.id"
        xl="4"
        lg="6"
      >
        <div class="address-wrapper">
          <div class="address p-4">
            <div v-if="address.is_primary" class="default-mark mb-2">
              Default
            </div>
            <p class="company">{{ address.company.company_name }}</p>
            <p>{{ address.first_name + ' ' + address.last_name }}</p>
            <p>
              <span v-if="address.house_number">{{
                address.house_number + ', '
              }}</span>
              <span>{{ address.street_name }}</span>
            </p>
            <p>{{ address.country.name }}</p>
            <p>{{ address.city }}</p>
            <p>{{ address.zip }}</p>
            <div class="controls">
              <b-link :href="'/my-account/addresses/address/' + address.id"
                >Modifier</b-link
              >
              <b-link v-b-modal.modal-delete @click="addressId = address.id"
                >Supprimer</b-link
              >
              <b-link
                v-if="!address.is_primary"
                @click="setAsDefault(address.id)"
                >Faire par défaut</b-link
              >
            </div>
          </div>
        </div>
      </b-col>
    </b-row>
    <b-modal id="modal-delete" centered :hide-header="true" :hide-footer="true">
      <p class="my-4 text-center">The address will be deleted.</p>
      <b-button class="yes btn-block" @click="confirmDelete"
        >YES, Delete it.</b-button
      >
      <b-button class="no btn-block" @click="cancelDelete"
        >NO, Keep it.</b-button
      >
    </b-modal>
  </div>
</template>

<script>
export default {
  data() {
    return {
      addresses: [],
      companyId: 0,
      companies: [{ value: 0, text: 'Toutes les entreprises' }],
      addressId: 0
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    async init() {
      const companies = (await this.$axios.$get(
        '/company/user/' + this.user.id
      )).data
      companies.forEach(company => {
        this.companies.push({
          value: company.listing_id,
          text: company.company_name
        })
      })
      this.fetchAddresses()
    },
    async fetchAddresses() {
      this.addresses = (await this.$axios.$get(
        '/address/company/' + this.companyId
      )).data
    },
    async confirmDelete() {
      await this.$axios.$delete('/address/' + this.addressId)
      this.fetchAddresses()
      this.$bvModal.hide('modal-delete')
    },
    cancelDelete() {
      this.$bvModal.hide('modal-delete')
    },
    async setAsDefault(id) {
      await this.$axios.$put('/address/default/' + id)
      this.fetchAddresses()
    }
  }
}
</script>

<style>
#my-account .edit-address .desc {
  font-size: 18px;
  color: #333;
  font-family: 'Open sans', san-serif;
  font-weight: 600;
  margin-bottom: 0;
}

#my-account .edit-address .address-header span {
  font-size: 12px;
  color: #242429;
}

#my-account .edit-address .address-header a {
  color: #ffa602;
  padding: 8px 28px;
  border: none;
  background: #f3f4f5;
  border-radius: 2px;
  font-size: 13px;
  font-weight: 400;
  -webkit-transition: all 0.2s ease;
  transition: all 0.2s ease;
}

#my-account .edit-address .address-header a:hover {
  color: #fff;
  background: #ffa602;
}

#my-account .edit-address .address-body p {
  font-size: 14px;
  color: #565d62;
  margin-bottom: 0;
  font-family: 'Source Sans Pro', sans-serif;
}

#modal-delete {
  font-family: 'Open Sans', sans-serif;
  font-size: 18px;
}

#modal-delete button {
  font-size: 16px;
  font-weight: bold;
  color: white;
  padding: 15px 0;
  border: none;
  border-radius: 0;
}

#modal-delete button.yes {
  background: #5c5c68;
}

#modal-delete button.no {
  background: #ffa602;
}

#modal-delete button.no:hover {
  background: #5c5c68;
}

#modal-delete button.yes:hover {
  background: #ffa602;
}

@media (min-width: 576px) {
  .modal-dialog {
    max-width: 350px;
  }
}
</style>
