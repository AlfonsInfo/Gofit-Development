
<script>
import { defineComponent } from 'vue'
// import { useRouter } from 'vue-router';
// import VTooltip from 'v-tooltip';


export default defineComponent({
    // directives : {'tooltip' :VTooltip.directives},
    name: 'table-data',
    props : ['context','data','actions','column','fields'],
    methods : {
      createLink(context,action){
        if(action == undefined)
        {
           return `/${context}`
        }
          return `/${context}/${action}`
        },
        eventAction(action)
        {
          alert('woy')
          if(action == 'Hapus'){
            console.log('hapus woy')
          }
        }
      },
    setup()
    {
      // console.log(props.context, props.actions[3])
    }
      // const router = useRouter('router'); //tidak boleh dalam fungsi login karena fungsi login await(event callback)
       


        

    });
</script>
<template>
  <!-- <div>
    test
  </div> -->
    <div>
            Search Section
          </div >
            <div class= 'container-fluid table-custom p-4'>
              <table class="table table-striped table-bordered table-hover mt-4">
                <thead class="table table-dark">
                  <tr>
                    <!-- <td > -->
                      <th v-for ="(dt,id) in column" :key ="id" >{{ dt }}</th>
                      <th>Aksi</th>
                    <!-- </td> -->
                    <!-- <th scope="col">ID Member</th> -->
                    <!-- <th scope="col">Nama Member</th> -->
                    <!-- <th scope="col">Tanggal Lahir Member</th> -->
                    <!-- <th scope="col">No Telp Member</th> -->
                    <!-- <th scope="col">Status Aktif</th> -->
                    <!-- <th scope="col">Aksi</th> -->
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(dt ,id) in data" :key ="id">
                    <td v-for="(field,index) in fields" :key="index">{{ dt[field] }}</td>                    
                    <td>
                      <span v-for="(action,index) in actions" :key="index" class="mx-2">
                        <router-link @click="eventAction('action')" :to="createLink(context,action.link)"  :class="action.class"> {{action.aksi}}</router-link>
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div> 
</template>

<style scoped>

.table-custom{
  background-color: rgba(255,255,255,0.9);
  border-radius: 10px;
}
</style>