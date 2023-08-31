<?php
session_start();
include_once '../../conexion.php';
$nombre = $_SESSION['usuario'];
$id= $_SESSION['id'];
$tipo = $_SESSION['tipo'];
$numero = $_SESSION['numero'];
$tp=$tipo;
if($tp == 3){
    $tp = "SUCURSAL";
}
if(!isset($_SESSION['usuario'])){
    header('Location: ../../login.php');
}
if($tipo != 3){
    session_destroy();
    header('Location: ../../login.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venta</title>
    <link href="../../../css/estilos.css" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="nav_user">
            <a href="/index.php"><img src="/img/logo.png" alt="logo"></a>  
            <a href=""><?php echo "&nbsp $tp"?></a>
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
                        <li><a href="../administrador/sucursales.php"><img src="/img/store.png" alt="">&nbsp Sucursales</a></li>
                        <li><a href="../facturas.php"><img src="/img/factura.png" alt="">&nbsp Facturas</a></li>
                        <li><a href="../recibos.php"><img src="/img/dinero.png" alt="">&nbsp Recibos</a></li>
                        <li><a href="../administrador/proveedores.php"><img src="/img/repartidor.png" alt="">&nbsp Proveedores</a></li>
                        <li><a href="venta.php"><img src="/img/venta.png" alt="">&nbsp Venta</a></li>
                    </ul>                
                </div>   
                                    
            </aside>            
        </div>
       
        <div class="venta">             
            <div class="top_content" id="top_content_venta">
                <div class="card_medium">
                    <div class="venta_botones">  
                        <a class="boton_login" href="registroventa.php">&nbsp &nbsp &nbsp &nbsp  Registrar Nueva Venta &nbsp &nbsp &nbsp &nbsp &nbsp</a><br><br><br>
                        <a class="boton_login" href="editarventa.php">&nbsp &nbsp &nbsp &nbsp &nbsp Editar Venta del Día &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</a><br><br><br>
                        <a class="boton_login" href="dias_laborales.php">&nbsp &nbsp &nbsp &nbsp Dias Laborales del Mes &nbsp &nbsp &nbsp &nbsp</a><br><br><br>
                        <a class="boton_login" href="editar_dias.php">&nbsp Editar Dias Laborales del Mes &nbsp</a>
                    </div>
                </div>

                <div class="card_medium">
                    <iframe class="grafica_dia" src="../../../../../graficas/graph_day.php" widht="350" height="240" ></iframe>                    
                </div>                
            </div>

            <div class="body_content">
                <div class="card_xl">
                    <iframe src="../../../../../graficas/graph_closure.php" widht="400" height="380" ></iframe> 
                </div>

                <div class="card_xl">
                    <iframe src="../../../../../graficas/graph_year.php" widht="400" height="380" ></iframe>                   
                </div>
            </div>
        </div>
    </div>

</body>
</html>