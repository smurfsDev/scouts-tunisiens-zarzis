<template>
  <v-app id="inspire">
    <v-main>
      <v-container fluid>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12 rounded-lg" shaped>
              <v-toolbar dark>
                <v-toolbar-title>Connexion</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <b-alert
                  :show="alert.dismissCountDown"
                  dismissible
                  :variant="alert.variant"
                  @dismissed="alert.dismissCountDown = 0"
                >
                  <p>{{ alert.msg }}</p>
                </b-alert>
                <v-form @submit.prevent="Login" id="login-form">
                  <v-text-field
                    prepend-icon="person"
                    name="Email"
                    label="email"
                    :error-messages="emailErrors"
                    v-model="email"
                    type="text"
                  ></v-text-field>
                  <v-text-field
                    id="password"
                    :error-messages="passwordErrors"
                    v-model="password"
                    prepend-icon="lock"
                    name="Mot de passe"
                    label="Mot de passe"
                    type="password"
                  ></v-text-field>
                </v-form>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="primary" to="/register">Register</v-btn>
                  <v-btn color="success" form="login-form" type="submit"
                    >Login</v-btn
                  >
                </v-card-actions>
              </v-card-text>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import { mapActions } from "vuex";
import { required, minLength, email } from "vuelidate/lib/validators";

export default {
  validations: {
    email: {
      required,
      email,
      async exists(value) {
        const response = await this.$axios(`/unique/${value}`);
        return response.status == 201 || value == "";
      },
    },
    password: { required, minLength: minLength(8) },
  },
  data() {
    return {
      email: "",
      password: "",
      alert: {
        dismissCountDown: null,
        variant: null,
        msg: null,
      },
    };
  },
  created() {
    if (typeof this.$route.params.msg!=="undefined") {
      this.alert.dismissCountDown = 10;
      this.alert.variant = this.$route.params.variant??"danger";
      this.alert.msg = this.$route.params.msg;
    }
  },
  methods: {
    ...mapActions(["login"]),
    Login() {
      this.$v.$touch();
      if (!this.$v.$anyError) {
        this.login({ email: this.email, password: this.password }).then(() => {
          if (this.$store.getters.authStatus == 2) {
            this.alert.dismissCountDown = 10;
            this.alert.variant = "danger";
            this.alert.msg = this.$store.getters.authMessage;
          }
        });
      }
    },
    post() {
      this.$v.$touch();
    },
  },
  computed: {
    passwordErrors() {
      const errors = [];
      if (!this.$v.password.$dirty) return errors;
      !this.$v.password.required &&
        errors.push("Merci d'entrer votre mot de passe!");
      !this.$v.password.minLength &&
        errors.push("Mot de passe doit etre au moin 8 characters!");
      return errors;
    },
    emailErrors() {
      const errors = [];
      if (!this.$v.email.$dirty) return errors;
      !this.$v.email.email && errors.push("Doit etre un email valide");
      !this.$v.email.required && errors.push("Merci d'entrer votre e-mail");
      !this.$v.email.exists && errors.push("Cet email n'existe pas");
      return errors;
    },
  },
};
</script>

<style></style>
