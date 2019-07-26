<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Inmaculados</title>

  <!-- Bootstrap core CSS -->
  <link href="recursos/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/estilos.css" rel="stylesheet">
  <link rel="shortcut icon" type="image/ico" href="recursos/favicon.ico">

</head>

<body>
 <!--//////////////////////////////////////////// -->
 <!--SOY UNA BARRAA ESPACEADORA EN PLENA MACRISIS -->
 <!--//////////////////////////////////////////// -->
<!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
       <a class="navbar-brand" href="index.php"><img src="recursos/logo.png"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item active"><a class="nav-link" href="guerras.php">War</a></li>                  
        </ul>
      </div>
    </div>
  </nav>
 <!--//////////////////////////////////////////// -->
 <!--SOY UNA BARRAA ESPACEADORA EN PLENA MACRISIS -->
 <!--//////////////////////////////////////////// -->
 <?php  
   //link con la documentacion https://docs.royaleapi.com/#/authentication?id=key-management
   $token="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6Mjc3NCwiaWRlbiI6IjMwNDAyOTI5MjcyNjE5MDA4MiIsIm1kIjp7fSwidHMiOjE1NjQwMDMxMzMyNDR9.9j1xQEZK-BXO9zi_J_q3AFGbUOQLp3UcnDIQBlp33Ps";
   $opts = ["http" => ["header" => "auth:" . $token]];
   $context = stream_context_create($opts);
   $json = file_get_contents("https://api.royaleapi.com/clan/PVC2PU8Q",true, $context);
   $jsonguerras=file_get_contents("https://api.royaleapi.com/clan/PVC2PU8Q/war",true, $context);   
   //Me traigo todos los datos del clan para mostrarlos en pantalla
   $datos_clan=json_decode($json);  
   $etiqueta_clan=$datos_clan->tag;
   $nombre_clan=$datos_clan->name;
   $descripcion_clan=$datos_clan->description;
   $puntaje_clan=$datos_clan->score;
   $miembrosdel_clan=$datos_clan->memberCount;
   $copasrequeridas_clan=$datos_clan->requiredScore;
   $donaciones_clan=$datos_clan->donations;
   $tipoinvitacion_clan=$datos_clan->type;      
  ?> 
 
  <!-- Header -->
  <!--<header class="bg-primary py-5 mb-5">-->
  <header class="bg-primary py-5 mb-5">
    <div class="container h-100">
      <div class="row h-100 align-items-center">
        <div class="col-lg-12">
          <h1 class="display-4 text-white mt-5 mb-2"><br>      </h1>
          <p class="lead mb-5 text-white-50"></p>
        </div>
      </div>
    </div>
  </header>

  <!-- Page Content -->
  <div class="container">
  <?php      
   //Me traigo todos los datos de la guerra actual del clan para mostrarlos en pantalla
   $datos_clan_guerra=json_decode($jsonguerras);
   $guerra_estado=$datos_clan_guerra->state;
   //Debemos chequear si estamos en guerra , y en caso de estar , si es dia de recoleccion o no
   if ($guerra_estado=="collectionDay") {$guerra_tiempo_restante=$datos_clan_guerra->collectionEndTime;}
   if ($guerra_estado=="warDay") {$guerra_tiempo_restante=$datos_clan_guerra->warEndTime;}
   if ($guerra_estado=="notInWar") {$guerra_tiempo_restante="No hay guerras en marchas";}
   ///////////////////////////////////////////  
   //$guerra_tiempo_restante=$datos_clan_guerra->collectionEndTime;  //formato TimeStamp
   ///////////////////////////////////////////  
   //Ahora solo es cuestion de traducir el estado actual de la guerra
   if ($guerra_estado=="collectionDay") $guerra_estado="Dia de Recoleccion";
   if ($guerra_estado=="warDay") $guerra_estado="Dia de Guerra";
   if ($guerra_estado=="notInWar") $guerra_estado="No hay guerras iniciadas por el momento";
   $guerra_etiqueta=$datos_clan_guerra->clan->tag;
   $guerra_name=$datos_clan_guerra->clan->name;  
   $guerra_participantes=$datos_clan_guerra->clan->participants;
   $guerra_batallas=$datos_clan_guerra->clan->battlesPlayed; 
   $guerra_victorias=$datos_clan_guerra->clan->wins;  
   $guerra_torres_caidas=$datos_clan_guerra->clan->crowns; 
   $guerra_trofeos=$datos_clan_guerra->clan->warTrophies;
   $guerra_ausentes=$miembrosdel_clan-$guerra_participantes;
   //////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
   //Ahora vamos a darle formato a las fechas y calcular el tiempo restante para que termine la coleccion o la guerra
   //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   date_default_timezone_set('America/Argentina/Buenos_Aires');
   $formato_fecha = date_create(); 
   date_timestamp_set($formato_fecha, $guerra_tiempo_restante);
   //$fechafin=date_format($fecha, 'U = d-m-Y H:i:s') . "\n";
   $Finalizacion_Evento=date_format($formato_fecha,'d-m-Y H:i'). "\n";
   $HoraActual_Evento=date_format(date_create(),'d-m-Y H:i'). "\n";    
   $HoraActual_Evento_Aux= new DateTime($HoraActual_Evento); 
   $Finalizacion_Evento_Aux= new DateTime($Finalizacion_Evento); 
   $TiempoRestante= $HoraActual_Evento_Aux->diff($Finalizacion_Evento_Aux); 
   //print $TiempoRestante->format("%H:%I:%S"); 
  ?>   

  <div class="row">
     <div class="col-md-8 mb-5">
         <h2>Guerra Actual en el <?php echo $guerra_estado; ?></h2>
         <hr>
         <strong>Estado de la Guerra Actual: </strong><?php echo $guerra_estado; ?>
         <br>              
         <strong>Finalizacion del <?php echo $guerra_estado; ?>: </strong><?php echo $Finalizacion_Evento; ?> hs 
         <br>  
         <strong>Tiempo Restante para finalizar el <?php echo $guerra_estado; ?>: </strong> <?php  echo $TiempoRestante->format("%H:%I")." hs";?>     
         <br> 
         <strong>Trofeos del Clan: </strong><?php echo $guerra_trofeos; ?> Trofeos 
         <br>        
         <strong>Batallas: </strong><?php echo $guerra_batallas; ?> Batallas completadas del <?php echo $guerra_estado; ?>        
         <br>
         <strong>Victorias: </strong><?php echo $guerra_victorias; ?> Victorias durante el <?php echo $guerra_estado; ?> 
         <br>
         <strong>Participantes: </strong><?php echo $guerra_participantes; ?> miembros estan participando actualmente
         <br>  
         <strong>Ausentes: </strong><?php echo $guerra_ausentes; ?> miembros no estan participando actualmente                      
     </div>
     <div class="col-md-4 mb-5">
         <h2>Datos del Clan</h2> 
         <hr>        
         <strong>Nombre: </strong><?php echo $nombre_clan;?>
         <br>          
         <strong>Copas del Clan: </strong><?php echo $puntaje_clan;?>
         <br> 
         <strong>Miembros: </strong><?php echo $miembrosdel_clan;?>
         <br>
         <strong>Donaciones Semanales: </strong><?php echo $donaciones_clan;?>
         <br>
         <strong>Etiqueta: </strong><?php echo $etiqueta_clan;?>  
         <br>
         <strong>Tipo de Ingreso: </strong><?php echo $tipoinvitacion_clan;?>                   
      </div>
    </div>
    <!-- /.row -->

