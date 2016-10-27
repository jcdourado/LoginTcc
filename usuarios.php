<?php
	$con = new PDO('mysql:host=localhost;dbname=tcc_fateczl','root','123456');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Usuários</title>
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
						<li class="active">Usuários</li>
					</ul>
					<h1>Usuários</h1>
					<p><a class="btn btn-primary" href="/registrar.php"><span class="glyphicon glyphicon-plus-sign"></span> Novo Usuário</a>    </p>

			    <table class="table table-striped table-bordered table-hover">
						<thead>
				      <tr>
								<th><a href="#">ID</a></th>
				        <th><a href="#">Usuário</a></th>
				        <th><a href="#">Curso</a></th>
				        <th></th>
				      </tr>
						</thead>
			      <?php foreach($con->query("SELECT ID_USER, NOME_CURSO, USUARIO FROM USERS LEFT JOIN CURSO ON (USERS.ID_CURSO = CURSO.ID_CURSO)") as $row){
							echo "<tr><td>".$row['ID_USER']."</td>";
			        echo "<td>".$row['USUARIO']."</td><td>";
							if ($row['NOME_CURSO'] == ""){
								echo "Sem Curso</td>";
							}else {
								echo $row['NOME_CURSO']."</td>";
							}
							echo "<td><a href='editar.php?id=".$row['ID_USER']."' title='Editar' aria-label='Editar' data-pjax='0'><span class='glyphicon glyphicon-pencil'></span></a>
							<a href='excluir.php?id=".$row['ID_USER']."' title='Excluir' aria-label='Excluir' data-pjax='0'><span class='glyphicon glyphicon-trash'></span></a></td></tr>";
		      	}
						$con = null;
			      ?>
			    </table>
				</div>
			</div>
	<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; FATEC Zona Leste 2016</p>
    </div>
  </footer>

  </body>
</html>
