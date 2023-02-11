<template>
	<v-container>
	  <Form
		:dialog="dialog"
		@close="reset"
		@add="add"
		:troupe="troupe"
		:edit="edit"
	  />
	  <v-btn color="success" class="m-2 mr-0 mt-4" large @click="dialog = true">
		<v-icon>mdi-plus</v-icon>
		اضافة
	  </v-btn>
	  <show
		:headers="headers"
		:request="request"
		@delete="delet"
		@update="update"
	  />
	  <v-snackbar v-model="snack" :timeout="10000" :color="snackColor">
		{{ snackText }}
		<template v-slot:action="{ attrs }">
		  <v-btn v-bind="attrs" text @click="snack = false"> اغلاق </v-btn>
		</template>
	  </v-snackbar>
	</v-container>
  </template>
  
  <script>
  import show from "@/components/requestDocuments/show.vue";
  import Form from "@/components/requestDocuments/form.vue";
  
  export default {
	components: {
	  show,
	  Form,
	},
	data() {
	  return {
		request: [],
		troupe: {},
		snack: false,
		snackColor: "",
		dialog: false,
		snackText: "",
		edit: false,
	  };
	},
	created() {
	  this.getrequest();
	},
	methods: {
	  getrequest() {
		this.$axios
		  .get("/requestDocuments")
		  .then((response) => {
			this.request = response.data;
			console.log(this.request);
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
	  delet(id) {
		this.$axios
		  .delete("/requestDocuments/" + id)
		  .then(() => {
			this.getrequest();
			this.snack = true;
			this.snackColor = "green";
			this.snackText = "تم حذف الطرق المرضية بنجاح";
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
	  update(troupe) {
		this.edit = true;
		this.troupe = troupe;
		this.dialog = true;
	  },
	  add(form) {
		if (!this.edit) {
		  this.$axios
			.post("/requestDocuments", form)
			.then(() => {
			  this.getrequest();
			  this.snack = true;
			  this.snackColor = "success";
			  this.snackText = "تمت الاضافة بنجاح";
			})
			.catch((error) => {
			  console.log(error);
			  this.snack = true;
			  this.snackColor = "red";
			  this.snackText = error.response.data.error
				? error.response.data.error
				: "لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا";
			});
		}else{
		  this.$axios
			.put("/requestDocuments/" + this.troupe.id, form)
			.then(() => {
			  this.getrequest();
			  this.snack = true;
			  this.snackColor = "success";
			  this.snackText = "تم التعديل بنجاح";
			})
			.catch((error) => {
			  console.log(error);
			  this.snack = true;
			  this.snackColor = "red";
			  this.snackText = error.response.data.error
				? error.response.data.error
				: "لقد حصل عطب في الخادم, الرجاء المحاولة لاحقا";
			});
		}
	  },
	  reset(){
		this.edit = false;
		this.troupe = {};
		this.dialog = false;
	  }
	},
	computed: {
	  headers() {
		return [
		  {
			text: "العنوان",
			value: "title",
		  },
		  {
			text: "الى",
			value: "to",
		  },
		  {
			text: "التاريخ",
			value: "date",
		  },
		  {
			text: "الحالة",
			value: "status",
		  },
		  {
			text: "اجرائات",
			value: "actions",
			sortable: false,
		  },
		];
	  },
	},
  };
  </script>
  
  <style>
  </style>