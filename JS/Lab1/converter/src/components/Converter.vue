<template>
  <div>
    <b-container>
       <b-card
      header="Перевод футов и метров"
      header-tag="header"
      class="my-5"
    >
      <b-row align-v="center" class="my-6">
        <b-col>
          <b-form-input v-model="foots" id='foots' placeholder="Футы"></b-form-input>
        </b-col>
        <b-col>
          <b-form-input id='meters' v-model="meters" placeholder="Метры"></b-form-input>
        </b-col>
      </b-row>
    </b-card>
    </b-container>
  </div>
</template>

<script>
export default {
  name: 'Converter',
  data() {
    return{
      foots: 0,
      meters: 0,
    }
  },
  watch: {
    foots: function() {
      this.convertFoots2Meters()
    },
    meters: function() {
       this.convertMeters2Foots()
    }
  },
  methods: {
    convertMeters2Foots: function() {
      return this.foots = parseFloat(this.meters) * 3.2808 || 0
    },
    
    convertFoots2Meters: function() {
      return this.meters = parseFloat(this.foots) / 3.2808 || 0
    }
  },
}
</script>
