<script>
  // import LogoutButton from '../components/LogoutButton.vue';
  import HomeNavbar from '../components/HomeNavbar.vue';
  import MenuCard from '../components/menu-card.vue'  
  import {functionalKasir} from '../data/staticData'
  export default{
    data(){
      return {
        showMenuAdmin : false,
        showMenuMO : false,
        showMenuKasir : false,
        functionalKasir,        

        functionalAdmin : ['Olah Instruktur',],
        functionalMO : [''],
      }
    },
    methods : {
      changeClass(){
        document.body.classList.replace('body-center','body-normalflow');
      },
      renderContent({jabatan_pegawai})
      {
        if(jabatan_pegawai == 'kasir')
          this.showMenuKasir = true;
        if(jabatan_pegawai == 'MO')
            this.showMenuMO = true;
        if(jabatan_pegawai == 'Amin')
            this.showMenuAdmin = true;
      },
      getDataUser()
      {
        let user =localStorage.getItem('userData');
        return JSON.parse(user)
      },
      getDataPegawai()
      {
        let pegawai = localStorage.getItem('pegawaiData');
        return JSON.parse(pegawai)
      }    
    },
  

    mounted(){
      //Change Class For Change CSS Styles
      this.changeClass()
      //Get dataPegawai
      const dataPegawai = this.getDataPegawai();
      //Render  based on Data
      this.renderContent(dataPegawai);
    },


    components : {
      // LogoutButton,
      HomeNavbar,
      MenuCard
    }
  }
</script>
<template >
  <header>
    <home-navbar></home-navbar>
  </header>
  <main>
    <div class="pegawai-admin" v-show="showMenuAdmin">Admin</div>
    <div class="pegawai-mo" v-show="showMenuMO">MO</div>
    <!-- <div class="pegawai-kasir" v-show="showMenuKasir">Kasir</div> -->
    <div class="" v-show="showMenuKasir">
      <div class="d-flex flex-row justify-content-evenly" >
        <menu-card :data ="functionalKasir"></menu-card>
      </div>
    </div>
  </main>
</template>

<style scoped>

#app{
  background-color: red;
}

.pegawai-admin{
  width: 100%;
  height: 200px;
  background-color: blue;
}
.pegawai-mo{
  height: 200px;
  width: 200px;
  background-color: blue;
}
.pegawai-kasir{
  margin: 10px 10px;
  height: 200px;
  width: 100%;
  background-color: blue;
}

</style>
