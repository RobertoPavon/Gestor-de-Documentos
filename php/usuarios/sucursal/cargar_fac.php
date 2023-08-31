<?php
error_reporting(0);
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
    <title>Cargar Facturas</title>
    <link href="../../../css/estilos.css" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="nav_user">
            <a href="/index.php"><img src="/img/logo.png" alt="logo"></a>  
            <a href="../facturas.php">Regresar</a>
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
        <h1>Cargar Nueva Factura</h1>
    

        <div class="formulario">
            <form action="cargar_fac.php" method="POST" enctype="multipart/form-data">          
                <div>
                    <label for="" >1. Sucursal</label>
                    <div >
                    <input type="text" name="sucursal" readonly="true" value="<?= $numero ?>"><br><br>
                    <?php
                    date_default_timezone_set('America/Mexico_City');
                    date("d/m/Y");                
                    $fcha = date("d/m/Y");

                    if(isset($_POST['sucursal'])){
                            $sucursal = $_POST['sucursal'];
                            $factura = $_POST['factura'];
                            $recepcion = $_POST['recepcion'];
                            $carga = $_POST['carga'];
                            $proveedor = $_POST['proveedor'];
                            $error = 1;                        
                        }
                        ?>
                    </div>            
                </div> 
                                                                                        
                <div>
                    <label for="" >2. Numero de Factura</label>
                    <div >
                    <input type="text" name="factura" <?php if(isset($_POST['factura'])){?>
                            value="<?=$_POST['factura']?>"><br><br>
                            <?php } ?>
                    <?php
                    if(isset($_POST['factura'])){
                            if(empty($factura)){
                                echo ('<h4 class="validacion"> </h4>') ("<i style = 'color: red';>El campo Numero de factura no puede estar vacio</i><br><br>");
                                $error = 1;                                               
                            }elseif(!preg_match("/^[a-zA-Z0-9]+$/",$factura)){
                                echo ('<h4 class="validacion">El campo de "Factura" solo puede contener numeros</h4>');
                                $error = 1;
                            }else{
                                $sql=$conn->prepare('Select * from facturas where factura = ?');
                                $sql->execute(array($factura));
                                $result=$sql->fetch();
                                if($result==true){
                                    echo ('<h4 class="validacion">Numero de Factura ya Registrado</h4>');
                                    $error = 1;
                                }
                            }
                        }
                        ?>  
                    </div>            
                </div>         <br>       

                <div >
                    <label for="" >3. ID de Proveedor</label>
                    <div >
                        <input type="number" name="proveedor" min="1" max="3" ><br><br>
                        <?php
                        if(isset($_POST['proveedor'])){
                            if(empty($proveedor)){
                                echo ('<h4 class="validacion">El campo de ID no puede estar vacio</h4>');
                                $error = 1;
                            }                   
                        }
                        ?>
                    </div>            
                </div> 
                                                                                  
                <div >
                    <label for="" >4. Fecha de Recepcción</label>
                    <div >
                    <input type="date" name="recepcion" ><br><br>
                    <?php
                    if(isset($_POST['recepcion'])){
                            if(empty($recepcion)){
                                echo ('<h4 class="validacion">El campo de "Nombre" no puede estar vacío</h4>');
                                $error = 1;                                               
                            }
                        }
                        ?>
                    </div>            
                </div> 

                <div class=>
                    <label for="">5. Fecha de Carga</label>
                    <div >
                    <input type="text" name="carga" value= "<?php echo ($fcha);?>" readonly="true"><br><br>
                    <?php
                    if(isset($_POST['carga'])){
                            if(empty($carga)){
                                echo ('<h4 class="validacion">>El campo de "Dirección" no puede estar vacío</h4>');
                                $error = 1;                                               
                            }
                        }
                        ?>
                    </div>            
                </div> 
                                                                            
                <div>
                    <label>6. Documento</label>
                    <div >
                    <input type="file" name="documento" ><br><br>
                    <?php
                        $archivo = $_FILES['documento']['name'];
                        $archivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
                        if(isset($_POST['factura'])){                            
                            if(!file_exists('documento')){
                                echo ('<h4 class="validacion">El campo de "Documento" no puede estar vacío </h4>');
                                $error = 1;                                               
                            }
                            if($_FILES['documento']){
                                if($archivo == "jpg"){
                                    $renombrar = $numero." - FACTURA - ".$factura.".jpg";
                                }elseif ($archivo == "jpeg"){
                                    $renombrar = $numero." - FACTURA - ".$factura.".jpeg";
                                }elseif ($archivo == "pdf"){
                                    $renombrar = $numero." - FACTURA - ".$factura.".pdf";
                                }else{
                                    echo ('<h4 class="validacion">El Archivo seleccionado no es valido, solo se pueden subir archivos 
                                    de tipo PDF, JPG y JPEG</h4>');
                                    $error = 1;
                                }
                                
                                if(move_uploaded_file($_FILES['documento']['tmp_name'],"../../../files/facturas/".$renombrar)){
                                    echo"archivo movido correctamente";
                                    $error = 0;
                                }else{
                                    echo ('<h4 class="validacion">ERROR AL MOVER EL ARCHIVO</h4>');
                                    $error = 1;
                                }                                                              
                            }                   
                            if($error==0){
                                try {
                                    $sql=$conn->prepare('Insert into facturas (sucursal, factura, recepcion, carga, documento, proveedor) values (?,?,?,?,?,?)');
                                    $result=$sql->execute([$sucursal, $factura, $recepcion, $carga, $renombrar, $proveedor]);                              
                                    if($result==true){?>
                                    <div class="container-modal">
                                                <div class="content-modal">
                                                    <div class="content-body">
                                                        <?php 
                                                        echo"<h2>Documento Guardado Exitosamente!</h>"; 
                                                        ?>
                                                    </div>
                                                    <div class="btn-cerrar">                                                      
                                                        <a href="../facturas.php">
                                                            <img class="modal-pic" src="/img/check.png" title="Check" alt="check">
                                                        </a>                                                      
                                                    </div>
                                                </div>
                                            </div>
                                            <?php                                            
                                        }else{
                                            echo  ('<h4 class="validacion">¡Error! El Archivo NO se Guardo</h4>');                              
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
                    <button class="boton_login" type="submit">Cargar Factura</button><br><br>
                    <a href="../facturas.php"><img class="modal-pic1" src="/img/flecha.png" title="Regresar" alt="regresar"></a> 
                </div>            
            </form>
        </div>
    </div>

</body>
</html>