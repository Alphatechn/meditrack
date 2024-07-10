<template>
  <div>
    <div
      class="modal fade"
      v-bind:id="dd"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl">
        <div class="modal-content text-dark">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">
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
              <div class="row">
                <center><h4>ANTECEDENTS</h4></center>
                <div class="col-sm-6 mb-2">
                  <label for=""> <b>Medicaux:</b> {{ ante.medi }}</label>
                </div>
                <div class="col-sm-6 mb-2">
                  <label for=""> <b>Chirurgicaux:</b> {{ ante.chiru }}</label>
                </div>
                <div class="col-sm-6 mb-2">
                  <label for=""> <b>Gyneco-Obst:</b> {{ ante.gyneco }}</label>
                </div>
                <div class="col-sm-6 mb-2">
                  <label for=""> <b>Immunologie:</b> {{ ante.immu }}</label>
                </div>
                <div class="col-sm-6 mb-2">
                  <label for=""> <b>Allergiques:</b> {{ ante.aller }}</label>
                </div>
                <div class="col-sm-6 mb-2">
                  <label for=""> <b>Autres:</b> {{ ante.autres }}</label>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <input type="hidden" v-model="id_consultation" />
                  <input type="hidden" v-model="id_patient" />
                  Type Consultation<input
                    class="form-control"
                    type="text"
                    v-model="type_cons"
                    placeholder=" Type Consultation...."
                    id="type_cons"
                  />
                </div>
              </div>
              <div class="col-sm-8 d-flex">
                <div class="col-sm-4">Age : {{ ages }} ans</div>
                <div class="col-sm-8">Date de Naissance : {{ dates }}</div>
              </div>
              <hr style="color: green; border: 3px solid green" />
              <div class="row">
                <div class="col-sm-4">
                  <label for="temperature">Temperature</label>
                  <input
                    class="form-control"
                    type="text"
                    v-model="temperature"
                    placeholder=""
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
                    placeholder=""
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
                    placeholder=""
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
                <!-- <div class="col-sm-12">

                        </div> -->

                <!-- Affichage des divs en fonction de la sélection -->
                <div
                  class="col-sm-12"
                  v-if="
                    selectedAffichage != 'ok' || selectedAffichage === 'both'
                  "
                >
                  <label for="examr">Examens Recommandes</label>
                  <textarea
                    class="form-control"
                    v-model="examr"
                    id=""
                  ></textarea>
                  <span style="color: red">{{ error_examr }}</span>
                </div>
                <div
                  v-if="
                    selectedAffichage === 'ok' || selectedAffichage === 'both'
                  "
                >
                  <label for="prescription">Prescription</label>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Medicament</th>
                          <th>Dose</th>
                          <th>Prise</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(pres, index) in prescrip" :key="index">
                          <td>
                            {{ pres.medicament }}
                          </td>
                          <td>
                            <textarea
                              rows="1"
                              class="form-control"
                              v-model="pres.dose"
                              id=""
                            ></textarea>
                          </td>
                          <td>
                            <textarea
                              rows="1"
                              class="form-control"
                              v-model="pres.prise"
                              id=""
                            ></textarea>
                            <input type="hidden" v-model="pres.id" />
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Medicament</th>
                          <th>Dose</th>
                          <th>Prise</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(item, index) in items" :key="index">
                          <td>
                            <input
                              placeholder="......"
                              type="text"
                              style="
                                height: 55px;
                                line-height: 2;
                                padding-top: 20px;
                                padding-bottom: 20px;
                              "
                              class="form-control"
                              v-model="item.libelle"
                              @input="
                                autocompleteItem(index, $event.target.value)
                              "
                            />
                            <ul
                              v-if="
                                filteredItems[index] &&
                                filteredItems[index].length > 0
                              "
                              class="autocomplete-list"
                            >
                              <li
                                v-for="(filteredItem, i) in filteredItems[
                                  index
                                ]"
                                :key="i"
                                @click="selectItem(index, filteredItem)"
                              >
                                {{ filteredItem.libelle }}
                              </li>
                            </ul>
                          </td>
                          <td>
                            <textarea
                              rows="1"
                              class="form-control"
                              v-model="item.dose"
                              id=""
                            ></textarea>
                          </td>
                          <td>
                            <textarea
                              rows="1"
                              class="form-control"
                              v-model="item.prise"
                              id=""
                            ></textarea>
                          </td>
                          <td>
                            <center>
                              <button
                                type="button"
                                class="badge bg-danger"
                                @click="removeItem(index)"
                              >
                                <i class="bx bx-trash text-light"></i>
                              </button>
                            </center>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <center>
                    <button
                      type="button"
                      class="badge bg-primary rounded-circle"
                      @click="addItem"
                    >
                      <i class="bx bx-plus-circle"></i>
                    </button>
                  </center>
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

