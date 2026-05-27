<template>
  <div>
    <Navbar />

    <div class="boutons">
      <button @click="section = 'ajouter'">Ajouter</button>
      <button @click="section = 'crud'">CRUD</button>
      <button @click="section = 'bilan'">Bilan</button>
    </div>

    <div class="zone-affichage">
      <Ajouter v-if="section === 'ajouter'" />
      <Crud    v-if="section === 'crud'" />
      <Bilan   v-if="section === 'bilan'" />
    </div>
  </div>
</template>

<script>
import Navbar  from '../components/Navbar.vue'
import Ajouter from '../components/Ajouter.vue'
import Crud    from '../components/Crud.vue'
import Bilan   from '../components/Bilan.vue'

export default {
  name: 'Dashboard',
  components: { Navbar, Ajouter, Crud, Bilan },
  data() {
    return {
      section: 'ajouter'
    }
  }
}
</script>

<style>
.boutons {
  display: flex;
  gap: 10px;
  padding: 20px;
}
.boutons button {
  padding: 10px 20px;
  background-color: #42b883;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
.zone-affichage {
  padding: 20px;
}
</style>