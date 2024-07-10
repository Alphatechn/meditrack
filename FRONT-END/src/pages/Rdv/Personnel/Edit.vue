<template>
  <div>
    <div
      class="modal fade"
      v-bind:id="dd"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content text-dark">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">
              Modifier RDV -- Motif : {{ rdv_motif }}
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form action="" @submit="updateRdv">
            <div class="modal-body">
              <div class="row justify-content-center">
                <div class="col-sm-6 mb-3">
                  <label for="date_rdv" class="form-label"
                    >Date Rendez-Vous</label
                  >
                  <input
                    type="date"
                    v-model="rdv_date"
                    class="form-control"
                    id="date_rdv"
                  />
                </div>
                <div class="col-sm-6 mb-3">
                  <label for="status" class="form-label" >Status</label>
                  <select v-model="rdv_status" class="form-control" id="">
                    <option value="">Demandé</option>
                    <option :selected="rdv_status === 'Confirmé'" value="Confirmé">
                      Confirmé
                    </option>
                    <option :selected="rdv_status === 'Annulé'" value="Annulé">
                      Annulé
                    </option>
                    <option :selected="rdv_status === 'Reporté'" value="Reporté">
                      Reporté
                    </option>
                    <option :selected="rdv_status === 'Réalisé'" value="Réalisé">
                      Réalisé
                    </option>
                  </select>
                </div>
                <div class="col-sm-6 mb-3">
                  <label for="time_rdv" class="form-label"
                    >Heure Rendez-Vous</label
                  >
                  <input
                    type="time"
                    v-model="rdv_time"
                    class="form-control"
                    id="time_rdv"
                  />
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">
                Enregistrer
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

<script>
export default {
  name: "Edit",
  props: {
    patient: Object,
  },
  data() {
    return {
      dd: "editModal" + this.patient.id_rdv,
      rdv_motif: this.patient.motif_r,
      rdv_status: this.patient.status_r,
      rdv_date: this.patient.date_r,
      rdv_time: this.patient.time_r,
    };
  },
  methods: {
    async updateRdv(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("motif", this.rdv_motif);
      formData.append("status", this.rdv_status);
      formData.append("date", this.rdv_date);
      formData.append("time", this.rdv_time);
      formData.append("id_pat", this.patient.id_pat);
      formData.append("id_pers", this.patient.id_pers);

      const res = await fetch(
        "http://127.0.0.1:8000/api/rdvupd/pers/" + this.patient.id_rdv,
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
};
</script>
