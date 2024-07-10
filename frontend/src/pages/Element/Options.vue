<template>
  <div
    class="btn-group d-flex"
    role="group"
    aria-label="Basic mixed styles example"
  >
    <div v-html="edit_button"></div>

    <button
      @click="deleteElement"
      class="btn btn-warning btn-sm"
      data-bs-toggle="modal"
      data-bs-target="#deleteModal"
    >
      <i class="bi bi-trash"></i>
    </button>
  </div>
  <Edit :element="element" />
</template>

<script >
import Edit from "./Edit.vue";

export default {
  name: "Options",
  components: { Edit },
  props: {
    element: Object,
  },
  data() {
    return {
      edit_button: "",
    };
  },
  methods: {
    async deleteElement(e) {
      e.preventDefault();
      if (confirm("Êtes vous sur de votre choix ?")) {
        const res = await fetch(
          "http://127.0.0.1:8000/api/element/" + this.element.id,
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
    const num_modal = this.element.id;
    this.edit_button =
      "<button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#editModal" +
      num_modal +
      "'><i class='bx bx-edit '></i></button>";
  },
};
</script>
