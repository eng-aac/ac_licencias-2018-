<?php
  session_start();
  if (!isset($_SESSION['user_id'])){
	  header("Location: /ac_licencias"); 
  }
  date_default_timezone_set("America/Argentina/Mendoza");

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

<!DOCtype html>

<html>

  <head>
    <meta http-equiv="Content-type" content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="icon" type="image/png" href="files/rl.png" sizes="32x32">
    <title>AC Licencias 3.0 - CARGA DE LICENCIA</title>
  </head>
  
  <body>

	<header>
		<a class="a" href="login.php">Volver atrás</a><BR><BR>
		<a class="b" href="logout.php">Cerrar Sesión</a><BR><BR>
	</header>
	
    <font color="#C71C1C"><h1 class="sesion_titulo">Carga de Licencia</h1></font>
	
	<form class="licencia" action="loadsi.php" method="POST" enctype="multipart/form-data">
		
		
		<?php   
        include 'database.php';
        
        $cuil = $user['cuil'];
        
        $sql = "SELECT * FROM users_personal WHERE cuil = '$cuil'";
        $stmt = $conn->prepare($sql);
        $sql = "SELECT * FROM users_personal WHERE cuil = '$cuil'";
        $res = $conn->query($sql);
		while ($fila=$res->fetch(PDO::FETCH_ASSOC)) {; 
        ?>
		<div class="datos">
        <div>
            <font color="#ffffff"><label for="name"> Nombre y Apellido del Afectado:</font> </label> <b><font color="#C71C1C"> <?php echo $fila['name']; ?> </font></b>
				<input type=HIDDEN name="name" PLACEHOLDER="Escriba aquí su nombre..." id="name" value="<?php echo $fila['name']; ?>" required> <BR><BR>
		</div>
		<div>
            <label for="cuil"> CUIL - CUIT: </label> <b><font color="#C71C1C"> <?php echo $fila['cuil']; ?> </font></b>
				<input type=HIDDEN name="cuil" PLACEHOLDER="Ingrese su CUIL" pattern="[0-9]{2}[0-9]{7,8}[0-9]{1}" id="cuil" value="<?php echo $fila['cuil']; ?>" required> <BR><BR>
		</div>
		<div>
            <font color="#ffffff"><label for="cell"> Teléfono:</font> </label> <b><font color="#C71C1C"> <?php echo $fila['cell']; ?> </font></b>
				<input type=HIDDEN name="cell" PLACEHOLDER="(Código de Área) - Número" pattern="[0-9]{3,4}-[0-9]{6,7}" id="cell" value="<?php echo $fila['cell']; ?>" required> <BR><BR>
		</div>
		
		<div>	
            <font color="#ffffff"><label for="email"> Correo Electrónico:</font> </label> <b><font color="#C71C1C"> <?php echo $fila['email']; ?> </font></b>
				<input type=HIDDEN name="email" PLACEHOLDER="usuario@servidor.com" pattern=".+\.com" id="email" value="<?php echo $fila['email']; ?>" required> <BR><BR>
		</div>
		
		<?php } ?>
		</div>
		
		<div class="ingreso p">
		<div>
		<label for="address"> Domicilio dónde se encuentra: </label>
				<input type=TEXT name="address" autofocus PLACEHOLDER="Ingrese su domicilio" id="address" required class="ing_i"> <BR><BR>
		</div>
		
		<div>	
		<label> Tipo de Licencia: </label>
				<select name="tipo" class="ing_e" id="tipo" onchange="habilitar(this.value);">
                    <option value="Enfermedad">Enfermedad</option>
                    <option selected value="Razones Particulares">Razones Particulares</option>	
                    <option value="ART">ART</option>
                    <option value="Mesa de Examen">Mesa de Examen</option>
                    <option value="Cursos">Cursos</option>
                    <option value="Embarazo">Embarazo</option>
                    <option value="Paternidad">Paternidad</option>
                    <option value="Otros">Otros</option>
				</select> <br>
		</div>
		
		<label for="comentarios" id="t_comentarios" hidden>Especifique:</label><br>
		<textarea name="comentarios" placeholder="Breve descripción de su licencia..." id="comentarios" hidden></textarea>
		
		<div>
		<label for="sday"> Fecha del comprobante: </label> 
				<input type=DATE name="sday" id="sday" min="<?php echo date("Y-m-01");?>" value="<?php echo date("Y-m-d");?>" required class="ing_i"> <BR><BR>
		</div>
		<div>
		<label for="fday"> Cantidad de días de licencia: </label> 
				<input type=NUMBER name="fday" PLACEHOLDER="Ingrese los días de su licencia" pattern="[0-9]{2}" max="30" id="fday" required class="ing_i"> <BR><BR>
		</div>
        
		<div>
		<label for="foto"> Ingrese comprobante: </label>
	
		<input type=FILE name="foto" id="foto" accept="image/*" required class="ing_i"> <BR><BR>
		</div>
	    </div>
	    
		<div>	
		<input type="submit" align="center" value="ENVIAR" class="btn_e ee">
		<input type="reset" align="center" value="BORRAR" class="btn_l ee">
		</div>
    </form>
    
	<br><br><br><br><br><br><br><br><br>	
    
    <footer>
	    Autor: Aldo Adrián Castillo - ELECTRICIDAD CASTILLO - Contacto: (261) 15-6934658 - Derechos Reservados © 2018 
    </footer>
    	
    <script src="mostrar.js"></script>
	</body>
	
</html>