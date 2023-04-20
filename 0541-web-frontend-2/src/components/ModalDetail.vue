<script>
import { defineComponent } from 'vue'
// import { useRouter } from 'vue-router';
// import VTooltip from 'v-tooltip';


export default defineComponent({
  name: 'modal-detail',
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
    <button class="btn btn-dark" @click.prevent="closeModal">Close</button>
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




