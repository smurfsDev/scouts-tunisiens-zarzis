<template>
  <v-data-table
    :headers="headers"
    :items="request"
    item-key="id"
    class="elevation-1"
  >
    <template v-slot:[`item.status`]="{ item }">
      <div class="align-center">
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
            <v-icon v-if="item.status == 0" color="orange" v-on="on"
              >mdi-close</v-icon
            >
            <v-icon v-else-if="item.status == 1" color="green" v-on="on"
              >mdi-check</v-icon
            >
            <v-icon v-else color="red" v-on="on">mdi-close</v-icon>
          </template>
          <span v-if="item.status == 0">لم يتم الموافقة</span>
          <span v-else-if="item.status == 1">تم الموافقة</span>
          <span v-else>تم الرفض</span>
        </v-tooltip>
      </div>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <div class="align-center">
        <deleteDialog
          :id="item.id"
          @ok="$emit('delete', item.id)"
        ></deleteDialog>
        <v-btn
          @click="$emit('update', item)"
          class="mx-1"
          :disabled="item.status == 1"
          x-small
          :fab="$vuetify.breakpoint.name != 'sm'"
          color="warning"
        >
          <v-icon>mdi-pen</v-icon>
        </v-btn>
      </div>
    </template>
  </v-data-table>
</template>

<script>
import deleteDialog from "./deleteDialog.vue";
export default {
  components: {
    deleteDialog,
  },
  props: ["request", "headers"],
};
</script>

<style></style>
