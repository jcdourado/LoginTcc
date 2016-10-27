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
			if(!$stmt->execute()){
				$erros[5] = "O usuário já existe!";
			}
			else{
				$_SESSION['usuario'] = getUsuario($con);
	    	header("Location: usuarios.php"); $con = null; exit;
			}
	  }
	  else if (isset($_POST['usuario']) && isset($_POST['senha']) && $_POST['curso'] != ""){
	    $sql = "UPDATE USERS SET usuario = ?,senha = ?, id_curso = ? WHERE ID_USER = ?";
	    $stmt = $con->prepare($sql);
	    $stmt->bindParam(1,$_POST['usuario']);
	    $stmt->bindParam(2,$_POST['senha']);
	    $stmt->bindParam(3,$_POST['curso']);
	    $stmt->bindParam(4,$_GET['id']);
			if(!$stmt->execute()){
				$erros[5] = "O usuário já existe!";
			}
			else{
				$_SESSION['usuario'] = getUsuario($con);
	    	header("Location: usuarios.php"); $con = null; exit;
			}
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
    <title>Atualizar Usuário: <?php echo $usuario['USUARIO']; ?></title>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="css/site.css" rel="stylesheet">
  </head>
  <body>
		<div class="wrap">
    <nav id="w0" class="navbar-inverse navbar-fixed-top navbar" role="navigation"><div class="container"><div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w0-collapse"><span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span></button><a class="navbar-brand" href="/index.php">FATEC Zona Leste - Sistema Gerenciador</a></div><div id="w0-collapse" class="collapse navbar-collapse"><ul id="w1" class="navbar-nav navbar-right nav">
</ul></li></ul></div></div></nav>
    <div class="container">
			<ul class="breadcrumb"><li><a href="/index.php">Home</a></li>
				<li><a href="/usuarios.php">Usuários</a></li>
				<li class="active">Atualizar Usuário: <?php echo $usuario['USUARIO']; ?></li>
			</ul>
					<h1>Atualizar Usuário: <?php echo $usuario['USUARIO']; ?></h1>
			    <form method="post">
						<div <?php if(isset($erros) && count($erros) > 0 && (isset($erros[1]) || isset($erros[3]) || isset($erros[5]) )){
							echo "class='form-group has-error'";
						} else{
								echo 'class="form-group"';
						}?>

						>
							<label class="control-label">Usuário</label>
			        <input class="form-control" type="text" name="usuario" maxlength="25" value="<?php echo $usuario['USUARIO']; ?>"/>
							<?php if(isset($erros[1])){echo "<p class='control-label'>".$erros[1]."</p>";}?>
							<?php if(isset($erros[3])){echo "<p class='control-label'>".$erros[3]."</p>";}?>
							<?php if(isset($erros[5])){echo "<p class='control-label'>".$erros[5]."</p>";}?>
						</div>
						<div <?php if(isset($erros) && count($erros) > 0 && (isset($erros[2]) || isset($erros[4]) )){
							echo "class='form-group has-error'";
						} else{
								echo 'class="form-group"';
						}?>

						>
						 	<label class="control-label">Senha</label>
			        <input type="password" class="form-control" name="senha" maxlength="25"  value="<?php echo $usuario['SENHA']; ?>"/>
							<?php if(isset($erros[2])){echo "<p class='control-label'>".$erros[2]."</p>";}?>
							<?php if(isset($erros[4])){echo "<p class='control-label'>".$erros[4]."</p>";}?>
						</div>
						<div class="form-group">
			        <label class="control-label">Curso</label>
			        <select class="form-control" name="curso">
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
						</div>
							<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Atualizar</button>
				</div>
			</div>
		</div>
	</div>
	<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; FATEC Zona Leste 2016</p>
    </div>
	</footer>
  </body>
</html>
