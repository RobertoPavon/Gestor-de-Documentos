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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Venta</title>
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
        <h1>Editar Venta del Día</h1><br><br>
        <div class="formulario">
            <form action="editarventa.php" method="POST">                      
                <div>
                    <label for="" >1. Sucursal</label>                        
                    <div >
                        <input type="text" name="sucursal" readonly="true" value="<?= $numero ?>">                                   
                            <?php
                            if(isset($_POST['sucursal'])){
                                $fecha = $_POST['fecha'];
                                $venta = $_POST['venta'];
                                $numero = $_POST['sucursal'];                                   
                                $error = 0; 
                            }
                            ?>
                    </div>   <br><br>          
                </div> 

                <div >
                    <label for="" >2. Día de Venta</label>                        
                    <div >                        
                        <input type="date" name="fecha" ><br><br>
                        <?php       
                        if(isset($_POST['fecha'])){  
                            if(empty($fecha)){
                                echo ('<h4 class="validacion">El campo de Nombre no puede estar vacío</h4>');                                                                    
                                $error = 1;                                               
                            }else{
                                $sql=$conn->prepare('Select * from venta_diaria where sucursal = ? and fecha = ?');
                                $sql->execute(array($numero, $fecha));
                                $result=$sql->fetch();
                                if($result==false){
                                    echo ('<h4 class="validacion">Día de venta no registrado</h4>');
                                    $error = 1;
                                }
                            }                                        
                        }
                        ?>
                    </div>            
                </div> 

                <div>
                    <label for="">3. Venta del Día</label>
                    <div>                                
                        <input type="text" name="venta" placeholder="$ 00.00">
                        <?php
                        if(isset($_POST['venta'])){                                    
                            if(empty($venta)){
                                echo('<h4 class="validacion">El campo de Venta no puede estar vacío</h4>');
                                $error = 1;                                               
                            }elseif(!preg_match("/^[0-9.]{1,9}+$/",$venta)){
                                echo('<h4 class="validacion">El campo de "Venta" solo puede contener numeros y decimales y debe tener como mínimo un dígito </h4>');
                                $error = 1;
                            }                                                      
                        }
                        ?>
                    </div><br><br>            
                </div> 
                    
                <div>
                    <div class="cerrar_venta">                                
                        <input type="checkbox" name="cerrar"  title="Cerrar Venta del Día"><br>
                                               
                         <label  for="">* Cerrar Venta del Día</label>
                        
                            <?php
                                // if(isset($_POST['cerrar'])){
                                    if($error==0){
                                        $sql=$conn->prepare('Select * from venta_diaria where sucursal = ? and fecha = ? and estatus = ?');
                                        $sql->execute(array($numero, $fecha, 1));
                                        $result=$sql->fetch();
                                        if($result==true){
                                            // if($_POST['cerrar']){                                               
                                                if($_POST['cerrar']==true){                                       
                                                    try {
                                                        $sql=$conn->prepare('Update venta_diaria set venta = ?, estatus = ? where sucursal = ? and fecha = ?');
                                                        $result=$sql->execute([$venta, 0, $numero, $fecha]);                                 
                                                        if($result==true){?>
                                                            <div class="container-modal">
                                                                <div class="content-modal">
                                                                    <div class="content-body">                                                                        
                                                                        <h2>¡Se Edito la Venta del Día Correctamente!</h>    
                                                                        <h2>¡La Venta de este Día ya fue Cerrada, ya no podrá editarse!</h>                                                                     
                                                                    </div>
                                                                    <div class="btn-cerrar">                                                      
                                                                        <a href="venta.php">
                                                                            <img class="modal-pic" src="/img/check.png" title="Check" alt="check">
                                                                        </a>                                                      
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        <?php
                                                        }
                                                        else{
                                                            // $arr = $sql->errorInfo();
                                                            // print_r($arr);
                                                            echo('<h4 class="validacion">¡Error! Registro no realizado</h4>');                                                                            
                                                        } 
                                                    }
                                                    catch (\Throwable $th) {
                                                        echo($th);
                                                    }                                         
                                                }
                                            // }
                                            elseif($_POST['cerrar']==false){                                        
                                                try{
                                                    $sql=$conn->prepare('Update venta_diaria set venta = ? where sucursal = ? and fecha = ?');
                                                    $result=$sql->execute([$venta, $numero, $fecha]);                                 
                                                    if($result==true){?>
                                                        <div class="container-modal">
                                                            <div class="content-modal">
                                                                <div class="content-body">                                                                    
                                                                        <h2>¡Se Edito la Venta del Día Correctamente!</h>                                                                     
                                                                </div>
                                                                <div class="btn-cerrar">                                                      
                                                                    <a href="venta.php">
                                                                        <img class="modal-pic" src="/img/check.png" title="Check" alt="check">
                                                                    </a>                                                      
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    else{
                                                        echo('<h4 class="validacion">¡Error! Registro no realizado</h4>'); 
                                                        // echo "\nPDO::errorCode(): ", $sql->errorCode();                                   
                                                    } 
                                                }catch (\Throwable $th){
                                                    echo($th);
                                                }                                        
                                            }   
                                        }elseif($result==false){
                                            $sql=$conn->prepare('Select * from venta_diaria where sucursal = ? and fecha = ? and estatus = ?');
                                            $sql->execute(array($numero, $fecha, 0));
                                            $result=$sql->fetch();
                                            if($result==true){
                                                echo('<h4 class="validacion">¡La venta de esta fecha ya fue cerrada, no se puede Editar!</h4>');
                                                $error = 1;
                                            }
                                        }
                                    } 
                                // }   
                            ?>                        
                    </div>    <br><br>        
                </div> 

                <div class="boton_formulario">
                    <button  class="boton_login" for="btn-modal1" type="submit">Registrar</button><br><br>         
                    <a href="venta.php"><img class="modal-pic1" src="/img/flecha.png" title="Regresar" alt="regresar"></a>                           
                </div>            
            </form>
        </div>
    </div>
</body>
</html>