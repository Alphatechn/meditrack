<template>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="#" class="logo d-flex align-items-center">
        <img src="../../assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">MediTrack</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn " @click="toggleSidebar"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li>
          <div>Temps restant avant déconnexion: {{ inactivityTimeRemaining }} secondes</div>
        </li>
        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span v-if="cpattrans !=0" class="badge bg-primary badge-number">{{cpattrans}}</span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              {{cpattrans}} Patients Transféré
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item" v-for="(pat,index) in pattrans" :key="pat.id_transfert">
              <p><b>{{ c+index }}</b></p> &nbsp;-&nbsp;
              <div>
                <p class="text-dark">{{ pat.nom }} {{ pat.prenom }}</p>
              </div>
              
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Afficher toutes les notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->


        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img :src="`http://localhost:8000/upload/profile/${profile}`" style="height: 50px; width: 50px;" alt="Profile" class="rounded-circle">

            <span class="d-none d-md-block dropdown-toggle ps-2">{{ this.nom}} {{ this.prenom }}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ this.nom}} {{ this.prenom }}</h6>
              <span>{{ this.travail}}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <router-link to="/profile" class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-person"></i>
                <span>Mon Profile</span>
              </router-link>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li v-if="this.current_token">
              <a class="dropdown-item d-flex align-items-center" href="#" @click="logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Deconnexion</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->
</template>

