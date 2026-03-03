<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= $mode === 'create' ? 'Ajouter' : 'Modifier' ?> Produit</title>
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

<div class="container mt-4" style="max-width: 700px;">
  <h3 class="mb-3"><?= $mode === 'create' ? 'Ajouter' : 'Modifier' ?> un produit</h3>

  <?php if(!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Nom</label>
        <input class="form-control" name="name" required
               value="<?= htmlspecialchars($product['name'] ?? '') ?>">
      </div>

      <div class="col-md-6">
        <label class="form-label">SKU (unique)</label>
        <input class="form-control" name="sku" required
               value="<?= htmlspecialchars($product['sku'] ?? '') ?>">
      </div>

      <div class="col-md-4">
        <label class="form-label">Prix</label>
        <input type="number" step="0.01" class="form-control" name="price"
               value="<?= htmlspecialchars($product['price'] ?? 0) ?>">
      </div>

      <div class="col-md-4">
        <label class="form-label">Quantité</label>
        <input type="number" class="form-control" name="quantity"
               value="<?= htmlspecialchars($product['quantity'] ?? 0) ?>">
      </div>

      <div class="col-md-4">
        <label class="form-label">Seuil min</label>
        <input type="number" class="form-control" name="min_stock"
               value="<?= htmlspecialchars($product['min_stock'] ?? 5) ?>">
      </div>

      <div class="col-md-12">
        <label class="form-label">Catégorie</label>
        <select class="form-select" name="category_id">
          <option value="0">-- Aucune --</option>
          <?php foreach($categories as $c): ?>
            <option value="<?= $c['id'] ?>"
              <?= ((int)($product['category_id'] ?? 0) === (int)$c['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($c['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="mt-3">
      <button class="btn btn-primary"><?= $mode === 'create' ? 'Ajouter' : 'Enregistrer' ?></button>
      <a class="btn btn-secondary" href="<?= BASE_URL ?>/index.php?url=products">Annuler</a>
    </div>
  </form>
</div>
</body>
</html>
