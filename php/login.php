<?php
error_reporting(0);
ob_start();
$nombre = $_SESSION['usuario'];
if(session_start()==true){
    if(isset($_SESSION['usuario'])){
        header('Location: panel.php');
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="../css/estilos.css" rel="stylesheet">
</head>
<body>
    <?php
    include "nav.php";
    ?><br><br>

    <div class="ingreso">
        <h2>LOGIN</h2><br><br><br>
        <form action="login.php" method="POST">
            <div class="formulario">
                <label for="">Nombre Completo</label>
                <div>            
                    <input type="text" name="nombre" id="nombre">
                    <?php
                    if(isset($_POST['nombre'])){
                        include_once 'conexion.php';
                        $nombre = $_POST['nombre'];
                        $password = $_POST['password'];
                        $error = 0;
                        if(empty($nombre)){
                            echo ('<h4 class="validacion">El campo de "Nombre" no puede estar vacío</h4>');
                            $error = 1;                                               
                        }elseif(!preg_match("/[a-zA-Z]{5,30}/",$nombre)){
                            echo ('<h4 class="validacion">El campo de "Nombre" solo puede contener letras</h4>');
                            $error = 1;
                        }else{
                            $sql=$conn->prepare('Select * from usuarios where nombre = ? and estatus = 1');
                            $sql->execute(array($nombre));
                            $result=$sql->fetch();
                            if($result==false){
                                echo"<i style = 'color: red';>Usuario no registrado</i><br><br>";
                                $error = 1;
                            }
                        }
                    }
                    ?>
                    <br><br>
                </div>
            </div>
                                        
            <div>
                <label for="">Contraseña</label>   
                <div>
                    <input type="password" name="password" autocomplete="off">
                    <?php
                    if(isset($_POST['password'])){
                        if(empty($password)){
                            echo  ('<h4 class="validacion">El campo de "Contraseña" no puede estar vacio</h4>');
                        }elseif(!preg_match("/^(?=.[A-Za-z])(?=.\d)(?=.[@$!%#?&])[A-Za-z\d@$!%*#?&]{8,10})$/", $password) and strlen($password)<8 and strlen($password)>10){
                            echo ('<h4 class="validacion">El campo de "Contraseña" debe tener entre 8 y 10 caracteres y debe contener letras, 
                            numeros y por lo menos un caracter especial (#, $, -, _, &, %, etc.</h4>');
                            $error = 1;
                        }else{
                            $sql=$conn->prepare('Select * from usuarios where nombre = ? and password = ?');
                            $sql->execute(array($nombre, $password));
                            $result=$sql->fetch(PDO::FETCH_OBJ); 
                            if($result==false){ 
                                echo ('<h4 class="validacion">Contraseña Incorrecta</h4>'); 
                            }elseif($result==true and $error == 0){   
                                $tipo=$result->tipo;
                                $id=$result->id;
                                session_start(); 
                                $_SESSION['usuario']=$nombre;
                                $_SESSION['tipo']=$tipo;
                                $_SESSION['id']=$id;
                                header("Location:panel.php");                                    
                            }
                        }
                    } 
                    ?>                    
                </div><br><br>
            </div>
            <div>
            <button class="boton_login" type="submit">INGRESAR</button><br><br>
            </div>
        </form>
    </div><br><br><br>
    <?php
    include "footer.php";
    ?>
</body>
</html>