
<script>
// import { defineComponent } from 'vue'
// import { useRouter } from 'vue-router';
// import VTooltip from 'v-tooltip';



export default {
    name: 'table-data',
    props : ['context','data','actions','column','fields'],
    data(){
        return{
          itemsPerPage : 10,
          currentPage : 1,
    }
  },
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
    },
    prevPage(){
      if(this.currentPage>1){
        this.currentPage -=1;
      }
    },
    nextPage(){
      if(this.currentPage < this.totalPages){
        this.currentPage +=1;
      }
      console.log(this.currentPage)
    },
  },
  computed : {
        totalPages(){
          // return Math.ceil(this.datafromProps / this.itemsPerPage )
          return Math.ceil(this.data.length / this.itemsPerPage )
        },
        
        displayedItems(){
          const startIndex = (this.currentPage - 1) * this.itemsPerPage
          const endIndex = startIndex + this.itemsPerPage
            return this.data.slice(startIndex,endIndex);
        }
      },       
      }
</script>
<template>
  <!-- <div>
    test
  </div> -->
    <div>
            Search Section
          </div >
            <div  class= 'container-fluid table-custom p-4'>
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
                    <td v-for="(field,index) in fields" :key="index">{{ dt[field] }}</td>                    
                    <td>
                      <span v-for="(action,index) in actions" :key="index" class="mx-2">
                        <router-link @click="eventAction('action')" :to="createLink(context,action.link)"  :class="action.class"> {{action.aksi}}</router-link>
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
              <nav>  
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
  background-color: black;
}
</style>