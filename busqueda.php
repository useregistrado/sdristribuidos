<!DOCTYPE html>
<html lang="" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Home</title>
  </head>
  <body>
    <div class="container">
    <nav class="navbar navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="./">Home</a>
        <a class="navbar-brand" href="user.html">Agregar Estudiante</a>
      </div>
    </nav>
      <h1 class="display-4 text-center">Colegio pinceladas</h1>
      <br>
      <form class="" action="busqueda.php" method="post">
        <label for=""><b>Buscar por Id o Nombre:</b></label>
        <div class="row g-3">
          <div class="col-md-3">
            <input name="id" type="text" class="form-control" placeholder="Identificación" aria-label="First name">
          </div>
          <div class="col-md-4">
            <input name="nombres" type="text" class="form-control" placeholder="Nombres" aria-label="Last name">
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-success" name="button">Buscar</button>
          </div>
        </div>
      </form><br>
      <table class="table table-striped">
      <thead>
        <tr class="table-success">
          <th scope="col">#</th>
          <th scope="col">Identificacion</th>
          <th scope="col">Nombre</th>
          <th scope="col">Edad</th>
        </tr>
      </thead>
      <tbody>
      <?php
        require_once("./GestionLog.php");
        $array = getEstudents();
        $ges = new GestionLog(0,2);
        if(sizeof($array)>0){
          $ges->searchEstudiante(0);
        }else{
          $ges->searchEstudiante(1);
        }
        $i=0;
        foreach ($array as $estudiante) {
          $i++;
          echo '<tr>
                  <th scope="row">'.($i).'</th>
                  <td>'.$estudiante["idestudiante"].'</td>
                  <td>'.$estudiante["nombreEstudiante"].'</td>
                  <td>'.$estudiante["edadEstudiante"].'</td>
                </tr>';
        }
        ?>
        </tbody>
      </table>
    </div>
    <div class="container">
      <br>
      <br>
      <h1 class="display-4">Tareas del estudiante</h1>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Asignatura</th>
            <th scope="col">Nombre</th>
            <th scope="col">Descargar</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Sociales</td>
            <td>Regiones de colombia</td>
            <td>

              <a Download href="https://27d437d4df00.ngrok.io/Recursos/regiones.pdf" target="_blank">Descargar</a>

              <h5>
               Si no funciona el link para regiones usa esta alternativa
              </h5>
              <a Download href="https://alojamientoarchivos.000webhostapp.com/Recursos/regiones.pdf" target="_blank">Descargar</a>
            </td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Matemáticas</td>
            <td>Suma de fraccionarios</td>
            <td>
              <a download href="https://27d437d4df00.ngrok.io/Recursos/operaciones.pdf" target="_blank">Descargar</a>
            </td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Informatica</td>
            <td>Partes de un computador</td>
            <td>
              <a download href="https://27d437d4df00.ngrok.io/Recursos/partes.pdf" target="_blank">Descargar</a>
            </td>
          </tr>
        </tbody>
      </table>

    </div>
  </body>
</html>

<?php
function getEstudents(){
  $id = $_POST["id"];
  $nombres = $_POST["nombres"];
  require_once './Conexion.php';
  require_once './ConexionR.php';
  $con = new Conexion(0,2);
  $sqlstr = "SELECT * FROM estudiante WHERE idestudiante='$id'";
  $res = $con->seleccion($sqlstr);

  $conR = new ConexionR(0,2);
  $sqlstrR = "SELECT * FROM estudiante WHERE idestudiante='$id'";
  $resR = $conR->seleccion($sqlstrR);
  if(sizeof($res)==0){
    respaldarDb($resR);
    return $resR;
  }elseif (sizeof($res)==1 and sizeof($resR)==0) {
    respaldarDb2($res);
    return $res;
  }
  return $res;
}

function respaldarDb($array){
  $id = $array[0]['idestudiante'];
  $nombre = $array[0]['nombreEstudiante'];
  $edad = $array[0]['edadEstudiante'];
  $sqlstr = "INSERT INTO estudiante VALUES($id,'$nombre',$edad)";
  $con = new Conexion(0,2);
  $res = $con->insercion($sqlstr);
}

function respaldarDb2($array){
  $id = $array[0]['idestudiante'];
  $nombre = $array[0]['nombreEstudiante'];
  $edad = $array[0]['edadEstudiante'];
  $sqlstr = "INSERT INTO estudiante VALUES($id,'$nombre',$edad)";
  $con = new ConexionR(0,2);
  $res = $con->insercion($sqlstr);
}
?>
