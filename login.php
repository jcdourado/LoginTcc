<?php
session_start();
if(usuarioEstaLogado()){
  header("Location: index.php"); exit;
}

function usuarioEstaLogado(){
    return !empty($_SESSION['usuario']);
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Meu sist</title>
  </head>
  <body>
    <form action="validacao.php" method="post">
      <fieldset>
        <legend>Dados de Login</legend>
        <label>Usuário</label>
        <input type="text" name="usuario" maxlength="25" />
        <?php if(isset($_GET['err'])){
          echo "<p>Digite seu usuário</p>";
        }?>
        <label>Senha</label>

        <input type="password" name="senha" maxlength="25"/>
        <?php if(isset($_GET['err'])){
          echo "<p>Digite sua senha</p>";
        }?>
        <input type="submit" value="Entrar" />
      </fieldset>
    </form>

  </body>
</html>
