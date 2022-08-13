<template>
  <v-row class="">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="text-h5">اضافة ورشة</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-text-field
                  prepend-icon="mdi-card-text-outline"
                  v-model="form.name"
                  :error-messages="nameError"
                  label=" اسم الوشة"
                  required
                  outlined
                  counter="255"
                  class="mt-3"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <v-textarea
                  prepend-icon="mdi-card-text-outline"
                  v-model="form.description"
                  :error-messages="descriptionError"
                  label=" وصف الورشة"
                  required
                  outlined
                  counter="255"
                  class="mt-3"
                ></v-textarea>
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <label class="float-right"
                  ><v-icon right>mdi-calendar</v-icon>تاريخ بداية الورشة
                </label>
                <br />
                <input
                  type="datetime-local"
                  class="mt-3 float-left"
                  prepend-icon="mdi-calendar"
                  v-model="form.heure_debut"
                  :error-messages="heure_debutError"
                  label="تاريخ بداية الورشة"
                  required
                  outlined
                />
              </v-col>
              <v-col cols="12" sm="12" md="12" lg="12" xl="12">
                <br />
                <label class="float-right"
                  ><v-icon right>mdi-calendar</v-icon>تاريخ انتهاء الورشة
                </label>
                <br />
                <input
                  type="datetime-local"
                  prepend-icon="mdi-calendar"
                  v-model="form.heure_fin"
                  :error-messages="heure_finError"
                  label="تاريخ انتهاء الورشة"
                  required
                  outlined
                  class="mt-3"
                />
              </v-col>

              <v-col>
                <v-select
                  :items="items.name"
                  :value="items.id"
                  label="اسم القائد"
                  v-model="form.leader"
                  :error-messages="leaderError"
                  required
                  outlined
                ></v-select>
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
import { required, minLength, maxLength } from "vuelidate/lib/validators";
const dateValidator = (date) => {
  return new Date(date).setHours(0, 0, 0, 0) >= new Date().setHours(0, 0, 0, 0);
};
export default {
  validations: {
    form: {
      name: {
        required,
        minLength: minLength(3),
        maxLength: maxLength(255),
      },
      description: {
        required,
        minLength: minLength(3),
        maxLength: maxLength(255),
      },
      heure_debut: {
        required,
        dateValidator,
      },
      heure_fin: {
        required,
        dateValidator,
        minValue(val, { heure_debut }) {
          return (
            new Date(val).setHours(0, 0, 0, 0) >=
            new Date(heure_debut).setHours(0, 0, 0, 0)
          );
        },
      },
      leader: {
        required,
      },
    },
  },
  props: {
    dialog: {
      type: Boolean,
      default: false,
    },
    demandeEvent: {
      type: Object,
      default: () => ({}),
    },
    editw: {
      type: Boolean,
      default: false,
    },
  },
  created() {
    // this.getMaterials();
  },
  data: () => ({
    form: {
      name: "",
      description: "",
      heure_debut: null,
      heure_fin: null,
      leader: null,
    },
    items: [],
    activator: null,
    attach: null,
    colors: ["green", "purple", "indigo", "cyan", "teal", "orange"],
    editing: null,
    editingIndex: -1,
    // items: [],
    visible_items: [],
    nonce: 1,
    menu: false,
    model: [],
    x: 0,
    search: null,
    y: 0,
  }),
  methods: {
    reset() {
      this.form = {
        name: "",
        description: "",
        heure_debut: null,
        heure_fin: null,
        type: null,
      };

      this.$emit("close");
    },
    add() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      }
      this.form.eventEdit = this.model;
      if (this.editw == false) {
        // if (this.form.type == "صغرى") {
        //   this.form.type = 0;
        // } else {
        //   this.form.type = 1;
        // }
        console.log(this.form);

        this.$axios
          .post("/events/create", this.form)
          .then(() => {
            this.$emit("success", {
              show: true,
              type: "success",
              msg: "تم اضافة طلب انشاء تظاهرة بنجاح",
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
        if (this.form.type == "صغرى") {
          this.form.type = 0;
        } else {
          this.form.type = 1;
        }
        this.$axios
          .put("/events/update/" + this.demandeEvent.id, this.form)
          .then(() => {
            this.$emit("success", {
              show: true,
              type: "success",
              msg: "تمت تعديل الطلب بنجاح",
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
    filter(item, queryText, itemText) {
      if (item.header) return false;

      const hasValue = (val) => (val != null ? val : "");

      const text = hasValue(itemText);
      const query = hasValue(queryText);

      return (
        text.toString().toLowerCase().indexOf(query.toString().toLowerCase()) >
        -1
      );
    },
    // getMaterials() {
    //   this.$axios.get("/all-materiel").then((response) => {
    //     this.items = response.data;
    //     this.visible_items = response.data;
    //   });
    // },
  },
  computed: {
    nameError() {
      const errors = [];
      if (!this.$v.form.name.$dirty) return errors;
      !this.$v.form.name.required && errors.push("الرجاء ادخال اسم الورشة");
      !this.$v.form.name.minLength &&
        errors.push("اسم الورشة لا يجب ان يقل عن 3 حروف");
      !this.$v.form.name.maxLength &&
        errors.push("اسم الورشة لا يجب ان يتجاوز 3 حروف");
      return errors;
    },
    descriptionError() {
      const errors = [];
      if (!this.$v.form.description.$dirty) return errors;
      !this.$v.form.description.required &&
        errors.push("الرجاء ادخال وصف الورشة");
      !this.$v.form.description.minLength &&
        errors.push("وصف الورشة لا يجب ان يقل عن 3 حروف");
      !this.$v.form.description.maxLength &&
        errors.push("وصف الورشة لا يجب ان يتجاوز 3 حروف");
      return errors;
    },
    heure_debutError() {
      const errors = [];
      if (!this.$v.form.heure_debut.$dirty) return errors;
      !this.$v.form.heure_debut.required &&
        errors.push("الرجاء ادخال تاريخ بداية الورشة");
      !this.$v.form.heure_debut.dateValidator &&
        errors.push("تاريخ بداية الورشة لا يمكن ان يكون في الماضي");
      return errors;
    },
    leaderError() {
      const errors = [];
      if (!this.$v.form.leader.$dirty) return errors;
      !this.$v.form.leader.required && errors.push("الرجاء ادخال قائد للورشة");

      return errors;
    },
    heure_finError() {
      const errors = [];
      if (!this.$v.form.heure_fin.$dirty) return errors;
      !this.$v.form.heure_fin.required &&
        errors.push("الرجاء ادخال تاريخ نهاية الورشة ");
      !this.$v.form.heure_fin.dateValidator &&
        errors.push("تاريخ نهاية الورشة لا يمكن ان يكون في الماضي");
      !this.$v.form.heure_fin.minValue &&
        errors.push("تاريخ نهاية الورشة لا يمكن ان يكون قبل تاريخ البداية");
      return errors;
    },
  },
  watch: {
    dialog() {
      this.form = this.dialog
        ? Object.assign({}, this.demandeEvent)
        : {
            name: "",
            // message: "",
            heure_debut: "",
            heure_fin: "",
          };
      this.model = this.demandeEvent
        ? Object.assign([], this.demandeEvent.eventEdit)
        : [];
    },
  },
};
</script>

<style>
</style>