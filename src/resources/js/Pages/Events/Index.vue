<template>
  <v-app>
    <v-content>
      <inertia-link :href="this.route('logout')" method="post">Logout</inertia-link>
      <Calendar :inertiaEvents="$page.events" />
    </v-content>
  </v-app>
</template>

<script>
import Calendar from '../../Components/Calendar'

export default {
  name: 'App',
  components: {
    Calendar
  },

  data: () => ({
    //
  }),
}
</script>