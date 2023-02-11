<template>
  <v-app style="margin: 0 !important">
    <navbar />
    <v-main id="main" class="grey lighten-3">
      <!-- <v-container fluid style="padding:0"> -->
      <router-view class="text-right" />
      <!-- </v-container> -->
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
