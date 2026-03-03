<?php $title = "Produits"; require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/sidebar.php'; ?>

<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Produits</h3>
    <a class="btn btn-primary" href="<?= BASE_URL ?>/index.php?url=product-create">+ Ajouter</a>
  </div>
<a class="btn btn-outline-dark" target="_blank"
   href="<?= BASE_URL ?>/index.php?url=products-print">
  🖨️ PDF
</a>

  <form class="row g-2 mb-3" method="GET" action="<?= BASE_URL ?>/index.php">
    <input type="hidden" name="url" value="products">

    <div class="col-md-5">
      <input class="form-control" name="search" placeholder="Rechercher (nom ou SKU)"
             value="<?= htmlspecialchars($search) ?>">
    </div>

    <div class="col-md-4">
      <select class="form-select" name="category_id">
        <option value="0">Toutes catégories</option>
        <?php foreach($categories as $c): ?>
          <option value="<?= $c['id'] ?>" <?= ($categoryId == $c['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-3 d-grid">
      <button class="btn btn-dark">Filtrer</button>
    </div>
  </form>

  <div class="card shadow-sm">
    <div class="card-body">
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>SKU</th>
            <th>Catégorie</th>
            <th>Prix</th>
            <th>Qté</th>
            <th>Seuil</th>
            <th>Statut</th>
            <th style="width:190px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if(empty($products)): ?>
            <tr><td colspan="9" class="text-center text-muted">Aucun produit</td></tr>
          <?php endif; ?>

          <?php foreach($products as $p): ?>
            <?php
              $status = 'OK';
              if((int)$p['quantity'] == 0) $status = 'OUT';
              else if((int)$p['quantity'] < (int)$p['min_stock']) $status = 'LOW';
            ?>
            <tr>
              <td><?= $p['id'] ?></td>
              <td><?= htmlspecialchars($p['name']) ?></td>
              <td><?= htmlspecialchars($p['sku']) ?></td>
              <td><?= htmlspecialchars($p['category_name'] ?? '-') ?></td>
              <td><?= number_format((float)$p['price'], 2) ?></td>
              <td><?= (int)$p['quantity'] ?></td>
              <td><?= (int)$p['min_stock'] ?></td>
              <td>
                <?php if($status === 'OUT'): ?>
                  <span class="badge bg-danger">OUT</span>
                <?php elseif($status === 'LOW'): ?>
                  <span class="badge bg-warning text-dark">LOW</span>
                <?php else: ?>
                  <span class="badge bg-success">OK</span>
                <?php endif; ?>
              </td>
              <td>
                <a class="btn btn-sm btn-warning" href="<?= BASE_URL ?>/index.php?url=product-edit&id=<?= $p['id'] ?>">Modifier</a>
                <a class="btn btn-sm btn-danger"
                   onclick="return confirm('Supprimer produit ?')"
                   href="<?= BASE_URL ?>/index.php?url=product-delete&id=<?= $p['id'] ?>">
                  Supprimer
                </a>
              </td>
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
