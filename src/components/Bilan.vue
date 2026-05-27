<template>
  <div class="bilan-container">
    <h2>Bilan</h2>

    <div class="cartes">
      <div class="carte">
        <h3>Total Produits</h3>
        <p>{{ totalProduits }}</p>
      </div>
      <div class="carte">
        <h3>Total Ventes</h3>
        <p>{{ totalVentes }} Ar</p>
      </div>
      <div class="carte">
        <h3>Stock Total</h3>
        <p>{{ stockTotal }}</p>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: 'Bilan',
  data() {
    return {
      totalProduits: 0,
      totalVentes: 0,
      stockTotal: 0
    }
  }
}
</script>

<style>
.bilan-container {
  width: 100%;
}
.cartes {
  display: flex;
  gap: 20px;
  margin-top: 20px;
}
.carte {
  flex: 1;
  padding: 20px;
  background-color: #2c3e50;
  color: white;
  border-radius: 10px;
  text-align: center;
}
.carte h3 {
  margin-bottom: 10px;
  color: #42b883;
}
.carte p {
  font-size: 30px;
  font-weight: bold;
}
</style>