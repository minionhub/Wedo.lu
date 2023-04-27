<template>
  <div id="my-account">
    <div class="content w-100">
      <b-container class="py-5">
        <b-row v-if="errorMsg">
          <b-col>
            <p
              class="d-flex align-items-center justify-content-left p-2 edit-account-error"
            >
              <v-icon name="exclamation-circle" class="mr-3"></v-icon>
              <b>
                ERREUR: &nbsp;
              </b>
              {{ errorMsg }}
            </p>
          </b-col>
        </b-row>
        <b-row v-else-if="successMsg">
          <b-col>
            <p
              class="d-flex align-items-center justify-content-left p-2 edit-account-success"
            >
              <v-icon name="check-circle" class="mr-3"></v-icon>
              {{ successMsg }}
            </p>
          </b-col>
        </b-row>
        <b-row>
          <b-col md="4" lg="3" class="sidebar-wrapper">
            <Sidebar></Sidebar>
          </b-col>
          <b-col md="8" lg="9" class="px-5 pb-5 edit-account">
            <div class="breadcrumbs py-3">
              <b-link href="/dashboard">Tableau de bord</b-link>
              <span class="separator">&gt;&gt;</span>
              <b-link class="last" href="/my-account/addresses"
                >Détails du compte</b-link
              >
            </div>
            <p class="sub-title mb-3">Détails du compte</p>
            <b-row>
              <b-col>
                <WedoInput
                  id="first-name"
                  label="Prénom *"
                  type="text"
                  :value="user.first_name"
                ></WedoInput>
              </b-col>
              <b-col>
                <WedoInput
                  id="last-name"
                  label="Nom *"
                  type="text"
                  :value="user.last_name"
                ></WedoInput>
              </b-col>
            </b-row>
            <b-row>
              <b-col md="6">
                <WedoInput
                  id="email"
                  label="Adresse de messagerie *"
                  type="text"
                  :value="user.email"
                ></WedoInput>
              </b-col>
            </b-row>

            <hr />
            <p>Changement de mot de passe</p>
            <form @submit.prevent="changePassword">
              <b-row>
                <b-col md="6">
                  <WedoInput
                    v-model="passwordForm.currentPassword"
                    v-validate="{ required: true }"
                    :error="errors.first('currentPassword')"
                    label="Mot de passe actuel (laisser vide pour le conserver)"
                    type="password"
                    name="Current password"
                  ></WedoInput>
                </b-col>
              </b-row>
              <b-row>
                <b-col md="6">
                  <WedoInput
                    v-model="passwordForm.newPassword"
                    v-validate="{
                      required: true,
                      is: passwordForm.newPasswordConfirm,
                      min: 12,
                      max: 50,
                      regex: /^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/
                    }"
                    :error="errors.first('newPassword')"
                    label="Nouveau mot de passe (laisser vide pour conserver l’actuel)"
                    type="password"
                    name="New password"
                  ></WedoInput>
                </b-col>
                <b-col md="6">
                  <WedoInput
                    v-model="passwordForm.newPasswordConfirm"
                    v-validate="{
                      required: true,
                      is: passwordForm.newPassword,
                      min: 12,
                      max: 50,
                      regex: /^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/
                    }"
                    :error="errors.first('confirmPassword')"
                    label="Confirmer le nouveau mot de passe"
                    type="password"
                    name="Confirm new password"
                  ></WedoInput>
                </b-col>
              </b-row>

              <b-row>
                <b-col md="6" class="mt-4">
                  <WedoButton
                    class="btn-block"
                    value="Enregistrer les modifications"
                    :disabled="errors.any()"
                  ></WedoButton>
                </b-col>
              </b-row>
            </form>
          </b-col>
        </b-row>
      </b-container>
    </div>
  </div>
</template>

<script>
import Icon from 'vue-awesome/components/Icon'
import 'vue-awesome/icons/exclamation-circle'
import 'vue-awesome/icons/check-circle'
import Sidebar from '~/components/my-account/Sidebar.vue'
import WedoInput from '~/components/WedoInput.vue'
import WedoButton from '~/components/WedoButton.vue'

export default {
  middleware: 'auth',
  components: {
    Sidebar,
    WedoInput,
    WedoButton,
    'v-icon': Icon
  },
  data: function() {
    return {
      title: 'Détails du compte',
      passwordForm: {
        currentPassword: '',
        newPassword: ''
      },
      successMsg: null,
      errorMsg: null
    }
  },
  methods: {
    changePassword() {
      this.$validator.validateAll().then(async () => {
        if (!this.errors.any()) {
          try {
            await this.$axios
              .$put('password', {
                currentPassword: this.passwordForm.currentPassword,
                newPassword: this.passwordForm.newPassword
              })
              .then(response => {
                if (response.status) {
                  this.errorMsg = null
                  this.successMsg =
                    'Les détails du compte ont bien été modifiés.'
                  this.passwordForm.currentPassword = ''
                  this.passwordForm.newPassword = ''
                  this.passwordForm.newPasswordConfirm = ''
                }
              })
          } catch (e) {
            this.successMsg = null
            this.errorMsg = 'Veillez saisir votre mot de passe actuel valide.'
          }
        }
      })
    }
  }
}
</script>

<style>
@import 'assets/css/my-account.css';

#my-account .edit-account p {
  color: #333;
  font-size: 13px;
  font-weight: 500;
  margin: 5px 0;
}

#my-account .edit-account-error {
  font-size: 14px;
  color: #515151;
  font-family: 'Source Sans Pro', sans-serif;
  border-top: 3px solid #ff5a61 !important;
  border-bottom: 1px solid lightgrey !important;
  margin-bottom: 0px;
}

#my-account .edit-account-success {
  font-size: 14px;
  color: #515151;
  font-family: 'Source Sans Pro', sans-serif;
  border-top: 3px solid rgb(0, 153, 0) !important;
  border-bottom: 1px solid lightgrey !important;
  margin-bottom: 0px;
}

#my-account .edit-account-error .fa-icon {
  color: #ff5a61;
}

#my-account .edit-account-success .fa-icon {
  color: rgb(0, 153, 0);
}
</style>
