<template>
  <v-app>
      <v-card width="400" class="mx-auto mt-5">
        <Form :userId="$page.auth.user.id" />
      </v-card>
  </v-app>
</template>

<script>
import Form from '../../Components/Form'

export default {
  name: 'Create',
  components: {
    Form
  },

  data: () => ({
    //
  }),
}
</script>