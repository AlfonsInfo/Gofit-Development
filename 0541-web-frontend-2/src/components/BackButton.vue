<script>
import { defineComponent } from 'vue'
// import { useRouter } from 'vue-router';

export default defineComponent({
    props : {
        className :{
            type: String,
            default : 'btn btn-primary'
        }
    },
    name: 'back-button',
    setup(){
    }
    });
</script>
<template>
  <main>
    <button :class="className" @click="$router.go(-1)">Back</button>
</main>
</template>
<style>

</style>


