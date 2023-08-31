<?php
session_start();
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Sucursal</title>
    <link href="../../../css/estilos.css" rel="stylesheet">
</head>
<body">
    <nav>
    <div>
        <a href="../../../index.php">Inicio</a>
        <a href="sucursales.php">Regresar</a>
        <a href="../../logout.php">Salir</a>         
        </div>            
    </nav>

    <div class="ingreso">
        <h1>Alta de Sucursal</h1> 
    

        <div class="formulario">
            <form action="crear_suc.php" method="POST">          
                <div class="campo">
                <label for="">1. Plaza</label>
                <select name="plaza">
                    <option value="" selected="disable" hidden></option>
                    <option value="CDMX">CDMX</option>
                    <option value="Toluca">Toluca</option>
                    <option value="Morelia" >Morelia</option>
                </select><br>               
                <div class="campo">
                    <?php
                    if(isset($_POST['plaza'])){

                            $plaza = $_POST['plaza'];
                            $numero = $_POST['numero'];
                            $nombre = $_POST['nombre'];
                            $direccion = $_POST['direccion'];
                            $telefono = $_POST['telefono'];
                            $red = $_POST['red'];
                            $correo = $_POST['correo'];
                            $iduser = $_POST['id'];
                            $error = 0;
                            if(empty($plaza)){
                                echo("<i style = 'color: red';>El campo de Plaza no puede estar vacio</i><br><br>");
                                $error = 1;                                               
                            }
                        }
                        ?>
                    </div>            
                </div> 
                
                <div class="campo">
                    <label for="">2. Numero</label>
                    <div>
                    <input type="text" name="numero" <?php if(isset($_POST['numero'])){?>
                            value="<?=$_POST['numero']?>"><br><br>
                            <?php } ?>
                    <?php
                    if(isset($_POST['numero'])){
                            if(empty($numero)){
                                echo("<i style = 'color: red';>El campo de Numero no puede estar vacio</i><br><br>");
                                $error = 1;                                               
                            }elseif(!preg_match("/^[0-9]{1,3}+$/",$numero)){
                                echo("<i style = 'color: red';>El campo de numero solo puede contener numeros y debe tener entre 1
                                y 3 digitos</i><br><br>");
                                $error = 1;
                            }else{
                                $sql=$conn->prepare('Select * from sucursales where numero = ?');
                                $sql->execute(array($numero));
                                $result=$sql->fetch();
                                if($result==true){
                                    echo"<i style = 'color: red';>Numero de sucursal ya registrado</i><br><br>";
                                    $error = 1;
                                }
                            }
                        }
                        ?>
                    </div>            
                </div>                

                <div class="campo">
                    <label for="">3. Nombre</label>
                    <div>
                    <input type="text" name="nombre" <?php if(isset($_POST['nombre'])){?>
                            value="<?=$_POST['nombre']?>"><br><br>
                            <?php } ?>
                    <?php
                    if(isset($_POST['nombre'])){
                            if(empty($nombre)){
                                echo("<i style = 'color: red';>El campo de Nombre no puede estar vacio</i><br><br>");
                                $error = 1;                                               
                            }elseif(!preg_match("/^[a-zA-Z-0-9\s]{5,50}+$/",$nombre)){
                                echo("<i style = 'color: red';>El campo de nombre no puede contener caracteres especiales,
                                y debe tener de 5 a 50 caracteres</i><br><br>");
                                $error = 1;
                            }else{
                                $sql=$conn->prepare('Select * from sucursales where nombre = ?');
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

                <div class="campo">
                    <label for="">4. Dirección</label>
                    <div>
                    <input type="text" name="direccion" <?php if(isset($_POST['direccion'])){?>
                            value="<?=$_POST['direccion']?>"><br><br>
                            <?php } ?>

                    <?php
                    if(isset($_POST['direccion'])){
                            if(empty($direccion)){
                                echo("<i style = 'color: red';>El campo de Dirección no puede estar vacio</i><br><br>");
                                $error = 1;                                               
                            }elseif(!preg_match("/^[A-Za-z-0-9.#\s]{7,50}+$/",$direccion)){
                                echo("<i style = 'color: red';>El campo de nombre solo puede contener letras, numero y el simbolo '#'</i><br><br>");
                                $error = 1;
                            }
                        }
                        ?>
                    </div>            
                </div>                 

                <div class="campo">
                    <label for="">5. Telefono</label>
                    <div>
                    <input type="text" name="telefono" <?php if(isset($_POST['telefono'])){?>
                            value="<?=$_POST['telefono']?>"><br><br>
                            <?php } ?>
                    <?php
                    if(isset($_POST['telefono'])){
                            if(empty($telefono)){
                                echo("<i style = 'color: red';>El campo de Telefono no puede estar vacio</i><br><br>");
                                $error = 1;                                               
                            }elseif(!preg_match("/^[0-9]{10}+$/",$telefono)){
                                echo("<i style = 'color: red';>El campo de Telefono solo puede contener numeros 
                                y debe contar con 10 digitos</i><br><br>");
                                $error = 1;
                            }
                        }
                        ?>
                    </div>            
                </div> 

                <div class="campo">
                    <label for="">6. RED</label>
                    <div>
                    <input type="text" name="red" <?php if(isset($_POST['red'])){?>
                            value="<?=$_POST['red']?>"><br><br>
                            <?php } ?>
                    <?php
                    if(isset($_POST['red'])){
                            if(empty($red)){
                                echo("<i style = 'color: red';>El campo de RED no puede estar vacio</i><br><br>");
                                $error = 1;                                               
                            }elseif(!preg_match("/^[0-9]{4}+$/",$red)){
                                echo("<i style = 'color: red';>El campo de RED solo puede contener numeros 
                                y debe contar con 4 digitos</i><br><br>");
                                $error = 1;
                            }
                        }
                        ?>
                    </div>            
                </div> 

                <div class="campo">
                    <label for="">7. Correo</label>
                    <div>
                        <input type="email" name="correo" <?php if(isset($_POST['correo'])){?>
                            value="<?=$_POST['correo']?>"><br><br>
                            <?php } ?> <br>
                        <?php
                        if(isset($_POST['correo'])){ 
                            if(empty($correo)){
                                echo("<i style = 'color: red';>El campo de Correo no puede estar vacio</i><br><br>");
                                $error = 1;
                            }elseif(!preg_match("/^[A-Za-z-0-9.@\s]{23,50}$/", $correo) and strlen($correo)<23){
                                echo("<i style = 'color: red';>El campo de Correo debe contar con al menos 23 caracteres entre ellos
                                '@'(arroba) y '.' (punto) y no debe contener caracteres especiales (#, $, =, - , _ , &, %, etc.)</i><br><br>");
                                $error = 1;
                            }
                        } 
                        ?>
                    </div>            
                </div>           

                <div class="campo">
                    <label for="">8. ID</label>
                    <div>
                        <input type="text" name="id" <?php if(isset($_POST['id'])){?>
                            value="<?=$_POST['id']?>"><br><br>
                            <?php } ?>
                        <?php
                        if(isset($_POST['id'])){
                            if(empty($iduser)){
                                echo("<i style = 'color: red';>El campo de ID no puede estar vacio</i><br><br>");
                                $error = 1;
                            }elseif(!preg_match("/^[0-9]{1,4}+$/",$iduser)){
                                echo("<i style = 'color: red';>El campo de ID solo puede contener numeros</i><br><br>");
                                $error = 1;                            
                            }else{
                                $sql=$conn->prepare('Select * from sucursales where idusuario = ?');
                                $sql->execute(array($iduser));
                                $result=$sql->fetch();
                                if($result==true){
                                    echo"<i style = 'color: red';>Este ID ya esta asignado a una Sucursal</i><br><br>";
                                    $error = 1;
                                }else{
                                    $sql=$conn->prepare('Select * from usuarios where id = ?');
                                    $sql->execute(array($iduser));
                                    $result=$sql->fetch(PDO::FETCH_OBJ);
                                    if($result==false){
                                        echo"<i style = 'color: red';>Primero debe generar un perfil de usuario para la nueva Sucursal que intenta registrar</i><br><br>";
                                        $error = 1;
                                    }
                                    else if($result==true){
                                        $tp = $result->tipo;
                                        if($tp!=3){
                                            echo"<i style = 'color: red';> El ID que intenta registrar no pertenece a un perfil de USUARIO de tipo ''Sucursal''</i><br><br>";
                                            $error=1;
                                        }else{
                                            $error=0;
                                            if($error==0){
                                                try {
                                                    $sql=$conn->prepare('Insert into sucursales (plaza, numero, nombre, direccion, telefono, idusuario, estatus) values (?,?,?,?,?,?,?)');
                                                    $result=$sql->execute([$plaza, $numero, $nombre, $direccion, $telefono, $iduser, 1]);                                 
                                                    if($result==true){?>
                                                        <div class="container-modal">
                                                            <div class="content-modal">
                                                                <div class="content-body">
                                                                    <?php echo"<h2>¡Registro Exitoso!</h>"; ?>
                                                                </div>
                                                                <div class="btn-cerrar">                                                      
                                                                    <a href="sucursales.php">
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
                                    }                                                           
                                }                                
                            }
                        } 
                        ?>
                    </div>            
                </div>           

                <div>
                    <br><button class="boton_login" type="submit">Registrar</button>
                </div>            
            </form>
        </div> 
    </div>

</body>
</html>