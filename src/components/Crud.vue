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
        <tr v-for="(produit, index) in produits" :key="produit.numProduit">
          <td>{{ index + 1 }}</td>
          <td>{{ produit.design }}</td>
          <td>{{ produit.prix }}</td>
          <td>{{ produit.quantite }}</td>
          <td class="montant">{{ produit.montant }}</td>
          <td>
            <button class="btn-modifier" @click="openEdit(produit)">⚙️</button>
            <button class="btn-supprimer" @click="askDelete(produit)">🗑️</button>
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

      <button class="btn-save" @click="enregistrerModification" :disabled="isLoading">
        {{ isLoading ? 'Enregistrement...' : 'Enregistrer' }}
      </button>
      <button class="btn-cancel" @click="cancelEdit">Annuler</button>
    </div>

    <!-- Delete confirmation modal -->
    <div class="modal-overlay" v-if="produitToDelete">
      <div class="modal-box">
        <h3>Confirmer la suppression</h3>
        <p>
          Voulez-vous vraiment supprimer
          <strong>{{ produitToDelete.design }}</strong> ?
        </p>
        <p class="modal-warning">Cette action est irréversible.</p>
        <div class="modal-actions">
          <button class="btn-confirm-delete" @click="confirmDelete" :disabled="isDeleting">
            {{ isDeleting ? 'Suppression...' : 'Oui, supprimer' }}
          </button>
          <button class="btn-cancel" @click="produitToDelete = null">Annuler</button>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
const API_URL = 'http://localhost/backend/crud.php'

export default {
  name: 'Crud',

  data() {
    return {
      produits: [],
      editingProduit: null,
      produitToDelete: null,
      isLoading: false,
      isDeleting: false,
      serverMessage: '',
      serverSuccess: false,
      editErrors: {
        design: '',
        prix: '',
        quantite: ''
      }
    }
  },

  async mounted() {
    await this.fetchProduits()
  },

  computed: {
    totalGeneral() {
      return this.produits.reduce((total, produit) => {
        return total + (produit.prix * produit.quantite)
      }, 0)
    }
  },

  methods: {
    async fetchProduits() {
      try {
        const response = await fetch(API_URL)
        const data = await response.json()
        if (data.success) {
          this.produits = data.data
        }
      } catch (e) {
        this.serverSuccess = false
        this.serverMessage = 'Impossible de contacter le serveur'
      }
    },

    validateDesign() {
      if (!this.editingProduit.design.trim()) {
        this.editErrors.design = "Le design est obligatoire"
      } else {
        this.editErrors.design = ''
      }
    },

    validatePrix() {
      if (!this.editingProduit.prix || this.editingProduit.prix <= 0) {
        this.editErrors.prix = "Le prix doit être supérieur à 0"
      } else {
        this.editErrors.prix = ''
      }
    },

    validateQuantite() {
      if (!this.editingProduit.quantite || this.editingProduit.quantite <= 0) {
        this.editErrors.quantite = "La quantité doit être supérieure à 0"
      } else {
        this.editErrors.quantite = ''
      }
    },

    openEdit(produit) {
      this.editingProduit = { ...produit }
      this.serverMessage = ''
      this.editErrors = { design: '', prix: '', quantite: '' }
    },

    cancelEdit() {
      this.editingProduit = null
      this.editErrors = { design: '', prix: '', quantite: '' }
    },

    async enregistrerModification() {
      this.validateDesign()
      this.validatePrix()
      this.validateQuantite()

      if (this.editErrors.design || this.editErrors.prix || this.editErrors.quantite) return

      this.isLoading = true
      try {
        const response = await fetch(API_URL, {
          method: 'PUT',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(this.editingProduit)
        })
        const data = await response.json()
        this.serverSuccess = data.success
        this.serverMessage = data.message
        if (data.success) {
          this.cancelEdit()
          await this.fetchProduits()
        }
      } catch (e) {
        this.serverSuccess = false
        this.serverMessage = 'Impossible de contacter le serveur'
      } finally {
        this.isLoading = false
      }
    },

    // Open delete confirmation modal
    askDelete(produit) {
      this.produitToDelete = produit
      this.serverMessage = ''
    },

    // Confirm and perform deletion
    async confirmDelete() {
      const numProduit = this.produitToDelete.numProduit
      this.isDeleting = true
      try {
        const response = await fetch(API_URL, {
          method: 'DELETE',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ numProduit })
        })
        const data = await response.json()
        this.serverSuccess = data.success
        this.serverMessage = data.message
        if (data.success) {
          this.produits = this.produits.filter(p => p.numProduit !== numProduit)
        }
      } catch (e) {
        this.serverSuccess = false
        this.serverMessage = 'Impossible de contacter le serveur'
      } finally {
        this.isDeleting = false
        this.produitToDelete = null
      }
    }
  }
}
</script>

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
.edit-form {
  margin-top: 20px;
  padding: 16px;
  border: 1px solid #1B3162;
  border-radius: 8px;
}
.field {
  margin-bottom: 10px;
}
.field label {
  display: block;
  margin-bottom: 4px;
  color: #1B3162;
  font-weight: bold;
}
.field input {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
.btn-save {
  padding: 8px 16px;
  background: #42b883;
  color: white;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  margin-right: 8px;
}
.btn-cancel {
  padding: 8px 16px;
  background: #95a5a6;
  color: white;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}
.error {
  color: red;
  font-size: 12px;
  display: block;
  margin-top: 4px;
}
.success {
  color: green;
}

/* Delete confirmation modal */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(27, 49, 98, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}
.modal-box {
  background: white;
  border: 2px solid #1B3162;
  border-radius: 15px;
  padding: 24px 28px;
  width: 320px;
  box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.3);
  text-align: center;
}
.modal-box h3 {
  color: #1B3162;
  margin-bottom: 12px;
}
.modal-box p {
  color: #333;
  margin-bottom: 8px;
}
.modal-warning {
  font-size: 12px;
  color: #e74c3c;
  margin-bottom: 16px;
}
.modal-actions {
  display: flex;
  justify-content: center;
  gap: 10px;
}
.btn-confirm-delete {
  padding: 8px 16px;
  background: #e74c3c;
  color: white;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  font-weight: bold;
  transition: all 0.3s ease;
}
.btn-confirm-delete:hover:not(:disabled) {
  transform: scale(1.08);
}
.btn-confirm-delete:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
</style>