<template>
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <router-link to="/home" class="nav-link" :class="{'collapsed' : $route.path!='/home'}">
          <i class="bx bxs-home"></i>
          <span>Accueil</span>
        </router-link>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item" v-if="current_role==='1011111001111101' || current_role==='1110101111101011'">
        <a :class="['nav-link',{'collapsed ' : !$route.path.startsWith('/pat/')}]" data-bs-target="#patient-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people-fill"></i><span>Patient</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="patient-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/pat/c_pat" :class="{'active' : $route.path==='/pat/c_pat'}">
              <i class="bi bi-circle"></i><span>Créer</span>
            </router-link>
          </li>
          <li>
            <router-link to="/pat/all_pat" :class="{'active' : $route.path==='/pat/all_pat'}">
              <i class="bi bi-circle"></i><span>Lister</span>
            </router-link>
          </li>
        </ul>
      </li><!-- End Patient Nav -->

      <li class="nav-item" v-if="current_role==='1011111001111101' || current_role==='0100000110000011'">
        <a :class="['nav-link',{'collapsed ' : !$route.path.startsWith('/per/')}]" data-bs-target="#personnel-nav" data-bs-toggle="collapse" href="#">
          <i class="bx bxs-user"></i><span>Personnel</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="personnel-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/per/c_per" :class="{'active' : $route.path==='/per/c_per'}">
              <i class="bi bi-circle"></i><span>Créer</span>
            </router-link>
          </li>
          <li>
            <router-link to="/per/all_per" :class="{'active' : $route.path==='/per/all_per'}">
              <i class="bi bi-circle"></i><span>Lister</span>
            </router-link>
          </li>
        </ul>
      </li><!-- End Personnel Nav -->

      <li class="nav-item" v-if="current_role==='1011111001111101' || current_role==='0100000110000011'">
        <a :class="['nav-link',{'collapsed ' : !$route.path.startsWith('/rdv/')}]" data-bs-target="#rdv-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-calendar-check"></i><span>Rendez-Vous</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="rdv-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/rdv/c_rdv" :class="{'active' : $route.path==='/rdv/c_rdv'}">
              <i class="bi bi-circle"></i><span>Programmé</span>
            </router-link>
          </li>
          <li>
            <router-link to="/rdv/all_rdv" :class="{'active' : $route.path==='/rdv/all_rdv'}">
              <i class="bi bi-circle"></i><span>Reçu</span>
            </router-link>
          </li>
        </ul>
      </li><!-- End RDV Nav -->

      <li class="nav-item" v-if="current_role==='1111100000011111'">
        <a :class="['nav-link',{'collapsed ' : !$route.path.startsWith('/rdvp/')}]" data-bs-target="#rdvp-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-calendar-check"></i><span>Rendez-Vous</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="rdvp-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/rdvp/c_rdv" :class="{'active' : $route.path==='/rdvp/c_rdv'}">
              <i class="bi bi-circle"></i><span>Demander</span>
            </router-link>
          </li>
          <li>
            <router-link to="/rdvp/all_rdv" :class="{'active' : $route.path==='/rdvp/all_rdv'}">
              <i class="bi bi-circle"></i><span>Listes</span>
            </router-link>
          </li>
        </ul>
      </li><!-- End RDV PATIENT Nav -->

      <li class="nav-item" v-if="current_role==='1011111001111101' || current_role==='0100000110000011'">
        <a :class="['nav-link',{'collapsed ' : !$route.path.startsWith('/med/')}]" data-bs-target="#medicament-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-capsule text-primary"></i><span>Medicament</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="medicament-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/med/c_cat" :class="{'active' : $route.path==='/med/c_cat'}">
              <i class="bi bi-circle"></i><span>Créer Categorie</span>
            </router-link>
          </li>
          <li>
            <router-link to="/med/c_med" :class="{'active' : $route.path==='/med/c_med'}">
              <i class="bi bi-circle"></i><span>Créer Medicament</span>
            </router-link>
          </li>
          <li>
            <router-link to="/med/all_cat" :class="{'active' : $route.path==='/med/all_cat'}">
              <i class="bi bi-circle"></i><span>Lister Categorie</span>
            </router-link>
          </li>
          <li>
            <router-link to="/med/all_med" :class="{'active' : $route.path==='/med/all_med'}">
              <i class="bi bi-circle"></i><span>Lister Medicament</span>
            </router-link>
          </li>
        </ul>
      </li><!-- End Medicament Nav -->

      <li class="nav-item" v-if="current_role==='1011111001111101' || current_role==='0100000110000011'">
        <a :class="['nav-link',{'collapsed ' : !$route.path.startsWith('/ser/')}]" data-bs-target="#service-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-box-seam"></i><span>Gestion des services</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="service-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/ser/c_ser" :class="{'active' : $route.path==='/ser/c_ser'}">
              <i class="bi bi-circle"></i><span>Créer</span>
            </router-link>
          </li>
          <li>
            <router-link to="/ser/all_ser" :class="{'active' : $route.path==='/ser/all_ser'}">
              <i class="bi bi-circle"></i><span>Lister</span>
            </router-link>
          </li>
        </ul>
      </li><!-- Service Nav -->

      <li class="nav-item" v-if="current_role==='1011111001111101' || current_role==='0100000110000011'">
        <a :class="['nav-link',{'collapsed ' : !$route.path.startsWith('/exa/')}]" data-bs-target="#examen-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-file-earmark-medical"></i><span>Gestion des Examens</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="examen-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/exa/c_exa" :class="{'active' : $route.path==='/exa/c_exa'}">
              <i class="bi bi-circle"></i><span>Créer</span>
            </router-link>
          </li>
          <li>
            <router-link to="/exa/all_exa" :class="{'active' : $route.path==='/exa/all_exa'}">
              <i class="bi bi-circle"></i><span>Lister</span>
            </router-link>
          </li>
        </ul>
      </li><!-- Examen Nav -->

      <li class="nav-item" v-if="current_role==='1011111001111101' || current_role==='0100000110000011'">
        <a :class="['nav-link',{'collapsed ' : !$route.path.startsWith('/ele/')}]" data-bs-target="#element-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-file-earmark-medical"></i><span>Elements Caisse</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="element-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/ele/c_ele" :class="{'active' : $route.path==='/ele/c_ele'}">
              <i class="bi bi-circle"></i><span>Créer</span>
            </router-link>
          </li>
          <li>
            <router-link to="/ele/all_ele" :class="{'active' : $route.path==='/ele/all_ele'}">
              <i class="bi bi-circle"></i><span>Lister</span>
            </router-link>
          </li>
        </ul>
      </li><!-- Element Caisse Nav -->

      <li class="nav-item" v-if="current_role==='1011111001111101' || current_role==='0100000110000011'">
        <a :class="['nav-link',{'collapsed ' : !$route.path.startsWith('/con/')}]" data-bs-target="#consultation-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-badge"></i><span>Consultation</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="consultation-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/con/c_con" :class="{'active' : $route.path==='/con/c_con'}">
              <i class="bi bi-circle"></i><span>Créer</span>
            </router-link>
          </li>
          <li>
            <router-link to="/con/all_con" :class="{'active' : $route.path==='/con/all_con'}">
              <i class="bi bi-circle"></i><span>Lister</span>
            </router-link>
          </li>
          <li>
            <router-link to="/con/res_labo" :class="{'active' : $route.path==='/con/res_labo'}">
              <i class="bi bi-circle"></i><span>Resultat Labo</span>
            </router-link>
          </li>
        </ul>
      </li><!-- Consultation Nav -->

      <li class="nav-item" v-if="current_role==='1011111001111101' || current_role==='0100000110000011' || current_role==='0011100000011100'">
        <a :class="['nav-link',{'collapsed ' : !$route.path.startsWith('/labo/')}]" data-bs-target="#laboratoire-nav" data-bs-toggle="collapse" href="#">
          <i class="bx bxs-flask"></i><span>Laboratoire</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="laboratoire-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/labo/c_exam" :class="{'active' : $route.path==='/labo/c_exam'}">
              <i class="bi bi-circle"></i><span>Créer</span>
            </router-link>
          </li>
          <li>
            <router-link to="/labo/all_exam" :class="{'active' : $route.path==='/labo/all_exam'}">
              <i class="bi bi-circle"></i><span>Lister</span>
            </router-link>
          </li>
        </ul>
      </li><!-- Laboratoire Nav -->

      <!--caisse-->
      <li class="nav-item" v-if="current_role==='1011111001111101' || current_role==='0100000110000011'">
        <a :class="['nav-link',{'collapsed ' : !$route.path.startsWith('/caisse/')}]" data-bs-target="#caisse-nav" data-bs-toggle="collapse" href="#">
          <i class="bx bxs-wallet"></i><span>Caisse</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="caisse-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/caisse/c_caisse" :class="{'active' : $route.path==='/caisse/c_caisse'}">
              <i class="bi bi-circle"></i><span>Operation</span>
            </router-link>
          </li>
          <li>
            <router-link to="/caisse/all_caisse" :class="{'active' : $route.path==='/caisse/all_caisse'}">
              <i class="bi bi-circle"></i><span>Liste</span>
            </router-link>
          </li>
          
        </ul>
      </li><!-- Caisse Nav -->

      <!--ETATS-->
      <li class="nav-item" v-if="current_role==='1011111001111101' || current_role==='0100000110000011'">
        <a :class="['nav-link',{'collapsed ' : !$route.path.startsWith('/etats/')}]" data-bs-target="#etats-nav" data-bs-toggle="collapse" href="#">
          <i class="bx bxs-file"></i><span>Etats</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="etats-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <router-link to="/etats/dm" :class="{'active' : $route.path==='/etats/dm'}">
              <i class="bi bi-circle"></i><span>Dossier Medical</span>
            </router-link>
          </li>
          
        </ul>
      </li><!-- ETATS Nav -->

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <router-link to="/profile" class="nav-link" :class="{'collapsed' : $route.path!='/profile'}">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </router-link>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item" v-if="current_role==='1111100000011111'">
        <router-link to="/dmp" class="nav-link" :class="{'collapsed' : $route.path!='/dmp'}">
          <i class="bi bi-envelope"></i>
          <span>Mon Dossier</span>
        </router-link>
      </li><!-- End Welcome Page Nav -->

      <li class="nav-item">
        <router-link to="/FAQ" class="nav-link" :class="{'collapsed' : $route.path!='/FAQ'}">
          <i class="bi bi-question-circle"></i>
          <span>F.A.Q</span>
        </router-link>
      </li><!-- End F.A.Q Page Nav -->


      <!-- <li class="nav-item">
        <router-link to="/welcome" class="nav-link" :class="{'collapsed' : $route.path!='/welcome'}">
          <i class="bi bi-envelope"></i>
          <span>Welcome</span>
        </router-link>
      </li>End Welcome Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->
</template>

<script>
export default{
        data(){
            return{
                current_token:localStorage.getItem('current_token'),
                current_nom:localStorage.getItem('current_nom'),
                current_prenom:localStorage.getItem('current_prenom'),
                current_email:localStorage.getItem('current_email'),
                current_profil:localStorage.getItem('current_profil'),
                current_role:localStorage.getItem('current_role'), 
            }
        },
    }
</script>