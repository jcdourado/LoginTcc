<?php
session_start();
if(!usuarioEstaLogado()){
    header("Location: login.php"); exit;
}

function usuarioEstaLogado(){
    return !empty($_SESSION['usuario']);
}
?>
