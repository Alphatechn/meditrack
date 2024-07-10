<template>
  <div
    class="btn-group d-flex justify-content-center "
    role="group"
    aria-label="Basic mixed styles example"
  >
  
    <div v-html="edit_button"></div>
    
  </div>
  <Edit :patient="patient" />
  <Transfert :patient="patient" />
</template>


<script >
import Edit from "./Edit.vue";

export default {
  name: "Options",
  components: { Edit },
  props: {
    patient: Object,
  },
  data() {
    return {
      edit_button: "",
      trans_button: "",
    };
  },
  methods: {
    async deletePatient(e) {
      e.preventDefault();
      if (confirm("Êtes vous sur de votre choix ?")) {
        const res = await fetch(
          "http://127.0.0.1:8000/api/patient/" + this.patient.id_patient,
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
    const num_modal = this.patient.id_patient;
    this.edit_button =
      "<button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" +
      num_modal +
      "'><i class='bx bx-edit '></i> Ouvrir</button>";
  },
};
</script>
