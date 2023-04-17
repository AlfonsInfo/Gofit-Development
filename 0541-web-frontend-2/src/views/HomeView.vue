<script>
  import LogoutButton from '../components/LogoutButton.vue';
  import HomeNavbar from '../components/HomeNavbar.vue';
  
  export default{
    data(){
      return {
        showMenuAdmin : false,
        showMenuMO : false,
        showMenuKasir : false 
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
      LogoutButton,
      HomeNavbar
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
    <div class="pegawai-kasir" v-show="showMenuKasir">Kasir</div>
    <logout-button></logout-button>
  </main>
</template>

<style scoped>

#app{
  background-color: red;
}

.pegawai-admin{
  width: 200px;
  width: 200px;
  background-color: blue;
}
.pegawai-mo{
  width: 200px;
  width: 200px;
  background-color: blue;
}
.pegawai-kasir{
  width: 200px;
  width: 200px;
  background-color: blue;
}

</style>
