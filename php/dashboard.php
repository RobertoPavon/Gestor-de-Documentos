<?php
// session_start();
include_once '../../conexion.php';
$nombre = $_SESSION['usuario'];
$id = $_SESSION['id'];
$tipo =$_SESSION['tipo'];
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
    <title>Document</title>
</head>
<body>
    <div class="dashboard">
        <div class="top_content">
            <div class="card">                
                <div class="box">
                    <?php
                        $sql=$conn->prepare('Select COUNT(id) from usuarios where estatus = 1');                    
                        $sql->execute();
                        $total= $sql->fetchColumn();                    
                    ?>
                <h1><?php echo $total;?> </h1>
                <h2>USUARIOS</h2>
                </div>
                <div class="icono">
                    <img src="/img/usuario1.png" alt="">
                </div>                
            </div>
            <div class="card"> 
                <div class="box">
                    <?php
                    $sql=$conn->query('Select COUNT(numero) from sucursales where estatus = 1');                    
                    $sql->execute();
                    $total= $sql->fetchColumn();
                    ?>
                    <h1><?php echo $total;?></h1>
                    <h2>SUCURSALES</h2>
                </div>                 
                <div class="icono">
                    <img src="/img/tienda.png" alt="">
                </div>                
            </div>
            <div class="card">                
                <div class="box">
                    <?php
                    $sql=$conn->query('Select COUNT(DISTINCT PLAZA) from sucursales where estatus = 1');                    
                    $sql->execute();
                    $total= $sql->fetchColumn();
                    ?>
                    <h1><?php echo $total;?></h1>
                    <h2>PLAZAS</h2>
                </div>
                <div class="icono">
                    <img src="/img/ruta2.png" alt="">
                </div>                
            </div>
        </div><br><br>

        <div class="body_content">
            <div class="big_card">
                <iframe src="../../../graficas/graph_month.php" widht=400" height="490" ></iframe>             
            </div>
            <div class="big_card">
                <iframe src="../../../graficas/graph_year.php" widht=400" height="490" ></iframe>           
            </div>
        </div>
    </div>
    
</body>
</html>