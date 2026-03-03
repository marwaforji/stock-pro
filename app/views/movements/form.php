<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Nouveau mouvement</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark px-3">
  <a class="navbar-brand text-white" href="<?= BASE_URL ?>/index.php?url=dashboard">Stock Pro</a>
  <div class="text-white">
    <?= $_SESSION['user']['fullname'] ?? 'User' ?> |
    <a class="text-warning" href="<?= BASE_URL ?>/index.php?url=logout">Logout</a>
  </div>
</nav>

<div class="container mt-4" style="max-width: 750px;">
  <h3 class="mb-3">Nouveau mouvement</h3>

  <?php if(!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Produit</label>
        <select class="form-select" name="product_id" required>
          <option value="">-- Choisir --</option>
          <?php foreach($products as $p): ?>
            <option value="<?= $p['id'] ?>">
              <?= htmlspecialchars($p['name']) ?> (<?= htmlspecialchars($p['sku']) ?>) - stock: <?= (int)$p['quantity'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Type</label>
        <select class="form-select" name="type">
          <option value="IN">IN (Entrée)</option>
          <option value="OUT">OUT (Sortie)</option>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Quantité</label>
        <input type="number" class="form-control" name="qty" min="1" required>
      </div>

      <div class="col-md-6">
        <label class="form-label">Raison</label>
        <input class="form-control" name="reason" placeholder="achat / vente / perte / utilisation ...">
      </div>

      <div class="col-md-6">
        <label class="form-label">Note</label>
        <input class="form-control" name="note" placeholder="facultatif">
      </div>
    </div>

    <div class="mt-3">
      <button class="btn btn-primary">Enregistrer</button>
      <a class="btn btn-secondary" href="<?= BASE_URL ?>/index.php?url=movements">Annuler</a>
    </div>
  </form>
</div>
</body>
</html>
