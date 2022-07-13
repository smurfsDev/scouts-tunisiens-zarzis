<template>
  <div>
    <Form :editm="editm" :demandeMateriel="demande" :dialog="dialog" @close="close" @success="getDemandeMateriel"></Form>
    <v-btn color="success" class="m-4 mr-0" large @click="dialog = true">
      <v-icon>mdi-plus</v-icon>
      اضافة
    </v-btn>
    <v-alert :value="alert.show" dismissible :type="alert.type">{{
      alert.msg
    }}</v-alert>
    <show :demandes="demandes" @setQte="setQte" @edit="edit" @deleteItem="deleteItem" ></show>
  </div>
</template>

<script>
import Form from "@/components/demandeMateriel/form.vue";
import show from "@/components/demandeMateriel/show.vue";
export default {
  components: {
    show,
    Form,
  },
  created() {
    this.getDemandeMateriel();
  },
  data() {
    return {
      dialog: false,
      alert: {
        show: false,
        type: null,
        msg: null,
      },
      demandes: [],
      demande:null,
      editm:false
    };
  },
  methods: {
    getDemandeMateriel(alert = { show: false, type: null, msg: null }) {
      this.$axios
        .get("/sent-demande-materiel")
        .then((response) => {
          this.demandes = response.data;
        })
        .catch()
        .finally(() => {
          this.alert = alert;
          setTimeout(() => {
            this.alert.show = false;
          }, 5000);
        });
    },
    close() {
      this.dialog = false;
      this.editm = false;
      this.demande = null;
    },
    deleteItem(id) {
      this.$axios
        .delete("/demande-materiel/" + id)
        .then(() => {
          this.getDemandeMateriel({
            show: true,
            type: "success",
            msg: "تم حذف الطلب بنجاح",
          });
        })
        .catch(() => {
          this.getDemandeMateriel({
            show: true,
            type: "red",
            msg: "حدث خطأ ما",
          });
        });
    },
    edit(item){
      this.dialog = true;
      this.editm = true;
      this.demande = item;
    },
    setQte(id, materiel_id, qte) {
      this.$axios
        .put("/demande-materiel-qte", {
          demande_id:id,
          quantity: qte,
          materiel_id: materiel_id,
        })
        .then(() => {
          this.getDemandeMateriel({
            show: true,
            type: "success",
            msg: "تم تعديل الكمية بنجاح",
          });
        })
        .catch(() => {
          this.getDemandeMateriel({
            show: true,
            type: "red",
            msg: "حدث خطأ ما",
          });
        });
    },
  },
};
</script>

<style>
</style>