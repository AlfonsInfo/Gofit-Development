<script>
import { HomeNavbar, TableData, ModalDetail, ref, useRouter, 
  reactive,inject,$toast,onMounted,ActionRouteToCreate ,ActionViewDetail, 
  ActionDelete,ActionUpdate, defineComponent} from '@/plugins/global.js'

  export default defineComponent({
    //Component Custom yang digunakan
    components:{
      HomeNavbar,
      TableData,
      ModalDetail,
      // ModalConfirm
    },
    

    //Setup
    setup(){
      const router = useRouter();
      let members = ref([])
      const state = reactive({
      modalToggle: false,
      sendDataDetail : {},
      searchInput : '',
      // modalConfirm : false,
      // modalReaction : false,
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

      //Navigasi Ke Create Member
      const ActionCreateMember =  ()=>{
        ActionRouteToCreate(router,'member-tambah')
      }

      //Fungsi Show Detail Data 
      const detailMember = async({id_member}) =>{
        const showDetailMemberRoute = `/member/${id_member}`
        try{
          const detailRequest = await http.get(showDetailMemberRoute)
          const detailData = detailRequest.data.data[0];
          state.modalToggle = true;
          const mappedData = {
            'ID Member': detailData.id_member,
            'Nama Member': detailData.nama_member,
            'Tanggal Lahir': detailData.tgl_lahir_member,
            'No Telp': detailData.no_telp_member,
            'Alamat' : detailData.alamat_member,
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

      //Fungsi Delete
      const deleteData = async ({id_member}) => {

        const confirmDelete = confirm('Yakin ingin menghapus data member ?')
        if(confirmDelete){
            const deleteRoute = `/member/${id_member}`
          try{
            const deleteRequest = await http.delete(deleteRoute)
            // alert(deleteRequest.data.message)
            $toast.success(deleteRequest.data.message)
            getAllMember('Tabel Data Member di update')
          }catch{
            $toast.warning('Gagal Menghapus Data')
          }
        }
      }


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
    },
    computed: {
      displayedMembers() {
        const searchKeyword = this.state.searchInput.toLowerCase();
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
      :create="ActionCreateMember"
      ></table-data>
    </div>
    <div>
      <modal-detail :display="state.modalToggle" :data="state.sendDataDetail"  @close-modal="state.modalToggle = false;" ></modal-detail>
    </div>
  </main>
  
  <div class="modal-dialog modal-sm"></div>
</template>



<style scoped>

</style>
