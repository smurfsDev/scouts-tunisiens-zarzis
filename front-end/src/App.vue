<template>
  <v-app >
    
    <navbar/>
    <v-main>
      <router-view class="text-right" />
    </v-main>
  </v-app>
</template>

<script>
import navbar from './components/NavBar.vue'
export default {
  name: "App",
  components: {
    navbar
  },
  data: () => ({
    //
  }),
};
</script>
