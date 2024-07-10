<template>
    <div>
       <div class='modal fade' v-bind:id="dd" tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
               <div class='modal-dialog'>
                   <div class='modal-content text-dark'>
                       <div class='modal-header'>
                           <h1 class='modal-title fs-5' id='exampleModalLabel'>Edit book --{{ book_name }}</h1>
                           <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                       </div>
                       <form action="" @submit="updateBook">
                           <div class='modal-body'>
                               <div>
                                   <label for='name' class='form-label'>book name</label>
                                   <input type='text' v-model='book_name' class='form-control' id='name' placeholder='book name...' />
                               </div>
                               <div>
                                   <label for='slug' class='form-label'>book slug</label>
                                   <input type='text' v-model='book_slug' class='form-control' id='slug' placeholder='book slug...' />
                               </div>
                               <div>
                                   <label for='desc' class='form-label'>book desc</label>
                                   <input type='text' class='form-control' v-model='book_desc' id='desc' placeholder='book desc...' />
                               </div>
                               <div>
                                   <label for='author' class='form-label'>book author</label>
                                   <input type='text' class='form-control' v-model='book_author' id='desc' placeholder='book author...' />
                               </div>
                               <div>
                                   <label for='price' class='form-label'>book price</label>
                                   <input type='text' v-model='book_price' class='form-control' id='price' placeholder='book price...' />
                               </div> 
                           </div>
                           <div class='modal-footer'>
                               <button type='submit' class='btn btn-primary'>update book</button>
                               <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                           </div>
                       </form>
                           
                   </div>
           </div>
       </div>
   </div>
</template>

<script >

export default{
   name:'Edit',
   props:{
       book:Object,
   },
   data(){
       return {
           dd:"editModal"+this.book.id,
           book_id:this.book.id,
           book_name: this.book.name,
           book_slug:this.book.slug,
           book_desc:this.book.desc,
           book_author:this.book.author,
           book_price:this.book.price,
       };
   },
   mounted(){},
   async created() {},


   methods:{


       async updateBook(e){
           e.preventDefault();

           const updateBook = {
               name:this.book_name,
               slug:this.book_slug,
               desc:this.book_desc,
               author:this.book_author,
               price:this.book_price,
           };
           const res = await fetch(
               "http://localhost:8000/api/books/"+this.book.id,
               {
                   method:"POST",
                   headers:{
                       'Authorization': 'Bearer '+localStorage.getItem('current_token'),
                       'Accept': 'application/json',
                       'Content-Type': 'application/json;charset=utf-8',
                   },
                   body: JSON.stringify(updateBook)
               }
           );

           const data = await res.json();

           if(res.status === 401){
               alert(data.message + " Please login first !");
           }else{
               alert("Data updated !!!");
               location.reload();
           }
           
           
       },
       
   },
};

</script>

<style>

</style>