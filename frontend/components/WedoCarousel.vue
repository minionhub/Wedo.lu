<template>
  <div>
    <b-carousel
      class="wedo-carousel"
      :interval="4000"
      controls
      indicators
      background="#ababab"
      img-width="1024"
      img-height="480"
      style="text-shadow: 1px 1px 2px #333;"
    >
      <b-carousel-slide
        v-for="(image, index) in images"
        :key="index"
        :img-src="image"
      ></b-carousel-slide>
    </b-carousel>
  </div>
</template>

<script>
export default {
  props: {
    images: {
      type: Array,
      default: function() {
        return []
      }
    }
  }
}
</script>

<style>
.wedo-carousel {
  padding: 15px;
  background: #fff !important;
  border: 1px solid #d1d1d1;
}

.wedo-carousel .carousel-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
}

@media (max-width: 768px) {
  .wedo-carousel .carousel-item img {
    height: 420px;
  }
}
</style>
