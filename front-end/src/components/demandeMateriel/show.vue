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
                <span class="h6">المرسل :</span>
                {{
                  demande.responsable.first_name +
                  " " +
                  demande.responsable.last_name
                }}
              </v-row>
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
            </v-container>
          </v-tab-item>
          <v-tab-item>d </v-tab-item>
        </v-tabs>
        <v-card-actions>
          <v-spacer></v-spacer>
          <deleteDialog
            :id="demande.id"
            @ok="$emit('deleteItem',demande.id)"
          ></deleteDialog>
          <v-btn color="warning darken-1" @click="$emit('edit',demande)" text>
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
  },
  data() {
    return {
      tab: null,
      items: ["المعلومات الاساسية", "الاثاث المطلوب"],
    };
  },
  watch: {
    demandes() {},
  },
};
</script>

<style>
</style>