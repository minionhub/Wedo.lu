<template
  ><div id="page-content">
    <div
      class="container-fluid col-12 p-lg-5 text-center"
      style="background-image: url('https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/pagehead2.jpg'); background-size: cover; height: 417px;"
    >
      <div id="contact_title" class="container py-5 mx-auto col-xl-8">
        <h1
          id="contact_title_h1"
          class="py-5 font-weight-bold bg-white"
          style="font-family: 'open sans',sans-serif; color: black; font-weight: 600!important;"
        >
          Nous contacter
        </h1>
      </div>
    </div>

    <div id="wrapper">
      <WedoMap
        :lat="49.633736"
        :lng="6.166686"
        :zoom="15"
        height="720px"
        width="100%"
      ></WedoMap>
      <div
        id="over_map_contact"
        class="col-xl-3 col-lg-4 col-md-6 col-sm-12 shadow-lg ml-auto bg-white"
      >
        <div class="container col-12 px-4 py-5 my-3">
          <div class="row w-100">
            <div class="col-1">
              <font-awesome-icon icon="user-secret" />
              <i class="fa fa-map-marker"></i>
            </div>
            <div class="col-10">
              <p>2 Circuit de La Foire Internationale, 1347 Luxembourg</p>
            </div>
          </div>
          <div class="row w-100 mt-3">
            <div class="col-1">
              <i class="fa fa-phone"></i>
            </div>
            <div class="col-10"><p>+ 352 42 45 11 - 44</p></div>
          </div>
          <div class="row w-100 mt-3">
            <div class="col-1">
              <i class="fa fa-envelope-o"></i>
            </div>
            <div class="col-10"><p>info@wedo.lu</p></div>
          </div>
          <div class="row w-100 mt-3">
            <div class="col-1">
              <i class="fa fa-globe"></i>
            </div>
            <div class="col-10"><p>https://www.wedo.lu</p></div>
          </div>
        </div>
      </div>
    </div>
  </div></template
>

<script>
import WedoMap from '~/components/WedoMap.vue'

export default {
  components: {
    WedoMap
  }
}
</script>

<style lang="css">
@import 'assets/css/style.css';
</style>
