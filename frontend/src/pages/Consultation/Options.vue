<template>
  <div
    class="btn-group d-flex"
    role="group"
    aria-label="Basic mixed styles example"
  >
    <div v-html="consg_button"></div>
    <div v-html="consm_button"></div>
    <div v-html="consc_button"></div>
    <!-- <button  @click="deletePatient"  class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fa fa-trash text-white"></i></button> -->
  </div>
  <General :transfert="transfert" />
  <Maternite :transfert="transfert" />
  <Chirurgie :transfert="transfert" />
</template>

<script >
import General from "./General.vue";
import Maternite from "./Maternite.vue";
import Chirurgie from "./Chirurgie.vue";
export default {
  name: "Options",
  components: { General, Maternite, Chirurgie },
  props: {
    transfert: Object,
  },
  data() {
    return {
      consg_button: "",
      consm_button: "",
      consc_button: "",
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
    const num_modal = this.transfert.id_transfert;
    this.consg_button =
      "<button type='button' class='badge bg-primary' data-bs-toggle='modal' data-bs-target='#consgModal" +
      num_modal +
      "'><i class='bx bxs-badge-dollar'></i> ConsulterG</button>";
    this.consm_button =
      "<button type='button' class='badge bg-primary' data-bs-toggle='modal' data-bs-target='#consmModal" +
      num_modal +
      "'><i class='bx bxs-badge-dollar'></i> ConsulterM</button>";
    this.consc_button =
      "<button type='button' class='badge bg-primary' data-bs-toggle='modal' data-bs-target='#conscModal" +
      num_modal +
      "'><i class='bx bxs-badge-dollar'></i> ConsulterC</button>";
  },
};
</script>
