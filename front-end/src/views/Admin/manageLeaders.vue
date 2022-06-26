<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="leaders"
      sort-by="first_name"
      show-expand
      :single-expand="true"
      :expanded.sync="expanded"
      item-key="first_name"
      class="elevation-1"
    >
      <template v-slot:[`item.image`]="{ item }">
        <img :src="item.image" alt="لا يوجد صورة" />
      </template>
      <template v-slot:expanded-item="{ item }">
        <td>
          <v-card>
            العمر:
            {{
              Math.floor((new Date() - new Date(item.birth_date)) / 31557600000)
            }}
          </v-card>
        </td>
        <td>
          <v-card> ر.ب.و: {{ item.cin }} </v-card>
        </td>
        <td>
          <v-card> البريد الالكتروني: {{ item.email }} </v-card>
        </td>
        <td>
          <v-card> رقم الهاتف: {{ item.phone_number }} </v-card>
        </td>
        <td>
          <v-card>
            تاريخ انشاء الحساب:
            {{
              new Date(item.created_at).getDate() +
              "/" +
              (new Date(item.created_at).getMonth() + 1) +
              "/" +
              new Date(item.created_at).getFullYear()
            }}
          </v-card>
        </td>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <div class="align-center">
          <v-btn
            @click="reject(item.roles[0].id)"
            class="mx-1"
            :disabled="item.roles[0].status == 0"
            x-small
            :fab="$vuetify.breakpoint.name!='sm'"
            color="red"
          >
            <v-icon color="white">mdi-close-outline</v-icon>
          </v-btn>
          <v-btn
            @click="accept(item.roles[0].id)"
            class="mx-1"
            :disabled="item.roles[0].status == 1"
            x-small
            :fab="$vuetify.breakpoint.name!='sm'"
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
  </div>
</template>
<script>
export default {
  created() {
    this.getLeaders();
  },
  data() {
    return {
      snack: false,
      snackColor: "",
      snackText: "",
      expanded: [],
      singleExpand: false,
      leaders: [],
    };
  },
  methods: {
    getLeaders() {
      this.$axios
        .get("/leaders")
        .then((response) => {
          this.leaders = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    accept(id) {
      this.$axios
        .put("/leaders/" + id + "/accept")
        .then(() => {
          this.snack = true;
          this.snackColor = "success";
          this.snackText = "لقد تم القبول";
          this.getLeaders();
        })
        .catch((error) => {
          this.snack = true;
          this.snackColor = "red";
          this.snackText = error.response.data.error;
          console.log(error.response.data);
        });
    },
    reject(id) {
      this.$axios
        .put("/leaders/" + id + "/reject")
        .then(() => {
          this.snack = true;
          this.snackColor = "pink";
          this.snackText = "لقد تم الرفض";
          this.getLeaders();
        })
        .catch((error) => {
                    this.snack = true;
          this.snackColor = "red";
          this.snackText = "لقد حصل عط, الب ";

          console.log(error);
        });
    },
  },
  computed: {
    headers() {
      return [
        {
          text: "الاسم",
          value: "first_name",
        },
        {
          text: "اللقب",
          value: "last_name",
        },
        {
          text: "المهمة",
          value: "roles[0].role.name",
        },
        {
          text: "الفرقة",
          value: "roles[0].troupe.name",
          default: "الفرقة",
        },
        {
          text: "الصورة",
          value: "image",
          sortable: false,
          align: "center",
          class: "img-responsive",
        },
        {
          text: "اجرائات",
          value: "actions",
          sortable: false,
        },
        { text: "", value: "data-table-expand" },
      ];
    },
  },
};
</script>

<style>
</style>