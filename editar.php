<?php
	$con = new PDO('mysql:host=localhost;dbname=tcc_fateczl','root','123456');
?>
<?php include 'validacaoUsuario.php';

$sql = "SELECT * FROM USERS WHERE ID_USER = ?";

$stmt = $con->prepare($sql);
$stmt->bindParam(1,$_GET['id']);
$usuario = "";
if($stmt->execute()){
  $usuario = $stmt->fetch();
}
else {
  session_destroy();
  header("Location: index.php"); $con = null; exit;
}

if(isset($_POST)){
	$erros = verErros();
	if(!$erros){
	  if(isset($_POST['usuario']) && isset($_POST['senha']) && ($_POST['curso'] == "")){
	    $sql = "UPDATE USERS SET usuario = ?,senha = ?, id_curso = NULL WHERE ID_USER = ?";
	    $stmt = $con->prepare($sql);
	    $stmt->bindParam(1,$_POST['usuario']);
	    $stmt->bindParam(2,$_POST['senha']);
	    $stmt->bindParam(3,$_GET['id']);
	    $stmt->execute();
			$_SESSION['usuario'] = getUsuario($con);
	    header("Location: usuarios.php"); $con = null; exit;
	  }
	  else if (isset($_POST['usuario']) && isset($_POST['senha']) && $_POST['curso'] != ""){
	    $sql = "UPDATE USERS SET usuario = ?,senha = ?, id_curso = ? WHERE ID_USER = ?";
	    $stmt = $con->prepare($sql);
	    $stmt->bindParam(1,$_POST['usuario']);
	    $stmt->bindParam(2,$_POST['senha']);
	    $stmt->bindParam(3,$_POST['curso']);
	    $stmt->bindParam(4,$_GET['id']);
	    $stmt->execute();
			$_SESSION['usuario'] = getUsuario($con);
	    header("Location: usuarios.php"); $con = null; exit;
	  }
	}
}

function getUsuario($con){
		$sql = "SELECT * FROM USERS WHERE ID_USER = ?";

		$stmt = $con->prepare($sql);
		$stmt->bindParam(1,$_SESSION['usuario']['ID_USER']);

		if($stmt->execute()){
			return $stmt->fetch();
		}
}

function verErros(){
	$erros = array();
	if(isset($_POST['usuario']) && strlen($_POST['usuario']) == 0){
		$erros[1] = "Digite um nome de usuário";
	}
	if(isset($_POST['senha']) && strlen($_POST['senha']) == 0){
		$erros[2] = "Digite uma senha";
	}
	if(isset($_POST['usuario']) && strlen($_POST['usuario']) > 1 && strlen($_POST['usuario']) < 5){
		$erros[3] = "O usuário deve possuir pelo menos 6 caracteres";
	}
	if(isset($_POST['senha']) && strlen($_POST['senha']) > 1 && strlen($_POST['senha']) < 5){
		$erros[4] = "A senha deve possuir pelo menos 6 caracteres";
	}
	return $erros;
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
        <input type="text" name="usuario" maxlength="25" value="<?php echo $usuario['USUARIO']; ?>"/>
				<?php if(isset($erros[1])){echo "<p>".$erros[1]."</p>";}?>
				<?php if(isset($erros[3])){echo "<p>".$erros[3]."</p>";}?>
        <label>Senha</label>
        <input type="password" name="senha" maxlength="25"  value="<?php echo $usuario['SENHA']; ?>"/>
				<?php if(isset($erros[2])){echo "<p>".$erros[2]."</p>";}?>
				<?php if(isset($erros[4])){echo "<p>".$erros[4]."</p>";}?>
        <label>Curso</label>
        <select name="curso">
          <option value="" <?php if($usuario['ID_CURSO'] == "") { echo 'selected="true"';}?>>Sem curso</option>
          <?php foreach($con->query('SELECT ID_CURSO, NOME_CURSO FROM CURSO') as $row){
            echo "<option value='".$row['ID_CURSO']."'";
            if($usuario['ID_CURSO'] == $row['ID_CURSO']){
              echo "selected='true'>".$row['NOME_CURSO']."</option>";
            }else {
              echo ">".$row['NOME_CURSO']."</option>";
            }
          }

          ?>
        </select>
        <input type="submit" value="Atualizar" />
        <a href="usuarios.php">Cancelar</a>
      </fieldset>
    </form>
  </body>
</html>
