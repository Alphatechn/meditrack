<template>
  <main class="wra">
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center bgs-transparent-h py-2">
                <router-link to="/home" class="logo d-flex align-items-center w-auto">
                  &nbsp;<img src="../../assets/img/logo.png" alt="">
                  <span class="none">MediTrack</span>&nbsp;
                </router-link>
              </div><!-- End Logo -->

              <div class="card mb-3 bgs-transparent">

                <div class="card-body">
                  <router-view></router-view>
                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
</template>
<style>
  .wra{
    background-image: url("../../assets/img/ap/0.png");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }
  .bgs-transparent {
    background-color: rgba(243, 236, 236, 0.901);
    border-top: 1px solid blue;
  }
  .bgs-transparent-h {
    background-color: rgba(243, 236, 236, 0.901);
    border-radius: 5px;
    border-top: 3px solid blue;
    border-bottom: 3px solid blue;
  }
</style>