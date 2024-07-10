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
              Edit personnel --{{ personnel_nom }} {{ personnel_prenom }}
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form action="" @submit="updatePersonnel">
            <div class="modal-body">
              <div>
                <label for="nom" class="form-label">Nom</label>
                <input
                  type="text"
                  v-model="personnel_nom"
                  class="form-control"
                  id="nom"
                  placeholder="personnel name..."
                />
              </div>
              <div>
                <label for="prenom" class="form-label">Prenom</label>
                <input
                  type="text"
                  v-model="personnel_prenom"
                  class="form-control"
                  id="prenom"
                  placeholder="personnel slug..."
                />
              </div>
              <div>
                <label for="telephone" class="form-label">Telephone</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="personnel_telephone"
                  id="telephone"
                  placeholder="personnel desc..."
                />
              </div>
              <div>
                <label for="author" class="form-label">Adresse</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="personnel_adresse"
                  id="desc"
                  placeholder="personnel author..."
                />
              </div>
              <div>
                <label for="date_em" class="form-label">Date Embauche</label>
                <input
                  type="date"
                  v-model="personnel_date_embauche"
                  class="form-control"
                  id="date_em"
                  placeholder="personnel price..."
                />
              </div>
              <div>
                <label for="email" class="form-label">Email</label>
                <input
                  type="email"
                  v-model="personnel_email"
                  class="form-control"
                  id="email"
                  placeholder="personnel price..."
                />
              </div>
              <div>
                <label for="sexe">Sexe</label>
                <select v-model="personnel_sexe" class="form-control" id="">
                  <option :selected="personnel_sexe === M" value="M">
                    Masculin
                  </option>
                  <option :selected="personnel_sexe === F" value="F">
                    Feminin
                  </option>
                </select>
              </div>
              <div>
                <label for="sit_mat">Situation Matrimoniale</label>
                <select
                  class="form-select form-control"
                  v-model="personnel_sit_mat"
                  id="sit_mat"
                >
                  <option
                    :selected="personnel_sit_mat === Célibataire"
                    value="Célibataire"
                  >
                    Célibataire
                  </option>
                  <option :selected="personnel_sit_mat === Marié" value="Marie">
                    Marié
                  </option>
                </select>
              </div>
              <div>
                <label for="type_user">Fonction</label>
                <select
                  class="form-select"
                  v-model="personnel_id_type_user"
                  id="type_user"
                >
                  <option
                    v-for="typeusers in allTypeU"
                    :value="typeusers.id"
                    :key="typeusers.id"
                    :selected="personnel_id_type_user === typeusers.id"
                  >
                    {{ typeusers.libelle }}
                  </option>
                </select>
                <span style="color: yellow">{{ error_type_user }}</span>
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
                    :src="`http://127.0.0.1:8000/upload/profile/${personnel_profil}`"
                    alt=""
                    style="width: 50px; height: 50px"
                  />
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">
                ENREGISTRER
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
    personnel: Object,
  },
  data() {
    return {
      dd: "editModal" + this.personnel.id_personnel,
      personnel_id: this.personnel.id_personnel,
      personnel_nom: this.personnel.nom,
      personnel_prenom: this.personnel.prenom,
      personnel_telephone: this.personnel.telephone,
      personnel_adresse: this.personnel.adresse,
      personnel_date_embauche: this.personnel.date_embauche,
      personnel_email: this.personnel.email,
      personnel_sexe: this.personnel.sexe,
      personnel_sit_mat: this.personnel.sit_mat,
      personnel_id_type_user: this.personnel.id_type_user,
      personnel_profil: this.personnel.profil,
      allTypeU: [],
      type_user: null,
      image: null,
    };
  },
  methods: {
    async fetchTypeU() {
      const typeuser = await fetch("http://127.0.0.1:8000/api/typeuser/all", {
        method: "GET",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("current_token"),
          "Content-type": "application/json",
        },
      });
      const TypeU = await typeuser.json();
      return TypeU;
    },

    onFileChange(event) {
      this.image = event.target.files[0];
    },

    async updatePersonnel(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("image", this.image);
      formData.append("nom", this.personnel_nom);
      formData.append("prenom", this.personnel_prenom);
      formData.append("telephone", this.personnel_telephone);
      formData.append("adresse", this.personnel_adresse);
      formData.append("date_embauche", this.personnel_date_embauche);
      formData.append("sit_mat", this.personnel_sit_mat);
      formData.append("email", this.personnel_email);
      formData.append("sexe", this.personnel_sexe);
      formData.append("type_user", this.personnel_id_type_user);

      const res = await fetch(
        "http://127.0.0.1:8000/api/personnel/" + this.personnel.id_personnel,
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
    this.allTypeU = await this.fetchTypeU();
  },
};
</script>