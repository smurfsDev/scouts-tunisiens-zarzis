<template>
  <div>
    <v-card class="elevation-12">
      <v-toolbar dark color="blue">
        <v-toolbar-title>
          <div class="d-flex justify-content-center">
            <p style="text-align: center !important">أضف حدث</p>
          </div>
        </v-toolbar-title>
      </v-toolbar>
      <v-card-text>
        <form @submit.prevent="Add_events()">
          <div class="row">
            <div class="col-md-12">
              <v-text-field
                name="Name"
                :error-messages="titre_error"
                v-model="formdata.titre"
                label="اسم"
                type="text"
                outlined
                counter="8"
              ></v-text-field>
            </div>
            <div class="col-md-12">
              <v-textarea
                v-model="formdata.description"
                :error-messages="description_error"
                name="input-7-1"
                label="وصف"
                counter="255"
                outlined
              ></v-textarea>
            </div>
            <div class="row">
             <div class="col-lg-6">
            <v-text-field
                type="date"
                 prepend-icon="mdi-calendar"
                v-model="formdata.date_debut"
                :error-messages="date_debut_error"
                label="تاريخ البدء"
                outlined
                class="mt-3"
           ></v-text-field>
           </div>
           <div class="col-lg-6">
           <v-text-field
              type="date"
              prepend-icon="mdi-calendar"
              v-model="formdata.date_fin"
              :error-messages="date_fin_error"
              label="تاريخ الانتهاء"
              outlined
              class="mt-3"
           ></v-text-field>
           </div>
           <div class="col-lg-12">
            <v-select
            :items="region"
             label="الموقع"
             class="mt-3"
             v-model="formdata.location"
             :error-messages="location_error"
             outlined
         ></v-select>
           </div>
           </div>
          </div>
          <v-btn
            type="submit"
            style="color: #fff !important"
            color="blue"
            class="mx-2"
          >
            أضف حدثًا
          </v-btn>
        </form>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
const dateValidator = (date) => {
  return new Date(date).setHours(0, 0, 0, 0) >= new Date().setHours(0, 0, 0, 0);
};
import { required, minLength, maxLength } from "vuelidate/lib/validators";
export default {
  validations: {
    formdata: {
      titre: {
        required,
        minLength: minLength(5),
        maxLength: maxLength(10),
      },
      description: {
        required,
        minLength: minLength(8),
        maxLength: maxLength(255),
      },
      date_debut:{
        required,
        dateValidator,
      },
      date_fin:{
        required,
        dateValidator,
        minValue(val, { date_debut }) {
          return (
            new Date(val).setHours(0, 0, 0, 0) >=
            new Date(date_debut).setHours(0, 0, 0, 0)
          );
        },
      },
      location:{
        required
      }
    },
  },
  name: "addevent",

  data() {
    return {
      region:['أريانة','باجة','	بنزرت','بن عروس','تطاوين','توزر','تونس','جندوبة','زغوان',
              'سليانة','سوسة','سيدي بوزيد','صفاقس','قابس','قبلي','القصرين','قفصة','القيروان',
            'الكاف','مدنين','المنستير','منوبة','المهدية','نابل'
        ],
      formdata: {
        titre: "",
        description: "",
        date_debut: "",
        date_fin: "",
        location: "",
      },
    };
  },
  methods: {
    Add_events() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      }
    },
    return_to_consulte() {
      this.$emit("cancel_add_events");
    },
  },
  computed: {
    titre_error() {
      const errors = [];
      if (!this.$v.formdata.titre.$dirty) return errors;
      !this.$v.formdata.titre.required && errors.push("الرجاء ادخال اسم");
      !this.$v.formdata.titre.minLength &&
        errors.push("الرجاء ادخال اسم بحد اقل 5 حروف");
      !this.$v.formdata.titre.maxLength &&
        errors.push("الرجاء ادخال اسم بحد اكثر 10 حروف");
      return errors;
    },
    description_error() {
      const errors = [];
      if (!this.$v.formdata.description.$dirty) return errors;
      !this.$v.formdata.description.required && errors.push("الرجاء ادخال وصف");
      !this.$v.formdata.description.maxLength &&
        errors.push("الرجاء ادخال وصف بحد اقل 255 حروف");
      !this.$v.formdata.description.minLength &&
        errors.push("الرجاء ادخال وصف بحد اقل 8 حروف");
      return errors;
    },
    date_debut_error(){
        const errors=[];
        if(!this.$v.formdata.date_debut.$dirty) return errors;
        !this.$v.formdata.date_debut.required && errors.push("الرجاء ادخال تاريخ البدء");
        !this.$v.formdata.date_debut.dateValidator && errors.push("تاريخ الحدث لا يمكن ان يكون في الماضي");
        return errors;
    },
    date_fin_error(){
        const errors=[];
        if(!this.$v.formdata.date_fin.$dirty) return errors;
        !this.$v.formdata.date_fin.required && errors.push("الرجاء ادخال تاريخ الانتهاء");
        !this.$v.formdata.date_fin.dateValidator && errors.push("تاريخ الانتهاء لا يمكن ان يكون في الماضي");
        !this.$v.formdata.date_fin.minValue && errors.push("تاريخ الانتهاء لا يمكن ان يكون قبل تاريخ البدء");
        return errors;
    },
    location_error(){
        const errors=[];
        if(!this.$v.formdata.location.$dirty) return errors;
        !this.$v.formdata.location.required && errors.push("الرجاء ادخال الموقع ");
        return errors;
    }
  },
};
</script>
