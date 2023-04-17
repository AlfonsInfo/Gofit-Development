<script>
  // import LogoutButton from '../components/LogoutButton.vue';
  import HomeNavbar from '../../components/HomeNavbar.vue';
  export default{
    data(){
      return {

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
    },


    components : {
        
      // LogoutButton,
      HomeNavbar,
    }
  }
</script>
<template >
  <header>
    <home-navbar :message="'Olah Data Member'"></home-navbar>
  </header>
  <!-- component untuk redirect ke  menu utama  -->
  <main>
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
  /* margin-top: 4em; */
  /* margin-left: 2em; */
  height: 100%;
  /* width: 100%; */
  background-color: rgba(0,0,0,0.7  );
}

</style>
