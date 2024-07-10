<template>
  <div class="pagetitle">
    <h1>Patient</h1>
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
            <h4 id="mss" class="text-success">Enregistrer un patient</h4>
          </div>
        </div>
        <div class="card-body border-0">
          <form @submit="create">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button
                  class="nav-link active"
                  id="page1-tab"
                  data-bs-toggle="tab"
                  data-bs-target="#page1"
                  type="button"
                  role="tab"
                  aria-controls="page1"
                  aria-selected="true"
                >
                  Informations Personnel
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button
                  class="nav-link"
                  id="page2-tab"
                  data-bs-toggle="tab"
                  data-bs-target="#page2"
                  type="button"
                  role="tab"
                  aria-controls="page2"
                  aria-selected="false"
                >
                  Antécédents & Groupe sanguin
                </button>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div
                class="tab-pane fade show active"
                id="page1"
                role="tabpanel"
                aria-labelledby="page1-tab"
              >
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
                    <label for="telephone" class="form-label">Telephone</label>
                    <input
                      class="form-control"
                      type="tel"
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
                  <div class="col-sm-4">
                    <label for="contact_urgent" class="form-label"
                      >Contact Urgent</label
                    >
                    <input
                      class="form-control"
                      type="tel"
                      v-model="contact_urgent"
                      id="contact_urgent"
                    />
                    <span class="text-warning">{{ error_contact_urgent }}</span>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-sm-4">
                    <label class="form-label">Sexe :</label>
                    <div class="d-flex">
                      <div class="form-check ml-2">
                        <input
                          value="F"
                          v-model="sexe"
                          id="sexeF"
                          name="sexe"
                          type="radio"
                          class="form-check-input"
                        />
                        <label class="form-check-label" for="sexeF">F</label>
                      </div>
                      <div class="form-check ml-2">
                        <input
                          value="M"
                          v-model="sexe"
                          id="sexeM"
                          name="sexe"
                          type="radio"
                          class="form-check-input"
                        />
                        <label class="form-check-label" for="sexeM">M</label>
                      </div>
                      <span class="text-warning">{{ error_sexe }}</span>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <label for="date_naissance" class="form-label"
                      >Date De Naissance</label
                    >
                    <input
                      class="form-control"
                      type="date"
                      v-model="date_naissance"
                      id="date_naissance"
                    />
                  </div>
                  <div class="col-sm-4">
                    <label for="lieu" class="form-label"
                      >Lieu de naissance</label
                    >
                    <input
                      class="form-control"
                      type="text"
                      v-model="lieu"
                      id="lieu"
                    />
                    <span class="text-warning">{{ error_lieu }}</span>
                  </div>
                </div>
                <div class="row mb-3">
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
                <div class="row mb-3">
                  <div class="col-sm-4">
                    <label for="nom_pere" class="form-label">Nom du père</label>
                    <input
                      class="form-control"
                      type="text"
                      v-model="nom_pere"
                      id="nom_pere"
                    />
                  </div>
                  <div class="col-sm-4">
                    <label for="nom_mere" class="form-label"
                      >Nom de la mère</label
                    >
                    <input
                      class="form-control"
                      type="text"
                      v-model="nom_mere"
                      id="nom_mere"
                    />
                  </div>
                  <div class="col-sm-4">
                    <label for="profession" class="form-label"
                      >Profession</label
                    >
                    <input
                      class="form-control"
                      type="text"
                      v-model="profession"
                      id="profession"
                    />
                  </div>
                </div>
              </div>
              <div
                class="tab-pane fade"
                id="page2"
                role="tabpanel"
                aria-labelledby="page2-tab"
              >
                <div class="row mb-3 justify-content-center">
                  <div class="col-sm-4">
                    <label for="grp_san" class="form-label"
                      >Groupe Sanguin</label
                    >
                    <input
                      class="form-control"
                      type="text"
                      v-model="grp_san"
                      id="grp_san" required
                    />
                  </div>
                  <div class="col-sm-4">
                    <label for="a_medi" class="form-label">A Medicaux </label>
                    <input
                      class="form-control"
                      type="text"
                      v-model="a_medi"
                      id="a_medi"
                    />
                  </div>
                  <div class="col-sm-4">
                    <label for="a_chiru" class="form-label"
                      >A Chirurgicaux</label
                    >
                    <input
                      class="form-control"
                      type="text"
                      v-model="a_chiru"
                      id="a_chiru"
                    />
                  </div>
                  <div class="col-sm-4">
                    <label for="a_gyneco" class="form-label"
                      >A Gyneco-obst</label
                    >
                    <input
                      class="form-control"
                      type="text"
                      v-model="a_gyneco"
                      id="a_gyneco"
                    />
                  </div>
                  <div class="col-sm-4">
                    <label for="a_immu" class="form-label">A Immunologie</label>
                    <input
                      class="form-control"
                      type="text"
                      v-model="a_immu"
                      id="a_immu"
                    />
                  </div>
                  <div class="col-sm-4">
                    <label for="a_aller" class="form-label">A Allergique</label>
                    <input
                      class="form-control"
                      type="text"
                      v-model="a_aller"
                      id="a_aller"
                    />
                  </div>
                  <div class="col-sm-4">
                    <label for="a_autres" class="form-label">A Autres</label>
                    <input
                      class="form-control"
                      type="text"
                      v-model="a_autres"
                      id="a_autres"
                    />
                  </div>
                </div>
              </div>
            </div>
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
</template>

