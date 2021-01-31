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
    <title> licenciasAC </title>
  </head>
  <header></header>
  <body>
   
    <?php if ($user['id'] == 72): ?>
    <?php   
        $id = $user['id'];
        require 'database.php';
        $cuil = $user['cuil'];
        $sql = "SELECT * FROM load_license WHERE id = '$id'";
        $stmt = $conn->prepare($sql);
        $res = $conn->query($sql);
        $columna = $res->fetch(PDO::FETCH_ASSOC); 
    ?>
        
    <form action="found.php" method="POST">
		
		<h5>Ingrese el cuil del cliente a consultar:</h5> <br>
		
		<font color="#842FA6">
		<div>
		<label for="number"> Cuil del Cliente: </label>
				<INPUT TYPE=TEXT NAME="number" PLACEHOLDER="Ingrese aquí número de cliente..." pattern="[0-9]{1,2,3,4}" id="number" size="25"> <BR><BR>
		</div>
		
        </font>
        
		<div>	
		<input type="submit" align="center" VALUE="ENVIAR" id="boton">
		<input type="reset" align="center" VALUE="BORRAR" id="boton">
		</div>
        </form>  
     
        <a class="a" href="logout.php">Cerrar Sesión</a><BR><BR>
        <a class="b" href="index.php">Volver al inicio</a>
        <br><br> 
        
    <?php if (!empty($_POST['number'])): ?> 
    <?php     
            
        $number = $_POST['number'];    
        $id = $user['id'];
        require 'database.php';
        $cuil = $user['cuil'];
        $sql = "SELECT * FROM load_license WHERE cuil = '$number'";
        $stmt = $conn->prepare($sql);
        $res = $conn->query($sql);
        $columna = $res->fetch(PDO::FETCH_ASSOC)
            
    ?>
            
    <font face="cambria">
    <b>
    <font color="#842FA6"><h1>Licencias ingresadas <?= $columna['cuil']; ?> </h1></font> <br><br><br><br>
    
	<h3>Consulta a la Base de datos. Registros.</h3> <br><br>
	</b>
	
	<table>
		<b>
		<thead>
		    <th>CUIL</th>
			<th>TIPO</th>
            <th>COMENTARIOS</th>
			<th>FECHA DEL COMPROBANTE</th>
			<th>CANTIDAD DE DIAS</th>
			<th>CERTIFICADO</th>
			
		</thead>
     
    <?php
		$number = $_POST['number'];    
        $id = $user['id'];
        require 'database.php';
        $cuil = $user['cuil'];
        $sql = "SELECT * FROM load_license WHERE cuil = '$number'";
        $stmt = $conn->prepare($sql);
        $res = $conn->query($sql);
		while ($columna = $res->fetch(PDO::FETCH_ASSOC)) {
		
        echo "<tbody>";
        echo "<tr>"; 
        echo "<td>".$columna['cuil']."</td><td>".$columna['tipo']."</td><td>".$columna['comentarios']."</td><td>".$columna['sday']."</td><td>".$columna['fday']."</td><td>".$columna['foto']."</td>";
        echo "</tr>";
        echo "</tbody>";
        
        }
        echo "</table>";
        
        ?>     
    <?php endif; ?>
    
    <?php else: ?>

    <font face="cambria">
    <b>
    <font color="#842FA6"><h1>Licencias ingresadas Usuario N° <?= $user['id']; ?> </h1></font> <br><br><br><br>
    
	<h3>Consulta a la Base de datos. Registros.</h3> <br><br>
	</b>
	
	<table>
		<b>
		<thead>
		    <th>CUIL</th>
			<th>TIPO</th>
            <th>COMENTARIOS</th>
			<th>FECHA DEL COMPROBANTE</th>
			<th>CANTIDAD DE DIAS</th>
			<th>CERTIFICADO</th>
			
		</thead>
        
        <?php
        require 'database.php';   
        $id = $user['id'];
        $cuil = $user['cuil'];
        $sql = "SELECT * FROM load_license WHERE cuil = '$cuil'";
        $stmt = $conn->prepare($sql);
        $res = $conn->query($sql);
            
        while ($columna = $res->fetch(PDO::FETCH_ASSOC)) {  
        echo "<tbody>";
        echo "<tr>"; 
        echo "<td>".$columna['cuil']."</td><td>".$columna['tipo']."</td><td>".$columna['comentarios']."</td><td>".$columna['sday']."</td><td>".$columna['fday']."</td><td>".$columna['foto']."</td>";
        echo "</tr>";
        echo "</tbody>";
        }
        echo "</table>";
        ?>
        
	   <br><br>
	<br>
	    
	   <a class="a" href="logout.php">Cerrar Sesión</a><BR><BR>
       <a class="b" href="index.php">Volver al inicio</a>
    
    <?php endif; ?>   
       
        <div>
              	    <form method="post" target="_blank" link rel="icon" type="image/png" href="files/ep.png" sizes="32x32">
                        <button type="submit" name="generar" id="generar" value="Generar PDF" class="texto_btn_pdf ggg">Generar PDF<img src="files/bpg.png" class="button_generar_pdf h" alt=""></button>
                    </form>
        </div> 
        
        <?php 
        require 'database.php';
        $id = $user['id'];
        $cuil = $user['cuil'];
            
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
            
        function selectTabla(){ 
            $id = $user['id'];
            $cuil = $user['cuil'];
            
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
            
            $stmti = $conn->prepare($sqli);
            $sqli = $sql = "SELECT * FROM load_license WHERE cuil = '$cuil'";
            $stmti = $conn->prepare($sqli);
            $resi = $conn->query($sqli);
            
            $tabla = '';
            
		while ($columnaa = $resi->fetch(PDO::FETCH_ASSOC)) {
            
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
                            <font color="#C71C1C"><br><b>COMPLETADO. LICENCIA CARGADA A -> '.$columnaa['cuil'].'</b></font><br><br>
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
                            <td>'.$columnaa['tipo'].'</td>
                            <td>'.$columnaa['name'].'</td>
                            <td>'.$columnaa['cuil'].'</td>
                            <td>'.str_replace('-','/', date('d-m-Y', strtotime($columnaa['sday']))).'</td>
                            <td>'.$columnaa['fday'].'</td>
                            <td>'.$columnaa['address'].'</td>
                            <td>'.$columnaa['cell'].'</td>
                            <td>'.$columnaa['email'].'</td>
                            <td>'.$columnaa['foto'].'</td>
                        </tr>
                            ';
        
	        $tabla .= '</table>';
            $tabla .= '<br>';
            
            if ($columnaa['tipo']=="Otros"){
                
            $tabla .= '<b><font color="#C71C1C">Descripción del Usuario: </font>'.$columnaa['comentarios'].'</b><br><br>';
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
        $mpdf->Output('history.pdf', 'I');
        exit;
        }         
        ?> 
    
    <br><br>
	<footer>
	    Autor: Aldo Adrián Castillo - ELECTRICIDAD CASTILLO - Contacto: (261) 15-6934658 - Derechos Reservados © 2018
	</footer>
  </body>
</html>