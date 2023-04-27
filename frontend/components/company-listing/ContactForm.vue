<template>
  <form action="" class="custom-card px-5 py-5 contact-form">
    <h2 class="mb-3">Contactez {{ companyName }}</h2>
    <WedoInput type="text" placeholder="Votre prénom, nom"></WedoInput>
    <WedoInput type="text" placeholder="Votre numéro de téléphone"></WedoInput>
    <WedoInput type="text" placeholder="Votre adresse email"></WedoInput>
    <WedoTextarea :rows="5" placeholder="Votre message"></WedoTextarea>
    <WedoCheckbox
      label="Je donne mon consentement pour que mes données soient transmises par ce formulaire"
    ></WedoCheckbox>
    <WedoButton class="btn-block" value="Envoyer"></WedoButton>
  </form>
</template>

<script>
import WedoInput from '~/components/WedoInput.vue'
import WedoButton from '~/components/WedoButton.vue'
import WedoTextarea from '~/components/WedoTextarea.vue'
import WedoCheckbox from '~/components/WedoCheckbox.vue'

export default {
  name: 'ContactFrom',
  components: {
    WedoInput,
    WedoButton,
    WedoTextarea,
    WedoCheckbox
  },
  props: {
    companyName: {
      type: String,
      default: ''
    }
  }
}
</script>

<style>
.contact-form .wedo-input,
.contact-form .wedo-textarea {
  margin-bottom: 10px;
}
</style>
