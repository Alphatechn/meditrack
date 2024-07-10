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
              Details Paiement -- {{ caisse_nom }} {{ caisse_prenom }}
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          
            <div class="modal-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th scope="col">N°</th>
                      <th scope="col">Libelle</th>
                      <th scope="col">Montant</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(caisse, index) in allcaisse" :key="caisse.id">
                      <td>{{ compter + index }}</td>
                      <td>{{ caisse.libelle }}</td>
                      <td>{{ caisse.montant }}</td>
                    </tr>
                  </tbody>
                </table>
                <center><b>Total :</b> {{ caisse_total }} FCFA</center>
              </div>
            </div>
            <div class="justify-content-center mb-3">
             <center><button class="btn btn-primary" @click="generatePdf">Aperçu avant impression</button></center> 
            </div>
            <iframe
              v-if="pdfUrl"
              :src="pdfUrl"
              width="100%"
              height="600"
              frameborder="0"
              allowfullscreen
            >
            </iframe>
         
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Show",
  props: {
    caisse: Object,
  },
  data() {
    return {
      pdfUrl: null,
      dd: "showModal" + this.caisse.id_caisse,
      caisse_id: this.caisse.id_caisse,
      caisse_nom: this.caisse.nom,
      caisse_prenom: this.caisse.prenom,
      caisse_total: this.caisse.prix,
      allcaisse: [],
      compter: 1,
    };
  },
  async created() {
    try {
      const resp = await fetch(
        "http://127.0.0.1:8000/api/caisse/showun/" + this.caisse.numero_recu
      );
      this.allcaisse = await resp.json();
    } catch (error) {
      console.error(error);
    }
  },
  methods: {
    async generatePdf() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/recu/'+ this.caisse.numero_recu,
        {
          method: 'GET',
          headers: {
            'Content-Type': 'application/pdf',
            'Accept': 'application/pdf'
          }
        });

        const blob = await response.blob();

        this.pdfUrl = URL.createObjectURL(blob);
        // window.open(url, '_blank');
        // link.click();
      } catch (error) {
        console.error('Erreur lors de la génération du PDF:', error);
      }
    },
    async updatecaisse(e) {
      e.preventDefault();
      const formData = new FormData();

      formData.append("libelle", this.caisse_libelle);
      formData.append("prix_caisse", this.caisse_prix_caisse);

      const res = await fetch(
        "http://127.0.0.1:8000/api/caisse/" + this.caisse.id,
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
};
</script>
