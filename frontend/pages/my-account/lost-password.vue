<template>
  <div class="woocommerce">
    <section class="i-section">
      <b-container>
        <b-row class="section-body reveal reveal_visible">
          <b-col lg="10" offset-lg="1">
            <div class="element">
              <div class="pf-head round-icon">
                <div class="title-style-1">
                  <i class="material-icons">lock_outline</i>
                  <h5>Mot de passe oublié ?</h5>
                </div>
              </div>
              <div v-if="!status" class="pf-body">
                <p v-if="errorMsg" class="alert warning p-4 mb-4">
                  <i class="fa fa-exclamation-circle mr-3"></i>
                  {{ errorMsg }}
                </p>
                <b-form
                  data-vv-scope="form"
                  class="lost_reset_password"
                  @submit.prevent="sendEmail"
                >
                  <p>
                    Mot de passe perdu&nbsp;? Veuillez saisir votre identifiant
                    ou votre adresse e-mail. Vous recevrez un lien par e-mail
                    pour créer un nouveau mot de passe.
                  </p>
                  <div class="form-row">
                    <label for="user_login">Identifiant ou e-mail</label>
                    <b-form-input
                      v-model="form.email"
                      v-validate="{ required: true, email: true }"
                      name="email"
                      class="input-text"
                    ></b-form-input>
                    <div class="w-100 text-danger validate-msg">
                      <span>{{ errors.first('form.email') }}</span>
                    </div>
                  </div>
                  <p class="form-row">
                    <button
                      :disabled="errors.any('form')"
                      type="submit"
                      class="button"
                    >
                      Réinitialisation du mot de passe
                    </button>
                  </p>
                  <div class="clear"></div>
                </b-form>
              </div>
              <div v-else class="pf-body">
                <p class="alert success p-4 mb-5">
                  <i class="fa fa-check-circle mr-3"></i>
                  L’e-mail de réinitialisation du mot de passe a été envoyé.
                </p>
                <p>
                  Un e-mail de réinitialisation de mot de passe a été envoyé à
                  l’adresse e-mail de votre compte, mais cela peut prendre
                  plusieurs minutes avant qu’il ne s’affiche dans votre boîte de
                  réception. Veuillez patienter au moins 10 minutes avant de
                  tenter une autre réinitialisation.
                </p>
              </div>
            </div>
          </b-col>
        </b-row>
      </b-container>
    </section>
  </div>
</template>

<script>
export default {
  data() {
    return {
      status: false,
      form: {
        email: ''
      },
      errorMsg: ''
    }
  },
  methods: {
    sendEmail() {
      this.$validator.validateAll('form').then(async () => {
        if (!this.errors.any()) {
          try {
            this.status =
              (await this.$axios.post('/password/email', this.form)).data
                .status === 'success'
          } catch (e) {
            this.errorMsg = 'Identifiant ou e-mail non valide.'
          }
        }
      })
    }
  }
}
</script>

<style>
@import 'assets/css/style.account.css';
p {
  font-family: 'Open Sans', 'Poppins', sans-serif;
}
.form-row {
  margin-right: 0;
  margin-left: 0;
}
label {
  max-width: 100%;
  margin-bottom: 5px;
  font-weight: 700;
  font-family: 'Source Sans Pro', sans-serif !important;
}
.woocommerce input,
.woocommerce textarea {
  width: 100%;
  display: block;
  border: none;
  resize: none;
  line-height: 18px;
  background-color: transparent;
  padding: 14px 0;
  color: #1d1d23;
  outline: none;
  font-size: 12px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.25) !important;
  -webkit-transition: padding 0.25s ease-in-out;
  transition: padding 0.25s ease-in-out;
}
.woocommerce input:focus,
.woocommerce textarea:focus {
  border-color: #ffa602 !important;
  box-shadow: 0px 1px 0px 0px #ffa602 !important;
  padding-left: 5px;
}
.form-control {
  display: block;
  width: 100%;
  height: calc(1.5em + 0.75rem + 2px);
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.form-row button {
  color: white;
  font-size: 13px;
  font-weight: 400;
  padding: 15px 40px;
  -webkit-transition: all 0.2s ease;
  transition: all 0.2s ease;
  overflow: hidden;
  border-radius: 2px;
  line-height: 16px;
  display: block;
  float: left;
  width: 100%;
  border: none;
}
.round-icon .title-style-1 i {
  background: #ffa602;
}

p.alert {
  background: #f7f6f7;
  color: #515151;
  display: flex;
  align-items: center;
}

p.warning {
  border-top: 3px solid #ff5a61;
}

p.success {
  border-top: 3px solid #3bbdb6;
}

p.warning i {
  color: #ff5a61;
  font-size: 15px;
}

p.success i {
  color: #3bbdb6;
  font-size: 15px;
}
</style>
