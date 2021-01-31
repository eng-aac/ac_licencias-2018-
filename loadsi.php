<?php
session_start();
require 'database.php';

$message = '';
$resultado ='';
$consulta = '';

	if (!empty($_POST['tipo']) && !empty($_POST['sday']) && !empty($_POST['fday']) && !empty($_POST['name']) && !empty($_POST['cuil']) && !empty($_POST['cell']) && !empty($_POST['email']) && !empty($_POST['address']) && !empty($_FILES['foto'])) {
		
		$nameFile = $_FILES['foto']['name'];
		$sizeFile = $_FILES['foto']['size'];
		$typeFile = $_FILES['foto']['type'];
		$tempFile = $_FILES['foto']['tmp_name'];
		
		copy($tempFile,$nameFile);
		$ruta = "files";
		$ruta = $ruta."/".$nameFile;
		move_uploaded_file($tempFile, $ruta);

		$archivo_objetivo = fopen($ruta, "r+");
		$file = fread($archivo_objetivo, $sizeFile);
		$file = addslashes($file);
		$file = base64_encode($file); 
		fclose($archivo_objetivo);
		
		$sql = "INSERT INTO load_license (cuil, tipo, comentarios, sday, fday, address, foto) VALUES (:cuil, :tipo, :comentarios, :sday, :fday, :address, :foto)";
		$stmt = $conn->prepare($sql);
		
        $stmt->bindParam(':cuil', $_POST['cuil']);
		$stmt->bindParam(':tipo', $_POST['tipo']);
        $stmt->bindParam(':comentarios', $_POST['comentarios']);
		$stmt->bindParam(':sday', $_POST['sday']);
		$stmt->bindParam(':fday', $_POST['fday']);
		$stmt->bindParam(':address', $_POST['address']);
		$stmt -> bindParam(':foto', $nameFile);
		
		if ($stmt->execute()) {
			$message = 'Comprobante cargado con éxito.';	
		} else {
            $message = 'Comprobante no recibido, por favor intente nuevamente más tarde.';
        }
        
		function laconsulta(){
		
		global $conn, $consulta;
		$sql = 'SELECT * FROM load_license order by id desc limit 1';
		return $conn->query($sql);
		}	
		$consulta = laconsulta();
	}
    
    function selectTabla(){
            
            include 'database.php';
        
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
        
            $stmt = $conn->prepare($sql);
            $sql = 'SELECT * FROM load_license order by id desc limit 1';
            $res = $conn->query($sql);
            
            $cuil = $user['cuil'];
            $stmti = $conn->prepare($sqli);
            $sqli = "SELECT * FROM users_personal WHERE cuil = '$cuil'";
            $resi = $conn->query($sqli);
        
            $fila2 = $resi->fetch(PDO::FETCH_ASSOC);
            
            $tabla = '';
            
            while($fila = $res->fetch(PDO::FETCH_ASSOC)){ 
                
            $tabla .= '<html>
                          <head>
                            <meta http-equiv="Content-type" content="text/html" charset="UTF-8">
                            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                            <link rel="shortcut icon" type="image/x-icon" href="i_ico.ico" size="32x32">
                            <link rel="stylesheet" href="estilos/estilos_comprobante.css">
                            <title> AC Licencias 3.0 - Comprobante WEB </title>
                          </head>
                          <body>
                            <header>
                            <img class="cm" src="img/certificado_2.png" width=120px height=100px/><h2><b>Comprobante WEB</b></h2><br><br><hr>
                            </header>
                            <br>
                            <h1>Carga de Licencia</h1>
                            <font color="#C71C1C"><br><b>COMPLETADO. LICENCIA CARGADA A -> '.$fila['cuil'].'</b></font><br><br>
                        ';
	        $tabla .= '
                        <h3>Comprobante Recibido</h3>
                        <br><br>  
                        <table class="pdf_tabla">
                        <tr>
                            <th>TIPO</th>
                            <th>NOMBRE</th>
                            <th>CUIL</th>
                            <th>FECHA DEL COMPROBANTE</th>
                            <th>CANTIDAD DE DIAS</th>
                            <th>DOMICILIO</th>
                            <th>CELULAR</th>
                            <th>EMAIL</th>
                            <th>CERTIFICADO</th>
                        </tr>
                        ';
            $tabla .= '
                        <tr>
                            <td>'.$fila['tipo'].'</td>
                            <td>'.$fila2['name'].'</td>
                            <td>'.$fila['cuil'].'</td>
                            <td>'.str_replace('-','/', date('d-m-Y', strtotime($fila['sday']))).'</td>
                            <td>'.$fila['fday'].'</td>
                            <td>'.$fila['address'].'</td>
                            <td>'.$fila2['cell'].'</td>
                            <td>'.$fila2['email'].'</td>
                            <td><img src="files/'.$fila['foto'].'" width=100px height=100px/></td>
                        </tr>
                            ';
        
	        $tabla .= '</table>';
            $tabla .= '<br>';
            
            if ($fila['tipo']=="Otros"){
                
            $tabla .= '<b><font color="#C71C1C">Descripción del Usuario: </font>'.$fila['comentarios'].'</b><br><br>';
            }
            }
        
            $tabla .= '<img src="img/recibido.png" width=180px height=180px/>';
            $tabla .= '<img src="img/copia_fiel.jpg" width=180px height=180px/>';
            $tabla .= '<br><br>';
            $tabla .= '<b><font color="#C71C1C">'.str_replace('-','/', date('d-m-Y')).'</font></b>'.'<div align=right>Firma Registrada<img src="img/firma.png" width=100px height=100px/></div>';
            $tabla .= '<b><h4>USUARIO N° '.$user['id'].'</h4></b>';
            $tabla .= '<h4>GRACIAS POR UTILIZAR AC LICENCIAS 3.0</h4><br>'; 
            $tabla .= '<footer><hr><span>AC Licencias 3.0 - Derechos Reservados &copy; 2018</span></footer>';
            $tabla .= '</body></html>';
            return $tabla;
        }
        
        if(isset($_POST['generar'])){
        
        include 'mpdf/mpdf.php';
        $html = selectTabla();
        
        $mpdf=new mPDF('c');
        $mpdf->WriteHTML($html);
        $mpdf->Output('comprobante.pdf', 'I');
        exit;
        }
   
        if(isset($_POST['envio'])){
        
        include 'mpdf/mpdf.php';
        include 'mpdf/AttachMailer.php';
        $html = selectTabla(); 
        
        $mpdf=new mPDF('c', 'A4');
        $mpdf->WriteHTML($html);
        $archivo="files/comprobante.pdf";
        $mpdf->Output($archivo, 'F');
        
        include 'database.php';
            
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
            
            $stmt = $conn->prepare($sql);
                
            $sql ='SELECT * FROM load_license order by id desc limit 1';
            $res = $conn->query($sql);
       
            $cuil = $user['cuil'];
            $stmti = $conn->prepare($sqli);
            $sqli = "SELECT * FROM users_personal WHERE cuil = '$cuil'";
            $resi = $conn->query($sqli);
            $fila2 = $resi->fetch(PDO::FETCH_ASSOC);
        
        while($fila = $res->fetch(PDO::FETCH_ASSOC)){
            
            $comprobante_web = '
                        <html>
                                <head>
                                    <meta http-equiv="Content-type" content="text/html" charset="UTF-8">
                                    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                                    <link rel="stylesheet" href="estilos/estilos_comprobante.css">
                                    <link rel="icon" type="image/png" href="files/bpg.png" sizes="32x32">
                                    <title> AC Licencias 3.0 - Comprobante WEB</title>    
                                </head>
                                <body>
                    
                                    <h1>Carga de Licencia</h1><hr>
                                    <font color="#C71C1C"><br><b>COMPLETADO. LICENCIA CARGADA A -> '.$fila['cuil'].'</b></font><br><br>
                                    
                                    <h3>Comprobante Recibido con éxito.</h3>
                                    <h4>GRACIAS POR UTILIZAR LICENCIAS AC 3.0.</h4><br><br>
                                    <div>
                                        <a href="../localthost/ac_licencias/index.php">AC Licencias 3.0</a>
                                    </div>
                                    <footer><hr><span>AC Licencias 3.0 - Derechos Reservados &copy; 2018</span></footer>
                                </body>
                        </html>
            
            
            ';
            
            $destinatario = $fila2['email'].',';
            $destinatario .='electricidad.castillo.g@gmail.com';
            
            $mailer = new AttachMailer("electricidad.castillo.g@gmail.com", $destinatario, "AC Licencias", $comprobante_web);
            
        }
            $mailer->attachFile($archivo);
            $resultado = $mailer->send() ? '
                        <html>

                                  <head>
                                    <meta http-equiv="Content-type" content="text/html" charset="UTF-8">
                                    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                                    <link rel="stylesheet" href="estilos/estilos.css">
                                    <link rel="icon" type="image/png" href="files/ep.png" sizes="32x32">
                                    <title> AC Licencias 3.0 - Envío Comprobante WEB</title> 
                                  </head>

                                  <body>

                                    <header>
                                        <a class="a" href="login.php">Volver atrás</a><br><br>
                                    </header>

                                    <span><a class="b" href="logout.php">Cerrar Sesión</a></span>

                                    <font color="#C71C1C"><h1 class="sesion_titulo">Carga de Licencia</h1></font>
                                    
                                    <div class="ingreso contenido_carga">
                                    <font color="#C71C1C"><h3>Enviado correctamente.</h3></font>
                                    <h4>GRACIAS POR UTILIZAR LICENCIAS AC 3.0.</h4>
                                    <br>
                                    </div>
                                    
                                    <a class="c" href="load.php">Cargar otra licencia</a>
                                    
                                    <br><br><br><br><br><br>
                                    <footer>
                                        Autor: Aldo Adrián Castillo - ELECTRICIDAD CASTILLO - Contacto: (261) 15-6934658 - Derechos Reservados © 2018
                                    </footer>
                                    </body>
                        </html>
                        ':
                        '
                        <html>

                                  <head>
                                    <meta http-equiv="Content-type" content="text/html" charset="UTF-8">
                                    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                                    <link rel="stylesheet" href="estilos/estilos.css">
                                    <link rel="icon" type="image/png" href="files/ep.png" sizes="32x32">
                                    <title> AC Licencias 3.0 - Envío Comprobante WEB</title>   
                                  </head>

                                  <body>

                                    <header>
                                        <a class="a" href="login.php">Volver atrás</a><br><br>
                                    </header>

                                    <span><a class="b" href="logout.php">Cerrar Sesión</a></span>

                                    <font color="#C71C1C"><h1 class="sesion_titulo">Carga de Licencia</h1></font>
                                    
                                    <div class="ingreso contenido_carga">
                                    <font color="#C71C1C"><h3>Error. No se pudo enviar el archivo.</h3></font>
                                    <h4>GRACIAS POR UTILIZAR AC LICENCIAS 3.0.</h4>
                                    <br>
                                    </div>
                                    
                                    <a class="c" href="load.php">Cargar otra licencia</a>
                                    
                                    <br><br><br><br><br><br>
                                    <footer>
                                        Autor: Aldo Adrián Castillo - ELECTRICIDAD CASTILLO - Contacto: (261) 15-6934658 - Derechos Reservados © 2018
                                    </footer>
                                    </body>
                        </html>
                        ';
            
            echo($resultado);
            exit;
    }

