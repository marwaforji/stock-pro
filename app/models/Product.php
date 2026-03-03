<?php
require_once __DIR__ . '/../config/database.php';

class Product {
  private $pdo;

  public function __construct(){
    $db = new Database();
    $this->pdo = $db->connect();
  }

  public function all($search = '', $categoryId = 0){
    $sql = "SELECT p.*, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON c.id = p.category_id
            WHERE 1=1";

    $params = [];

    if($search !== ''){
      $sql .= " AND (p.name LIKE ? OR p.sku LIKE ?)";
      $params[] = "%$search%";
      $params[] = "%$search%";
    }

    if($categoryId > 0){
      $sql .= " AND p.category_id = ?";
      $params[] = $categoryId;
    }

    $sql .= " ORDER BY p.id DESC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function find($id){
    $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function create($data){
    $stmt = $this->pdo->prepare("
      INSERT INTO products(name, sku, price, quantity, min_stock, category_id)
      VALUES(?,?,?,?,?,?)
    ");
    return $stmt->execute([
      $data['name'],
      $data['sku'],
      $data['price'],
      $data['quantity'],
      $data['min_stock'],
      $data['category_id'] ?: null
    ]);
  }

  public function update($id, $data){
    $stmt = $this->pdo->prepare("
      UPDATE products
      SET name=?, sku=?, price=?, quantity=?, min_stock=?, category_id=?, updated_at=NOW()
      WHERE id=?
    ");
    return $stmt->execute([
      $data['name'],
      $data['sku'],
      $data['price'],
      $data['quantity'],
      $data['min_stock'],
      $data['category_id'] ?: null,
      $id
    ]);
  }

  public function delete($id){
    $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
    return $stmt->execute([$id]);
  }
  public function countAll(){
  $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM products");
  return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

public function countOutOfStock(){
  $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM products WHERE quantity = 0");
  return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

public function countLowStock(){
  $stmt = $this->pdo->query("SELECT COUNT(*) AS total FROM products WHERE quantity > 0 AND quantity < min_stock");
  return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

public function lowStockList($limit = 5){
  $stmt = $this->pdo->prepare("
    SELECT p.*, c.name AS category_name
    FROM products p
    LEFT JOIN categories c ON c.id = p.category_id
    WHERE p.quantity > 0 AND p.quantity < p.min_stock
    ORDER BY (p.min_stock - p.quantity) DESC
    LIMIT ?
  ");
  $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function outOfStockList($limit = 5){
  $stmt = $this->pdo->prepare("
    SELECT p.*, c.name AS category_name
    FROM products p
    LEFT JOIN categories c ON c.id = p.category_id
    WHERE p.quantity = 0
    ORDER BY p.id DESC
    LIMIT ?
  ");
  $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function outOfStockNames($limit = 10){
  $stmt = $this->pdo->prepare("
    SELECT name
    FROM products
    WHERE quantity = 0
    ORDER BY id DESC
    LIMIT ?
  ");
  $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
public function lowStockNames($limit = 5){
  $stmt = $this->pdo->prepare("
    SELECT name
    FROM products
    WHERE quantity > 0 AND quantity < min_stock
    ORDER BY quantity ASC
    LIMIT ?
  ");
  $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

}
