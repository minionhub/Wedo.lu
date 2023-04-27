<template>
  <div class="google-map-ex pb-3">
    <div>
      <label>Adresse pour Google Map</label>
      <gmap-autocomplete @keyup.prevent="" @place_changed="setPlace">
      </gmap-autocomplete>
      <div class="controls">
        <div class="row py-2">
          <div
            class="lock col-md-6 d-flex align-items-center"
            @click="isLocked = !isLocked"
          >
            <i class="material-icons mr-2">lock_outline</i>
            {{ isLocked ? unlockText : lockText }}
          </div>
          <div class="coords col-md-6" @click="showCoords = !showCoords">
            Entrer les coordonnées manuellement
          </div>
        </div>
        <div v-show="showCoords" class="row pt-2 pb-3">
          <div class="col-md-6">
            <label>Latitude</label>
            <input v-model="marker.lat" @change="updatePos" />
          </div>
          <div class="col-md-6">
            <label>Longitude</label>
            <input v-model="marker.lng" @change="updatePos" />
          </div>
        </div>
      </div>
    </div>
    <gmap-map
      :options="{ draggable: !isLocked }"
      :center="{ lat: Number(marker.lat), lng: Number(marker.lng) }"
      :zoom="12"
      style="width:100%;  height: 300px;"
    >
      <gmap-marker
        :position="{ lat: Number(marker.lat), lng: Number(marker.lng) }"
      ></gmap-marker>
    </gmap-map>
    <div v-if="error" class="w-100 text-danger validate-msg">
      <span>Ce champ est obligatoire</span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'GoogleMap',
  props: {
    value: {
      type: Object,
      default: function() {
        return {
          lat: 45.508,
          lng: -73.587,
          street_number: '',
          route: '',
          locality: '',
          administrative_area_level_1: '',
          country: '',
          postal_code: ''
        }
      }
    },
    name: {
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
      marker: { lat: this.value.lat, lng: this.value.lng },
      position: this.value,
      currentPlace: null,
      isLocked: false,
      lockText: 'Lock Pin Emplacement',
      unlockText: "Déverrouiller l'emplacement des broches",
      showCoords: false,
      components: {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      }
    }
  },

  mounted() {
    this.marker = { lat: this.value.lat, lng: this.value.lng }
    this.position = this.value
  },

  methods: {
    // receives a place object via the autocomplete component
    setPlace(place) {
      this.currentPlace = place
      if (this.currentPlace.geometry) {
        for (let i = 0; i < place.address_components.length; i++) {
          const addressType = place.address_components[i].types[0]
          if (this.components[addressType]) {
            const val =
              place.address_components[i][this.components[addressType]]
            this.position[addressType] = val
          }
        }
        const marker = {
          lat: this.currentPlace.geometry.location.lat(),
          lng: this.currentPlace.geometry.location.lng()
        }
        this.marker = marker
        this.currentPlace = null
        this.updatePos()
      }
    },
    geolocate: function() {
      navigator.geolocation.getCurrentPosition(position => {
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        }
        this.marker = this.center
      })
    },
    updatePos() {
      this.position.lat = this.marker.lat
      this.position.lng = this.marker.lng
      this.$emit('input', this.position)
    }
  }
}
</script>

<style>
@import 'assets/css/edit-listing/google-map-ex.css';
</style>
