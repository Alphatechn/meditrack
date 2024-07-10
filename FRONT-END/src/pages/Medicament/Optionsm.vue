<template>
  <div class="btn-group" role="group" aria-label="Basic mixed styles example">
    <div v-html="edit_button"></div>
    <button
      type="button"
      @click="deleteMedicament"
      class="btn btn-warning"
      data-bs-toggle="modal"
      data-bs-target="#deleteModal"
    >
      Delete
    </button>
  </div>

  <Edite :medicament="medicament" />
</template>

<script >
import Edite from "./Edite.vue";

export default {
  name: "Optionsm",
  components: { Edite },
  props: {
    medicament: Object,
  },
  data() {
    return {
      edit_button: "",
    };
  },
  methods: {
    async deleteMedicament(e) {
      e.preventDefault();
      if (confirm("Are you sure ?")) {
        const res = await fetch(
          "http://127.0.0.1:8000/api/medicament/" +
            this.medicament.id_medicament,
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
    const num_modal = this.medicament.id_medicament;
    this.edit_button =
      "<button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#editModal" +
      num_modal +
      "'>Edit</button>";
  },
};
</script>
