<!-- components/GeneratePdfButton.vue -->
<template>
  <button @click="generatePdf">Générer PDF</button>
  <iframe v-if="pdfUrl" :src="pdfUrl" width="100%" height="600" frameborder="0" allowfullscreen>

  </iframe>
</template>

<script>
export default {
  name: 'GeneratePdfButton',
  data() {
    return {
      pdfUrl: null
    }
  },
  methods: {
    async generatePdf() {
      try {
        const response = await fetch('http://127.0.0.1:8000/api/pdf/generate/'+
        localStorage.getItem("current_iduser")+'/'+
        localStorage.getItem("current_idpat"), {
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
    }
  }
}
</script>
