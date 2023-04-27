<template>
  <b-container id="reset-pwd" class="py-5">
    <b-row>
      <b-col lg="10" class="custom-card mx-auto">
        <div class="heading mb-4">
          <i class="material-icons mr-3">lock_outline</i>
          Réinitialisez votre mot de passe
        </div>
        <div class="body">
          <p v-if="errorMsg" class="alert warning p-4 mb-4">
            <i class="fa fa-exclamation-circle mr-3"></i>
            {{ errorMsg }}
          </p>
          <p>Saisissez un nouveau mot de passe ci-dessous.</p>
          <form @submit.prevent="resetPwd">
            <b-row>
              <b-col lg="6">
                <WedoInput
                  ref="password"
                  v-model="form.password"
                  v-validate="{
                    required: true,
                    max: 50,
                    regex: /^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/
                  }"
                  name="password"
                  type="password"
                  :error="errors.first('password')"
                  label="Nouveau mot de passe *"
                ></WedoInput>
              </b-col>
              <b-col lg="6">
                <WedoInput
                  v-model="form.password_confirmation"
                  v-validate="'required|confirmed:password'"
                  label="Ressaisissez le nouveau mot de passe *"
                  name="password_confirmation"
                  type="password"
                  data-vv-as="password"
                  :error="errors.first('password_confirmation')"
                ></WedoInput>
              </b-col>
            </b-row>
            <WedoButton
              :disabled="errors.any()"
              value="Enregistrer"
              class="w-100"
            ></WedoButton>
          </form>
        </div>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import WedoInput from '~/components/WedoInput'
import WedoButton from '~/components/WedoButton'

export default {
  validate({ query }) {
    return query.email && query.token
  },
  components: {
    WedoButton,
    WedoInput
  },
  data: () => ({
    status: '',
    form: {
      token: '',
      email: '',
      password: '',
      password_confirmation: ''
    },
    errorMsg: ''
  }),

  created() {
    this.form.email = this.$route.query.email
    this.form.token = this.$route.query.token
  },

  methods: {
    resetPwd() {
      this.$validator.validateAll().then(async () => {
        if (!this.errors.any()) {
          try {
            const { data } = await this.$axios.post(
              '/password/reset',
              this.form
            )
            this.status = data.status
            if (this.status === 'success') {
              localStorage.setItem('resetPwd', 'success')
              this.$router.push({
                path: '/my-account'
              })
            }
          } catch (e) {
            this.errorMsg =
              'Cette clé n’est pas valide ou a déjà été utilisée. Veuillez réinitialiser votre mot de passe si nécessaire.'
          }
        }
      })
    }
  }
}
</script>

<style>
#reset-pwd {
  margin-top: 90px;
}

#reset-pwd .heading {
  font-family: 'Open Sans', sans-serif;
  font-weight: 400 !important;
  font-size: 12px;
  display: flex;
  align-items: center;
}

#reset-pwd .heading i {
  width: 35px;
  height: 35px;
  border-radius: 50%;
  color: #fff;
  background: #ffa602;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

#reset-pwd .custom-card {
  background: #fff;
  padding: 20px;
  border: 1px solid;
  border-color: #e5e6e9 #dfe0e4 #d0d1d5;
  transition: box-shadow 0.25s ease-in-out, -webkit-box-shadow 0.25s ease-in-out;
}

#reset-pwd .custom-card:hover {
  box-shadow: 0 5px 33px rgba(0, 0, 0, 0.07);
}

#reset-pwd p {
  font-size: 13px;
  line-height: 24px;
  color: #565d62;
}

.validate-msg {
  font-size: 13px;
  padding: 5px;
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

@media (min-width: 1200px) {
  .container {
    width: 1170px;
  }
}
</style>
