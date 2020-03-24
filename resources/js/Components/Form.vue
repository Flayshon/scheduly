<template>
  <v-form v-model="formValid" @submit.prevent="submit">
    <v-jsonschema-form
      v-if="schema"
      :schema="schema"
      :model="dataObject"
      :options="options"
      @error="showError"
      @change="showChange"
      @input="showInput"
    />
    <v-btn color="success" type="submit">Submit</v-btn>
  </v-form>
</template>

<script>

import Draggable from 'vuedraggable'
import Swatches from 'vue-swatches'
import 'vue-swatches/dist/vue-swatches.min.css'
import VJsonschemaForm from '@koumoul/vuetify-jsonschema-form'
import '@koumoul/vuetify-jsonschema-form/dist/main.css'
import { Sketch } from 'vue-color'

Vue.component('swatches', Swatches)
Vue.component('draggable', Draggable)
Vue.component('color-picker', Sketch)

export default {
  components: {VJsonschemaForm},
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
          "start_date",
          "end_date",
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
          "start_date": {
            "title": "Start Date",
            "type": "string",
            "format": "date"
          },
          "end_date": {
            "title": "End Date",
            "type": "string",
            "format": "date"
          },
          "time_slots": {
            "title": "Time Slots",
            "type": "array",
            "items": {
              "$ref": "#/definitions/time_slot"
            }
          },
        },
        "definitions": {
          "time_slot": {
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
        }
      },
      dataObject: {
        
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
      this.dataObject.user_id = this.userId
      console.log(this.dataObject)
      this.$inertia
        .post('/events', this.dataObject)
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