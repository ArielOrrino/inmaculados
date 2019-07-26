<?php  
 //////////////////////////////////////////////////////////////////////////////////////////////
 //////////////////////////////////////////////////////////////////////////////////////////////
 //Datos para la conexion con la base de datos
 $servername = "127.0.0.1";
 $database = "inmaculados";
 $username = "inmaculado_admin";
 $password = "carlitox100%";
 //Creamos la conexion con la BD 
 $conn = mysqli_connect($servername, $username, $password, $database);
 //Cheaquea como se menea esta conexion con la BD
 if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
 }
 echo "La conexion con la BD fue exitosa amigazo <hr>";
 //////////////////////////////////////////////////////////////////////////////////////////////
 ////////////////////////////////////////////////////////////////////////////////////////////// 
 //Me Conecto con la API para comenzar a pegarle
 $token="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6Mjc3NCwiaWRlbiI6IjMwNDAyOTI5MjcyNjE5MDA4MiIsIm1kIjp7fSwidHMiOjE1NjQwMDMxMzMyNDR9.9j1xQEZK-BXO9zi_J_q3AFGbUOQLp3UcnDIQBlp33Ps";
 $opts = ["http" => ["header" => "auth:" . $token]];
 $context = stream_context_create($opts);
 $json = file_get_contents("https://api.royaleapi.com/clan/PVC2PU8Q",true, $context); 
 //////////////////////////////////////////////////////////////////////////////////////////////
 ////////////////////////////////////////////////////////////////////////////////////////////// 
 //me traigo todos los miembros del json para mostrar los miembros del clan    
 $todos_los_miembros=json_decode($json);
 $miembros= $todos_los_miembros->members; //los items en este json son la lista de miembros justamente
 $total_de_miembros= count($miembros);  //contamos cuantos miembros tenemos (recordar que el 1er elemento es el 0)  
 for ($i = 0; $i < $total_de_miembros; $i++) {
   $miembro_nombre=$miembros[$i]->name;
   $miembro_etiqueta=$miembros[$i]->tag; 
   $miembro_pertenece=TRUE;
   date_default_timezone_set('America/Argentina/Buenos_Aires');
   $miembro_ingreso=date('Y-m-d'); //vamos asumir que ingreso hoy
   //echo $miembro_ingreso."<br>";
   $miembro_egreso=null;
   //echo "Miembro: ".$miembro_nombre." --------- Etiqueta: ".$miembro_etiqueta." ----- Fecha Ingreso: ".$FechaActual."<br>"; 

   //Ahora nos conectamos a la BD para chequear si el miembro que estamos agregar ya existia en la Base de datos
   $sql="select * from miembros where (Miembro='$miembro_nombre') AND (Egreso IS NOT NULL)"; //and fechaegreso=vacio --> editar
   $result = mysqli_query($conn, $sql);
   if(mysqli_num_rows($result)>0) { echo "Ya existe el registro que intenta registrar <br>";}
    
   else {
   $sql = "INSERT INTO miembros (Miembro, Etiqueta,Pertenece,Ingreso,Egreso) VALUES ('$miembro_nombre','$miembro_etiqueta','$miembro_pertenece','$miembro_ingreso','$miembro_egreso')";

   if (mysqli_query($conn, $sql)) { echo "Nuevo miembro agregado en la base de datos <br>";} 
   else {echo "Error: " . $sql . mysqli_error($conn)."<hr>";}
  }  
}//fin del for    

 mysqli_close($conn);

 //Datos del machetin
 //Base de Datos: inmaculados
 //Tabla: miembros
 //Campos: ID(int),Miembro(varchar),Etiqueta(varchar),Pertenece(Booleano),Ingreso(Date),Egreso(Date)
 
?>     
  
