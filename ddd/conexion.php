<?php 

$server = "localhost";
$user = "root";
$pass = "";
$db = "base_cv";

$conexion = new mysqli($server, $user, $pass, $db);

if ($conexion->connect_errno){
    die("Conexion Fallida"). $conexion->connect_errno;
}else{
    echo "";
}
?>