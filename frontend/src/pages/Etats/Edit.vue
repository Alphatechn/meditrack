<template>
  <div>
    <div
      class="modal fade"
      v-bind:id="dd"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      ref="modal"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content text-dark">
          <div class="modal-header">
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <iframe v-if="pdfUrl" :src="pdfUrl" width="100%" height="600" frameborder="0" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Edit",
  props: {
    patient: Object,
  },
  data() {
    return {
      dd: "editModal" + this.patient.id_patient,
      patient_id: this.patient.id_patient,
      patient_user: this.patient.id_user,
      pdfUrl: null
    };
  },
  methods: {
    async generatePdf() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/pdf/generate/' +
          this.patient_user + '/' +
          this.patient_id, {
            method: 'GET',
            headers: {
              'Content-Type': 'application/pdf',
              'Accept': 'application/pdf'
            }
          });

        const blob = await response.blob();

        this.pdfUrl = URL.createObjectURL(blob);
      } catch (error) {
        console.error('Erreur lors de la génération du PDF:', error);
      }
    }
  },
  mounted() {
    this.generatePdf();
  }
};
</script>
