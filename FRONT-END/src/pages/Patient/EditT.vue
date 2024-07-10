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
              Edit transfert --{{ transfert_nom }} {{ transfert_prenom }}
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form action="" @submit="updatePatient">
            <div class="modal-body">
              <div>
                <label for="service">Au Service De </label>
                <select
                  class="form-select form-control"
                  v-model="transfert_id_service"
                  id="service"
                  required
                >
                  <option
                    v-for="service in allService"
                    :value="service.id"
                    :key="service.id"
                    :selected="transfert_id_service === service.id"
                  >
                    {{ service.libelle }}
                  </option>
                </select>
              </div>
              <div>
                <label for="motif">Motif</label>
                <input
                  type="text"
                  v-model="transfert_motif"
                  class="form-control"
                />
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">
                update transfert
              </button>
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
  name: "Edit",
  props: {
    transfert: Object,
  },
  data() {
    return {
      dd: "editTModal" + this.transfert.id_transfert,
      transfert_id: this.transfert.id_transfert,
      transfert_nom: this.transfert.nom,
      transfert_prenom: this.transfert.prenom,
      transfert_id_service: this.transfert.id_service,
      transfert_motif: this.transfert.motif,
      allService: [],
      service: "",
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
    async updatePatient(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("service", this.transfert_id_service);
      formData.append("motif", this.transfert_motif);
      const res = await fetch(
        "http://127.0.0.1:8000/api/transfert/" + this.transfert.id_transfert,
        {
          method: "POST",
          headers: {
            Authorization: "Bearer " + localStorage.getItem("current_token"),
            Accept: "application/json",
          },
          body: formData,
        }
      );

      const data = await res.json();
      if (res.status === 401) {
        alert(data.message + " Please login first!");
      } else {
        alert("Informations à jour !!!");
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