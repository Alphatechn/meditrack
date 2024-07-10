<template>
  <div>
    <div
      class="modal fade"
      v-bind:id="dd"
      tabindex="-1"
      aria-labelledby="cmModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl">
        <div class="modal-content text-dark">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="cmModalLabel">
              Consulter le patient -- {{ this.nom_p }} {{ this.prenom_p }}
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form action="" @submit="saveData">
            <div class="modal-body">
              <div>
                <label for="motif" class="form-label"
                  ><h3><b>Motif :</b> {{ this.motif }}</h3></label
                >
                <input type="hidden" v-model="id_transfert" />
                <input type="hidden" v-model="id_patient" />
              </div>
              <div class="col-sm-8 d-flex">
                <div class="col-sm-4">Age : {{ ages }} ans</div>
                <div class="col-sm-8">Date de Naissance : {{ dates }}</div>
              </div>
              <hr style="color: green; border: 3px solid green" />
              <div class="row">
                <div class="col-sm-3">
                  <label for="date">Mouvement</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="date"
                    id="date"
                  />
                  <span style="color: red">{{ error_date }}</span>
                </div>
                <div class="col-sm-3">
                  <label for="temperature">Temperature</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="temperature"
                    id="temperature"
                  />
                  <span style="color: red">{{ error_temperature }}</span>
                </div>
                <div class="col-sm-3">
                  <label for="poids">Poids</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="poids"
                    id="poids"
                  />
                  <span style="color: red">{{ error_poids }}</span>
                </div>

                <div class="col-sm-3">
                  <label for="taille">Taille</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="taille"
                    id="taille"
                  />
                  <span style="color: red">{{ error_taille }}</span>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3">
                  <label for="oedeme">Oedemes</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="oedeme"
                    id="oedeme"
                  />
                  <span style="color: red">{{ error_oedemes }}</span>
                </div>
                <div class="col-sm-3">
                  <label for="p">P</label>
                  <input class="form-control" type="text" v-model="p" id="p" />
                  <span style="color: red">{{ error_p }}</span>
                </div>
                <div class="col-sm-3">
                  <label for="obst">OBST</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="obst"
                    id="obst"
                  />
                  <span style="color: red">{{ error_obst }}</span>
                </div>
                <div class="col-sm-3">
                  <label for="bassin">Bassin</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="bassin"
                    id="bassin"
                  />
                  <span style="color: red">{{ error_bassin }}</span>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3">
                  <label for="ddr">DDR</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="ddr"
                    id="ddr"
                  />
                  <span style="color: red">{{ error_ddr }}</span>
                </div>
                <div class="col-sm-3">
                  <label for="dpa">DPA</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="dpa"
                    id="dpa"
                  />
                  <span style="color: red">{{ error_dpa }}</span>
                </div>
                <div class="col-sm-3">
                  <label for="albu">Albumine</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="albu"
                    id="albu"
                  />
                  <span style="color: red">{{ error_albu }}</span>
                </div>
                <div class="col-sm-3">
                  <label for="sucre">Sucre</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="sucre"
                    id="sucre"
                  />
                  <span style="color: red">{{ error_sucre }}</span>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-3">
                  <label for="ta">TA</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="ta"
                    id="ta"
                  />
                  <span style="color: red">{{ error_ta }}</span>
                </div>
                <div class="col-sm-3">
                  <label for="gs">GS</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="gs"
                    id="gs"
                  />
                  <span style="color: red">{{ error_gs }}</span>
                </div>
                <div class="col-sm-3">
                  <label for="rhe">Rhesus</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="rhe"
                    id="rhe"
                  />
                  <span style="color: red">{{ error_rhe }}</span>
                </div>
                <div class="col-sm-3">
                  <label for="rendez"> Date rendez-vous </label>
                  <input
                    class="form-control"
                    type="date"
                    v-model="rendez"
                    id="rendez"
                  />
                  <span style="color: red">{{ error_rendez }}</span>
                </div>
                <div class="col-sm-12">
                  <input
                    class="form-control"
                    type="hidden"
                    v-model="type"
                    values="consultation prenatale"
                    id="type"
                  />
                  <span style="color: red">{{ error_type }}</span>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <label for="diagnos">Diagnostique</label>
                  <textarea
                    class="form-control"
                    v-model="diagnos"
                    id="diagnos"
                  ></textarea>
                  <span style="color: red">{{ error_diagnos }}</span>
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
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Soumettre</button>
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

<script >
export default {
  name: "consultation Maternite",
  props: {
    transfert: Object,
  },
  data() {
    return {
      dd: "consmModal" + this.transfert.id_transfert,
      ages: "",
      dates: "",
      nom_p: this.transfert.nom,
      prenom_p: this.transfert.prenom,
      motif: this.transfert.motif,
      id_transfert: this.transfert.id_transfert,
      id_patient: this.transfert.id_pat,
    };
  },
  async created() {
    var dateA = new Date();
    var dateBD = new Date(this.transfert.date_naissance);
    var diffM = dateA - dateBD;
    var diffA = diffM / (1000 * 60 * 60 * 24 * 365.25);
    var age = Math.floor(diffA);
    this.ages = age;
    this.showResults = false;
    var dateBaseDeDonnees = this.transfert.date_naissance;
    // Séparation de la chaîne de caractères en trois parties : année, mois et jour
    var partiesDate = dateBaseDeDonnees.split("-");
    var annee = partiesDate[0];
    var mois = partiesDate[1];
    var jour = partiesDate[2];

    // Création de la nouvelle chaîne de caractères dans le format désiré : "jour-mois-année"
    var formatReformate = jour + "-" + mois + "-" + annee;
    this.dates = formatReformate;
  },

  methods: {
    async saveData(e) {
      e.preventDefault();
      try {
        const response = await fetch("http://127.0.0.1:8000/api/caisse", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            items: this.items,
            taskName: this.taskName,
            prix: this.someAmount,
            verser: this.mverse,
            lettre: this.mlettre,
            reste: this.mreste,
            id_pat: this.id_patient,
            id_transfert: this.id_transfert,
            id_pers: localStorage.getItem("current_idper"),
          }),
        });
        if (response.ok) {
          console.log("Data saved successfully");
          location.reload();
        } else {
          console.error("Error saving data");
        }
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>
<style scoped>
.autocomplete-list {
  list-style-type: none;
  padding: 0;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  background-color: white;
  position: absolute;
  z-index: 1;
}

.autocomplete-list li {
  padding: 8px 12px;
  cursor: pointer;
}

.autocomplete-list li:hover {
  background-color: #f1f1f1;
}
</style>