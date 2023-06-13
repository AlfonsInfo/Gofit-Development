<script>
import { defineComponent } from 'vue'
import { useRouter } from 'vue-router';
import { getImageUrl } from '../data/staticData';


export default defineComponent({
    name: 'menu-card',
    props : ['data'],
    setup(){
        const router = useRouter('router'); 
        
        const navigateToPage =   () => {
            // * Bersihkan LocalStorage
            localStorage.clear();
            // Redirect kehalaman luar
            router.push({name:'login'})
        }
        const clickNavigateEvent = ($event) => {
          console.log('click')
          console.log($event)
        }

        
        return{
            navigateToPage,
            clickNavigateEvent,
        }
    }
    });
</script>

<template >
  <!-- style="width: 18rem;" -->
  <div v-for="(items,key) in data" class="col-12 col-md-3 p-2 m-auto"  :key = "key">
    <div     @click="clickNavigateEvent" class="card text-dark mt-5 " > 
      <!-- items.imageLink -->
      <img   :src="items.imageLink" class="card-img-top " style="height: 30%;" alt="...">
    <div class="card-body">
      <h5 class="card-title ">  
        {{items.title}}
      </h5>
      <p class="card-text">
        {{items.description}}
      </p>
      <div class="mt-auto d-flex justify-content-start">
        <router-link  :to="{name: items.route}" class="mdi mdi-location-enter mt-auto p-2 rounded"> Masuk</router-link>
        </div>
      </div>
    </div>
  </div>
  </template>

<style>

</style>




