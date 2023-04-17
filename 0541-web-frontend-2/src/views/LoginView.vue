<script>
import axios from 'axios';
import { defineComponent, reactive } from 'vue';
import { useRouter } from 'vue-router';

const togglePassword = (showPassword) => {
  return showPassword ? 'text' : 'password';
}

const toggleIconPassword = (showPassword) => {
  return showPassword ? 'mdi mdi-eye-off' : '';
}

const useLogin = () => {
  const router = useRouter();
  const inputLogin = reactive({
    username: '',
    password: '',
  });
  const showPassword = reactive(false);

  const login = async () => {
    const request = {
      username: inputLogin.username,
      password: inputLogin.password,
    }
    const postUrl = 'http://127.0.0.1:8000/api/login';

    try {
      const response = await axios.post(postUrl, request);

      // Destructuring Login Response
      const { user, access_token, pegawai } = response.data;

      // Set Local Storage
      localStorage.setItem('token', access_token);
      localStorage.setItem('userData', JSON.stringify(user));
      localStorage.setItem('pegawaiData', JSON.stringify(pegawai));

      //Route ke Home
      router.push({ name: 'Home' });
    } catch (e) {
      alert('Gagal Login');
    }
  }

  return {
      login,
    inputLogin,
    showPassword,
    togglePassword,
    toggleIconPassword,
  }
}

export default defineComponent({
  mounted() {
    document.body.classList.add('body-center');
  },
  setup() {
    const { login, inputLogin, showPassword,togglePassword,toggleIconPassword } = useLogin();

    return {
      login,
      inputLogin,
      showPassword,
      togglePassword,
      toggleIconPassword
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
          <input :type="togglePassword" class="form-control" id="password"  v-model="inputLogin.password" required>
          <i span toggle="#password" class="toggle-password icon-blue"  :class ="toggleIconPassword"></i>
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