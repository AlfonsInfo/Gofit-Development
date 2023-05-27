<script>
import { defineComponent } from 'vue'
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
    <button :class="className" type="button" @click="$router.go(-1)">Back</button>
</main>
</template>




