<template>
  <div>
    <div class="container-xl px-4 mt-4">
      <div class="row">
        <div class="col-xl-4">
          <!-- Profile picture card-->
          <div class="card mb-4 mb-xl-0">
            <div class="card-header">الصورة الشخصية</div>
            <div class="card-body text-center">
              <!-- Profile picture image-->
              <img
                v-if="user.image != null"
                class="img-account-profile rounded-circle mb-2"
                width="100"
                :src="user.image"
              />
              <v-avatar v-else color="primary" class="text-white" size="128">{{
                (user.first_name[0] + user.last_name[0]).toUpperCase()
              }}</v-avatar>
              <!-- Profile picture help block-->
              <div v-if="!image" class="form-group">
                <label for="image">صورة</label>
                <input
                  id="image"
                  type="file"
                  name="image"
                  accept="image/*"
                  class="form-control"
                  @change="convert64"
                  ref="file"
                />
              </div>
              <div class="small font-italic text-muted mb-4">
                JPG او PNG لا يفوق حجمها 2ميجا بايت.
              </div>
              <!-- Profile picture upload button-->
              <v-btn
                :loading="loadingImage"
                v-if="image"
                @click="updateImage"
                color="primary"
                type="button"
              >
                <v-icon>mdi-image-plus</v-icon>
                اضافة صورة
              </v-btn>
            </div>
          </div>
        </div>
        <div class="col-xl-8">
          <!-- Account details card-->
          <v-card :loading="loadingEdit" class="card mb-4">
            <div class="card-header">تفاصيل الحساب</div>
            <div class="card-body">
              <form @submit.prevent="updateProfile">
                <!-- Form Group (username)-->

                <!-- Form Row-->
                <div class="row gx-3 mb-3">
                  <!-- Form Group (first name)-->
                  <div class="col-md-6">
                    <v-text-field
                      id="first_name"
                      type="text"
                      label="الأسم"
                      name="first_name"
                      :error-messages="first_nameError"
                      placeholder="ادخل اسمك"
                      v-model="user.first_name"
                    />
                  </div>
                  <!-- Form Group (last name)-->
                  <div class="col-md-6">
                    <div class="form-group">
                      <v-text-field
                        id="last_name"
                        type="text"
                        name="last_name"
                        :error-messages="last_nameError"
                        label="اللقب"
                        placeholder="ادخل لقبك"
                        v-model="user.last_name"
                      />
                    </div>
                  </div>
                </div>
                <!-- Form Row        -->
                <div class="row gx-3 mb-3">
                  <!-- Form Group (organization name)-->
                  <div class="col-md-6">
                    <v-menu
                      ref="menu"
                      v-model="menu"
                      :close-on-content-click="false"
                      :return-value.sync="user.birth_date"
                      :error-messages="birth_dateError"
                      transition="scale-transition"
                      offset-y
                      min-width="auto"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="user.birth_date"
                          label="تاريح الولادة"
                          prepend-icon="mdi-calendar"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="user.birth_date"
                        :max="
                          new Date(
                            new Date().getFullYear() - 6,
                            new Date().getMonth(),
                            new Date().getDate()
                          ).toISOString()
                        "
                        no-title
                        scrollable
                      >
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="menu = false">
                          اغلاق
                        </v-btn>
                        <v-btn
                          text
                          color="primary"
                          @click="$refs.menu.save(user.birth_date)"
                        >
                          اختيار
                        </v-btn>
                      </v-date-picker>
                    </v-menu>
                  </div>
                  <!-- Form Group (location)-->
                  <div class="col-md-6">
                    <v-select
                      :error-messages="sexeError"
                      :items="[
                        { text: 'ذكر', value: 'H' },
                        { text: 'أنثى', value: 'F' },
                      ]"
                      label="الجنس"
                      id="sexe"
                      v-model="user.sexe"
                      item-text="text"
                      item-value="value"
                    >
                    </v-select>
                  </div>
                </div>
                <!-- Form Group (email address)-->
                <div class="mb-3">
                  <v-text-field
                    disabled
                    id="inputEmailAddress"
                    v-model="user.email"
                    :error-messages="emailError"
                    label="البريد الإلكتروني"
                    type="email"
                    placeholder="ادخل البريد الإلكترونيك"
                  />
                </div>
                <!-- Form Row-->
                <div class="row gx-3 mb-3">
                  <!-- Form Group (phone number)-->
                  <div class="col-md-6">
                    <v-text-field
                      id="inputPhone"
                      label="رقم الهاتف"
                      type="tel"
                      :error-messages="phone_numberError"
                      placeholder="ادخل رقم الهاتف"
                      v-model="user.phone_number"
                    />
                  </div>
                  <!-- Form Group (birthday)-->
                </div>
                <!-- Save changes button-->
                <button class="btn btn-primary">حفظ التغييرات</button>
              </form>
            </div>
          </v-card>
        </div>
      </div>
    </div>
    <v-snackbar v-model="snack" :timeout="10000" :color="snackColor">
      {{ snackText }}

      <template v-slot:action="{ attrs }">
        <v-btn v-bind="attrs" text @click="snack = false"> اغلاق </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
