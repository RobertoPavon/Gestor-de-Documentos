<?php
include_once '../../conexion.php';
if(isset($_GET['numero'])){
    try {
        $numero=$_GET['numero'];
        //$sql=$conn->prepare('Delete from sucursales Where numero = ?;');
        $sql=$conn->prepare('Update sucursales set status = 0 Where numero = ?;');
        $result=$sql->execute([$numero]);
        header('Location:sucursales.php');
    } catch (PDOException $th) {
        echo "error ".$th;
    }    
} 
?>