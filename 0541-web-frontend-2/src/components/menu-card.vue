<script>
import { defineComponent } from 'vue'
import { useRouter } from 'vue-router';
// import VTooltip from 'v-tooltip';


export default defineComponent({
    // directives : {'tooltip' :VTooltip.directives},
    name: 'menu-card',
    props : ['data'],
    setup(){
        const router = useRouter('router'); 
        
        const navigateToPage =   () => {
            // * Debugging
            // * Bersihkan LocalStorage
            localStorage.clear();
            // Redirect kehalaman luar
            router.push({name:'login'})
        }
        const hoverEvent = ($event) => {
          console.log($event)
        }

        const clickNavigateEvent = ($event) => {
          console.log('click')
          console.log($event)
        }
        
        return{
            navigateToPage,
            clickNavigateEvent,
            hoverEvent
        }
    }
    });
</script>

<template >
  <!-- style="width: 18rem;" -->
  <div v-for="(items,key) in data" class="col-12 col-md-3 p-2"  :key = "key">
    <div  @hover="hoverEvent($event)" v-tooltip="'testing text'"  @click="clickNavigateEvent" class="card text-dark mt-5 " > 
      <!-- items.imageLink -->
      <img   :src="items.imageLink" class="card-img-top " style="height: 40%;" alt="...">
    <div class="card-body">
      <h5 class="card-title ">  
        {{items.title}}
      </h5>
      <p class="card-text">
        {{items.description}}
      </p>
      <div class="mt-auto d-flex justify-content-start">
        <router-link  :to="{name: items.route}" class="mdi mdi-location-enter mt-auto"> Masuk</router-link>
          <!-- <router-link  :to="`/${items.route}`" class="mdi mdi-location-enter mt-auto"> Masuk</router-link> -->
        </div>
      </div>
    </div>
  </div>
  </template>

<style>

</style>




