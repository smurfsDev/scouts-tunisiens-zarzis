<template>
  <div>
    <div v-if="update_page == true && AddEvents == false">
      <UpdateEvent
        @cancel_add_events="return_page_consulte"
        :id="idevent_updated"
      ></UpdateEvent>
    </div>
    <div v-else-if="AddEvents == true && update_page == false">
      <AddEvent @cancel_add_events="return_page_consulte"></AddEvent>
    </div>
    <div v-else>
      <v-card style="padding: 25px">
        <h4 class="text-center py-4">الفعاليات</h4>
        <div class="row gap-4 p-5 mt-3">
          <div class="col-lg-3 mx-2 text-center">
            <v-text-field
              v-model="search"
              @keyup="FetchData()"
              append-icon="mdi-magnify"
              label="بحث"
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
                  <span>أضف فعالية</span>
                </v-tooltip>
              </div>
            </div>
          </div>
        </div>

        <v-simple-table color="blue">
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-center">*</th>
                <th class="text-center">اسم</th>
                <th class="text-center">وصف</th>
                <th class="text-center">تاريخ البدء</th>
                <th class="text-center">تاريخ الانتهاء</th>
                <th class="text-center">حالة</th>
                <th class="text-center">عملية</th>
              </tr>
            </thead>
            <tbody v-if="loader">
              <tr class="text-center">
                <td colspan="5">
                  <v-progress-circular
                    indeterminate
                    color="blue"
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
                <td class="text-center">{{ item.id }}</td>
                <td class="text-center">{{ item.titre }}</td>
                <td class="text-center">{{ item.description }}</td>
                <td class="text-center">{{ item.date_debut }}</td>
                <td class="text-center">{{ item.date_fin }}</td>
                <td class="text-center" v-if="item.etat == 0">جاري</td>
                <td class="text-center" v-else-if="item.etat == 1">موافقة</td>
                <td class="text-center" v-else>مرفوض</td>
                <td class="d-flex">
                  <v-btn @click="initIndice(item)" class="mx-2 mb-2">
                    <v-icon color="red"> mdi-delete </v-icon>
                  </v-btn>
                  <v-btn class="mx-2 mb-2" @click="editevents(item.id)">
                    <v-icon color="yellow"> mdi-square-edit-outline </v-icon>
                  </v-btn>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
        <div class="mt-5" style="display: flex; justify-content: center">
          <v-btn
            small
            :disabled="pagination.prevpage == null"
            @click="changer_page(pagination.current_page - 1)"
          >
            <v-icon> mdi-chevron-right </v-icon>
          </v-btn>
          <v-btn
            v-for="num in Math.ceil(
              pagination.per_page ? pagination.total / pagination.per_page : 1
            )"
            :key="num"
            @click="changer_page(num)"
            class="mx-2"
            color="primary"
            :disabled="num == pagination.current_page"
            small
            x-small
          >
            {{ num }}
          </v-btn>
          <v-btn
            small
            :disabled="pagination.nextpage == null"
            @click="changer_page(pagination.current_page + 1)"
          >
            <v-icon> mdi-chevron-left </v-icon>
          </v-btn>
        </div>
      </v-card>
    </div>
    <v-snackbar color="blue" v-model="snackbar_added">
      تمت إضافة الفعالية بنجاح
      <template v-slot:action="{ attrs }">
        <v-btn color="#000" text v-bind="attrs" @click="snackbar_added = false">
          اغلاق
        </v-btn>
      </template>
    </v-snackbar>

    <v-snackbar color="yellow" v-model="snackbar_updated">
      تمت تعديل الفعالية بنجاح
      <template v-slot:action="{ attrs }">
        <v-btn
          color="#000"
          text
          v-bind="attrs"
          @click="snackbar_updated = false"
        >
          اغلاق
        </v-btn>
      </template>
    </v-snackbar>

    <v-snackbar color="blue" v-model="snackbar_supprimer">
      تمت حذف الفعالية بنجاح
      <template v-slot:action="{ attrs }">
        <v-btn
          color="#000"
          text
          v-bind="attrs"
          @click="snackbar_supprimer = false"
        >
          اغلاق
        </v-btn>
      </template>
    </v-snackbar>
    <v-dialog
      v-if="deleteEventSelected != ''"
      transition="dialog-bottom-transition"
      width="auto"
      v-model="dialog"
    >
      <template>
        <v-card>
          <v-toolbar color="primary">
            <h2 style="color: #fff">تأكيد الحذف</h2>
          </v-toolbar>
          <v-card-text>
            <div class="text-h4 pa-12">
              هل تريد حذف هذه الفعالية :
              {{ deleteEventSelected.titre }}
            </div>
          </v-card-text>
          <v-card-actions class="justify-end">
            <v-btn
              :loading="loading_supprimer"
              text
              color="red"
              @click="deleteEvent(deleteEventSelected.id)"
              >حذف</v-btn
            >
            <v-btn text @click="dialog = false">اغلاق</v-btn>
          </v-card-actions>
        </v-card>
      </template>
    </v-dialog>
  </div>
</template>

<script>
import UpdateEvent from "../../components/manage_events/UpdateEvent.vue";
import AddEvent from "../../components/manage_events/AddEvent.vue";
export default {
  name: "consulte_events",
  created() {
    this.FetchData();
    this.changer_page(1);
  },
  data() {
    return {
      search: "",
      events: [],
      AddEvents: false,
      loading_supprimer: false,
      loader: true,
      snackbar_added: false,
      dialog: false,
      deleteEventSelected: [],
      snackbar_supprimer: false,
      snackbar_updated: false,
      idevent_updated: 0,
      update_page: false,
      pagination: {
        current_page: 1,
        totale: 0,
        nextpage: 0,
        prevpage: 0,
        per_page: 0,
      },
    };
  },
  methods: {
    changer_page(num) {
      this.pagination.current_page = num;
      this.FetchData();
    },
    return_page_consulte(check) {
      if (check != undefined) {
        if (check == "updated") {
          this.snackbar_updated = true;
        } else {
          this.snackbar_added = true;
        }
      }
      this.FetchData();
      this.update_page = false;
      this.AddEvents = false;
    },
    deleteEvent(id) {
      this.loading_supprimer = true;
      this.$axios
        .delete("/event/deleteEvenet/" + id)
        .then((res) => {
          console.log(res);
          this.snackbar_supprimer = true;
          this.deleteEventSelected = [];
          this.dialog = false;
          this.loading_supprimer = false;
          this.FetchData();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    initIndice(item) {
      this.deleteEventSelected = item;
      this.dialog = true;
    },
    FetchData() {
      this.$axios
        .get(
          `/event/getEventbyIdUser?${
            this.search ? "search=" + this.search : ""
          }&page=${this.pagination.current_page}`
        )
        .then((response) => {
          // console.log(response.data);
          this.pagination.current_page = response.data.data.current_page;
          this.pagination.prevpage =
            response.data.data.prev_page_url?.split("=")[1];
          this.pagination.nextpage =
            response.data.data.next_page_url?.split("=")[1];
          this.pagination.per_page = response.data.data.per_page;
          this.pagination.total = response.data.data.total;
          this.events = response.data.data.data;
          this.loader = false;
        });
    },
    editevents(id) {
      this.idevent_updated = id;
      this.update_page = true;
    },
  },
  components: {
    AddEvent,
    UpdateEvent,
  },
};
</script>
