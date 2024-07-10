<template>
  <Header/>

  <Menu/>

  <main id="main" class="main">
    <router-view></router-view>
  </main><!-- End #main -->

  <Footer/>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
</template>
  
  <script setup>
  import Footer from '@/components/Layouts/Footer.vue';
  import Header from '@/components/Layouts/Header.vue';
  import Menu from '@/components/Layouts/Menu.vue';
  </script>
  
  <style scoped>

  </style>