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
      <tab-content title="Donnee personnel" :selected="true">
        <div class="form-group">
          <label for="first_name">Prénom</label>
          <input
            type="text"
            class="form-control"
            :class="hasError('first_name') ? 'is-invalid' : ''"
            placeholder="Entrez votre prénom"
            v-model="formData.first_name"
          />
          <div v-if="hasError('first_name')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.first_name.required">
              Merci d'entrer votre prénom.
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="last_name">Nom</label>
          <input
            type="text"
            class="form-control"
            :class="hasError('last_name') ? 'is-invalid' : ''"
            placeholder="Entrer votre nom"
            v-model="formData.last_name"
          />
          <div v-if="hasError('last_name')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.last_name.required">
              Merci d'entrer votre Nom.
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="birth_date">date de naissance</label>
          <input
            type="date"
            class="form-control"
            :class="hasError('birth_date') ? 'is-invalid' : ''"
            placeholder="Entrer votre date de naissance"
            v-model="formData.birth_date"
          />
          <div v-if="hasError('birth_date')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.birth_date.required">
              Merci d'entrer votre date de naissance.
            </div>
            <div class="error" v-if="!$v.formData.birth_date.dateValidator">
              Merci d'entrer une date de naissance valide.
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="cin">cin</label>
          <input
            type="number"
            class="form-control"
            :class="hasError('cin') ? 'is-invalid' : ''"
            placeholder="Entrer votre cin"
            v-model="formData.cin"
          />
          <div v-if="hasError('cin')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.cin.required">
              Merci d'entrer votre cin (ou cin de parent).
            </div>
            <div
              class="error"
              v-if="!$v.formData.cin.numeric || !$v.formData.cin.between"
            >
              Merci d'entrer une cin valide.
            </div>
            <!-- <div
              class="error"
              v-if="!$v.formData.cin.isUnique"
            >
              Cette cin est deja utilisée.
            </div> -->
          </div>
        </div>
      </tab-content>
      <tab-content title="Contact">
        <div class="form-group">
          <div class="form-group">
            <label for="email">Email</label>
            <input
              type="email"
              class="form-control"
              :class="hasError('email') ? 'is-invalid' : ''"
              placeholder="Entrer votre email"
              v-model="formData.email"
            />
            <div v-if="hasError('email')" class="invalid-feedback">
              <div class="error" v-if="!$v.formData.email.required">
                Merci d'entrer votre email.
              </div>
              <div class="error" v-if="!$v.formData.email.email">
                Merci d'entrer un email valid.
              </div>
            <div
              class="error"
              v-if="!$v.formData.email.isUnique"
            >
              Ce mail est deja utilisée.
            </div>
            </div>
          </div>
          <label for="phone_number">Numero de telephone</label>
          <input
            type="number"
            class="form-control"
            :class="hasError('phone_number') ? 'is-invalid' : ''"
            placeholder="Entrer votre numero de telephone"
            v-model="formData.phone_number"
          />
          <div v-if="hasError('phone_number')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.phone_number.required">
              Merci d'entrer votre numero de telephone.
            </div>
            <div
              class="error"
              v-if="
                !$v.formData.phone_number.numeric ||
                !$v.formData.phone_number.between
              "
            >
              Merci d'entrer un numero de telephone valide.
            </div>
          </div>
        </div>
      </tab-content>
      <tab-content title="Identifiants">
        <div class="form-group">
          <label for="password">Mot de passe</label>
          <input
            type="password"
            :class="hasError('password') ? 'is-invalid' : ''"
            class="form-control"
            v-model="formData.password"
          />
          <div v-if="hasError('password')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.password.required">
              Merci d'entrer votre mot de passe.
            </div>
            <div
              class="error"
              v-if="
                !$v.formData.password.minLength ||
                !$v.formData.password.maxLength
              "
            >
              Mot de passe doit etre entre 8 et 30 characteres.
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="confirm_password">Verification mot de passe</label>
          <input
            :class="hasError('confirm_password') ? 'is-invalid' : ''"
            class="form-control"
            type="password"
            v-model="formData.confirm_password"
          />
          <div v-if="hasError('confirm_password')" class="invalid-feedback">
            <div class="error" v-if="!$v.formData.confirm_password.required">
              Merci de verifier votre mot de passe.
            </div>
            <div
              class="error"
              v-if="
                !$v.formData.confirm_password.minLength ||
                !$v.formData.confirm_password.maxLength
              "
            >
              Mot de passe doit etre entre 8 et 30 characteres.
            </div>
            <div class="error" v-if="!$v.formData.confirm_password.confirmed">
              Mot de passe non identitque .
            </div>
          </div>
        </div>
      </tab-content>
               <span class="caption"> Vous avez deja un compte ? <router-link color="primary" to="/login">Login</router-link></span>
    </form-wizard>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import { FormWizard, TabContent, ValidationHelper } from "vue-step-wizard";
import "vue-step-wizard/dist/vue-step-wizard.css";
import {
  required,
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
  data() {
    return {
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
      },
      validationRules: [
        {
          first_name: { required },
          last_name: { required },
          birth_date: { required, dateValidator },
          cin: {
            required,
            numeric,
            between: between(1000000, 99999999),
            // async isUnique(value) {
            //   const response = await this.$axios(`/unique/${value}`);
            //   console.log(response.data);
              // return response.status == 200||value=='';
            // },
          },
        },
        {
          phone_number: { required, between: between(10000000, 99999999) },
          email: { required, email,async isUnique(value) {

              const response = await this.$axios(`/unique/${value}`);
              console.log(response.data);
              return response.status == 200||value=='';
            } },
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
      console.log(this.formData);
      this.register(this.formData)
        .then(() => {
          if (this.$store.getters.regStatus == 2) {
            this.alert.dismissCountDown = 10;
            this.alert.variant = "danger";
            this.alert.msg = this.$store.getters.regMessage;
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    onComplete() {
      this.Register();
    },
  },
};
</script>
<style >
.error {
  color: white !important;
}
</style>