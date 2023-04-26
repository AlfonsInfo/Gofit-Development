<script>
import { defineComponent, reactive,inject } from 'vue';
import { useRouter} from 'vue-router';
import {$toast} from '../plugins/notifHelper.js'

export default defineComponent({
  mounted(){
    document.body.classList.add('body-center');
  },

  //setup dieksekusi sebelum data()
  setup(){  
    const inputLogin = reactive({
      username : "",
      password : "",
    });
    const http = inject('$http');
    const router = useRouter(); //tidak boleh dalam fungsi login karena fungsi login await(event callback)
    let showPassword = false;

    const Login = async () => {
      console.log('Fungsi Login');
      let username = inputLogin.username;
      let password = inputLogin.password;

      const data = {
        username : username,
        password : password
      }

      try{
        const Login = await http.post('/login',data);
        let {user, access_token,pegawai} = Login.data;
        
        // Set Local Storage
        localStorage.setItem('token', access_token);
        localStorage.setItem('userData', JSON.stringify(user));
        localStorage.setItem('pegawaiData', JSON.stringify(pegawai))
        $toast.success(`Welcome  ${user.username}!`);

        //Route ke Home
        router.push({name: "Home"});
      }catch(e)
      {
        $toast.warning(`Gagal Login`)
        // console.log(e)
      }
    
    }

    const togglePassword = () => {
      return showPassword ? 'text' : 'password'
    }

    const toggleIconPassword = () => {
      return showPassword ? 'mdi mdi-eye-off' : ''
    }
    
    return{
      Login,
      inputLogin,
      togglePassword,
      toggleIconPassword,
      showPassword,
    }
  }
})
</script>

<template style>

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
    max-width: 95%;
    margin-left: 20px;
    padding: 40px;
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