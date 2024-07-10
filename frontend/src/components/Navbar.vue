<template>
  <div>
      <nav class="navbar navbar-expand-lg bg-light">
          <div class="container-fluid">
              <a class="navbar-brand" href="/">Home</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="/home">All books</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link " aria-current="page" href="/add_book">Add book</a>
                  </li>
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="display:flex" v-if="this.current_token">
                      <a class="nav-link" @click="logout" href="#">{{ this.current_name }} | Logout</a>
                  </ul>
                  <li class="nav-item" v-if="!this.current_token">
                      <a class="nav-link"  href="/login">Login/Register</a>
                  </li>
              </ul>
              </div>
          </div>
      </nav>
      <router-view />
  </div>

  

</template>

<script >



export default{
  data(){
      return{
          current_token:localStorage.getItem('current_token'),
          current_name:localStorage.getItem('current_name'),
          current_email:localStorage.getItem('current_email'),
      }
  },
  methods:{
      async logout(e){
          e.preventDefault();

          let res;
          res = await fetch(
              "http://localhost:8000/api/logout",
              {
                  method:"POST",
                  headers:{
                      'Authorization': 'Bearer '+this.current_token,
                  },
              }
          );

          const error_msg = await res?.json();
          
          delete localStorage.current_token;
          delete localStorage.current_name;
          delete localStorage.current_email;
          alert(error_msg.message);
          location.reload();
      }
  }
  
}


</script>

<style scope>



</style>