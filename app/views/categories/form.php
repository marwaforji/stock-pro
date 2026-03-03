<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= $mode === 'create' ? 'Ajouter' : 'Modifier' ?> Catégorie</title>
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

<div class="container mt-4" style="max-width: 600px;">
  <h3 class="mb-3"><?= $mode === 'create' ? 'Ajouter' : 'Modifier' ?> une catégorie</h3>

  <?php if(!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <label class="form-label">Nom</label>
    <input class="form-control mb-3" name="name" value="<?= htmlspecialchars($category['name'] ?? '') ?>" required>

    <button class="btn btn-primary"><?= $mode === 'create' ? 'Ajouter' : 'Enregistrer' ?></button>
    <a class="btn btn-secondary" href="<?= BASE_URL ?>/index.php?url=categories">Annuler</a>
  </form>
</div>
</body>
</html>
