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
      // Validation
      if (!this.nom || !this.prix || !this.quantite) {
        alert('Veuillez remplir tous les champs')
        return
      }

      fetch('http://localhost/APPGESTION/backend/ajouter.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          design: this.nom,
          prix: parseFloat(this.prix),
          quantite: parseInt(this.quantite)
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Produit ajouté !')
          this.nom = ''
          this.prix = ''
          this.quantite = ''
        } else {
          alert('Erreur : ' + data.message)
        }
      })
      .catch(error => {
        alert('Impossible de contacter le serveur')
        console.error(error)
      })
    }
  }
}
</script>

<style scoped>
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