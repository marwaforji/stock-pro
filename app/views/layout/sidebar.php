<?php
function isActive($key){
  return (CURRENT_URL === $key) ? 'active' : '';
}
require __DIR__ . '/notify_data.php';
?>
<div class="d-flex">

  <!-- SIDEBAR -->
  <aside class="sidebar text-white p-3" style="width:260px; background: linear-gradient(180deg,#111827,#1f2937);">
    <div class="mb-4">
      <div class="fw-bold fs-5">Stock Pro</div>
      <small class="text-white-50"><?= $_SESSION['user']['fullname'] ?? '' ?></small>
    </div>

    <nav class="nav flex-column gap-1">
      <a class="nav-link text-white px-3 py-2 <?= isActive('dashboard') ?>" href="<?= BASE_URL ?>/index.php?url=dashboard">📊 Dashboard</a>
      <a class="nav-link text-white px-3 py-2 <?= isActive('categories') ?>" href="<?= BASE_URL ?>/index.php?url=categories">🗂️ Catégories</a>

      <a class="nav-link text-white px-3 py-2 <?= isActive('products') ?>" href="<?= BASE_URL ?>/index.php?url=products">
        📦 Produits
        <?php if($outCountN > 0): ?>
          <span class="badge bg-danger ms-2"><?= $outCountN ?></span>
        <?php endif; ?>
      </a>

      <a class="nav-link text-white px-3 py-2 <?= isActive('movements') ?>" href="<?= BASE_URL ?>/index.php?url=movements">
        🔄 Mouvements
        <?php if($todayMovesN > 0): ?>
          <span class="badge bg-dark ms-2"><?= $todayMovesN ?></span>
        <?php endif; ?>
      </a>

      <hr class="border-secondary my-3">

      <button class="btn btn-outline-light w-100" onclick="toggleTheme()">
        <span id="themeIcon">🌙</span> Mode
      </button>

      <a class="nav-link text-warning px-3 py-2 mt-2" href="<?= BASE_URL ?>/index.php?url=logout">🚪 Logout</a>
    </nav>
  </aside>

  <!-- MAIN -->
  <main class="p-4" style="width:100%;">

    <!-- TOPBAR (bell) -->
    <div class="d-flex justify-content-end mb-3">
      <div class="dropdown">
        <button class="btn btn-light position-relative shadow-sm"
                data-bs-toggle="dropdown"
                style="border-radius:10px;">
          🔔
          <?php if($totalNotif>0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
              <?= $totalNotif ?>
            </span>
          <?php endif; ?>
        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width: 280px;">
          <li class="dropdown-header">Notifications</li>

          <li>
            <a class="dropdown-item d-flex justify-content-between" href="<?= BASE_URL ?>/index.php?url=products">
              Rupture
              <span class="badge bg-danger"><?= $outCountN ?></span>
            </a>
          </li>

          <li>
            <a class="dropdown-item d-flex justify-content-between" href="<?= BASE_URL ?>/index.php?url=products">
              Faible stock
              <span class="badge bg-warning text-dark"><?= $lowCountN ?></span>
            </a>
          </li>

          <li><hr class="dropdown-divider"></li>

          <li>
            <a class="dropdown-item d-flex justify-content-between" href="<?= BASE_URL ?>/index.php?url=movements">
              Mouvements 
              <span class="badge bg-dark"><?= $todayMovesN ?></span>
            </a>
          </li>
        </ul>
      </div>
    </div>
