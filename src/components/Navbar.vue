//deconnexion
<template>
  <nav class="navbar">
    <h1>GESTION DE VENTE DES PRODUITS</h1>
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
  padding: 5px 20px;
  background-color: white;
  color: #1B3162;
  border: 2px solid #1B3162;
  border-radius: 15px;

}
.navbar button {
  padding: 8px 15px;
  background-color: white;
  color: black;
  border: 2px solid rgb(255, 0, 0);
  border-radius: 5px;
  cursor: pointer;
  transition: all 0.3s ease; 
}
.navbar button:hover {
  transform: scale(1.08);    
}
</style>