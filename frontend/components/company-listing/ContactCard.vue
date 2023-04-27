<template>
  <div class="contact-card">
    <div v-if="street" class="item">
      <b-img
        src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/company/marker.svg"
      ></b-img>
      <p>{{ street }}<br />{{ houseNbr }}</p>
    </div>
    <div v-if="websiteUrl" class="item">
      <b-img
        src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/company/web.svg"
      ></b-img>
      <p>{{ websiteUrl }}</p>
    </div>
    <div v-if="phone" class="item">
      <b-img
        src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/company/mobile.svg"
      ></b-img>
      <p>{{ phone }}</p>
    </div>
    <div v-if="fax" class="item">
      <b-img
        src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/company/fax.svg"
      ></b-img>
      <p>{{ fax }}</p>
    </div>
    <div v-if="contactEmail" class="item">
      <b-img
        src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/company/envelop-dark.svg"
      ></b-img>
      <p>{{ contactEmail }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ContactCard',
  props: {
    street: {
      type: String,
      default: ''
    },
    houseNbr: {
      type: String,
      default: ''
    },
    websiteUrl: {
      type: String,
      default: ''
    },
    phone: {
      type: String,
      default: ''
    },
    fax: {
      type: String,
      default: ''
    },
    contactEmail: {
      type: String,
      default: ''
    }
  }
}
</script>

<style>
.contact-card {
  display: flex;
  flex-wrap: wrap;
}

.contact-card .item {
  display: flex;
  flex: 1 1 auto;
  align-items: center;
  padding: 10px;
  position: relative;
  justify-content: center;
}

.contact-card .item img {
  width: 18px;
  height: 18px;
  margin-right: 10px;
}

.contact-card .item p {
  font-family: 'Open Sans', sans-serif;
  font-size: 14px;
  color: #5c5c68;
  margin-bottom: 0;
}
</style>
