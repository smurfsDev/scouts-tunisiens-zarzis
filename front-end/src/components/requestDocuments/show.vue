<template>
  <v-data-table
    :headers="headers"
    :items="request"
    item-key="id"
    class="elevation-1"
  >
    <template v-slot:[`item.status`]="{ item }">
      <div class="align-center">
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
            <v-icon v-if="item.status == 0" color="orange" v-on="on"
              >mdi-close</v-icon
            >
            <v-btn
              class="mx-1"
              v-else-if="item.status == 1"
              @click="download(item.id)"
              x-small
              :fab="$vuetify.breakpoint.name != 'sm'"
              color="success"
            >
              <v-icon color="" v-on="on"> mdi-download </v-icon>
            </v-btn>
            <v-icon v-else-if="item.status == 2" color="red" v-on="on">
              mdi-close
            </v-icon>
          </template>
          <span v-if="item.status == 0">لم يتم الموافقة</span>
          <span v-else-if="item.status == 1">تم الموافقة</span>
          <span v-else-if="item.status == 2">تم الرفض</span>
        </v-tooltip>
      </div>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <div class="align-center">
        <deleteDialog
          :id="item.id"
          @ok="$emit('delete', item.id)"
        ></deleteDialog>
        <v-btn
          @click="$emit('update', item)"
          class="mx-1"
          :disabled="item.status == 1"
          x-small
          :fab="$vuetify.breakpoint.name != 'sm'"
          color="warning"
        >
          <v-icon>mdi-pen</v-icon>
        </v-btn>
      </div>
    </template>
  </v-data-table>
</template>

<script>
import html2pdf from "html2pdf.js";
import deleteDialog from "./deleteDialog.vue";
export default {
  components: {
    deleteDialog,
  },
  methods: {
    download(id) {
      // download file usin windows

      this.$axios
        .get("/requestDocuments/" + id + "/download")
        .then((res) => {
          console.log(res.data);
          html2pdf(res.data, {
            margin: 1,
            filename: "document.pdf",
            image: { type: "jpeg", quality: 0.98 },
            html2canvas: { dpi: 300, letterRendering: false, useCORS: true },
            jsPDF: {
              unit: "mm",
              format: "a4",
              orientation: "portrait",
            },
          });
          this.snack = true;
          this.snackColor = "green";
          this.snackText = "لقد تم  التحميل";
        })
        .catch((error) => {
          this.snack = true;
          this.snackColor = "red";
          this.snackText = error.response.data.error
            ? error.response.data.error
            : "لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا";
        });
    },
  },
  props: ["request", "headers"],
};
</script>

<style></style>
