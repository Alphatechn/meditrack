<template>
  <div>
    <div
      class="modal fade"
      v-bind:id="dd"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content text-dark">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">
              Transfert du patient --{{ patient_nom }} {{ patient_prenom }}
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form action="" @submit="transPatient">
            <div class="modal-body">
              <div>
                <input
                  type="hidden"
                  v-model="patient_id"
                  class="form-control"
                  id="nom"
                  readonly
                />
              </div>
              <div>
                <label for="service">Au Service De </label>
                <select
                  class="form-select form-control"
                  v-model="service"
                  id="service"
                  required
                >
                  <option
                    v-for="service in allService"
                    :value="service.id"
                    :key="service.id"
                  >
                    {{ service.libelle }}
                  </option>
                </select>
                <span style="color: yellow">{{ error_service }}</span>
              </div>
              <div>
                <label for="motif">Motif</label>
                <input type="text" v-model="motif" class="form-control" />
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Soumettre</button>
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Close
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script >
export default {
  name: "Transfer",
  props: {
    patient: Object,
  },
  data() {
    return {
      dd: "transModal" + this.patient.id_patient,
      patient_id: this.patient.id_patient,
      patient_nom: this.patient.nom,
      patient_prenom: this.patient.prenom,
      allService: [],
      service: "",
      motif: "",
    };
  },
  methods: {
    async fetchService() {
      try {
        const service = await fetch("http://127.0.0.1:8000/api/service", {
          method: "GET",
          headers: {
            Authorization: "Bearer " + localStorage.getItem("current_token"),
            "Content-type": "application/json",
          },
        });
        const Ser = await service.json();
        return Ser;
      } catch (error) {
        console.error("Erreur lors de la récupération des services:", error);
        return [];
      }
    },
    async transPatient(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("patient", this.patient_id);
      formData.append("service", this.service);
      formData.append("motif", this.motif);
      formData.append("idper", localStorage.getItem("current_idper"));

      const res = await fetch("http://127.0.0.1:8000/api/transfert", {
        method: "POST",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("current_token"),
          Accept: "application/json",
        },
        body: formData,
      });

      const data = await res.json();
      if (res.status === 401) {
        alert(data.message + " Please login first!");
      } else {
        alert("Transfert reussi à jour !!!");
        location.reload();
      }
    },
  },
  async created() {
    try {
      this.allService = await this.fetchService();
    } catch (error) {
      console.error(
        "Erreur lors de la récupération des types d'utilisateurs et des services:",
        error
      );
    }
  },
};
</script>