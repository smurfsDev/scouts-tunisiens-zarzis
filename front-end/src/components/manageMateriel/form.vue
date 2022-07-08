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
                <v-text-field
                  prepend-icon="mdi-form-textbox"
                  v-model="form.name"
                  label="الاسم"
                  required
                  :error-messages="nameError"
                  outlined
                  counter="25"
                  class="mt-3"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-textarea
                  prepend-icon="mdi-card-text-outline"
                  v-model="form.description"
                  :error-messages="descriptionError"
                  label="الوصف"
                  required
                  outlined
                  counter="255"
                  class="mt-3"
                ></v-textarea>
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-text-field
                  type="number"
                  min="0"
                  prepend-icon="mdi-numeric"
                  v-model="form.quantity"
                  :error-messages="quantityError"
                  label="الكمية"
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
  numeric,
  minValue,
} from "vuelidate/lib/validators";

export default {
  validations: {
    form: {
      name: {
        required,
        minLength: minLength(3),
        maxLength: maxLength(25),
      },
      description: {
        required,
        minLength: minLength(3),
        maxLength: maxLength(255),
      },
      quantity: {
        required,
        numeric,
        min: minValue(0),
      },
    },
  },
  props: {
    dialog: {
      type: Boolean,
      default: false,
    },
    materiel: {
      type: Object,
      default: () => ({}),
    },
  },
  data: () => ({
    form: {
      name: "",
      description: "",
      quantity: "",
    },
  }),
  methods: {
    reset() {
      this.form.name = "";
      this.form.description = "";
      this.form.quantity = "";
      this.$emit("close");
    },
    add() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      }
      if (this.edit == false) {
        this.$axios
          .post("/materiel/", this.form)
          .then(() => {
            this.$emit("success", {
              show: true,
              type: "success",
              msg: "تمت اضافة الاثاث بنجاح",
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
          .put("/materiel/" + this.materiel.id, this.form)
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
    nameError() {
      const errors = [];
      if (!this.$v.form.name.$dirty) return errors;
      !this.$v.form.name.required && errors.push("الرجاء ادخال اسم الاثاث");
      !this.$v.form.name.minLength &&
        errors.push("الرجاء ادخال اسم الاثاث بحد اقل 3 حروف");
      !this.$v.form.name.maxLength &&
        errors.push("الرجاء ادخال اسم الاثاث بحد اكثر 25 حروف");
      return errors;
    },
    descriptionError() {
      const errors = [];
      if (!this.$v.form.description.$dirty) return errors;
      !this.$v.form.description.required &&
        errors.push("الرجاء ادخال وصف الاثاث");
      !this.$v.form.description.minLength &&
        errors.push("الرجاء ادخال وصف الاثاث بحد اقل 3 حروف");
      !this.$v.form.description.maxLength &&
        errors.push("الرجاء ادخال وصف الاثاث بحد اكثر 255 حروف");
      return errors;
    },
    quantityError() {
      const errors = [];
      if (!this.$v.form.quantity.$dirty) return errors;
      !this.$v.form.quantity.required &&
        errors.push("الرجاء ادخال كمية الاثاث");
      !this.$v.form.quantity.numeric &&
        errors.push("الرجاء ادخال كمية الاثاث أرقام");
      !this.$v.form.quantity.min &&
        errors.push("الرجاء ادخال كمية الاثاث بحد اقل 0");
      return errors;
    },
  },
  watch: {
    materiel() {
      this.form = Object.assign({}, this.materiel);
    },
  },
};
</script>

<style>
</style>