<script>
export default {
  name: "Creer",
  data() {
    return {
      nom: "",
      prenom: "",
      telephone: "",
      adresse: "",
      contact_urgent: "",
      date_naissance: "",
      sit_mat: "",
      email: "",
      sexe: "",
      lieu: "",
      nom_pere:'',
      nom_mere:'',
      profession:'',
      grp_san:'',
      a_medi:'',
      a_chiru:'',
      a_immu:'',
      a_aller:'',
      a_gyneco:'',
      a_autres:'',
      image: null,
      error_nom: "",
      error_prenom: "",
      error_telephone: "",
      error_adresse: "",
      error_date_naissance: "",
      error_sit_mat: "",
      error_email: "",
      error_sexe: "",
      error_contact_urgent: "",
      error_lieu: "",
    };
  },
  methods: {
    onFileChange(event) {
      this.image = event.target.files[0];
    },
    async create(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("image", this.image);
      formData.append("nom", this.nom);
      formData.append("prenom", this.prenom);
      formData.append("telephone", this.telephone);
      formData.append("adresse", this.adresse);
      formData.append("contact_urgent", this.contact_urgent);
      formData.append("date_naissance", this.date_naissance);
      formData.append("sit_mat", this.sit_mat);
      formData.append("email", this.email);
      formData.append("sexe", this.sexe);
      formData.append("lieu", this.lieu);
      formData.append("nom_pere", this.nom_pere);
      formData.append("nom_mere", this.nom_mere);
      formData.append("grp_san", this.grp_san);
      formData.append("profession", this.profession);
      formData.append("a_chiru", this.a_chiru);
      formData.append("a_medi", this.a_medi);
      formData.append("a_gyneco", this.a_gyneco);
      formData.append("a_immu", this.a_immu);
      formData.append("a_aller", this.a_aller);
      formData.append("a_autres", this.a_autres);

      try {
        const res = await fetch("http://127.0.0.1:8000/api/patient", {
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
          this.error_contact_urgent =
            error_msg.errors?.contact_urgent?.[0] || "";
          this.error_date_naissance =
            error_msg.errors?.date_naissance?.[0] || "";
          this.error_sit_mat = error_msg.errors?.sit_mat?.[0] || "";
          this.error_email = error_msg.errors?.email?.[0] || "";
          this.error_sexe = error_msg.errors?.sexe?.[0] || "";
          this.error_lieu = error_msg.errors?.lieu?.[0] || "";
        } else {
          this.nom = "";
          this.prenom = "";
          this.telephone = "";
          this.adresse = "";
          this.contact_urgent = "";
          this.date_naissance = "";
          this.sit_mat = "";
          this.email = "";
          this.sexe = "";
          this.lieu = "";

          this.error_nom = "";
          this.error_prenom = "";
          this.error_telephone = "";
          this.error_adresse = "";
          this.error_contact_urgent = "";
          this.error_date_naissance = "";
          this.error_sit_mat = "";
          this.error_email = "";
          this.error_sexe = "";
          this.error_lieu = "";

          alert("Patient créé avec succès !");
        }
      } catch (error) {
        console.error("Erreur lors de la création du patient:", error);
        alert("Une erreur est survenue lors de la création du patient.");
      }
    },
  },
  async created() {},
};
</script>
