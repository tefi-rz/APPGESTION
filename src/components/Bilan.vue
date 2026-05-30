//diagramme
<template>
  <div class="bilan-container">
    <h2>BILAN & VISUALISATION</h2>
    <div class="cartes">
      <div class="carte">
        <p class="titre-carte">MONTANT TOTAL</p>
        <p class="valeur total">{{ totalGeneral }} Ar</p>
      </div>
      <div class="carte">
        <p class="titre-carte">MONTANT MINIMAL</p>
        <p class="valeur minimal">{{ produitMin.montant }} Ar</p>
        <p class="nom-produit">{{ produitMin.nom }}</p>
      </div>
      <div class="carte">
        <p class="titre-carte">MONTANT MAXIMAL</p>
        <p class="valeur maximal">{{ produitMax.montant }} Ar</p>
        <p class="nom-produit">{{ produitMax.nom }}</p>
      </div>
    </div>
    <div class="graphique">
      <p class="titre-graphique">CAMEMBERT — RÉPARTITION</p>
      <div class="camembert-wrapper">
        <Doughnut
          :data="dataCamembert"
          :options="optionsGraph"
          :width="250"
          :height="250"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { Doughnut } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title, Tooltip, Legend,
  ArcElement
} from 'chart.js'
ChartJS.register(Title, Tooltip, Legend, ArcElement)

export default {
  name: 'Bilan',
  components: { Doughnut },
  data() {
    return {
      data() {
  return {
    produits: [],   // ← vide
    optionsGraph: {
      responsive: false,
      width: 250,
      height: 250,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            color: '#1B3162',
            font: { size: 10 }
          }
        }
      }
    }
  }
},

// PHP 
async mounted() {
  const response = await fetch('http://localhost/api/produits.php')
  this.produits = await response.json()
},
      optionsGraph: {
        responsive: false,
        width: 250,
        height: 250,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              color: '#1B3162',
              font: { size: 10 }
            }
          }
        }
      }
    }
  },
  computed: {
    montants() {
      return this.produits.map(p => ({
        nom: p.nom,
        montant: p.prix * p.quantite
      }))
    },
    totalGeneral() {
      return this.montants.reduce((total, p) => total + p.montant, 0)
    },
    produitMax() {
      if (this.montants.length === 0) return { nom: '-', montant: 0 }
      return this.montants.reduce((max, p) =>
        p.montant > max.montant ? p : max
      )
    },
    produitMin() {
      if (this.montants.length === 0) return { nom: '-', montant: 0 }
      return this.montants.reduce((min, p) =>
        p.montant < min.montant ? p : min
      )
    },
    dataCamembert() {
      return {
        labels: this.montants.map(p => p.nom),
        datasets: [{
          data: this.montants.map(p => p.montant),
          backgroundColor: [
            '#1B3162',
            '#00BCD4',
            '#42b883',
            '#e74c3c',
            '#f1c40f'
          ],
          borderWidth: 0
        }]
      }
    }
  }
}
</script>

<style>
.bilan-container {
  width: 100%;
}
h2 {
  color: #1B3162;
  font-size: 13px;
  letter-spacing: 2px;
  margin-bottom: 10px;
}
.cartes {
  display: flex;
  gap: 10px;
  margin-bottom: 10px;
}
.carte {
  flex: 1;
  padding: 5px;
  background-color: #2c3e50;
  color: white;
  border-radius: 8px;
  text-align: center;
}
.titre-carte {
  font-size: 10px;
  color: white;
  letter-spacing: 1px;
  margin-bottom: 5px;
}
.valeur {
  font-size: 13px;
  font-weight: bold;
}
.total   { color: white; }
.minimal { color: white; }
.maximal { color: white; }
.nom-produit {
  font-size: 10px;
  color: white;
  margin-top: 3px;
}
.graphique {
  border: 2px solid #00BCD4;
  border-radius: 15px;
  padding: 10px;
}
.titre-graphique {
  color: #1B3162;
  font-size: 11px;
  letter-spacing: 1px;
  margin-bottom: 8px;
  font-weight: bold;
}
.camembert-wrapper {
  width: 250px;
  height: 250px;
  margin: 0 auto;
}
</style>