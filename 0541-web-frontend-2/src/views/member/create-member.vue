<script>
  import HomeNavbar from '../../components/HomeNavbar.vue';
  import BackButton from '../../components/BackButton.vue';
  import { reactive , inject } from 'vue';
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
      window.onpopstate = () => {
        this.goBack();
      };
    },
    //Setup
    setup(){
      const router = useRouter(); 
      const http = inject('$http');
      const member = reactive({
        nama_member : '',
        tgl_lahir_member : '',
        no_telp_member : '',
        membership : false,
        alamat_member : ''
      })

      const submitForm = (event) => {
        console.log(event)
        event.preventDefault(); // hindari default form submission
        // kode untuk memproses data form
        storeMember()
      }

      function isValid({nama_member,tgl_lahir_member,no_telp_member}){
        let status = true;  
        console.log(nama_member,tgl_lahir_member,no_telp_member)
        if (!nama_member) {
          $toast.warning('Nama member harus diisi');
          status = false;
        }
        // const regex = /^\d{4}-\d{2}-\d{2}$/;
        if (!tgl_lahir_member) {
          $toast.warning('Tanggal lahir member harus diisi');
          status = false;
        }
        if (!no_telp_member) {
          $toast.warning('No telp member harus diisi');
          status = false;
        }
        return status;
      }

      function isActivateNow({membership}){
        if(membership){
          return true;
        }
        return false;
      }

      function transaksiAktivasi(){
        console.log('transaksiAktivasi')
      }

      const storeMember = async() => {
        const statusValidate = isValid(member)
        const statusAksiAktivasi = isActivateNow(member)
        if(statusValidate){
          try{
            const post = "/member"; 
            const request = await http.post(post,member); // ; 
            (statusAksiAktivasi)? transaksiAktivasi() : null;
            $toast.success(request.data.message)
            router.push({name : 'member'})
          }catch{
            $toast.warning('Gagal Menambahkan Data')
          }
        }
      }

      return{
        router,
        member,
        storeMember,
        submitForm
      }
    }

})
</script>
<template >
  <header>
    <home-navbar :message="'Gofit -  Tambah Data Member'"></home-navbar>
  </header>
  <main>
    <div class='content text-white p-5'>
      <h2>Tambah member</h2>
      <div  class= 'container-fluid form-custom p-4 text-dark'>
        <h3 class="title">Tambah Data Member <span class="mdi mdi-account-plus"></span></h3>
        <hr>
        <form @submit.prevent="submitForm($event)">
          <div class="mb-3">
            <label for="nama_member" class="form-label">Nama Member</label>
            <input type="teal" v-model="member.nama_member" class="form-control" id="nama_member" aria-describedby="emailHelp">
            <div id="namaHelp" class="form-text">ex : Ucup Surucup</div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="birthday">Tanggal Lahir Member</label>
            <input class="form-text" v-model="member.tgl_lahir_member" type="date" id="birthday" >
            <div id="namaHelp" class="form-text">Format yang digunakan : mm/dd/yyyy</div>
          </div>
          <div class="mb-3">
            <label for="notelp" class="form-label">No Telp Member</label>
            <input type="text" v-model="member.no_telp_member" class="form-control" id="notelp">
            <div id="namaHelp" class="form-text">ex : 08123456789</div>
          </div>
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Member</label>
            <input type="text" v-model="member.alamat_member" class="form-control" id="alamat">
            <div id="namaHelp" class="form-text">ex : 08123456789</div>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" v-model="member.membership" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
              Daftar Membership langsung ?
            </label>
          </div>
          <div class="d-flex justify-content-between">
            <back-button :className="'btn btn-dark'" @click="goBack"></back-button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
        <hr>
      </div>
    </div>
  </main>
  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Launch static backdrop modal
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>
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
