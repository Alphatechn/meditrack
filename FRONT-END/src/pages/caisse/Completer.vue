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
                  ><h3><b>Motif Bref :</b> {{ this.taskName }}</h3></label
                >
                <input type="hidden" v-model="id_transfert" />
                <input type="hidden" v-model="id_patient" />
              </div>
              <br />
              <div class="row">
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
                    readonly
                  />
                </div>
                <div class="col-sm-3">
                  <label for="taskName">Montant Versé New:</label>
                  <input
                    type="number"
                    class="form-control"
                    id="taskName"
                    v-model.number="mverse_n"
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
      lcaisse:'',
      filteredItems: [[]],
      taskName: '',
      someAmount: 0,
      mreste: 0,
      mverse: 0,
      mverse_n: 0,
      mlettre: "",
      dd: "compModal" + this.transfert.id_transfert,
      nom_p: this.transfert.nom,
      prenom_p: this.transfert.prenom,
      motif: this.transfert.motif,
      id_transfert: this.transfert.id_transfert,
      id_patient: this.transfert.id_pat,
      idcaisse:'',
    };
  },
  async created() {
    try {
      const response = await fetch("http://127.0.0.1:8000/api/autocomp");
      this.itemsList = await response.json();
    } catch (error) {
      console.error(error);
    }

    try {
      const resp = await fetch("http://127.0.0.1:8000/api/caisse/show/"+this.transfert.num_caisse);
      this.lcaisse = await resp.json();
      this.mreste = this.lcaisse.reste;
      this.mverse = this.lcaisse.verser;
      this.taskName = this.lcaisse.motif;
      this.someAmount = this.lcaisse.prix;
      this.idcaisse = this.lcaisse.id;
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
    mverse_n(newMverseN) {
      this.calcul();
      this.mlettre = (
        this.convertNumberToWords(this.mverse + newMverseN) + " FCFA"
      ).toUpperCase();
    },
  },
  methods: {
    calcul() {
      this.mreste = this.someAmount - (this.mverse + this.mverse_n);
    },
    async saveData(e) {
      e.preventDefault();
      try {
        const response = await fetch("http://127.0.0.1:8000/api/caisse/update/"+this.idcaisse, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            verser: this.mverse + this.mverse_n,
            lettre: this.mlettre,
            reste: this.mreste,
            idcaisse: this.idcaisse,
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
