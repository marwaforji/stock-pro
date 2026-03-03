<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= $title ?? 'Stock Pro' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root{
  --bg:#f6f7fb; --text:#111; --card:#fff; --muted:#6c757d;
}
body.dark{
  --bg:#0f172a;
  --text:#f1f5f9;
  --card:#1e293b;
  --muted:#cbd5e1;
}

body.dark .card {
  border: 1px solid rgba(255,255,255,.05);
}

body.dark .progress {
  background-color: #334155;
}

body.dark .table{ color: var(--text); }
body.dark .table-light{ --bs-table-bg: #1f2937; --bs-table-color: #e5e7eb; }

    body { background:#f6f7fb; }
    .sidebar { min-height: 100vh; }
    .nav-link.active { background: rgba(255,255,255,.12); border-radius: 10px; }
  </style>
</head>
<body>
