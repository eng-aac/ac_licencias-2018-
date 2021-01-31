<?php
require 'database.php';
$message = '';
$vusuario = $_POST['cuil'];

	if (!empty($_POST['cuil'])) {
		$records = $conn->prepare('SELECT id, cuil, password FROM users_personal WHERE cuil = :cuil');
		$records->bindParam(':cuil', $_POST['cuil']);
		
		$records->execute();
		$results = $records->fetch(PDO::FETCH_ASSOC);
		
		if (($_POST['cuil'] == $results['cuil'])) {
		
		$message = 'El usuario que intentas registrar, ya está ingresado.'.'<br>';
        $message .= 'Por favor, intenta nuevamente.';    
		
		} else {
			
			if (!empty($_POST['cuil']) && !empty($_POST['password']) && !empty($_POST['name']) && !empty($_POST['cell']) && !empty($_POST['email'])) {
                
				$sql = "INSERT INTO users_personal (cuil, password, name, cell, email) VALUES (:cuil, :password, :name, :cell, :email)";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':cuil', $_POST['cuil']);
				$stmt->bindParam(':name', $_POST['name']);
				$stmt->bindParam(':cell', $_POST['cell']);
				$stmt->bindParam(':email', $_POST['email']);
	
				$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
				$stmt->bindParam(':password', $password);
		
				if ($stmt->execute()) {
					$message = 'Datos recibidos con éxito.';
				} else {
					$message = 'Disculpe, ha ocurrido un error.';
					}
				}
			}
	}
?>	

<!DOCTYPE html>

<html>

  <head>
    <meta http-equiv="Content-type" content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="icon" type="image/png" href="files/r.png" sizes="32x32">
    <title>AC Licencias 3.0 - REGISTRO DE USUARIO</title>
  </head>
  
  <body>

	<header>
		<a class="a" href="/ac_licencias">Volver al inicio</a><BR><BR>
		<a class="b z" href="login.php">Iniciar Sesión</a><BR><BR>
	</header>
   
    <font color="#C71C1C"><h1 class="sesion_titulo_1">Formulario de Registro</h1></font>
    
	<div class="ingreso o">
	<b>
	<?php if(!empty($stmt)): ?>
		<BR> Usuario <?= $_POST['cuil']; ?> creado satisfactoriamente!<BR>
		<p> <?= $message ?></p><BR>
		<?php else: ?>
		<p> <?= $message ?></p><BR>
    <?php endif; ?>
	</b>
    </div>
    
	<a class="c" href="signup.php">Registrar otro usuario</a>
   
    <footer>
        Autor: Aldo Adrián Castillo - ELECTRICIDAD CASTILLO - Contacto: (261) 15-6934658 - Derechos Reservados © 2018
    </footer>
    
  </body>
  
</html>