<!--//////////////////////////////////////////// -->
<!--SOY UNA BARRAA ESPACEADORA EN PLENA MACRISIS -->
<!--//////////////////////////////////////////// -->   
<center><h2>Participantes Actuales del <?php echo $guerra_estado; ?> </h2></center>
<hr>
 <table class="table table-bordered table-dark table-hover table-sm">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Etiqueta</th>
      <th scope="col">Recolectadas</th>
      <th scope="col">Batallas</th>
      <th scope="col">Victorias</th>
    </tr>
  </thead>
  <tbody>

  
  <?php       
   for ($i = 0; $i < $guerra_participantes; $i++) {
   $participantes_guerra_nombre=$datos_clan_guerra->participants[$i]->name;
   $participantes_guerra_etiqueta=$datos_clan_guerra->participants[$i]->tag;
   $participantes_guerra_recolectadas=$datos_clan_guerra->participants[$i]->cardsEarned;
   $participantes_guerra_jugadas=$datos_clan_guerra->participants[$i]->battlesPlayed;
   $participantes_guerra_victorias=$datos_clan_guerra->participants[$i]->wins;   
   $numero=$i+1;
   echo "<tr>"; 
   echo "<td>".$numero."</td>";    
   echo "<td>".$participantes_guerra_nombre."</td>";
   echo "<td>".$participantes_guerra_etiqueta."</td>";
   echo "<td>".$participantes_guerra_recolectadas."</td>";
   echo "<td>".$participantes_guerra_jugadas."</td>";
   echo "<td>".$participantes_guerra_victorias."</td>";
   echo "</tr>"; 
  }
  ?>      
 </tbody>
