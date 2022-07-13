<template>
  <div>
    <v-alert :value="alert.show" dismissible :type="alert.type">{{
      alert.msg
    }}</v-alert>
    <show :demandes="demandes" @rem="rem" @setStatus="setStatus"></show>
  </div>
</template>

<script>
import show from "@/components/demandeMateriel/manage/show.vue";

export default {
  components: {
    show,
  },
  created() {
    this.getDemandeMateriel();
  },
  data() {
    return {
      alert: {
        show: false,
        type: null,
        msg: null,
      },
      demandes: [],
    };
  },
  methods: {
    getDemandeMateriel(alert = { show: false, type: null, msg: null }) {
      this.$axios
        .get("/demande-materiel")
        .then((response) => {
          this.demandes = response.data.data;
        })
        .catch()
        .finally(() => {
          this.alert = alert;
          setTimeout(() => {
            this.alert.show = false;
          }, 5000);
        });
    },
    rem() {},
    setStatus(id, status) {
      this.$axios
        .put(`/demande-materiel-status/${id}/${status}`)
        .then(() => {
          if (status == 1) {
            this.getDemandeMateriel({
              show: true,
              type: "success",
              msg: "تم القبول  بنجاح",
            });
          }else{
            this.getDemandeMateriel({
              show: true,
              type: "success",
              msg: "تم الرفض  بنجاح",
            });
          }
        })
        .catch()
        .finally(() => {
          this.alert = alert;
          setTimeout(() => {
            this.alert.show = false;
          }, 5000);
        });
    },
  },
};
</script>

<style>
</style>