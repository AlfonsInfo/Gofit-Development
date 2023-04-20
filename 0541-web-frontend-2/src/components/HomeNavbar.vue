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
        const router = useRouter('router'); 
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

