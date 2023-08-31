<?php
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
        <h1>Registro de Venta Diaria</h1><br><br>
            <div class="formulario">
                <form action="registroventa.php" method="POST"> 
                    <div >
                        <label for="" >1. Sucursal</label>                        
                        <div >
                            <input type="text" name="sucursal" readonly="true" value="<?= $numero ?>"><br><br>                                    
                                <?php

                                if(isset($_POST['sucursal'])){
                                    $fecha = $_POST['fecha'];
                                    $venta = $_POST['venta'];
                                    $numero = $_POST['sucursal'];
                                    $mes = $_POST['mes'];
                                    $año = $_POST['año'];                                     
                                    $error = 0; 
                                }
                                ?>
                        </div>            
                    </div> 

                    <div >
                        <label for="" >2. Día de Venta</label>                        
                        <div >                        
                                <input type="date" name="fecha" >
                                <?php       
                                if(isset($_POST['fecha'])){    
                                    // se crea la variable $fcha para separar los datos de la fecha seleccionada por el usuario en dia, mes y año
                                    // mediante la propiedad explode 
                                    $fcha=list($año,$mes,$dia) = explode('-', $fecha);
                                    
                                    if(empty($fecha)){
                                        echo ('<h4 class="validacion">El campo de Nombre no puede estar vacio</h4>');
                                        $error = 1;                                               
                                    }else{
                                        $sql=$conn->prepare('Select * from venta_diaria where sucursal = ? and fecha = ?');
                                        $sql->execute(array($numero, $venta));
                                        $result=$sql->fetch();
                                        if($result==true){
                                            echo ('<h4 class="validacion"> Día de Venta ya Registrado</h4>');
                                            $error = 1;
                                        }
                                    }
                                }
                                ?>
                        </div>  <br><br>          
                    </div> 

                    <div>                        
                        <label for="">3. Venta del Día</label>
                            <div>                                 
                                <input type="text" name="mes" value="<?php echo $mes;?>" hidden>
                                <input type="text" name="año" value="<?php echo $año;?>" hidden>                            
                                <input type="text" name="venta" placeholder="$ 00.00">
                                <?php
                                if(isset($_POST['venta'])){
                                    // $error = 0;
                                    if(empty($venta)){
                                        echo ('<h4 class="validacion">El campo de Venta no puede estar vacío</h4>');
                                        $error = 1;                                               
                                    }elseif(!preg_match("/^[0-9.]{1,9}+$/",$venta)){
                                        echo ('<h4 class="validacion">El campo de "Venta" solo puede contener numeros y decimales y debe tener como mínimo un digito </h4>');
                                        $error = 1;
                                    }elseif($error==0){
                                        $sql=$conn->prepare('Select * from venta_diaria where sucursal = ? and fecha = ?');
                                        $sql->execute(array($numero, $fecha));
                                        $result=$sql->fetch();
                                        if($result==true){
                                            echo ('<h4 class="validacion">La Venta inicial de este Día ya fue Registrada</h4>');
                                            $error = 1;
                                        }else{
                                            try {
                                                $sql=$conn->prepare('Insert into venta_diaria (sucursal, fecha, venta, mes, año, estatus) values (?,?,?,?,?,?)');
                                                $result=$sql->execute([$numero, $fecha, $venta, $mes, $año, 1]);                                 
                                                if($result==true){?>
                                                    <div class="container-modal">
                                                        <div class="content-modal">
                                                            <div class="content-body">
                                                                <?php 
                                                                echo"<h2>¡Venta del Día Registrada!</h>"; 
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
                                                    echo ('<h4 class="validacion">¡Error! Registro no realizado</h4>'); 
                                                    // echo "\nPDO::errorCode(): ", $sql->errorCode();    
                                                    // $arr = $sql->errorInfo();
                                                    //         print_r($arr);                               
                                                } 
                                            }catch (\Throwable $th) {
                                                echo($th);
                                            }
                                        }                                        
                                    }
                                }
                                ?>
                            </div> <br><br>           
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