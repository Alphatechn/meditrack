<template>
  <div class="pagetitle">
    <h1>Personnel</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/home">Home</router-link>
        </li>
        <li class="breadcrumb-item active">Creation</li>
      </ol>
    </nav>
  </div>
  <!-- End Page Title -->

  <div class="content">
    <div class="container-fluid">
      <div class="card align-self-center border-0 p-2">
        <div class="card-header border-0 bg-white">
          <div class="row">
            <h4 id="mss" class="text-success">Ajouter un personnel</h4>
          </div>
        </div>
        <div class="card-body border-0">
          <form @submit="create">
            <div class="row mb-3">
              <div class="col-sm-6">
                <label for="nom" class="form-label">Nom</label>
                <input
                  class="form-control"
                  v-model="nom"
                  type="text"
                  id="nom"
                />
                <span class="text-warning">{{ error_nom }}</span>
              </div>
              <div class="col-sm-6">
                <label for="prenom" class="form-label">Prenom</label>
                <input
                  class="form-control"
                  type="text"
                  v-model="prenom"
                  id="prenom"
                />
                <span class="text-warning">{{ error_prenom }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-4">
                <label for="service" class="form-label">Service</label>
                <select
                  class="form-select"
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
                <span class="text-warning">{{ error_service }}</span>
              </div>
              <div class="col-sm-4">
                <label for="telephone" class="form-label">Telephone</label>
                <input
                  class="form-control"
                  type="text"
                  v-model="telephone"
                  id="telephone"
                />
                <span class="text-warning">{{ error_telephone }}</span>
              </div>
              <div class="col-sm-4">
                <label for="adresse" class="form-label">Adresse</label>
                <input
                  class="form-control"
                  type="text"
                  v-model="adresse"
                  id="adresse"
                />
                <span class="text-warning">{{ error_adresse }}</span>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-4">
                <label for="email" class="form-label">E-mail</label>
                <input
                  class="form-control"
                  type="email"
                  v-model="email"
                  id="email"
                />
                <span class="text-warning">{{ error_email }}</span>
              </div>
              <div class="col-sm-4">
                <label for="date_embauche" class="form-label"
                  >Date Embauche</label
                >
                <input
                  class="form-control"
                  type="date"
                  v-model="date_embauche"
                  id="date_embauche"
                />
              </div>
              <div class="col-sm-4">
                <label class="form-label">Sexe :</label>
                <div class="d-flex">
                  <div class="form-check ml-2">
                    <input
                      value="F"
                      v-model="sexe"
                      name="sexe"
                      type="radio"
                      class="form-check-input"
                      required
                    />
                    <label class="form-check-label" for="credit">F</label>
                  </div>
                  <div class="form-check ml-2">
                    <input
                      value="M"
                      v-model="sexe"
                      name="sexe"
                      type="radio"
                      class="form-check-input"
                      required
                    />
                    <label class="form-check-label" for="debit">M</label>
                  </div>
                  <span class="text-warning">{{ error_sexe }}</span>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-4">
                <label for="type_user" class="form-label">Fonction</label>
                <select class="form-select" v-model="type_user" id="type_user">
                  <option
                    v-for="typeusers in allTypeU"
                    :value="typeusers.id"
                    :key="typeusers.id"
                  >
                    {{ typeusers.libelle }}
                  </option>
                </select>
                <span class="text-warning">{{ error_type_user }}</span>
              </div>
              <div class="col-sm-4">
                <label for="sit_mat" class="form-label"
                  >Situation Matrimoniale</label
                >
                <select class="form-select" v-model="sit_mat" id="sit_mat">
                  <option value="Célibataire">Célibataire</option>
                  <option value="Marié">Marié</option>
                </select>
                <span class="text-warning">{{ error_sit_mat }}</span>
              </div>
              <div class="col-sm-4">
                <label for="image" class="form-label">Image</label>
                <input
                  type="file"
                  class="form-control"
                  @change="onFileChange"
                  id="image"
                />
                <span class="text-warning">{{ error_image }}</span>
              </div>
            </div>
            <div class="row w-100">
              <div class="col text-center">
                <button class="btn btn-success btt">ENREGISTRER</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<style></style>
<script>
export default {
  name: "Creer",
  data() {
    return {
      nom: "",
      prenom: "",
      telephone: "",
      adresse: "",
      type_user: "",
      date_embauche: "",
      sit_mat: "",
      email: "",
      sexe: "",
      service: "",
      allTypeU: [],
      allService: [],
      type_user: null,
      image: null,
      error_nom: "",
      error_prenom: "",
      error_telephone: "",
      error_adresse: "",
      error_type_user: "",
      error_date_embauche: "",
      error_sit_mat: "",
      error_email: "",
      error_sexe: "",
      error_service: "",
    };
  },
  methods: {
    onFileChange(event) {
      this.image = event.target.files[0];
    },
    async fetchTypeU() {
      try {
        const typeuser = await fetch("http://127.0.0.1:8000/api/typeuser/all", {
          method: "GET",
          headers: {
            Authorization: "Bearer " + localStorage.getItem("current_token"),
            "Content-type": "application/json",
          },
        });
        const TypeU = await typeuser.json();
        return TypeU;
      } catch (error) {
        console.error(
          "Erreur lors de la récupération des types d'utilisateurs:",
          error
        );
        return [];
      }
    },

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

    async create(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("image", this.image);
      formData.append("nom", this.nom);
      formData.append("prenom", this.prenom);
      formData.append("telephone", this.telephone);
      formData.append("adresse", this.adresse);
      formData.append("type_user", this.type_user);
      formData.append("date_embauche", this.date_embauche);
      formData.append("sit_mat", this.sit_mat);
      formData.append("email", this.email);
      formData.append("sexe", this.sexe);
      formData.append("service", this.service);
      try {
        const res = await fetch("http://127.0.0.1:8000/api/personnel", {
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

          this.error_nom = error_msg.errors?.nom?.[0] || "";
          this.error_prenom = error_msg.errors?.prenom?.[0] || "";
          this.error_telephone = error_msg.errors?.telephone?.[0] || "";
          this.error_adresse = error_msg.errors?.adresse?.[0] || "";
          this.error_type_user = error_msg.errors?.type_user?.[0] || "";
          this.error_date_embauche = error_msg.errors?.date_embauche?.[0] || "";
          this.error_sit_mat = error_msg.errors?.sit_mat?.[0] || "";
          this.error_email = error_msg.errors?.email?.[0] || "";
          this.error_sexe = error_msg.errors?.sexe?.[0] || "";
          this.error_service = error_msg.errors?.service?.[0] || "";
        } else {
          this.nom = "";
          this.prenom = "";
          this.telephone = "";
          this.adresse = "";
          this.type_user = "";
          this.date_embauche = "";
          this.sit_mat = "";
          this.email = "";
          this.sexe = "";
          this.service = "";

          this.error_nom = "";
          this.error_prenom = "";
          this.error_telephone = "";
          this.error_adresse = "";
          this.error_type_user = "";
          this.error_date_embauche = "";
          this.error_sit_mat = "";
          this.error_email = "";
          this.error_sexe = "";
          this.error_service = "";

          alert("Personnel créé avec succès !");
        }
      } catch (error) {
        console.error("Erreur lors de la création du personnel:", error);
        alert("Une erreur est survenue lors de la création du personnel.");
      }
    },
  },
  async created() {
    try {
      this.allTypeU = await this.fetchTypeU();
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
