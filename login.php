<?php
session_start();
require 'database.php';
$message = '';

	if (isset($_SESSION['user_id'])) {
		header('Location: /ac_licencias');
	}

	if (!empty($_POST['cuil']) && !empty($_POST['password'])) {
		$records = $conn->prepare('SELECT id, cuil, password FROM users_personal WHERE cuil = :cuil');
		$records->bindParam(':cuil', $_POST['cuil']);
	
		$records->execute();
		$results = $records->fetch(PDO::FETCH_ASSOC);
		
    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['user_id'] = $results['id'];
      header("Location: /ac_licencias");
    } else {
		$message = 'Lo siento, las credenciales no coinciden.';
		}
	}
?>

<!DOCTYPE html>

<html>

  <head>
    <meta http-equiv="Content-type" content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="icon" type="image/svg" href="files/is.svg" sizes="32x32">
    <title>AC Licencias 3.0 - INICIO DE SESION</title>
  </head>
  
  <body>
   
    <font color="#C71C1C">
    <div class="ingreso contenido_carga">   
    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>
    </div>
    </font>
    
	<header>
		<a class="a" href="/ac_licencias">Volver al inicio</a><BR><BR>
		<a class="b y" href="signup.php">Regístrate</a><BR><BR>
	</header>
	
    <font color="#C71C1C"><h1 class="sesion_titulo">Inicio de Sesión</h1></font>
    
	<form class="inicio_sesion"action="login.php" method="POST">
		
		<div class="ff">
		<div>
		<label for="cuil"></label>
				<input type=text name="cuil" autofocus placeholder="Ingrese su CUIL" pattern="[0-9]{2}[0-9]{7,8}[0-9]{1}" id="cuil" required> <br><br>
		</div>
		<div>
		<label for="password"></label>
				<input type=password NAME="password" placeholder="Ingrese su nueva contraseña" pattern="[0-9]{8}" title="Una contraseña válida, es un conjuto de caracteres numéricos. Total 8 (ocho) caracteres." id="pass" required> <br><br>
		</div>
		</div>
		
		<div>	
		<input type="submit" align="center" value="INGRESAR" class="btn-enviar">
		<input type="reset" align="center" value="BORRAR" class="btn-limpiar">
		</div>	
    </form>
    <br><br><br><br>
	<footer>
	    Autor: Aldo Adrián Castillo - ELECTRICIDAD CASTILLO - Contacto: (261) 15-6934658 - Derechos Reservados © 2018
	</footer>
	</body>
	
</html>