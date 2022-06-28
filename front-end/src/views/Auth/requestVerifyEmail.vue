<template>
  <div>
    <v-container>
      <v-layout row wrap>
        <v-flex xs12>
          <v-card :loading="loading">
            <b-alert
              :show="alert.dismissCountDown"
              dismissible
              :variant="alert.variant"
              @dismissed="alert.dismissCountDown = 0"
            >
              <p>{{ alert.msg }}</p>
            </b-alert>
            <v-card-title>
              <span class="headline"> طلب تأكيد البريد الإلكتروني </span>
            </v-card-title>
            <v-card-text>
              <v-form
                @submit.prevent="requestVerifyEmail"
                id="request-verify-email-form"
              >
                <v-text-field
                  prepend-icon="person"
                  name="البريد الإلكتروني"
                  label="البريد الإلكتروني"
                  :error-messages="emailErrors"
                  @change="requestVerifyEmail()"
                  v-model="email"
                  type="text"
                ></v-text-field>
              </v-form>
              <v-card-actions>
                <v-spacer></v-spacer>
                <span class="caption">
                  هل لديك حساب ?
                  <router-link color="primary" to="/register"
                    >صنع حساب</router-link
                  ></span
                >
                <v-btn
                  :loading="loading"
                  color="success"
                  form="request-verify-email-form"
                  type="submit"
                  >طلب تأكيد البريد الإلكتروني</v-btn
                >
              </v-card-actions>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>

<script>
import { required, email } from "vuelidate/lib/validators";

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
  },
  data() {
    return {
      email: "",
      loading: false,
      alert: {
        dismissCountDown: null,
        variant: null,
        msg: null,
      },
    };
  },
  methods: {
    requestVerifyEmail() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      }
      let iam = this;
      this.loading= true;
      this.$axios
        .get(`/email/resend/${this.email}`)
        .then(() => {
          this.alert.variant = "success";
          this.alert.msg =
            "تم إرسال رابط التحقق إلى البريد الإلكتروني الخاص بك";
          this.alert.dismissCountDown = 5;
            this.loading = false;
        })
        .catch((error) => {
          this.alert.variant = "danger";
          this.alert.msg = error.response.data.msg??"لقد حصل عطب ما الرجاء المحاولة لاحقا";
          this.alert.dismissCountDown = 5;
            this.loading = false;
          setTimeout(function () {
            iam.$router.push("/login");
          }, 5000);
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
  },
};
</script>

<style>
</style>