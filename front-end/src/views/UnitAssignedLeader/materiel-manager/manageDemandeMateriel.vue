<template>
  <div>
    <v-alert :value="alert.show" dismissible :type="alert.type">{{
      alert.msg
    }}</v-alert>
    <show
      :demandes="demandes"
      @rem="rem"
      @setStatus="setStatus"
      :pagination_meta="pagination_meta"
      @getDemandeMateriel="getDemandeMateriel"
    ></show>
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
      pagination_meta: {
        current: 1,
        total: 0,
      },
      demandes: [],
    };
  },
  methods: {
    getDemandeMateriel(alert = {},pagination=5) {
      this.$axios
        .get("/demande-materiel", { params: { pagination: pagination } })
        .then((response) => {
          this.demandes = response.data.data;
          this.pagination_meta.current = response.data.pagination.current_page;
          this.pagination_meta.total = response.data.pagination.last_page;
        })
        .catch()
        .finally(() => {
          if ("type" in alert) {
            this.alert = alert;
            setTimeout(() => {
              this.alert.show = false;
            }, 5000);
          }
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
          } else {
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