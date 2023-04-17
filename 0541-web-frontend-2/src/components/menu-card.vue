<script>
import { defineComponent } from 'vue'
import { useRouter } from 'vue-router';

export default defineComponent({
    name: 'menu-card',
    props : ['data'],
    setup(){
        const router = useRouter('router'); //tidak boleh dalam fungsi login karena fungsi login await(event callback)
        const navigateToPage =   () => {
            // * Debugging
            // * Bersihkan LocalStorage
            localStorage.clear();
            // Redirect kehalaman luar
            router.push({name:'login'})
        }
        
        return{
            navigateToPage
        }
    }
    });
</script>
<template>
    <div v-for="(items,key) in data" :key = "key" class="card text-dark mt-5" style="width: 18rem;">
    <img src="../../src/assets/image/background-1.jpg" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title ">
        {{items.title}}
      </h5>
      <p class="card-text">
        {{ items.description }}
        </p>
      <a href="#" class="btn btn-primary">
        Go somewhere
      </a>
    </div>
  </div>
</template>

<style>

</style>




