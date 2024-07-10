<template>
  <div class="pagetitle">
    <h1>Personnel</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/home">Home</router-link>
        </li>
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
              <b>LISTE DU PERSONNELS</b>
            </h1>
          </div>

          <div class="row justify-content-end mr-1">
            <p>
              <button class="btn btn-success w-">
                <router-link class="text-white link" to="/per/c_per"
                  >Ajouter un personnel <i class="fas fa-plus"></i
                ></router-link>
              </button>
            </p>
          </div>
          <div class="card-body overflow-auto">
            <table ref="dataTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Nom</th>
                  <th scope="col">Profile</th>
                  <th scope="col">Prenom</th>
                  <th scope="col">Contact</th>
                  <th scope="col">Adresse</th>
                  <th scope="col">Date Embauche</th>
                  <th scope="col">Fonction</th>
                  <th scope="col">Matricule</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(personnel, index) in allPersonnel" :key="index">
                  <td>{{ counter + index }}</td>
                  <td>
                    <img
                      :src="`http://127.0.0.1:8000/upload/profile/${personnel.profil}`"
                      alt=""
                      style="width: 50px; height: 50px; border-radius: 50px"
                    />
                  </td>
                  <td>{{ personnel.nom }}</td>
                  <td>{{ personnel.prenom }}</td>
                  <td>{{ personnel.telephone }}</td>
                  <td>{{ personnel.adresse }}</td>
                  <td>{{ personnel.date_embauche }}</td>
                  <td>{{ personnel.libelle }}</td>
                  <td>{{ personnel.matricule }}</td>
                  <td><Options :personnel="personnel" /></td>
                </tr>
              </tbody>
            </table>
          </div>
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
      allPersonnel: [],
      counter: 1,
      dataTable: null,
    };
  },
  methods: {
    async fetchPersonnel() {
      const personnel = await fetch("http://127.0.0.1:8000/api/personnel", {
        method: "GET",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("current_token"),
          "Content-type": "application/json",
        },
      });
      const Personnel = await personnel.json();
      return Personnel;
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
              columns: [0, 1, 2, 3, 4, 5, 6, 7],
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
              columns: [0, 1, 2, 3, 4, 5, 6, 7],
            },
          },
          "colvis",
        ],
      });
    },
  },
  async mounted() {
    this.allPersonnel = await this.fetchPersonnel();
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
