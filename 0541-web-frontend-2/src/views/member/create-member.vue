<script>
  import axios from 'axios';
  import HomeNavbar from '../../components/HomeNavbar.vue';
  import { onMounted ,ref } from 'vue';
  import { defineComponent  } from 'vue';
  import { useRouter} from 'vue-router';
  // import { ActionCreate,ActionUpdate,ActionDelete} from '../../data/actionData'

  export default defineComponent({
    //Component yang digunakan
    components:{
      HomeNavbar,
    },

    //Setup
    setup(){
      const router = useRouter('router'); 
      // let members = ref([])



      return{
        router,
        // members
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
        <form>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nama Member</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="birthday">Tanggal Lahir Member  </label>
            <input class="form-text" type="date" id="birthday" name="birthday">
          </div>
          <div></div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">No Telp Member</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <hr>
      </div>
    </div>
  </main>
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
