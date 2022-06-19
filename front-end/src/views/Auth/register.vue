<template>
  <div>
    <b-alert
      class="mt-4"
      :show="alert.dismissCountDown"
      dismissible
      :variant="alert.variant"
      @dismissed="alert.dismissCountDown = 0"
    >
      <p>{{ alert.msg }}</p>
    </b-alert>
    <form-wizard @onComplete="onComplete">
      <tab-content title="معلومات شخصية" :selected="true">
        <div class="form-group">
          <label for="first_name">الأسم</label>
          <input
            type="text"
            name="prenom"
            class="form-control"
            :class="hasError('first_name') ? 'is-invalid' : ''"
            placeholder="ادخل اسمك"
            v-model="formData.first_name"
          />
          <div v-if="hasError('first_name')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.first_name.required">
              الرجاء ادخال اسمك.
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="last_name">اللقب</label>
          <input
            type="text"
            name="nom"
            class="form-control"
            :class="hasError('last_name') ? 'is-invalid' : ''"
            placeholder="ادخل لقبك"
            v-model="formData.last_name"
          />
          <div v-if="hasError('last_name')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.last_name.required">
              الرجاء ادخال لقبك.
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="birth_date">تاريح الولادة</label>
          <input
            type="date"
            class="form-control"
            :class="hasError('birth_date') ? 'is-invalid' : ''"
            placeholder="الرجاء ادخال تاريخ ولادتك"
            v-model="formData.birth_date"
          />
          <div v-if="hasError('birth_date')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.birth_date.required">
              الرجاء ادخال تاريخ ولادتك.
            </div>
            <div class="error" v-if="!$v.formData.birth_date.dateValidator">
              الرجاء ادخال تاريخ ولادتك بشكل صحيح.
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="sexe">الجنس</label>
          <select
            class="form-control"
            :class="hasError('sexe') ? 'is-invalid' : ''"
            v-model="formData.sexe"
          >
            <option disabled="disabled" selected="selected">اختر جنسك</option>

            <option value="F">انثى</option>
            <option value="H">ذكر</option>
          </select>
          <div v-if="hasError('sexe')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.sexe.required">
              الرجاء اختيار جنسك.
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="cin">رقم ب.ت.و</label>
          <input
            type="number"
            name="cin"
            class="form-control"
            :class="hasError('cin') ? 'is-invalid' : ''"
            placeholder="ادخل رقم ب.ت.و"
            v-model="formData.cin"
          />
          <div v-if="hasError('cin')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.cin.required">
              الرجاء ادخال رقم ب.ت.و(او رقم ب.ت.و الولي )
            </div>
            <div
              class="error"
              v-if="!$v.formData.cin.numeric || !$v.formData.cin.between"
            >
              الرجاء ادخال رقم ب.ت.و بشكل صحيح.
            </div>
            <!-- <div
              class="error"
              v-if="!$v.formData.cin.isUnique"
            >
              Cette cin est deja utilisée.
            </div> -->
          </div>
        </div>
        <span class="caption">
          هل لديك حساب ?
          <router-link color="primary" to="/login"
            >تسجيل الدخول</router-link
          ></span
        >
      </tab-content>
      <tab-content title="المعطيات الكشفية">
        <div class="form-group">
          <label for="role">مهمة</label>
          <select
            :class="hasError('role') ? 'is-invalid' : ''"
            class="form-control"
            v-model="formData.role"
          >
            <option disabled="disabled" selected="selected">اختر مهمتك</option>
            <option v-for="role in roles" :key="role.id" :value="role.id">
              {{ role.name }}
            </option>
          </select>
          <div v-if="hasError('role')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.role.required">
              <span>مهمة مطلوبة</span>
            </div>
          </div>
        </div>
        <div
          class="form-group"
          v-if="
            roles.length != 0 &&
            roles[formData.role ? formData.role - 2 : 0].name != 'قيادة الفوج'
          "
        >
          <label for="troupe">الفرقة</label>
          <select
            :class="hasError('troupe') ? 'is-invalid' : ''"
            class="form-control"
            v-model="formData.troupe"
          >
            <option disabled="disabled" selected="selected">اختر فرقتك</option>

            <option
              v-for="troupe in troupes"
              :key="troupe.id"
              v-show="
                (age >= troupe.min_age &&
                age <= troupe.max_age ||
            roles[formData.role ? formData.role - 2 : 0].name != 'قيادة الفوج')&&
                formData.sexe == troupe.gender
              "
              :value="troupe.id"
            >
              {{ troupe.name }}
            </option>
          </select>
          <div v-if="hasError('troupe')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.troupe.required">
              <span>الفرقة مطلوبة</span>
            </div>
          </div>
        </div>
      </tab-content>
      <tab-content title="الاتصال">
        <div class="form-group">
          <div class="form-group">
            <label for="email">البريد الإلكتروني</label>
            <input
              type="email"
              name="email"
              class="form-control"
              :class="hasError('email') ? 'is-invalid' : ''"
              placeholder="ادخل البريد الإلكترونيك"
              v-model="formData.email"
            />
            <div v-if="hasError('email')" class="invalid-feedback">
              <div class="error" v-if="!$v.formData.email.required">
                الرجاء ادخال البريد الإلكتروني.
              </div>
              <div class="error" v-if="!$v.formData.email.email">
                الرجاء ادخال البريد الإلكتروني بشكل صحيح.
              </div>
              <div class="error" v-if="!$v.formData.email.isUnique">
                البريد الإلكتروني هذا مستخدم من قبل.
              </div>
            </div>
          </div>
          <label for="phone_number">رقم الهاتف</label>
          <input
            type="number"
            name="phone_numberf"
            class="form-control"
            :class="hasError('phone_number') ? 'is-invalid' : ''"
            placeholder="ادخل رقم الهاتف"
            v-model="formData.phone_number"
          />
          <div v-if="hasError('phone_number')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.phone_number.required">
              الرجاء ادخال رقم الهاتف.
            </div>
            <div
              class="error"
              v-if="
                !$v.formData.phone_number.numeric ||
                !$v.formData.phone_number.between
              "
            >
              الرجاء ادخال رقم الهاتف بشكل صحيح.
            </div>
          </div>
        </div>
      </tab-content>
      <tab-content title="معرفات">
        <div class="form-group">
          <label for="password">الرمز السري</label>
          <input
            type="password"
            :class="hasError('password') ? 'is-invalid' : ''"
            class="form-control"
            v-model="formData.password"
          />
          <div v-if="hasError('password')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.password.required">
              الرجاء ادخال رمز السر.
            </div>
            <div
              class="error"
              v-if="
                !$v.formData.password.minLength ||
                !$v.formData.password.maxLength
              "
            >
              الرمز السري يجب ان يكون بين 8 و 30 حرف.
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="confirm_password">اعادة الرمز السري</label>
          <input
            :class="hasError('confirm_password') ? 'is-invalid' : ''"
            class="form-control"
            type="password"
            v-model="formData.confirm_password"
          />
          <div v-if="hasError('confirm_password')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.confirm_password.required">
              الرجاء ادخال رمز السر مرة اخرى.
            </div>
            <div
              class="error"
              v-if="
                !$v.formData.confirm_password.minLength ||
                !$v.formData.confirm_password.maxLength
              "
            >
              الرمز السري يجب ان يكون بين 8 و 30 حرف.
            </div>
            <div class="error" v-if="!$v.formData.confirm_password.confirmed">
              الرجاء ادخال رمز السر مرة اخرى.
            </div>
          </div>
        </div>
      </tab-content>
    </form-wizard>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import { FormWizard, TabContent, ValidationHelper } from "vue-step-wizard";
