<?php
session_start();
include_once '../conexion.php';
$nombre = $_SESSION['usuario'];
$id= $_SESSION['id'];
$tipo = $_SESSION['tipo'];
if(!isset($_SESSION['usuario'])){
    header('Location: ../login.php');
}
$
 = strtolower($_REQUEST['busqueda']);
if(empty($busqueda)){
    header('Location: facturas.php');
}
$tp=$tipo;
if($tp == 1){
    $tp = "ADMINISTRADOR";
}if($tp == 2){
    $tp = "ANALISTA";
}if($tp == 3){
    $tp = "SUCURSAL";
}

if($tipo != '3'){
    // $sql=$conn->query('Select * from facturas');     
    $sql=$conn->query("select facturas.sucursal, sucursales.nombre as nomSuc, facturas.factura, proveedor.nombre, facturas.recepcion, 
    facturas.carga, facturas.documento from facturas INNER JOIN  proveedor 
    on facturas.proveedor = proveedor.idproveedor
    INNER JOIN sucursales on facturas.sucursal = sucursales.numero where
    (facturas.sucursal like '%$busqueda%' or
    sucursales.nombre like '%$busqueda%' or
    facturas.factura like '%$busqueda%' or
    proveedor.nombre like '%$busqueda%' or
    facturas.recepcion like '%$busqueda%' or
    facturas.carga like '%$busqueda%')");                      
    $result=$sql->fetchAll();
}elseif($tipo === '3'){  
    $numero = $_SESSION['numero'];
    // $sql=$conn->query("Select * from facturas where sucursal = $numero");       
    $sql=$conn->query("select facturas.sucursal, sucursales.nombre as nomSuc, facturas.factura, proveedor.nombre, facturas.recepcion, 
    facturas.carga from facturas INNER JOIN  proveedor 
    on facturas.proveedor = proveedor.idproveedor 
    INNER JOIN sucursales on facturas.sucursal = sucursales.numero where 
    (facturas.sucursal like '%$busqueda%' or
    sucursales.nombre like '%$busqueda%' or
    facturas.factura like '%$busqueda%' or
    proveedor.nombre like '%$busqueda%' or
    facturas.recepcion like '%$busqueda%' or
    facturas.carga like '%$busqueda%') 
    and sucursal = '$numero'");  
        
print_r($conn->errorInfo()); 
$arr = $sql->errorInfo();   
print_r($arr); 
    $result=$sql->fetchAll(); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturas</title>
    <link href="../../css/estilos.css" rel="stylesheet">
</head>
<body>

    <nav>
        <div class="nav_user">
            <a href="/index.php"><img src="/img/logo.png" alt="logo"></a>  
            <a href=""><?php echo $tp ?></a>
                <ul class="horizontal">
                    <li>
                        <a class="div_login" href="">
                            <img class="login" src="/img/login.png" alt="">
                                <?php echo "&nbsp $nombre"?>
                                    <ul class="vertical">
                                        <li>
                                            <a href="../logout.php">Salir</a>
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
                        <li><a href="../panel.php"><img src="/img/panel.png" alt="">&nbsp Menú</a></li>
                        <?php
                            if($tipo === '1'){     
                        ?>
                        <li><a href="administrador/usuarios.php"><img src="/img/usuario.png" alt="">&nbsp Usuarios</a></li>                        
                        <?php
                            }
                        ?>
                        <li><a href="administrador/sucursales.php"><img src="/img/store.png" alt="">&nbsp Sucursales</a></li>
                        <li><a href="facturas.php"><img src="/img/factura.png" alt="">&nbsp Facturas</a></li>
                        <li><a href="recibos.php"><img src="/img/dinero.png" alt="">&nbsp Recibos</a></li>                        
                        <li><a href="administrador/proveedores.php"><img src="/img/repartidor.png" alt="">&nbsp Proveedores</a></li>  
                        <?php
                            if($tipo != '3'){                  
                        ?>
                        <li><a href="administrador/presupuesto.php"><img src="/img/presupuesto.png" alt="">&nbsp Presupuesto</a></li>
                        <?php
                            }                 
                        if($tipo == '3'){                  
                        ?>
                        <li><a href="sucursal/venta.php"><img src="/img/venta.png" alt="">&nbsp Venta</a></li>
                        <?php
                            }                 
                        ?>                                              
                    </ul>                
                </div>                                       
            </aside>            
        </div>

        <div class="contents">
            <div><br>
                <h1>Consulta de Facturas</h1>
            </div><br>
            <div class="buscador">
                <form action="buscar_facturas.php" method="get">
                        <input type="text" name="busqueda" placeholder="Busqueda" value="<?php echo $busqueda;?>">
                        <button type="submit">Buscar</button>
                </form>
            </div><br>

            <?php
                if($tipo === '3'){     
            ?>
                <button class="nuevo"><a href="sucursal/cargar_fac.php">+ Cargar Factura</a></button><br><br>
            <?php
            }
            ?>

            <div class="tabla">
                <table>
                    <thead>
                        <tr>
                            <td class="celda"># de Suc.</td">
                            <td class="celda_grande">Nombre</td">
                            <td class="celda_grande"># de Factura</td">
                            <td class="celda_grande">Proveedor</td">
                            <td class="celda_grande">Fecha de Recepción</td">
                            <td class="celda_grande">Fecha de Carga</td">
                            <td class="celda">Documento</td">
                            <?php
                            if($tipo != '3' ){                                
                            ?>  
                                <td class="celda">Acciones</td">
                            <?php
                                }
                            ?>                            
                        </tr>
                    </thead>     
                    <tr>
                        <?php
                            foreach($result as $celda){
                        ?>
                            <td class="celda"><?php print_r($celda['sucursal'])?></td">
                            <td class="celda_grande"><?php print_r($celda['nomSuc'])?></td">
                            <td class="celda_grande"><?php print_r($celda['factura'])?></td">
                            <td class="celda_grande"><?php print_r($celda['nombre'])?></td">
                            <td class="celda_grande"><?php print_r($celda['recepcion'])?></td">
                            <td class="celda_grande"><?php print_r($celda['carga'])?></td">
                            <td class="celda"><a href="/files/facturas/<?php print_r($celda['documento'])?>">
                            <img class="login" src="/img/archivo.png" title="VISTA PREVIA" alt="vista previa"></a></td">
                            
                        <?php
                            if($tipo != '3'){
                                $archivo= $celda['documento'];
                        ?>
                                <td class="celda">
                                <?php
                                ?>
                                    <a download href="/files/facturas/<?php echo $archivo?>">
                                        <img class="login" src="/img/descarga2.png" title="DESCARGAR" alt="descargar">
                                    </a>   
                                </td">
                        <?php
                            }
                        ?>
                    </tr>
                    <?php
                        } 
                    ?>        
                </table> 
            </div>
        </div>
    </div>

</body>
</html>