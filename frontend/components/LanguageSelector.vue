<template>
  <b-dropdown
    size="lg"
    variant="link"
    toggle-class="text-decoration-none"
    no-caret
    class="dropdown-wrapper lang-dropdown"
  >
    <template slot="button-content"
      ><b-img
        id="french"
        src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/french.png"
        alt="language"
      />
    </template>
    <b-link href="/en">
      <b-dropdown-item id="english-dp" href="/en"
        ><b-img
          id="english"
          src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/english.png"
          alt="language"
      /></b-dropdown-item>
    </b-link>
    <b-link href="/de">
      <b-dropdown-item id="german-dp" href="/de"
        ><b-img
          id="german"
          src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/german.png"
          alt="language"
        /> </b-dropdown-item
    ></b-link> </b-dropdown
></template>

<script>
export default {
  name: 'LanguageSelector'
}
</script>

<style>
@media (max-width: 360px) {
  #english {
    width: 30px;
  }
  #german {
    width: 30px;
  }
  #french {
    width: 30px;
  }
}
@media (min-width: 361px) {
  #english {
    width: 40px;
  }
  #german {
    width: 36px;
  }
  #french {
    width: 36px;
  }
}
</style>