</table>
<hr>
<!--//////////////////////////////////////////// -->
<!--SOY UNA BARRAA ESPACEADORA EN PLENA MACRISIS -->
<!--//////////////////////////////////////////// -->
<center><h2>Lista de Ausentes del <?php echo $guerra_estado; ?> </h2></center>
<hr>
<!-- Vamos a obtener los ausentes en las guerras --> 
<table class="table table-bordered table-dark table-hover table-sm">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombre</th>
      <th scope="col">Etiqueta</th>      
    </tr>
  </thead>
  <tbody> 
<?php   
 //me traigo todos los miembros del clan
 $todos_los_miembros=json_decode($json);
 $miembros_del_clan= $todos_los_miembros->members; //me traigo a todo los miembros 
 $participantes=$datos_clan_guerra->participants; //me traigo todos los participantes del clan en la guerra
 //sabemos que $guerra_participantes es la cantidad que participan en la guerra
 //sabemos que $miembrosdel_clan es la cantidad de miembros del clan
 //para recorrer los nombres de miembros debo hacer $miembrosdel_clan[i]->name
 //para recorrer los nombres de los participantes en guerras debo hacer $participantes[i]->name
 //$participantes_guerra_nombre=$datos_clan_guerra->participants[$i]->name;
 //$participantes_guerra_etiqueta=$datos_clan_guerra->participants[$i]->tag; 
 $contador_no_jugaron=0;
 for ($aux1 = 0; $aux1 < $miembrosdel_clan; $aux1++) {
   $miembroanalizado=$miembros_del_clan[$aux1]->name;
    for ($aux2=0; $aux2 < $guerra_participantes; $aux2++) {      
      $participanteanalizado=$participantes[$aux2]->name;
      //Inicia el IF que verifica la participacion del integrante
      if ($miembroanalizado == $participanteanalizado) {
       $participa="SI"; //si esta en 1 se encontro el miembro en la guerra       
       //echo "miembro ".$miembroanalizado." VS participante ".$participanteanalizado." | ¿participa?=".$participa;
       //echo "<br>";  
       break;         
      }
      else {
       $participa="NO";
      }      
     //fin del IF que verifica si el participante esta o no en la guerra  
     }//termina el for que recorre todos los participantes 
     //IF QUE SI NO ESTA JUGANDO LA GUERRA LO IMPRIME EN LA LISTA DE LOS QUE FALTAN JUGAR O NO JUGARON
     if ($participa=="NO") {
      $contador_no_jugaron=$contador_no_jugaron+1;
      $No_Jugo_Etiqueta=$miembros_del_clan[$aux1]->tag;
      echo "<tr>"; 
      echo "<td>".$contador_no_jugaron."</td>";
      echo "<td>".$miembroanalizado."</td>";
      echo "<td>".$No_Jugo_Etiqueta."</td>";
      echo "</tr> ";       
      }//termina el IF que imprime los que no jugaron
  }//termina el for que recorre todos los miembros


?> 
</tbody>
</table>



</div>
<!-- /.container -->  
<!--//////////////////////////////////////////// -->
<!--SOY UNA BARRAA ESPACEADORA EN PLENA MACRISIS -->
<!--//////////////////////////////////////////// -->
  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Inmaculados y todos los derechos e izquierdos reservados</p>
    </div>
    <!-- /.container -->
  </footer>
  <!-- Bootstrap core JavaScript -->
  <script src="recursos/jquery/jquery.min.js"></script>
  <script src="recursos/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
