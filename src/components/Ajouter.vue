//ajouter
<template>
  <div class="ajouter-container">
    <h2>Ajouter un produit</h2>
    <input v-model="nom" type="text" placeholder="Nom du produit" />
    <input v-model="prix" type="number" placeholder="Prix" />
    <input v-model="quantite" type="number" placeholder="Quantité" />
    <button @click="ajouter">Enregistrer</button>
  </div>
</template>

<script>
export default {
  name: 'Ajouter',
  data() {
    return {
      nom: '',
      prix: '',
      quantite: ''
    }
  },
  methods: {
    ajouter() {
      // php sy BD
      console.log('Produit à ajouter:', this.nom, this.prix, this.quantite)
    }
  }
}
</script>

<style>
.ajouter-container {
  display: flex;
  flex-direction: column;
  width: 400px;
  gap: 10px;
}
input {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
button {
  padding: 10px;
  background-color: #1B3162;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
</style>