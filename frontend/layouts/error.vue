<template>
  <div class="container p-5" style="margin-top: 100px;">
    <div v-if="error.statusCode === 404">
      <div class="col-md-12">
        <div class="container-fluid">
          <div class="row justify-content-md-center">
            <p class="icon">
              <v-icon scale="3" name="mood_bad" />
            </p>
          </div>
          <div class="row mt-1 justify-content-md-center">
            <p class="message">
              Erreur 404: La page que vous cherchez n'est pas disponible.
            </p>
          </div>
          <div class="row pt-1 justify-content-md-center">
            <b-link href="/">
              <w-button value="Retour à l'accueil"></w-button>
            </b-link>
          </div>
        </div>
      </div>
    </div>
    <div v-else>An error occurred</div>
  </div>
</template>

<script>
import 'vue-awesome-material-icons/icons'
import Icon from 'vue-awesome/components/Icon'
import WedoButton from '../components/WedoButton'

export default {
  components: {
    'v-icon': Icon,
    'w-button': WedoButton
  },
  props: {
    error: {
      type: Object,
      default: function() {
        return {}
      }
    }
  }
}
</script>

<style>
.icon {
  color: #c4c4c4c4;
}

.message {
  color: #565d62;
  font-size: 12px;
  line-height: 17px;
  font-weight: 400;
  font-family: 'Source Sans Pro', sans-serif;
}

.container-fluid {
  padding-top: 150px;
  padding-bottom: 150px;
}
</style>
