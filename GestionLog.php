<?php
require_once './Conexion.php';
class GestionLog{
private $conexion;
  function __construct(){
    $this->conexion = new Conexion(1);
  }
  public function addEstudiante(int $resultado, $id){
    if($resultado==0){
      //SE AGREGUE EL ESTUDIANTE
      $sqlstr = "INSERT INTO log (fecha,operacion, descripcion,resultado) VALUES(now(),'AGREGAR ESTUDIANTE','Se agregó el estudiante con id $id','Operación exitosa')";
      $this->conexion->insercion($sqlstr);
    }else if ($resultado==1) {
      $sqlstr = "INSERT INTO log (fecha,operacion, descripcion,resultado) VALUES(now(),'AGREGAR ESTUDIANTE','Estudiante con id $id existente','Operación fallida')";
      $this->conexion->insercion($sqlstr);
    }elseif (3) {
      // RESPALDAR ESTUDIANTE
      $sqlstr = "INSERT INTO log (fecha,operacion, descripcion,resultado) VALUES(now(),'RESPALDAR ESTUDIANTE','Estudiante con id $id se respaldó','Operación exitosa')";
      $this->conexion->insercion($sqlstr);
    }
  }

public function searchEstudiante($resultado){
  if($resultado==0){
    //Consulta exitosa de los estudiantes
    $sqlstr = "INSERT INTO log (fecha,operacion, descripcion,resultado) VALUES(now(),'CONSULTAR ESTUDIANTE','Se consultó uno o varios estudiantes','Operación exitosa')";
    $this->conexion->insercion($sqlstr);
  }else {
    // No se encontro un estudiante
    $sqlstr = "INSERT INTO log (fecha,operacion, descripcion,resultado) VALUES(now(),'CONSULTAR ESTUDIANTE','El estudiante consultado no existe en la BD','Operación fallida')";
    $this->conexion->insercion($sqlstr);
  }
}


  public function bdsNoDisponibles($codigo){
    if ($codigo==1) {
      //Error al agregar estudiante
      $sqlstr = "INSERT INTO log (fecha,operacion, descripcion,resultado) VALUES(now(),'AGREGAR ESTUDIANTE','Bases de datos fallando','Operación fallida')";
      $this->conexion->insercion($sqlstr);
    }elseif (2) {
      // Consultar estudiantes
      $sqlstr = "INSERT INTO log (fecha,operacion, descripcion,resultado) VALUES(now(),'CONSULTAR ESTUDIANTE','Bases de datos fallando','Operación fallida')";
      $this->conexion->insercion($sqlstr);
    }elseif($codigo==5){

      $sqlstr = "INSERT INTO log (fecha,operacion, descripcion,resultado) VALUES(now(),'RESPALDAR ESTUDIANTE','Bases de datos fallando','Operación fallida')";
      $this->conexion->insercion($sqlstr);
    }else {
      // Error desconocido
      $sqlstr = "INSERT INTO log (fecha,operacion, descripcion,resultado) VALUES(now(),'OPERACIÓN DESCONOCIDA','Bases de datos fallando','Operación fallida')";
      $this->conexion->insercion($sqlstr);
    }
  }

}
?>
