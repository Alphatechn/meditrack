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
              Edit --{{ medicament_libelle }}
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form @submit="updateMedicament">
            <div class="modal-body">
              <div>
                <label for="libelle" class="form-label">Medicament</label>
                <input
                  type="text"
                  v-model="medicament_libelle"
                  class="form-control"
                  id="libelle"
                  placeholder="nom medicament name..."
                />
              </div>

              <div>
                <label for="type_user">Categorie</label>

                <select
                  class="form-select"
                  v-model="medicament_id_cat_cat"
                  id="cat"
                >
                  <option
                    v-for="categorie in allcat"
                    :value="categorie.id"
                    :key="categorie.id"
                    :selected="medicament_id_cat === categorie.id"
                  >
                    {{ categorie.libelle }}
                  </option>
                </select>
                <span style="color: yellow">{{ error_id_cat }}</span>
              </div>
              <div>
                <label for="prix" class="form-label">Prix</label>
                <input
                  type="text"
                  v-model="medicament_prix"
                  class="form-control"
                  id="prix"
                />
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">
                update medicament
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
    medicament: Object,
  },
  data() {
    return {
      dd: "editModal" + this.medicament.id_medicament,
      medicament_id: this.medicament.id_medicament,
      medicament_libelle: this.medicament.medi,
      medicament_prix: this.medicament.prix,
      medicament_id_cat_cat: this.medicament.id_cat,
      allcat: [],
      cat: null,
    };
  },
  methods: {
    async fetchCategorie() {
      const cat = await fetch("http://127.0.0.1:8000/api/categorie", {
        method: "GET",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("current_token"),
          "Content-type": "application/json",
        },
      });
      const cats = await cat.json();
      return cats;
    },
    async updateMedicament(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("libelle", this.medicament_libelle);
      formData.append("id_cat", this.medicament_id_cat_cat);
      formData.append("prix", this.medicament_prix);

      const res = await fetch(
        "http://127.0.0.1:8000/api/medicament/" + this.medicament.id_medicament,
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
      this.allcat = await this.fetchCategorie();
    } catch (error) {
      console.error("Erreur lors de la récupération des categories:", error);
    }
  },
};
</script>