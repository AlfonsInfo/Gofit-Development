<script>
import { defineComponent } from 'vue'
// import { useRouter } from 'vue-router';
// import VTooltip from 'v-tooltip';

export default defineComponent({
  name: 'modal-confirm',
  props : ['display', 'data', 'fields'],

  computed: {
    computedData(){
      return this.data
    },
    toggleModalClass() {
      return this.display ? 'show' : 'hidden'
    }
  },
  methods: {
    closeModal() {
      this.$emit('close-modal');
    },

    sendData(status){
      this.$emit('status',status);
      this.closeModal();
    }

    
  }
}
);
</script>
<template>
<div id="myModal" class="modal text-dark" :class="toggleModalClass">
  <div class="modal-content modal-sm">
      <h4>Apakah Yakin ingin menghapus Data ini? </h4>
      <hr>
    <div class="d-flex justify-content-between" >
      <button class="btn btn-dark" @click.prevent="sendData(false)">Batalkan</button>
      <button class="btn btn-primary" @click.prevent="sendData(true)">Hapus</button>
    </div>
  </div>
</div>
</template>

<style>
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  /* width: 100%; */
  /* height: 100%; */
  overflow: auto;
  background-color: rgba(0,0,0,0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 5% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 40%;
}

.hidden {
  display: none;
}

.show {
  display: block;
}
</style>




