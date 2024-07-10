<template>
  <div class="btn-group" role="group" aria-label="Basic mixed styles example">
    <div v-html="edit_button"></div>
    <button
      type="button"
      @click="deletePersonnel"
      class="btn btn-warning"
      data-bs-toggle="modal"
      data-bs-target="#deleteModal"
    >
      Delete
    </button>
  </div>

  <Edit :personnel="personnel" />
</template>

<script >
import Edit from "./Edit.vue";

export default {
  name: "Options",
  components: { Edit },
  props: {
    personnel: Object,
  },
  data() {
    return {
      edit_button: "",
    };
  },
  methods: {
    async deletePersonnel(e) {
      e.preventDefault();
      if (confirm("Are you sure ?")) {
        const res = await fetch(
          "http://127.0.0.1:8000/api/personnel/" + this.personnel.id_personnel,
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
    const num_modal = this.personnel.id_personnel;
    this.edit_button =
      "<button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#editModal" +
      num_modal +
      "'>Edit</button>";
  },
};
</script>
