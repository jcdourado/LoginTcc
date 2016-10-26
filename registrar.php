<?php
	$con = new PDO('mysql:host=localhost;dbname=tcc_fateczl','root','123456');
?>
<?php include 'validacaoUsuario.php';

if(isset($_SESSION['usuario']['ID_CURSO'])){
  header("Location: index.php");
  exit;
}

if(isset($_POST)){
	$erros = verErros();
	if(!$erros){
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
}

function verErros(){
	$erros = array();
	if(strlen($_POST['usuario']) == 0){
		$erros[1] = "Digite um nome de usuário";
	}
	if(strlen($_POST['senha']) == 0){
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
        <input type="text" name="usuario" maxlength="25" <?php if(isset($_POST['usuario']) && strlen($_POST['usuario']) > 1){ echo "value='".$_POST['usuario']."'";}  ?>/>
				<?php if(isset($erros[1])){echo "<p>".$erros[1]."</p>";}?>
				<?php if(isset($erros[3])){echo "<p>".$erros[3]."</p>";}?>
        <label>Senha</label>
        <input type="password" name="senha" maxlength="25" <?php if(isset($_POST['senha']) && strlen($_POST['senha']) > 1){ echo "value='".$_POST['senha']."'";}  ?>/>
				<?php if(isset($erros[2])){echo "<p>".$erros[2]."</p>";}?>
				<?php if(isset($erros[4])){echo "<p>".$erros[4]."</p>";}?>
        <label>Curso</label>
        <select name="curso">
          <option value="" <?php if(isset($_POST['curso']) && $_POST['curso'] == ""){ echo " selected "; } ?>>Sem curso</option>
          <?php foreach($con->query('SELECT ID_CURSO, NOME_CURSO FROM CURSO') as $row){
            echo "<option value='".$row['ID_CURSO']."' ";
						if(isset($_POST['curso']) && $_POST['curso'] == $row['ID_CURSO']){ echo " selected "; }
						echo ">".$row['NOME_CURSO']."</option>";
          }
					$con = null;
          ?>
        </select>
        <input type="submit" value="Entrar" />
      </fieldset>
    </form>
  </body>
</html>
