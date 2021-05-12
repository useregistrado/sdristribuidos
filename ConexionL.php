<?php
require_once './GestionLog.php';
error_reporting(E_ERROR | E_PARSE);
class ConexionL{
  private $server;
  private $user;
  private $password;
  private $database;
  private $port;
  private $conexion;

  function __construct(int $bd=0,$opr=0){
    $listadatos = $this->datosConexion();
    if($bd==0){
      foreach ($listadatos as $key => $value) {
          $this->server = $value['serverL'];
          $this->user = $value['userL'];
          $this->password = $value['passwordL'];
          $this->database = $value['databaseL'];
          $this->port = $value['portL'];
      }
      $this->conexion = new mysqli($this->server,$this->user,$this->password,$this->database,$this->port);
      if($this->conexion->connect_errno){
        $listadatos = $this->datosConexion();
        foreach ($listadatos as $key => $value) {
            $this->server = $value['server2'];
            $this->user = $value['user2'];
            $this->password = $value['password2'];
            $this->database = $value['database2'];
            $this->port = $value['port2'];
        }
        $this->conexion = new mysqli($this->server,$this->user,$this->password,$this->database,$this->port);
        if($this->conexion->connect_errno){
          $ges = new GestionLog();
          echo "Error en la base de datos principal y en la secundaria";
          $ges->bdsNoDisponibles($opr);
          die();
        }else{
          echo "Conexion exitosa a BD de respaldo";
        }
      }else {
          echo "Conexion exitosa a la BD principal";
      }

  }else{
    foreach ($listadatos as $key => $value) {
        $this->server = $value['serverL'];
        $this->user = $value['userL'];
        $this->password = $value['passwordL'];
        $this->database = $value['databaseL'];
        $this->port = $value['portL'];
    }
    $this->conexion = new mysqli($this->server,$this->user,$this->password,$this->database,$this->port);
  }
}

  private function datosConexion(){
      $direccion = dirname(__FILE__);
      $jsondata = file_get_contents($direccion . "/" . "config");
      return json_decode($jsondata, true);
  }

  public function seleccion($sqlstr){
      $results = $this->conexion->query($sqlstr);
      $resultArray = array();
      foreach ($results as $key) {
          $resultArray[] = $key;
      }
      return $this->convertirUTF8($resultArray);
  }

  public function insercion($sqlstr){
      $this->conexion->query($sqlstr);
      $msg = array(
          'filas_afectadas'=> $this->conexion->affected_rows,
          'error'=>$this->conexion->error
      );
      return $msg;
  }

  private function convertirUTF8($array){
    array_walk_recursive($array,function(&$item,$key){
        if(!mb_detect_encoding($item,'utf-8',true)){
            $item = utf8_encode($item);
        }
    });
    return $array;
}
}
  ?>
