<template>
  <div class="pagetitle">
    <h1>Medicament</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/home">Home</router-link>
        </li>
        <li class="breadcrumb-item">Categorie</li>
        <li class="breadcrumb-item active">Listes</li>
      </ol>
    </nav>
  </div>
  <!-- End Page Title -->
  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <div class="row justify-content-center">
            <h1 id="ll" class="card-title text-center">
              <b> LISTE DES CATEGORIES </b>
            </h1>
          </div>

          <div class="row justify-content-end mr-1">
            <p>
              <button class="btn btn-success w-">
                <router-link class="text-white link" to="/med/c_cat">
                  Ajouter une categorie<i class="fas fa-plus"></i
                ></router-link>
              </button>
            </p>
          </div>

          <table ref="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th scope="col">N°</th>
                <th scope="col">categorie</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="categorie in allCategorie" :key="categorie.id">
                <td>{{ categorie.id }}</td>
                <td>{{ categorie.libelle }}</td>
                <td><Options :categorie="categorie" /></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
</style>
<script>
import Options from "./Options.vue";
export default {
  name: "Liste",
  components: { Options },
  data() {
    return {
      allCategorie: [],
      dataTable: null,
    };
  },
  methods: {
    async fetchCategorie() {
      const categorie = await fetch("http://127.0.0.1:8000/api/categorie", {
        method: "GET",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("current_token"),
          "Content-type": "application/json",
        },
      });
      const Categorie = await categorie.json();
      return Categorie;
    },
    initializeDataTable() {
      this.dataTable = $(this.$refs.dataTable).DataTable({
        lengthMenu: [10, 25, 50, 100, "Tous"],
        language: {
          decimal: "",
          emptyTable: "Aucune donnée disponible dans le tableau",
          info: "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
          infoEmpty: "Affichage de 0 à 0 sur 0 entrée",
          infoFiltered: "(filtré à partir de _MAX_ entrées au total)",
          infoPostFix: "",
          thousands: ",",
          lengthMenu: "Afficher _MENU_ entrées",
          loadingRecords: "Chargement...",
          processing: "Traitement...",
          search: "Rechercher :",
          zeroRecords: "Aucun enregistrement correspondant trouvé",
          paginate: {
            first: "Premier",
            last: "Dernier",
            next: "Suivant",
            previous: "Précédent",
          },
          aria: {
            sortAscending:
              ": activer pour trier la colonne par ordre croissant",
            sortDescending:
              ": activer pour trier la colonne par ordre décroissant",
          },
        },
        dom: "lBfrtip",
        buttons: [
          {
            extend: "print",
            text: "Imprimer",
            exportOptions: {
              columns: [0, 1, 2],
            },
          },
          // {
          //   extend: 'pdfHtml5',
          //   text: 'PDF',
          //   exportOptions: {
          //     columns: [0, 1, 2, 3, 4, 5, 6, 7]
          //   }
          // },
          {
            extend: "excel",
            text: "Excel",
            exportOptions: {
              columns: [0, 1, 2],
            },
          },
          "colvis",
        ],
      });
    },
  },
  async mounted() {
    this.allCategorie = await this.fetchCategorie();
    this.$nextTick(() => {
      this.initializeDataTable();
    });
  },
  beforeDestroy() {
    if (this.dataTable) {
      this.dataTable.destroy();
    }
  },
};
</script>