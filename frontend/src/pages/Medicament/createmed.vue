<template>
  <div class="pagetitle">
    <h1>Medicament</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/home">Home</router-link>
        </li>
        <li class="breadcrumb-item">Medicament</li>
        <li class="breadcrumb-item active">Creer</li>
      </ol>
    </nav>
  </div>
  <!-- End Page Title -->

  <div class="content">
    <div class="container-fluid">
      <div class="card bg-white border-0">
        <div class="col-lg-12 col-md-12">
          <div class="card-header border-0 bg-white">
            <div class="row">
              <h4 id="mss" class="text-success">Ajouter un medicament</h4>
            </div>
          </div>
          <div class="card-body border-0">
            <form @submit="create">
              <div class="row justify-content-center">
                <div class="col-6">
                  <label for="nom ">Nom medicament</label>
                  <input
                    class="form-control"
                    v-model="libelle"
                    type="text"
                    
                    name="medicament"
                  />
                  <span style="color: red">{{ error_libelle }}</span>
                </div>
                <div class="col-6">
                  <label for="categorie">categorie</label>
                  <select
                    class="form-select form-control"
                    v-model="categorie"
                    id="categorie"
                    name="categorie"
                  >
                    <option
                      v-for="categorie in allcat"
                      :value="categorie.id"
                      :key="categorie.id"
                    >
                      {{ categorie.libelle }}
                    </option>
                  </select>
                  <span style="color: yellow">{{ error_categorie }}</span>
                </div>
                 <div class="col-6 mt-3">
                  <label for="prix ">Prix</label>
                  <input
                    class="form-control"
                    v-model="prix"
                    type="text"
                    
                    name="prix"
                  />
                  <span style="color: red">{{ error_prix }}</span>
                </div>
              </div>
              <br />
              <div class="row mb-3">
              <div class="col text-center">
                <button class="btn btn-success btt">ENREGISTER</button>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script >
export default {
  name: "addmed",
  data() {
    return {
      categorie: "",
      libelle: "",
      prix: "",
      allcat: [],
      error_id_cat: "",
      error_libelle: "",
      error_prix: "",
    };
  },
  methods: {
    async fetchCategorie() {
      try {
        const categorie = await fetch("http://127.0.0.1:8000/api/categorie", {
          method: "GET",
          headers: {
            Authorization: "Bearer " + localStorage.getItem("current_token"),
            "Content-type": "application/json",
          },
        });
        const cat = await categorie.json();
        return cat;
      } catch (error) {
        console.error("Erreur lors de la récupération des categories:", error);
        return [];
      }
    },

    async create(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("categorie", this.categorie);
      formData.append("libelle", this.libelle);
      formData.append("prix", this.prix);

      try {
        const res = await fetch("http://127.0.0.1:8000/api/medicament", {
          method: "POST",
          headers: {
            Authorization: "Bearer " + localStorage.getItem("current_token"),
            Accept: "application/json",
          },
          body: formData,
        });

        if (res.status === 422) {
          const error_msg = await res.json();
          console.log(error_msg);
          this.error_id_cat = error_msg.errors?.id_cat?.[0] || "";
          this.error_libelle = error_msg.errors?.libelle?.[0] || "";
          this.error_prix = error_msg.errors?.prix?.[0] || "";
        } else {
          this.id_cat = "";
          this.error_id_cat = "";

          this.libelle = "";
          this.error_libelle = "";
          this.error_prix = "";

          alert("Medicament ajouter avec succès !");
        }
      } catch (error) {
        console.error("Erreur lors de la création d'un medicament:", error);
        alert("Une erreur est survenue lors de la création d'un' medicament.");
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