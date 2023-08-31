<?php
session_start();
include_once '../../conexion.php';
$nombre = $_SESSION['usuario'];
$id= $_SESSION['id'];
$tipo = $_SESSION['tipo'];
if(!isset($_SESSION['usuario'])){
    header('Location: ../../login.php');
}
$busqueda = strtolower($_REQUEST['busqueda']);
if(empty($busqueda)){
    header('Location: sucursales.php');
}elseif(!preg_match("/^[a-zA-Z-0-9\s]{5,50}+$/",$busqueda)){
    header('Location: sucursales.php');
}

$sql=$conn->query("Select * from sucursales where 
(plaza like '%$busqueda%' or
numero like '%$busqueda%' or
nombre like '%$busqueda%' or
direccion like '%$busqueda%' or
telefono like '%$busqueda%' or
red like '%$busqueda%' or
correo like '%$busqueda%' or
idusuario like '%$busqueda%') 
and estatus = 1");     
// print_r($conn->errorInfo()); 
// $arr = $sql->errorInfo();   
// print_r($arr);              
$result=$sql->fetchAll();
$tp=$tipo;
if($tp == 1){
    $tp = "ADMINISTRADOR";
}if($tp == 2){
    $tp = "ANALISTA";
}if($tp == 3){
    $tp = "SUCURSAL";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sucursales</title>
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
                        <?php
                            if($tipo == '1'){                  
                        ?>
                        <li><a href="usuarios.php"><img src="/img/usuario.png" alt="">&nbsp Usuarios</a></li>
                        <?php
                            }                 
                        ?>
                        <li><a href="sucursales.php"><img src="/img/store.png" alt="">&nbsp Sucursales</a></li>
                        <li><a href="../facturas.php"><img src="/img/factura.png" alt="">&nbsp Facturas</a></li>
                        <li><a href="../recibos.php"><img src="/img/dinero.png" alt="">&nbsp Recibos</a></li>                        
                        <li><a href="proveedores.php"><img src="/img/repartidor.png" alt="">&nbsp Proveedores</a></li>
                        <?php
                            if($tipo != '3'){                  
                        ?>
                        <li><a href="prespupuesto.php"><img src="/img/presupuesto.png" alt="">&nbsp Presupuesto</a></li>
                        <?php
                            }                 
                        ?>

                        


                        <?php
                            if($tipo === '3'){                  
                        ?>
                        <li><a href="../sucursal/venta.php"><img src="/img/presupuesto.png" alt="">&nbsp Venta</a></li>
                        <?php
                            }                
                        ?>
                    </ul>                
                </div>   
                                    
            </aside>            
        </div>

        <div class="contents">        
            <div><br>
                <h1>Consulta de Sucursales</h1><br>

                <div class="buscador">
                <form action="buscar_sucursales.php" method="get">
                        <input type="text" name="busqueda" placeholder="Busqueda" value="<?php echo $busqueda;?>">

                        <button type="submit">Buscar</button>
                </form>
                </div>
            
            </div><br>
            <?php
            if($tipo === '1'){                  
            ?>
            <button class="nuevo"><a href="crear_suc.php">+ Nueva Sucursal</a></button><br><br>
            <?php
            }                 
            ?>
            <div class="tabla">
                <table>
                    <thead>
                    <tr>
                        <td class="celda">Plaza</td>    
                        <td class="celda">Numero</td>
                        <td>Nombre</td>
                        <td>Dirección</td>
                        <td>Telefono</td>
                        <td class="celda">RED</td>
                        <td>Correo</td>
                        <?php
                            if($tipo === '1'){                  
                        ?>
                        <td class="celda">ID</td>
                        <td>Acciones</td>
                        <?php
                            }                  
                        ?>
                    </tr>
                    </thead>     
                        
                    <tr>
                        <?php
                            foreach($result as $celda){
                        ?>
                        <td class="celda"><?php print_r($celda['plaza'])?></td>
                        <td class="celda"><?php print_r($celda['numero'])?></td>
                        <td><?php print_r($celda['nombre'])?></td>
                        <td><?php print_r($celda['direccion'])?></td>
                        <td><?php print_r($celda['telefono'])?></td>
                        <td class="celda"><?php print_r($celda['red'])?></td>
                        <td><?php print_r($celda['correo'])?></td>
                        <?php
                            if($tipo === '1'){                  
                        ?>
                        <td class="celda"><?php print_r($celda['idusuario'])?></td>
                        <td>
                            <a href="editar_suc.php?numero=<?php echo $celda['numero']?>"><img src="/img/editar.png" title="Editar" alt="editar"></a>&nbsp &nbsp
                            <a href="eliminar_suc.php?numero=<?php echo $celda['numero']?>"><img src="/img/eliminar.png" title="Eliminar" alt="eliminar"></a>                    
                        </td>
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