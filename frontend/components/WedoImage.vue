<template>
  <div class="wedo-file-input">
    <label>{{ label }}</label>

    <div v-show="value" class="row py-3">
      <div class="col-md-4 preview-wrapper">
        <img :src="value" alt="Alt text here" class="preview" />
        <button @click.prevent="deleteImage">
          <i class="material-icons">delete</i>
        </button>
      </div>
    </div>

    <input type="file" :name="name" @change="onImageChange" />

    <div v-if="hasError" class="w-100 text-danger validate-msg">
      <span>Ce champ est obligatoire</span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'WedoImage',
  props: {
    value: {
      type: String,
      default: ''
    },
    label: {
      type: String,
      default: ''
    },
    name: {
      type: String,
      default: ''
    },
    hasError: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      image: this.value,
      file: null,
      uploading: false
    }
  },
  updated() {
    this.image = this.value
  },
  methods: {
    onImageChange(e) {
      const files = e.target.files || e.dataTransfer.files
      if (!files.length) return
      this.createImage(files[0])
    },
    async createImage(file) {
      const reader = new FileReader()
      const vm = this
      reader.onload = e => {
        vm.file = e.target.result
        vm.$emit('input', vm.file)
        // vm.uploadImage()
      }
      await reader.readAsDataURL(file)
    },
    uploadImage() {
      // this.$axios.post('/image/store', { file: this.file }).then(response => {})
    },
    deleteImage() {
      this.file = null
      this.$emit('input', this.file)
    }
  }
}
</script>

<style>
.wedo-file-input {
  margin-bottom: 15px;
}

.wedo-file-input label {
  display: block;
  width: 100%;
  font-family: 'Source Sans Pro', sans-serif;
  margin-bottom: 5px;
  line-height: 2;
  color: #565662;
  padding-bottom: 0;
  font-size: 12px;
  font-weight: 700;
}

.wedo-file-input input[type='file'] {
  outline: none;
  width: 100%;
  padding: 15px 0;
  font-size: 12px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.25);
  font-family: 'Source Sans Pro', sans-serif;
}

.wedo-file-input .preview {
  width: 100%;
  height: 120px;
  object-fit: cover;
  object-position: center;
}

.wedo-file-input .preview-wrapper {
  position: relative;
}

.wedo-file-input .preview-wrapper button {
  background: orange;
  border: none;
  width: 30px;
  height: 30px;
  position: absolute;
  right: 30px;
  bottom: 15px;
  transition: opacity 0.2s ease-in-out;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  color: white;
  opacity: 0;
}

.wedo-file-input .preview-wrapper:hover button {
  opacity: 1;
}

.wedo-file-input .preview-wrapper button i {
  font-size: 18px;
}

.wedo-file-input .uploading {
  height: 120px;
  background: orange;
}
</style>
