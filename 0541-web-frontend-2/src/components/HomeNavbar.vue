r
<script>
import { defineComponent } from 'vue'
import LogoutButton from '../components/LogoutButton.vue';
import BackButton from '../components/BackButton.vue';

import { useRouter } from 'vue-router';

export default defineComponent({
    props : ['message'],
    name: 'home-navbar',
    setup(){
        const router = useRouter('router'); //tidak boleh dalam fungsi login karena fungsi login await(event callback)
        const backHome =   () => {
            router.push({name:'Home'})
        }  

        return {
          backHome
        }
      },        
    components :{
      LogoutButton,
      BackButton,
    }
    });

</script>
<template>
  <main>
    <nav class="navbar bg-dark">
  <div class="container-fluid"> 
    <!-- maybe hilangkan fluid agar ditengah -->
    <a class="navbar-brand text-white" @click="backHome">
      {{ message }}
    </a>
    <div class="d-flex my-2">
      <logout-button class="mx-5"></logout-button>
      <back-button style="display: none;"></back-button>
    </div>

  </div>
</nav>
</main>
</template>

