<template>
  <div>
    <v-container class="mx-auto mt-3 mb-5">
      <h4 class="text-center"> الفعاليات المقترحة</h4>
      <v-text-field
        v-model="search_demander"
        @keyup="FetchEventDemander()"
        append-icon="mdi-magnify"
        label="بحث"
        max-width="100"
        single-line
        hide-details
      ></v-text-field>
      <v-row max-width="700" class="mt-2 mb-2">
        <v-card   class="mt-5"
          style="padding: 25px 15px; margin: 0 auto"
         v-if="loader_demander==false">
            <v-progress-circular
            :width="3"
            color="red"
            indeterminate
          ></v-progress-circular>
        </v-card>
        <v-card
          class="mt-5"
          style="padding: 25px 15px; margin: 0 auto"
          v-else-if="EventDemander == ''"
        >
        لا تتوافر بيانات
        </v-card>
        <v-card
          v-else
          v-for="event in EventDemander"
          :key="event"
          class="mx-5 mb-2"
          style="padding: 15px"
          max-width="300"
        >
          <h5>
            مقترح الفعالية {{ event.user["first_name"] + " " + event.user["last_name"] }}
          </h5>
          <h4 class="text-center mb-4">{{ event.titre }}</h4>
          <div class="text-center py-2">
            <v-btn
              class="text-center"
              color="primary"
              @click="initIndice(event)"
              >مزيد من المعلومات</v-btn
            >
          </div>
          <v-container>
            <v-row class="mt-2 justify-center">
              <v-btn
                @click="AccepterEvent(event.id)"
                class="mx-2 mb-1"
                style="color: blue"
                text
                outlined
                >قبول</v-btn
              >
              <v-btn
                type="button"
                @click="rejeter(event.id)"
                text
                outlined
                style="color: red"
                >رفض</v-btn
              >
            </v-row>
          </v-container>
        </v-card>
      </v-row>
      <v-dialog
        v-if="eventdemandercurrent != ''"
        transition="dialog-bottom-transition"
        width="auto"
        v-model="dialog_demander"
      >
        <template>
          <v-card>
            <v-toolbar color="primary">
              <h2 style="color: #fff">{{ eventdemandercurrent.titre }}</h2>
            </v-toolbar>
            <v-card-text>
              <div class="text-h4 pa-12">
                <div class="row">
                  <div class="col-lg-12 text-center">وصف</div>
                  <div class="col-lg-12 text-center">
                    {{ eventdemandercurrent.description }}
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">تاريخ البدء</div>
                  <div class="col-lg-6">
                    {{ eventdemandercurrent.date_debut }}
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">تاريخ الانتهاء</div>
                  <div class="col-lg-6">
                    {{ eventdemandercurrent.date_fin }}
                  </div>
                </div>
              </div>
            </v-card-text>
            <v-card-actions class="justify-end">
              <v-btn text @click="dialog_demander = false">اغلاق</v-btn>
            </v-card-actions>
          </v-card>
        </template>
      </v-dialog>
      <div class="justify-center mt-3">
        <v-btn
          class="mx-2"
          :disabled="pagination.page_prev == null"
          @click="changerPage(pagination.current_page - 1)"
        >
          <v-icon> mdi-chevron-right </v-icon>
        </v-btn>
        <v-btn
          v-for="num in Math.ceil(
            pagination.per_page ? pagination.total / pagination.per_page : 1
          )"
          :key="num"
          color="primary"
          @click="changerPage(num)"
          :disabled="pagination.current_page == num"
        >
          {{ num }}
        </v-btn>
        <v-btn
          class="mx-2"
          :disabled="pagination.page_suiv == null"
          @click="changerPage(pagination.current_page + 1)"
        >
          <v-icon> mdi-chevron-left </v-icon>
        </v-btn>
      </div>
      <v-snackbar color="blue" v-model="snackbar_accepted">
        تم قبول الفعالية
        <template v-slot:action="{ attrs }">
          <v-btn
            color="#000"
            text
            v-bind="attrs"
            @click="snackbar_accepted = false"
          >
            اغلاق
          </v-btn>
        </template>
      </v-snackbar>
    </v-container>

    <v-container>
      <div class="mt-5 py-5">
        <v-card elavation="7" style="padding: 25px">
          <div class="row" v-if="event_current == 'accepter'">
            <span class="col-lg-2">
              <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    @click="changerView('rejeter')"
                    class="mb-5"
                    v-bind="attrs"
                    v-on="on"
                    outlined
                    fab
                    color="blue"
                  >
                    <v-icon>mdi-note-remove</v-icon>
                  </v-btn>
                </template>
                <span>رفض</span>
              </v-tooltip>
            </span>
            <h4 class="col-lg-10 text-center py-4">الفعاليات المقبولة</h4>
          </div>
          <div class="row" v-else>
            <span class="col-lg-2">
              <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    @click="changerView('accepter')"
                    class="mb-5"
                    v-bind="attrs"
                    v-on="on"
                    outlined
                    fab
                    color="blue"
                  >
                    <v-icon>mdi-calendar-star</v-icon>
                  </v-btn>
                </template>
                <span>قبول</span>
              </v-tooltip>
            </span>
            <h4 class="col-lg-10 text-center py-4">الفعاليات المرفوضة</h4>
          </div>
          <div v-if="event_current == 'accepter'">
            <div class="gap-4 p-5">
              <div class="col-lg-12 mx-2 text-center">
                <v-text-field
                  v-model="search_acc"
                  append-icon="mdi-magnify"
                  @keyup="serchdata()"
                  label="بحث"
                  single-line
                  hide-details
                ></v-text-field>
              </div>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-center">*</th>
                      <th class="text-center">اسم</th>
                      <th class="text-center">اللقب</th>
                      <th class="text-center">اسم الفعالية</th>
                      <th class="text-center">تاريخ البدء</th>
                      <th class="text-center">تاريخ الانتهاء</th>
                      <th class="text-center">حذف</th>
                    </tr>
                  </thead>
                  <tbody v-if="loader == ''">
                    <tr>
                      <td colspan="5" class="text-center">
                        <v-progress-circular
                          :width="3"
                          color="red"
                          indeterminate
                        ></v-progress-circular>
                      </td>
                    </tr>
                  </tbody>
                  <tbody v-else-if="AllEventAccepted == ''">
                    <tr>
                      <td colspan="6" class="text-center">لا تتوافر بيانات</td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr v-for="item in AllEventAccepted" :key="item">
                      <td>{{ item.id }}</td>
                      <td>{{ item.user["first_name"] }}</td>
                      <td>{{ item.user["last_name"] }}</td>
                      <td>{{ item.titre }}</td>
                      <td>{{ item.date_debut }}</td>
                      <td>{{ item.date_fin }}</td>
                      <v-btn @click="deleteEvent(item.id)" class="mx-2 mb-2">
                        <v-icon color="red"> mdi-delete </v-icon>
                    </v-btn>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
            </div>
          </div>
          <div v-else>
            <div class="gap-4 p-5">
              <div class="col-lg-12 mx-2 text-center">
                <v-text-field
                  v-model="search_acc"
                  append-icon="mdi-magnify"
                  @keyup="serchdata()"
                  label="بحث "
                  single-line
                  hide-details
                ></v-text-field>
              </div>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                        <th class="text-center">*</th>
                        <th class="text-center">اسم</th>
                        <th class="text-center">اللقب</th>
                        <th class="text-center">اسم الفعالية</th>
                        <th class="text-center">تاريخ البدء</th>
                        <th class="text-center">تاريخ الانتهاء</th>
                        <th class="text-center">حذف</th>
                    </tr>
                  </thead>
                  <tbody v-if="loader == ''">
                    <tr>
                      <td colspan="5" class="text-center">
                        <v-progress-circular
                          :width="3"
                          color="red"
                          indeterminate
                        ></v-progress-circular>
                      </td>
                    </tr>
                  </tbody>
                  <tbody v-else-if="AllEventRejeter == ''">
                    <tr>
                      <td colspan="6" class="text-center">لا تتوافر بيانات</td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr v-for="item in AllEventRejeter" :key="item">
                      <td>{{ item.id }}</td>
                      <td>{{ item.user["first_name"] }}</td>
                      <td>{{ item.user["last_name"] }}</td>
                      <td>{{ item.titre }}</td>
                      <td>{{ item.date_debut }}</td>
                      <td>{{ item.date_fin }}</td>
                      <td>
                           <v-btn @click="deleteEvent(item.id)" class="mx-2 mb-2">
                              <v-icon color="red"> mdi-delete </v-icon>
                          </v-btn>
                      </td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
            </div>
          </div>

          <v-snackbar v-model="snackbar_rejeter">
            تم حذف الفعالية
            <template v-slot:action="{ attrs }">
              <v-btn
                color="indigo"
                text
                v-bind="attrs"
                @click="snackbar_rejeter = false"
              >
              اغلاق
              </v-btn>
            </template>
          </v-snackbar>
        </v-card>
      </div>
    </v-container>
  </div>
