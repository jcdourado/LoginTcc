<?php
	$con = new PDO('mysql:host=localhost;dbname=tcc_fateczl','root','123456');
?>
<?php include 'validacaoUsuario.php';

if(isset($_SESSION['usuario']['ID_CURSO'])){
  header("Location: index.php");
  exit;
}

if(isset($_POST)){

  if(isset($_POST['usuario']) && isset($_POST['senha']) && ($_POST['curso'] == "")){
    $sql = "INSERT INTO USERS(usuario,senha) VALUES (?,?)";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(1,$_POST['usuario']);
    $stmt->bindParam(2,$_POST['senha']);
    $stmt->execute();
  }
  else if (isset($_POST['usuario']) && isset($_POST['senha']) && $_POST['curso'] != ""){
    $sql = "INSERT INTO USERS(usuario,senha,id_curso) VALUES (?,?,?)";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(1,$_POST['usuario']);
    $stmt->bindParam(2,$_POST['senha']);
    $stmt->bindParam(3,$_POST['curso']);
    $stmt->execute();
  }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form method="post">
      <fieldset>
        <legend>Dados de Login</legend>
        <label>Usuário</label>
        <input type="text" name="usuario" maxlength="25" />
        <label>Senha</label>
        <input type="password" name="senha" maxlength="25"/>
        <label>Curso</label>
        <select name="curso">
          <option value="">Sem curso</option>
          <?php foreach($con->query('SELECT ID_CURSO, NOME_CURSO FROM CURSO') as $row){
            echo "<option value='".$row['ID_CURSO']."'>".$row['NOME_CURSO']."</option>";
          }
          ?>
        </select>
        <input type="submit" value="Entrar" />
      </fieldset>
    </form>
  </body>
</html>
