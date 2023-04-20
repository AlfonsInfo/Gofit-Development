<script>
import { defineComponent } from 'vue'
import { useRouter } from 'vue-router';

export default defineComponent({
    name: 'logout-button',
    setup(){
        const router = useRouter('router'); 
        const logout =   () => {
            // * Debugging
            console.log('logout');
            // * Bersihkan LocalStorage
            localStorage.clear();
            // Redirect kehalaman luar
            router.push({name:'login'})
        }
        
        return{
            logout
        }
    }
    });
</script>
<template>
  <main>
    <button class="btn btn-primary" @click="logout">Logout</button>
</main>
</template>

<style>

</style>


