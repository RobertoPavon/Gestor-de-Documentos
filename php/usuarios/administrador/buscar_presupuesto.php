<?php
error_reporting(0);
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
    header('Location: presupuesto.php');
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
date_default_timezone_set('America/Mexico_City');
if (isset($_POST['año'])){
    $año = $_POST['año'];
    }
else{
    $año= date("Y");
}
if (isset($_POST['mes'])){
    $mes = $_POST['mes'];
    }
else{
    $mes = date("m");
}
$sql=$conn->prepare("select presupuesto.idpresupuesto, sucursales.plaza, sucursales.nombre, presupuesto.presupuesto, mes.nombre as mes from sucursales 
    inner join presupuesto on sucursales.numero = presupuesto.sucursal
    inner join mes  on mes.idmes = presupuesto.mes where 
    (sucursales.plaza like '%$busqueda%' or
    sucursales.nombre like '%$busqueda%' or
    presupuesto.presupuesto like '%$busqueda%') 
    and presupuesto.mes =  ?");  
$sql->execute([$mes]);          
$result=$sql->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presupuesto</title> 
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
            <?php
                echo ('<h1>Presupuestos '.$año.'</h1>');                 
            ?> 
            </div><br>

            <div class="buscador">
                <form action="buscar_presupuesto.php" method="get">
                        <input type="text" name="busqueda" placeholder="Busqueda" value="<?php echo $busqueda;?>">
                        <button type="submit">Buscar</button>
                </form>
            </div><br>

            <div class="top_presupuesto">
                <div class="botones_presupuesto">
                    <button class="nuevo"><a href="crear_pre.php">+ Asignar Presupuesto</a></button><br>              
                </div>

                <div class="form_presupuesto">
                    <form class="formulario_presupuesto" action="presupuesto.php" method="post">
                
                        <div>
                            <label for="">MES</label> 
                        </div> 
                        <div><select class="presupuesto_select" name="mes" id="">
                                <option value="1" <?php if ($mes == 1){?> selected="true" <?php }?>>ENERO</option>
                                <option value="2" <?php if ($mes == 2){?> selected="true" <?php }?>>FEBRERO</option>
                                <option value="3" <?php if ($mes == 3){?> selected="true" <?php }?>>MARZO</option>
                                <option value="4" <?php if ($mes == 4){?> selected="true" <?php }?>>ABRIL</option>
                                <option value="5" <?php if ($mes == 5){?> selected="true" <?php }?>>MAYO</option>
                                <option value="6" <?php if ($mes == 6){?> selected="true" <?php }?>>JUNIO</option>
                                <option value="7" <?php if ($mes == 7){?> selected="true" <?php }?>>JULIO</option>
                                <option value="8" <?php if ($mes == 8){?> selected="true" <?php }?>>AGOSTO</option>
                                <option value="9" <?php if ($mes == 9){?> selected="true" <?php }?>>SEPTIEMBRE</option>
                                <option value="10" <?php if ($mes == 10){?> selected="true" <?php }?>>OCTUBRE</option>
                                <option value="11" <?php if ($mes == 11){?> selected="true" <?php }?>>NOVIEMBRE</option>
                                <option value="12" <?php if ($mes == 12){?> selected="true" <?php }?>>DICIEMBRE</option>
                            </select>                        

                            <?php 
                            if($_POST['mes']){
                                $mes = $_POST['mes'];
                            }
                            ?> 
                        </div> 
                            
                        &nbsp &nbsp 
                        <div>
                            <label for="">AÑO</label> 
                        </div>
                        <div>
                        <select class="presupuesto_select name="año" id="">
                                <option value="2022" <?php if ($año == 2022){?> selected="true" <?php }?>>2022</option>
                                <option value="2023" <?php if ($año == 2023){?> selected="true" <?php }?>>2023</option>
                                <option value="2024" <?php if ($año == 2024){?> selected="true" <?php }?>>2024</option>
                            </select>                        

                            <?php 
                            if($_POST['año']){
                                $año = $_POST['año'];
                            }
                            ?>
                        </div>
                            &nbsp 
                            
                        <div>
                            <button type="submit">Buscar</button>
                        </div>
                    </form>
                </div>
            </div><br>

            
            <div class="tabla">
                <table>
                    <thead>
                        <tr>
                            <td hidden>ID</td>
                            <td>Plaza</td>
                            <td>Sucursal</td>
                            <td>Presupuesto</td>  
                            <td>Acciones</td>
                        </tr>
                    </thead>     
                        <tr>
                            <?php
                                foreach($result as $celda){
                            ?>
                            <td hidden><?php print_r($celda['idpresupuesto'])?></td>
                            <td><?php print_r($celda['plaza'])?></td>
                            <td><?php print_r($celda['nombre'])?></td>
                            <td><?php echo ('$'.number_format(($celda['presupuesto'])))?></td>                            
                            <td>
                                <a href="editar_pre.php?idpresupuesto=<?php echo $celda['idpresupuesto']?>">
                                 <img src="/img/editar.png" title="Editar" alt="editar"></a>                                          
                            </td>       
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