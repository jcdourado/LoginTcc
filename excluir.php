<?php
session_start();
  if(!isset($_GET['id'])){
    header("Location: index.php");
    session_destroy();
    exit;
  }
	$con = new PDO('mysql:host=localhost;dbname=tcc_fateczl','root','123456');

  $sql = "DELETE FROM USERS WHERE ID_USER = ?";

  $stmt = $con->prepare($sql);
  $stmt->bindParam(1,$_GET['id']);
  $stmt->execute();

  $usuario = $_SESSION['usuario']['USUARIO'];
  $senha = $_SESSION['usuario']['SENHA'];

  $userDB = getUsuario($con,$usuario,$senha);

  if(!$userDB){
    session_destroy();
    header("Location: login.php?err=emp"); $con = null; exit;
  }

  header("Location: usuarios.php");
  $con = null;
  exit;

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
