<template>
  <div class="pt-4 pb-2">
    <h5 class="card-title text-center pb-0 fs-4">
      Reinitialisez votre compte
    </h5>
    <p class="text-center small">
      Entrez votre nouveau mot de passe
    </p>
  </div>

  <form class="row g-2 needs-validation" @submit="login">
    <div class="col-12">
      <label for="password" class="form-label">Password</label>
      <input
        type="password"
        v-model="password"
        class="form-control"
        id="password"
        placeholder="..."
      />
      <span style="color: red">{{ error_password }}</span>
    </div>
    <div class="col-12">
      <label for="cpassword" class="form-label">Confirmation Password</label>
      <input
        type="password"
        v-model="cpassword"
        class="form-control"
        id="cpassword"
        placeholder="..."
      />
      <span style="color: red">{{ error_cpassword }}</span>
    </div>

    <div class="col-12">
      <button class="btn btn-primary w-100" type="submit">Reinitialiser</button>
    </div>
    <div class="col-12">
      <p class="small mb-0">
        <router-link to="/login">Se connecter ? </router-link>
      </p>
    </div>
  </form>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      password: "",
      cpassword: "",
      error_password: "",
      error_cpassword: "",
    };
  },
  methods: {
    async login(e) {
      e.preventDefault();
      const token = this.$route.params.token;
      const user = {
        cpassword: this.cpassword,
        password: this.password,
        token: token,
      };

      try {
        const res = await fetch(
          "http://localhost:8000/api/reset",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "Accept": "application/json",
              "Access-Control-Allow-Origin": "*",
              "Access-Control-Allow-Headers":"Origin, X-Requested-With, Content-Type, Accept",
            },
            body: JSON.stringify(user),
          }
        );

        if (res.status === 422) {
          const error_msg = await res.json();

          this.error_cpassword = error_msg.errors.cpassword
            ? error_msg.errors.cpassword[0]
            : "";
          this.error_password = error_msg.errors.password
            ? error_msg.errors.password[0]
            : "";
        } else if (res.status === 401) {
          const error_msg = await res.json();
          this.error_cpassword = error_msg.message || "";
        } else {
          const login_user = await res.json();
          alert('Mot de passe reinitialiser avec succes, Suivant pour vous connecter');
          this.$router.push('/');
        }
      } catch (error) {
        console.error("There was a problem with the fetch operation:", error);
      }
    },
  },
};
</script>

<style></style>
