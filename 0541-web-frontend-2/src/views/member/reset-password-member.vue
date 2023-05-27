<script>
import { 
  HomeNavbar, useRouter, ref ,  $toast, defineComponent, TableData,
  reactive,inject,ActionResetPassword, onMounted, Swal } 
from '@/plugins/global.js'


  export default defineComponent({
    components:{
      HomeNavbar,
      TableData,
    },
    

    //Setup
    setup(){
      const router = useRouter();
      let members = ref([])
      const state = reactive({
        modalToggle: false,
        sendDataDetail : {},
        searchInput : '',
      })
      const http = inject('$http');


      function konversiMember(members){
          members.value.forEach((e)=>{
          const tanggalLengkap = e['tgl_lahir_member'].split(' ');
          const tanggal = new Date(tanggalLengkap[0])
          const formattedDate = tanggal.toLocaleDateString('en-GB');
          return e['tgl_lahir_member'] = formattedDate;
        })
          members.value.forEach((e)=>{
            e['aktivasi'] = (e.tgl_kadeluarsa_aktivasi == null) ? 'Tidak Aktif' : 'Aktif'  
          })
      }

      //Fungsi mendapatkan semua member
      const getAllMember = async(message) => {
        const dataRoute = "/member";
        const request = await http.get(dataRoute)
        members.value = request.data.data 
        konversiMember(members)
        $toast.success(message)
      }

      //Mounted
      onMounted(async () =>  {
        getAllMember('Berhasil Menampilkan Data Member !!')
      })

      function formatDate(date) {
      const [dd, mm, yyyy] = date.split('/');
      return `${yyyy}-${mm}-${dd}`;
      }

      // const validasiPIC = ()=>{
      //   let user =localStorage.getItem('userData');
      //   user = JSON.parse(user);
      //   let konfirmUsername = prompt('Konfirmasi username sebelum melakukan reset password');
      //   if(user.username == konfirmUsername)
      //   {
      //     return true;
      //   }
      //   return false;
      // }

      //Fungsi ResetPW
      const ResetPw = async ({id_pengguna,tgl_lahir_member}) => {

        tgl_lahir_member = formatDate(tgl_lahir_member)
        const result = await Swal.fire({
          title: 'Apakah Anda yakin ingin reset password member ini?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#dc3545',
        confirmButtonText: 'Reset',
          cancelButtonText: 'Batal',
        })
        //Jika di confirm
      if (result.isConfirmed) {
          try{
              const url = `/pengguna/${id_pengguna}`
              const request = await http.put(url,{ } ); // ; 
              $toast.success(request.data.message)
          }catch{
              $toast.warning('Gagal Menambahkan Data')
          }

        // Tampilkan notifikasi SweetAlert setelah data dihapus
        Swal.fire({
          title: 'Password berhasil direset!',
          icon: 'success',
          timer: 2000,
          timerProgressBar: true,
          showConfirmButton: false,
        })
      }
    }



      ActionResetPassword.functionAction = (member) => {
        ResetPw(member)
      }




      const actions = [
        ActionResetPassword
    ]

      return{
        actions,
        router,
        members,
        state,
      }
    },
    computed: {
      displayedMembers() {
        const searchKeyword = this.state.searchInput.toLowerCase();
        // console.log('Search Keyword', searchKeyword);
        return this.members.filter(member => {
          const memberString = Object.values(member).join(' ').toLowerCase();
          return memberString.includes(searchKeyword);
    });
}

    },

})
</script>
<template >
  <header>
    <home-navbar :message="'Olah Data Member'"></home-navbar>
  </header>
  <main>
    <div class='content text-white p-5'>
        <h2 class="">Daftar Member</h2>
      <div class="input-group mt-3 mb-2">
        <input type="search" class="form-control rounded me-2 " placeholder="Cari Member" aria-label="Search" aria-describedby="search-addon" v-model="state.searchInput"/>
      </div>
      <table-data 
      :context="'member'" 
      :data="displayedMembers" 
      :column="['ID Member','Nama Member','Tanggal Lahir','Nomor Telepon','Status Aktif']" 
      :actions="actions" 
      :fields="['id_member','nama_member','tgl_lahir_member','no_telp_member','aktivasi']"
      :hiddenClass ="'hidden-feature'"
      ></table-data>
    </div>
  </main>
</template>



<style scoped>
.content{
  height: 100vh;
  background-color: rgba(0,0,0,0.7  );
}

</style>
