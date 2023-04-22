<script>
  import axios from 'axios';
  import HomeNavbar from '../../components/HomeNavbar.vue';
  import BackButton from '../../components/BackButton.vue';
  import { reactive } from 'vue';
  import { defineComponent  } from 'vue';
  import { useRouter} from 'vue-router';
  import {$toast} from '../../plugins/notifHelper.js'

  // import { ActionCreate,ActionUpdate,ActionDelete} from '../../data/actionData'

  export default defineComponent({
    //Component yang digunakan
    components:{
      HomeNavbar,
      BackButton
    },

    methods : {
        goBack() {
        if ($toast) {
        this.toast.goAway(0);
        }
      },
    },

    mounted(){
      this.instruktur = this.$route.query
      this.instruktur.tanggal_lahir_instruktur = this.formatDate(this.instrutanggal_lahir_instruktur.tgl_lahir_instruktur)
      window.onpopstate = () => {
        this.goBack();
      };
    },
    //Setup
    setup(){
      const router = useRouter('router'); 
      const instruktur = reactive({
        nama_instruktur : '',
        tanggal_lahir_instruktur : '',
        alamat_instruktur : '',
        no_telp_instruktur : '',
        username : '',
        password : '',
      })

      const submitForm = (event) => {
        console.log(event)
        event.preventDefault(); // hindari default form submission
        storeInstruktur()
      }

      function isValid({nama_instruktur,tanggal_lahir_instruktur, alamat_instruktur , no_telp_instruktur ,username,password}){
        let status = true;  
        if (!nama_instruktur) {
          $toast.warning('Nama instruktur harus diisi');
          status = false;
        }
        // const regex = /^\d{4}-\d{2}-\d{2}$/;
        if (!tanggal_lahir_instruktur) {
          $toast.warning('Tanggal lahir instruktur harus diisi');
          status = false;
        }
        if (!alamat_instruktur) {
          $toast.warning('Alamat instruktur harus diisi');
          status = false;
        }
        if (!no_telp_instruktur) {
          $toast.warning('No telp instruktur harus diisi');
          status = false;
        }
        if (!username) {
          $toast.warning('username harus diisi');
          status = false;
        }
        if (!password) {
          $toast.warning('username harus diisi');
          status = false;
        }
        return status;
      }

      


      const storeInstruktur = async() => {
        const statusValidate = isValid(instruktur)
        if(statusValidate){
          try{
            const post = "http://127.0.0.1:8000/api/instruktur"; 
            const request = await axios.post(post,instruktur); // ; 
            $toast.success(request.data.message)
            router.push({name:'instruktur'})
          }catch{
            $toast.warning('Gagal Menambahkan Data')
          }
        }
      }



      return{
        router,
        instruktur,
        storeInstruktur,
        submitForm
      }
    }

})
</script>
<template >
  <header>
    <home-navbar :message="'Gofit -  Tambah Data Instruktur'"></home-navbar>
  </header>
  <main>
    <div class='content text-white p-5'>
      <h2>Tambah Instruktur</h2>
      <div  class= 'container-fluid form-custom p-4 text-dark'>
        <h3 class="title">Tambah Data Instruktur <span class="mdi mdi-account-plus"></span></h3>
        <hr>
        <form @submit.prevent="submitForm($event)">
          <div class="mb-3">
            <label for="nama_member" class="form-label">Nama Instruktur</label>
            <input type="teal" v-model="instruktur.nama_instruktur" class="form-control" id="nama_instruktur" aria-describedby="emailHelp">
            <div id="namaHelp" class="form-text">ex : Ucup Surucup</div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="birthday">Tanggal Lahir instruktur</label>
            <input class="form-text" v-model="instruktur.tanggal_lahir_instruktur" type="date" id="birthday" >
            <div id="tglLahirHelp" class="form-text">Format yang digunakan : mm/dd/yyyy</div>
          </div>
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Instruktur</label>
            <input type="text" v-model="instruktur.alamat_instruktur" class="form-control" id="alamat">
            <div id="alamat" class="form-text">ex : Babarsari No 43 Yogyakarta</div>
          </div>
          <div class="mb-3">
            <label for="notelp" class="form-label">No Telp instruktur</label>
            <input type="text" v-model="instruktur.no_telp_instruktur" class="form-control" id="notelp">
            <div id="notelp" class="form-text">ex : 08123456789</div>
          </div>
          <hr>
          <h5>Akun</h5>
          <div class="mb-3">
            <label for="username" class="form-label">username</label>
            <input type="text" v-model="instruktur.username" class="form-control" id="username">
            <div id="usernameHelp" class="form-text">ex : ucup1</div>
          </div>
          <hr>
          <div class="mb-3">
            <label for="password" class="form-label">Password Instruktur</label>
            <input type="password" v-model="instruktur.password" class="form-control" id="password">
            <div id="passwordHelp" class="form-text">ex : 08123456789</div>
          </div>
          <hr>
          <div class="d-flex justify-content-between">
            <back-button :className="'btn btn-dark'" @click="goBack"></back-button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
        <hr>
      </div>
    </div>
  </main>
</template>

<style scoped>

/* set width to match other form inputs */
input[type="date"] {
  width: 100%;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

/* hide default arrow */
input[type="date"]::-webkit-calendar-picker-indicator {
  display: none;
}

/* use Bootstrap icon for date picker */
input[type="date"]::before {
  content: "\f0ed";
  font-family: "Material Design Icons";
  font-weight: 400;
  font-size: 1.25rem;
  line-height: 1.5;
  color: #6c757d;
  position: absolute;
  right: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  pointer-events: none;
}

/* change border color on focus */
input[type="date"]:focus {
  border-color: #80bdff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}


.content{
  height: 100vh;
  background-color: rgba(0,0,0,0.7  );
}


.form-custom{
  background-color: rgba(255,255,255,0.9);
  border-radius: 10px;
}

</style>
