<template>
  <v-data-table
      :headers="headers"
      :items="troops"
      item-key="id"
      class="elevation-1"
    >
      <template v-slot:[`item.actions`]="{ item }">
        <div class="align-center">
          <deleteDialog :id="item.id" @ok="$emit('delete',item.id)"></deleteDialog>
          <v-btn
            @click="$emit('update',item.id)"
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
import deleteDialog from './deleteDialog.vue';
export default {
    components: {
        deleteDialog,
    },
    props: ['troops', 'headers'],
}
</script>

<style>

</style>