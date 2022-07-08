<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="materiel"
      :items-per-page="5"
      class="elevation-1"
    ></v-data-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      materiel: [],
       headers: [
          {
            text: 'الاسم',
            align: 'start',
            sortable: false,
            value: 'name',
          },
          {
            text: 'الوصف',
            align: 'start',
            sortable: false,
            value: 'description',
          },
          {
            text: 'الكمية',
            align: 'start',
            sortable: false,
            value: 'quantity',
          }
          
        ],
    };
  },
  created() {
    this.getMateriel();
  },
  methods: {
    getMateriel() {
      this.$axios.get("/materiel/").then((response) => {
        this.materiel = response.data;
      });
    },
  },
};
</script>

<style>
</style>