<?php
require_once __DIR__ . '/../config/database.php';

class Movement {
  private $pdo;

  public function __construct(){
    $db = new Database();
    $this->pdo = $db->connect();
  }

  public function all(){
    $sql = "SELECT m.*, p.name AS product_name, p.sku AS product_sku, u.fullname AS user_name
            FROM movements m
            JOIN products p ON p.id = m.product_id
            LEFT JOIN users u ON u.id = m.user_id
            ORDER BY m.id DESC";
    return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
  }

  public function createMovementAndUpdateStock($userId, $productId, $type, $qty, $reason, $note){
    $this->pdo->beginTransaction();

    // lock product row
    $stmt = $this->pdo->prepare("SELECT quantity FROM products WHERE id = ? FOR UPDATE");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$product){
      $this->pdo->rollBack();
      throw new Exception("Produit introuvable");
    }

    $currentQty = (int)$product['quantity'];
    $qty = (int)$qty;

    if($qty <= 0){
      $this->pdo->rollBack();
      throw new Exception("Quantité invalide");
    }

    if($type === 'OUT' && $currentQty < $qty){
      $this->pdo->rollBack();
      throw new Exception("Stock insuffisant (disponible: $currentQty)");
    }

    // insert movement
    $stmt = $this->pdo->prepare("
      INSERT INTO movements(product_id, user_id, type, qty, reason, note)
      VALUES(?,?,?,?,?,?)
    ");
    $stmt->execute([$productId, $userId, $type, $qty, $reason, $note]);

    // update product quantity
    if($type === 'IN'){
      $stmt = $this->pdo->prepare("UPDATE products SET quantity = quantity + ? WHERE id = ?");
      $stmt->execute([$qty, $productId]);
    } else {
      $stmt = $this->pdo->prepare("UPDATE products SET quantity = quantity - ? WHERE id = ?");
      $stmt->execute([$qty, $productId]);
    }

    $this->pdo->commit();
    return true;
  }
}
