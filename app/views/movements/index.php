<?php $title = "Mouvements"; require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/sidebar.php'; ?>

<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Mouvements (Entrées / Sorties)</h3>
    <a class="btn btn-primary" href="<?= BASE_URL ?>/index.php?url=movement-create">+ Nouveau mouvement</a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Date</th>
            <th>Produit</th>
            <th>SKU</th>
            <th>Type</th>
            <th>Qté</th>
            <th>Raison</th>
            <th>Utilisateur</th>
          </tr>
        </thead>
        <tbody>
          <?php if(empty($movements)): ?>
            <tr><td colspan="7" class="text-center text-muted">Aucun mouvement</td></tr>
          <?php endif; ?>

          <?php foreach($movements as $m): ?>
            <tr>
              <td><?= htmlspecialchars($m['created_at']) ?></td>
              <td><?= htmlspecialchars($m['product_name']) ?></td>
              <td><?= htmlspecialchars($m['product_sku']) ?></td>
              <td>
                <?php if($m['type'] === 'IN'): ?>
                  <span class="badge bg-success">IN</span>
                <?php else: ?>
                  <span class="badge bg-danger">OUT</span>
                <?php endif; ?>
              </td>
              <td><?= (int)$m['qty'] ?></td>
              <td><?= htmlspecialchars($m['reason'] ?? '-') ?></td>
              <td><?= htmlspecialchars($m['user_name'] ?? '-') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-3">
    <a class="btn btn-secondary" href="<?= BASE_URL ?>/index.php?url=dashboard">← Retour</a>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
