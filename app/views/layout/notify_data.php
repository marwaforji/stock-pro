<?php
require_once __DIR__ . '/../../config/database.php';
$db = new Database();
$pdo = $db->connect();

$outCountN = (int)$pdo->query("SELECT COUNT(*) FROM products WHERE quantity=0")->fetchColumn();
$lowCountN = (int)$pdo->query("SELECT COUNT(*) FROM products WHERE quantity>0 AND quantity<min_stock")->fetchColumn();

$todayMoves = $pdo->prepare("SELECT COUNT(*) FROM movements WHERE DATE(created_at)=CURDATE()");
$todayMoves->execute();
$todayMovesN = (int)$todayMoves->fetchColumn();

$totalNotif = $outCountN + $lowCountN + ($todayMovesN>0 ? 1 : 0);
