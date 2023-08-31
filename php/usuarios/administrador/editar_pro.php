<?php
session_start();
error_reporting(0);
include_once '../../conexion.php';
$nombre = $_SESSION['usuario'];
$id= $_SESSION['id'];
$tipo = $_SESSION['tipo'];
if(!isset($_SESSION['usuario'])){
    session_destroy();
    header('Location: ../../login.php');
}
if($tipo != 1){
    session_destroy();
    header('Location: ../../login.php');
}
$dato=$_GET['idproveedor'];
$sql=$conn->prepare('Select * from proveedor where idproveedor = ?;');   
$sql->execute([$dato]);                 
$result=$sql->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedor</title>
    <link href="../../../css/estilos.css" rel="stylesheet">

</head>
<body>
    <nav>
    <div>
        <a href="../../index.php">Inicio</a>
        <a href="proveedores.php">Regresar</a>
        <a href="../logout.php">Salir</a>         
        </div>            
    </nav>

    <div class="ingreso">
        <h1>Alta de Proveedor</h1><br>
    

        <div class="formulario">
            <form action="editar_pro.php" method="POST">          
                <div>
                    <label for="">Nombre</label>
                    <div> 
                    <input type="hidden" name="id" value="<?php if(isset($_POST['id'])){ echo $_POST['id'];} else{echo $dato;}?>" >
                    <input type="text" name="nombre" value="<?php if(isset($_POST['nombre'])){ echo $_POST['nombre'];}
                        else{echo $result->nombre;}?>"><br><br>
                    <?php
                    if(isset($_POST['nombre'])){
                        $nombre = $_POST['nombre'];
                        $rfc = $_POST['rfc'];
                        $telefono = $_POST['telefono'];
                        $dato = $_POST['id'];
                        $error = 0;
                            if(empty($nombre)){
                                echo("<i style = 'color: red';>El campo de Nombre no puede estar vacio</i><br><br>");
                                $error = 1;                                               
                            }else{
                                $sql=$conn->prepare('Select * from proveedor where nombre = ?');
                                $sql->execute(array($nombre));
                                $result=$sql->fetch();
                                if($result==true){
                                    echo"<i style = 'color: red';>Nombre ya registrado</i><br><br>";
                                    $error = 1;
                                }
                            }
                        }
                        ?>
                    </div>            
                </div>       
                
                <div>
                    <label for="">2. RFC</label>
                    <div>
                    <input type="text" name="rfc" value="<?php if(isset($_POST['rfc'])){ echo $_POST['rfc'];}
                        else{echo $result->rfc;}?>"><br><br>
                    <?php
                    if(isset($_POST['rfc'])){
                            if(empty($rfc)){
                                echo("<i style = 'color: red';>El campo de RFC no puede estar vacio</i><br><br>");
                                $error = 1;                                               
                            }
                        }
                        ?>
                    </div>            
                </div>    
                
                <div class="campo">
                    <label for="">3. Telefono</label>
                    <div>
                    <input type="text" name="telefono" value="<?php if(isset($_POST['telefono'])){ echo $_POST['telefono'];}
                        else{echo $result->telefono;}?>"><br><br>
                    
                    <?php
                    if(isset($_POST['telefono'])){
                            if(empty($telefono)){
                                echo("<i style = 'color: red';>El campo de Telefono no puede estar vacio</i><br><br>");
                                $error = 1;                                               
                            }elseif(!preg_match("/^[0-9]{10}+$/",$telefono)){
                                echo("<i style = 'color: red';>El campo de Telefono solo puede contener numeros 
                                y debe contar con 10 digitos</i><br><br>");
                                $error = 1;
                            }elseif($error==0){
                                try {
                                    $sql=$conn->prepare('Update proveedor set nombre = ?, rfc = ?, telefono = ? where idproveedor = ?');
                                    $result=$sql->execute([$nombre, $rfc, $telefono, $dato]);                                 
                                    if($result==true){?>
                                        <div class="container-modal">
                                            <div class="content-modal">
                                                <div class="content-body">
                                                    <?php echo"<h2>¡Registro Editado Exitosamente!</h>"; ?>
                                                </div>
                                                <div class="btn-cerrar">                                                      
                                                    <a href="proveedores.php">
                                                        <img class="modal-pic" src="/img/check.png" title="Check" alt="check">
                                                    </a>                                                      
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }else{
                                        echo"<i style = 'color: red';>¡Error! Registro no realizado</i>"; 
                                        // echo "\nPDO::errorCode(): ", $sql->errorCode();                                   
                                    } 
                                } catch (\Throwable $th) {
                                    echo($th);
                                }
                            }
                        }
                    ?>
                </div>       

                <div>
                    <button  class="boton_login" type="submit">EDITAR</button>
                </div>            
            </form>
        </div>
    </div>
</body>
</html>