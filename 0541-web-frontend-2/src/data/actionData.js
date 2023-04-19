// import { useRouter } from 'vue-router';

class Actions{
    constructor(aksi,kelas,link,functionAction){
        this.aksi = aksi,
        this.kelas = kelas, //stand for class css
        this.link = link
        this.functionAction = functionAction
    }
}


export const ActionRouteToCreate = (router,route) =>{
    // const router = useRouter();
    router.push({name:route})
}

export const ActionCreate = new Actions('Tambah','');
export const ActionViewDetail = new Actions('Detail','','detail')
export const ActionUpdate = new Actions('Ubah','','ubah')
export const ActionDelete = new Actions('Hapus','')
export const ActionResetPassword = new Actions('Reset Password','','')
export const ActionConfirm = new Actions('Konfirmasi','','')
export const ActionReject = new Actions('Tolak','','')