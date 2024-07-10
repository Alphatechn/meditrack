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
              Edit Categorie --{{ categorie_libelle }}
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form @submit="updateCategorie">
            <div class="modal-body">
              <div>
                <label for="libelle" class="form-label">Categorie</label>
                <input
                  type="text"
                  v-model="categorie_libelle"
                  class="form-control"
                  id="libelle"
                  placeholder="categorie name..."
                />
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">
                update categorie
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
    categorie: Object,
  },
  data() {
    return {
      dd: "editModal" + this.categorie.id,
      categorie_id: this.categorie.id,
      categorie_libelle: this.categorie.libelle,
    };
  },
  methods: {
    async updateCategorie(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("libelle", this.categorie_libelle);

      const res = await fetch(
        "http://127.0.0.1:8000/api/categorie/" + this.categorie.id,
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