
<script>
import { defineComponent } from 'vue'
import LogoutButton from '../components/LogoutButton.vue';

// import { useRouter } from 'vue-router';

export default defineComponent({
    props : ['message'],
    name: 'home-navbar',
    setup(){
        // const router = useRouter('router'); //tidak boleh dalam fungsi login karena fungsi login await(event callback)
        },        
    components :{
      LogoutButton,
    }
    });

</script>
<template>
  <main>
    <nav class="navbar bg-dark">
  <div class="container-fluid"> 
    <!-- maybe hilangkan fluid agar ditengah -->
    <a class="navbar-brand text-white" href="#">
      {{ message }}
    </a>
    <logout-button></logout-button>

  </div>
</nav>
</main>
</template>

