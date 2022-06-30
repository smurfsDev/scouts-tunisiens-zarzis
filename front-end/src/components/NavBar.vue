<template>
  <v-app-bar
    app
    :color="$store.getters.status == false ? 'red darken-4' : 'primary'"
    dark
  >
    <router-link to="/" class="d-flex align-center">
      <v-img
        alt="Vuetify Logo"
        class="shrink mr-2"
        contain
        src="https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png"
        transition="scale-transition"
        width="40"
      />

      <v-img
        alt="Vuetify Name"
        class="shrink mt-1 hidden-sm-and-down"
        contain
        min-width="100"
        src="https://cdn.vuetifyjs.com/images/logos/vuetify-name-dark.png"
        width="100"
      />
    </router-link>
    <router-link class="btn btn-warning" to="manageLeaders"
      >manage leaders</router-link
    >
    <router-link class="btn btn-warning" to="manageMembers"
      >manage members</router-link
    >
    <v-spacer></v-spacer>
    <div class="text-center">
      <v-menu open-on-hover top offset-y offset-x offset-overflow>
        <template v-slot:activator="{ on, attrs }">
          <v-btn color="primary" dark v-bind="attrs" v-on="on">
            الحساب <v-icon>mdi-account</v-icon>
          </v-btn>
        </template>

        <v-list>
          <v-list-item v-if="this.$store.getters.isLoggedIn">
            <router-link to="profile" v-if="$store.getters.status != false">
              <v-icon v-if="$store.getters.authUser.image == null"
                >mdi-account</v-icon
              >
              <v-avatar v-else size="25">
                <img :src="$store.getters.authUser.image" />
              </v-avatar>
              {{
                $store.getters.authUser.first_name +
                " " +
                $store.getters.authUser.last_name
              }}
            </router-link>
            <v-tooltip bottom color="red">
              <template v-slot:activator="{ on, attrs }">
                <del
                  v-if="$store.getters.status == false"
                  v-bind="attrs"
                  v-on="on"
                >
                  <router-link to="profile">
                    <v-icon v-if="$store.getters.authUser.image == null"
                      >mdi-account</v-icon
                    >
                    <v-avatar v-else size="25">
                      <img :src="$store.getters.authUser.image" />
                    </v-avatar>
                    {{
                      $store.getters.authUser.first_name +
                      " " +
                      $store.getters.authUser.last_name
                    }}
                  </router-link>
                </del>
              </template>
              <span>حسابك غير مفعل</span>
            </v-tooltip>
          </v-list-item>
          <v-list-item v-if="!this.$store.getters.isLoggedIn">
            <router-link class="button" to="/login"
              ><v-icon>mdi-account-arrow-right</v-icon>تسجيل الدخول</router-link
            >
          </v-list-item>
          <v-list-item v-if="this.$store.getters.isLoggedIn">
            <router-link class="button" to="/logout"
              ><v-icon>mdi-account-arrow-left</v-icon>الخروج</router-link
            >
          </v-list-item>
          <v-list-item v-if="!this.$store.getters.isLoggedIn">
            <router-link class="button" to="/register"
              ><v-icon>mdi-account-plus</v-icon>انشاء حساب</router-link
            >
          </v-list-item>
        </v-list>
      </v-menu>
    </div>
  </v-app-bar>
</template>

<script>
export default {};
</script>

<style></style>
