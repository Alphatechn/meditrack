<template>
  <div class="pagetitle">
    <h1>Element</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/home">Home</router-link>
        </li>
        <li class="breadcrumb-item active">Creation Element</li>
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
              <h4 id="mss" class="text-success">Ajouter un Element</h4>
            </div>
          </div>
          <div class="card-body border-0">
            <form @submit="create">
              <div class="row">
                <div class="col-sm-12">
                  <label for="libelle">Libelle</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="libelle"
       
                    id="libelle"
                  />
                  <span style="color: red">{{ error_libelle }}</span>
                </div>

                <div class="col-sm-12">
                  <label for="montant">Montant</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="montant"
               
                    id="libelle"
                  />
                  <span style="color: red">{{ error_montant }}</span>
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
      montant: "",
      error_libelle: "",
      error_montant: "",
    };
  },
  methods: {
    async create(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("libelle", this.libelle);
      formData.append("montant", this.montant);

      try {
        const res = await fetch("http://127.0.0.1:8000/api/element", {
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
          this.error_montant = error_msg.errors?.montant?.[0] || "";
        } else {
          this.libelle = "";
          this.montant = "";

          this.error_libelle = "";
          this.error_montant = "";

          alert("Element créé avec succès !");
        }
      } catch (error) {
        console.error("Erreur lors de la création de l'element:", error);
        alert("Une erreur est survenue lors de la création de l'examen.");
      }
    },
  },
  async created() {},
};
</script>