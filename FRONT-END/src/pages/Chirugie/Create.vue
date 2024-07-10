<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-4 bg-primary">
          <h1 class="m-0">CONSULTATION</h1>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="card bg-white border-0">
        <div class="col-lg-12 col-md-12">
          <div class="card-header border-0 bg-white">
            <div class="row">
              <h4 id="mss">Ajouter une consultation</h4>
            </div>
          </div>
          <div class="card-body border-0">
            <form @submit="create">
              <div class="row">
                <div class="col-sm-4">
                  <input
                    class="form-control"
                    placeholder="Rechercher Patient"
                    v-model="searchQuery"
                    @input="handleInput"
                  />
                  <ul v-if="showResults" class="list-unstyled">
                    <li
                      v-for="result in results"
                      :key="result.id"
                      @click="selectResult(result)"
                      class="text-dark list-item alert-info text-center"
                    >
                      {{ result.nom }} {{ result.prenom }}
                    </li>
                  </ul>
                </div>
                <div class="col-sm-8 d-flex" v-if="selectedResult">
                  <div class="col-sm-4">Age : {{ ages }} ans</div>
                  <div class="col-sm-8">Date de Naissance : {{ dates }}</div>
                </div>
              </div>
              <hr style="color: green; border: 3px solid green" />
              <div class="row">
                <div class="col-sm-4">
                  <label for="temperature">Temperature</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="temperature"
                    placeholder="Temperature"
                    id="temperature"
                  />
                  <span style="color: red">{{ error_temperature }}</span>
                </div>
                <div class="col-sm-4">
                  <label for="poids">Poids</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="poids"
                    placeholder="Poids"
                    id="poids"
                  />
                  <span style="color: red">{{ error_poids }}</span>
                </div>
                <div class="col-sm-4">
                  <label for="taille">Taille</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="taille"
                    placeholder="Taille"
                    id="taille"
                  />
                  <span style="color: red">{{ error_taille }}</span>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <label for="symptome">Symptomes</label>
                  <textarea
                    class="form-control"
                    v-model="symptome"
                    id=""
                  ></textarea>
                  <span style="color: red">{{ error_symptome }}</span>
                </div>
                <div class="col-sm-12">
                  <label for="diagnostique">Diagnostique</label>
                  <textarea
                    class="form-control"
                    v-model="diagnostique"
                    id=""
                  ></textarea>
                  <span style="color: red">{{ error_diagnostique }}</span>
                </div>
                <div class="col-sm-12">
                  <label for="examr">Examens Recommandes</label>
                  <textarea
                    class="form-control"
                    v-model="examr"
                    id=""
                  ></textarea>
                  <span style="color: red">{{ error_examr }}</span>
                </div>
              </div>
              <br />

              <div class="row w-100">
                <button type="submit" class="btn btn-success btt">
                  <small>AJOUTER</small>
                </button>
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
  data() {
    return {
      searchQuery: "",
      ages: "",
      dates: "",
      results: [],
      showResults: false,
      selectedResult: null,
    };
  },
  methods: {
    async handleInput() {
      if (this.searchQuery.length > 0) {
        try {
          const response = await fetch(
            "http://127.0.0.1:8000/api/transfert/search/" +
              localStorage.getItem("current_idser") +
              "/" +
              this.searchQuery,
            {
              method: "GET",
              headers: {
                Authorization:
                  "Bearer " + localStorage.getItem("current_token"),
                "Content-type": "application/json",
              },
            }
          );
          if (response.ok) {
            const data = await response.json();
            this.results = data;
            this.showResults = true;
            // console.log(data);
          }
        } catch (error) {
          console.error(
            "Une erreur s'est produite lors de la recherche :",
            error
          );
        }
      } else {
        this.showResults = false;
      }
    },
    selectResult(result) {
      this.selectedResult = result;
      this.searchQuery = result.nom + " " + result.prenom;
      var dateA = new Date();
      var dateBD = new Date(result.date_naissance);
      var diffM = dateA - dateBD;
      var diffA = diffM / (1000 * 60 * 60 * 24 * 365.25);
      var age = Math.floor(diffA);
      this.ages = age;
      this.showResults = false;
      var dateBaseDeDonnees = result.date_naissance;
      // Séparation de la chaîne de caractères en trois parties : année, mois et jour
      var partiesDate = dateBaseDeDonnees.split("-");
      var annee = partiesDate[0];
      var mois = partiesDate[1];
      var jour = partiesDate[2];

      // Création de la nouvelle chaîne de caractères dans le format désiré : "jour-mois-année"
      var formatReformate = jour + "-" + mois + "-" + annee;
      this.dates = formatReformate;
    },
  },
};
</script>