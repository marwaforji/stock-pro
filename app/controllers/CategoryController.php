<?php
require_once __DIR__ . '/../models/Category.php';

class CategoryController {

  private function auth(){
    if(!isset($_SESSION['user'])){
      header("Location: ".BASE_URL."/index.php?url=login");
      exit;
    }
  }

  public function index(){
    $this->auth();
    $model = new Category();
    $categories = $model->all();
    require __DIR__ . '/../views/categories/index.php';
  }

  public function create(){
    $this->auth();
    $error = null;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $name = trim($_POST['name'] ?? '');

      if($name === ''){
        $error = "Nom obligatoire";
      } else {
        try{
          (new Category())->create($name);
          header("Location: ".BASE_URL."/index.php?url=categories");
          exit;
        } catch(Exception $e){
          $error = "Catégorie existe déjà أو خطأ في الإدخال";
        }
      }
    }

    $mode = 'create';
    $category = ['name' => ''];
    require __DIR__ . '/../views/categories/form.php';
  }

  public function edit(){
    $this->auth();
    $id = (int)($_GET['id'] ?? 0);
    $model = new Category();
    $category = $model->find($id);

    if(!$category){
      header("Location: ".BASE_URL."/index.php?url=categories");
      exit;
    }

    $error = null;
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $name = trim($_POST['name'] ?? '');
      if($name === ''){
        $error = "Nom obligatoire";
      } else {
        $model->update($id, $name);
        header("Location: ".BASE_URL."/index.php?url=categories");
        exit;
      }
    }

    $mode = 'edit';
    require __DIR__ . '/../views/categories/form.php';
  }

  public function delete(){
    $this->auth();
    $id = (int)($_GET['id'] ?? 0);
    (new Category())->delete($id);
    header("Location: ".BASE_URL."/index.php?url=categories");
    exit;
  }
}
