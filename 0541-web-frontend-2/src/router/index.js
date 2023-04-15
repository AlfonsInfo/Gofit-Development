import { createRouter, createWebHistory , } from 'vue-router'
import LoginView from '../views/LoginView.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: LoginView
    },
    {
      path: '/Home',
      name: 'Home',
      meta : {
        requiresAuth : true
      },
      beforeEnter: (to, from, next) => {
        if (isLoggedIn()) { // fungsi isLoggedIn() akan mengembalikan true jika pengguna sudah terautentikasi
          next();
        } else {
          next('/'); // redirect ke halaman login jika pengguna belum terautentikasi
        }
      },
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue')
    },
      // route fallback
    {
      path: '/:pathMatch(.*)*',
      redirect: '/'
    }
  ]
})

//Munkin nanti dipindahkan ke helper function
function isLoggedIn()
{
    let token  =localStorage.getItem('access_token')
    console.log(token)
    if(token != null)
      return true;
    return false;
}

export default router
