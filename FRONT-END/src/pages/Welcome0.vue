<template>
  <div class="content">
    <div class="container-fluid">
      <div class="card align-self-center border-0 p-2 full-width">
        <div class="card-body border-0">
          <div class="row">
            <!-- Colonne pour le texte -->
            <div class="col-md-6 ">
              <h3 class="text-justify">
                
                Bienvenue sur notre application de gestion hospitalière ! Nous
                sommes ravis de vous voir vous connecter. Cette plateforme est
                conçue pour vous aider à gérer vos tâches et responsabilités
                de manière efficace et organisée. Si vous avez besoin
                d'assistance ou avez des questions, notre équipe de support
                est à votre disposition. Merci de faire partie de notre
                mission pour améliorer les soins aux patients.
              </h3>
            </div>
            <!-- Colonne pour l'image -->
            <div class="col-md-6">
              <div class="wa"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// Votre script JavaScript peut être ajouté ici si nécessaire
</script>

<style>
.wa {
  background-image: url("../assets/img/oo.png");
  background-size: cover;
  height: 0;
  padding-top: 75%; /* Ratio 4:3 (75% = 3/4 * 100) */
  width: 100%; /* Remplir toute la largeur de la colonne */

  /* Ajoutez d'autres styles au besoin */
}
.text-justify{
  text-align: justify;
}
@media (max-width: 576px) {
  .wa {
    height: 200px; /* Taille réduite pour les écrans de téléphone */
    padding-top: 0; /* Retirer le padding-top pour conserver la hauteur fixe */
  }
}
</style>
