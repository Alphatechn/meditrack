<template>
  <div id="app">
    <h1 class="header h1">BIENVENUE SUR MEDITRACK</h1>
    <h2 class="section__title">Nos modules:</h2>

    <main class="main">
      <div class="container">
        <section class="section">
          <h2 class="section__title">Module patients</h2>
          <div class="section__item">
            <h3 class="item__title">Enregistrement du patient</h3>
            <p class="item__description">
              Les patients sont enregistrés dans le système lors de leur arrivée
              à l'hôpital. Les informations saisies incluent les données
              d'identification, les antécédents médicaux et les coordonnées.
            </p>
            <h3 class="item__title">Comment faire?</h3>
            <p class="item__description">
              Sur l'onglet "patient", cliquer sur "creer", ensuite basculer sur
              "Antécédents&Groupe sanguins" et y remplir les antecedents et
              cliquer sur "Enregistrer"
            </p>
          </div>
          <div class="section__item">
            <h3 class="item__title">Transfert patient</h3>
            <p class="item__description">
              Une fois le patient enregistrer, il peut etre transferer dans un
              service(laboratoire,chirugie etc...) en fonction du probleme posé.
            </p>
            <h3 class="item__title">Comment faire?</h3>
            <p class="item__description">
              Sur l'onglet "patient", cliquer sur "lister" rechercher le nom du
              patient à transferer puis cliquer sur le bouton "vert", donner le
              motif et le service dans lequel vous voulez le transférer puis
              valider.
            </p>
          </div>
        </section>
        <section class="section">
          <h2 class="section__title">Module personnel medical</h2>
          <div class="section__item">
            <h3 class="item__title">Enregistrement du personnel</h3>
            <p class="item__description">
              Le personnel medical est enregistré dans le système lors de leur
              prise de fonction à l'hôpital. Les informations saisies incluent
              les données d'identification, le service dans lequel il exercera
              sa fonction,la date d'embauche et les coordonnées
            </p>
          </div>
          <div class="section__item">
            <h3 class="item__title">
              Gestion des patients recu dans les services
            </h3>
            <p class="item__description">
              chaque consultation est propre à un service par exemple la
              consultation chirugicale n'est pas la meme qu'en medecine generale
              ou maternite,chaque service à ses prérequis
            </p>
          </div>
          <div class="section__item">
            <h3 class="item__title">
              paiements avec notification vers le service transferé
            </h3>
            <p class="item__description">
              le patient doit payé au préalable la consultation avant d'etre
              recu
            </p>
          </div>
        </section>

        <section
          class="section"
          v-if="
            current_role === '1011111001111101' ||
            current_role === '0100000110000011' ||
            current_role === '0100111110111011'
          "
        >
          <h2 class="section__title">Module caisse</h2>
          <div class="section__item">
            <h3 class="item__title">Paiement des frais medicaux</h3>
            <p class="item__description">
              Avant d'effectuer un quelconque soins le patient concernés devra
              passer à la caisse
            </p>
          </div>
        </section>

        <section class="section">
          <h2 class="section__title">Communication avec les patients</h2>
          <div class="section__item">
            <h3 class="item__title">Accès au dossier médical</h3>
            <p class="item__description">
              Les patients peuvent consulter leur dossier médical en ligne et
              obtenir des informations sur leur état de santé, les traitements
              prescrits et l'évolution de leur cas.
            </p>
          </div>
          <div class="section__item">
            <h3 class="item__title">Échanges avec le personnel médical</h3>
            <p class="item__description">
              Les patients peuvent obtenir des rendez-vous avec un medecin via
              l'application , faire part de leurs préoccupations ou obtenir des
              conseils.
            </p>
          </div>
        </section>

        <section class="section">
          <h2 class="section__title">Module dossier medical</h2>
          <div class="section__item">
            <h3 class="item__title">Formation du dossier medical</h3>
            <p class="item__description">
              des l'enregistrement des donneees telque nom, antecents du
              patient, le dossier medical comme a etre rediger et s'en suit des
              differents examen effectuer les resultats,les prescription ains
              que les rendez-vous
            </p>
          </div>
          <div class="section__item">
            <h3 class="item__title">Impression du dossier medical</h3>
            <p class="item__description">
              possibilite pour le patient et medecin concernes d'imprimer le
              dossier medicale
            </p>
            <h3 class="item__title">Comment faire?</h3>
            <p class="item__description">
              Sur l'onglet "Etats", cliquer sur "dossier medical" puis cliquer
              sur le bouton "imprimer".
            </p>
          </div>
          <div class="section__item">
            <h3 class="item__title">Gestion des ordonnances et traitements</h3>
            <p class="item__description">
              Les ordonnances et les traitements prescrits par les médecins sont
              enregistrés dans le dossier médical du patient. Le suivi de la
              prise de médicaments est assuré.
            </p>
          </div>
        </section>
        <section class="section">
          <h2 class="section__title">Module prise de rendez-vous</h2>
          <div class="section__item">
            <h3 class="item__title">Enregistrement d'un rendez-vous</h3>
            <p class="item__description">
              Ici, le patient a acces a une interface qui le permet de demander
              un rendez-vous, il enregistrera la date,l'heure le medecin
              concernés,le motif de consultation,ainsi que les notes
            </p>
            <h3 class="item__title">Comment faire?</h3>
            <p class="item__description">
              Sur l'onglet "rendez-vous", cliquer sur "Demander" ,ensuite
              renseigner les informations et cliquer sur le bouton
              "Enregistrer".
            </p>
          </div>
          <div class="section__item">
            <h3 class="item__title">Validation du rendez-vous</h3>
            <p class="item__description">
              apres la demande du rendez-vous par le patient,le medecin concerné
              est notifier et donne une reponse
            </p>
            <h3 class="item__title">Comment faire?</h3>
            <p class="item__description">
              Sur l'onglet "liste rendez-vous recu ", cliquer sur
              "traiter",ensuite choisir "approuve" ou "reporter" puis cliquer
              sur le bouton "enregistrer". le patient concerne est notifier de
              la reponse du medecin
            </p>
          </div>
        </section>
        <section class="section">
          <h2 class="section__title">Module Utilisateur</h2>
          <div class="section__item">
            <h3 class="item__title">
              parametres de connexion des l'utilisateurs
            </h3>
            <p class="item__description">
              l'utilisateur voulant acceder a notre apllication MEDITRACK devra
              avoir au prealable son email est son mot de passe. l'email qui est
              donne a la secretaire medicale lors de l'enregistrement et un
              premier mot de passe qui est generer et envoyer par mail.
            </p>
            <h3 class="item__title">Comment faire?</h3>
            <p class="item__description">
              Acceder a l'application ,l'interface de connexion se
              presentera,ensuite renseigner les informations et cliquer sur le
              bouton "Se connecter".
            </p>
          </div>
          <div class="section__item">
            <h3 class="item__title">profil de l'utilisateur</h3>
            <p class="item__description">
              Pour visualiser ses informations personnelles
            </p>
            <h3 class="item__title">Comment faire?</h3>
            <p class="item__description">
              Sur l'onglet "profile ", cliquer sur "apercu"
            </p>
          </div>
          <div class="section__item">
            <h3 class="item__title">information de l'utilisateur</h3>
            <p class="item__description">
              Pouvoir modifier ses informations personnelles en cas d'erreur et
              inscrire la bonne
            </p>
            <h3 class="item__title">Comment faire?</h3>
            <p class="item__description">
              Sur l'onglet "profile ", cliquer sur "Editer le profile". changer
              le champs ayant un probleme et cliquer sur "Enregistrer"
            </p>
          </div>
          <div class="section__item">
            <h3 class="item__title">mot de passe de l'utilisateur</h3>
            <p class="item__description">
              Pouvoir modifier le mot de passe generer par l'application
            </p>
            <h3 class="item__title">Comment faire?</h3>
            <p class="item__description">
              Sur l'onglet "profile ", cliquer sur "changer le mot de
              passe",renseigner les champs demander et cliquer sur "Enregistrer"
            </p>
          </div>
        </section>
      </div>
    </main>
  </div>
</template>
<script>
export default {
  data() {
    return {
      current_role: localStorage.getItem("current_role"),
    };
  },
};
</script>
<style>
/* Reset styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.h1 {
  font-size: 42px;
  font-weight: bold;
  color: #070707;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border-bottom: 3px solid #34495e;
  padding-bottom: 10px;
}

/* Header styles */
.header {
  background-color: #fcfeff;
  padding: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  /* Hauteur initiale du header */
}

.header__title {
  font-size: 36px;
  font-weight: bold;
  color: #050404;
}

/* Main content styles */
.main {
  padding: 40px 0;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.section {
  margin-bottom: 40px;
}

.section__title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 20px;
}

.section__item {
  padding: 20px;
  background-color: #f5f5f5;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  margin-bottom: 20px;
}

.item__title {
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 10px;
}

.item__description {
  font-size: 16px;
}
</style>
