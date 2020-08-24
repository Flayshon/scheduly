<template>
  <v-form v-model="formValid" @submit.prevent="submit">
    <v-jsf
      v-if="schema"
      v-model="model"
      :schema="schema"
      :options="options"
      @error="showError"
      @change="showChange"
      @input="showInput"
    />
    <v-btn color="success" type="submit">Submit</v-btn>
  </v-form>
</template>

<script>
import VJsf from '@koumoul/vjsf'
import '@koumoul/vjsf/dist/main.css'
import '@koumoul/vjsf/dist/third-party.js'

Vue.component('VJsf', VJsf)

export default {
  props: {
    userId: null
  },
  data() {
    return {
      schema: {
        "title": "Event",
        "type": "object",
        "required": [
          "title",
          "description",
          "start",
          "end",
          "time_slots"
        ],
        "properties": {
          "title": {
            "title": "Title",
            "type": "string"
          },
          "description": {
            "title": "Description",
            "type": "string"
          },
          "start": {
            "title": "Start Date",
            "type": "string",
            "format": "date"
          },
          "end": {
            "title": "End Date",
            "type": "string",
            "format": "date"
          },
          "time_slots": {
            "title": "Time Slots",
            "type": "array",
            "items": {
              "type": "object",
              "required": [
                "start",
                "end",
                "location"
              ],
              "properties": {
                "start":{
                  "title": "Start time",
                  "type": "string",
                  "format": "date-time",
                },
                "end":{
                  "title": "End time",
                  "type": "string",
                  "format": "date-time",
                },
                "location_id":{
                  "title": "Location",
                  "type": "string"
                }
              }
            }
          },
        },
      },
      model: {
        
      },
      formValid: false,
      sending: false,
      options: {
        debug: true,
        disableAll: false,
        autoFoldObjects: true
      }
    }
  },
  methods: {
    submit() {
      this.model.user_id = this.userId
      console.log(this.model)
      this.$inertia
        .post('/events', this.model)
        .then(() => (this.sending = false))
    },

    showError(err) {
      window.alert(err)
    },

    showChange(e) {
      console.log('"change" event', e)
    },
    
    showInput(e) {
      console.log('"input" event', e)
    }
  }
}
</script>