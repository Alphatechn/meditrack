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
              Paye du patient -- {{ this.nom_p }} {{ this.prenom_p }}
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
              <br />
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Elements</th>
                      <th>Montant</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in items" :key="index">
                      <td>
                        <input
                          type="text"
                          class="form-control"
                          v-model="item.libelle"
                          @input="autocompleteItem(index, $event.target.value)"
                        />
                        <ul
                          v-if="
                            filteredItems[index] &&
                            filteredItems[index].length > 0
                          "
                          class="autocomplete-list"
                        >
                          <li
                            v-for="(filteredItem, i) in filteredItems[index]"
                            :key="i"
                            @click="selectItem(index, filteredItem)"
                          >
                            {{ filteredItem.libelle }}
                          </li>
                        </ul>
                      </td>
                      <td>
                        <input
                          type="number"
                          class="form-control"
                          v-model.number="item.montant"
                          :disabled="!item.libelle"
                          readonly
                        />
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

              <div class="row">
                <div class="col-sm-3">
                  <label for="taskName">Motif Bref:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="taskName"
                    v-model="taskName"
                  />
                </div>
                <div class="col-sm-3">
                  <label for="someAmount">Montant total:</label>
                  <input
                    type="number"
                    class="form-control"
                    id="someAmount"
                    v-model.number="someAmount"
                    readonly
                  />
                </div>
                <div class="col-sm-3">
                  <label for="verse">Montant Versé:</label>
                  <input
                    type="number"
                    class="form-control"
                    id="verse"
                    v-model.number="mverse"
                  />
                </div>
                <div class="col-sm-3">
                  <label for="reste">Montant Restant:</label>
                  <input
                    type="number"
                    class="form-control"
                    id="reste"
                    v-model.number="mreste"
                    readonly
                  />
                </div>
                <div>
                  <label for="lettre">Montant en lettre:</label>
                  <input
                    type="text"
                    readonly
                    v-model="mlettre"
                    class="form-control"
                    id="lettre"
                  />
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
        <!-- Spinner pour l'animation -->
 <!-- Overlay du spinner -->
    <div v-if="loading" class="spinner-overlay">
      <div class="spinner"></div>
    </div>
    <!-- Nouveau modal pour afficher le résultat -->
    <div class="modal fade" id="resultModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Aperçu avant impression</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <iframe v-if="pdfUrl" :src="pdfUrl" width="100%" height="600" frameborder="0" allowfullscreen>

            </iframe>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "paye",
  props: {
    transfert: Object,
  },
  data() {
    return {
      items: [{ libelle: "", montant: 0 }],
      itemsList: [],
      filteredItems: [[]],
      taskName: "",
      someAmount: 0,
      mreste: 0,
      mverse: 0,
      mlettre: "",
      dd: "transModal" + this.transfert.id_transfert,
      nom_p: this.transfert.nom,
      prenom_p: this.transfert.prenom,
      motif: this.transfert.motif,
      id_transfert: this.transfert.id_transfert,
      id_patient: this.transfert.id_pat,
      pdfUrl: null,
      loading: false,
    };
  },
  async created() {
    try {
      const response = await fetch("http://127.0.0.1:8000/api/autocomp");
      this.itemsList = await response.json();
    } catch (error) {
      console.error(error);
    }
  },
  computed: {
    total() {
      return this.items.reduce((total, item) => total + item.montant, 0);
    },
  },
  watch: {
    total(newTotal) {
      this.someAmount = newTotal;
      this.calcul();
    },
    mverse(newMverse) {
      this.calcul();
      this.mlettre = (
        this.convertNumberToWords(newMverse) + " FCFA"
      ).toUpperCase();
    },
  },
  methods: {
    calcul() {
      this.mreste = this.someAmount - this.mverse;
    },
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
      this.items.push({ libelle: "", montant: 0 });
      this.filteredItems.push([]);
    },
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
          this.loading = true;
          const blob = await response.blob();

        this.pdfUrl = URL.createObjectURL(blob);
          setTimeout(() => {
            this.loading = false; // Masquer le spinner après 30 secondes
            this.showResultModal();
          }, 5000); // 5000 ms = 5 seconds
          console.log("Data saved successfully");


      } catch (error) {
        console.error(error);
        this.loading = false;
      }
    },
    showResultModal() {
      // Fermer le modal actuel
      const modal = bootstrap.Modal.getInstance(document.getElementById(this.dd));
      modal.hide();

      // Ouvrir le modal de résultat
      const resultModal = new bootstrap.Modal(document.getElementById('resultModal'));
      resultModal.show();

      document.getElementById('resultModal').addEventListener('hidden.bs.modal', () => {
        location.reload();
      }, { once: true });
    },
    convertNumberToWords(num) {
      const ones = [
        "",
        "un",
        "deux",
        "trois",
        "quatre",
        "cinq",
        "six",
        "sept",
        "huit",
        "neuf",
        "dix",
        "onze",
        "douze",
        "treize",
        "quatorze",
        "quinze",
        "seize",
        "dix-sept",
        "dix-huit",
        "dix-neuf",
      ];
      const tens = [
        "",
        "",
        "vingt",
        "trente",
        "quarante",
        "cinquante",
        "soixante",
        "soixante-dix",
        "quatre-vingt",
        "quatre-vingt-dix",
      ];

      if (num < 20) return ones[num];
      if (num < 100)
        return (
          tens[Math.floor(num / 10)] +
          (num % 10 > 0 ? "-" + ones[num % 10] : "")
        );
      if (num < 1000) {
        if (num === 100) return "cent";
        return (
          ones[Math.floor(num / 100)] +
          " cent " +
          (num % 100 > 0 ? this.convertNumberToWords(num % 100) : "")
        );
      }

      if (num < 1000000) {
        if (num === 1000) return "mille";
        if (num < 2000)
          return (
            "mille " +
            (num % 1000 > 0 ? this.convertNumberToWords(num % 1000) : "")
          );
        return (
          this.convertNumberToWords(Math.floor(num / 1000)) +
          " mille " +
          (num % 1000 > 0 ? this.convertNumberToWords(num % 1000) : "")
        );
      }

      if (num < 1000000000)
        return (
          this.convertNumberToWords(Math.floor(num / 1000000)) +
          " million " +
          (num % 1000000 > 0 ? this.convertNumberToWords(num % 1000000) : "")
        );

      return (
        this.convertNumberToWords(Math.floor(num / 1000000000)) +
        " milliard " +
        (num % 1000000000 > 0
          ? this.convertNumberToWords(num % 1000000000)
          : "")
      );
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

.spinner-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.8);
  z-index: 9999; /* Un peu plus élevé que les modals Bootstrap */
  display: flex;
  justify-content: center;
  align-items: center;
}

.spinner {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

</style>
