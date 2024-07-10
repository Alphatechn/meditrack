<template>
  <div class="pagetitle">
    <h1>LABORATOIRE</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/home">Home</router-link>
        </li>
        <li class="breadcrumb-item">Examen</li>
        <li class="breadcrumb-item active">Creation</li>
      </ol>
    </nav>
  </div>
  <!-- End Page Title -->

  <div class="content">
    <div class="container-fluid">
      <div class="card bg-white border-0">
        <div class="col-lg-12 col-md-12">
          <div class="card-header border-0 bg-white">
            <div class="row">
              <h4 id="mss">EXAMENS</h4>
            </div>
          </div>
          <div class="card-body border-0">
            <div class="table-responsive">
              <table
                ref="dataTable2"
                class="table table-bordered table-striped"
              >
                <thead>
                  <tr>
                    <th scope="col">N°</th>
                    <th scope="col">Code</th>
                    <th scope="col">Nom Prenom</th>
                    <th scope="col">Motif</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(transfert, index) in allPatTrans"
                    :key="transfert.id_transfert"
                  >
                    <td>{{ compter + index }}</td>
                    <td>{{ transfert.code }}</td>
                    <td>{{ transfert.nom }} {{ transfert.prenom }}</td>
                    <td>{{ transfert.motif }}</td>

                    <td>
                      <Options :transfert="transfert" />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script >
import Options from "./Options.vue";
export default {
  components: { Options },
  data() {
    return {
      tableauDonnees: [{ id: 1, nom: "" }],
      allPatTrans: [],
      compter: 1,
    };
  },
  methods: {
    ajouterChamp(index) {
      const nouvelleLigne = { id: this.tableauDonnees.length + 1, nom: "" };
      this.tableauDonnees.splice(index + 1, 0, nouvelleLigne);
    },
    async fetchTransfert() {
      const transfert = await fetch(
        "http://127.0.0.1:8000/api/transfert/" +
          localStorage.getItem("current_idser"),
        {
          method: "GET",
          headers: {
            Authorization: "Bearer " + localStorage.getItem("current_token"),
            "Content-type": "application/json",
          },
        }
      );
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