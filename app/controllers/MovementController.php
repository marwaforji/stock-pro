<?php
require_once __DIR__ . '/../models/Movement.php';
require_once __DIR__ . '/../models/Product.php';

class MovementController {

  private function auth(){
    if(!isset($_SESSION['user'])){
      header("Location: ".BASE_URL."/index.php?url=login");
      exit;
    }
  }

  public function index(){
    $this->auth();
    $movements = (new Movement())->all();
    require __DIR__ . '/../views/movements/index.php';
  }

  public function create(){
    $this->auth();

    $productModel = new Product();
    $products = $productModel->all('', 0); // all products

    $error = null;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $productId = (int)($_POST['product_id'] ?? 0);
      $type      = $_POST['type'] ?? 'IN';
      $qty       = (int)($_POST['qty'] ?? 0);
      $reason    = trim($_POST['reason'] ?? '');
      $note      = trim($_POST['note'] ?? '');

      try{
        (new Movement())->createMovementAndUpdateStock(
          $_SESSION['user']['id'],
          $productId,
          $type,
          $qty,
          $reason,
          $note
        );
        header("Location: ".BASE_URL."/index.php?url=movements");
        exit;
      } catch(Exception $e){
        $error = $e->getMessage();
      }
    }

    require __DIR__ . '/../views/movements/form.php';
  }
}
