<?php
session_start();
include_once '../../conexion.php';
$nombre = $_SESSION['usuario'];
$id= $_SESSION['id'];
$tipo = $_SESSION['tipo'];
// $numero = $_SESSION['numero'];
if(!isset($_SESSION['usuario'])){
    session_destroy();
    header('Location: ../../login.php');
}
if($tipo == 3){
    session_destroy();
    header('Location: ../../login.php');
}
if (isset($_POST['id'])){
    $dato = $_POST['id'];
    }
else{
    $dato=$_GET['idpresupuesto'];
}

$sql=$conn->prepare('Select * from presupuesto where idpresupuesto = ?');   
$sql->execute([$dato]);                   
$result=$sql->fetch(PDO::FETCH_OBJ);
if (isset($_POST['mes'])){
    $mes = $_POST['mes'];
    }
else{
    $mes= $result->mes;
}
if (isset($_POST['año'])){
    $año = $_POST['año'];
    }
else{
    $año= $result->año;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Presupuesto</title>
    <link href="../../../css/estilos.css" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="nav_user">
            <a href="/index.php"><img src="/img/logo.png" alt="logo"></a>  
            <a href="presupuesto.php">Regresar</a>
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
                <form action="editar_pre.php" method="POST"> 
                    <input type="hidden" name="id" value="<?php echo $dato;?>" >
                    <div >
                        <label for="" >1. Numero de Sucursal</label>                        
                        <div >
                            <input type="text" name="sucursal" value="<?php echo $result->sucursal; ?>" disabled>                               
                                <?php
                                if(isset($_POST['sucursal'])){                                     
                                    if(empty($sucursal)){
                                        echo ('<h4 class="validacion">El campo de Sucursal no puede estar vacio</h4>');
                                        $error = 1;                                               
                                    }
                                    echo $sucursal;                                    
                                }                                
                                ?>
                        </div> <br>          
                    </div>                     

                    <div >
                        <label for="" >2. Mes</label>                        
                        <div >                        
                            <select name="mes" id="">
                                <option value="1" <?php if($mes == 1){?> selected="true" <?php }?> disabled>ENERO</option>
                                <option value="2" <?php if($mes == 2){?> selected="true" <?php }?> disabled>FEBRERO</option>
                                <option value="3" <?php if($mes == 3){?> selected="true" <?php }?> disabled>MARZO</option>
                                <option value="4" <?php if($mes == 4){?> selected="true" <?php }?> disabled>ABRIL</option>
                                <option value="5" <?php if($mes == 5){?> selected="true" <?php }?> disabled>MAYO</option>
                                <option value="6" <?php if($mes == 6){?> selected="true" <?php }?> disabled>JUNIO</option>
                                <option value="7" <?php if($mes == 7){?> selected="true" <?php }?> disabled>JULIO</option>
                                <option value="8" <?php if($mes == 8){?> selected="true" <?php }?> disabled>AGOSTO</option>
                                <option value="9" <?php if($mes == 9){?> selected="true" <?php }?> disabled>SEPTIEMBRE</option>
                                <option value="10" <?php if($mes == 10){?> selected="true" <?php }?> disabled>OCTUBRE</option>
                                <option value="11" <?php if($mes == 11){?> selected="true" <?php }?> disabled>NOVIEMBRE</option>
                                <option value="12" <?php if($mes == 12){?> selected="true" <?php }?> disabled>DICIEMBRE</option>
                            </select>
                                <?php       
                                if(isset($_POST['mes'])){                                        
                                    if(empty($mes)){
                                        echo ('<h4 class="validacion">El campo de Mes no puede estar vacio</h4>');
                                        $error = 1;                                               
                                    }
                                }
                                echo $mes;
                                ?>
                        </div><br>
                    </div>

                    <div >
                        <label for="" >3. Año</label>                        
                        <div >                        
                            <select name="año" id="">
                                <option value="2022" <?php if ($año == 2022){?> selected="true" <?php }?> disabled>2022</option>
                                <option value="2023" <?php if ($año == 2023){?> selected="true" <?php }?> disabled>2023</option>
                                <option value="2024" <?php if ($año == 2024){?> selected="true" <?php }?> disabled>2024</option>
                                <option value="2025" <?php if ($año == 2025){?> selected="true" <?php }?> disabled>2025</option>                                
                            </select>
                                <?php       
                                if(isset($_POST['año'])){                                        
                                    if(empty($año)){
                                        echo ('<h4 class="validacion">El campo de Año no puede estar vacio</h4>');
                                        $error = 1;                                               
                                    }
                                }
                                echo $año;
                                ?>
                        </div>  <br>        
                    </div>  

                    <div>                        
                        <label for="">4. Presupuesto</label>                          
                                <input type="text" name="presupuesto" placeholder="$ 00.00">
                                <?php
                                if(isset($_POST['presupuesto'])){
                                    $presupuesto = $_POST['presupuesto'];
                                    $sucursal = $_POST['sucursal'];
                                    $mes = $_POST['mes'];
                                    $año = $_POST['año'];    
                                    $dato = $_POST['id'];                                 
                                    $error = 0;
                                    if(empty($presupuesto)){
                                        echo ('<h4 class="validacion">El campo de Presupuesto no puede estar vacío</h4>');
                                        $error = 1;                                               
                                    }elseif(!preg_match("/^[0-9.]{1,9}+$/",$presupuesto)){
                                        echo ('<h4 class="validacion">El campo de "presupuesto" solo puede contener numeros y decimales y debe tener como mínimo un digito</h4>');
                                        $error = 1;
                                    }elseif($error==0){                                        
                                        try {
                                            $sql=$conn->prepare('Update presupuesto set presupuesto = ? where idpresupuesto = ?');
                                            $result=$sql->execute([$presupuesto, $dato]);                                 
                                            if($result==true){?>
                                                <div class="container-modal">
                                                    <div class="content-modal">
                                                        <div class="content-body">
                                                            <?php 
                                                            echo"<h2>¡Presupuesto Editado!</h>"; 
                                                            ?>
                                                        </div>
                                                        <div class="btn-cerrar">                                                      
                                                            <a href="presupuesto.php">
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
                                ?>
                            </div> <br><br>           
                    </div>          

                    <div class="boton_formulario">
                        <button  class="boton_login" for="btn-modal1" type="submit">Registrar</button><br><br>         
                        <a href="presupuesto.php"><img class="modal-pic1" src="/img/flecha.png" title="Regresar" alt="regresar"></a>                           
                    </div>            
                </form>
            </div>
        </div>
    </div>
</body>
</html>