import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import Dashboard from '../views/Dashboard.vue'

const routes = [
  { 
    path: '/', 
    component: Login 
  },
  { 
    path: '/dashboard', 
    component: Dashboard,
    meta: { requiresAuth: true }  // ← protégé
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

// Garde de navigation — redirige si pas connecté
router.beforeEach((to, from, next) => {
  const user = localStorage.getItem('user')
  if (to.meta.requiresAuth && !user) {
    next('/')  // redirige vers login
  } else {
    next()
  }
})

export default router