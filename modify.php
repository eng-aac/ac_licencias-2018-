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

  if (!isset($_SESSION['user_id'])){
	  header("Location: /ac_licencias"); 
  }
  $message = '';
?>

<!DOCTYPE html>

<html>

  <head>
    <meta http-equiv="Content-type" content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="icon" type="image/png" href="files/m.png" sizes="32x32">
    <title> AC Licencias 3.0 - MODIFICACION </title>
  </head>
  
  <body>
   
    <header></header>
    
        <?php   
        $id = $user['id'];
        require 'database.php';
        $cuil = $user['cuil'];
        $sql = "SELECT * FROM users_personal WHERE id = '$id'";
        $stmt = $conn->prepare($sql);
        $res = $conn->query($sql);
        $columna = $res->fetch(PDO::FETCH_ASSOC);   
        ?>
        <?php if (!empty($_POST)): ?>
        
        <?php
        require 'database.php';
        
        $id = $user['id'];
        $cuil = $_POST['cuil']; 
        $name = $_POST['name'];       
        $cell = $_POST['cell'];       
        $email = $_POST['email'];
        
        $sql = "UPDATE users_personal SET name = '$name', cuil = '$cuil', cell = '$cell', email = '$email' WHERE id = $id";
        $stmt = $conn->prepare($sql);
            
        $res = $conn->query($sql);
        $columna = $res->fetch(PDO::FETCH_ASSOC);
        ?>
        
        <font color="#C71C1C"><h1 class="sesion_titulo_1">Actualización de datos</h1></font> <br>
       
        <?php
        if ($stmt->execute()) {
			$message = 'Datos modificados con éxito.';	
		}else{
            $message = 'Error, no se pudo realizar la actualización.';
        }
        ?>
        
        <div class="ingreso o">
        <p> <?= $message ?></p><br><br>
        </div>
        
        <a class="a j" href="logout.php">Cerrar Sesión</a><BR><BR>
        <a class="b" href="index.php">Volver al inicio</a>
        <br><br>
        
        <?php else: ?>
        
        <font color="#C71C1C"><h1 class="sesion_titulo_1">Actualización de datos</h1></font><br>
		
		<form action="modify.php" method="POST">
		
        
        <div class="ingreso n">
            <label for="id"> USUARIO N°: </label>
            <b><font color="#C71C1C"> <?php echo $user['id']; ?> </font></b><br><br>
        </div>  
        
        <div class="ingreso m">
        <div>
		<label for="cuil"> CUIL - CUIT: </label> 
				<INPUT TYPE=TEXT NAME="cuil" PLACEHOLDER="Ingrese su CUIL" pattern="[0-9]{2}[0-9]{7,8}[0-9]{1}" id="cuil" value="<?php echo $columna['cuil']; ?>" required> <BR><BR>
		</div>
		
		<div>	
		<label for="name"> Nombre y Apellido: </label> 
				<INPUT TYPE=TEXT NAME="name" PLACEHOLDER="Escriba aquí su nombre..." id="name" value="<?php echo $columna['name']; ?>" required> <BR><BR>
		</div>
		<div>
		<label for="cell"> Teléfono: </label> 
				<INPUT TYPE=TEXT NAME="cell" PLACEHOLDER="(Código de Área) - Número" pattern="[0-9]{3,4}-[0-9]{6,7}" id="cell" value="<?php echo $columna['cell']; ?>" required> <BR><BR>
		</div>
		<div>	
		<label for="email"> Correo Electrónico: </label>
				<INPUT TYPE=EMAIL NAME="email" PLACEHOLDER="usuario@servidor.com" pattern=".+\.com" id="email" value="<?php echo $columna['email']; ?>" required> <BR><BR>
		</div>
		</div>
		
		<div>	
		<input type="submit" align="center" VALUE="MODIFICAR" id="btn" class="btn_m">
		<input type="RESET" align="center" VALUE="BORRAR" id="btn" class="btn_e">
	    </div><br><br>
	    
	   <a class="a j" href="logout.php">Cerrar Sesión</a><BR><BR>
       <a class="b" href="index.php">Volver al inicio</a>
    
        <?php endif; ?>  
    
    <br><br>
	<footer>
	    Autor: Aldo Adrián Castillo - ELECTRICIDAD CASTILLO - Contacto: (261) 15-6934658 - Derechos Reservados © 2018
	</footer>

  </body>
  
</html>