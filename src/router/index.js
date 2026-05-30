import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import Dashboard from '../views/Dashboard.vue'

const routes = [
  { path: '/login',          component: Login },
  { path: '/', component: Dashboard },
]

export default createRouter({
  history: createWebHistory(),
  routes
})