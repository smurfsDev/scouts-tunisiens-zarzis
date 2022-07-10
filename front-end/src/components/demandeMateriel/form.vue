<template>
  <v-row class="">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="text-h5">اضافة اثاث</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-textarea
                  prepend-icon="mdi-card-text-outline"
                  v-model="form.message"
                  :error-messages="messageError"
                  label="الرسالة"
                  required
                  outlined
                  counter="255"
                  class="mt-3"
                ></v-textarea>
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-text-field
                  type="date"
                  prepend-icon="mdi-calendar"
                  v-model="form.date_demande"
                  :error-messages="date_demandeError"
                  label="تاريخ الطلب"
                  required
                  outlined
                  class="mt-3"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red darken-1" text @click="reset"> اغلاق </v-btn>
          <v-btn color="success darken-1" @click="add"> اضافة </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
import {
  required,
  minLength,
  maxLength,
} from "vuelidate/lib/validators";
const dateValidator = (date) => {
  return new Date(date).setHours(0, 0, 0, 0) >= new Date().setHours(0, 0, 0, 0);
};
export default {
  validations: {
    form: {
      message: {
        required,
        minLength: minLength(3),
        maxLength: maxLength(255),
      },
      date_demande: {
        required,
        dateValidator
      },
    },
  },
  props: {
    dialog: {
      type: Boolean,
      default: false,
    },
    demandeMateriel: {
      type: Object,
      default: () => ({}),
    },
    editm: {
      type: Boolean,
      default: false,
    },
  },
  created() {
  },
  data: () => ({
    form: {
      message: "",
      date_demande: null,
    },

  }),
  methods: {
    reset() {
      this.form = {
        message: "",
        date_demande:null,
      };
      this.$emit("close");
    },
    add() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      }
      this.form.categories = this.model;
      if (this.editm == false) {
        this.$axios
          .post("/demande-materiel/", this.form)
          .then(() => {
            this.$emit("success", {
              show: true,
              type: "success",
              msg: "تم اضافة الطلب بنجاح",
            });
            this.reset();
          })
          .catch(() => {
            this.$emit("success", {
              show: true,
              type: "red",
              msg: "حدث خطأ ما",
            });
            this.reset();
          });
      } else {
        this.$axios
          .put("/demande-materiel/" + this.demandeMateriel.id, this.form)
          .then(() => {
            this.$emit("success", {
              show: true,
              type: "success",
              msg: "تمت تعديل الاثاث بنجاح",
            });
            this.reset();
          })
          .catch(() => {
            this.$emit("success", {
              show: true,
              type: "red",
              msg: "حدث خطأ ما",
            });
            this.reset();
          });
      }
    },
  },
  computed: {
    messageError() {
      const errors = [];
      if (!this.$v.form.message.$dirty) return errors;
      !this.$v.form.message.required &&
        errors.push("الرجاء ادخال الرسالة");
      !this.$v.form.message.minLength &&
        errors.push("الرجاء ادخال الرسالة بحد اقل 3 حروف");
      !this.$v.form.message.maxLength &&
        errors.push("الرجاء ادخال الرسالة بحد اكثر 255 حروف");
      return errors;
    },
    date_demandeError() {
      const errors = [];
      if (!this.$v.form.date_demande.$dirty) return errors;
      !this.$v.form.date_demande.required &&
        errors.push("الرجاء ادخال تاريخ الطلب");
      !this.$v.form.date_demande.dateValidator &&
        errors.push("تاريخ الطلب لا يمكن ان يكون في الماضي");
      return errors;
    },
  },
  watch: {
    dialog() {
      this.form = this.dialog
        ? Object.assign({}, this.demandeMateriel)
        : {
            name: "",
            message: "",
            date_demande: "",
          };
    },
  },
};
</script>

<style>
</style>