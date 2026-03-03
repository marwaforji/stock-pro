<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Produits - PDF</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    @media print { .no-print { display:none; } }
  </style>
</head>
<body class="p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Liste des produits</h3>
    <button class="btn btn-dark no-print" onclick="window.print()">Imprimer / PDF</button>
  </div>

  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>Nom</th><th>SKU</th><th>Prix</th><th>Qté</th><th>Seuil</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($products as $p): ?>
        <tr>
          <td><?= htmlspecialchars($p['name']) ?></td>
          <td><?= htmlspecialchars($p['sku']) ?></td>
          <td><?= number_format((float)$p['price'],2) ?></td>
          <td><?= (int)$p['quantity'] ?></td>
          <td><?= (int)$p['min_stock'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
