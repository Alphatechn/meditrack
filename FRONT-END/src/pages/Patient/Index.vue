<template>
  <div class="pagetitle">
    <h1>Patient</h1>
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
              <b> LISTE DES PATIENTS </b>
            </h1>
          </div>
          <div class="row justify-content-end mr-1">
            <p>
              <button class="btn btn-success w-">
                <router-link class="text-white link" to="/pat/c_pat">
                  Ajouter un patient
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
                  <th scope="col">Profile</th>
                  <th scope="col">Nom</th>
                  <th scope="col">Prenom</th>
                  <th scope="col">Contact</th>
                  <th scope="col">Adresse</th>
                  <th scope="col">Date Naissance</th>
                  <th scope="col">Lieu</th>
                  <th scope="col">Code</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(patient, eco) in allPatient" :key="patient.id">
                  <td>{{ counter + eco }}</td>
                  <td>
                    <img
                      :src="`http://127.0.0.1:8000/upload/profile/${patient.profil}`"
                      alt=""
                      style="width: 50px; height: 50px; border-radius: 50px"
                    />
                  </td>
                  <td>{{ patient.nom }}</td>
                  <td>{{ patient.prenom }}</td>
                  <td>{{ patient.telephone }}</td>
                  <td>{{ patient.adresse }}</td>
                  <td>{{ patient.date_naissance }}</td>
                  <td>{{ patient.lieu }}</td>
                  <td>{{ patient.code }}</td>
                  <td><Options :patient="patient" /></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <div class="row justify-content-center">
            <h1 id="ll" class="card-title text-center">
              <b> LISTE DES PATIENTS TRANSFERES </b>
            </h1>
          </div>
          <div class="table-responsive">
            <table ref="dataTable2" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Code</th>
                  <th scope="col">Nom et Prenom</th>
                  <th scope="col">Motif</th>
                  <th scope="col">Service</th>

                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(transfert, index) in allPatTrans"
                  :key="transfert.id_transfert"
                >
                  <td>{{ counter + index }}</td>
                  <td>{{ transfert.code }}</td>
                  <td>{{ transfert.nom }} {{ transfert.prenom }}</td>
                  <td>{{ transfert.motif }}</td>
                  <td>{{ transfert.libelle }}</td>

                  <td><OptionsT :transfert="transfert" /></td>
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
import OptionsT from "./OptionsT.vue";
import Options from "./Options.vue";

export default {
  name: "Liste",
  components: { OptionsT, Options },
  data() {
    return {
      allPatient: [],
      allPatTrans: [],
      counter: 1,
      dataTable: null,
      dataTable2: null,
    };
  },
  methods: {
    async fetchPatient() {
      const patient = await fetch("http://127.0.0.1:8000/api/patient", {
        method: "GET",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("current_token"),
          "Content-type": "application/json",
        },
      });
      const Patient = await patient.json();
      return Patient;
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
    async fetchTransfert() {
      const transfert = await fetch("http://127.0.0.1:8000/api/transfert", {
        method: "GET",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("current_token"),
          "Content-type": "application/json",
        },
      });
      const Transfert = await transfert.json();
      return Transfert;
    },
    initializeDataTable2() {
      this.dataTable2 = $(this.$refs.dataTable2).DataTable({
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
        dom: "lfrtip",
      });
    },
  },
  async mounted() {
    this.allPatient = await this.fetchPatient();
    this.$nextTick(() => {
      this.initializeDataTable();
    });
    this.allPatTrans = await this.fetchTransfert();
    this.$nextTick(() => {
      this.initializeDataTable2();
    });
  },
  beforeDestroy() {
    if (this.dataTable) {
      this.dataTable.destroy();
    }

    if (this.dataTable2) {
      this.dataTable2.destroy();
    }
  },
};
</script>