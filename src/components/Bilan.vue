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
        <span class="label">MONTANT MINIMAL</span>
        <p class="valeur minimal">{{ formatMontant(stats.minMontant) }}</p>
      </div>
      <div class="carte">
        <span class="label">MONTANT MAXIMAL</span>
        <p class="valeur maximal">{{ formatMontant(stats.maxMontant) }}</p>
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
    }
  }
};
</script>

<style scoped>
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
  margin-top: 10px;
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