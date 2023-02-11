<template>
  <div>
    <v-dialog v-model="dialog" hide-overlay persistent width="300">
      <v-card color="primary" dark>
        <v-card-text>
          الرجاء الانتظار
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-container>
      <v-row justify="center">
        <v-col loading cols="12" md="8">
          <v-card :class="status == 'success' ? 'text-success' : 'text-danger'">
            <v-card-title>
              <span class="headline">{{ header }}</span>
            </v-card-title>
            <v-card-text>
              <p>
                {{ msg }}
              </p>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <router-link
                class="btn btn-warning text-white"
                v-if="status == 'invalid'"
                to="/request-verify-email"
                >طلب تأكيد البريد الإلكتروني</router-link
              >
              <router-link v-else class="btn btn-primary text-white" to="/login"
                >تسجيل الدخول</router-link
              >
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
export default {
  name: "VerifyEmail",
  data() {
    return {
      message: "VerifyEmail",
      header: "",
      msg: ".",
      status: "",
      dialog: false,
    };
  },
  created() {
    this.verifyEmail();
  },
  methods: {
    verifyEmail() {
      this.dialog = true;
      this.$axios
        .get(this.$route.query.url)
        .then((response) => {
          this.header = response.data.header;
          this.msg = response.data.msg;
          this.status = response.data.status;
        })
        .catch((error) => {
          this.header = error.response.data.header;
          this.msg = error.response.data.msg;
          this.status = error.response.data.status;
        })
        .finally(() => {
          this.dialog = false;
          if (this.status == "success" || this.status == "already_verified") {
            setTimeout(() => {
              this.$router.push("/login");
            }, 5000);
          }
        });
    },
  },
};
</script>

<style></style>
