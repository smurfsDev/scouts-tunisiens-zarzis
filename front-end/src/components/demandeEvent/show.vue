<template>
  <div>
    <div
      v-show="demandes.length != 0"
      v-for="demande in demandes"
      :key="demande.id + 'i'"
    >
      <v-card>
        <v-tabs align-with-title>
          <v-tabs-slider></v-tabs-slider>
          <v-tab v-for="item in items" :key="item">
            {{ item }}
          </v-tab>
          <v-tab-item>
            <v-container p-4>
              <v-row>
                <span class="h6">اسم التظاهرة :</span>
                {{ demande.name }}
              </v-row>
              <v-row>
                <span class="h6">وصف التظاهرة :</span>
                {{ demande.description }}
              </v-row>
              <v-row>
                <span class="h6">تاريخ بداية التظاهرة :</span>
                {{ demande.date_debut }}
              </v-row>
              <v-row>
                <span class="h6">تاريخ انتهاء التظاهرة :</span>
                {{ demande.date_fin }}
              </v-row>
              <v-row>
                <span class="h6"> نوع التظاهرة :</span>
                <div v-if="demande.type == 0">تظاهرة صغرى</div>
                <div v-if="demande.type == 1">تظاهرة كبرى</div>
              </v-row>
            </v-container>
            <v-card-actions>
              <v-spacer></v-spacer>
              <deleteDialog
                v-if="demande.status == 0"
                :id="demande.id"
                @ok="$emit('deleteItem', demande.id)"
              ></deleteDialog>
              <v-btn
                v-if="demande.status == 0"
                color="warning darken-1"
                @click="$emit('edit', demande)"
                text
              >
                تعديل
                <v-icon>edit</v-icon>
              </v-btn>
            </v-card-actions>
          </v-tab-item>
          <v-tab-item>
            <FormWorkshop
              v-if="dialog"
              :editw="editw"
              :demandeEvent="demande"
              :idEvent="demande.id"
              :dialog="dialog"
              @close="close"
            ></FormWorkshop>
            <v-btn
              color="warning"
              class="m-4 mr-4"
              large
              @click="dialog = true"
            >
              <v-icon>mdi-plus</v-icon>
              اضافة
            </v-btn>

            <v-tabs-slider></v-tabs-slider>

            <v-tabs align-with-title>
              <v-tab
                v-for="(workshop, index) in demande.workshops"
                :key="workshop.id"
              >
                ورشة {{ index + 1 }}
              </v-tab>
              <v-tab-item
                v-for="workshop in demande.workshops"
                :key="workshop.id"
              >
                <v-container p-4>
                  <v-row> اسم الورشة : {{ workshop.name }} </v-row>
                  <v-row> وصف الورشة : {{ workshop.description }} </v-row>
                  <v-row>
                    قائد الورشة : {{ workshop.leader.first_name }}
                    {{ workshop.leader.last_name }}
                  </v-row>
                  <v-row>
                    تاريخ بداية الورشة : {{ workshop.heure_debut }}
                  </v-row>
                  <v-row>
                    تاريخ انتهاء الورشة : {{ workshop.heure_fin }}
                  </v-row>
                  <v-row>
                    منظم الورشة : {{ demande.user.first_name }}
                    {{ demande.user.last_name }}
                  </v-row>
                  <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                      color="red"
                      v-if="workshop.status == 0"
                      :id="workshop.id"
                      text
                      @click="deleteWorkshop(workshop.id)"
                    >
                      حذف
                      <v-icon>delete</v-icon>
                    </v-btn>

                    <v-btn
                      v-if="demande.status == 0"
                      color="warning darken-1"
                      @click="$emit('edit', demande)"
                      text
                    >
                      تعديل
                      <v-icon>edit</v-icon>
                    </v-btn>
                  </v-card-actions>
                </v-container>
              </v-tab-item>
            </v-tabs>
          </v-tab-item>
        </v-tabs>
        <!-- <v-card-actions>
          <v-spacer></v-spacer>
          <deleteDialog
            v-if="demande.status == 0"
            :id="demande.id"
            @ok="$emit('deleteItem', demande.id)"
          ></deleteDialog>
          <v-btn
            v-if="demande.status == 0"
            color="warning darken-1"
            @click="$emit('edit', demande)"
            text
          >
            تعديل
            <v-icon>edit</v-icon>
          </v-btn>
        </v-card-actions> -->
      </v-card>
      <br />
    </div>

    <v-card v-if="demandes.length == 0">
      <v-card-title>
        <h1>لا يوجد طلبات انشاء تظاهرات</h1>
      </v-card-title>
      <v-card-text>
        <p>لم تقم بإرسال طلبات انشاء تظاهرات بعد</p>
      </v-card-text>
      <v-card-actions>
        <v-btn color="teal accent-4"> طلب انشاء تظاهرة جديد </v-btn>
      </v-card-actions>
    </v-card>
    <v-pagination
      v-model="pagination_meta.current"
      :length="pagination_meta.total"
      @input="$emit('getDemandeEvent', {}, pagination)"
    ></v-pagination>
    <v-select
      v-model="pagination"
      :items="[5, 10, 15, 30, 50, 100]"
      label="عدد الصفوف"
      @input="$emit('getDemandeEvent', {}, pagination)"
    ></v-select>
  </div>
</template>

<script>
// import detachMaterialDialog from "@/components/demandeMateriel/detachMaterialDialog.vue";
import FormWorkshop from "./formWorkshop.vue";

import deleteDialog from "@/components/demandeEvent/deleteDialog.vue";
export default {
  components: {
    FormWorkshop,
    deleteDialog,
  },
  props: {
    demandes: {
      type: Array,
      default: () => [],
    },
    pagination_meta: {
      type: Object,
      default: () => {
        return {
          current: 1,
          total: 0,
        };
      },
    },
  },

  data() {
    return {
      tab: null,
      items: ["المعلومات الاساسية", "الورشات الخاصة بالتظاهرة"],
      dialog: false,
      pagination: 5,
      editw: false,
    };
  },
  methods: {
    rem(id, materiel_id) {
      this.$emit("rem", id, materiel_id);
    },
    close() {
      this.dialog = false;
      this.editm = false;
      this.demande = null;
    },
    deleteWorkshop(id) {
      if (confirm("?هل انت متاكد من حذف هذه الورشة"))
        this.$axios
          .delete("/workshops/delete/" + id)
          .then(() => {
            this.getDemandeEvent({
              show: true,
              type: "success",
              msg: "تم حذف الطلب بنجاح",
            });
          })
          .catch(() => {
            this.getDemandeEvent({
              show: true,
              type: "red",
              msg: "حدث خطأ ما",
            });
          });
    },
    getDemandeEvent(alert = {}, pagination = 5) {
      this.$axios
        .get("/events/myDemande?page=" + this.pagination_meta.current, {
          params: { pagination: pagination },
        })
        .then((response) => {
          // console.log(response.data.data);
          this.demandes = response.data.data.data;
          console.log(this.demandes);
          this.pagination_meta.current = response.data.data.current_page;
          this.pagination_meta.total = response.data.data.last_page;
          console.log(
            "pagination_meta.current: " + this.pagination_meta.current
          );
          console.log("pagination_meta.total: " + this.pagination_meta.total);
        })
        .catch()
        .finally(() => {
          if ("type" in alert) {
            this.alert = alert;
            setTimeout(() => {
              this.alert.show = false;
            }, 5000);
          }
        });
    },
    // status(events) {
    //   return events.status;
    // },
  },
  watch: {
    demandes() {},
  },
  mounted() {},
};
</script>

<style>
</style>