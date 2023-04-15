<script>
import axios from 'axios' ;
import { reactive } from 'vue';
import { useRouter} from 'vue-router';

 //script setup apa bedanya bangg
export default{
  data(){
    return{
      //* Toggle Password
      showPassword: false,
      // invalidMessage: 'Please Input'
    }
  },

  setup(){
    const inputLogin = reactive({
      username : "",
      password : "",
    });

    function Login(){
      console.log('Fungsi Login');
      //Data yang ingin di kirim melalui Api
      let username = inputLogin.username;
      let password = inputLogin.password;
      //Debugging
      // console.log(username,password);

      //State validation
      // const validation = ref([]);

      //Vue router
      const router = useRouter()
      
      axios.post('http://127.0.0.1:8000/api/login',{
        username : username,
        password : password},)
        .then(response => response.data)
        .then(response=>
        {
          let {user,access_token} = response
          
          console.log(access_token)
          localStorage.setItem('token', access_token);
          localStorage.setItem('user', user);

          //route sesuai dengan role
          router.push({name: "Home"})
        }).catch(error => {
          console.log(error);
          alert('Gagal Login'); 
        })
    }

    return{
      Login,
      inputLogin
    }
  },

  methods: {
    togglePassword(){
      return this.showPassword ? 'text' : 'password'
    },
    toggleIconPassword()
    {
      return this.showPassword ? 'mdi mdi-eye-off' : ''
    }
  }
}
</script>


<template class="template">
  <div class="welcome-message">
    <h1>Selamat Datang Di Aplikasi Gofit</h1>
  </div>
  <div class="login-form">
    <!--  @submit.prevent = "Login" -->
    <form class="needs-validation" @submit.prevent = "Login">
      <div class="has-validation mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" v-model="inputLogin.username" required>
        <div class="invalid-feedback">
          Please Input Username
        </div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="password-wrapper">
          <input :type="togglePassword()" class="form-control" id="password"  v-model="inputLogin.password" required>
          <i span toggle="#password" class="toggle-password icon-blue"  :class ="toggleIconPassword()"></i>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>



<style scoped>
  .welcome-message, .login-form{
    margin-left: 20px;
    padding: 35px;
    border-radius: 5px;
    background-color: rgba(0,0,0,0.8);
    color: white;
  }


  .toggle-password {
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  cursor: pointer;
}

.icon-blue{
  color: darkblue;
}
</style>