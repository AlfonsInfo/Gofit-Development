<script>
import { HomeNavbar, MenuCard  } from '@/plugins/global.js'
import {menuPresensi} from '../../data/staticData'


  export default{
    data(){
      return {
        menuPresensi
      }
    },
    methods : {
      changeClass(){
        document.body.classList.replace('body-center','body-normalflow');
      },
    },
  

    mounted(){
      this.changeClass()
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
    <home-navbar :message = "'Menu Presensi Gofit'"></home-navbar>
  </header>
  <main class="">
      <div class="pegawai-mo p-5 " >
        <div class=" row row-cols-2 row-cols-md-12" >
          <menu-card :data ="menuPresensi"></menu-card>
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
