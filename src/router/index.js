import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import Dashboard from '../views/Dashboard.vue'

const routes = [
  { path: '/',          component: Login },
  { path: '/dashboard', component: Dashboard, meta: { requiresAuth: true }},
]

export default createRouter({
  history: createWebHistory(),
  routes
})