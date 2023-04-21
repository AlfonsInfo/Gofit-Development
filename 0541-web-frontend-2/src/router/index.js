import { createRouter, createWebHistory , } from 'vue-router'
import LoginView from '../views/LoginView.vue'


const beforeEnter = (to, from, next) => {
  if (isLoggedIn()) { // fungsi isLoggedIn() akan mengembalikan true jika pengguna sudah terautentikasi
    next();
  } else {
    next('/'); // redirect ke halaman login jika pengguna belum terautentikasi
  }
}


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView,
      beforeEnter: (to, from, next) => {
        if (isLoggedIn()) { // fungsi isLoggedIn() akan mengembalikan true jika pengguna sudah terautentikasi
          next('/Home'); // redirect ke halaman Home jika pengguna sudah terautentikasi
        } else {
          next(); 
        }
      }
    },
    {
      path: '/Home',
      name: 'Home',
      // meta : {
      //   requiresAuth : true
      // },
      beforeEnter: beforeEnter,
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/HomeView.vue')
    },
    {
      path:'/member',
      name : 'member',
      beforeEnter : beforeEnter,
      component: () => import('../views/member/index-member.vue')
    },
    {
      path:'/member/tambah',
      name : 'MemberCreate',
      beforeEnter : beforeEnter,
      component: () => import('../views/member/create-member.vue')
    },
    {
      path: '/member/Ubah',
      name: 'member-ubah',
      beforeEnter: beforeEnter,
      component: () => import('../views/member/update-member.vue')
    },
    {
      path:'/reset-password-member',
      name : 'MemberReset',
      beforeEnter : beforeEnter,
      component: () => import('../views/member/reset-password-member.vue')
    },
    {
      path:'/instruktur',
      name : 'Instruktur',
      beforeEnter : beforeEnter,
      component: () => import('../views/instruktur/index-instruktur.vue')
    },
    {
      path:'/ijin-instruktur',
      name : 'IjinInstruktur',
      beforeEnter : beforeEnter,
      component: () => import('../views/instruktur/ijin-instruktur.vue')
    },
    // route fallback
    {
      path: '/:pathMatch(.*)*',
      redirect: '/'
    }
  ],
})

//Munkin nanti dipindahkan ke helper function
function isLoggedIn()
{
    let token  =localStorage.getItem('token')
    if(token != null)
      return true;
    return false;
}

export default router

//* Tombol logout 



// const dynamicImport = (path) => import(path)
// const importPath = async (suffixLink) => {
//     const path = `../views/${suffixLink}`
//     console.log(path)
//     return dynamicImport(path)
// }
