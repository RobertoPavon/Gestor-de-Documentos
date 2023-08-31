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
    <title>Nuevo Usuario</title>
    <link href="../../../css/estilos.css" rel="stylesheet">
</head>
<body>
    <nav>
    <div>
        <a href="../../../index.php">Inicio</a>
        <a href="usuarios.php">Regresar</a>
        <a href="../../logout.php">Salir</a>         
        </div>            
    </nav>

    <div class="ingreso">
        <h1>Alta de Nuevo Usuario</h1><br>

        <div class="formulario">
            <form action="crear.php" method="POST">
                <div class="campo">
                    <label for="">1. Tipo</label>
                    <div>
                        <select name="tipo" id="" >
                            <option value="" selected="disable" hidden></option>
                            <option value="1">Administrador</option>
                            <option value="2">Analista</option>
                            <option value="3" >Sucursal</option>
                            <option value="4" >Capital Humano</option>                        
                        </select><br>
                        <?php
                            if(isset($_POST['tipo'])){
                                $tipo = $_POST['tipo'];
                                $nombre = $_POST['nombre'];
                                $password = $_POST['password'];

                                if(empty($tipo)){
                                    echo "<i style = 'color: red';>El campo de Tipo no puede estar vacio</i><br><br>";
                                    $error = 1;                                               
                                }
                            }                        
                        ?>
                    </div>            
                </div>            
                
                <div class="campo">
                    <label for="">2. Nombre</label>
                    <div>
                        <input type="text" name="nombre" <?php if(isset($_POST['nombre'])){?> value="<?=$_POST['nombre']?>">
                        <?php 
                            } 
                        
                            if(isset($_POST['nombre'])){                                                              
                                $error = 0;
                                if(empty($nombre)){
                                    echo "<i style = 'color: red';>El campo de Nombre no puede estar vacio</i><br><br>";
                                    $error = 1;                                               
                                }elseif(!preg_match("/^[a-zA-Z-0-9\s]{5,50}+$/",$nombre)){
                                    echo("<i style = 'color: red';>El campo de nombre no puede contener caracteres especiales y 
                                    debe contar con 5 a 50 caracteres</i><br><br>");
                                    $error = 1;
                                }else{
                                    $sql=$conn->prepare('Select * from usuarios where nombre = ?');
                                    $sql->execute(array($nombre));
                                    $result=$sql->fetch();
                                    if($result==true){
                                        echo ("<i style = 'color: red';>Usuario ya registrado</i><br><br>");
                                        $error = 1;
                                        // echo "\nPDO::errorCode(): ", $sql->errorCode(); 
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>                

                <div class="campo">
                    <label for="">3. Contraseña</label>
                    <div>
                        <input type="password" name="password"><br><br>
                        <?php
                        if(isset($_POST['password'])){
                            if(empty($password)){
                                echo("<i style = 'color: red';>El campo de contraseña no puede estar vacio</i><br><br>");
                                $error = 1;
                            }elseif(!preg_match("/^(?=.[A-Za-z])(?=.\d)(?=.[@$!%#?&])[A-Za-z\d@$!%*#?&]{8,10}$/", $password) and strlen($password)<8){
                                echo("<i style = 'color: red';>El campo de contraseña debe contar con al menos 8 caracteres y debe contener letras, 
                                numeros y por lo menos un caracter especial (#, $, - , _ , &, %, etc.)</i><br><br>");
                                $error = 1;
                            }elseif($error==0){
                                $sql=$conn->prepare('Insert into usuarios (nombre, password, tipo, estatus) values (?,?,?,?)');
                                $result=$sql->execute([$nombre, $password, $tipo, 1]);
                                if($result==true){?>
                                    <div class="container-modal">
                                        <div class="content-modal">
                                            <div class="content-body">
                                                <?php echo"<h2>¡Usuario Registrado Exitosamente!</h>"; ?>
                                            </div>
                                            <div class="btn-cerrar">                                                      
                                                <a href="usuarios.php">
                                                    <img class="modal-pic" src="/img/check.png" title="Check" alt="check">
                                                </a>                                                      
                                            </div>
                                        </div>
                                    </div>
                                    <?php

                                }else{
                                    echo"<i style = 'color: red';>¡Error! Registro no realizado</i>";
                                } 
                            }
                        } 
                        ?>
                    </div>            
                </div>           

                <div>
                    <button class="boton_login" type="submit">REGISTRAR</button>
                </div>            
            </form>
        </div>
    </div>
        

</body>
</html>