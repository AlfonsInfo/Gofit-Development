<script>
  import axios from 'axios';
  import HomeNavbar from '../../components/HomeNavbar.vue';
  import { onMounted ,ref } from 'vue';
  import { defineComponent  } from 'vue';
  import { useRouter} from 'vue-router';
  import { ActionCreate,ActionUpdate,ActionDelete} from '../../data/actionData'

  export default defineComponent({
    //Component yang digunakan
    components:{
      HomeNavbar,
    },

    //Setup
    setup(){
      const router = useRouter('router'); //tidak boleh dalam fungsi login karena fungsi login await(event callback)
      let members = ref([])
      onMounted(async () =>  {
        const dataRoute = "http://localhost:8000/api/member";
        const request = await axios.get(dataRoute)
        members.value = request.data.data 
        
        members.value.forEach((e)=>{
          e['aktivasi'] = (e.tgl_kadeluarsa_aktivasi == null) ? 'Ya' : 'Tidak'  
        })

      })
      console.log(ActionCreate)
      const actions = [
        ActionCreate,ActionUpdate,ActionDelete
    ]

      return{
        actions,
        router,
        members
      }
    }

})
</script>
<template >
  <header>
    <home-navbar :message="'Olah Data Member'"></home-navbar>
  </header>
  <main>
    <div class='content text-white p-5'>
      <h2>Tambah member</h2>
    </div>
  </main>
</template>

<style scoped>




.content{
  height: 100vh;
  background-color: rgba(0,0,0,0.7  );
}

</style>
