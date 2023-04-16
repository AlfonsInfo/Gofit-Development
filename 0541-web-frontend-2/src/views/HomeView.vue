<script>
  import LogoutButton from '../components/LogoutButton.vue';
  import HomeNavbar from '../components/HomeNavbar.vue';
  
  export default{
    mounted(){
      document.body.classList.replace('body-center','body-normalflow')
    },
    components : {
      LogoutButton,
      HomeNavbar
    }
  }
</script>
<template >
  <home-navbar></home-navbar>
  <header>test</header>  
  <logout-button></logout-button>
  <logout-button></logout-button>
</template>

<style scoped>

#app{
  background-color: red;
}
.content-test{
  width: 100px;
  height: 100px;
  background-color: blue;
  margin: 20px;
}


</style>
