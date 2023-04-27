<template>
  <div class="wedo-file-input">
    <label>{{ label }}</label>

    <div v-if="value" class="row py-3">
      <div class="col-md-4 preview-wrapper">
        <div
          class="preview w-100 d-flex align-items-center justify-content-center"
        >
          <i class="material-icons">insert_drive_file</i>
        </div>
        <div class="filename">
          {{
            typeof this.value !== 'object'
              ? this.value.split('/').pop()
              : this.value.name
          }}
        </div>
        <button @click.prevent="deleteFile">
          <i class="material-icons">delete</i>
        </button>
      </div>
    </div>

    <input
      ref="file"
      v-validate="'ext:pdf'"
      name="pdf"
      type="file"
      @change="onFileChange"
    />
    <div v-if="errors.any()" class="w-100 text-danger validate-msg">
      {{ error }}
      <span>Format de fichier invalide. Formats acceptés : pdf</span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'WedoFile',
  props: {
    name: {
      type: String,
      default: ''
    },
    value: {
      type: [String, File],
      default: ''
    },
    label: {
      type: String,
      default: ''
    },
    hasError: {
      type: Boolean,
      default: false
    },
    error: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      file: this.value ? this.value : ''
    }
  },
  methods: {
    onFileChange(e) {
      const files = e.target.files || e.dataTransfer.files
      if (!files.length) return
      this.file = files[0]
      this.$emit('input', this.file)
    },
    uploadImage() {},
    deleteFile() {
      this.file = null
      this.$refs.file.value = ''
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
  border: 1px solid #dfe0e4;
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

.wedo-file-input .preview-wrapper .filename {
  position: absolute;
  left: 30px;
  top: 15px;
  font-size: 13px;
}

.wedo-file-input .preview-wrapper:hover button {
  opacity: 1;
}

.wedo-file-input .preview i {
  font-size: 50px;
}

.wedo-file-input .preview-wrapper button i {
  font-size: 18px;
}

.wedo-file-input .uploading {
  height: 120px;
  background: orange;
}
</style>
