<template>
  <v-app>
    <v-app-bar app color="primary" dark>
      <div class="d-flex align-center">
        <v-img
          alt="Vuetify Logo"
          class="shrink mr-2"
          contain
          src="https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png"
          transition="scale-transition"
          width="40"
        />

        <v-img
          alt="Vuetify Name"
          class="shrink mt-1 hidden-sm-and-down"
          contain
          min-width="100"
          src="https://cdn.vuetifyjs.com/images/logos/vuetify-name-dark.png"
          width="100"
        />
      </div>

      <v-spacer></v-spacer>
      <div class="text-center">
        <v-menu open-on-hover top offset-y offset-x offset-overflow>
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark v-bind="attrs" v-on="on">
              Compte <v-icon>mdi-account</v-icon>
            </v-btn>
          </template>

          <v-list>
            <v-list-item v-if="!this.$store.getters.isLoggedIn">
              <router-link class="button" to="/login"
                ><v-icon>mdi-account-arrow-right</v-icon>Connecter</router-link
              >
            </v-list-item>
            <v-list-item v-if="this.$store.getters.isLoggedIn">
              <router-link class="button" to="/logout"
                ><v-icon>mdi-account-arrow-left</v-icon>Deconnecter</router-link
              >
            </v-list-item>
            <v-list-item v-if="!this.$store.getters.isLoggedIn">
              <router-link class="button" to="/register"
                ><v-icon>mdi-account-plus</v-icon>S'inscrire</router-link
              >
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
    </v-app-bar>

    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: "App",

  data: () => ({
    //
  }),
};
</script>
