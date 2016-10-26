<?php
session_start();
if(!usuarioEstaLogado()){
    header("Location: login.php?err=emp"); exit;
}

function usuarioEstaLogado(){
    return !empty($_SESSION['usuario']);
}
?>
