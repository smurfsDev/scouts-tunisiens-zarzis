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
          </v-tab-item>
        </v-tabs>
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
import deleteDialog from "@/components/demandeEvent/deleteDialog.vue";
export default {
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
  components: {
    deleteDialog,
    // detachMaterialDialog,
  },
  data() {
    return {
      tab: null,
      items: ["المعلومات الاساسية"],
      pagination: 5,
    };
  },
  methods: {
    rem(id, materiel_id) {
      this.$emit("rem", id, materiel_id);
    },
    // status(events) {
    //   return events.status;
    // },
  },
  watch: {
    demandes() {},
  },
  mounted() {
    console.log(this.demandes);
  },
};
</script>

<style>
</style>