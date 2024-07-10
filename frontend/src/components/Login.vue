<template>
  <div class="pt-4 pb-2">
    <h5 class="card-title text-center pb-0 fs-4">
      Connectez-vous à votre compte
    </h5>
    <p class="text-center small">
      Entrez votre E-mail et votre mot de passe pour vous connecter
    </p>
  </div>

  <form class="row g-2 needs-validation" @submit="login">
    <div class="col-12">
      <label for="email" class="form-label">E-mail</label>
      <div class="input-group has-validation">
        <span class="input-group-text" id="inputGroupPrepend">@</span>
        <input
          type="email"
          v-model="email"
          class="form-control"
          id="email"
          placeholder="name@example.com"
        />
        <br />
      </div>
      <span style="color: red">{{ error_email }}</span>
    </div>

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
      <div class="form-check">
        <input
          class="form-check-input"
          type="checkbox"
          name="remember"
          value="true"
          id="rememberMe"
        />
        <label class="form-check-label" for="rememberMe"
          >Se souvenir de moi</label
        >
      </div>
    </div>
    <div class="col-12">
      <button class="btn btn-primary w-100" type="submit">Se Connecter</button>
    </div>
    <div class="col-12">
      <p class="small mb-0">
        <router-link to="/forgetpass">Mot de passe oublié ? </router-link>
      </p>
    </div>
  </form>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      email: "",
      password: "",
      error_email: "",
      error_password: "",
    };
  },
  methods: {
    async login(e) {
      e.preventDefault();

      const user = {
        email: this.email,
        password: this.password,
      };

      try {
        const res = await fetch(
          "http://localhost:8000/api/login",
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

          this.error_email = error_msg.errors.email
            ? error_msg.errors.email[0]
            : "";
          this.error_password = error_msg.errors.password
            ? error_msg.errors.password[0]
            : "";
        } else if (res.status === 401) {
          const error_msg = await res.json();
          this.error_email = error_msg.message || "";
          this.error_password = error_msg.messa || "";
        } else {
          const login_user = await res.json();
          localStorage.setItem("current_token", login_user.token);
          localStorage.setItem("current_iduser", login_user.user.id);
          localStorage.setItem("current_nom", login_user.user.nom);
          localStorage.setItem("current_prenom", login_user.user.prenom);
          localStorage.setItem("current_profil", login_user.user.profil);
          localStorage.setItem(
            "current_fonction",
            login_user.type_user.libelle
          );
          localStorage.setItem("current_role", login_user.type_user.role);
          localStorage.setItem("current_email", login_user.user.email);
          if (login_user.appartenir != "") {
            localStorage.setItem("current_idser", login_user.appartenir.id_ser);
            localStorage.setItem("current_idper", login_user.personnel.id);
          } else {
            localStorage.setItem("current_idpat", login_user.patient.id);
          }

          this.email = "";
          this.password = "";
          this.$router.push('/home');
          // location.href = "";
        }
      } catch (error) {
        console.error("There was a problem with the fetch operation:", error);
      }
    },
  },
};
</script>

<style></style>
