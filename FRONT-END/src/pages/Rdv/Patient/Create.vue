<template>
  <div class="pagetitle">
    <h1>Rendez-Vous</h1>
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
      <div class="card bg-white border-0">
        <div class="col-lg-12 col-md-12">
          <div class="card-header border-0 bg-white">
            <div class="row">
              <h4 id="mss" class="text-success">Demander un Rendez-Vous</h4>
            </div>
          </div>
          <div class="card-body border-0">
            <form @submit="create">
              <div class="row justify-content-center">
                <div class="col-sm-6 mb-3">
                  <label for="date_r">Date Rendez-Vous</label>
                  <input
                    class="form-control"
                    type="date"
                    v-model="date_r"
       
                    id="date_r"
                  />
                  <span style="color: red">{{ error_date_r }}</span>
                </div>

                <div class="col-sm-6 mb-3">
                  <label for="motif_r">Motif</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="motif_r"
               
                    id="date_r"
                  />
                  <span style="color: red">{{ error_motif_r }}</span>
                </div>
                <div class="col-sm-6 mb-3">
                  <label for="note_r">Notes</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="note_r"
               
                    id="date_r"
                  />
                  
                  <span style="color: red">{{ error_note_r }}</span>
                </div>
                <div class="col-sm-6 mb-3">
                  <label for="medecin_r">Medecin</label>
                  <select v-model="medecin_r" class="form-control" id="">
                    <option
                    v-for="med in allMed"
                    :value="med.id_personnel"
                    :key="med.id_personnel"
                    >
                      {{ med.nom }} {{ med.prenom }}
                    </option>
                  </select>
                  <span style="color: red">{{ error_medicin_r }}</span>
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
 <style>
</style>
 <script>
export default {
  name: "Creer",
  data() {
    return {
      allMed: [],
      date_r: "",
      motif_r: "",
      note_r: "",
      medecin_r: "",
      idpat: localStorage.getItem("current_idpat"),
      error_date_r: "",
      error_motif_r: "",
      error_note_r: "",
      error_medicin_r: "",
    };
  },
  methods: {
    async fetchMed() {
      try {
        const med = await fetch("http://127.0.0.1:8000/api/medecin/"+ localStorage.getItem("current_idpat"), {
          method: "GET",
          headers: {
            Authorization: "Bearer " + localStorage.getItem("current_token"),
            "Content-type": "application/json",
          },
        });
        const Med = await med.json();
        return Med;
      } catch (error) {
        console.error(
          "Erreur lors de la récupération des types d'utilisateurs:",
          error
        );
        return [];
      }
    },

    async create(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("date_r", this.date_r);
      formData.append("motif_r", this.motif_r);
      formData.append("note_r", this.note_r);
      formData.append("medecin_r", this.medecin_r);
      formData.append("idpat", this.idpat);

      try {
        const res = await fetch("http://127.0.0.1:8000/api/rdvstore", {
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

          this.error_date_r = error_msg.errors?.date_r?.[0] || "";
          this.error_motif_r = error_msg.errors?.motif_r?.[0] || "";
          this.error_note_r = error_msg.errors?.note_r?.[0] || "";
        } else {
          this.date_r = "";
          this.motif_r = "";
          this.note_r = "";

          this.error_date_r = "";
          this.error_motif_r = "";

          alert("Rendez-vous créé avec succès !");
        }
      } catch (error) {
        console.error("Erreur lors de la création de l'examen:", error);
        alert("Une erreur est survenue lors de la création de l'examen.");
      }
    },
  },
  async created() {
    this.allMed = await this.fetchMed();
  },
};
</script>