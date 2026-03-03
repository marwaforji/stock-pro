<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {

  public function login(){
    $error = null;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $email = $_POST['email'];
      $password = $_POST['password'];

      $userModel = new User();
      $user = $userModel->findByEmail($email);

      if($user && password_verify($password, $user['password_hash'])){
        $_SESSION['user'] = $user;
        header("Location: " . BASE_URL . "/index.php?url=dashboard");
        exit;
      } else {
        $error = "Email ou mot de passe incorrect";
      }
    }

    require __DIR__ . '/../views/auth/login.php';
  }

  public function logout(){
    session_destroy();
    header("Location: " . BASE_URL . "/index.php?url=login");
  }
}
