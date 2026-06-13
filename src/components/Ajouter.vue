<template>
  <div class="ajouter-container">
    <h2>Ajouter un produit</h2>

    <!-- Server response message -->
    <p v-if="serverMessage" :class="serverSuccess ? 'success' : 'error'">
      {{ serverMessage }}
    </p>

    <!-- Design field -->
    <div class="field">
      <input
        v-model="nom"
        type="text"
        placeholder="Nom du produit"
        @input="validateNom"
      />
      <span class="error" v-if="errors.nom">{{ errors.nom }}</span>
    </div>

    <!-- Prix field -->
    <div class="field">
      <input
        v-model="prix"
        type="number"
        placeholder="Prix"
        @input="validatePrix"
      />
      <span class="error" v-if="errors.prix">{{ errors.prix }}</span>
    </div>

    <!-- Quantite field -->
    <div class="field">
      <input
        v-model="quantite"
        type="number"
        placeholder="Quantité"
        @input="validateQuantite"
      />
      <span class="error" v-if="errors.quantite">{{ errors.quantite }}</span>
    </div>

    <button @click="ajouter" :disabled="isLoading">
      {{ isLoading ? 'Enregistrement...' : 'Enregistrer' }}
    </button>
  </div>
</template>

<script>
export default {
  name: 'Ajouter',

  data() {
    return {
      nom: '',
      prix: '',
      quantite: '',
      isLoading: false,
      serverMessage: '',
      serverSuccess: false,
      errors: {
        nom: '',
        prix: '',
        quantite: ''
      }
    }
  },

  methods: {
    // Validate product name field
    validateNom() {
      if (!this.nom.trim()) {
        this.errors.nom = "Le nom du produit est obligatoire"
      } else {
        this.errors.nom = ''
      }
    },

    // Validate price field
    validatePrix() {
      if (!this.prix || this.prix <= 0) {
        this.errors.prix = "Le prix doit être supérieur à 0"
      } else {
        this.errors.prix = ''
      }
    },

    // Validate quantity field
    validateQuantite() {
      if (!this.quantite || this.quantite <= 0) {
        this.errors.quantite = "La quantité doit être supérieure à 0"
      } else {
        this.errors.quantite = ''
      }
    },

    // Handle form submission
    async ajouter() {
      this.validateNom()
      this.validatePrix()
      this.validateQuantite()

      if (this.errors.nom || this.errors.prix || this.errors.quantite) return

      this.isLoading = true
      this.serverMessage = ''

      try {
        const response = await fetch('http://localhost/backend/ajouter.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            design: this.nom,
            prix: parseFloat(this.prix),
            quantite: parseInt(this.quantite)
          })
        })

        const data = await response.json()
        this.serverSuccess = data.success
        this.serverMessage = data.message

        if (data.success) {
          this.nom = ''
          this.prix = ''
          this.quantite = ''
        }
      } catch (e) {
        this.serverSuccess = false
        this.serverMessage = 'Impossible de contacter le serveur'
      } finally {
        this.isLoading = false
      }
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
.field {
  display: flex;
  flex-direction: column;
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
button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
.error {
  color: red;
  font-size: 12px;
  margin-top: 4px;
}
.success {
  color: green;
  font-size: 13px;
}
</style>