<template>
  <div
    class="btn-group d-flex"
    role="group"
    aria-label="Basic mixed styles example"
  >
    <div v-html="edit_button"></div>
    <button
      @click="deleteTranf"
      class="btn btn-warning btn-sm"
      data-bs-toggle="modal"
      data-bs-target="#deleteModal"
    >
      Annuler
    </button>
  </div>
  <EditT :transfert="transfert" />
</template>

<script >
import EditT from "./EditT.vue";

export default {
  name: "OptionsT",
  components: { EditT },
  props: {
    transfert: Object,
  },
  data() {
    return {
      edit_button: "",
      trans_button: "",
    };
  },
  methods: {
    async deleteTranf(e) {
      e.preventDefault();
      if (confirm("Êtes vous sur de votre choix ?")) {
        const res = await fetch(
          "http://127.0.0.1:8000/api/transfert/" + this.transfert.id_transfert,
          {
            method: "DELETE",
            headers: {
              Authorization: "Bearer " + localStorage.getItem("current_token"),
              Accept: "application/json",
              "Content-Type": "application/json;charset=utf-8",
            },
          }
        );

        const data = await res.json();

        if (res.status === 401) {
          alert(data.message + " Please login first !");
        } else {
          alert("Information Supprime !!!");
          location.reload();
        }
      }
    },
  },
  async created() {
    const num_modal = this.transfert.id_transfert;
    this.edit_button =
      "<button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#editTModal" +
      num_modal +
      "'><i class='bx bx-edit '></i></button>";
  },
};
</script>