</template>

<script>
export default {
  created() {
    if (this.event_current == "accepter") {
      this.fetchAcceptedEvent();
    } else {
      this.fetchRejeterEvent();
    }
    this.FetchEventDemander();
  },
  data() {
    return {
      snackbar_accepted: false,
      loader: false,
      loader_demander:false,
      event_current: "accepter",
      EventDemander: [],
      search_demander: "",
      snackbar_rejeter: false,
      search_acc: "",
      AllEventAccepted: [],
      AllEventRejeter: [],
      eventdemandercurrent: [],
      dialog_demander: false,
      pagination_acc: {
        current_page: 1,
        prev_page: 0,
        next_page: 0,
        per_page: 0,
        total: 0,
      },
      pagination: {
        current_page: 1,
        total: 0,
        page_suiv: 0,
        page_prev: 0,
        per_page: 0,
      },
    };
  },
  methods: {
    serchdata(){
        if(this.event_current=='accepter'){
            this.fetchAcceptedEvent();
        }else{
            this.fetchRejeterEvent();
        }
    },
    rejeter(id) {
      this.$axios
        .post("/gererEvent/RejeterEvent/" + id)
        .then((res) => {
          console.log(res);
          this.FetchEventDemander();
          this.snackbar_rejeter = true;
          this.fetchRejeterEvent();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    changerView(curent) {
      this.search_acc='';
      this.loader=false;
      this.event_current = curent;
      if (this.event_current == "accepter") {
        this.fetchAcceptedEvent();
      } else {
        this.fetchRejeterEvent();
      }
    },
    changerPage(num) {
      this.pagination.current_page = num;
      this.FetchEventDemander();
    },
    initIndice(item) {
      this.eventdemandercurrent = item;
      this.dialog_demander = true;
    },
    AccepterEvent(id) {
      this.$axios
        .post("/gererEvent/AccpeterEvent/" + id)
        .then((res) => {
          console.log(res);
          this.FetchEventDemander();
          this.snackbar_accepted = true;
          this.fetchAcceptedEvent();
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteEvent(id){
        this.$axios.delete('/gererEvent/deleteEvent/'+id).then((res)=>{
            console.log(res);
             if(this.event_current=='accepter'){
                this.fetchAcceptedEvent();
             }else{
                this.fetchRejeterEvent();
             }
        }).catch((error)=>{
            console.log(error);
        })
    },
    global_pagination(data) {
      this.pagination_acc.total = data.total;
      this.pagination_acc.per_page = data.per_page;
      this.pagination_acc.current_page = data.current_page;
      this.pagination_acc.next_page = data.next_page_url?.split("=")[1];
      this.pagination_acc.prev_page = data.prev_page_url?.split("=")[1];
    },
    fetchAcceptedEvent() {
      this.$axios
        .get(
          `/gererEvent/getEventAccepter?${
            this.search_acc ? "search=" + this.search_acc : ""
          }&page=${this.pagination_acc.current_page}`
        )
        .then((res) => {
          this.loader = true;
          this.AllEventAccepted = res.data.data.data;
        
          this.global_pagination(res.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    fetchRejeterEvent() {
      this.$axios
        .get(
          `/gererEvent/getEventrejeter?${
            this.search_acc ? "search=" + this.search_acc : ""
          }&page=${this.pagination_acc.current_page}`
        )
        .then((res) => {
          this.loader = true;
          this.AllEventRejeter = res.data.data.data;
          this.global_pagination(res.data.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    FetchEventDemander() {
      this.$axios
        .get(
          `/gererEvent/getEventDemander?${
            this.search_demander ? "search=" + this.search_demander : ""
          }&page=${this.pagination.current_page}`
        )
        .then((res) => {
          this.loader_demander=true;
          this.EventDemander = res.data.data.data;
          this.pagination.current_page = res.data.data.current_page;
          this.pagination.total = res.data.data.total;
          this.pagination.page_suiv =
            res.data.data.next_page_url?.split("=")[1];
          this.pagination.page_prev =
            res.data.data.prev_page_url?.split("=")[1];
          this.pagination.per_page = res.data.data.per_page;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
