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
              Edit element --{{ element_libelle }} {{ element_montant }}
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form action="" @submit="updateElement">
            <div class="modal-body">
              <div>
                <label for="libelle" class="form-label">Libelle</label>
                <input
                  type="text"
                  v-model="element_libelle"
                  class="form-control"
                  id="nom"
                  placeholder="element name..."
                />
              </div>
              <div>
                <label for="montant" class="form-label">Montant</label>
                <input
                  type="text"
                  v-model="element_montant"
                  class="form-control"
                  id="montant"
                  placeholder="element buy..."
                />
              </div>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">
                update element
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
    element: Object,
  },
  data() {
    return {
      dd: "editModal" + this.element.id,
      examen_id: this.element.id,
      element_libelle: this.element.libelle,
      element_montant: this.element.montant,
    };
  },
  methods: {
    async updateElement(e) {
      e.preventDefault();
      const formData = new FormData();

      formData.append("libelle", this.element_libelle);
      formData.append("montant", this.element_montant);

      const res = await fetch(
        "http://127.0.0.1:8000/api/element/" + this.element.id,
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