<?php
include_once '../../conexion.php';

    try {
        $id=$_GET['idproveedor'];
        $sql=$conn->prepare('Delete from proveedor Where idproveedor = ?');
        $result=$sql->execute([$id]);
        header('Location:proveedores.php');       
    } catch (\Throwable $th) {
        echo $th;
    }

?>