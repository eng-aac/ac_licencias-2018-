<?php
  session_start();
  require 'database.php';
  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, cuil, password FROM users_personal WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    $user = null;
    if (count($results) > 0) {
      $user = $results;
    }
  }
?>

<!DOCTYPE html>

<html>

  <head>
    <meta http-equiv="Content-type" content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="estilos/estilos_index.css">
    <link rel="icon" type="image/png" href="img/certificado_2.png" sizes="32x32">
    <title> AC Licencias 3.0 - INDEX </title>
  </head>
  
  <body>
   
    <header></header>
    
    <?php if(!empty($user)): ?>
    
        <?php   
        $id = $user['id'];
        require 'database.php';
        $cuil = $user['cuil'];
        $sql = "SELECT * FROM users_personal WHERE id = '$id'";
        $stmt = $conn->prepare($sql);
        $res = $conn->query($sql);
        $columna = $res->fetch(PDO::FETCH_ASSOC);   
        ?>
	
      <font color="#C71C1C"><h1 class="sesion_titulo"><b><br>BIENVENIDO...</b><br></h1></font>
      <h1 class="sesion_titulo_name"><br>Hola, <?php echo $columna['name']; ?>. </b><br></h1></font>
      
      <div class="sesion_datos">
      <b></b><h2><?= $user['cuil']; ?></h2> </b>
      <b><br> Te haz registrado correctamente a AC LICENCIAS 3.0 <br><br></b>
      <b></b><h2>USUARIO N° <?= $user['id']; ?></h2> </b>
	  </div>
	  
      <a class="d" href="load.php">Registrar Licencia<img class="rl" src="files/rl.png" alt=""></a><br>
      <a class="f" href="modify.php">Modificar datos<img class="md" src="files/m.png" alt=""></a><br>
      <a class="j" href="found.php">Buscar datos<img class="md" src="files/buscar.png" alt=""></a><br>
      <a class="e" href="logout.php">Cerrar Sesión<img class="cs" src="files/cs.png" alt=""></a>
   
    
	<?php else: ?>
	
	<img src="img/certificado_2.png" alt="">
	
    <font color="#C71C1C"><h1 class="titulo_p"> AC LICENCIAS 3.0 </h1></font>
    
      <a class="a xx" href="login.php">Inicio de Sesión<img class="is" src="files/is.svg" alt=""></a><br>
      <a class="b tt" href="signup.php">Registro<img class="r" src="files/r.png" alt=""></a><br>
      <a class="c yy" href="autor.html">Nosotros<img class="n" src="files/n.jpg" alt=""></a>
	  
    <?php endif; ?>
	
    <footer></footer>

  </body>
  
</html>