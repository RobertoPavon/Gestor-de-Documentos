<?php
session_start();
require 'login.php';
$nombre = $_SESSION['usuario'];
$tipo = $_SESSION['tipo'];
$varsession = $_SESSION['usuario'];
if($varsession = null || $varsession = ''){
    echo 'No tiene Autorizacion';
    die();
}

if($tipo === "1"){
    header("Location:usuarios/administrador/administrador.php");                        
}
if($tipo === "2"){
    header('Location:usuarios/analista/analista.php');                        
} 
if($tipo === "3"){
    header('Location:usuarios/sucursal/sucursal.php');                        
} 
if($tipo === "4"){
    header('Location:usuarios/rh.php');                        
} 
?>