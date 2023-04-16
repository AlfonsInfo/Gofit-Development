
<script>
import { defineComponent } from 'vue'
// import { useRouter } from 'vue-router';

export default defineComponent({
    name: 'home-navbar',
    setup(){
        // const router = useRouter('router'); //tidak boleh dalam fungsi login karena fungsi login await(event callback)
        }        
    });
</script>
<template>
  <main>
    <nav class="navbar bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      Selamat Datang Di Aplikasi Gofit
    </a>
  </div>
</nav>
</main>
</template>

