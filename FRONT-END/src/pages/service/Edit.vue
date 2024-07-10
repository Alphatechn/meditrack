<template>
  <div>
    <div
      class="modal fade"
      v-bind:id="dd"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content text-dark">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">
              Edit Service --{{ service_libelle }}
            </h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form @submit="updateService">
            <div class="modal-body">
              <div>
                <label for="libelle" class="form-label">Service</label>
                <input
                  type="text"
                  v-model="service_libelle"
                  class="form-control"
                  id="libelle"
                  placeholder="Service name..."
                />
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">
                update Service
              </button>
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Close
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script >
export default {
  name: "Edit",
  props: {
    service: Object,
  },
  data() {
    return {
      dd: "editModal" + this.service.id,
      service_id: this.service.id,
      service_libelle: this.service.libelle,
    };
  },
  methods: {
    async updateService(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append("libelle", this.service_libelle);

      const res = await fetch(
        "http://127.0.0.1:8000/api/service/" + this.service.id,
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