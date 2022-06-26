<template>
  <v-app>
    <navbar />
    <v-main class="grey lighten-3">
      <v-container fluid class="my-4">
        <router-view class="text-right" />
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import navbar from "./components/NavBar.vue";
export default {
  name: "App",
  components: {
    navbar,
  },
  data: () => ({
    //
  }),
};
</script>
