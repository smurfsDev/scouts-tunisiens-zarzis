<template>
  <div>
    <v-container>
      <v-row justify="center">
        <v-col cols="12" md="8">
          <v-card :loading="loading" >
          <b-alert
              :show="alert.dismissCountDown"
              dismissible
              :variant="alert.variant"
              @dismissed="alert.dismissCountDown = 0"
            >
              <p>{{ alert.msg }}</p>
            </b-alert>
            <v-card-title>
              <span class="headline">نسيت كلمت المرور</span>
            </v-card-title>
            <v-form @submit.prevent="ForgotPassword" >
              <v-card-text>
                <v-text-field
                  v-model="email"
                  @change="$v.$touch()"
                  :error-messages="emailErrors"
                  label="البريد الإلكتروني"
                  type="email"
                  required
                  autofocus
                ></v-text-field>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn type="submit" :disabled="$v.$invalid"  :loading="loading" color="primary"> ابعث </v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-col>
      </v-row>
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
          this.disabled = true;
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
      alert: {
        dismissCountDown: null,
        variant: null,
        msg: null,
      },
      loading: false,
    };
  },
  methods: {
    ForgotPassword() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      }
      this.loading = true;
      this.$axios
        .post("/forgot-password", { email: this.email })
        .then((response) => {
          this.loading = false;
          this.alert.variant = "success";
          this.alert.msg = response.data.message;
          this.alert.dismissCountDown = 5;
        })
        .catch(() => {
          this.loading = false;
          this.alert.variant = "danger";
          this.alert.msg = "حصل خطأ ما ، حاول مرة أخرى";
          this.alert.dismissCountDown = 5;
        })
        .finally(() => {
          this.loading = false;
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