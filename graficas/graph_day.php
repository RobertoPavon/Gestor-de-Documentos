<?php
error_reporting(0);
session_start();
include_once '../php/conexion.php';
$nombre = $_SESSION['usuario'];
$id= $_SESSION['id'];
$tipo = $_SESSION['tipo'];
$numero = $_SESSION['numero'];
if(!isset($_SESSION['usuario'])){
    header('Location: ../../login.php');
}
date_default_timezone_set('America/Mexico_City');
$mes = date('m');
$año = date("Y");
$fcha = date('Y-m-d');
// $fcha = "2022-10-15";

        
$sql=$conn->prepare('select t7.MetaVentaDiaria, (t7.VDD / t7.MetaVentaDiaria) * 100 AS cubierto,(1 - (t7.VDD / t7.MetaVentaDiaria)) * 100 AS faltante from 
    (SELECT t6.VD AS VDD, (t6.MetaVentaRestante / t6.DiasRestantes) AS MetaVentaDiaria FROM 
    (SELECT t5.venta as VD, (t2.dias - t1.VentaCerrada) AS DiasRestantes, (t3.presupuesto - t4.VentaTotal) AS MetaVentaRestante FROM 
    (SELECT count(venta) AS VentaCerrada FROM venta_diaria WHERE sucursal = ? AND mes = ? AND estatus = 0) AS t1, 
    (SELECT dias FROM dvm WHERE sucursal = ? AND mes = ?) AS t2, 
    (SELECT presupuesto FROM presupuesto WHERE sucursal = ? AND mes = ?) AS t3,
    (SELECT SUM(venta) AS VentaTotal FROM venta_diaria WHERE sucursal = ? AND mes = ? AND estatus = 0) AS t4, 
    (SELECT venta FROM venta_diaria WHERE sucursal = ? AND date(fecha) = ?) AS t5) AS t6) AS t7;');
$sql->execute([$numero, $mes, $numero, $mes, $numero, $mes, $numero, $mes, $numero, $fcha]);  
$result=$sql->fetchAll();
foreach($result as $data){
    $meta = $data['MetaVentaDiaria'];
    $cubierto = $data['cubierto'];
    $faltante = $data['faltante'];
}
$meta_format = number_format($meta, 1, '.', ',');
$nuevo = ('$'.$meta_format);

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
<body class="grafica_dia">    
        <h3>Meta de Venta Diaria</h3>
        <?php echo ('<h3>'.$nuevo.'</h3><br>'); ?>
        <a href="graph_day.php" target="_blank"><canvas id="myChart" width="350" height="250"></canvas></a>
        
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const name = ['% Cubierto', '% Faltante'];
        const covertura = [<?php echo json_encode($cubierto)?>, <?php echo json_encode($faltante)?>];

        const myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: name,
                datasets: [{
                    label: '% de Cobertura',
                    data: covertura,
                    backgroundColor:[
                        'rgba(67, 209, 161, 0.8)',
                        // 'rgba(255, 193, 24, 0.8)',
                        // 'rgba(255, 53, 53, 0.8)'
                        // 'rgba(121, 206, 220, 0.8)',
                        // 'rgba(250, 114, 46, 0.8)',
                        'rgba(242, 85, 124, 0.6)'
                    ],
                    borderColor:[
                        'rgba(36, 181, 132, 1)',
                        // 'rgba(255, 193, 24, 1)',
                        // 'rgba(255, 53, 53, 1)'
                        // 'rgba(75, 203, 223, 1)',
                        // 'rgba(246, 99, 26, 1)',
                        'rgba(240, 50, 97, 1)'
                    ],
                        borderWidth: 1.5
                }]
            } 
        })
    </script>
</body>
</html>