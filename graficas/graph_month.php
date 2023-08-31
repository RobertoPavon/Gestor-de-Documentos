<?php
error_reporting(0);
session_start();
include_once '../php/conexion.php';
$nombre = $_SESSION['usuario'];
$id= $_SESSION['id'];
$tipo = $_SESSION['tipo'];
// $numero = $_SESSION['numero'];
if(!isset($_SESSION['usuario'])){
    header('Location: ../../login.php');
}
date_default_timezone_set('America/Mexico_City');
$fcha= date("m");
if (isset($_POST['mes'])){
    $mes = $_POST['mes'];
    }
else{
    $mes = date("m");
}
$año = date("Y");
$sql=$conn->prepare('Select nombre from mes where idmes = ?');  
$sql->execute([$fcha]);          
$result=$sql->fetchAll();
foreach($result as $data){
    $fcha = $data['nombre'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graficas</title>
    <link rel="stylesheet" href="/css/estilos.css">
</head>
<body class="grafica">    
    <br>
       <form class="formulario_grafica" action="graph_month.php" method="post">
            
            <label for="">MES</label>   
            <select name="mes" id="">
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
                        $sql=$conn->prepare('Select nombre from mes where idmes = ?');  
                        $sql->execute([$mes]);          
                        $result=$sql->fetchAll();
                        foreach($result as $data){
                            $fcha = $data['nombre'];
                        }
                    }
                    $sql=$conn->prepare('select t1.sucursal, t1.nombre, t1.VentaTotal AS "Venta Total", t1.presupuesto AS "Presupuesto", 
                        (t1.VentaTotal/t1.presupuesto)*100 As Cobertura, t1.mes from
                            (select presupuesto.sucursal, sucursales.nombre, SUM(venta_diaria.venta) AS VentaTotal, presupuesto.presupuesto, presupuesto.mes from presupuesto  
                                INNER JOIN venta_diaria ON presupuesto.sucursal = venta_diaria.sucursal 
                                    inner join sucursales on presupuesto.sucursal = sucursales.numero 
                                        where presupuesto.mes = ? and venta_diaria.mes = ? group by sucursal, mes) AS t1');
                                        // print_r($conn->errorInfo());           
                    $sql->execute([$mes, $mes]);    
                    $result=$sql->fetchAll();
                    foreach($result as $data){
                        $nom[] = $data['nombre'];
                        $sucursal[] = $data['sucursal'];
                        $total[] = $data['Cobertura'];
            }
                    ?>
                 <button type="submit">Buscar</button>
       </form>
    <br>
    <div class="grafica">
        <h1>Presupuesto Mensual</h1>
        <?php echo ('<h3>'.$fcha." ".$año.'</h3><br>');?>
        <a href="graph_month.php" target="_blank"><canvas id="myChart" width="400" height="280"></canvas></a>
    </div>
        
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const names = <?php echo json_encode($nom) ?>;
        const ages = <?php echo json_encode($total) ?>;

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: names,
                datasets: [{
                    label: '% de Cobertura',
                    data: ages,
                    backgroundColor:[                        
                        'rgba(20, 118, 132, 0.8)',
                        'rgba(237, 221, 237, 0.8)',
                        'rgba(209, 227, 196, 0.8)',
                        'rgba(46, 250, 145, 0.8)',
                        'rgba(255, 193, 24, 0.8)',
                        'rgba(242, 85, 124, 0.8)',
                        'rgba(106, 120, 209, 0.8)',  
                        'rgba(121, 206, 220, 0.8)',                      
                        'rgba(250, 114, 46, 0.8)',
                        'rgba(255, 107, 238, 0.8)',                      
                    ],
                    borderColor:[                        
                        'rgba(18, 99, 112, 1)',
                        'rgba(236, 183, 236, 1)',
                        'rgba(186, 223, 159, 1)',
                        'rgba(27, 195, 108, 1)',
                        'rgba(255, 193, 24, 1)',
                        'rgba(240, 50, 97, 1)',
                        'rgba(73, 91, 208, 1)',
                        'rgba(75, 203, 223, 1)',
                        'rgba(246, 99, 26, 1)',
                        'rgba(218, 63, 200, 1)'  
                    ],
                    borderWidth: 1.5,
                    indexAxis: 'y'
                }]
            } 
        })
    </script>
</body>
</html>