import {
  required,
  minLength,
  email,
  maxLength,
} from "vuelidate/lib/validators";

export default {
  name: "Profile",
  validations: {
    user: {
      first_name: {
        required,
        minLength: minLength(3),
      },
      last_name: {
        required,
        minLength: minLength(3),
      },
      email: {
        required,
        email,
      },
      phone_number: {
        required,
        minLength: minLength(8),
        maxLength: maxLength(8),
      },
      birth_date: {
        required,
      },
      sexe: {
        required,
      },
    },
  },
  data() {
    return {
      user: {},
      avatar: "",
      menu: false,
      image: "",
      loadingImage: false,
      loadingEdit: false,
      snack: false,
      snackColor: "",
      snackText: "",
    };
  },
  created() {
    this.user = Object.assign({}, this.$store.getters.authUser);
  },
  methods: {
    convert64(e) {
      var file = e.target.files[0];
      this.srcImage = file;
      var reader = new FileReader();
      reader.onloadend = () => {
        this.user.image = reader.result;
      };
      this.image = file;
      reader.readAsDataURL(file);
    },
    updateImage() {
      this.loadingImage = true;
      this.$axios
        .put("/profile/image", {
          image: this.user.image,
        })
        .then((response) => {
          this.snack = true;
          this.snackColor = "success";
          this.snackText = "لقد تم التحديث بنجاح";
          this.$store.commit("setAuthUser", response.data.user);
          this.$store.commit("setAuthUser", response.data.user);
        })
        .catch((error) => {
          this.snack = true;
          this.snackColor = "red";
          this.snackText = error.response.data.error
            ? error.response.data.error
            : "لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا";
          console.log(error);
        })
        .finally(() => {
          this.image = "";
          this.loadingImage = false;
        });
    },
    updateProfile() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.loadingEdit = true;
        this.$axios
          .put("/profile/all", 
            this.user
          )
          .then((response) => {
            this.snack = true;
            this.snackColor = "success";
            this.snackText = "لقد تم التحديث بنجاح";
            this.$store.commit("setAuthUser", response.data.user);
          })
          .catch((error) => {
            this.snack = true;
            this.snackColor = "red";
            this.snackText = error.response.data.error
              ? error.response.data.error
              : "لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا";
          })
          .finally(() => {
            this.loadingEdit = false;
          });
      }
    },
  },
  computed: {
    first_nameError() {
      const errors = [];
      if (!this.$v.user.first_name.$dirty) return errors;
      !this.$v.user.first_name.required && errors.push("الرجاء ادخال اسم");
      !this.$v.user.first_name.minLength &&
        errors.push("الرجاء ادخال اسم بحد اقل من 3 حروف");
      return errors;
    },
    last_nameError() {
      const errors = [];
      if (!this.$v.user.last_name.$dirty) return errors;
      !this.$v.user.last_name.required && errors.push("الرجاء ادخال اللقب");
      !this.$v.user.last_name.minLength &&
        errors.push("الرجاء ادخال اللقب بحد اقل من 3 حروف");
      return errors;
    },
    emailError() {
      const errors = [];
      if (!this.$v.user.email.$dirty) return errors;
      !this.$v.user.email.required &&
        errors.push("الرجاء ادخال البريد الإلكتروني");
      !this.$v.user.email.email &&
        errors.push("الرجاء ادخال البريد الإلكتروني بطريقة صحيحة");
      return errors;
    },
    phone_numberError() {
      const errors = [];
      if (!this.$v.user.phone_number.$dirty) return errors;
      !this.$v.user.phone_number.required &&
        errors.push("الرجاء ادخال رقم الهاتف");
      !this.$v.user.phone_number.minLength &&
        errors.push("الرجاء ادخال رقم الهاتف بطريقة صحيحة");
      !this.$v.user.phone_number.maxLength &&
        errors.push("الرجاء ادخال رقم الهاتف بطريقة صحيحة");
      return errors;
    },
    birth_dateError() {
      const errors = [];
      if (!this.$v.user.birth_date.$dirty) return errors;
      !this.$v.user.birth_date.required &&
        errors.push("الرجاء ادخال تاريخ الميلاد");
      return errors;
    },
    sexeError() {
      const errors = [];
      if (!this.$v.user.sexe.$dirty) return errors;
      !this.$v.user.sexe.required && errors.push("الرجاء ادخال الجنس");
      return errors;
    },
  },
};
</script>

<style>
</style>