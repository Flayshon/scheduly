<template>
  <v-app>
    <v-card width="400" class="mx-auto mt-5">
      <v-card-title>
        <h1 class="display-1">Sign In</h1>
      </v-card-title>
      <v-card-text>
        <v-form @submit.prevent="submit">
          <v-text-field
            v-model="form.email"
            label="Email"
            type="email"
            autofocus
            autocapitalize="off"
            prepend-icon="mdi-account-circle"
          ></v-text-field>
          <div v-if="errors.length" class="form-error">{{ errors[0] }}</div>
          <v-text-field
            v-model="form.password"
            label="Password"
            type="password"
            prepend-icon="mdi-lock"
            append-icon="mdi-eye-off"
          ></v-text-field>
          <v-checkbox v-model="form.remember" label="Remember me"></v-checkbox>
          <v-divider></v-divider>
          <v-card-actions>
            <v-btn color="success">Register</v-btn>
            <v-spacer></v-spacer>
            <v-btn color="indo" type="submit">Login</v-btn>
          </v-card-actions>
        </v-form>
      </v-card-text>
    </v-card>
  </v-app>
</template>

<script>
export default {
  name: "Login",
  metaInfo: { title: "Login" },

  props: {
    errors: {
      type: Array,
      default: () => []
    }
  },

  data: () => ({
    sending: false,
    form: {
      email: "flayshon@gmail.com",
      password: "asdfasdf",
      remember: null
    }
  }),

  methods: {
    submit() {
      this.$inertia
        .post("/login", {
          email: this.form.email,
          password: this.form.password,
          remember: this.form.remember
        })
        .then(() => (this.sending = false));
      console.log("açlskdfj");
    }
  }
};
</script>