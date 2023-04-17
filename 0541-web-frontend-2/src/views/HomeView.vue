<script>
  // import LogoutButton from '../components/LogoutButton.vue';
  import HomeNavbar from '../components/HomeNavbar.vue';
  
  export default{
    data(){
      return {
        showMenuAdmin : false,
        showMenuMO : false,
        showMenuKasir : false,
        
        functionalKasir : ['Olah Member','Reset Password Member','Transaksi','Presensi Member Gym'],
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
    <!-- <div class="pegawai-kasir" v-show="showMenuKasir">Kasir</div> -->
    <div class="" v-show="showMenuKasir">
      <div class="d-flex flex-row justify-content-evenly" >
  <div v-for="(items,key) in functionalKasir" :key = "key" class="card text-dark mt-5" style="width: 18rem;">
    <img src="../../src/assets/image/background-1.jpg" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title ">
        {{items}}
      </h5>
      <p class="card-text">
        Some quick example text to build on the card title and make up the bulk of the card's content.
      </p>
      <a href="#" class="btn btn-primary">
        Go somewhere
      </a>
    </div>
  </div>
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
