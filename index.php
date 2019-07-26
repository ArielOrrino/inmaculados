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
          <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li> 
          <li class="nav-item"><a class="nav-link" href="guerras.php">War</a></li>                     
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
  ?>     

  <?php
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

    <div class="row">
     <div class="col-md-8 mb-5">
         <h2>Sobre Nosotros</h2>
         <hr>
         <p><?php echo $descripcion_clan;?></p>       
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
 <hr>
 <!--//////////////////////////////////////////// -->
 <!--SOY UNA BARRAA ESPACEADORA EN PLENA MACRISIS -->
 <!--//////////////////////////////////////////// -->
   <center><h2>Miembros Actuales del Clan</h2></center>
   <hr>
    <!-- ACA SACAR LOS COLORES DE LA TABLA PARA LOS COLIDERES Y EL LIDER SEÑOR NARIZ QUE TANTO LO QUEREMOS -->
    <!-- LINK PAPU https://getbootstrap.com/docs/4.3/content/tables/ -->
   <table class="table table-bordered table-dark table-hover table-sm">
   <thead>
     <tr>
     <th scope="col">#</th>
     <th scope="col">Nombre</th>
     <th scope="col">Rango</th>
     <th scope="col">Trofeos</th>
     <th scope="col">Torre</th>
     <th scope="col">Donaciones</th>
     <th scope="col">Recibidas</th>
     </tr>
   </thead>
    <tbody>  
     <?php  
     //me traigo todos los miembros del json para mostrar los miembros del clan    
     $todos_los_miembros=json_decode($json);
     $miembros= $todos_los_miembros->members; //los items en este json son la lista de miembros justamente
     $total_de_miembros= count($miembros);  //contamos cuantos miembros tenemos (recordar que el 1er elemento es el 0)  
     for ($i = 0; $i < $total_de_miembros; $i++) {
         $miembro_nombre=$miembros[$i]->name;  
         $miembro_rango=$miembros[$i]->role; 
         $miembro_trofeos=$miembros[$i]->trophies;
         if ($miembro_rango=="leader") $miembro_rango="Lider";
         if ($miembro_rango=="coLeader") $miembro_rango="Colider";
         if ($miembro_rango=="elder") $miembro_rango="Veterano";
         if ($miembro_rango=="member") $miembro_rango="Miembro";
         $miembro_nivel_torre=$miembros[$i]->expLevel;
         $miembro_donaciones=$miembros[$i]->donations;
         $miembro_donaciones_recibidas=$miembros[$i]->donationsReceived;
         $numero=$i+1;  
         echo "<tr>"; 
         echo "<td>".$numero."</td>";
         echo "<td>".$miembro_nombre."</td>";
         echo "<td>".$miembro_rango."</td>";
         echo "<td>".$miembro_trofeos."</td>";
         echo "<td>".$miembro_nivel_torre."</td>";
         echo "<td>".$miembro_donaciones."</td>";
         echo "<td>".$miembro_donaciones_recibidas."</td>";
         echo "</tr>";
    }   
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
