<?php
login();

function login(){
  session_start();

    if (empty($_POST) OR (empty($_POST['usuario']) OR empty($_POST['senha']))) {
      header("Location: login.php?err=emp");
      session_destroy();
      exit;
    } else {
      $con = new PDO('mysql:host=localhost;dbname=tcc_fateczl','root','123456');

      $usuario = $_POST['usuario'];
      $senha = $_POST['senha'];

      $userDB = getUsuario($con,$usuario,$senha);

      if(!$userDB){
        session_destroy();
        header("Location: login.php?err=emp"); $con = null; exit;
      }

      $_SESSION['usuario'] = $userDB;
      header("Location: index.php"); $con = null; exit;
    }
}

function getUsuario($con,$usuario, $senha){
    $sql = "SELECT * FROM USERS WHERE USUARIO = ? AND SENHA = ?";

    $stmt = $con->prepare($sql);
    $stmt->bindParam(1,$usuario);
    $stmt->bindParam(2,$senha);

    if($stmt->execute()){
      return $stmt->fetch();
    }

}


?>
