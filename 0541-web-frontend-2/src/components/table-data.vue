
<script>
import BackButton from '../components/BackButton.vue';


export default {
  components:{
    BackButton,
  },
    //* name : nama komponen yang digunakan di file vue lainnya (template html)
    name: 'table-data',
    //* props data yang diambil dari parent template
    props : ['context','data','actions','column','fields','create','hiddenClass'],
    //* data untuk pagination
    data(){
      return{
          itemsPerPage : 10,
          currentPage : 1,
    }
  },

  methods : {

    //generate link
    createLink(context,action){
      if(action == undefined)
      {
        return `/${context}`
      }
      return `/${context}/${action}`
    },
    createPathName(context,action){
      if(action.link == undefined)
      {
        return `${context}`
      }
      return `${context}-${action.link}`
      // return `/${context}/${action}`
    },

    //event action
    eventAction(action)
    {
      console.log(action)
    },

    //go to prev page
    prevPage(){
      if(this.currentPage>1){
        this.currentPage -=1;
      }
    },

    //go to next page
    nextPage(){
      if(this.currentPage < this.totalPages){
        this.currentPage +=1;
      }
      console.log(this.currentPage)
    },
    
    // looping index for passing object
    getField(object,fields){
      let value = object;
      for (let i = 0; i < fields.length; i++) {
        value = value[fields[i]];
      }
      return value;
    },


    // Modal Delete dan Reset

    getToggle(action) {
    if (action.aksi === 'Hapus' || action.aksi ===  'Reset Password') {
      return 'modal';
    } else {
      return null; // kosongkan atribut jika tidak sesuai dengan aksi
    }
  },
  getTarget(action) {
    if (action.aksi === 'Hapus' || action.aksi ===  'Reset Password') {
      return '#staticBackdrop';
    } else {
      return null; // kosongkan atribut jika tidak sesuai dengan jenis
    }
  },
  },

  //computed properties
  computed : {

        //count total pages
        totalPages(){
        // return Math.ceil(this.datafromProps / this.itemsPerPage )
          return Math.ceil(this.data.length / this.itemsPerPage )
        },
        
        //displayed items
        displayedItems(){
          const startIndex = (this.currentPage - 1) * this.itemsPerPage
          const endIndex = startIndex + this.itemsPerPage
            return this.data.slice(startIndex,endIndex);
        }
      },       
      }
</script>
<template>
          <div  class= 'container-fluid table-custom p-4'>
                <button type="button" @click.prevent="create" class="btn btn-outline-dark" :class="hiddenClass">{{ 'Tambah ' + context}}</button>              
              <table  class="table table-striped table-bordered table-hover mt-4">
                <thead class="table table-dark">
                  <tr>
                    <!-- <td > -->
                      <th v-for ="(dt,id) in column" :key ="id" >{{ dt }}</th>
                      <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(dt ,id) in displayedItems" :key ="id">
                    <td v-for="(field,index) in fields" :key="index">
                        <template v-if="Array.isArray(field)" >
                          {{ getField(dt,field) }}
                        </template>
                        <template v-else>
                          {{ dt[field] }}
                        </template>
                    </td>                    
                    <td>  
                      <span v-for="(action,index) in actions" :key="index" class="mx-2">
                        <router-link 
                        @click="action.functionAction(dt)" 
                        :to="{name : createPathName(context,action,dt), query : {...dt}  }"  
                        :class="action.kelas" 
                        > {{action.aksi}}</router-link>
                        <!-- :data-bs-toggle="getToggle(action)" 
                        :data-bs-target="getTarget(action)" -->
                    </span>
                  </td>
                  </tr>
                </tbody>
              </table>
              <nav class="d-flex justify-content-between">  
              <ul class="pagination pagination-dark">
                  <li class="page-item" :class="{disabled: currentPage === 1}">
                    <a class="page-link" href="#" @click.prevent="prevPage">Previous</a>
                  </li>
                  <li class="page-item" :class="{active: page === currentPage}" v-for="page in totalPages" :key="page">
                    <a class="page-link" href="#" @click.prevent="currentPage = page">{{ page }}</a>
                  </li>
                  <li class="page-item" :class="{disabled: currentPage === totalPages}">
                    <a class="page-link" href="#" @click.prevent="nextPage">Next</a>
                  </li>
                </ul>
                <back-button className="btn btn-dark"></back-button>
              </nav> 
            </div> 
</template>

<style scoped>

.table-custom{
  background-color: rgba(255,255,255,0.9);
  border-radius: 10px;
}

.page-item:not(.active) .page-link {
  background-color: #fff; /* warna latar belakang */
  color: black; /* warna teks */
  border-color: darkblue; /* warna garis tepi */
}
.pagination.pagination-dark .page-item.active .page-link {
  z-index: 0;
  background-color: black;
}

.hidden-feature{
  display:none
}
</style>