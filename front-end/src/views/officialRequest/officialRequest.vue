<template>
  <div class="content container">
      <b-alert class="mt-4" :show="alert.dismissCountDown" dismissible :variant="alert.variant"
            @dismissed="alert.dismissCountDown = 0">
            <p>{{ alert.msg }}</p>
          </b-alert>
    <div class="card card-body my-5 py-5 text-center" v-if="demandes.length == 0">
      <h3>il y'a aucune demande</h3>
    </div>
    <v-card class="my-2" v-for="demande in demandes" :key="demande.id">
      <md-tabs>
        <md-tab id="tab-home" md-label="demande">
          <div class="bv-example-row text-center">
            <v-row class="mb-2">
               <v-row>
                <v-col>المرسل : {{ demande.user.first_name+" "+demande.user.last_name }} المرسل اليه : {{ demande.receiver}}</v-col>
              </v-row>

              <v-row>
                <v-col>تاريخ الارسال  : {{ demande.created_at }} </v-col>
              </v-row>
            </v-row>
            <v-row>          
                <v-col>الموضوع : {{ demande.subject }}</v-col>        
            </v-row>
                <v-row >
                <v-col>المحتوى : {{ demande.content }}</v-col>
                </v-row>            
            <!-- <b-button variant="success" :class="[{ disabled: demande.status == 1 }]" v-on:click="Approve(demande.id)">Approve</b-button>
            <b-button variant="danger" :class="[{ disabled: demande.status == 2 }]" v-on:click="Desapprove(demande.id)">Desapprove</b-button> -->
          </div>
        </md-tab>
      </md-tabs>
    </v-card>
    <nav class="row" v-if="demandes.length != 0">
      <ul class="pagination w-auto mx-auto">
        <li :class="[{ disabled: !pagination.prev_page_url }]" class="page-item">
          <a @click="getRequests(pagination.prev_page_url)" class="btn btun page-link" :class="[
            !pagination.prev_page_url ? 'disabled' : 'link-primary btun',
          ]">Precedent</a>
        </li>
        <li class="page-item">
          <a class="page-link text-dark" href="#">{{
              pagination.current_page + "/" + pagination.last_page
          }}</a>
        </li>
        <li :class="[{ disabled: !pagination.next_page_url }]" class="page-item">
          <a @click="getRequests(pagination.next_page_url)" :class="[
            !pagination.next_page_url ? 'disabled' : 'link-primary btun',
          ]" class="btun btn page-link">Suivant</a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  data() {
    return {
        snack: false,
        snackColor: "",
        snackText: "",
        demandes: [],
        pagination: {},
        show: true,
        alert: {
            dismissCountDown: 0,
            variant: "",
            msg: "",
        },
    };
  },
  created() {
      this.getRequests();
  },
  methods: {
     getRequests() {
      let vm = this;
      this.$axios
        .get("/officialRequest")
        .then((response) => {
          this.demandes = response.data.data;
          vm.makePagination(response.data);
        })
        .catch((error) => {
          console.log(error);
          this.snack = true;
          this.snackColor = "red";
          this.snackText = error.response.data.error
            ? error.response.data.error
            : "لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا";
        });
    },
    makePagination(meta) {
      this.pagination = {
        current_page: meta.current_page,
        current_page_url:
          "http://localhost:8000/api/officialRequest?page=" + meta.current_page,
        last_page: meta.last_page,
        next_page_url: meta.next_page_url,
        prev_page_url: meta.prev_page_url,
      };
    },
  },
}
</script>

<style>
</style>