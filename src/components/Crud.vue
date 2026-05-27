<template>
  <div class="crud-container">
    <h2>Liste des produits</h2>
    <table>
      <thead>
        <tr>
          <th>Nom</th>
          <th>Prix</th>
          <th>Quantité</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="produit in produits" :key="produit.id">
          <td>{{ produit.nom }}</td>
          <td>{{ produit.prix }}</td>
          <td>{{ produit.quantite }}</td>
          <td>
            <button @click="modifier(produit)">Modifier</button>
            <button @click="supprimer(produit.id)">Supprimer</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'Crud',
  data() {
    return {
      produits: [
        { id: 1, nom: 'Produit A', prix: 100, quantite: 10 },
        { id: 2, nom: 'Produit B', prix: 200, quantite: 5 },
      ]
    }
  },
  methods: {
    modifier(produit) {
      // La personne BDD va connecter le PHP ici
      console.log('Modifier:', produit)
    },
    supprimer(id) {
      // La personne BDD va connecter le PHP ici
      console.log('Supprimer id:', id)
    }
  }
}
</script>

<style>
.crud-container {
  width: 100%;
}
table {
  width: 100%;
  border-collapse: collapse;
}
th, td {
  padding: 10px;
  border: 1px solid #ccc;
  text-align: left;
}
th {
  background-color: #2c3e50;
  color: white;
}
button {
  padding: 5px 10px;
  margin: 2px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}
</style>