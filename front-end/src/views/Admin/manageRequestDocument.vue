<template>
  <v-container>
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
          <v-btn
            @click="reject(item.id)"
            class="mx-1"
            :disabled="item.status == 2"
            x-small
            :fab="$vuetify.breakpoint.name != 'sm'"
            color="red"
          >
            <v-icon color="white">mdi-close-outline</v-icon>
          </v-btn>
          <v-btn
            @click="accept(item.id)"
            class="mx-1"
            :disabled="item.status == 1"
            x-small
            :fab="$vuetify.breakpoint.name != 'sm'"
            color="success"
          >
            <v-icon>mdi-check-outline</v-icon>
          </v-btn>
        </div>
      </template>
    </v-data-table>
    <v-snackbar v-model="snack" :timeout="10000" :color="snackColor">
      {{ snackText }}

      <template v-slot:action="{ attrs }">
        <v-btn v-bind="attrs" text @click="snack = false"> اغلاق </v-btn>
      </template>
    </v-snackbar>
  </v-container>
</template>

<script>
import html2pdf from "html2pdf.js";

export default {
  components: {},
  data() {
    return {
      request: [],
      troupe: {},
      snack: false,
      snackColor: "",
      dialog: false,
      snackText: "",
      edit: false,
    };
  },
  created() {
    this.getrequestDocuments();
  },
  methods: {
    getrequestDocuments() {
      this.$axios
        .get("/requestDocuments")
        .then((response) => {
          this.request = response.data;
          console.log(this.request);
        })
        .catch((error) => {
          console.log(error);
          this.snack = true;
          this.snackColor = "red";
          this.snackText = error.response.data.error
            ? error.response.data.error
            : "لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا";
        });
    },
    accept(id) {
      this.$axios
        .put("/requestDocuments/" + id + "/approve")
        .then(() => {
          this.snack = true;
          this.snackColor = "success";
          this.snackText = "لقد تم القبول";
          this.getrequestDocuments();
        })
        .catch((error) => {
          this.snack = true;
          this.snackColor = "red";
          this.snackText = error.response.data.error
            ? error.response.data.error
            : "لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا";
        });
    },
    reject(id) {
      this.$axios
        .put("/requestDocuments/" + id + "/reject")
        .then(() => {
          this.snack = true;
          this.snackColor = "pink";
          this.snackText = "لقد تم الرفض";
          this.getrequestDocuments();
        })
        .catch((error) => {
          this.snack = true;
          this.snackColor = "red";
          this.snackText = error.response.data.error
            ? error.response.data.error
            : "لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا";
        });
    },
    download(id) {
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
  computed: {
    headers() {
      return [
        {
          text: "العنوان",
          value: "title",
        },
        {
          text: "الى",
          value: "to",
        },
        {
          text: "التاريخ",
          value: "date",
        },
        {
          text: "الحالة",
          value: "status",
        },
        {
          text: "اجرائات",
          value: "actions",
          sortable: false,
        },
      ];
    },
  },
};
</script>

<style></style>
