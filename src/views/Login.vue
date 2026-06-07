<template>
  <div class="login-wrapper">
    <div class="login-box">

      <h2>Connexion</h2>

      <form @submit.prevent="handleLogin">

        <!-- Username field -->
        <div class="field">
          <label>Nom d'utilisateur</label>
          <input
            v-model="username"
            type="text"
            placeholder="Entrez votre nom d'utilisateur"
            @input="validateUsername"
          />
          <span class="error" v-if="errors.username">{{ errors.username }}</span>
        </div>

        <!-- Password field -->
        <div class="field">
          <label>Mot de passe</label>
          <input
            v-model="password"
            :type="showPassword ? 'text' : 'password'"
            placeholder="Entrez votre mot de passe"
            @input="validatePassword"
          />
          <label class="show-pass">
            <input type="checkbox" v-model="showPassword" /> Afficher le mot de passe
          </label>
          <span class="error" v-if="errors.password">{{ errors.password }}</span>
        </div>

        <!-- Server response message -->
        <div v-if="serverMessage">
          <span :class="serverSuccess ? 'success' : 'error'">{{ serverMessage }}</span>
        </div>

        <!-- Submit button -->
        <button type="submit" :disabled="isLoading">
          {{ isLoading ? 'Connexion...' : 'Se connecter' }}
        </button>

      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// Form fields
const username = ref('')
const password = ref('')
const showPassword = ref(false)

// UI state
const isLoading = ref(false)
const serverMessage = ref('')
const serverSuccess = ref(false)

// Validation error messages
const errors = reactive({
  username: '',
  password: ''
})

// Validate username on every keystroke
function validateUsername() {
  if (!username.value.trim()) {
    errors.username = "Le nom d'utilisateur est obligatoire"
  } else if (username.value.trim().length < 3) {
    errors.username = "Minimum 3 caractères"
  } else if (/\s/.test(username.value)) {
    errors.username = "Pas d'espaces autorisés"
  } else {
    errors.username = ''
  }
}

// Validate password on every keystroke
function validatePassword() {
  if (!password.value) {
    errors.password = "Le mot de passe est obligatoire"
  } else if (password.value.length < 3) {
    errors.password = "Minimum 3 caractères"
  } else {
    errors.password = ''
  }
}

// Handle form submission
async function handleLogin() {
  validateUsername()
  validatePassword()
  if (errors.username || errors.password) return

  isLoading.value = true
  serverMessage.value = ''

  try {
    const response = await fetch('http://localhost/backend/login.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        username: username.value.trim(),
        password: password.value
      })
    })
    const data = await response.json()
    if (data.success) {
      serverSuccess.value = true
      serverMessage.value = 'Connexion réussie !'
      localStorage.setItem('user', JSON.stringify(data.user))
      setTimeout(() => router.push('/dashboard'), 800)
    } else {
      serverSuccess.value = false
      serverMessage.value = data.message || 'Identifiants incorrects'
    }
  } catch (e) {
    serverSuccess.value = false
    serverMessage.value = 'Impossible de contacter le serveur'
  } finally {
    isLoading.value = false
  }
}
</script>

<style>
.login-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

.login-box {
  border: 2px solid #1B3162;
  border-radius: 15px;
  padding: 40px;
  width: 350px;
  box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.3);
}

h2 {
  color: #1B3162;
  text-align: center;
  margin-bottom: 24px;
  font-weight: bold;
}

.field {
  margin-bottom: 16px;
}

.field label {
  display: block;
  margin-bottom: 6px;
  color: #1B3162;
  font-weight: bold;
}

.field input[type="text"],
.field input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #1B3162;
  border-radius: 10px;
  font-size: 14px;
  box-sizing: border-box;
}

.show-pass {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  margin-top: 6px;
  color: #1B3162;
  cursor: pointer;
}

button[type="submit"] {
  width: 100%;
  padding: 15px;
  background-color: #1B3162;
  color: white;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  font-weight: bold;
  box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.3);
  transition: all 0.3s ease;
  margin-top: 10px;
}

button[type="submit"]:hover:not(:disabled) {
  transform: scale(1.08);
}

button[type="submit"]:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.error {
  color: red;
  font-size: 12px;
  margin-top: 4px;
  display: block;
}

.success {
  color: green;
  font-size: 13px;
}
</style>