import "vue-step-wizard/dist/vue-step-wizard.css";
import {
  required,
  requiredIf,
  email,
  numeric,
  between,
  minLength,
  maxLength,
  sameAs,
} from "vuelidate/lib/validators";
const dateValidator = (date) => {
  return new Date(date).setHours(0, 0, 0, 0) <= new Date().setHours(0, 0, 0, 0);
};
export default {
  name: "StepFormValidation",
  components: {
    FormWizard,
    TabContent,
  },
  mixins: [ValidationHelper],
  updated() {
    // console.log(this.age);
  },
  data() {
    return {
      roles: [],
      troupes: {},
      uniqueCin: false,
      uniqueEmail: false,
      formData: {
        first_name: "",
        last_name: "",
        email: null,
        cin: null,
        password: null,
        confirm_password: null,
        birth_date: null,
        role: null,
        troupe: null,
        sexe: null,
      },
      validationRules: [
        {
          first_name: { required },
          last_name: { required },
          birth_date: { required, dateValidator },
          sexe: { required },
          cin: {
            required,
            numeric,
            between: between(1000000, 99999999),
          },
        },
        {
          role: {
            required,
          },
          troupe: {
            required: requiredIf(function () {
              let index =
                this.formData.role !== null ? this.formData.role - 2 : 0;
              return this.roles.length != 0
                ? this.roles[index].name != "قيادة الفوج"
                : false;
            }),
          },
        },
        {
          phone_number: { required, between: between(10000000, 99999999) },
          email: {
            required,
            email,
            async isUnique(value) {
              const response = await this.$axios(`/unique/${value}`);
              return response.status == 200 || value == "";
            },
          },
        },
        {
          password: {
            required,
            minLength: minLength(8),
            maxLength: maxLength(30),
          },
          confirm_password: {
            required,
            minLength: minLength(8),
            maxLength: maxLength(30),
            confirmed: sameAs("password"),
          },
        },
      ],
      alert: {
        dismissCountDown: null,
        variant: null,
        msg: null,
      },
    };
  },
  methods: {
    ...mapActions(["register"]),
    Register() {
      this.alert.msg = "";
      this.register(this.formData)
        .then(() => {
          if (this.$store.getters.regStatus == 2) {
            this.alert.dismissCountDown = 10;
            this.alert.variant = "danger";
            this.alert.msg = this.$store.getters.regMessage;
          }
        })
        .catch(() => {});
    },
    onComplete() {
      this.Register();
    },
  },
  created() {
    this.$axios.get("/roles").then((response) => {
      this.roles = response.data;
    });
    this.$axios.get("/troupes").then((response) => {
      this.troupes = response.data;
    });
  },
  computed: {
    age() {
      let date = new Date(this.formData.birth_date);
      let ageDiff = new Date().getFullYear() - date.getFullYear();
      return ageDiff;
    },
  },
};
</script>
<style>
::-webkit-input-placeholder {
   text-align: right;
}

:-moz-placeholder { /* Firefox 18- */
   text-align: right;  
}

::-moz-placeholder {  /* Firefox 19+ */
   text-align: right;  
}

:-ms-input-placeholder {  
   text-align: right; 
}
input{
   text-align: right; 
}
option ,select{
   text-align: right; 
}

.error {
  padding: 5px;
  color: white !important;
}
</style>
