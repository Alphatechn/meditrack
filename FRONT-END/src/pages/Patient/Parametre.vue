<template>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-3 text-center bg-primary">
          <h1 class="m-0 text-white">Patients</h1>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div id="case24" class="n">
        <div class="row">
          <div class="col-6">
            <div class="box bg-white p-2" id="para">
              <div class="offset-3">
                <h4 id="lll">PATIENTS ENVOYER</h4>
              </div>

              <div class="px-4">
                <table id="parametre" class="table datatable table-responsive">
                  <thead>
                    <tr>
                      <th scope="col">Nom</th>
                      <th scope="col">Prenom</th>
                      <th scope="col">Age</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <td>gaga</td>
                    <td>chou</td>
                    <td>12</td>
                    <td>
                      <i
                        class="fas fa-share-square text-success"
                        title="Transferer"
                      ></i>
                      <span
                        id="sen"
                        class="btn btn-success ml-2 badge"
                        style="height: 25px"
                        >Parametre</span
                      >
                    </td>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-1"></div>
          <div class="col-4" id="metre">
            <div class="box bg-white p-3" id="para">
              <div class="row"></div>
              <div class="ml-3">
                <h1 id="lll">PARAMETRE DU PATIENT</h1>
              </div>
              <div class="row justify-content-center">
                <form method="post">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group position-relative">
                        <label for=""></label>
                        <input
                          type="hidden"
                          class="form-control is-search idpat"
                          name="idpat"
                          placeholder="Temperature"
                          id=""
                        />
                        <input
                          type="hidden"
                          value="<?php echo session()->get('id')?>"
                          class="idper"
                          name="idper"
                        />

                        <input
                          type="text"
                          class="form-control is-search"
                          name="temperature"
                          placeholder="Temperature"
                          id=""
                        />
                        <div class="search-feedback">°C</div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group position-relative">
                        <label for=""></label>
                        <input
                          type="text"
                          class="form-control is-search"
                          name="poids"
                          id=""
                          placeholder="Poids"
                        />
                        <div class="search-feedback">Kg</div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group position-relative">
                        <label for=""></label>
                        <input
                          type="text"
                          class="form-control is-search"
                          id=""
                          name="tension"
                          placeholder="Tension"
                        />
                        <div class="search-feedback">MmHg</div>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="p-3 offset-4">
                    <button class="btn btn-success" type="submit">
                      <small> OK <i class="fas fa-plus text-white"></i></small>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
#para {
  border-radius: 10px;
}
</style>
 <script >
</script>