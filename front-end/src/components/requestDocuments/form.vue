<template>
  <v-row class="">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="text-h5">اضافة مطلب</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-text-field
                  prepend-icon="mdi-form-textbox"
                  v-model="form.title"
                  label="العنوان"
                  required
                  :error-messages="titleError"
                  outlined
                  counter="25"
                  class="mt-3"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-text-field
                  prepend-icon="mdi-form-textbox"
                  v-model="form.to"
                  label="الى"
                  required
                  :error-messages="toError"
                  outlined
                  counter="25"
                  class="mt-3"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-text-field
                  type="date"
                  prepend-icon="mdi-calendar"
                  v-model="form.date"
                  :error-messages="dateError"
                  label="تاريخ"
                  required
                  outlined
                  class="mt-3"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-text-field
                  prepend-icon="mdi-form-textbox"
                  v-model="form.location"
                  label="المكان"
                  required
                  :error-messages="locationError"
                  outlined
                  counter="25"
                  class="mt-3"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-text-field
                  prepend-icon="mdi-form-textbox"
                  v-model="form.subject"
                  label="الموضوع"
                  required
                  :error-messages="subjectError"
                  outlined
                  counter="25"
                  class="mt-3"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-textarea
                  prepend-icon="mdi-card-text-outline"
                  v-model="form.body"
                  :error-messages="bodyError"
                  label="المحتوى"
                  required
                  outlined
                  counter="255"
                  class="mt-3"
                ></v-textarea>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red darken-1" text @click="reset"> اغلاق </v-btn>
          <v-btn color="success darken-1" @click="add">
            {{ edit ? "تحديث" : "اضافة" }}
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
import { required, minLength, maxLength } from "vuelidate/lib/validators";
const dateValidator = (date) => {
  return new Date(date).setHours(0, 0, 0, 0) >= new Date().setHours(0, 0, 0, 0);
};
export default {
  props: {
    dialog: {
      type: Boolean,
      default: false,
    },
    troupe: {
      type: Object,
      default: () => ({}),
    },
    edit: {
      type: Boolean,
      default: false,
    },
  },
  created() {},
  data: () => ({
    form: {
      title: "",
      to: "",
      subject: "",
      date: "",
      location: "",
      body: "",
    },
  }),
  validations() {
    return {
      form: {
        title: {
          required,
          minLength: minLength(3),
          maxLength: maxLength(25),
        },
        to: {
          required,
          minLength: minLength(3),
          maxLength: maxLength(25),
        },
        subject: {
          required,
          minLength: minLength(3),
          maxLength: maxLength(25),
        },
        date: {
          required,
          dateValidator,
        },
        location: {
          required,
          minLength: minLength(3),
          maxLength: maxLength(25),
        },
        body: {
          required,
          minLength: minLength(3),
          maxLength: maxLength(255),
        },
      },
    };
  },
  methods: {
    reset() {
      this.form = {
        title: "",
        body: "",
        gender: "H",
        min_age: "",
        max_age: "",
      };
      this.$emit("close");
    },
    add() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.$emit("add", this.form);
        this.reset();
      }
    },
  },
  computed: {
    titleError() {
      const errors = [];
      if (!this.$v.form.title.$dirty) return errors;
      !this.$v.form.title.required && errors.push("الرجاء ادخال عنوان");
      !this.$v.form.title.minLength &&
        errors.push("الرجاء ادخال عنوان بحد اقل 3 حروف");
      !this.$v.form.title.maxLength &&
        errors.push("الرجاء ادخال عنوان بحد اكثر 25 حروف");
      return errors;
    },
    toError() {
      const errors = [];
      if (!this.$v.form.to.$dirty) return errors;
      !this.$v.form.to.required && errors.push("الرجاء ادخال 'المبعوث له'");
      !this.$v.form.to.minLength &&
        errors.push("الرجاء ادخال 'المبعوث له' بحد اقل 3 حروف");
      !this.$v.form.to.maxLength &&
        errors.push("الرجاء ادخال 'المبعوث له' بحد اكثر 25 حروف");
      return errors;
    },
    locationError() {
      const errors = [];
      if (!this.$v.form.location.$dirty) return errors;
      !this.$v.form.location.required && errors.push("الرجاء ادخال المكان");
      !this.$v.form.location.minLength &&
        errors.push("الرجاء ادخال المكان بحد اقل 3 حروف");
      !this.$v.form.location.maxLength &&
        errors.push("الرجاء ادخال المكان بحد اكثر 25 حروف");
      return errors;
    },
    subjectError() {
      const errors = [];
      if (!this.$v.form.subject.$dirty) return errors;
      !this.$v.form.subject.required && errors.push("الرجاء ادخال موضوع");
      !this.$v.form.subject.minLength &&
        errors.push("الرجاء ادخال موضوع بحد اقل 3 حروف");
      !this.$v.form.subject.maxLength &&
        errors.push("الرجاء ادخال موضوع بحد اكثر 25 حروف");
      return errors;
    },
    dateError() {
      const errors = [];
      if (!this.$v.form.date.$dirty) return errors;
      !this.$v.form.date.required && errors.push("الرجاء ادخال تاريخ ");
      !this.$v.form.date.dateValidator &&
        errors.push("تاريخ  لا يمكن ان يكون في الماضي");
      return errors;
    },
    bodyError() {
      const errors = [];
      if (!this.$v.form.body.$dirty) return errors;
      !this.$v.form.body.required && errors.push("الرجاء ادخال محتوى الرسالة");
      !this.$v.form.body.minLength &&
        errors.push("الرجاء ادخال محتوى الرسالة بحد اقل 3 حروف");
      !this.$v.form.body.maxLength &&
        errors.push("الرجاء ادخال محتوى الرسالة بحد اكثر 255 حروف");
      return errors;
    },
  },
  watch: {
    dialog() {
      this.form = this.dialog
        ? Object.assign({}, this.troupe)
        : {
            name: "",
            body: "",
            min_age: "",
            max_age: "",
          };
    },
  },
};
</script>

<style></style>
