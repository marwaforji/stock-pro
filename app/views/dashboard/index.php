<?php $title = "Dashboard"; require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/sidebar.php'; ?>

<h3 class="mb-3">Dashboard 📊</h3>

<?php if($outCount > 0): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    ⛔ Rupture: <?= (int)$outCount ?> produit(s).
    <div class="mt-1 small">
      <b>Produits:</b>
      <?= htmlspecialchars(implode(' • ', $outNames ?? [])) ?>
      <?php if($outCount > 5): ?>
        <span class="text-white-50">(+<?= $outCount - 5 ?> autres)</span>
      <?php endif; ?>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<?php if($lowCount > 0): ?>
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    ⚠️ <?= (int)$lowCount ?> produit(s) à faible stock.
    <div class="mt-1 small">
      <b>Produits:</b>
      <?= htmlspecialchars(implode(' • ', $lowNames ?? [])) ?>
      <?php if($lowCount > 5): ?>
        <span class="text-muted">(+<?= $lowCount - 5 ?> autres)</span>
      <?php endif; ?>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<?php
$percentOut = ($totalProducts > 0) ? round(($outCount / $totalProducts) * 100) : 0;
$percentLow = ($totalProducts > 0) ? round(($lowCount / $totalProducts) * 100) : 0;

$labels = [];
$inData = [];
$outData = [];

foreach(($chartRows ?? []) as $row){
  $labels[] = $row['mois'];
  $inData[] = (int)$row['total_in'];
  $outData[] = (int)$row['total_out'];
}
?>

<!-- KPIs -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-body position-relative">
        <div class="text-muted">📦 Total produits</div>
        <div class="fs-2 fw-bold"><?= (int)$totalProducts ?></div>
        <a href="<?= BASE_URL ?>/index.php?url=products" class="stretched-link"></a>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card shadow-sm border-danger">
      <div class="card-body position-relative">
        <div class="text-muted">⛔ Rupture de stock</div>
        <div class="fs-2 fw-bold text-danger"><?= (int)$outCount ?></div>
        <a href="<?= BASE_URL ?>/index.php?url=products" class="stretched-link"></a>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card shadow-sm border-warning">
      <div class="card-body position-relative">
        <div class="text-muted">⚠️ Faible stock</div>
        <div class="fs-2 fw-bold text-warning"><?= (int)$lowCount ?></div>
        <a href="<?= BASE_URL ?>/index.php?url=products" class="stretched-link"></a>
      </div>
    </div>
  </div>
</div>

<!-- Progress bars -->
<div class="card shadow-sm mb-4">
  <div class="card-body">
    <h5 class="mb-3">État du stock</h5>

    <div class="mb-2">Rupture: <b><?= $percentOut ?>%</b></div>
    <div class="progress mb-3" style="height: 10px;">
      <div class="progress-bar bg-danger" style="width: <?= $percentOut ?>%"></div>
    </div>

    <div class="mb-2">Faible stock: <b><?= $percentLow ?>%</b></div>
    <div class="progress" style="height: 10px;">
      <div class="progress-bar bg-warning text-dark" style="width: <?= $percentLow ?>%"></div>
    </div>
  </div>
</div>



<!-- Graph (CUMULATIVE LINE) -->
<div class="card shadow-sm mb-4">
  <div class="card-body">
    <h5 class="mb-3">Mouvements cumulés (IN / OUT)</h5>
    <canvas id="movChart" height="90"></canvas>
    <?php if(empty($labels)): ?>
      <div class="text-muted mt-2">Pas encore de mouvements pour afficher le graphique.</div>
    <?php endif; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = <?= json_encode($labels) ?>;
const inData = <?= json_encode($inData) ?>;
const outData = <?= json_encode($outData) ?>;

// cumulative
let cumIn = [];
let cumOut = [];
let sIn = 0, sOut = 0;

for(let i=0;i<inData.length;i++){
  sIn += Number(inData[i] || 0);
  sOut += Number(outData[i] || 0);
  cumIn.push(sIn);
  cumOut.push(sOut);
}

if(labels.length){
  new Chart(document.getElementById('movChart'), {
    type: 'line',
    data: {
      labels,
      datasets: [
        { label: 'Cumul IN', data: cumIn, tension: 0.25 },
        { label: 'Cumul OUT', data: cumOut, tension: 0.25 }
      ]
    },
    options: {
      responsive: true,
      scales: { y: { beginAtZero: true } }
    }
  });
}
</script>

<!-- Lists -->
<div class="row g-3">
  <div class="col-lg-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="mb-3">Rupture (Top 5)</h5>
        <?php if(empty($outList)): ?>
          <div class="text-muted">Aucun produit en rupture ✅</div>
        <?php else: ?>
          <ul class="list-group">
            <?php foreach($outList as $p): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <div class="fw-semibold"><?= htmlspecialchars($p['name']) ?></div>
                  <small class="text-muted"><?= htmlspecialchars($p['sku']) ?> • <?= htmlspecialchars($p['category_name'] ?? '-') ?></small>
                </div>
                <span class="badge bg-danger">OUT</span>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="mb-3">Faible stock (Top 5)</h5>
        <?php if(empty($lowList)): ?>
          <div class="text-muted">Aucun produit faible ✅</div>
        <?php else: ?>
          <ul class="list-group">
            <?php foreach($lowList as $p): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <div class="fw-semibold"><?= htmlspecialchars($p['name']) ?></div>
                  <small class="text-muted"><?= htmlspecialchars($p['sku']) ?> • Qté: <?= (int)$p['quantity'] ?> / Seuil: <?= (int)$p['min_stock'] ?></small>
                </div>
                <span class="badge bg-warning text-dark">LOW</span>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="mb-3">Top sorties (OUT)</h5>
        <?php if(empty($topOut)): ?>
          <div class="text-muted">Pas encore de sorties</div>
        <?php else: ?>
          <ul class="list-group">
            <?php foreach($topOut as $t): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <div class="fw-semibold"><?= htmlspecialchars($t['name']) ?></div>
                  <small class="text-muted"><?= htmlspecialchars($t['sku']) ?></small>
                </div>
                <span class="badge bg-dark"><?= (int)$t['total_out'] ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Latest movements -->
<div class="card shadow-sm mt-3">
  <div class="card-body">
    <h5 class="mb-3">Derniers mouvements</h5>
    <?php if(empty($latestMoves)): ?>
      <div class="text-muted">Aucun mouvement</div>
    <?php else: ?>
      <ul class="list-group">
        <?php foreach($latestMoves as $m): ?>
          <li class="list-group-item d-flex justify-content-between">
            <div>
              <div class="fw-semibold"><?= htmlspecialchars($m['name']) ?> (<?= htmlspecialchars($m['sku']) ?>)</div>
              <small class="text-muted"><?= htmlspecialchars($m['created_at']) ?></small>
            </div>
            <span class="badge <?= $m['type']==='IN' ? 'bg-success' : 'bg-danger' ?>">
              <?= htmlspecialchars($m['type']) ?> • <?= (int)$m['qty'] ?>
            </span>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
