<?php
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/config/database.php';

$url = $_GET['url'] ?? 'login';

switch($url){
  case 'login':
    require_once __DIR__ . '/../app/controllers/AuthController.php';
    (new AuthController())->login();
    break;

  case 'logout':
    require_once __DIR__ . '/../app/controllers/AuthController.php';
    (new AuthController())->logout();
    break;

 case 'dashboard':
  require_once __DIR__ . '/../app/controllers/DashboardController.php';
  (new DashboardController())->index();
  break;
case 'categories':
  require_once __DIR__ . '/../app/controllers/CategoryController.php';
  (new CategoryController())->index();
  break;

case 'category-create':
  require_once __DIR__ . '/../app/controllers/CategoryController.php';
  (new CategoryController())->create();
  break;

case 'category-edit':
  require_once __DIR__ . '/../app/controllers/CategoryController.php';
  (new CategoryController())->edit();
  break;

case 'category-delete':
  require_once __DIR__ . '/../app/controllers/CategoryController.php';
  (new CategoryController())->delete();
  break;

case 'products':
  require_once __DIR__ . '/../app/controllers/ProductController.php';
  (new ProductController())->index();
  break;

case 'product-create':
  require_once __DIR__ . '/../app/controllers/ProductController.php';
  (new ProductController())->create();
  break;

case 'product-edit':
  require_once __DIR__ . '/../app/controllers/ProductController.php';
  (new ProductController())->edit();
  break;

case 'product-delete':
  require_once __DIR__ . '/../app/controllers/ProductController.php';
  (new ProductController())->delete();
  break;
case 'movements':
  require_once __DIR__ . '/../app/controllers/MovementController.php';
  (new MovementController())->index();
  break;

case 'movement-create':
  require_once __DIR__ . '/../app/controllers/MovementController.php';
  (new MovementController())->create();
  break;
case 'products-print':
  require_once __DIR__ . '/../app/controllers/ProductController.php';
  (new ProductController())->print();
  break;

  default:
    echo "404 Not Found";
}
