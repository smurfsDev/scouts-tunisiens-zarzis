<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="leaders"
      show-expand
      :single-expand="true"
      :expanded.sync="expanded"
      item-key="id"
      class="elevation-1"
    >
      <template v-slot:[`item.user.image`]="{ item }">
        <v-avatar size="64">
          <img :src="item.user.image" alt="لا يوجد صورة" />
        </v-avatar>
      </template>
      <template v-slot:[`item.troupe.name`]="{ item }">
        <td>{{ item.troupe ? item.troupe.name : "فوج" }}</td>
      </template>
      <template v-slot:[`item.role.name`]="{ item }">
        <td>{{ item.role.name!=="معين قائد وحدة" ? item.role.name : item.role.name+"("+item.responsability[0].name+")"}}</td>
      </template>
      <template v-slot:expanded-item="{ item }">
        <td>
          <v-card>
            العمر:
            {{
              Math.floor(
                (new Date() - new Date(item.user.birth_date)) / 31557600000
              )
            }}
          </v-card>
        </td>
        <td>
          <v-card> ر.ب.و: {{ item.user.cin }} </v-card>
        </td>
        <td>
          <v-card> البريد الالكتروني: {{ item.user.email }} </v-card>
        </td>
        <td>
          <v-card> رقم الهاتف: {{ item.user.phone_number }} </v-card>
        </td>
        <td>
          <v-card>
            تاريخ انشاء الحساب:
            {{
              new Date(item.user.created_at).getDate() +
              "/" +
              (new Date(item.user.created_at).getMonth() + 1) +
              "/" +
              new Date(item.user.created_at).getFullYear()
            }}
          </v-card>
        </td>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <div class="align-center">
          <v-btn
            @click="reject(item.id)"
            class="mx-1"
            :disabled="item.status == 0"
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
          this.snack = true;
          this.snackColor = "red";
          this.snackText = error.response.data.error
            ? error.response.data.error
            : "لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا";
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
          this.snackText = error.response.data.error
            ? error.response.data.error
            : "لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا";
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
          text: "الاسم",
          value: "user.first_name",
        },
        {
          text: "اللقب",
          value: "user.last_name",
        },
        {
          text: "المهمة",
          value: "role.name",
        },
        {
          text: "الفرقة",
          value: "troupe.name",
          default: "الفرقة",
        },
        {
          text: "الصورة",
          value: "user.image",
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

<style></style>
