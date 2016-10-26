<?php
	$con = new PDO('mysql:host=localhost;dbname=tcc_fateczl','root','123456');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Usuários</title>
  </head>
  <body>
    <table>
      <tr>
        <th>Usuário</th>
        <th>Curso</th>
        <th></th>
      </tr>
      <?php foreach($con->query("SELECT ID_USER, NOME_CURSO, USUARIO FROM USERS LEFT JOIN CURSO ON (USERS.ID_CURSO = CURSO.ID_CURSO)") as $row){
        echo "<tr><td>".$row['USUARIO']."</td><td>";
				if ($row['NOME_CURSO'] == ""){
					echo "Sem Curso</td>";
				}else {
					echo $row['NOME_CURSO']."</td>";
				}
				echo "<td><a href='editar.php?id=".$row['ID_USER']."'>Editar</a>
				<a href='excluir.php?id=".$row['ID_USER']."'>Excluir</a></td></tr>";

      }
			$con = null;
      ?>
    </table>


  </body>
</html>
