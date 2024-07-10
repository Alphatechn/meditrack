<template>
    <div class="pt-4 pb-2">
      <h5 class="card-title text-center pb-0 fs-4">Vous avez oublié votre mot de passe ?</h5>
      <p class="text-center small">Ici, vous pouvez facilement récupérer un nouveau mot de passe.</p>
    </div>
  
    <form class="row g-3 needs-validation" @submit.prevent="forgotpass">
      <div class="col-12">
        <label for="email" class="form-label">E-mail</label>
        <div class="input-group has-validation">
          <span class="input-group-text" id="inputGroupPrepend">@</span>
          <input type="email" v-model="email" class="form-control" id="email" placeholder="name@example.com"> <br>
        </div>
        <span style="color:red">{{ error_email }}</span>
      </div>
      <div class="col-12">
        <button class="btn btn-primary w-100" type="submit">Demandez un nouveau mot de passe</button>
      </div>
      <div class="col-12">
        <p class="small mb-0">
          <router-link to="/">Connexion</router-link>
        </p>
      </div>
    </form>
  </template>
  
  <script>
  import { ref } from 'vue';
  import { useRoute } from 'vue-router';
  
  export default {
    name: "renew",
    setup() {
      const route = useRoute();
      const email = ref("");
      const error_email = ref("");
  
      const forgotpass = async (e) => {
        e.preventDefault();
  
        const user = {
          email: email.value,
        };
  
        try {
          let res = await fetch("http://localhost:8000/api/forgotpass", {
            method: "POST",
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json;charset=utf-8',
            },
            body: JSON.stringify(user),
          });
  
          console.log('HTTP Status:', res.status); // Ajout de débogage
  
          if (res.status === 422) {
            const error_msg = await res.json();
            error_email.value = error_msg.errors?.email?.[0] || "";
          } else if (res.status === 401) {
            const error_msg = await res.json();
            alert(error_msg.message);
          } else if (res.ok) {
            alert("Demande de réinitialisation envoyée. Veuillez vous connecter à votre compte GMAIL.");
            location.href = '/';
          } else {
            console.log('HTTP Response:', res); // Ajout de débogage
            alert("Erreur inconnue.");
          }
        } catch (error) {
          console.error('Erreur pendant la demande de réinitialisation :', error);
          error_email.value = "Erreur de connexion";
        }
      };
  
      return {
        email,
        error_email,
        forgotpass,
      };
    },
  };
  </script>
  
  <style>
  /* Ajoutez vos styles ici */
  </style>
  