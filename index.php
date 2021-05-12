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
        $array = getEstudents();
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
  </body>
</html>

<?php
function getEstudents(){
  require_once './Conexion.php';
  $con = new Conexion;
  $sqlstr = "SELECT * FROM estudiante";
  return $con->seleccion($sqlstr);
}
?>
