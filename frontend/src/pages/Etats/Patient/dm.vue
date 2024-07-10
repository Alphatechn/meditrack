<!-- components/GeneratePdfButton.vue -->
<template>
  <div class="pagetitle">
    <h1>Pages</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/home">Home</router-link>
        </li>
        <li class="breadcrumb-item active">Mon Dossier Medical</li>
      </ol>
    </nav>
  </div>

  <iframe v-if="pdfUrl" :src="pdfUrl" width="100%" height="600" frameborder="0" allowfullscreen></iframe>
</template>

<script>
export default {
  name: 'GeneratePdfButton',
  data() {
    return {
      pdfUrl: null,
      id: localStorage.getItem("current_iduser"),
      idpat: localStorage.getItem("current_idpat"),
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
      } catch (error) {
        console.error('Erreur lors de la génération du PDF:', error);
      }
    }
  },
  mounted() {
    this.generatePdf();
  }
}
</script>
