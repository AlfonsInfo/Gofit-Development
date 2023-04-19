class Actions{
    constructor(aksi,kelas,link,functionAction){
        this.aksi = aksi,
        this.kelas = kelas, //stand for class css
        this.link = link
        this.functionAction = functionAction
    }
}

function Tambah($params)
{
    console.log('Tambah' + $params)
}

export const ActionCreate = new Actions('Tambah','','tambah' ,Tambah )
export const ActionUpdate = new Actions('Ubah','','ubah')
export const ActionDelete = new Actions('Hapus','')
export const ActionResetPassword = new Actions('Reset Password','','')