<?php
session_start();
$nombre = $_SESSION['usuario'];
$id = $_SESSION['id'];
$tipo =$_SESSION['tipo'];
if(!isset($_SESSION['usuario'])){
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
    <title>Administrador</title>
    <link href="../../../css/estilos.css" rel="stylesheet">

</head>
<body>    
    <nav>
        <div class="nav_user">
            <a href="/index.php"><img src="/img/logo.png" alt="logo"></a>  
            <a href="">ADMINISTRADOR</a>
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

    <div class="main-user">
        <div class="user">
            <aside>
                <div>
                    <h1 class="panel">PANEL</h1>
                </div>
                
                <div>
                    <ul>
                    <li><a href="../../panel.php"><img src="/img/panel.png" alt="">&nbsp Menú</a></li>
                        <li><a href="usuarios.php"><img src="/img/usuario.png" alt="">&nbsp Usuarios</a></li>
                        <li><a href="sucursales.php"><img src="/img/store.png" alt="">&nbsp Sucursales</a></li>
                        <li><a href="../facturas.php"><img src="/img/factura.png" alt="">&nbsp Facturas</a></li>
                        <li><a href="../recibos.php"><img src="/img/dinero.png" alt="">&nbsp Recibos</a></li>
                        <li><a href="proveedores.php"><img src="/img/repartidor.png" alt="">&nbsp Proveedores</a></li>
                        <li><a href="presupuesto.php"><img src="/img/presupuesto.png" alt="">&nbsp Presupuesto</a></li>
                    </ul>                
                </div>                       
            </aside>            
        </div>

        <div class="contents">
            <?php
            include '../../dashboard.php';
            ?>   
        </div>
    </div>
</body>
</html>
