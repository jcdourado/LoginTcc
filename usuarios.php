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
      <?php foreach($con->query("SELECT NOME_CURSO, USUARIO FROM USERS LEFT JOIN CURSO ON (USERS.ID_CURSO = CURSO.ID_CURSO)") as $row){
        echo "<tr><td>".$row['USUARIO']."</td><td>".$row['NOME_CURSO']."</td></tr>";
      }
      ?>
    </table>

  </body>
</html>
