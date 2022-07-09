<template>
  <div>
    <Form
      :dialog="dialog"
      :materiel="mat"
      :editm="edit"
      @close="close"
      @success="getMateriel"
    />
    <v-btn color="success" class="m-4 mr-0" large @click="dialog = true">
      <v-icon>mdi-plus</v-icon>
      اضافة
    </v-btn>
    <v-alert :value="alert.show" dismissible :type="alert.type">{{
      alert.msg
    }}</v-alert>
    <v-data-table
      :headers="headers"
      :items="materiel"
      :items-per-page="5"
      class="elevation-1"
    >
      <template v-slot:item.categories="{ item }">
        <v-chip
          v-for="(categorie) in item.categories"
          :key="categorie.id"
          :color="categorie.color"
          >{{ categorie.text }}</v-chip
        >
      </template>

      <template v-slot:item.operations="{ item }">
        <v-btn icon @click="editMateriel(item)" color="primary" dark>
          <v-icon>edit</v-icon>
        </v-btn>
        <deleteForm @ok="deleteMateriel" :id="item.id" />
      </template>
    </v-data-table>
  </div>
</template>

<script>
import Form from "@/components/manageMateriel/form.vue";
import deleteForm from "@/components/manageMateriel/deleteDialog.vue";
export default {
  components: {
    Form,
    deleteForm,
  },
  data() {
    return {
      materiel: [],
      headers: [
        {
          text: "الاسم",
          align: "start",
          sortable: false,
          value: "name",
        },
        {
          text: "الوصف",
          align: "start",
          sortable: false,
          value: "description",
        },
        {
          text: "الكمية",
          align: "start",
          sortable: false,
          value: "quantity",
        },
        {
          value: "categories",
          text: "الفئة",
        },
        {
          text: "العمليات",
          sortable: false,
          align: "center",
          value: "operations",
        },
      ],
      alert: {
        show: false,
        type: null,
        msg: null,
      },
      dialog: false,
      edit: false,
      mat: null,
    };
  },
  created() {
    this.getMateriel();
  },
  methods: {
    getMateriel(alert = { show: false, type: null, msg: null }) {
      this.$axios
        .get("/materiel/")
        .then((response) => {
          this.materiel = response.data;
        })
        .finally(() => {
          this.alert = alert;
          setTimeout(() => {
            this.alert.show = false;
          }, 5000);
        });
    },
    close() {
      this.dialog = false;
    },
    deleteMateriel(materiel) {
      this.$axios
        .delete("/materiel/" + materiel)
        .then(() => {
          this.getMateriel({
            show: true,
            type: "success",
            msg: "تم حذف الاثاث بنجاح",
          });
        })
        .catch(() => {
          this.getMateriel({
            show: true,
            type: "error",
            msg: "حدث خطأ أثناء حذف الاثاث",
          });
        });
    },
    editMateriel(materiel) {
      this.mat = materiel;
      this.dialog = true;
      this.edit = true;
    },
  },
};
</script>

<style>
</style>