?>

<!DOCTYPE html>

<html>

  <head>
    <meta http-equiv="Content-type" content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="icon" type="image/png" href="files/rl.png" sizes="32x32">
    <title>AC Licencias 3.0 - CARGA RECIBIDA</title>    
  </head>
  
  <body>
	
	<header>
		<a class="a" href="login.php">Volver atrás</a><br><br>
		<a class="b" href="logout.php">Cerrar Sesión</a>
	</header>
	
    <font color="#C71C1C"><h1 class="sesion_titulo">Carga de Licencia</h1></font>

    <b> <?php if(!empty($stmt)): ?>
    
    <div class="ingreso contenido_carga">
        
        <br><font color="#C71C1C">COMPLETADO. LICENCIA CARGADA A -> <?=$_POST['cuil'] ?></font><br><br>
	
	<h3>Comprobante Cargado</h3>
	</b>
	<br><br>
	<table class="tabla_cargada">
		
		<thead>
			<th>TIPO</th>
			<th>NOMBRE</th>
			<th>CUIL</th>
			<th>FECHA DEL COMPROBANTE</th>
			<th>CANTIDAD DE DIAS</th>
			<th>DOMICILIO</th>
			<th>CELULAR</th>
			<th>EMAIL</th>
			<th>CERTIFICADO</th>
			
		</thead>
		<tbody>
		
		<?php while($comprobante = $consulta->fetch(PDO::FETCH_ASSOC)) { ?>
		<tr>
				<td><?php echo $_POST['tipo'];?></td>
				<td><?php echo $_POST['name'];?></td>
				<td><?php echo $_POST['cuil'];?></td>
				<td><?php echo str_replace('-','/', date('d-m-Y', strtotime($_POST['sday'])));?></td>
				<td><?php echo $_POST['fday'];?></td>
				<td><?php echo $_POST['address'];?></td>
				<td><?php echo $_POST['cell'];?></td>
				<td><?php echo $_POST['email'];?></td>
				<td><?php echo '<img src="'.$ruta.'" width="300" heigth="300">'?></td>
		</tr>
		</tbody>
		
		<?php } ?>
	
	</table><br><br>
	
	<?php 
      if ($_POST['tipo']=="Otros"){
        echo ('<b><font color="#C71C1C">'.'<h4>Descripción del Usuario: </b></font>'.$_POST['comentarios'].'.</h4>');
      }
	?>
	<br>
	<b><font color="#C71C1C">
	<p> <?= $message ?></p> <br>

	<?php else: ?>
		<?php header('Location: /ac_licencias/load.php');?>
		<p> <?= $message ?></p> 
    <?php endif; ?>
	</b>
    </font>
                <div>
              	    <form method="post" target="_blank" link rel="icon" type="image/png" href="files/ep.png" sizes="32x32">
                        <button type="submit" name="generar" value="Generar PDF" class="texto_btn_pdf ggg" >Generar PDF<img src="files/bpg.png" class="button_generar_pdf h" alt=""></button>
                    </form>
                </div>
                <div>
              	    <form method="post" target="_blank">
                        <button type="submit" name="envio" value="Enviar PDF por correo" class="texto_btn_pdf eee">Enviar PDF por correo<img src="files/ep.png" class="button_generar_pdf i" alt=""></button>
                    </form>
                </div>
	<br>
	</div>
	<a class="c" href="load.php">Cargar otra licencia</a>
	<br><br><br><br><br><br><br><br><br><br><br><br><br>
	<br><br><br><br><br><br><br><br><br><br><br><br><br>
	<footer>
	     Autor: Aldo Adrián Castillo - ELECTRICIDAD CASTILLO - Contacto: (261) 15-6934658 - Derechos Reservados © 2018
	</footer>
	</body>
	
</html>