<template>
  <div class="form-group h-100 d-flex mb-0 flex-wrap">
    <label class="image-label w-100" style="marginBottom: 47px !important">{{
      label
    }}</label>
    <div class="fileupload-container w-100 d-flex align-items-end">
      <input
        id="sp-upload"
        ref="file"
        v-validate="
          'ext:doc,docx,xls,odt,ods,pdf,rtf,jpg,jpeg,png,tif,gif,webp'
        "
        type="file"
        name="files"
        multiple
        class="fileupload-input custom-file-input"
        @change="onFileChange"
      />
    </div>
    <div v-if="errors.any()" class="w-100 text-danger validate-msg">
      <span
        >Format de fichier invalide. Formats acceptés : doc, docx, xls, odt,
        ods, pdf, rtf, jpg, jpeg, png, tif, gif, webp</span
      >
    </div>
    <div style="marginTop: 20px; fontSize: 14px;" v-html="fileName"></div>
  </div>
</template>
<script>
const _files = []
const _ext = [
  'doc',
  'docx',
  'xls',
  'odt',
  'ods',
  'pdf',
  'rtf',
  'jpg',
  'jpeg',
  'png',
  'tif',
  'gif',
  'webp'
]
export default {
  name: 'WedoFileProject',
  props: {
    name: {
      type: String,
      default: ''
    },
    value: {
      type: [String, Array],
      default: ''
    },
    label: {
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
      file: this.value ? this.value : null,
      fileName: ''
    }
  },
  methods: {
    onFileChange(e) {
      this.fileName = ''
      const files = e.target.files || e.dataTransfer.files
      if (!files.length) return
      for (const file of files) {
        const ext = file.name.split('.')[1]
        if (_ext.indexOf(ext) > 0) {
          _files.push(file)
        }
      }
      for (const _file of _files) {
        this.fileName += `<li>` + _file.name + `</li>`
      }
      this.$emit('input', _files)
    }
  }
}
</script>
