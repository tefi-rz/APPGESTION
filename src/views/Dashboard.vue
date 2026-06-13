<template>
  <div>
    <Navbar />
    <div class="contenu">

      <div class="colonne-gauche">
        <button @click="section = 'ajouter'">Ajouter</button>
        <button @click="section = 'crud'">Liste</button>
        <button @click="section = 'bilan'">Bilan</button>
      </div>

      <div class="colonne-droite-wrapper">

        <div class="colonne-droite">
          <Ajouter v-if="section === 'ajouter'" />
          <Crud    v-if="section === 'crud'" />
          <Bilan   v-if="section === 'bilan'" />
        </div>

        <div class="paragraphe-bas">
          <p>Participants: Nolan, Henintsoa, Tefy</p>
        </div>

      </div>

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
.contenu {
  display: flex;
  gap: 20px;
  padding: 20px;
  align-items: flex-start;
}

.colonne-gauche {
  display: flex;
  flex-direction: column;
  gap: 20px;
  padding: 10px;       
}

.colonne-gauche button {
  padding: 15px 25px;
  background-color: #1B3162;
  color: white;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  font-weight: bold;
  box-shadow: 3px 3px 8px rgba(0,0,0,0.3);
  transition: all 0.3s ease;
}

.colonne-gauche button:hover {
  transform: scale(1.08);
}

.colonne-droite-wrapper {
  display: flex;
  flex-direction: column;
  flex: 1;
}

.colonne-droite {
  border: 2px solid #1B3162;
  border-radius: 15px;
  padding: 20px;
  min-height: 450px;
}

.paragraphe-bas {
  margin-top: 2px;
  text-align: center;
  color: black;
  font-size: 14px;
  padding: 10px;
}
</style>