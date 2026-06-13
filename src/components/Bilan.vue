<template>
  <div class="bilan-container">
    <h2 class="titre">BILAN &amp; VISUALISATION</h2>

    <!-- Cartes stats -->
    <div class="stats">
      <div class="carte">
        <span class="label">MONTANT TOTAL (Σ)</span>
        <p class="valeur total">{{ formatMontant(stats.totalMontant) }}</p>
      </div>
      <div class="carte">
<<<<<<< Updated upstream
        <span class="label">MONTANT MINIMAL</span>
        <p class="valeur minimal">{{ formatMontant(stats.minMontant) }}</p>
      </div>
      <div class="carte">
        <span class="label">MONTANT MAXIMAL</span>
        <p class="valeur maximal">{{ formatMontant(stats.maxMontant) }}</p>
=======
        <p class="titre-carte">MONTANT MINIMAL</p>
        <p class="valeur minimal">{{ produitMin.montant }} Ar</p>
        <p class="nom-produit">{{ produitMin.design }}</p>
      </div>
      <div class="carte">
        <p class="titre-carte">MONTANT MAXIMAL</p>
        <p class="valeur maximal">{{ produitMax.montant }} Ar</p>
        <p class="nom-produit">{{ produitMax.design }}</p>
>>>>>>> Stashed changes
      </div>
    </div>

    <!-- Graphique camembert uniquement -->
    <div class="graphiques">
      <div class="graph-carte">
        <h3>CAMEMBERT — RÉPARTITION</h3>
        <canvas ref="pieRef"></canvas>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Chart from "chart.js/auto";

export default {
  name: 'Bilan',
  data() {
    return {
<<<<<<< Updated upstream
      stats: {},
      produits: []
    };
  },
  mounted() {
    axios.get("http://localhost/backend/bilan.php")
      .then(res => {
        this.stats    = res.data.stats;
        this.produits = res.data.produits;
        this.renderCharts();
      })
      .catch(err => console.error("Erreur chargement bilan:", err));
  },
  methods: {
    formatMontant(val) {
      if (!val) return "0.00 AR";
      return parseFloat(val).toFixed(2) + " AR";
    },
    renderCharts() {
      const labels = this.produits.map(p => p.produit);
      const data   = this.produits.map(p => p.totalMontant);
      const colors = ["#7B6CF6", "#5B8DEF", "#4ADE80", "#FACC15", "#F87171"];

      // Camembert uniquement ✅
      new Chart(this.$refs.pieRef, {
        type: "doughnut",
        data: {
          labels,
          datasets: [{
            data,
            backgroundColor: colors,
            hoverOffset: 10
          }]
        },
        options: {
          plugins: {
            legend: {
              position: "bottom",
              labels: { color: "#ccc", padding: 16 }
            }
          }
        }
      });
=======
      produits: [],
      optionsGraph: {
        responsive: false,
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
    montants() {
      return this.produits.map(p => ({
        design: p.design,
        montant: p.prix * p.quantite
      }))
    },
    totalGeneral() {
      return this.montants.reduce((total, p) => total + p.montant, 0)
    },
    produitMax() {
      if (this.montants.length === 0) return { design: '-', montant: 0 }
      return this.montants.reduce((max, p) =>
        p.montant > max.montant ? p : max
      )
    },
    produitMin() {
      if (this.montants.length === 0) return { design: '-', montant: 0 }
      return this.montants.reduce((min, p) =>
        p.montant < min.montant ? p : min
      )
    },
    dataCamembert() {
      return {
        labels: this.montants.map(p => p.design),
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
>>>>>>> Stashed changes
    }
  }
};
</script>

<style scoped>
<<<<<<< Updated upstream
.bilan-container {
  background-color: #0f1117;
  min-height: 100vh;
  padding: 30px;
  font-family: 'Courier New', monospace;
  color: #ccc;
}
.titre {
  color: #7B6CF6;
  letter-spacing: 3px;
  font-size: 14px;
  margin-bottom: 24px;
=======
.bilan-container { width: 100%; }
h2 {
  color: #1B3162;
  font-size: 13px;
  letter-spacing: 2px;
  margin-bottom: 10px;
>>>>>>> Stashed changes
}
.stats {
  display: flex;
  gap: 20px;
  margin-bottom: 28px;
}
.carte {
  flex: 1;
  background: #1a1d27;
  border: 1px solid #2a2d3a;
  border-radius: 12px;
  padding: 24px;
}
.label {
  font-size: 11px;
  letter-spacing: 2px;
  color: #888;
}
.valeur {
  font-size: 28px;
  font-weight: bold;
<<<<<<< Updated upstream
  margin-top: 10px;
=======
}
.total, .minimal, .maximal { color: white; }
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
>>>>>>> Stashed changes
  letter-spacing: 1px;
}
.total   { color: #5B8DEF; }
.minimal { color: #4ADE80; }
.maximal { color: #FACC15; }
.graphiques {
  display: flex;
  gap: 20px;
}
.graph-carte {
  flex: 1;
  background: #1a1d27;
  border: 1px solid #2a2d3a;
  border-radius: 12px;
  padding: 24px;
}
.graph-carte h3 {
  font-size: 11px;
  letter-spacing: 2px;
  color: #888;
  margin-bottom: 20px;
}
</style>