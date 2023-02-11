<template>
  <div>
    <div v-if="AddEvents == true">
      <AddEvent @cancel_add_events="return_page_consulte"></AddEvent>
    </div>
    <div v-else>
      <v-card style="padding: 25px">
        <h4 class="text-center py-4">الأحداث</h4>
        <div class="row gap-4 p-5 mt-3">
          <div class="col-lg-3 mx-2 text-center">
            <v-text-field
              v-model="search"
              @keyup="FetchData()"
              append-icon="mdi-magnify"
              label="	
            بحث"
              single-line
              color="blue"
              hide-details
            ></v-text-field>
          </div>
          <v-spacer></v-spacer>
          <div class="col-lg-3 text-center">
            <div class="row">
              <div class="col-lg-12 text-center">
                <v-tooltip bottom>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      @click="AddEvents = true"
                      class="mb-5"
                      v-bind="attrs"
                      v-on="on"
                      outlined
                      fab
                      color="blue"
                    >
                      <v-icon>mdi-calendar-plus</v-icon>
                    </v-btn>
                  </template>
                  <span>أضف حدث</span>
                </v-tooltip>
              </div>
            </div>
          </div>
        </div>
        <v-simple-table color="blue">
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left">*</th>
                <th class="text-left">اسم</th>
                <th class="text-left">وصف</th>
                <th class="text-left">تاريخ البدء</th>
                <th class="text-left">تاريخ الانتهاء</th>
                <th class="text-left">حالة</th>
                <th class="text-left">عملية</th>
              </tr>
            </thead>
            <tbody v-if="loader">
              <tr class="text-center">
                <td colspan="5">
                  <v-progress-circular
                    indeterminate
                    color="red"
                  ></v-progress-circular>
                </td>
              </tr>
            </tbody>
            <tbody v-else-if="events == ''">
              <tr>
                <td colspan="6" class="text-center">لا تتوافر بيانات</td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr v-for="item in events" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.titre }}</td>
                <td>{{ item.description }}</td>
                <td>{{ item.date_debut }}</td>
                <td>{{ item.date_fin }}</td>
                <td>{{ item.etat }}</td>
                <td>
                  <v-btn @click="initIndice(item)" class="mx-2 mb-2">
                    <v-icon> mdi-delete </v-icon>
                  </v-btn>
                  <v-btn class="mx-2 mb-2" @click="editevents(item.id)">
                    <v-icon> mdi-square-edit-outline </v-icon>
                  </v-btn>
                </td>
              </tr>
            </tbody>
            <!-- <div class="text-center mt-2">
              <v-btn small :disabled="pagination.prevpage==null"  @click="changerPage(pagination.curentpage-1)">
                <v-icon>
                  mdi-chevron-left
               </v-icon>
             </v-btn>
             <v-btn v-for="num in (Math.ceil(pagination.per_page ? pagination.total/pagination.per_page : 1))" :key="num"
               @click="changerPage(num)"
                class="mx-2"
                color="primary"
                :disabled="num==pagination.curentpage"
                small
                x-small
              >
             {{num}}
           </v-btn>
              <v-btn small :disabled="pagination.nextpage==null"  @click="changerPage(pagination.curentpage+1)">
                 <v-icon>
                    mdi-chevron-right
                 </v-icon>
              </v-btn>
            </div> -->
          </template>
        </v-simple-table>
      </v-card>
    </div>
  </div>
</template>

<script>
import AddEvent from "../../components/manage_events/AddEvent.vue";
export default {
  name: "consulte_events",
  created() {
    this.FetchData();
  },
  data() {
    return {
      search: "",
      events: [],
      AddEvents: false,
      loader: false,
    };
  },
  methods: {
    return_page_consulte() {
      this.AddEvents = false;
    },
    initIndice(item) {
      console.log(item);
    },
    FetchData() {},
    editevents(id) {
      console.log(id);
    },
  },
  components: {
    AddEvent,
  },
};
</script>
