//modifier et supprimer
<template>
  <div class="crud-container">
    <h2>Liste des produits</h2>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Nom</th>
          <th>Prix</th>
          <th>Quantité</th>
          <th>Montant</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(produit, index) in produits" :key="produit.id">
          <td>{{ index + 1 }}</td>
          <td>{{ produit.nom }}</td>
          <td>{{ produit.prix }}</td>
          <td>{{ produit.quantite }}</td>
          <td class="montant">{{ produit.prix * produit.quantite }} Ar</td>
          <td>
            <button class="btn-modifier" @click="modifier(produit)">⚙️</button>
            <button class="btn-supprimer" @click="supprimer(produit.id)">🗑️</button>
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
      data() {
  return {
    produits: []  
  }
},

async mounted() {
  const response = await fetch('http://localhost/api/produits.php')
  this.produits = await response.json()
}
    }
  },
  computed: {
    totalGeneral() {
      return this.produits.reduce((total, produit) => {
        return total + (produit.prix * produit.quantite)
      }, 0)
    }
  },
  methods: {
    modifier(produit) {
      // PHP SY BD
      console.log('Modifier:', produit)
    },
    supprimer(id) {
      // PHP SY BD
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
  background-color: #1B3162;
  color: white;
}
.montant {
  color: #1B3162;
  font-weight: bold;
}

.btn-modifier {
  padding: 5px 10px;
  margin: 2px;
  background-color: #1B3162;
  color: white;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}
.btn-supprimer {
  padding: 5px 10px;
  margin: 2px;
  background-color: #e74c3c;
  color: white;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}
</style>