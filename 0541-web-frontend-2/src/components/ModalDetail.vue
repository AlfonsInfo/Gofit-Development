<script>
import { defineComponent } from 'vue'
import { jsPDF } from "jspdf";

export default defineComponent({
  name: 'modal-detail',
  props : ['display', 'data', 'fields'],

  computed: {
    computedData(){
      return this.data
    },
    toggleModalClass() {
      console.log(this.display);
      return this.display ? 'show' : 'hidden'
    }
  },

  methods: {
    closeModal() {
      this.$emit('close-modal');
    },

    cetakMemberCard()
    {
      console.log(this.data)
    // Membuat instance dari jspdf
      let doc = new jsPDF({
        orientation : 'landscape',
        unit : 'mm',
        format : ['150','80']
      });
        // Mengatur posisi dan ukuran teks untuk judul
        doc.setFontSize(18);
        doc.setFont(undefined,"bold");
        doc.text("GoFit", 10, 10, null, null, "left");

        // Mengatur posisi dan ukuran teks untuk alamat
        doc.setFontSize(12);
        doc.setFont(undefined,"normal");
        doc.text("Jl. Centralpark No. 10 Yogyakarta", 10 , 20, null, null, "");

        // Mengatur posisi dan ukuran teks untuk nomor member
        doc.setFontSize(16);
        doc.setFont(undefined,"bold");
        doc.text("MEMBER CARD", 10, 30, null, null, "left");
        doc.setFontSize(12);
        doc.setFont(undefined,"normal");
        doc.text(`Member ID : ${this.data['ID Member']}`, 10, 40, null, null, "left");

        // Mengatur posisi dan ukuran teks untuk nama, alamat, dan nomor telepon
        doc.setFontSize(12);
        doc.setFont(undefined,"normal");
        doc.text("Nama :", 10, 50);
        doc.setFont(undefined,"normal");
        doc.text(this.data['Nama Member'], 40, 50);
        doc.setFont(undefined,"normal");
        doc.text("Alamat :", 10, 60);
        doc.setFont(undefined,"normal");
        doc.text(this.data['Alamat'], 40, 60); //this.data['']
        doc.setFont(undefined,"normal");
        doc.text("Telpon :", 10, 70);
        doc.setFont(undefined,"normal");
        doc.text(this.data['No Telp'], 40, 70  );

        // Menyimpan dokumen ke dalam PDF
        doc.save(`${this.data['ID Member']}.pdf`);
    }
  }
}
);
</script>
<template>
<div id="myModal" class="modal text-dark" :class="toggleModalClass">
  <div class="modal-content">
    <div v-for="(data,key) in computedData" :key="key">
      <!-- <div v-if="data"></div> -->
      <p>{{key}} : {{data }}</p>
      <hr>
    </div>
    <div class="d-flex justify-content-between" >
      <button class="btn btn-primary" @click.prevent="cetakMemberCard()">Cetak Member Card</button>
      <button class="btn btn-dark" @click.prevent="closeModal">Close</button>
    </div>
  </div>
</div>
</template>

<style scoped>

.modal {
  display: block;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.hidden {
  display: none;
}

.show {
  display: block;
}
</style>




