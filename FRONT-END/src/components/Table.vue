<template>
  <div class="containerr">
      <div class='col-md-6'>
          <table class="table table-striped-columns table-bordered text-white">
              <thead>
                  <tr class='bg-success '>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Auteur</th>
                  <th scope="col">Price</th>
                  <th scope="col">Options</th>
                  </tr>
              </thead>
              <tbody >
                  <tr v-for="book in allBooks" :key="book.id">
                      <th scope="row">{{ book.id }}</th>
                      <td>{{ book.name }}</td>
                      <td>{{ book.author }}</td>
                      <td>{{ book.price }}</td>
                      <td><Options :book="book"/></td>
                  </tr>
                  
              </tbody>
          </table>
      </div>
      
  </div>
</template>

<script >

import Options from "./Options.vue";

export default {
  name:"Table",
  components:{Options},
  data(){
      return{
          allBooks:[],
      }
  },
  methods:{
      async fetchBooks(){
          const book = await fetch(
              "http://localhost:8000/api/books",
              {
                  method:"GET",
                  headers:{
                      "Content-type":"application/json",
                  },
              }
          );
          const Books = await book.json();
          return Books;
          
          
      },
      
  },
  async created() {
          this.allBooks = await this.fetchBooks();
  },
}


</script>

<style scope>

.containerr{
  display:flex;
  align-items:center;
  justify-content: center;
  background-color: teal;
}

</style>