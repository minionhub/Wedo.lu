<template>
  <div class="address-form">
    <div class="breadcrumbs py-3">
      <b-link href="/dashboard">Tableau de bord</b-link>
      <span class="separator">&gt;&gt;</span>
      <b-link href="/my-account/addresses">Mes adresses</b-link>
      <span class="separator">&gt;&gt;</span>
      <b-link class="last">{{ title }}</b-link>
    </div>
    <form class="edit-address-billing" @submit.prevent="submit">
      <p class="sub-title mb-3">{{ title }}</p>
      <div class="wedo-select">
        <legend>Nom de l’entreprise</legend>
        <model-select
          v-model="address.company_id"
          v-validate="{ required: true }"
          :options="companies"
          name="company"
        >
        </model-select>
        <div
          v-if="errors.first('company')"
          class="w-100 text-danger validate-msg"
        >
          <span>{{ errors.first('company') }}</span>
        </div>
      </div>
      <hr />
      <b-row>
        <b-col>
          <WedoInput
            v-model="address.first_name"
            v-validate="{ required: true }"
            name="first_name"
            label="Prénom *"
            type="text"
            :error="errors.first('first_name')"
          ></WedoInput>
        </b-col>
        <b-col>
          <WedoInput
            v-model="address.last_name"
            v-validate="{ required: true }"
            name="last_name"
            label="Nom *"
            type="text"
            :error="errors.first('last_name')"
          ></WedoInput>
        </b-col>
      </b-row>
      <hr />
      <div class="wedo-select">
        <legend>Pays *</legend>
        <model-select
          v-model="address.country_id"
          v-validate="{ required: true }"
          :options="countries"
          name="country"
        >
        </model-select>
        <div
          v-if="errors.first('country')"
          class="w-100 text-danger validate-msg"
        >
          <span>{{ errors.first('country') }}</span>
        </div>
      </div>
      <b-row>
        <b-col>
          <WedoInput
            v-model="address.house_number"
            label="Numéro"
            type="text"
          ></WedoInput>
        </b-col>
        <b-col>
          <WedoInput
            v-model="address.street_name"
            v-validate="{ required: true }"
            name="street_name"
            label="Nom de la rue *"
            type="text"
            :error="errors.first('street_name')"
          ></WedoInput>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <WedoInput
            v-model="address.city"
            v-validate="{ required: true }"
            name="city"
            label="Ville *"
            type="text"
            :error="errors.first('city')"
          ></WedoInput>
        </b-col>
        <b-col>
          <WedoInput
            v-model="address.zip"
            v-validate="{ required: true }"
            name="postal_code"
            label="Code postal *"
            type="text"
            :error="errors.first('postal_code')"
          ></WedoInput>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <WedoInput
            v-model="address.phone"
            v-validate="{ required: true }"
            name="phone"
            label="Téléphone *"
            type="text"
            :error="errors.first('phone')"
          ></WedoInput>
        </b-col>
        <b-col>
          <WedoInput
            v-model="address.email"
            v-validate="{ required: true, email: true }"
            name="email"
            label="Adresse de messagerie *"
            type="text"
            :error="errors.first('email')"
          ></WedoInput>
        </b-col>
      </b-row>

      <b-row>
        <b-col md="6" class="mt-4">
          <WedoButton
            :disabled="errors.any()"
            class="btn-block"
            value="Sauvegarder l’adresse"
          ></WedoButton>
        </b-col>
      </b-row>
    </form>
  </div>
</template>

<script>
import WedoInput from '~/components/WedoInput.vue'
import WedoButton from '~/components/WedoButton.vue'
// import WedoSelect from '~/components/WedoSelect.vue'
// import WedoCheckbox from '~/components/WedoCheckbox.vue'

export default {
  components: {
    WedoInput,
    WedoButton
    // WedoSelect,
    // WedoCheckbox
  },
  data() {
    return {
      title: '',
      address: {},
      companies: [],
      countries: []
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
      const countries = (await this.$axios.$get('/country')).data
      companies.forEach(company => {
        this.companies.push({
          value: company.listing_id,
          text: company.company_name
        })
      })
      countries.forEach(country => {
        this.countries.push({ value: country.id, text: country.name })
      })

      if (this.$route.params.id) {
        this.title = "Modifier l'adresse"
        this.address = (await this.$axios.$get(
          '/address/' + this.$route.params.id
        )).data
      } else {
        this.title = 'Add new address'
      }
    },
    submit() {
      this.$validator.validateAll().then(async () => {
        if (!this.errors.any()) {
          try {
            if (this.$route.params.id) {
              await this.$axios.$put('/address', this.address)
            } else {
              this.address.user_id = this.user.id
              await this.$axios.$post('/address', this.address)
            }
            this.$router.push({ path: '/my-account/addresses' })
          } catch (e) {}
        }
      })
    }
  }
}
</script>

<style>
#my-account .edit-address-billing p {
  color: #333;
  font-size: 13px;
  font-weight: 500;
  margin: 5px 0;
}

#my-account .checkbox-wrapper label {
  position: relative;
  padding-left: 25px;
}

#my-account .checkbox-wrapper label input {
  position: absolute;
  top: 8px;
  left: 0;
}

#my-account .checkbox-wrapper label span {
  font-size: 12px;
  font-weight: 700;
  font-family: 'Source Sans Pro', sans-serif;
}

.wedo-select {
  margin-bottom: 25px;
}

.wedo-select .selection.dropdown,
.wedo-select input.search,
.wedo-select .item {
  line-height: 18px !important;
  padding: 14px 0 !important;
  color: #1d1d23 !important;
  font-size: 12px !important;
  border-radius: 0 !important;
  -webkit-transition: padding 0.25s ease-in-out;
  transition: padding 0.25s ease-in-out;
  border: none !important;
  border-bottom: 1px solid rgba(0, 0, 0, 0.25) !important;
  background: transparent !important;
}

.wedo-select .item {
  border: none !important;
}

.wedo-select .ui.dropdown .menu > .item:hover {
  background: #ffa602 !important;
  color: #fff !important;
}

.wedo-select i.dropdown.icon {
  padding: 0.8em 0 !important;
  font-size: 16px !important;
  color: #ffa602 !important;
}

.wedo-select legend {
  font-family: 'Source Sans Pro', sans-serif;
  margin-bottom: 5px;
  line-height: 2;
  color: #565662;
  padding-bottom: 0;
  font-size: 12px;
  font-weight: 700;
}

.validate-msg {
  font-size: 13px;
  padding: 5px;
}
</style>
