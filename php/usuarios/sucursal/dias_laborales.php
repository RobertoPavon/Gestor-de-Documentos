<?php
error_reporting(0);
session_start();
include_once '../../conexion.php';
$nombre = $_SESSION['usuario'];
$id= $_SESSION['id'];
$tipo = $_SESSION['tipo'];
$numero = $_SESSION['numero'];
if(!isset($_SESSION['usuario'])){
    session_destroy();
    header('Location: ../../login.php');
}
if($tipo != 3){
    session_destroy();
    header('Location: ../../login.php');
}
date_default_timezone_set('America/Mexico_City');
$mes= date("m");
$año= date("Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Venta</title>
    <link href="../../../css/estilos.css" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="nav_user">
            <a href="/index.php"><img src="/img/logo.png" alt="logo"></a>  
            <a href="venta.php">Regresar</a>
                <ul class="horizontal">
                    <li>
                        <a class="div_login" href="">
                            <img class="login" src="/img/login.png" alt="">
                                <?php echo "&nbsp $nombre"?>
                                    <ul class="vertical">
                                        <li>
                                            <a href="../../logout.php">Salir</a>
                                        </li>
                                    </ul>
                        </a> 
                    </li>
                </ul>         
        </div>
    </nav>

    <div class="ingreso">
        <h1 class="ventah1">Registro de Días Laborales del Mes</h1><br><br>
            <div class="formulario">
                <form action="dias_laborales.php" method="POST"> 
                    <div >
                        <label for="" >1. Sucursal</label>                        
                        <div >
                            <input type="text" name="sucursal" readonly="true" value="<?= $numero ?>"><br><br>                                    
                                <?php

                                if(isset($_POST['sucursal'])){
                                    $dias = $_POST['dias'];
                                    $numero = $_POST['sucursal'];
                                    $mes = $_POST['mes'];
                                    $año = $_POST['año'];                                     
                                    $error = 0; 
                                }
                                ?>
                        </div>            
                    </div> 
                    

                    <div >
                        <label for="" >2. Mes de Venta</label>                        
                        <div >                        
                            <select name="mes" id="">
                                <option value="1" <?php if ($mes == 1){?> selected="true" <?php }?>>ENERO</option>
                                <option value="2" <?php if ($mes == 2){?> selected="true" <?php }?>>FEBRERO</option>
                                <option value="3" <?php if ($mes == 3){?> selected="true" <?php }?>>MARZO</option>
                                <option value="4" <?php if ($mes == 4){?> selected="true" <?php }?>>ABRIL</option>
                                <option value="5" <?php if ($mes == 5){?> selected="true" <?php }?>>MAYO</option>
                                <option value="6" <?php if ($mes == 6){?> selected="true" <?php }?>>JUNIO</option>
                                <option value="7" <?php if ($mes == 7){?> selected="true" <?php }?>>JULIO</option>
                                <option value="8" <?php if ($mes == 8){?> selected="true" <?php }?>>AGOSTO</option>
                                <option value="9" <?php if ($mes == 9){?> selected="true" <?php }?>>SEPTIEMBRE</option>
                                <option value="10" <?php if ($mes == 10){?> selected="true" <?php }?>>OCTUBRE</option>
                                <option value="11" <?php if ($mes == 11){?> selected="true" <?php }?>>NOVIEMBRE</option>
                                <option value="12" <?php if ($mes == 12){?> selected="true" <?php }?>>DICIEMBRE</option>
                            </select>
                                <?php       
                                if(isset($_POST['mes'])){                                        
                                    if(empty($mes)){
                                        echo('<h4 class="validacion">El campo de "Mes" no puede estar vacío</h4>');
                                        $error = 1;                                               
                                    }else{
                                        $sql=$conn->prepare('Select * from dvm where sucursal = ? and mes = ? and año = ?');
                                        $sql->execute(array($numero, $mes, $año));
                                        $result=$sql->fetch();
                                        if($result==true){
                                            echo('<h4 class="validacion">Ya se Ingreso una Cantidad de Días Habiles para este Mes</h4>');
                                            $error = 1;
                                        }
                                    }
                                }
                                ?>
                                <br><br>
                        </div>            
                    </div> 

                    <div>                        
                        <label for="">3. Total de Días que Abrirá la Sucursal</label>
                            <div>                                 
                                <input type="text" name="año" value="<?php echo $año;?>" hidden>                            
                                <input type="text" name="dias">
                                <?php
                                if(isset($_POST['dias'])){
                                    if(empty($dias)){
                                        echo('<h4 class="validacion">Este campo no puede estar vacío</h4>');
                                        $error = 1;                                               
                                    }elseif(!preg_match("/^[0-9]{2}+$/",$dias)){
                                        echo('<h4 class="validacion">Este campo solo puede contener numeros y un máximo 2 dígitos</h4>');
                                        $error = 1;
                                    }elseif($dias > 31){
                                        echo('<h4 class="validacion">¡Valor Incorrecto! Un Mes no puede tener mas de 31 días.</h4>');
                                        $error = 1;
                                    }elseif($error==0){
                                        try {
                                            $sql=$conn->prepare('Insert into dvm (sucursal, mes, dias, año) values (?,?,?,?)');
                                            $result=$sql->execute([$numero, $mes, $dias, $año]);                                 
                                            if($result==true){?>
                                                <div class="container-modal">
                                                    <div class="content-modal">
                                                        <div class="content-body">
                                                            <?php 
                                                            echo"<h2>¡Días Laborales Registrados!</h>"; 
                                                            ?>
                                                        </div>
                                                        <div class="btn-cerrar">                                                      
                                                            <a href="venta.php">
                                                                <img class="modal-pic" src="/img/check.png" title="Check" alt="check">
                                                            </a>                                                      
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }else{
                                                echo('<h4 class="validacion">¡Error! Registro no realizado</h4>'); 
                                                // echo "\nPDO::errorCode(): ", $sql->errorCode();    
                                                // $arr = $sql->errorInfo();
                                                //         print_r($arr);                               
                                            } 
                                        }catch (\Throwable $th) {
                                            echo($th);
                                        }
                                                                                
                                    }
                                }
                                ?>
                                <br><br>
                            </div>            
                    </div>          

                    <div class="boton_formulario">
                        <button  class="boton_login" for="btn-modal1" type="submit">Registrar</button><br><br>         
                        <a href="venta.php"><img class="modal-pic1" src="/img/flecha.png" title="Regresar" alt="regresar"></a>                           
                    </div>            
                </form>
            </div>
        </div>
    </div>
</body>
</html>