<script>
export default {
  name: 'App',
  data() {
    return {

      inactivityTimeout: null,
      inactivityInterval: null,
      inactivityTimeLimit: 600, // Temps d'inactivité en secondes (10 minutes)
      inactivityTimeRemaining: 600, // Temps restant avant déconnexion en secondes
      isSidebarOpen: false,
      current_token: localStorage.getItem('current_token'),
      current_nom: localStorage.getItem('current_nom'),
      current_prenom: localStorage.getItem('current_prenom'),
      current_email: localStorage.getItem('current_email'),
      current_idser: localStorage.getItem('current_idser'),
      current_profil: localStorage.getItem('current_profil'),
      current_role: localStorage.getItem('current_role'),
      current_fonction: localStorage.getItem('current_fonction'),
      pattrans: [],
      cpattrans: '',
      c: 1,
      UserA: '',
      nom: '',
      prenom: '',
      sexe: '',
      travail: '',
      image: '',
    }
  },
  watch: {
    isSidebarOpen(newValue) {
      document.body.classList.toggle('toggle-sidebar', newValue)
    },
    '$route'(to, from) {
      this.isSidebarOpen = false; // Hide the sidebar when the URL changes
    }
  },
  methods: {
    resetInactivityTimeout() {
      // Réinitialiser le délai d'inactivité
      clearTimeout(this.inactivityTimeout);
      clearInterval(this.inactivityInterval);
      this.inactivityTimeRemaining = this.inactivityTimeLimit;
      this.inactivityTimeout = setTimeout(this.logoutUser, this.inactivityTimeLimit * 1000);
      this.startInactivityInterval();
    },
    startInactivityInterval() {
      this.inactivityInterval = setInterval(() => {
        if (this.inactivityTimeRemaining > 0) {
          this.inactivityTimeRemaining--;
        } else {
          clearInterval(this.inactivityInterval);
        }
      }, 1000);
    },
    async logoutUser() {
      // // Déconnexion de l'utilisateur
      // localStorage.removeItem("auth_token"); // Invalider le token en le supprimant
      // this.$router.push("/"); // Rediriger vers la page de connexion
      let res;
        res = await fetch(
          "http://localhost:8000/api/logout",
          {
            method: "POST",
            headers: {
              'Authorization': 'Bearer ' + this.current_token,
            },
          }
        );

        delete localStorage.current_token;
        delete localStorage.current_nom;
        delete localStorage.current_prenom;
        delete localStorage.current_email;
        location.reload();
    },
    onFileChange(event) {
      this.image = event.target.files[0];
    },
    async updateUser(e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append('image', this.image);
      formData.append('nom', this.nom);
      formData.append('prenom', this.prenom);
      formData.append('telephone', this.telephone);
      formData.append('adresse', this.adresse);
      formData.append('sit_mat', this.sit_mat);
      formData.append('email', this.email);
      formData.append('sexe', this.sexe);
      formData.append('travail', this.travail);

      const res = await fetch(
        'http://localhost:8000/api/updateuser/' + this.id_user,
        {
          method: 'POST',
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('current_token'),
            Accept: 'application/json',
          },
          body: formData,
        }
      );

      const data = await res.json();
      if (res.status === 401) {
        alert(data.message + ' Veuillez vous connecter d\'abord !');
      } else {
        alert('Informations mises à jour !!!');
        location.reload();
      }
    },
    async fetchUser() {
      const user = await fetch("http://localhost:8000/api/infouser/" + localStorage.getItem('current_iduser'), {
        method: "GET",
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('current_token'),
          "Content-type": "application/json"
        }
      });
      const User = await user.json();
      return User;
    },
    toggleSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen;
    },
    async fetchPatTrans() {
      const transfert = await fetch("http://localhost:8000/api/transfert/" + localStorage.getItem('current_idser'), {
        method: "GET",
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('current_token'),
          "Content-type": "application/json"
        }
      });

      const PatTrans = await transfert.json();
      return PatTrans;
    },
    async fetchCPatTrans() {
      const Ctransfert = await fetch("http://localhost:8000/api/transfert/count/" + localStorage.getItem('current_idser'), {
        method: "GET",
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('current_token'),
          "Content-type": "application/json"
        }
      });

      const CPatTrans = await Ctransfert.json();
      return CPatTrans;
    },
    async logout(e) {
      e.preventDefault();
      if (confirm("Voulez-vous vraiment vous déconnecter ?")) {
        let res;
        res = await fetch(
          "http://localhost:8000/api/logout",
          {
            method: "POST",
            headers: {
              'Authorization': 'Bearer ' + this.current_token,
            },
          }
        );

        const error_msg = await res?.json();

        delete localStorage.current_token;
        delete localStorage.current_nom;
        delete localStorage.current_prenom;
        delete localStorage.current_email;
        alert(error_msg.message);
        location.reload();
      }
    }
  },

  created() {
    // Ajouter des écouteurs d'événements pour détecter l'activité
    window.addEventListener("mousemove", this.resetInactivityTimeout);
    window.addEventListener("mousedown", this.resetInactivityTimeout);
    window.addEventListener("keypress", this.resetInactivityTimeout);
    window.addEventListener("touchstart", this.resetInactivityTimeout);

    // Initialiser le délai d'inactivité
    this.resetInactivityTimeout();
  },

  beforeDestroy() {
    // Supprimer les écouteurs d'événements lorsque le composant est détruit
    window.removeEventListener("mousemove", this.resetInactivityTimeout);
    window.removeEventListener("mousedown", this.resetInactivityTimeout);
    window.removeEventListener("keypress", this.resetInactivityTimeout);
    window.removeEventListener("touchstart", this.resetInactivityTimeout);

    // Nettoyer le délai d'inactivité et l'intervalle
    clearTimeout(this.inactivityTimeout);
    clearInterval(this.inactivityInterval);
  },


  async mounted() {
    this.UserA = await this.fetchUser();
    this.nom = this.UserA.user.nom;
    this.id_user = this.UserA.user.id;
    this.prenom = this.UserA.user.prenom;
    this.sexe = this.UserA.user.sexe;
    this.sit_mat = this.UserA.user.sit_mat;
    this.adresse = this.UserA.user.adresse;
    this.telephone = this.UserA.user.telephone;
    this.profile = this.UserA.user.profil;
    this.email = this.UserA.user.email;
    this.travail = this.UserA.type_user.libelle;
    setInterval(async () => {
      this.pattrans = await this.fetchPatTrans();
      this.cpattrans = await this.fetchCPatTrans();
    }, 5000);
  },
}
</script>


<style>
  .badge-small {
    font-size: 0.5rem;
    padding: 0.2rem 0.4rem;
  }

</style>