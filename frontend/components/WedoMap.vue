<template>
  <div class="wedo-map">
    <GmapMap
      :center="{
        lat: lat,
        lng: lng
      }"
      :zoom="zoom"
      :options="{
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: true,
        disableDefaultUi: false,
        draggable: false
      }"
      map-type-id="roadmap"
      :style="'width: ' + width + '; height: ' + height"
    >
    </GmapMap>
    <div class="marker">
      <img :src="icon" alt="marker" />
    </div>
  </div>
</template>

<script>
export default {
  name: 'WedoMap',
  props: {
    lat: {
      type: Number,
      default: 11
    },
    lng: {
      type: Number,
      default: 11
    },
    icon: {
      type: String,
      default: ''
    },
    width: {
      type: String,
      default: '100%'
    },
    height: {
      type: String,
      default: '500px'
    },
    zoom: {
      type: Number,
      default: 11
    }
  }
}
</script>

<style>
.wedo-map {
  position: relative;
}

.wedo-map .marker {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 46px;
  height: 46px;
  margin-left: -23px;
  margin-top: -23px;
  overflow: hidden;
  border-radius: 50%;
  border: 2px solid #fff;
  -webkit-box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  transition: all 0.4s;
  background-color: white;
}

.wedo-map .marker:hover {
  transform: scale(1.1, 1.1);
}

.wedo-map .marker img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
}
</style>
