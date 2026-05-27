<template>
  <nav class="navbar">
    <h1>G2Vente</h1>
    <button @click="seDeconnecter">Déconnexion</button>
  </nav>
</template>

<script>
export default {
  name: 'Navbar',
  methods: {
    seDeconnecter() {
      this.$router.push('/')
    }
  }
}
</script>

<style>
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px;
  background-color: #2c3e50;
  color: white;
}
.navbar button {
  padding: 8px 15px;
  background-color: #e74c3c;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
</style>