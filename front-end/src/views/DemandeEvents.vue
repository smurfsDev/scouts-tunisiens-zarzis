<template>
  <div>
    <Form
      :editm="editm"
      :demandeEvent="demande"
      :dialog="dialog"
      @close="close"
      @success="getDemandeEvent"
    ></Form>
    <v-btn color="success" class="m-4 mr-0" large @click="dialog = true">
      <v-icon>mdi-plus</v-icon>
      اضافة
    </v-btn>
    <v-alert :value="alert.show" dismissible :type="alert.type">{{
      alert.msg
    }}</v-alert>
    <show
      :demandes="demandes"
      @setQte="setQte"
      @rem="rem"
      @edit="edit"
      @deleteItem="deleteItem"
      :pagination_meta="pagination_meta"
      @getDemandeEvent="getDemandeEvent"
    ></show>
  </div>
</template>

<script>
import Form from "@/components/demandeEvent/form.vue";
import show from "@/components/demandeEvent/show.vue";
export default {
  components: {
    show,
    Form,
  },
  created() {
    this.getDemandeEvent();
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
      demande: {},
      pagination_meta: {
        current: 1,
        total: 0,
      },
      editm: false,
    };
  },
  methods: {
    getDemandeEvent(alert = {}, pagination = 5) {
      this.$axios
        .get("/events/myDemande?page=" + this.pagination_meta.current, {
          params: { pagination: pagination },
        })
        .then((response) => {
          // console.log(response.data.data);
          this.demandes = response.data.data.data;
          console.log(this.demandes);
          this.pagination_meta.current = response.data.data.current_page;
          this.pagination_meta.total = response.data.data.last_page;
          console.log(
            "pagination_meta.current: " + this.pagination_meta.current
          );
          console.log("pagination_meta.total: " + this.pagination_meta.total);
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
    close() {
      this.dialog = false;
      this.editm = false;
      this.demande = null;
    },
    deleteItem(id) {
      this.$axios
        .delete("/events/delete/" + id)
        .then(() => {
          this.getDemandeEvent({
            show: true,
            type: "success",
            msg: "تم حذف الطلب بنجاح",
          });
        })
        .catch(() => {
          this.getDemandeEvent({
            show: true,
            type: "red",
            msg: "حدث خطأ ما",
          });
        });
    },
    edit(item) {
      this.dialog = true;
      this.editm = true;
      this.demande = item;
    },
    setQte(id, Event_id, qte) {
      this.$axios
        .put("/demande-Event-qte", {
          demande_id: id,
          quantity: qte,
          Event_id: Event_id,
        })
        .then(() => {
          this.getDemandeEvent({
            show: true,
            type: "success",
            msg: "تم تعديل الكمية بنجاح",
          });
        })
        .catch((res) => {
          this.getDemandeEvent({
            show: true,
            type: "red",
            msg: res.response.data ? res.response.data.message : "حدث خطأ ما",
          });
        });
    },
    rem(id, Event_id) {
      console.log(id, Event_id);
      this.$axios
        .delete(`/demande-Event-mat/${id}/${Event_id}`)
        .then(() => {
          this.getDemandeEvent({
            show: true,
            type: "success",
            msg: "تم حذف المادة بنجاح",
          });
        })
        .catch(() => {
          this.getDemandeEvent({
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