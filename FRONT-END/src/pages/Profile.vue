<template>
  <div class="pagetitle">
    <h1>Profile</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/home">Home</router-link>
        </li>
        <li class="breadcrumb-item">Users</li>
        <li class="breadcrumb-item active">Profile</li>
      </ol>
    </nav>
  </div>
  <!-- End Page Title -->

  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">
        <div class="card">
          <div
            class="card-body profile-card pt-4 d-flex flex-column align-items-center"
          >
            <img
              :src="`http://127.0.0.1:8000/upload/profile/${profile}`"
              style="height: 100px; width: 100px"
              alt="Profile"
              class="rounded-circle"
            />
            <h2>{{ this.nom }} {{ this.prenom }}</h2>
            <h3>{{ this.travail }}</h3>
          </div>
        </div>
      </div>

      <div class="col-xl-8">
        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">
              <li class="nav-item">
                <button
                  class="nav-link active"
                  data-bs-toggle="tab"
                  data-bs-target="#profile-overview"
                >
                  Aperçu
                </button>
              </li>

              <li class="nav-item">
                <button
                  class="nav-link"
                  data-bs-toggle="tab"
                  data-bs-target="#profile-edit"
                >
                  Editer le Profile
                </button>
              </li>

              <li class="nav-item">
                <button
                  class="nav-link"
                  data-bs-toggle="tab"
                  data-bs-target="#profile-change-password"
                >
                  Changer le mot de Passe
                </button>
              </li>
            </ul>
            <div class="tab-content pt-2">
              <div
                class="tab-pane fade show active profile-overview"
                id="profile-overview"
              >
                <h5 class="card-title">Profile Details</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Noms Prenoms</div>
                  <div class="col-lg-9 col-md-8">
                    {{ this.nom }} {{ this.prenom }}
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Sexe</div>
                  <div class="col-lg-9 col-md-8">{{ this.sexe }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Travail</div>
                  <div class="col-lg-9 col-md-8">{{ this.travail }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">
                    Situation Matrimoniale
                  </div>
                  <div class="col-lg-9 col-md-8">{{ this.sit_mat }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Adresse</div>
                  <div class="col-lg-9 col-md-8">{{ this.adresse }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Telephone</div>
                  <div class="col-lg-9 col-md-8">{{ this.telephone }}</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8">{{ this.email }}</div>
                </div>
              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                <!-- Profile Edit Form -->
                <form action="" @submit="updateUser">
                  <div class="row mb-3">
                    <label
                      for="profileImage"
                      class="col-md-4 col-lg-3 col-form-label"
                      >Profile Image</label
                    >
                    <div class="col-md-8 col-lg-9">
                      <img
                        :src="`http://127.0.0.1:8000/upload/profile/${this.profile}`"
                        style="height: 100px; width: 100px"
                        alt="Profile"
                      />

                      <div class="mt-2">
                        <div class="col-sm-8 d-flex">
                          <div>
                            <input
                              type="file"
                              class="form-control"
                              @change="onFileChange"
                              id="image"
                            />
                            &nbsp; &nbsp;&nbsp;
                          </div>
                          <div>
                            &nbsp;&nbsp;<input
                              type="checkbox"
                              v-model="supp"
                              class="form-check-input"
                            />
                            &nbsp;
                            <label class="" for="">Supprimer</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label
                      for="fullName"
                      class="col-md-4 col-lg-3 col-form-label"
                      >Nom</label
                    >
                    <div class="col-md-8 col-lg-9">
                      <input
                        name="fullName"
                        type="text"
                        class="form-control"
                        id="fullName"
                        v-model="nom"
                      />
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label
                      for="fullName"
                      class="col-md-4 col-lg-3 col-form-label"
                      >Prénom</label
                    >
                    <div class="col-md-8 col-lg-9">
                      <input
                        name="fullName"
                        type="text"
                        class="form-control"
                        id="fullName"
                        v-model="prenom"
                      />
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Sexe" class="col-md-4 col-lg-3 col-form-label"
                      >Sexe</label
                    >
                    <div class="col-md-8 col-lg-9">
                      <select
                        v-model="sexe"
                        class="form-select form-control"
                        id=""
                      >
                        <option :selected="sexe === M" value="M">
                          Masculin
                        </option>
                        <option :selected="sexe === F" value="F">
                          Feminin
                        </option>
                      </select>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Job" class="col-md-4 col-lg-3 col-form-label"
                      >Situation matrimonial</label
                    >
                    <div class="col-md-8 col-lg-9">
                      <select
                        class="form-select form-control"
                        v-model="sit_mat"
                        id="sit_mat"
                      >
                        <option
                          :selected="sit_mat === Célibataire"
                          value="Célibataire"
                        >
                          Célibataire
                        </option>
                        <option :selected="sit_mat === Marié" value="Marie">
                          Marié
                        </option>
                      </select>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label
                      for="Address"
                      class="col-md-4 col-lg-3 col-form-label"
                      >Address</label
                    >
                    <div class="col-md-8 col-lg-9">
                      <input
                        name="address"
                        type="text"
                        class="form-control"
                        id="Address"
                        v-model="adresse"
                      />
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Phone" class="col-md-4 col-lg-3 col-form-label"
                      >Phone</label
                    >
                    <div class="col-md-8 col-lg-9">
                      <input
                        name="phone"
                        type="text"
                        class="form-control"
                        id="Phone"
                        v-model="telephone"
                      />
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 col-form-label"
                      >Email</label
                    >
                    <div class="col-md-8 col-lg-9">
                      <input
                        name="email"
                        type="email"
                        class="form-control"
                        id="Email"
                        v-model="email"
                      />
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                      Sauvegarder
                    </button>
                  </div>
                </form>
                <!-- End Profile Edit Form -->
              </div>

              <div class="tab-pane fade pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                <form @submit="change">
                  <span style="color: red">{{ error_mess }}</span>
                  <div class="row mb-3">
                    <label
                      for="currentPassword"
                      class="col-md-4 col-lg-3 col-form-label"
                      >Mot de passe actuel</label
                    >
                    <div class="col-md-8 col-lg-9">
                      <input
                        v-model="a_pass"
                        type="password"
                        class="form-control"
                        id="currentPassword"
                      />
                    </div>
                  </div>
                  <span style="color: red">{{ error_a_pass }}</span>

                  <div class="row mb-3">
                    <label
                      for="newPassword"
                      class="col-md-4 col-lg-3 col-form-label"
                      >Nouveau Mot de passe</label
                    >
                    <div class="col-md-8 col-lg-9">
                      <input
                        v-model="n_pass"
                        type="password"
                        class="form-control"
                        id="newPassword"
                      />
                    </div>
                  </div>
                  <span style="color: red">{{ error_n_pass }}</span>

                  <div class="row mb-3">
                    <label
                      for="renewPassword"
                      class="col-md-4 col-lg-3 col-form-label"
                      >Confirmer le Mot de passe</label
                    >
                    <div class="col-md-8 col-lg-9">
                      <input
                        v-model="c_pass"
                        type="password"
                        class="form-control"
                        id="renewPassword"
                      />
                    </div>
                  </div>
                  <span style="color: red">{{ error_c_pass }}</span>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                      Changer
                    </button>
                  </div>
                </form>
                <!-- End Change Password Form -->
              </div>
            </div>
            <!-- End Bordered Tabs -->
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script >
export default {
  name: "Prof",
  data() {
    return {
      current_token: localStorage.getItem("current_token"),
      current_nom: localStorage.getItem("current_nom"),
      current_prenom: localStorage.getItem("current_prenom"),
      current_email: localStorage.getItem("current_email"),
      current_idser: localStorage.getItem("current_idser"),
      current_profil: localStorage.getItem("current_profil"),
      current_role: localStorage.getItem("current_role"),
      current_fonction: localStorage.getItem("current_fonction"),
      UserA: "",
      nom: "",
      prenom: "",
      sexe: "",
      travail: "",
      a_pass: "",
      n_pass: "",
      c_pass: "",
      error_n_pass: "",
      error_c_pass: "",
      error_a_pass: "",
      image: "",
      supp: "",
      error_mess: "",
    };
  },
  methods: {
    onFileChange(event) {
      this.image = event.target.files[0];
    },
    async updateUser(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("image", this.image);
      formData.append("nom", this.nom);
      formData.append("prenom", this.prenom);
      formData.append("telephone", this.telephone);
      formData.append("adresse", this.adresse);
      formData.append("sit_mat", this.sit_mat);
      formData.append("email", this.email);
      formData.append("sexe", this.sexe);
      formData.append("travail", this.travail);
      formData.append("supp", this.supp);

      const res = await fetch(
        "http://127.0.0.1:8000/api/updateuser/" + this.id_user,
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
    async change(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("a_pass", this.a_pass);
      formData.append("n_pass", this.n_pass);
      formData.append("c_pass", this.c_pass);

      const res = await fetch(
        "http://127.0.0.1:8000/api/updatepass/" + this.id_user,
        {
          method: "POST",
          headers: {
            Authorization: "Bearer " + localStorage.getItem("current_token"),
            Accept: "application/json",
          },
          body: formData,
        }
      );

      if (res.status === 422) {
        const error_msg = await res?.json();

        if (
          typeof error_msg.errors.n_pass === "undefined" ||
          error_msg.errors.n_pass === null
        ) {
          this.error_n_pass = "";
        } else {
          this.error_n_pass = error_msg.errors.n_pass[0];
        }
        if (
          typeof error_msg.errors.c_pass === "undefined" ||
          error_msg.errors.c_pass === null
        ) {
          this.error_c_pass = "";
        } else {
          this.error_c_pass = error_msg.errors.c_pass[0];
        }
        if (
          typeof error_msg.errors.a_pass === "undefined" ||
          error_msg.errors.a_pass === null
        ) {
          this.error_a_pass = "";
        } else {
          this.error_a_pass = error_msg.errors.a_pass[0];
        }
      } else {
        if (res.status === 401) {
          const data = await res?.json();
          if (data.messa) {
            this.error_mess = data.messa;
          }
        } else {
          alert("Mot de passe à jour !!!");
          this.error_mess = "";
          location.reload();
        }
      }
    },
    async fetchUser() {
      const user = await fetch(
        "http://127.0.0.1:8000/api/infouser/" +
          localStorage.getItem("current_iduser"),
        {
          method: "GET",
          headers: {
            Authorization: "Bearer " + localStorage.getItem("current_token"),
            "Content-type": "application/json",
          },
        }
      );
      const User = await user.json();
      return User;
      // console.log(User);
    },
  },
  async mounted() {
    this.UserA = await this.fetchUser();
    this.nom = this.UserA.user.nom;
    this.id_user = this.UserA.user.id;
    this.prenom = this.UserA.user.prenom;
    this.sexe = this.UserA.user.sexe;
    this.sit_mat = this.UserA.user.sit_mat;
    this.adresse = this.UserA.user.adresse;
    this.telephone = this.UserA.user.telephone;
    this.profile = this.UserA.user.profil;
    this.email = this.UserA.user.email;
    this.travail = this.UserA.type_user.libelle;
  },
};
</script>