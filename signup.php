<!DOCtype html>

<html>

  <head>
    <meta http-equiv="Content-type" content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="icon" type="image/png" href="files/r.png" sizes="32x32">
    <title>AC Licencias 3.0 - REGISTRO</title>
  </head>
  
  <body>

	<header>
		<a class="a" href="/ac_licencias">Volver al inicio</a><BR><BR>
		<a class="b z" href="login.php">Iniciar Sesión</a><BR><BR>
	</header>
   
    <font color="#C71C1C"><h1 class="sesion_titulo_1">Formulario de Registro</h1></font>
	    <div class="ingreso">
	    <form action="signupsi.php" method="POST">
		<div>	
		<label for="name"> Nombre y Apellido: </label> 
				<input type=TEXT name="name" autofocus placeholder="Escriba aquí su nombre..." id="name" required> <BR><BR>
		</div>
		<div>
		<label for="cuil"> CUIL - CUIT: </label>
				<input type=TEXT name="cuil" placeholder="Ingrese su CUIL" pattern="[0-9]{2}[0-9]{7,8}[0-9]{1}" id="cuil" required> <BR><BR>
		</div>
		<div>
		<label for="cell"> Teléfono: </label> 
				<input type=TEXT name="cell" placeholder="(Código de Área) - Número" pattern="[0-9]{3,4}-[0-9]{6,7}" id="cell" required> <BR><BR>
		</div>
		<div>	
		<label for="email"> Correo Electrónico: </label>
				<input type=EMAIL name="email" placeholder="usuario@servidor.com" pattern=".+\.com" id="email" required> <BR><BR>
		</div>
		<div>
		<label for="password"> Contraseña: </label>
				<input type=PASSWORD name="password" placeholder="Ingrese su nueva contraseña" pattern="[0-9]{8}" title="Una contraseña válida, es un conjuto de caracteres numéricos. Total 8 (ocho) caracteres." id="pass" required> <BR><BR>
		</div>
		</div>
		
		<div>	
		<input type="submit" align="center" VALUE="ENVIAR" class="btn_e" id="btn">
		<input type="RESET" align="center" VALUE="BORRAR" class="btn_l" id="btn">

	    </div>
    </form>
    <br><br><br><br>
	<footer>
	    Autor: Aldo Adrián Castillo - ELECTRICIDAD CASTILLO - Contacto: (261) 15-6934658 - Derechos Reservados © 2018
	</footer>
  </body>
  
</html>