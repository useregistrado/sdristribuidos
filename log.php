<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>Log</title>
  </head>
  <body><br>
    <div class="container">
      <h1 class="display-4">Log</h1><br>
      <table class="table table-striped">
      <thead>
        <tr class="table-success">
          <th scope="col">#</th>
          <th scope="col">Fecha</th>
          <th scope="col">Operación</th>
          <th scope="col">Descripción</th>
          <th scope="col">Resultado</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $array = getLog();
        $i=0;
        foreach ($array as $log) {
          $i++;
          if($log["resultado"]=="Operación fallida"){
            echo '<tr>
                    <th scope="row">'.($i).'</th>
                    <td>'.$log["fecha"].'</td>
                    <td>'.$log["operacion"].'</td>
                    <td>'.$log["descripcion"].'</td>
                    <td style="color:red">'.$log["resultado"].'</td>
                  </tr>';
          }else {
            echo '<tr>
                    <th scope="row">'.($i).'</th>
                    <td>'.$log["fecha"].'</td>
                    <td>'.$log["operacion"].'</td>
                    <td>'.$log["descripcion"].'</td>
                    <td style="color:green">'.$log["resultado"].'</td>
                  </tr>';
          }
        }
        ?>
        </tbody>
      </table>
    </div>
  </body>
</html>
<?php
function getLog(){
  require_once './Conexion.php';
  $con = new Conexion(1);
  $sqlstr = "SELECT * FROM log ORDER BY fecha DESC";
  return $con->seleccion($sqlstr);
}
?>
