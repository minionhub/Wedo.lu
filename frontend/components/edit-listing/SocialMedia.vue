<template>
  <div class="social-media">
    <h3 class="title">RÉSEAUX SOCIAUX</h3>
    <label>Réseaux sociaux (optionnel)</label>
    <div class="social-content pb-3">
      <div class="social-links">
        <div
          v-for="(item, index) of inputData"
          :key="'link-' + index"
          class="social-link"
        >
          <div class="select-wrapper">
            <model-select v-model="item.type" :options="socialMedia" />
          </div>
          <div class="input-wrapper">
            <input v-model="item.link" placeholder="Entrer l’URL." />
          </div>
          <div class="btn-wrapper">
            <button @click.prevent="deleteLink(index)">
              <i class="material-icons">delete</i>
            </button>
          </div>
        </div>
        <button class="add-btn" @click.prevent="addLink">
          Ajouter
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    inputData: {
      type: Array,
      default: function() {
        return [{ type: '', link: '' }]
      }
    }
  },
  data() {
    return {
      socialMedia: [
        { value: '', text: 'Sélectionnez Réseau' },
        { value: 'Facebook', text: 'Facebook' },
        { value: 'Twitter', text: 'Twitter' },
        { value: 'Google+', text: 'Google+' },
        { value: 'Pinterest', text: 'Pinterest' }
      ]
    }
  },
  methods: {
    deleteLink(index) {
      this.inputData.splice(index, 1)
    },
    addLink() {
      this.inputData.push({ type: '', link: '' })
    }
  }
}
</script>

<style>
@import 'assets/css/edit-listing/social-media.css';
</style>
