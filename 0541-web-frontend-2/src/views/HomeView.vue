<script>
  // import LogoutButton from '../components/LogoutButton.vue';
  import HomeNavbar from '../components/HomeNavbar.vue';
  import MenuCard from '../components/menu-card.vue'  
  //bagaimana cara kondisi tertentu -> data tertentu
  import {functionalKasir, functionalAdmin, functionalMO} from '../data/staticData'
  export default{
    data(){
      return {
        showMenuAdmin : false,
        showMenuMO : false,
        showMenuKasir : false,
        functionalKasir ,
        functionalAdmin,
        functionalMO        

      }
    },
    methods : {
      changeClass(){
        document.body.classList.replace('body-center','body-normalflow');
      },
      renderContent({jabatan_pegawai})
      {
        if(jabatan_pegawai == 'kasir')
        {
          this.showMenuKasir = true;
        }else if(jabatan_pegawai == 'MO')
        {
          this.showMenuMO = true;
        }else if(jabatan_pegawai == 'Admin')
        {
          this.showMenuAdmin = true;
        }
        console.log(this.showMenuAdmin) 
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
      console.log(functionalKasir)
      console.log(this.showMenuAdmin)
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
    <home-navbar :message = "'Selamat Datang Di Aplikasi Gofit'"></home-navbar>
  </header>
  <main>
      <div class="pegawai-admin p-5" v-show="showMenuAdmin">
        <div class="d-flex flex-row justify-content-evenly" >
          <menu-card :data ="functionalAdmin"></menu-card>
        </div>
      </div>
      <div class="pegawai-mo p-5" v-show="showMenuMO">
        <div class="d-flex flex-row justify-content-evenly" >
          <menu-card :data ="functionalMO"></menu-card>
        </div>
      </div>
      <div class="pegawai-kasir p-5" v-show="showMenuKasir">
        <div class="d-flex flex-row justify-content-evenly" >
          <menu-card :data ="functionalKasir"></menu-card>
        </div>
      </div>
  </main>
</template>

<style scoped>


.pegawai-admin{
  height: 100vh;
  background-color: rgba(0,0,0,0.7  );
}
.pegawai-mo{
  height: 100vh;
  background-color: rgba(0,0,0,0.7  );
}
.pegawai-kasir{
  /* margin-top: 4em; */
  /* margin-left: 2em; */
  height: 100vh;
  background-color: rgba(0,0,0,0.7  );
  /* width: 100%; */
}

</style>
