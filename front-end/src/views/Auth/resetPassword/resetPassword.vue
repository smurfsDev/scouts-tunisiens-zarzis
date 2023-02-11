<template>
  <div>
    <!-- reset password vuetify -->
    <v-container>
      <v-row justify="center">
        <v-col cols="12" md="6">
          <v-card>
            <b-alert
              :show="alert.dismissCountDown"
              dismissible
              :variant="alert.variant"
              @dismissed="alert.dismissCountDown = 0"
            >
              <p>{{ alert.msg }}</p>
            </b-alert>
            <v-toolbar color="primary">
              <v-toolbar-title>
                <span class="white--text">إعادة تعيين كلمة المرور</span>
              </v-toolbar-title>
            </v-toolbar>
            <v-card-text>
              <v-text-field
                v-model="email"
                :error-messages="emailErrors"
                label="البريد الإلكتروني"
                type="email"
                required
                autofocus
              ></v-text-field>
              <v-text-field
                v-model="code"
                :error-messages="codeErrors"
                label="الرمز"
                type="text"
                required
                autofocus
              ></v-text-field>
              <v-text-field
                v-model="password"
                :error-messages="passwordErrors"
                label="كلمة المرور"
                type="password"
                required
                autofocus
              ></v-text-field>
              <v-text-field
                v-model="password_confirmation"
                :error-messages="password_confirmationErrors"
                label="تأكيد كلمة المرور"
                type="password"
                required
                autofocus
              ></v-text-field>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                type="submit"
                :loading="loading"
                color="primary"
                @click="resetPassword"
              >
                ابعث
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import { required, minLength, email, sameAs } from "vuelidate/lib/validators";
export default {
  validations: {
    email: {
      required,
      email,
      async exists(value) {
        if (value === "") {
          return true;
        }
        const response = await this.$axios(`/unique/${value}`);
        return response.status == 201 || value == "";
      },
    },
    code: {
      required,
      async exists(value) {
        if (value === "") {
          return true;
        }
        const response = await this.$axios.post("/password/code/check", {
          code: value,
        });
        return response.status == 200 || value == "";
      },
    },
    password: { required, minLength: minLength(8) },
    password_confirmation: {
      required,
      minLength: minLength(8),
      confirmed: sameAs("password"),
    },
  },
  data() {
    return {
      alert: {
        dismissCountDown: null,
        variant: null,
        msg: null,
      },
      email: "",
      code: "",
      password: "",
      password_confirmation: "",
      loading: false,
    };
  },
  methods: {
    resetPassword() {
      this.loading = true;
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.loading = false;
        return;
      }
      this.$axios
        .post("/password/reset", {
          email: this.email,
          code: this.code,
          password: this.password,
          password_confirmation: this.password_confirmation,
        })
        .then(() => {
          this.loading = false;
          this.$router.push({
            name: "login",
            params: {
              msg: "لقد تم انشاء كلمة المرور بنجاح",
              variant: "success",
            },
          });
        })
        .catch(() => {
          this.loading = false;
          this.alert.dismissCountDown = 5;
          this.alert.variant = "danger";
          this.alert.msg = "حدث خطأ ما الرجاء المحاولة مرة اخرى";
        });
    },
  },
  computed: {
    emailErrors() {
      const errors = [];
      if (!this.$v.email.$dirty) return errors;
      !this.$v.email.email && errors.push("الرجاء ادخال بريد صحيح");
      !this.$v.email.required && errors.push("الرجاء ادخال بريد الكتروني");
      !this.$v.email.exists && errors.push("البريد الالكتروني غير مسجل");
      return errors;
    },
    codeErrors() {
      const errors = [];
      if (!this.$v.code.$dirty) return errors;
      !this.$v.code.required && errors.push("الرجاء ادخال الرمز");
      !this.$v.code.exists && errors.push("الرمز غير مسجل او غير صالخ");
      return errors;
    },
    passwordErrors() {
      const errors = [];
      if (!this.$v.password.$dirty) return errors;
      !this.$v.password.required && errors.push("الرجاء ادخال بكلمة المرور");
      !this.$v.password.minLength &&
        errors.push("الرجاء ادخال بكلمة المرور بحد اقل من 8 حروف");
      return errors;
    },
    password_confirmationErrors() {
      const errors = [];
      if (!this.$v.password.$dirty) return errors;
      !this.$v.password.required &&
        errors.push("الرجاء ادخال تأكيد كلمة المرور");
      !this.$v.password.minLength &&
        errors.push("الرجاء ادخال تأكيد كلمة المرور بحد اقل من 8 حروف");
      !this.$v.password_confirmation.confirmed &&
        errors.push("الرجاء ادخال تأكيد كلمة المرور بشكل صحيح");
      return errors;
    },
  },
};
</script>

<style></style>
