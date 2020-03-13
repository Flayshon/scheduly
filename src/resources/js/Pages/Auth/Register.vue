<template>
  <v-app>
    <v-card width="400" class="mx-auto mt-5">
      <v-card-title>
        <h1 class="display-1">Create a new account</h1>
      </v-card-title>
      <v-card-text>
        <v-form @submit.prevent="submit">
          <v-text-field
            v-model="form.name"
            :error-messages="$page.errors.name"
            label="Name"
            type="text"
            prepend-icon="mdi-account-circle"
          ></v-text-field>
          <v-text-field
            v-model="form.email"
            :error-messages="$page.errors.email"
            label="Email"
            type="email"
            autofocus
            autocapitalize="off"
            prepend-icon="mdi-account-circle"
          ></v-text-field>
          <v-text-field
            v-model="form.password"
            :error-messages="$page.errors.password"
            label="Password"
            type="password"
            prepend-icon="mdi-lock"
            append-icon="mdi-eye-off"
          ></v-text-field>
          <v-text-field
            v-model="form.password_confirmation"
            :error-messages="$page.errors.passwordConfirmation"
            label="Password confirmation"
            type="password"
            prepend-icon="mdi-lock"
            append-icon="mdi-eye-off"
          ></v-text-field>
          <v-divider></v-divider>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="indo" type="submit">Create</v-btn>
          </v-card-actions>
        </v-form>
      </v-card-text>
    </v-card>
  </v-app>
</template>

<script>
export default {
  name: "Register",
  metaInfo: { title: "Register" },

  data: () => ({
    sending: false,
    form: {
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
    }
  }),

  methods: {
    submit() {
      this.$inertia
        .post(this.route('register'), {
          name: this.form.name,
          email: this.form.email,
          password: this.form.password,
          password_confirmation: this.form.password_confirmation,
        })
        .then(() => (this.sending = false));
      console.log("Register Form submitted");
    }
  }
};
</script>