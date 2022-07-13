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
                <span class="h6">الرسالة :</span>
                {{ demande.message }}
              </v-row>
              <v-row>
                <span class="h6">تاريخ الارسال :</span>
                {{ demande.created_at }}
              </v-row>
              <v-row>
                <span class="h6">تاريخ الطلب :</span>
                {{ demande.date_demande }}
              </v-row>
              <v-row>
                <span class="h6">تاريخ الارجاع :</span>
                {{ demande.date_fin_demande }}
              </v-row>
            </v-container>
          </v-tab-item>
          <v-tab-item>
            <v-container p-4>
              <v-row v-for="materiel in demande.materiels" :key="materiel.id">
                <v-text-field
                  v-model="materiel.pivot.quantity"
                  label="الكمية"
                  type="number"
                  step="1"
                  min="1"
                  :rules="rules"
                  @keyup.enter="
                    setQte(demande.id, materiel.id, materiel.pivot.quantity)
                  "
                  max="100"
                  style="width: 100px"
                >
                  <span slot="prepend">
                    {{ materiel.name }}
                  </span>
                </v-text-field>
                <v-btn
                v-if="materiel.pivot.status!=1"
                  color="success"
                  text
                  @click="
                    setQte(demande.id, materiel.id, materiel.pivot.quantity)
                  "
                  class="m-4 mr-0 ml-1 mr-1"
                >
                  <v-icon>mdi-check</v-icon>
                  تحديث
                </v-btn>
                <detachMaterialDialog
                v-if="materiel.pivot.status!=1"
                  @ok="rem(demande.id, materiel.id)"
                  :id="materiel.name"
                />
                <v-tooltip
                  bottom
                  :color="
                    materiel.pivot.status == 0
                      ? 'warning'
                      : materiel.pivot.status == 1
                      ? 'success'
                      : 'red'
                  "
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-icon
                      :color="
                        materiel.pivot.status == 0
                          ? 'warning'
                          : materiel.pivot.status == 1
                          ? 'success'
                          : 'red'
                      "
                      v-bind="attrs"
                      v-on="on"
                    >
                      {{
                        materiel.pivot.status == 0
                          ? "mdi-alert"
                          : materiel.pivot.status == 1
                          ? "mdi-check"
                          : "mdi-close"
                      }}
                    </v-icon>
                  </template>
                  <span>
                    {{
                      materiel.pivot.status == 0
                        ? "لم يقع الرد"
                        : materiel.pivot.status == 1
                        ? "مقبول"
                        : "غير مقبول"
                    }}</span
                  >
                </v-tooltip>
              </v-row>
              <v-row v-if="demande.materiels.length == 0">
                <span class="h5"> لا يوجد اثاث </span>
              </v-row>
            </v-container>
          </v-tab-item>
        </v-tabs>
        <v-card-actions>
          <v-spacer></v-spacer>
          <deleteDialog
          v-if="!status(demande.materiels)"
            :id="demande.id"
            @ok="$emit('deleteItem', demande.id)"
          ></deleteDialog>
          <v-btn
          v-if="!status(demande.materiels)" color="warning darken-1" @click="$emit('edit', demande)" text>
            تعديل
            <v-icon>edit</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
      <br />
    </div>

    <v-card v-if="demandes.length == 0">
      <v-card-title>
        <h1>لا يوجد طلبات</h1>
      </v-card-title>
      <v-card-text>
        <p>لم تقم بإرسال طلبات بعد</p>
      </v-card-text>
      <v-card-actions>
        <v-btn color="teal accent-4"> طلب جديد </v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
import detachMaterialDialog from "@/components/demandeMateriel/detachMaterialDialog.vue";
import deleteDialog from "@/components/demandeMateriel/deleteDialog.vue";
export default {
  props: {
    demandes: {
      type: Array,
      default: () => [],
    },
  },
  components: {
    deleteDialog,
    detachMaterialDialog,
  },
  data() {
    return {
      rules: [(v) => !!v || "الكمية مطلوبة و يجب ان تكون رقما"],
      tab: null,
      items: ["المعلومات الاساسية", "الاثاث المطلوب"],
    };
  },
  methods: {
    setQte(id, materiel_id, qte) {
      this.$emit("setQte", id, materiel_id, qte);
    },
    rem(id, materiel_id) {
      this.$emit("rem", id, materiel_id);
    },
    status(materiels){
      return materiels.some(materiel => materiel.pivot.status != 0);
    }
  },
  watch: {
    demandes() {},
  },
  
};
</script>

<style>
</style>