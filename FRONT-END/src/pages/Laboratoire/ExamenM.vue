<template>
  <div>
    <div
      class="modal fade"
      :id="dd"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-xl">
        <div class="modal-content text-dark">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">
              Modifier les resultats de -- {{ nom_p }} {{ prenom_p }}
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form @submit="saveData">
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12">
                  <label for="motif" class="form-label">
                    <h3><b>Examens Recommandes :</b> {{ motif }}</h3>
                  </label>
                  <input type="hidden" v-model="id_transfert" />
                  <input type="hidden" v-model="id_patient" />
                </div>
              </div>
              <hr style="color: green; border: 3px solid green" />
              <div class="row">
                <div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Examen</th>
                          <th>Resultat Text</th>
                          <th>Resultat Image</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(itemm, index) in examina" :key="index">
                          <td>
                            <input
                              type="text"
                              class="form-control"
                              v-model="itemm.exam"
                            />
                            <input type="hidden" v-model="itemm.id_resultp" />
                          </td>
                          <td>
                            <textarea
                              rows="1"
                              class="form-control"
                              v-model="itemm.result_text"
                            ></textarea>
                          </td>
                          <td>
                            <center>
                            
                              <img v-if="itemm.result_image != null"
:src="`http://127.0.0.1:8000/images/${itemm.result_image}`"
                              alt=""
                              style="width: 50px; height: 50px;"
                            />                            <input
                              type="file"
                              class="form-control"
                              @change="onImageChange($event, index)"
                              :id="'imagem_' + index"
                            />
                            
                          </center>

                          </td>
                          
                        </tr>
                      </tbody>
                    </table>
                  </div>

                </div>
              </div>

              <div class="row">
                <div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Examen</th>
                          <th>Resultat Text</th>
                          <th>Resultat Image</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(item, index) in items" :key="index">
                          <td>
                            <input
                              placeholder="......"
                              type="text"
                              class="form-control"
                              v-model="item.libelle"
                              @input="autocompleteItem(index, $event.target.value)"
                            />
                            <ul
                              v-if="filteredItems[index] && filteredItems[index].length > 0"
                              class="autocomplete-list"
                            >
                              <li
                                v-for="(filteredItem, i) in filteredItems[index]"
                                :key="i"
                                @click="selectItem(index, filteredItem)"
                              >
                                {{ filteredItem.libelle }}
                              </li>
                            </ul>
                          </td>
                          <td>
                            <textarea
                              rows="1"
                              class="form-control"
                              v-model="item.result_t"
                            ></textarea>
                          </td>
                          <td>
                            <input
                              type="file"
                              class="form-control"
                              @change="onFileChange($event, index)"
                              :id="'image_' + index"
                            />
                          </td>
                          <td>
                            <center>
                              <button
                                type="button"
                                class="badge bg-danger"
                                @click="removeItem(index)"
                              >
                                <i class="bx bx-trash text-light"></i>
                              </button>
                            </center>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <center>
                    <button
                      type="button"
                      class="badge bg-primary rounded-circle"
                      @click="addItem"
                    >
                      <i class="bx bx-plus-circle"></i>
                    </button>
                  </center>
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
                Fermer
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
    examination: Object,
  },
  data() {
    return {
      items: [],
      itemsList: [],
      filteredItems: [[]],
      dd: `consgModal${this.examination.id_transfert}`,
      nom_p: this.examination.nom,
      prenom_p: this.examination.prenom,
      motif: this.examination.motif,
      id_transfert: this.examination.id_transfert,
      id_patient: this.examination.id_pat,
      id_consult: this.examination.id_cons,
      examina: [],
    };
  },
  async created() {
    try {
      const response = await fetch("http://127.0.0.1:8000/api/autocomp/exam");
      this.itemsList = await response.json();
    } catch (error) {
      console.error(error);
    }
  },

  methods: {
    autocompleteItem(index, searchTerm) {
      this.filteredItems[index] = this.itemsList.filter((item) =>
        item.libelle.toLowerCase().includes(searchTerm.toLowerCase())
      );
    },
    selectItem(index, item) {
      this.items[index].libelle = item.libelle;
      this.filteredItems[index] = [];
    },
    removeItem(index) {
      this.items.splice(index, 1);
      this.filteredItems.splice(index, 1);
    },
    addItem() {
      this.items.push({ libelle: "", result_t: "", image: null });
      this.filteredItems.push([]);
    },
    async fetchExamination() {
      const exam = await fetch(
        "http://127.0.0.1:8000/api/examination/show/" +
          this.examination.id_cons,
        {
          method: "GET",
          headers: {
            Authorization: "Bearer " + localStorage.getItem("current_token"),
            "Content-type": "application/json",
          },
        }
      );

      const Examination = await exam.json();
      return Examination;
      // console.log(Prescrire);
    },
    async saveData(e) {
      e.preventDefault();
      const formData = new FormData();
      this.items.forEach((item, index) => {
        formData.append(`items[${index}][libelle]`, item.libelle);
        formData.append(`items[${index}][result_t]`, item.result_t);
        if (item.image) {
          formData.append(`items[${index}][image]`, item.image);
        }
      });
      this.examina.forEach((itemm, index) => {
        formData.append(`examina[${index}][id]`, itemm.id_resultp);
        formData.append(`examina[${index}][exam]`, itemm.exam);
        formData.append(`examina[${index}][result_text]`, itemm.result_text);
        if (itemm.imagem) {
          formData.append(`examina[${index}][imagem]`, itemm.imagem);
        }
      });
      formData.append("id_pat", this.id_patient);
      formData.append("id_transfert", this.id_transfert);
      formData.append("id_consultation", this.id_consult);
      formData.append("id_pers", localStorage.getItem("current_idper"));
      try {
        const response = await fetch("http://127.0.0.1:8000/api/examination/update", {
          method: "POST",
          headers: {
            Authorization: `Bearer ${localStorage.getItem("current_token")}`,
            Accept: "application/json",
          },
          body: formData,
        });
        if (response.status === 422) {
          const error_msg = await response.json();
          console.error(error_msg);
        } else {
          alert("Patient recu avec success!!!");
          location.reload();
        }
      } catch (error) {
        console.error(error);
      }
    },
    onFileChange(event, index) {
      const file = event.target.files[0];
      if (file) {
        this.items[index].image = file;
      }
    },
    onImageChange(event, index) {
      const file = event.target.files[0];
      if (file) {
        this.examina[index].imagem = file;
      }
    },
  },
  async mounted() {
    this.examina = await this.fetchExamination();
  },
};
</script>

<style scoped>
.autocomplete-list {
  list-style-type: none;
  padding: 0;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  background-color: white;
  position: absolute;
  z-index: 1;
}

.autocomplete-list li {
  padding: 8px 12px;
  cursor: pointer;
}

.autocomplete-list li:hover {
  background-color: #f1f1f1;
}
</style>+