<template>
  <div>
    <v-app-bar
      clipped-right
      :color="$store.getters.status == false ? 'red darken-4' : 'primary'"
      dark
    >
      <router-link to="/" class="d-flex align-center">
        <v-img
          alt="Scouts Logo"
          class="shrink mr-2"
          contain
          src="../assets/scouts.png"
          transition="scale-transition"
		  style="border-radius:100%"
          width="50"
        />

        <v-container class="text-light mr-3">
		  <v-row class="font-weight-bold">الكشافة التونسية</v-row>
		  <v-row class="font-weight-medium">فوج جرجيس</v-row>
		</v-container>
      </router-link>
      <v-spacer></v-spacer>
      <div class="text-center">
        <v-menu open-on-hover top offset-y offset-x offset-overflow>
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark v-bind="attrs" v-on="on">
              الحساب <v-icon>mdi-account</v-icon>
            </v-btn>
          </template>

          <v-list>
            <v-list-item v-if="$store.getters.isLoggedIn">
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
            <v-list-item v-if="!$store.getters.isLoggedIn">
              <router-link class="button" to="/login"
                ><v-icon>mdi-account-arrow-right</v-icon>تسجيل
                الدخول</router-link
              >
            </v-list-item>
            <v-list-item v-if="$store.getters.isLoggedIn">
              <router-link class="button" to="/logout"
                ><v-icon>mdi-account-arrow-left</v-icon>الخروج</router-link
              >
            </v-list-item>
            <v-list-item v-if="!$store.getters.isLoggedIn">
              <router-link class="button" to="/register"
                ><v-icon>mdi-account-plus</v-icon>انشاء حساب</router-link
              >
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
    </v-app-bar>
    <!--  -->
    <v-navigation-drawer
      v-if="$store.getters.isLoggedIn"
      :mini-variant.sync="mini"
      light
      right
      v-model="drawer"
      absolute
      bottom
      permanent
      clipped
    >
      <v-list nav dense>
        <v-list-item>
          <v-list-item-avatar>
            <v-btn @click.stop="mini = !mini" icon>
              <v-icon dark>{{
                !mini ? "mdi-chevron-right" : "mdi-chevron-left"
              }}</v-icon>
            </v-btn>
          </v-list-item-avatar>
        </v-list-item>
        <v-list-item
          v-if="$store.getters.isLoggedIn && $store.getters.status != false"
          id="loggedinActivated"
        >
          <v-list-item-avatar>
            <v-icon v-if="$store.getters.authUser.image == null"
              >mdi-account</v-icon
            >
            <v-img v-else :src="$store.getters.authUser.image"> </v-img>
          </v-list-item-avatar>
          <v-list-item-title>
            <router-link to="profile">
              {{
                $store.getters.authUser.first_name +
                " " +
                $store.getters.authUser.last_name
              }}
            </router-link>
          </v-list-item-title>
        </v-list-item>
        <v-list-item
          v-if="$store.getters.isLoggedIn && $store.getters.status == false"
          id="loggedinActivetd"
        >
          <v-list-item-avatar>
            <v-icon v-if="$store.getters.authUser.image == null"
              >mdi-account</v-icon
            >
            <v-img v-else :src="$store.getters.authUser.image"> </v-img>
          </v-list-item-avatar>
          <v-list-item-title>
            <v-tooltip bottom color="red">
              <template v-slot:activator="{ on, attrs }">
                <router-link to="profile">
                  <del v-bind="attrs" v-on="on">
                    {{
                      $store.getters.authUser.first_name +
                      " " +
                      $store.getters.authUser.last_name
                    }}
                  </del>
                </router-link>
              </template>
              <span>حسابك غير مفعل</span>
            </v-tooltip>
          </v-list-item-title>
        </v-list-item>
        <v-list-item v-if="!$store.getters.isLoggedIn">
          <v-list-item-avatar>
            <v-menu open-on-hover top offset-y offset-x offset-overflow>
              <template v-slot:activator="{ on, attrs }">
                <v-icon v-bind="attrs" v-on="on">mdi-account</v-icon>
              </template>
              <v-list>
                <v-list-item v-if="!$store.getters.isLoggedIn">
                  <router-link class="button" to="/login"
                    ><v-icon>mdi-account-arrow-right</v-icon>تسجيل
                    الدخول</router-link
                  >
                </v-list-item>
                <v-list-item v-if="!$store.getters.isLoggedIn">
                  <router-link class="button" to="/register"
                    ><v-icon>mdi-account-plus</v-icon>انشاء حساب</router-link
                  >
                </v-list-item>
              </v-list>
            </v-menu>
          </v-list-item-avatar>
          <v-list-item-title> </v-list-item-title>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item-group active-class="deep-purple--text text--accent-4">
          <v-list-item
            v-show="$store.getters[item.access]"
            v-for="item in items"
            :key="item.title"
          >
            <v-list-item-icon>
              <router-link class="text-dark" :to="item.link"
                ><v-icon>{{
                  item.icon ? item.icon : "mdi-head-question"
                }}</v-icon></router-link
              >
            </v-list-item-icon>
            <v-list-item-title>
              <router-link class="text-dark" :to="item.link">{{
                item.title
              }}</router-link>
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list>
      <template v-slot:append>
        <div class="pa-2">
          <v-btn
            to="/logout"
            v-if="$store.getters.isLoggedIn"
            class="my-2"
            color="red"
            block
          >
            <v-icon>mdi-account-arrow-left</v-icon>
          </v-btn>
          <v-btn dark @click.stop="mini = !mini" block>
            <v-icon>{{
              !mini ? "mdi-chevron-right" : "mdi-chevron-left"
            }}</v-icon>
          </v-btn>
        </div>
      </template>
    </v-navigation-drawer>
  </div>
</template>

<script>
export default {
  data: () => ({
    mini: true,
    show: true,
    items: [
      { icon: "mdi-home", title: "الرئيسية", link: `/`,access: "isLoggedIn", },
      {
        icon: "mdi-account-cog",
        title: "manage leaders",
        link: "manageLeaders",
        access: "isSuperAdmin",
      },
      {
        icon: "mdi-account-group",
        title: "manage troops",
        link: "manageTroops",
        access: "isSuperAdmin",
      },
      {
        icon: "mdi-account-cog",
        title: "manage members",
        link: "manageMembers",
        access: "isUnitLeader",
      },
      {
        icon: "mdi-cash-check",
        title: "manage members subscription",
        link: "manageMembersSubs",
        access: "isMonetary",
      },
      {
        icon: "mdi-toolbox",
        title: "manage materiel",
        link: "manageMateriel",
        access: "isMaterielManager",
      },
      {
        icon: "mdi-file-document",
        title: "demande materiel",
        link: "demandeMateriel",
        access: "isLeader",
      },
      {
        icon: "mdi-file-document-check",
        title: "manageDemandeMateriel",
        link: "manageDemandeMateriel",
        access: "isMaterielManager",
      },
    ],
    drawer: true,
    group: null,
  }),
  watch: {
    group() {
      this.drawer = false;
    },
    mini() {
      if (this.mini) {
        // margin right id=main = 250
        document.getElementById("main").style.marginRight = "0px";
      } else {
        document.getElementById("main").style.marginRight = "256px";
      }
    },
  },
};
</script>

<style></style>
