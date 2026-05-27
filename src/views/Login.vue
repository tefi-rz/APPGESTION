<template>
  <div class="login-container">
    <h2>Connexion</h2>
    <input v-model="email" type="email" placeholder="Email" />
    <input v-model="password" type="password" placeholder="Mot de passe" />
    <button @click="seConnecter">Se connecter</button>
  </div>
</template>

<script>
export default {
  name: 'Login',
  data() {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    seConnecter() {
      this.$router.push('/dashboard')
    }
  }
}
</script>

<style>
.login-container {
  display: flex;
  flex-direction: column;
  width: 300px;
  margin: 100px auto;
  gap: 10px;
}
input {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
button {
  padding: 10px;
  background-color: #42b883;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
</style>