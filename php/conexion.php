<?php

$server = 'localhost';
$user = 'root';
$pass = 'barbacoa';
$dbname = 'econocomex';

try {
    $conn = new PDO("mysql:host=$server;dbname=$dbname", $user, $pass);
    //echo "conexion establecida<br>";
} catch (\PDOException $th) {
    echo("Conexion no establecida, error: ".$th->getMessage());
    // $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    // $arr = $sql->errorInfo();
    // print_r($arr);
}
?>