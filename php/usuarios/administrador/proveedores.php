<?php
session_start();
include_once '../../conexion.php';
$nombre = $_SESSION['usuario'];
$id= $_SESSION['id'];
$tipo = $_SESSION['tipo'];
if(!isset($_SESSION['usuario'])){
    header('Location: ../../login.php');
}
$sql=$conn->query('Select * from proveedor where estatus = 1');                    
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
    <title>Proveedores</title> 
    <link href="../../../css/estilos.css" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="nav_user">
            <a href="/index.php"><img src="/img/logo.png" alt="logo"></a>  
            <a href=""> <?php echo "&nbsp $tp"?></a>
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
                        <li><a href="presupuesto.php"><img src="/img/presupuesto.png" alt="">&nbsp Presupuesto</a></li>
                        <?php
                            }                  
                        ?>
                        <?php
                            if($tipo == '3'){     
                        ?>
                        <li><a href="../sucursal/venta.php"><img src="/img/venta.png" alt="">&nbsp Venta</a></li>
                        <?php
                            }                  
                        ?>
                    </ul>                
                </div>   
                                    
            </aside>            
        </div>

        <div class="contents">
          
            <div><br>
                <h1>Consulta de Proveedores</h1>
            </div><br>
            <div class="buscador">
                <form action="buscar_proveedores.php" method="get">
                        <input type="text" name="busqueda" placeholder="Busqueda">
                        <button type="submit">Buscar</button>
                </form>
            </div><br>
            
            <?php
                if($tipo == '1'){                  
            ?>  
            <button class="nuevo"><a href="crear_pro.php">+ Nuevo Proveedor</a></button><br><br>
            <?php
            }                 
                ?> 
            <div class="tabla">
                <table>
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Nombre</td>
                            <td>RFC</td>
                            <td>Teléfono</td>
                            <?php
                                if($tipo == '1'){                  
                            ?>   
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
                            <td><?php print_r($celda['idproveedor'])?></td>
                            <td><?php print_r($celda['nombre'])?></td>
                            <td><?php print_r($celda['rfc'])?></td>
                            <td><?php print_r($celda['telefono'])?></td>
                            <?php
                                if($tipo == '1'){                  
                            ?>   
                                    <td>
                                        <a href="editar_pro.php?idproveedor=<?php echo $celda['idproveedor']?>">
                                        <img src="/img/editar.png" title="Editar" alt="editar"></a>&nbsp &nbsp
                                        <a href="eliminar_pro.php?idproveedor=<?php echo $celda['idproveedor']?>">
                                        <img src="/img/eliminar.png" title="Eliminar" alt="eliminar"></a>                    
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