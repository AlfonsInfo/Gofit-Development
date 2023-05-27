<script>
  // import LogoutButton from '../components/LogoutButton.vue';
  import HomeNavbar from '../components/HomeNavbar.vue';
  import MenuCard from '../components/menu-card.vue'  
  import { Swal } from '@/plugins/global.js'

  //bagaimana cara kondisi tertentu -> data tertentu
  import {functionalKasir, functionalAdmin, functionalMO} from '../data/staticData'
  export default{
    data(){
      return {
        functionalKasir ,
        functionalAdmin,
        functionalMO,
        showMenu : null ,
        role : null,        
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
         this.showMenu = this.functionalKasir;
         this.role = 'Kasir'
        }else if(jabatan_pegawai == 'MO')
        {
          this.showMenu = this.functionalMO;
          this.role = 'Manajer Operasional'
          
        }else if(jabatan_pegawai == 'Admin')
        {
          this.showMenu = this.functionalAdmin;
          this.role = 'Admin'
        }
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
      },    

    },
  

    mounted(){
      this.changeClass()
      const dataPegawai = this.getDataPegawai();
      this.renderContent(dataPegawai);
    },

    components : {
      HomeNavbar,
      MenuCard
    }
  }
</script>
<template >
  <header>
    <home-navbar :message = "`Selamat Datang Di Aplikasi Gofit - Login Sebagai ${role}`"></home-navbar>
  </header>
  <main class="">
      <div class="pegawai-admin p-5">
        <div class="row row-cols-2 row-cols-md-12" >
          <menu-card :data ="showMenu"></menu-card>
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
