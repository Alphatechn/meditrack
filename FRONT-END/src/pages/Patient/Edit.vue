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
              Edit patient --{{ patient_nom }} {{ patient_prenom }}
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
              <div class="row justify-content-center">
                <div class="col-sm-4 mb-3">
                  <label for="nom" class="form-label">Nom</label>
                  <input
                    type="text"
                    v-model="patient_nom"
                    class="form-control"
                    id="nom"
                    placeholder="patient name..."
                  />
                </div>
                <div class="col-sm-4 mb-3">
                  <label for="prenom" class="form-label">Prenom</label>
                  <input
                    type="text"
                    v-model="patient_prenom"
                    class="form-control"
                    id="prenom"
                    placeholder="patient slug..."
                  />
                </div>
                <div class="col-sm-4 mb-3">
                  <label for="telephone" class="form-label">Telephone</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="patient_telephone"
                    id="telephone"
                    placeholder="patient desc..."
                  />
                </div>
                <div class="col-sm-4 mb-3">
                  <label for="contact_urgent" class="form-label"
                    >Contact Urgent</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    v-model="patient_contact_urgent"
                    id="contact_urgent"
                    placeholder="patient desc..."
                  />
                </div>
                <div class="col-sm-4 mb-3">
                  <label for="patient_adresse" class="form-label"
                    >Adresse</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    v-model="patient_adresse"
                    id="desc"
                    placeholder=" patient_adresse..."
                  />
                </div>
                <div class="col-sm-4 mb-3">
                  <label for="date_em" class="form-label"
                    >Date de Naissance</label
                  >
                  <input
                    type="date"
                    v-model="patient_date_naissance"
                    class="form-control"
                    id="date_em"
                    placeholder="patient price..."
                  />
                </div>
                <div class="col-sm-4 mb-3">
                  <label for="lieu" class="form-label">Lieu de naissance</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="patient_lieu"
                    id="desc"
                    placeholder="patient author..."
                  />
                </div>
                <div class="col-sm-4 mb-3">
                  <label for="profession" class="form-label">Profession</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="patient_profession"
                    id="desc"
                    placeholder="patient author..."
                  />
                </div>
                <div class="col-sm-4 mb-3">
                  <label for="grp_san" class="form-label">Groupe Sanguin</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="patient_grp_san"
                    id="desc"
                    placeholder="patient author..."
                  />
                </div>
                <div class="col-sm-4 mb-3">
                  <label for="nom_pere" class="form-label">Nom du Pere</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="patient_nom_pere"
                    id="desc"
                    placeholder="patient author..."
                  />
                </div>
                <div class="col-sm-4 mb-3">
                  <label for="nom_mere" class="form-label"
                    >Nom de la mere</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    v-model="patient_nom_mere"
                    id="desc"
                    placeholder="patient author..."
                  />
                </div>
                <div class="col-sm-4 mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="email"
                    v-model="patient_email"
                    class="form-control"
                    id="email"
                    placeholder="patient email..."
                  />
                </div>
                <div class="col-sm-4 mb-3">
                  <label for="sexe">Sexe</label>
                  <select v-model="patient_sexe" class="form-control" id="">
                    <option :selected="patient_sexe === M" value="M">
                      Masculin
                    </option>
                    <option :selected="patient_sexe === F" value="F">
                      Feminin
                    </option>
                  </select>
                </div>
                <div class="col-sm-4 mb-3">
                  <label for="sit_mat">Situation Matrimoniale</label>
                  <select
                    class="form-select form-control"
                    v-model="patient_sit_mat"
                    id="sit_mat"
                  >
                    <option
                      :selected="patient_sit_mat === Célibataire"
                      value="Célibataire"
                    >
                      Célibataire
                    </option>
                    <option :selected="patient_sit_mat === Marié" value="Marie">
                      Marié
                    </option>
                  </select>
                </div>
                <div class="row">
                  <div class="col-sm-8">
                    <label for="image">Image</label>
                    <input
                      type="file"
                      class="form-control"
                      @change="onFileChange"
                      id="image"
                    />
                    <span style="color: yellow">{{ error_image }}</span>
                  </div>
                  <div class="col-sm-4 mt-4 text-center">
                    <img
                      :src="`http://127.0.0.1:8000/upload/profile/${patient_profil}`"
                      alt=""
                      style="width: 50px; height: 50px"
                    />
                  </div>
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
      dd: "editModal" + this.patient.id_patient,
      patient_id: this.patient.id_patient,
      patient_nom: this.patient.nom,
      patient_prenom: this.patient.prenom,
      patient_telephone: this.patient.telephone,
      patient_adresse: this.patient.adresse,
      patient_date_naissance: this.patient.date_naissance,
      patient_email: this.patient.email,
      patient_sexe: this.patient.sexe,
      patient_sit_mat: this.patient.sit_mat,
      patient_lieu: this.patient.lieu,
      patient_contact_urgent: this.patient.contact_urgent,
      patient_profil: this.patient.profil,
      patient_profession: this.patient.profession,
      patient_grp_san: this.patient.grp_san,
      patient_nom_pere: this.patient.nom_p,
      patient_nom_mere: this.patient.nom_m,
      image: null,
    };
  },
  methods: {
    onFileChange(event) {
      this.image = event.target.files[0];
    },
    async updatePatient(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("image", this.image);
      formData.append("nom", this.patient_nom);
      formData.append("prenom", this.patient_prenom);
      formData.append("telephone", this.patient_telephone);
      formData.append("adresse", this.patient_adresse);
      formData.append("date_naissance", this.patient_date_naissance);
      formData.append("sit_mat", this.patient_sit_mat);
      formData.append("email", this.patient_email);
      formData.append("sexe", this.patient_sexe);
      formData.append("contact_urgent", this.patient_contact_urgent);
      formData.append("lieu", this.patient_lieu);
      formData.append("profession", this.patient_profession);
      formData.append("nom_p", this.patient_nom_pere);
      formData.append("nom_m", this.patient_nom_mere);
      formData.append("grp_san", this.patient_grp_san);

      const res = await fetch(
        "http://127.0.0.1:8000/api/patient/" + this.patient.id_patient,
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
