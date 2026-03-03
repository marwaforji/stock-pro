<?php $title = "Catégories"; require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/sidebar.php'; ?>

<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Catégories</h3>
    <a class="btn btn-primary" href="<?= BASE_URL ?>/index.php?url=category-create">+ Ajouter</a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <table class="table table-bordered table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Nom</th>
            <th style="width:180px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if(empty($categories)): ?>
            <tr><td colspan="3" class="text-center text-muted">Aucune catégorie</td></tr>
          <?php endif; ?>

          <?php foreach($categories as $c): ?>
            <tr>
              <td><?= $c['id'] ?></td>
              <td><?= htmlspecialchars($c['name']) ?></td>
              <td>
                <a class="btn btn-sm btn-warning" href="<?= BASE_URL ?>/index.php?url=category-edit&id=<?= $c['id'] ?>">Modifier</a>
                <a class="btn btn-sm btn-danger"
                   onclick="return confirm('Supprimer  catégorie ?')"
                   href="<?= BASE_URL ?>/index.php?url=category-delete&id=<?= $c['id'] ?>">
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
    <a href="<?= BASE_URL ?>/index.php?url=dashboard" class="btn btn-secondary">← Retour</a>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
