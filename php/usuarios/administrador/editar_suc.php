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
$dato=$_GET['numero'];
$sql=$conn->prepare('Select * from sucursales where numero = ?;');   
$sql->execute([$dato]);                 
$result=$sql->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Sucursal</title>
    <link href="../../../css/estilos.css" rel="stylesheet">
</head>
<body">
    <nav>
    <div>
        <a href="../index.php">Inicio</a>
        <a href="sucursales.php">Regresar</a>
        <a href="../logout.php">Salir</a>         
    </div>            
    </nav>

    <div class="ingreso">
        <h1>Editar Sucursal</h1>
    

        <div class="formulario">
            <form action="editar_suc.php" method="POST">          
                <div class="campo">
                <label for="">1. Plaza</label>
                <select name="plaza">
                    <option value="" selected="disable" hidden></option>
                    <option value="CDMX" <?php if (isset($_POST['plaza'])){
                        echo $_POST['plaza'];
                    }
                    else if($result->plaza == "CDMX"){?> selected="true" <?php }?>>CDMX</option>
                    <option value="Toluca" <?php if (isset($_POST['plaza'])){
                        echo $_POST['plaza'];
                    }else if ($result->plaza == "Toluca"){?> selected="true" <?php }?>>Toluca</option>
                    <option value="Morelia" <?php if (isset($_POST['plaza'])){
                        echo $_POST['plaza'];
                    }else if ($result->plaza == "Morelia"){?> selected="true" <?php }?>>Morelia</option>
                </select><br>               
                <div class="campo">
                    <?php
                    if(isset($_POST['plaza'])){
                            $plaza = $_POST['plaza'];
                            $dato = $_POST['numero']; 
                            $nombre = $_POST['nombre'];
                            $direccion = $_POST['direccion'];
                            $telefono = $_POST['telefono'];
                            $red = $_POST['red'];
                            $correo = $_POST['correo'];
                            // $iduser = $_POST['id'];
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
                    <input type="text" name="numero" readonly value="<?php  
                                                        if(isset($_POST['numero'])){
                                                            echo $_POST['numero'];
                                                        }else { echo $result->numero;} ?>
                                                        "><br>
                    <?php
                    // if(isset($_POST['numero'])){
                    //         if(empty($numero)){
                    //             echo("<i style = 'color: red';>El campo de Numero no puede estar vacio</i><br><br>");
                    //             $error = 1;                                               
                    //         }elseif(!preg_match("/^[0-9]{1,3}+$/",$numero)){
                    //             echo("<i style = 'color: red';>El campo de numero solo puede contener numeros y debe tener entre 1
                    //             y 3 digitos</i><br><br>");
                    //             $error = 1;
                    //         }else{
                    //             $sql=$conn->prepare('Select * from sucursales where numero = ?');
                    //             $sql->execute(array($numero));
                    //             $result=$sql->fetch();
                    //             if($result==true){
                    //                 echo"<i style = 'color: red';>Numero de sucursal ya registrado</i><br><br>";
                    //                 $error = 1;
                    //             }
                    //         }
                    //     }
                        ?>
                    </div>            
                </div>                

                <div class="campo">
                    <label for="">3. Nombre</label>
                    <div>
                    <input type="text" name="nombre" value="<?php if(isset($_POST['nombre'])){ echo $_POST['nombre'];}
                    else{echo $result->nombre;}?>"><br><br>
                    <?php
                    if(isset($_POST['nombre'])){
                            if(empty($nombre)){
                                echo("<i style = 'color: red';>El campo de Nombre no puede estar vacio</i><br><br>");
                                $error = 1;                                               
                            }elseif(!preg_match("/^[a-zA-Z-0-9\s]{7,50}+$/",$nombre)){
                                echo("<i style = 'color: red';>El campo de nombre no puede contener caracteres especiales,
                                y debe tener de 5 a 50 caracteres</i><br><br>");
                                $error = 1;
                            }
                            else{
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
                    <input type="text" name="direccion" value="<?php if(isset($_POST['direccion'])){
                        echo $_POST['direccion'];
                        }else{
                            echo $result->direccion;
                        }
                        ?>"><br><br>

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
                    <input type="text" name="telefono" value="<?php if(isset($_POST['telefono'])){
                       echo $_POST['telefono'];
                    }else{
                        echo $result->telefono;
                    }
                    ?>"><br><br>

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
                    <input type="text" name="red" value="<?php if(isset($_POST['red'])){
                            echo $_POST['red'];
                    }
                    else{
                        echo $result->red;                
                    }?>"><br><br>
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
                        <input type="email" name="correo" value=" <?php if(isset($_POST['correo'])){
                            echo $_POST['correo'];
                        }
                        else{
                            echo $result->correo;                
                        }?>"><br><br>
                        
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
                            if($error==0){
                                try {
                                    $sql=$conn->prepare('update sucursales set plaza = ?, nombre = ?, direccion = ?, telefono = ?, red = ?, correo = ? where numero = ?');
                                        $result=$sql->execute([$plaza, $nombre, $direccion, $telefono, $red, $correo, $dato]);                                 
                                            if($result==true){?>

                                                <div class="container-modal">
                                                    <div class="content-modal">
                                                        <div class="content-body">
                                                        <?php echo"<h2>¡Registro Editado Exitosamente!</h>"; ?>
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
                        ?>
                    </div>            
                </div>       


                <div>
                    <br><button class="boton_login" type="submit">EDITAR</button>
                </div>            
            </form>
        </div> 
    </div>

</body>
</html>