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
$dato=$_GET['id'];
$sql=$conn->prepare('Select * from usuarios where id = ?;');   
$sql->execute([$dato]);                 
$result=$sql->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="../../../css/estilos.css" rel="stylesheet">
</head>
<body>
    <nav>
    <div>
        <a href="../index.php">Inicio</a>
        <a href="usuarios.php">Regresar</a>
        <a href="../../logout.php">Salir</a>         
        </div>            
    </nav>

    <div class="ingreso">
        <h1>Editar Usuario</h1><br>

        <div class="formulario">
            <form action="editar.php" method="POST">
                <div class="campo">
                    <input type="hidden" name="id" value="<?php echo $dato;?>" >
                    <label for="">1. Tipo</label>
                    <div>
                    <select name="tipo" id="" require> 
                        <option value="" selected="disable" hidden></option>
                        <option value="1" <?php if (isset($_POST['tipo'])){
                            echo $_POST['tipo'];
                        }
                        else if ($result->tipo == 1){?> selected="true" <?php }?>>Administrador</option> 
                                               
                        <option value="2" <?php  if (isset($_POST['tipo'])){
                            echo $_POST['tipo'];
                        }else if ($result->tipo == 2){?> selected="true" <?php }?>>Analista</option>
                        <option value="3" <?php  if (isset($_POST['tipo'])){
                            echo $_POST['tipo'];
                        }else if ($result->tipo == 3){?> selected="true" <?php }?>>Sucursal</option>
                        <option value="4" <?php  if (isset($_POST['tipo'])){
                            echo $_POST['tipo'];
                        }else if ($result->tipo == 4){?> selected="true" <?php }?>>Capital Humano</option>
                    </select><br>
                    <?php
                    if(isset($_POST['tipo'])){
                        $tipo = $_POST['tipo'];
                                $nombre = $_POST['nombre'];
                                $password = $_POST['password'];
                            if(empty($tipo)){
                                echo("<i style = 'color: red';>El campo de Tipo no puede estar vacio</i><br><br>");
                                $error = 1;                                               
                            }
                        }
                        ?>
                    </div>            
                </div>            
                
                <div class="campo">                
                    <label for="">2. Nombre</label>
                    <div>
                        <input type="text" name="nombre" value="<?php if(isset($_POST['nombre'])){ echo $_POST['nombre'];}
                        else{echo $result->nombre;}?>" require><br>
                        <?php
                            if(isset($_POST['nombre'])){
                                $nombre = $_POST['nombre'];
                                $password = $_POST['password'];
                                $tipo= $_POST['tipo'];
                                $dato=$_POST['id'];
                                
                                $error = 0;
                                if(empty($nombre)){
                                    echo("<i style = 'color: red';>El campo de Nombre no puede estar vacio</i><br><br>");
                                    $error = 1;                                               
                                }elseif(!preg_match("/^[a-zA-Z\s]{7,50}+$/",$nombre)){
                                    echo("<i style = 'color: red';>El campo de nombre no puede contener caracteres especiales y 
                                    debe tener de 7 a 50 caracteres</i><br><br>");
                                    $error = 1;
                                }
                                else{
                                    $sql=$conn->prepare('Select * from usuarios where nombre = ?');
                                    $sql->execute(array($nombre));
                                    $result=$sql->fetch();
                                    if($result==true){
                                        echo"<i style = 'color: red';>Usuario ya registrado (si esta intentanto modificar
                                        solo el &nbsp &nbsp  'TIPO' &nbsp &nbsp de usuario o la  &nbsp &nbsp  'CONTRASEÑA' , 
                                        debe modificar tambien el nombre de usuario para realizar la edición)</i><br><br>";
                                        $error = 1;
                                        echo "\nPDO::errorCode(): ", $sql->errorCode(); 
                                    }
                                }
                            }
                            ?>
                    </div>            
                </div>                

                <div class="campo">
                    <label for="">3. Contraseña</label>
                    <div>
                        <input type="password" name="password" value="<?php if(isset($_POST['password'])){ echo $_POST['password'];}
                    else{echo $result->password;}?>" require><br><br>
                        
                        <?php
                        if(isset($_POST['password'])){
                            if(empty($password)){
                                echo("<i style = 'color: red';>El campo de contraseña no puede estar vacio</i><br><br>");
                                $error = 1;
                            }elseif(!preg_match("/^(?=.[A-Za-z])(?=.\d)(?=.[@$!%#?&])[A-Za-z\d@$!%*#?&]{8,10}$/", $password) and strlen($password)<8){
                                echo("<i style = 'color: red';>El campo de contraseña debe contar con al menos 8 caracteres y debe contener letras, 
                                numeros y por lo menos un caracter especial (#, $, -, _, &, %, etc.)</i><br><br>");
                                $error = 1;
                            }
                            elseif($error == 0){
                                $sql=$conn->prepare('Update usuarios set nombre = ?, password = ?, tipo = ? where id = ?');
                                $result=$sql->execute([$nombre, $password, $tipo, $dato]);
                                if($result==true){?>
                                    <div class="container-modal">
                                        <div class="content-modal">
                                            <div class="content-body">
                                                <?php echo"<h2>¡Registro Editado Exitosamente!</h>"; ?>
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
                    <button class="boton_login" type="submit">EDITAR</button>                  
                </div>            
            </form>
        </div>
    </div>       
</body>
</html>