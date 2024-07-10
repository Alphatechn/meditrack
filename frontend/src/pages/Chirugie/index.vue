<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-3 text-center bg-primary">
          <h1 class="m-0 text-white">Examens</h1>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <div class="row justify-content-center">
            <h1 id="ll" class="card-title text-center">
              <b> LISTE DES EXAMENS </b>
            </h1>
          </div>
          <div class="row justify-content-end mr-1">
            <p>
              <button class="btn btn-success w-">
                <router-link class="text-white link" to="/exa/c_exa">
                  Ajouter un examen
                </router-link>
                <i class="fas fa-plus"></i>
              </button>
            </p>
          </div>
          <div class="table-responsive">
            <table ref="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Examen</th>
                  <th scope="col">Montant</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(examen, index) in allExamen" :key="examen.id">
                  <td>{{ compter + index }}</td>
                  <td>{{ examen.libelle }}</td>
                  <td>{{ examen.prix_examen }}</td>
                  <td><Options :examen="examen" /></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

 <script>
import Options from "./Options.vue";

export default {
  name: "Liste",
  components: { Options },
  data() {
    return {
      allExamen: [],
      dataTable: null,
      compter: 1,
    };
  },
  methods: {
    async fetchExamen() {
      const examen = await fetch("http://127.0.0.1:8000/api/examen", {
        method: "GET",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("current_token"),
          "Content-type": "application/json",
        },
      });
      const Examen = await examen.json();
      return Examen;
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
              columns: [0, 1, 2, 3],
            },
          },
          // {
          //   extend: 'pdfHtml5',
          //   text: 'PDF',
          //   exportOptions: {
          //     columns: [0, 1, 2, 3]
          //   }
          // },
          {
            extend: "excel",
            text: "Excel",
            exportOptions: {
              columns: [0, 1, 2, 3],
            },
          },
          "colvis",
        ],
      });
    },
  },
  async mounted() {
    this.allExamen = await this.fetchExamen();
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