<script>
export default {
  name: "paye",
  props: {
    consultation: Object,
  },
  data() {
    return {
      items: [],
      itemsList: [],
      ante: [],
      prescrip: [],
      itemsM: [],
      filteredItems: [[]],
      taskName: "",
      selectedAffichage: this.consultation.exam_recom,
      dd: "consgMModal" + this.consultation.id_consultation,
      ages: "",
      dates: "",
      nom_p: this.consultation.nom,
      prenom_p: this.consultation.prenom,
      motif: this.consultation.motif,
      id_consultation: this.consultation.id_consultation,
      id_patient: this.consultation.id_pat,
      temperature: this.consultation.temperature,
      poids: this.consultation.poids,
      taille: this.consultation.taille,
      symptome: this.consultation.symptome,
      diagnostique: this.consultation.diagnostique,
      examr: this.consultation.exam_recom,
      type_cons: this.consultation.type_cons,
    };
  },
  async created() {
    var dateA = new Date();
    var dateBD = new Date(this.consultation.date_naissance);
    var diffM = dateA - dateBD;
    var diffA = diffM / (1000 * 60 * 60 * 24 * 365.25);
    var age = Math.floor(diffA);
    this.ages = age;
    this.showResults = false;
    var dateBaseDeDonnees = this.consultation.date_naissance;
    // Séparation de la chaîne de caractères en trois parties : année, mois et jour
    var partiesDate = dateBaseDeDonnees.split("-");
    var annee = partiesDate[0];
    var mois = partiesDate[1];
    var jour = partiesDate[2];

    // Création de la nouvelle chaîne de caractères dans le format désiré : "jour-mois-année"
    var formatReformate = jour + "-" + mois + "-" + annee;
    this.dates = formatReformate;
    try {
      const response = await fetch("http://127.0.0.1:8000/api/autocomp/med");
      this.itemsList = await response.json();
    } catch (error) {
      console.error(error);
    }
  },

  methods: {
    autocompleteItem(index, searchTerm) {
      this.filteredItems[index] = this.itemsList.filter((item) =>
        item.libelle.toLowerCase().includes(searchTerm.toLowerCase())
      );
    },
    selectItem(index, item) {
      this.items[index].libelle = item.libelle;
      this.items[index].montant = item.montant;
      this.filteredItems[index] = [];
    },
    removeItem(index) {
      this.items.splice(index, 1);
      this.filteredItems.splice(index, 1);
    },
    addItem() {
      this.items.push({ libelle: "", dose: "", prise: "" });
      this.filteredItems.push([]);
    },
    async fetchAnte() {
      try {
        const res = await fetch(
          "http://127.0.0.1:8000/api/patient/ante/" + this.id_patient,
          {
            method: "GET",
            headers: {
              Authorization: "Bearer " + localStorage.getItem("current_token"),
              "Content-type": "application/json",
            },
          }
        );
        const anteced = await res.json();
        return anteced;
      } catch (error) {
        console.error(error);
      }
    },
    async fetchPrescrire() {
      const pres = await fetch(
        "http://127.0.0.1:8000/api/prescrire/" +
          this.consultation.id_consultation,
        {
          method: "GET",
          headers: {
            Authorization: "Bearer " + localStorage.getItem("current_token"),
            "Content-type": "application/json",
          },
        }
      );

      const Prescrire = await pres.json();
      return Prescrire;
      // console.log(Prescrire);
    },
    async saveData(e) {
      e.preventDefault();
      const formData = new FormData();
      const itemsData = JSON.stringify(this.items);
      const itemsMData = JSON.stringify(this.prescrip);
      formData.append("items", itemsData);
      formData.append("itemsM", itemsMData);
      formData.append("id_pat", this.id_patient);
      formData.append("temperature", this.temperature);
      formData.append("poids", this.poids);
      formData.append("taille", this.taille);
      formData.append("symptome", this.symptome);
      formData.append("diagnostique", this.diagnostique);
      formData.append("examr", this.examr);
      formData.append("id_consultation", this.id_consultation);
      formData.append("type_cons", this.type_cons);
      formData.append("id_pers", localStorage.getItem("current_idper"));
      try {
        const response = await fetch(
          "http://127.0.0.1:8000/api/consutation/update",
          {
            method: "POST",
            headers: {
              Authorization: "Bearer " + localStorage.getItem("current_token"),
              Accept: "application/json",
            },
            body: formData,
          }
        );
        if (response.status === 422) {
          const error_msg = await response.json();
          console.log(error_msg);
          // this.error_libelle = error_msg.errors?.libelle?.[0] || "";
          // this.error_prix_examen = error_msg.errors?.prix_examen?.[0] || "";

          // location.reload();
        } else {
          alert("Patient recu avec success!!!");
          location.reload();
        }
      } catch (error) {
        console.error(error);
      }
    },
  },
  async mounted() {
    this.prescrip = await this.fetchPrescrire();
    this.ante = await this.fetchAnte();
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
