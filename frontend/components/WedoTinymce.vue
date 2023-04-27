<template>
  <div class="wedo-tinymce">
    <legend class="label">{{ label }}</legend>
    <tinymce-editor
      v-model="data"
      api-key="4e3j5c2ykvs89kbdlvlh957lq88xavftcnmuiw7cu2ju6k53"
      :init="{
        menubar: false,
        height: 250,
        plugins: 'wordcount',
        branding: false
      }"
      @initial-value="this.value"
      @input="updateData"
    ></tinymce-editor>
    <div v-if="error" class="w-100 text-danger validate-msg">
      <span>Ce champ est obligatoire</span>
    </div>
  </div>
</template>

<script>
import Editor from '@tinymce/tinymce-vue'

export default {
  components: {
    'tinymce-editor': Editor
  },
  props: {
    label: {
      type: String,
      default: ''
    },
    name: {
      type: String,
      default: ''
    },
    value: {
      type: String,
      default: ''
    },
    error: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      data: this.value
    }
  },
  updated() {
    this.data = this.value
  },
  methods: {
    updateData() {
      this.$emit('input', this.data)
    }
  }
}
</script>

<style>
.wedo-tinymce {
  margin-bottom: 25px !important;
  border-bottom: 1px solid #ccc;
}

.wedo-tinymce legend.label {
  font-family: 'Source Sans Pro', sans-serif;
  line-height: 2;
  color: #565662;
  font-size: 13px;
  font-weight: 700;
}
</style>
