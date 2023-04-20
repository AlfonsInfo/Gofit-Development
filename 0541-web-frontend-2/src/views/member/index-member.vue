<script>
  import axios from 'axios';
  import HomeNavbar from '../../components/HomeNavbar.vue';
  import TableData from '../../components/table-data.vue';
  import ModalDetail from '../../components/ModalDetail.vue';
  import { onMounted ,ref, reactive} from 'vue';
  import { defineComponent  } from 'vue';
  import { useRouter} from 'vue-router';
  import {  ActionRouteToCreate, ActionViewDetail,ActionUpdate,ActionDelete} from '../../data/actionData'

  export default defineComponent({
    //Component yang digunakan
    components:{
      HomeNavbar,
      TableData,
      ModalDetail
    },

    setup(){
      const router = useRouter('router');
      let members = ref([])
      const state = reactive({
      modalToggle: false,
      sendDataDetail : {}

    })
      //Fungsi mendapatkan semua member
      const getAllMember = async() => {
        const dataRoute = "http://localhost:8000/api/member";
        const request = await axios.get(dataRoute)
        members.value = request.data.data 
        
        members.value.forEach((e)=>{
          const tanggalLengkap = e['tgl_lahir_member'].split(' ');
          const tanggal = new Date(tanggalLengkap[0])
          const formattedDate = tanggal.toLocaleDateString('en-GB');
          return e['tgl_lahir_member'] = formattedDate;
        })
        members.value.forEach((e)=>{
          e['aktivasi'] = (e.tgl_kadeluarsa_aktivasi == null) ? 'Aktif' : 'Tidak Aktif'  
        })

      }

      //Mounted
      onMounted(async () =>  {
        getAllMember()
      })

      //Navigasi Ke Create Member
      const ActionCreateMember =  ()=>{
        ActionRouteToCreate(router,'MemberCreate')
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
          console.log(state.sendDataDetail)
        }catch(e){
          alert(e)
          alert('Gagal Menampilkan Detail')
        }
      }

      ActionViewDetail.functionAction = (member) =>{
          detailMember(member)
      }

      //Fungsi Delete
      const deleteData = async ({id_member}) => {
        // alert(id.)
        const deleteRoute = `http://localhost:8000/api/member/${id_member}`
        try{
          const deleteRequest = await axios.delete(deleteRoute)
          alert(deleteRequest.data.message)
          getAllMember()
        }catch{
          alert('Gagal Delete')
        }
      }

      // const deleteDataWrapper = (deleteDataFunc, id /*, additionalParam*/ ) => {
      //   deleteDataFunc(id);
      // }

      ActionDelete.functionAction = (member) => {
        deleteData(member)
        // deleteDataWrapper(deleteData,id)
      }




      const actions = [
        ActionViewDetail,ActionUpdate,ActionDelete
    ]
      return{
        actions,
        router,
        members,
        ActionCreateMember,
        ModalDetail,
        state,
      }
    }

})
</script>
<template >
  <header>
    <home-navbar :message="'Olah Data Member'"></home-navbar>
  </header>
  <main>
    <div class='content text-white p-5'>
      <h2 class="">Daftar Member</h2>
      <table-data 
      :context="'member'" 
      :data="members" 
      :column="['ID Member','Nama Member','Tanggal Lahir','Nomor Telepon','Status Aktif']" 
      :actions="actions" 
      :fields="['id_member','nama_member','tgl_lahir_member','no_telp_member','aktivasi']"
      :create="ActionCreateMember"
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
