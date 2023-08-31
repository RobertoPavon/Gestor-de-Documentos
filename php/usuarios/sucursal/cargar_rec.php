<?php
// error_reporting(0);
session_start();
include_once '../../conexion.php';
$nombre = $_SESSION['usuario'];
$id= $_SESSION['id'];
$tipo = $_SESSION['tipo'];
$numero = $_SESSION['numero'];
if(!isset($_SESSION['usuario'])){
    header('Location: ../../login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Recibo</title>
    <link href="../../../css/estilos.css" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="nav_user">
            <a href="/index.php"><img src="/img/logo.png" alt="logo"></a>  
            <a href="../recibos.php">Regresar</a>
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
        <h1>Cargar Nuevo Recibo</h1>

        <div class="formulario">
            <form action="cargar_rec.php" method="POST" enctype="multipart/form-data">         
                <div class="campo">
                    <label>1. Sucursal</label>
                    <div>
                        <input type="text" name="sucursal" readonly="true" value="<?= $numero ?>"><br><br>
                        <?php
                        date_default_timezone_set('America/Mexico_City');
                        $fcha = date("d/m/Y");
                        if(isset($_POST['sucursal'])){
                                $sucursal = $_POST['sucursal'];
                                $autorizacion = $_POST['autorizacion'];
                                $deposito = $_POST['deposito'];
                                $carga = $_POST['carga'];
                                $error = 0;                        
                            }
                        ?>
                    </div>            
                </div>                                                                  
                
                <div>
                    <label for="" >2. Numero de Autorización</label>
                    <div >
                    <input type="text" name="autorizacion" <?php if(isset($_POST['autorizacion'])){?>
                            value="<?=$_POST['autorizacion']?>"><br><br>
                            <?php } ?>
                    <?php
                        if(isset($_POST['autorizacion'])){
                            if(empty($autorizacion)){
                                echo ('<h4 class="validacion">>El campo Numero de Autorización no puede estar vacío </h4>');
                                $error = 1;                                               
                            }elseif(!preg_match("/^[a-zA-Z0-9]+$/",$autorizacion)){
                                echo ('<h4 class="validacion">El campo de "Numero de Autorización" solo puede contener numeros</h4>');
                                $error = 1;
                            }else{
                                $sql=$conn->prepare('Select * from autorizacion where autorizacion = ?');
                                $sql->execute(array($autorizacion));
                                $result=$sql->fetch();
                                if($result==true){
                                    echo ('<h4 class="validacion">Numero de Autorización ya registrado</h4>');
                                    $error = 1;
                                }
                            }
                        }
                    ?>
                    </div>            
                </div> 
                                                                            
                <div class="campo">
                    <label>3. Fecha a la que corresponde el Deposito</label>
                    <div>
                    <input type="date" name="deposito" min="2022-01-01" max="2024-12-31" required="true"><br>
                    <?php
                    if(isset($_POST['deposito'])){
                        
                            if(empty($deposito)){
                                echo ('<h4 class="validacion">El campo de "Fecha" no puede estar vacío</h4>');
                                $error = 1;                                               
                            }                           
                        }
                        ?>
                    </div>            
                </div> 

                <div class="campo">
                    <label>4. Fecha de Carga</label>
                    <div>
                    <input type="text" name="carga" value= "<?php echo ($fcha);?>" readonly="true"><br>
                    <?php
                    if(isset($_POST['carga'])){
                            if(empty($carga)){
                                echo ('<h4 class="validacion">El campo de "Fecha de Carga" no puede estar vacío</h4>');
                                $error = 1;                                               
                            }
                        }
                        ?>
                    </div>            
                </div> 
                                                                    
                <div class="campo">
                    <label>5. Documento</label>
                    <div class="file-select">
                        <input type="file" name="documento"><br><br>
                        <?php     
                        $archivo = $_FILES['documento']['name'];
                        $archivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));           
                            if(isset($_POST['deposito'])){
                                if(!file_exists('documento')){
                                    echo ('<h4 class="validacion"> >El campo de Documento no puede estar vacío</h4>');
                                    $error = 1;                                               
                                }
                                if($_FILES['documento']){ 
                                    if($archivo == "jpg"){
                                        $renombrar = $numero." - DEPOSITO - ".$deposito.".jpg";
                                    }elseif ($archivo == "jpeg"){
                                        $renombrar = $numero." - DEPOSITO - ".$deposito.".jpeg";
                                    }elseif ($archivo == "pdf"){
                                        $renombrar = $numero." - DEPOSITO - ".$deposito.".pdf";
                                    }else{
                                        echo ('<h4 class="validacion">El Archivo seleccionado no es valido, solo se pueden subir archivos 
                                        de tipo PDF, JPG y JPEG</h4>');
                                        $error = 1;
                                    }
                                    if(move_uploaded_file($_FILES['documento']['tmp_name'],"../../../files/recibos/".$renombrar)){
                                        echo"archivo movido correctamente";
                                            $error = 0;
                                    }else{
                                        echo ('<h4 class="validacion">ERROR AL MOVER EL ARCHIVO</h4>');
                                        $error = 1;
                                    }                                                                     
                                }
                                if($error==0){                                      
                                    try {
                                        $sql=$conn->prepare('Insert into recibos (sucursal, autorizacion, fechaDeposito, fechaCarga, documento) values (?,?,?,?,?)');
                                        $result=$sql->execute([$sucursal, $autorizacion, $deposito, $carga, $renombrar]);                                 
                                        if($result==true){?>
                                            <div class="container-modal">
                                                <div class="content-modal">
                                                    <div class="content-body">
                                                        <?php 
                                                        echo"<h2>Documento Guardado Exitosamente!</h>";
                                                         ?>
                                                    </div>
                                                    <div class="btn-cerrar">                                                      
                                                        <a href="../recibos.php">
                                                            <img class="modal-pic" src="/img/check.png" title="Check" alt="check">
                                                        </a>                                                      
                                                    </div>
                                                </div>
                                            </div>
                                            <?php                                            
                                        }else{
                                            echo ('<h4 class="validacion"> ¡Error! El Archivo NO se Guardo</h4>'); 
                                            // echo "\nPDO::errorCode(): ", $sql->errorCode();                                   
                                        } 
                                    } catch (\Throwable $th) {
                                        echo($th);
                                    }
                                }
                            }                                       
                        ?>
                    </div>            
                </div>            
                    

                <div class="boton_formulario">
                    <button class="boton_login" type="submit">Cargar Recibo</button><br><br>
                    <a href="../recibos.php"><img class="modal-pic1" src="/img/flecha.png" title="Regresar" alt="regresar"></a>   
                </div>            
            </form>
        </div>
    </div>
</body>
</html>