<template>
  <div class="crud-container">
    <h2>Liste des produits</h2>

    <!-- Server response message -->
    <p v-if="serverMessage" :class="serverSuccess ? 'success' : 'error'">
      {{ serverMessage }}
    </p>

    <!-- Products table -->
    <table>
      <thead>
        <tr>
          <th>N°</th>
          <th>Design</th>
          <th>Prix</th>
          <th>Quantité</th>
          <th>Montant</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
<<<<<<< Updated upstream
        <tr v-for="produit in produits" :key="produit.numProduit">
          <td>{{ produit.numProduit }}</td>
=======
        <tr v-for="(produit, index) in produits" :key="produit.numProduit">
          <td>{{ index + 1 }}</td>
>>>>>>> Stashed changes
          <td>{{ produit.design }}</td>
          <td>{{ produit.prix }}</td>
          <td>{{ produit.quantite }}</td>
          <td>{{ produit.montant }}</td>
          <td>
<<<<<<< Updated upstream
            <button class="btn-edit" @click="openEdit(produit)">Modifier</button>
            <button class="btn-delete" @click="supprimer(produit.numProduit)">Supprimer</button>
=======
            <button class="btn-modifier" @click="modifier(produit)">⚙️</button>
            <button class="btn-supprimer" @click="supprimer(produit.numProduit)">🗑️</button>
>>>>>>> Stashed changes
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Edit form (shown when editing) -->
    <div class="edit-form" v-if="editingProduit">
      <h3>Modifier le produit</h3>

      <div class="field">
        <label>Design</label>
        <input v-model="editingProduit.design" type="text" @input="validateDesign" />
        <span class="error" v-if="editErrors.design">{{ editErrors.design }}</span>
      </div>

      <div class="field">
        <label>Prix</label>
        <input v-model="editingProduit.prix" type="number" @input="validatePrix" />
        <span class="error" v-if="editErrors.prix">{{ editErrors.prix }}</span>
      </div>

      <div class="field">
        <label>Quantité</label>
        <input v-model="editingProduit.quantite" type="number" @input="validateQuantite" />
        <span class="error" v-if="editErrors.quantite">{{ editErrors.quantite }}</span>
      </div>

      <button class="btn-save" @click="modifier" :disabled="isLoading">
        {{ isLoading ? 'Enregistrement...' : 'Enregistrer' }}
      </button>
      <button class="btn-cancel" @click="cancelEdit">Annuler</button>
    </div>

  </div>
</template>

<<<<<<< Updated upstream
<script setup>
import { ref, reactive, onMounted } from 'vue'

const API_URL = 'http://localhost/backend/crud.php'

// Data
const produits = ref([])
const editingProduit = ref(null)
const isLoading = ref(false)
const serverMessage = ref('')
const serverSuccess = ref(false)

// Edit form validation errors
const editErrors = reactive({
  design: '',
  prix: '',
  quantite: ''
})

// Validate design field
function validateDesign() {
  if (!editingProduit.value.design.trim()) {
    editErrors.design = "Le design est obligatoire"
  } else {
    editErrors.design = ''
=======
<script>
export default {
  name: 'Crud',
  data() {
    return {
      produits: []
    }
  },
  async mounted() {
    try {
      const response = await fetch('http://localhost/backend/crud.php')
      const data = await response.json()
      if (data.success) {
        this.produits = data.data
      }
    } catch (e) {
      console.error('Erreur chargement produits:', e)
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
      console.log('Modifier:', produit)
    },
    async supprimer(numProduit) {
      if (!confirm('Confirmer la suppression ?')) return
      try {
        const response = await fetch('http://localhost/backend/crud.php', {
          method: 'DELETE',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ numProduit })
        })
        const data = await response.json()
        if (data.success) {
          this.produits = this.produits.filter(p => p.numProduit !== numProduit)
          alert('Produit supprimé !')
        }
      } catch (e) {
        alert('Erreur lors de la suppression')
      }
    }
>>>>>>> Stashed changes
  }
}

// Validate prix field
function validatePrix() {
  if (!editingProduit.value.prix || editingProduit.value.prix <= 0) {
    editErrors.prix = "Le prix doit être supérieur à 0"
  } else {
    editErrors.prix = ''
  }
}

// Validate quantite field
function validateQuantite() {
  if (!editingProduit.value.quantite || editingProduit.value.quantite <= 0) {
    editErrors.quantite = "La quantité doit être supérieure à 0"
  } else {
    editErrors.quantite = ''
  }
}

// Fetch all products on mount
async function fetchProduits() {
  try {
    const response = await fetch(API_URL)
    const data = await response.json()
    if (data.success) {
      produits.value = data.data
    }
  } catch (e) {
    serverMessage.value = 'Impossible de contacter le serveur'
    serverSuccess.value = false
  }
}

// Open edit form with selected product
function openEdit(produit) {
  editingProduit.value = { ...produit }
  serverMessage.value = ''
}

// Cancel editing
function cancelEdit() {
  editingProduit.value = null
  editErrors.design = ''
  editErrors.prix = ''
  editErrors.quantite = ''
}

// Update product
async function modifier() {
  validateDesign()
  validatePrix()
  validateQuantite()

  if (editErrors.design || editErrors.prix || editErrors.quantite) return

  isLoading.value = true
  try {
    const response = await fetch(API_URL, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(editingProduit.value)
    })
    const data = await response.json()
    serverSuccess.value = data.success
    serverMessage.value = data.message
    if (data.success) {
      cancelEdit()
      fetchProduits()
    }
  } catch (e) {
    serverSuccess.value = false
    serverMessage.value = 'Impossible de contacter le serveur'
  } finally {
    isLoading.value = false
  }
}

// Delete product
async function supprimer(numProduit) {
  if (!confirm('Confirmer la suppression ?')) return
  try {
    const response = await fetch(API_URL, {
      method: 'DELETE',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ numProduit })
    })
    const data = await response.json()
    serverSuccess.value = data.success
    serverMessage.value = data.message
    if (data.success) fetchProduits()
  } catch (e) {
    serverSuccess.value = false
    serverMessage.value = 'Impossible de contacter le serveur'
  }
}

// Load products when component mounts
onMounted(fetchProduits)
</script>

<<<<<<< Updated upstream
<style>
.crud-container { width: 100%; }
table { width: 100%; border-collapse: collapse; }
th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
th { background-color: #2c3e50; color: white; }
.btn-edit { padding: 5px 10px; margin: 2px; background: #3498db; color: white; border: none; border-radius: 3px; cursor: pointer; }
.btn-delete { padding: 5px 10px; margin: 2px; background: #e74c3c; color: white; border: none; border-radius: 3px; cursor: pointer; }
.btn-save { padding: 8px 16px; background: #42b883; color: white; border: none; border-radius: 3px; cursor: pointer; margin-right: 8px; }
.btn-cancel { padding: 8px 16px; background: #95a5a6; color: white; border: none; border-radius: 3px; cursor: pointer; }
.edit-form { margin-top: 20px; padding: 16px; border: 1px solid #ccc; border-radius: 5px; }
.field { margin-bottom: 10px; }
.field label { display: block; margin-bottom: 4px; }
.field input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
.error { color: red; font-size: 12px; }
.success { color: green; }
=======
<style scoped>
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
>>>>>>> Stashed changes
</style>