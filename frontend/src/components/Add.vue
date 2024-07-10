<template>
  <div class="container1">
      <div class="col-md-5 mb-3">
          <h3>Add book</h3>
          <form @submit="add_book">
             <div>
              <label for="name" class="form-label">book name</label>
              <input type="text" v-model="name" class="form-control" id="name" placeholder="Book name..." />
              <span style="color:yellow" >{{ error_name }}</span>
              </div>
              <div>
                  <label for="author" class="form-label">Author</label>
                  <input type="text" class="form-control" v-model="author" id="author" placeholder="Book's author...." />
                  <span style="color:yellow" >{{ error_author }}</span>
              </div>
              <div>
                  <label for="desc" class="form-label">Description</label>
                  <input type="text" v-model="desc" class="form-control" id="desc" placeholder="Book Description..." />
                  <span style="color:yellow" >{{ error_desc }}</span>
              </div>
              <div>
                  <label for="price" class="form-label">Price</label>
                  <input type="text" v-model="price" class="form-control" id="price" placeholder="your Price..." />
                  <span style="color:yellow" >{{ error_price }}</span>
              </div> 
              <div>
                  <button class='btn btn-danger mt-2'>Add book</button>
              </div> 
          </form>
          
          
      </div>
  </div>
</template>

<script >

export default{
  name:"Add",
  data(){
      return {
          name: "",
          author:"",
          desc:"",
          price:"",
          error_name:"",
          error_author:"",
          error_desc:"",
      };
  },
  methods:{
      

      async add_book(e){
          e.preventDefault();

          if(typeof localStorage.getItem('current_token') === 'undefined' || localStorage.getItem('current_token') === null )
          {
                   alert("please login first !!!");
                   location.href = 'http://127.0.0.1:5173/login';   
          }
          else{
              const book = {
                      name:this.name,
                      author:this.author,
                      desc:this.desc,
                      price:this.price,
                  };

                  let res;
                  res = await fetch(
                      "http://localhost:8000/api/books",
                      {
                          method:"POST",
                          headers:{
                              'Authorization': 'Bearer '+localStorage.getItem('current_token'),
                              'Accept': 'Application/json',
                              'Content-Type': 'Application/json;charset=utf-8',
                          },
                          body: JSON.stringify(book)
                      }
                      );

                  if(res.status === 422){
                      const error_msg = await res?.json();

                      console.log(error_msg);

                      if (typeof error_msg.errors.name === 'undefined' || error_msg.errors.name === null) {
                          this.error_name="";
                      }else{
                          this.error_name = error_msg.errors.name[0];
                      }
                      if (typeof error_msg.errors.author === 'undefined' || error_msg.errors.author === null) {
                          this.error_author="";
                      }else{
                          this.error_author = error_msg.errors.author[0];
                      }
                      if (typeof error_msg.errors.desc === 'undefined' || error_msg.errors.desc === null) {
                          this.error_desc="";
                      }else{
                          this.error_desc = error_msg.errors.desc[0];
                      }
                      if (typeof error_msg.errors.price === 'undefined' || error_msg.errors.price === null) {
                          this.error_price="";
                      }else{
                          this.error_price = error_msg.errors.price[0];
                      }
                      
                  }
                  else{

                      const registed_user = await res?.json();

                      this.name= "";
                      this.author= "";
                      this.desc= "";
                      this.price= "";

                      this.error_name= "";
                      this.error_author= "";
                      this.error_desc= "";
                      this.error_price= "";

                      alert("Book saved !!!");

                      }
          }
          

      },

  },
};
</script>

<style>
.container1{
  height:100vh;
  display:flex;
  align-items:center;
  justify-content: center;
  background-color: teal;
}
</style>