<template>
  <v-app>
    <v-content>
      <inertia-link :href="this.route('logout')" method="post">Logout</inertia-link>
      <v-spacer></v-spacer>
      <inertia-link :href="this.route('events.create')" method="get">Create new event</inertia-link>
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