<template>
  <div class="pagetitle">
    <h1>Examen</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/home">Home</router-link>
        </li>
        <li class="breadcrumb-item active">Creation Examen</li>
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
              <h4 id="mss" class="text-success">Ajouter un Examen</h4>
            </div>
          </div>
          <div class="card-body border-0">
            <form @submit="create">
              <div class="row">
                <div class="col-sm-12">
                  <label for="libelle">Examen</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="libelle"
       
                    id="libelle"
                  />
                  <span style="color: red">{{ error_libelle }}</span>
                </div>

                <div class="col-sm-12">
                  <label for="prix_examen">Montant</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="prix_examen"
               
                    id="libelle"
                  />
                  <span style="color: red">{{ error_prix_examen }}</span>
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
      libelle: "",
      prix_examen: "",
      error_libelle: "",
      error_prix_examen: "",
    };
  },
  methods: {
    async create(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("libelle", this.libelle);
      formData.append("prix_examen", this.prix_examen);

      try {
        const res = await fetch("http://127.0.0.1:8000/api/examen", {
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

          this.error_libelle = error_msg.errors?.libelle?.[0] || "";
          this.error_prix_examen = error_msg.errors?.prix_examen?.[0] || "";
        } else {
          this.libelle = "";
          this.prix_examen = "";

          this.error_libelle = "";
          this.error_prix_examen = "";

          alert("Examen créé avec succès !");
        }
      } catch (error) {
        console.error("Erreur lors de la création de l'examen:", error);
        alert("Une erreur est survenue lors de la création de l'examen.");
      }
    },
  },
  async created() {},
};
</script>