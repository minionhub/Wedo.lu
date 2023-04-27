<template>
  <li>
    <b-link :to="link">
      <header>
        <h3>
          {{ title }}
        </h3>
        <p>{{ date }}</p>
      </header>
    </b-link>
    <div class="meta-data">
      <ul class="list3">
        <li>
          <i
            ><b-img
              src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/project/marker.svg"
              alt="image"
            ></b-img
          ></i>
          <address>rue Roosevelt, Olm</address>
        </li>
        <li>
          <i
            ><b-img
              src="https://wedo-dev-images.s3.eu-central-1.amazonaws.com/img/project/envelope.svg"
              alt="image"
            ></b-img></i
          ><a href="#">{{ email }}</a>
        </li>
      </ul>
    </div>
    <div class="description">
      <p>
        {{ description }}
      </p>
    </div>
  </li>
</template>

<script>
export default {
  name: 'WedoProject',
  props: {
    id: {
      type: String,
      default: ''
    },
    description: {
      type: String,
      default: ''
    },
    status: {
      type: String,
      default: ''
    },
    label: {
      type: String,
      default: ''
    },
    src: {
      type: String,
      default: ''
    },
    link: {
      type: String,
      default: ''
    },
    title: {
      type: String,
      default: ''
    },
    email: {
      type: String,
      default: ''
    },
    date: {
      type: String,
      default: ''
    },
    contents: {
      type: Array,
      default: function() {
        return []
      }
    },
    image: {
      type: String,
      default: ''
    },
    duration: {
      type: String,
      default: ''
    }
  },
  methods: {}
}
</script>

<style></style>
