<?php
    // header('content');
    require_once './GestionLog.php';
    $ges = new GestionLog();
    $id = $_POST['Identificacion'];
    $nombre = $_POST['full-name'];
    $edad = $_POST['Edad'];
    require_once './Conexion.php';
    require_once './ConexionL.php';
    require_once './ConexionR.php';

    $conexion = new Conexion(0,1);
    $conexionR = new ConexionR(0,5);
    $conexionl = new ConexionL(0,1);

    $sqlstr = "INSERT INTO estudiante VALUES($id,'$nombre',$edad)";

    $result = $conexion->insercion($sqlstr);
    $resulr = $conexionR->insercion($sqlstr);

    $ipRegistro = getUserIpAddress();
    $sqlsR  = "INSERT INTO registro (fecha_registro,ipRegistro) values(CURTIME(),'$ipRegistro')";
    $resultR = $conexionl->insercion($sqlsR);

    if($resulr['filas_afectadas']==-1){
      $ges->addEstudiante(1,$id);
    }else{
      $ges->addEstudiante(3,$id);
    }

    if($result['filas_afectadas']==-1){
        $ges->addEstudiante(1,$id);
        echo "No se ha podido agregar el estudiante";
    }else{

      $ges->addEstudiante(0,$id);
      $sqlstr = "SELECT max(id) as maxid from registro";
      $result = $conexionl->seleccion($sqlstr);
      $idR = $result[0]["maxid"];
      $idR = strlen($idR)==0 ? 1 : $idR;
      registrarAdd($id,$idR);
      header("Location: /sdistribuidos");
      exit();
    }

    function registrarAdd($idEstudiante,$idRegistro){
      $datos_clientes = file_get_contents("conexion.json");
      $json_clientes = json_decode($datos_clientes, true);
      print_r($json_clientes);
      $json_clientes[$idEstudiante] = $idRegistro;
      $json_string = json_encode($json_clientes);
      $file = 'conexion.json';
      file_put_contents($file, $json_string);
    }

    function getUserIpAddress() {

    foreach ( [ 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR' ] as $key ) {

        // Comprobamos si existe la clave solicitada en el array de la variable $_SERVER
        if ( array_key_exists( $key, $_SERVER ) ) {

            // Eliminamos los espacios blancos del inicio y final para cada clave que existe en la variable $_SERVER
            foreach ( array_map( 'trim', explode( ',', $_SERVER[ $key ] ) ) as $ip ) {

                // Filtramos* la variable y retorna el primero que pase el filtro
                if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) !== false ) {
                    return $ip;
                }
            }
        }
    }

    return '?'; // Retornamos '?' si no hay ninguna IP o no pase el filtro
}
?>
