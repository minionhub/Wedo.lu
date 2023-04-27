<template>
  <div class="opening-hours">
    <h3 class="title">HEURES D'OUVERTURE</h3>
    <label>Heures d'ouverture (optionnel)</label>
    <div class="tab">
      <div class="tab-links">
        <a
          v-for="(weekDay, index) of weekDays"
          :key="'weekDay-' + index"
          class="tab-link"
          :class="activeTab === weekDay ? 'active' : null"
          @click="activeTab = weekDay"
          >{{ weekDay }}</a
        >
      </div>
      <div class="tab-content">
        <div class="types py-2">
          <div class="type">
            <input
              v-model="inputData[activeTab].type"
              class="type"
              name="type"
              value="0"
              type="radio"
            />
            <label>Entrer</label>
          </div>
          <div class="type">
            <input
              v-model="inputData[activeTab].type"
              class="type"
              name="type"
              value="1"
              type="radio"
            />
            <label>Ouvert toute la journée</label>
          </div>
          <div class="type">
            <input
              v-model="inputData[activeTab].type"
              class="type"
              name="type"
              value="2"
              type="radio"
            />
            <label>Fermé toute la journée</label>
          </div>
          <div class="type">
            <input
              v-model="inputData[activeTab].type"
              class="type"
              name="type"
              value="3"
              type="radio"
            />
            <label>Uniquement sur rendez-vous</label>
          </div>
        </div>

        <div v-if="inputData[activeTab].type == 0" class="hours">
          <div
            v-for="(hourPair, index) of inputData[activeTab].intervals"
            :key="'hourPair-' + index"
            class="hour"
          >
            <div class="select-wrapper">
              <model-select v-model="hourPair[0]" :options="hoursFrom" />
            </div>
            <div class="select-wrapper">
              <model-select v-model="hourPair[1]" :options="hoursTo" />
            </div>
            <div class="btn-wrapper">
              <button @click.prevent="deleteHourPair(index)">
                <i class="material-icons">delete</i>
              </button>
            </div>
          </div>

          <button class="add-btn" @click.prevent="addHourPair">
            Ajouter des horaires
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    inputData: {
      type: [Object, Array],
      default: function() {
        return {
          Monday: { type: 0, intervals: [] },
          Tuesday: { type: 0, intervals: [] },
          Wednesday: { type: 0, intervals: [] },
          Thursday: { type: 0, intervals: [] },
          Friday: { type: 0, intervals: [] },
          Saturday: { type: 2, intervals: [] },
          Sunday: { type: 2, intervals: [] }
        }
      }
    }
  },
  data() {
    return {
      activeTab: 'Monday',
      selected: false,
      hoursFrom: [{ value: '', text: 'A partir de' }],
      hoursTo: [{ value: '', text: 'À' }],
      weekDays: [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday'
      ]
    }
  },
  watch: {},
  mounted() {
    for (let i = 0; i < 60 * 24; i += 15) {
      const text = Math.floor(i / 60) + ':' + (i % 60 === 0 ? '00' : i % 60)
      this.hoursFrom.push({ value: text, text: text })
      this.hoursTo.push({ value: text, text: text })
    }
  },
  methods: {
    addHourPair() {
      if (typeof this.inputData[this.activeTab].intervals === 'undefined')
        this.inputData[this.activeTab].intervals = []
      this.inputData[this.activeTab].intervals.push(['', ''])
    },
    deleteHourPair(index) {
      this.inputData[this.activeTab].intervals.splice(index, 1)
    }
  }
}
</script>

<style>
@import 'assets/css/edit-listing/opening-hours.css';
</style>
