<template>
  <div class="home-container">
    <div class="card">
      <div class="text-container">
        <h1>Bienvenue sur notre application de gestion hospitalière ! Nous
          sommes ravis de vous voir vous connecter. Cette plateforme est
          conçue pour vous aider à gérer vos tâches et responsabilités
          de manière efficace et organisée. Si vous avez besoin
          d'assistance ou avez des questions, notre équipe de support
          est à votre disposition. Merci de faire partie de notre
          mission pour améliorer les soins aux patients.</h1>
      </div>
      <div class="image-container">
        <img src="../assets/img/oo.png" alt="Hospital Image" class="side-image">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Home'
};
</script>

<style scoped>
.home-container {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  height: 100vh;
  padding: 30px;
  margin: -30px -30px -50px -30px;
    /* background-color: #f4f4f9; */
  background-image: url('../assets/img/ap/ac.png'); /* Add this line for background image */
  background-size: cover; /* Ensure the image covers the whole container */
  background-position: center; /* Center the background image */
}

.card {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  background-color: rgba(245, 238, 238, 0.87);
  border-radius: 10px;
  border: 3px solid rgba(4, 53, 251, 0.841);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 20px;
  max-width: 1200px;
  width: 100%;
  margin-top: 20px;
  flex-direction: row;
}

.text-container {
  flex: 1;
  text-align: justify;
  padding: 20px;
}

.image-container {
  flex: 0 1 40%; /* Ensure the image container takes up to 40% of the space */
  display: flex;
  justify-content: center;
  align-items: flex-start;
  padding: 20px;
}

.side-image {
  max-width: 100%;
  height: auto;
  border-radius: 10px;
}

h1 {
  color: #333;
  font-size: 2em;
}

@media (max-width: 1200px) {
  .card {
    flex-direction: row;
  }
  
  .text-container, .image-container {
    flex: 1;
    padding: 10px;
  }

  h1 {
    font-size: 1.5em;
  }
}

@media (max-width: 768px) {
  .card {
    flex-direction: column;
  }

  .text-container, .image-container {
    width: 100%;
    margin-bottom: 20px;
  }
}
</style>
