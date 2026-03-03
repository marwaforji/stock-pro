<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Dashboard.php';

class DashboardController {
  public function index(){
    if(!isset($_SESSION['user'])){
      header("Location: ".BASE_URL."/index.php?url=login");
      exit;
    }

    $productModel = new Product();
    $dashModel = new Dashboard();

    $totalProducts = $productModel->countAll();
    $outCount = $productModel->countOutOfStock();
    $lowCount = $productModel->countLowStock();

    $outList = $productModel->outOfStockList(5);
    $lowList = $productModel->lowStockList(5);

    $topOut = $dashModel->topOutProducts(5);
    $latestMoves = $dashModel->latestMovements(5);
    $chartRows = $dashModel->movementsByMonth(6);
$outNames = $productModel->outOfStockNames(5); // top 5 names
$lowNames = $productModel->lowStockNames(5);

    require __DIR__ . '/../views/dashboard/index.php';
  }
}
