<script>
  import axios from 'axios';
  import HomeNavbar from '../../components/HomeNavbar.vue';
  import TableData from '../../components/table-data.vue';
  import ModalDetail from '../../components/ModalDetail.vue';
  import { onMounted ,ref, reactive} from 'vue';
  import { defineComponent  } from 'vue';
  import { useRouter} from 'vue-router';
  import {  ActionRouteToCreate, ActionViewDetail,ActionUpdate,ActionDelete} from '../../data/actionData'
  import {$toast} from '../../plugins/notifHelper.js'

  export default defineComponent({
    //Component yang digunakan
    components:{
      HomeNavbar,
      TableData,
      ModalDetail
    },
    

    //Setup
    setup(){
      const router = useRouter();
      let presensiGym = ref([])
      const state = reactive({
      modalToggle: false,
      sendDataDetail : {},
      searchInput : '',
    })

    //   function konversiMember(members){
    //       members.value.forEach((e)=>{
    //       const tanggalLengkap = e['tgl_lahir_member'].split(' ');
    //       const tanggal = new Date(tanggalLengkap[0])
    //       const formattedDate = tanggal.toLocaleDateString('en-GB');
    //       return e['tgl_lahir_member'] = formattedDate;
    //     })
    //       members.value.forEach((e)=>{
    //         e['aktivasi'] = (e.tgl_kadeluarsa_aktivasi == null) ? 'Tidak Aktif' : 'Aktif'  
    //       })
    //   }

      //Fungsi mendapatkan semua member
      const getAllPresensi = async(message) => {
        const dataRoute = "http://localhost:8000/api/presensi-instruktur";
        const request = await axios.get(dataRoute)
        presensiGym.value = request.data.data 
        // konversiMember(members)
        $toast.success(message)
      }

      //Mounted
      onMounted(async () =>  {
        getAllPresensi('Berhasil Menampilkan Data Member !!')
      })

      //Navigasi Ke Create Member
      const ActionCreateMember =  ()=>{
        ActionRouteToCreate(router,'member-tambah')
      }

      //Fungsi Show Detail Data 
      const detailMember = async({id_member}) =>{
        const showDetailMemberRoute = `http://localhost:8000/api/member/${id_member}`
        try{
          const detailRequest = await axios.get(showDetailMemberRoute)
          const detailData = detailRequest.data.data[0];
          state.modalToggle = true;
          const mappedData = {
            'ID Member': detailData.id_member,
            'Nama Member': detailData.nama_member,
            'Tanggal Lahir': detailData.tgl_lahir_member,
            'No Telp': detailData.no_telp_member,
            'Kadeluarsa Aktivasi': detailData.tgl_kadeluarsa_aktivasi,
            'Total Deposit ': detailData.total_deposit_uang,
            'Tanggal Gabung Member': detailData.tgl_gabung_member,
            'Total Deposit Paket': detailData.total_deposit_paket,
            'Tanggal Kadeluarsa Paket': detailData.tgl_kadeluarsa_paket,
            'username': detailData.pengguna.username,
          };

          state.sendDataDetail = mappedData ;          
        }catch(e){
          alert(e)
          alert('Gagal Menampilkan Detail')
        }
      }

      ActionViewDetail.functionAction = (member) =>{
          detailMember(member)
      }
      //Fungsi Update


      // ActionUpdate.functionAction = member => {

      // }

      //Fungsi Delete
    //   const deleteData = async ({id_member}) => {
    //     // alert(id.)
    //     const deleteRoute = `http://localhost:8000/api/member/${id_member}`
    //     try{
    //       const deleteRequest = await axios.delete(deleteRoute)
    //       // alert(deleteRequest.data.message)
    //       $toast.success(deleteRequest.data.message)
    //       getAllMember('Tabel Data Member di update')
    //     }catch{
    //       $toast.danger('Berhasil Menghapus Data')
    //     }
    //   }


    //   ActionDelete.functionAction = (member) => {
    //     deleteData(member)
    //   }




      const actions = [
        ActionViewDetail,ActionUpdate,ActionDelete
    ]

      return{
        actions,
        router,
        presensiGym,
        ActionCreateMember,
        ModalDetail,
        state,
        // searchMember
      }
    },
    computed: {
      displayedpresensiGym() {
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
    <home-navbar :message="'Gofit - Olah Presensi Gym Member'"></home-navbar>
  </header>
  <main>
    <div class='content text-white p-5'>
        <h2 class="">Daftar Presensi</h2>
      <div class="input-group mt-3 mb-2">
        <input type="search" class="form-control rounded me-2 " placeholder="Cari presensi" aria-label="Search" aria-describedby="search-addon" v-model="state.searchInput"/>
      </div>
      <table-data 
      :context="'ijin-instruktur'" 
      :data="presensiGym" 
      :column="['ID Member','Nama Member','Tanggal Lahir','Nomor Telepon','Status Aktif']" 
      :actions="actions" 
      :fields="['id_presensi','nama_member','tgl_lahir_member','no_telp_member','aktivasi']"
      :hiddenClass ="'hidden-feature'"
      ></table-data>
    </div>
    <div>
      <modal-detail :display="state.modalToggle" :data="state.sendDataDetail"  @close-modal="state.modalToggle = false;" ></modal-detail>
    </div>
  </main>
</template>



<style scoped>
.content{
  height: 100vh;
  background-color: rgba(0,0,0,0.7  );
}

</style>
