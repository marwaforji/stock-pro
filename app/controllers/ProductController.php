<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';

class ProductController {

  private function auth(){
    if(!isset($_SESSION['user'])){
      header("Location: ".BASE_URL."/index.php?url=login");
      exit;
    }
  }

  public function index(){
    $this->auth();

    $search = trim($_GET['search'] ?? '');
    $categoryId = (int)($_GET['category_id'] ?? 0);

    $productModel = new Product();
    $categoryModel = new Category();

    $products = $productModel->all($search, $categoryId);
    $categories = $categoryModel->all();

    require __DIR__ . '/../views/products/index.php';
  }

  public function create(){
    $this->auth();

    $categoryModel = new Category();
    $categories = $categoryModel->all();

    $error = null;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $data = [
        'name' => trim($_POST['name'] ?? ''),
        'sku' => trim($_POST['sku'] ?? ''),
        'price' => (float)($_POST['price'] ?? 0),
        'quantity' => (int)($_POST['quantity'] ?? 0),
        'min_stock' => (int)($_POST['min_stock'] ?? 5),
        'category_id' => (int)($_POST['category_id'] ?? 0),
      ];

      if($data['name'] === '' || $data['sku'] === ''){
        $error = "Nom et SKU obligatoires";
      } else {
        try{
          (new Product())->create($data);
          header("Location: ".BASE_URL."/index.php?url=products");
          exit;
        } catch(Exception $e){
          $error = "Erreur: SKU existe déjà أو بيانات غير صحيحة";
        }
      }
    }

    $mode = 'create';
    $product = ['name'=>'','sku'=>'','price'=>0,'quantity'=>0,'min_stock'=>5,'category_id'=>0];
    require __DIR__ . '/../views/products/form.php';
  }

  public function edit(){
    $this->auth();

    $id = (int)($_GET['id'] ?? 0);
    $productModel = new Product();
    $product = $productModel->find($id);

    if(!$product){
      header("Location: ".BASE_URL."/index.php?url=products");
      exit;
    }

    $categoryModel = new Category();
    $categories = $categoryModel->all();

    $error = null;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $data = [
        'name' => trim($_POST['name'] ?? ''),
        'sku' => trim($_POST['sku'] ?? ''),
        'price' => (float)($_POST['price'] ?? 0),
        'quantity' => (int)($_POST['quantity'] ?? 0),
        'min_stock' => (int)($_POST['min_stock'] ?? 5),
        'category_id' => (int)($_POST['category_id'] ?? 0),
      ];

      if($data['name'] === '' || $data['sku'] === ''){
        $error = "Nom et SKU obligatoires";
      } else {
        try{
          $productModel->update($id, $data);
          header("Location: ".BASE_URL."/index.php?url=products");
          exit;
        } catch(Exception $e){
          $error = "Erreur update (SKU ممكن موجود لمنتج آخر)";
        }
      }
    }

    $mode = 'edit';
    require __DIR__ . '/../views/products/form.php';
  }

  public function delete(){
    $this->auth();

    $id = (int)($_GET['id'] ?? 0);
    (new Product())->delete($id);
    header("Location: ".BASE_URL."/index.php?url=products");
    exit;
  }
  public function print(){
  $this->auth();
  $search = trim($_GET['search'] ?? '');
  $categoryId = (int)($_GET['category_id'] ?? 0);

  $productModel = new Product();
  $products = $productModel->all($search, $categoryId);

  require __DIR__ . '/../views/products/print.php';
}

}
