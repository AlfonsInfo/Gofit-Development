import { createRouter, createWebHistory ,} from 'vue-router'
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
      name : 'member-tambah',
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
      path:'/member/reset-password',
      name : 'member-reset-password',
      beforeEnter : beforeEnter,
      component: () => import('../views/member/reset-password-member.vue')
    },
    {
      path:'/member/generate-member-card',
      name : 'generate-member-card',
      beforeEnter : beforeEnter,
      component: () => import('../views/member/generate-member-card.vue')
    },
    {
      path:'/instruktur',
      name : 'instruktur',
      beforeEnter : beforeEnter,
      component: () => import('../views/instruktur/index-instruktur.vue')
    },
    {
      path:'/instruktur/tambah',
      name : 'instruktur-tambah',
      beforeEnter : beforeEnter,
      component: () => import('../views/instruktur/create-instruktur.vue')
    },
    {
      path:'/instruktur/ubah',
      name : 'instruktur-ubah',
      beforeEnter : beforeEnter,
      component: () => import('../views/instruktur/update-instruktur.vue')
    },
    {
      path:'/ijin-instruktur',
      name : 'ijin-instruktur',
      beforeEnter : beforeEnter,
      component: () => import('../views/instruktur/ijin-instruktur.vue')
    },
    {
      path:'/jadwal-umum',
      name : 'jadwal-umum',
      beforeEnter : beforeEnter,
      component: () => import('../views/jadwal/index-jadwal.vue')
    },
    {
      path:'/jadwal-umum/tambah',
      name : 'jadwal-umum-tambah',
      beforeEnter : beforeEnter,
      component: () => import('../views/jadwal/create-jadwal-umum.vue')
    },
    {
      path:'/jadwal-umum/ubah',
      name : 'jadwal-umum-ubah',
      beforeEnter : beforeEnter,
      component: () => import('../views/jadwal/update-jadwal-umum.vue')
    },
    {
      path:'/jadwal-harian',
      name : 'jadwal-harian',
      beforeEnter : beforeEnter,
      component: () => import('../views/instruktur/ijin-instruktur.vue')
    },
    {
      path:'/laporan',
      name : 'laporan',
      beforeEnter : beforeEnter,
      component: () => import('../views/instruktur/ijin-instruktur.vue')
    },
    {
      path:'/transaksi-member',
      name : 'transaksi-member',
      beforeEnter : beforeEnter,
      component: () => import('../views/transaksi/transaksi-member.vue')
    },
    {
      path:'/transaksi-member/transaksi-aktivasi',
      name : 'transaksi-aktivasi',
      beforeEnter : beforeEnter,
      component: () => import('../views/transaksi/transaksi-aktivasi.vue')
    },
    {
      path:'/transaksi-member/transaksi-deposit-uang',
      name : 'transaksi-deposit-uang',
      beforeEnter : beforeEnter,
      component: () => import('../views/transaksi/transaksi-deposit-uang.vue')
    },
    {
      path:'/transaksi-member/transaksi-deposit-kelas',
      name : 'transaksi-deposit-kelas',
      beforeEnter : beforeEnter,
      component: () => import('../views/transaksi/transaksi-deposit-kelas.vue')
    },
    {
      path:'/presensi-member',
      name : 'presensi-member',
      beforeEnter : beforeEnter,
      component: () => import('../views/member/presensi-member.vue')
    },

    {
      path:'/presensi-member-kelas',
      name : 'presensi-member-kelas',
      beforeEnter : beforeEnter,
      component: () => import('../views/member/presensi-member-kelas.vue')
    },
    {
      path:'/presensi-member-gym',
      name : 'presensi-member-gym',
      beforeEnter : beforeEnter,
      component: () => import('../views/member/presensi-member-gym.vue')
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
