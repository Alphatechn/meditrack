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
              Edit examen --{{ examen_libelle }} {{ examen_prix_examen }}
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form action="" @submit="updateExamen">
            <div class="modal-body">
              <div>
                <label for="libelle" class="form-label">Libelle</label>
                <input
                  type="text"
                  v-model="examen_libelle"
                  class="form-control"
                  id="nom"
                  placeholder="examen name..."
                />
              </div>
              <div>
                <label for="prix_examen" class="form-label">Montant</label>
                <input
                  type="text"
                  v-model="examen_prix_examen"
                  class="form-control"
                  id="prix_examen"
                  placeholder="examen buy..."
                />
              </div>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">
                update Examen
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
    examen: Object,
  },
  data() {
    return {
      dd: "editModal" + this.examen.id,
      examen_id: this.examen.id,
      examen_libelle: this.examen.libelle,
      examen_prix_examen: this.examen.prix_examen,
    };
  },
  methods: {
    async updateExamen(e) {
      e.preventDefault();
      const formData = new FormData();

      formData.append("libelle", this.examen_libelle);
      formData.append("prix_examen", this.examen_prix_examen);

      const res = await fetch(
        "http://127.0.0.1:8000/api/examen/" + this.examen.id,
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