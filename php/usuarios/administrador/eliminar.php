<?php
$id = $_SESSION['id'];
include_once '../../conexion.php';
if(isset($_GET['id'])){
    try {
        if($id == $_GET['id'] ){
            echo "No puedes Eliminar tu cuenta de usuario, debe hacerlo otro usuario de tipo 'Administrador'";

        }else{
            $id=$_GET['id'];
            //$sql=$conn->prepare('Delete from usuarios Where id = ?;');
            $sql=$conn->prepare('Update usuarios set estatus = 0 Where id = ?;');
            $result=$sql->execute([$id]);
            header('Location:usuarios.php');
        }        
    } catch (\Throwable $th) {
        echo $th;
    }
} 
?>