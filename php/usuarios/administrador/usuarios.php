<?php
session_start();
include_once '../../conexion.php';
$nombre = $_SESSION['usuario'];
$id= $_SESSION['id'];
$tipo = $_SESSION['tipo'];
if(!isset($_SESSION['usuario'])){
    header('Location: ../../login.php');
}
if($tipo != 1){
    session_destroy();
    header('Location: ../../login.php');
}
// $sql=$conn->query('Select * from usuarios where estatus = 1');       
$sql=$conn->query('select usuarios.id, usuarios.nombre, usuarios.password, tipousuarios.tipo from usuarios INNER JOIN  tipousuarios 
on usuarios.tipo = tipousuarios.id where usuarios.estatus = 1');               
$result=$sql->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
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
            <div>
                <br><h1>Consulta de Usuarios</h1>
            </div><br>
            
            <div class="buscador">
                <form action="buscar_usuarios.php" method="get">
                        <input type="text" name="busqueda" placeholder="Busqueda">
                        <button type="submit">Buscar</button>
                </form>
            </div><br>
            
            <button class="nuevo"><a href="crear.php">+ Nuevo Usuario</a></button><br><br>
    
            <div class="tabla">
                <table>
                    <thead>
                        <tr>
                           <td class="celda">ID</td>
                            <td>NOMBRE</td>
                            <td>CONTRASEÑA</td>
                            <td>TIPO</td>
                            <td>ACCIONES</td>
                        </tr>
                    </thead>  
                        <tr>
                            <?php
                                foreach($result as $celda){
                            ?>
                                <td class="celda"><?php print_r($celda['id'])?></td>
                                <td><?php print_r($celda['nombre'])?></td>
                                <td><?php print_r($celda['password'])?></td>
                                <td><?php print_r($celda['tipo'])?></td>
                                <td>
                                    <a href="editar.php?id=<?php echo $celda['id']?>"><img src="/img/editar.png" title="Editar" alt="editar"></a>&nbsp &nbsp
                                    <a href="eliminar.php?id=<?php echo $celda['id']?>"><img src="/img/eliminar.png" title="Eliminar" alt="eliminar"></a>                    
                                </td>
                        </tr>
                            <?php
                                } 
                            ?>        
                </table><br> 
            </div>     
        </div>        
    </div>
</body>
</html>