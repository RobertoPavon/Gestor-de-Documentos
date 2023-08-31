<?php
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
$fcha = date("m");
$sql=$conn->prepare('Select nombre from mes where idmes = ?');  
$sql->execute([$fcha]);          
$result=$sql->fetchAll();
foreach($result as $data){
    $mes = $data['nombre'];
}

$sql=$conn->prepare('Select presupuesto  from presupuesto where sucursal = ? and mes = ?');  
$sql->execute([$numero,$fcha]);          
$result=$sql->fetchAll();
foreach($result as $data){
    $presupuesto = $data['presupuesto'];
}

$sql=$conn->prepare('select SUM(venta) as total from venta_diaria where sucursal = ? and mes = ?;');     
$sql->execute([$numero, $fcha]);                    
$result=$sql->fetchAll();
foreach($result as $data){
    $parcial = $data['total'];
}
$total = ($parcial / $presupuesto) * 100;
$total_format = number_format($total, 1, '.', ',');
$presupuesto_format = number_format($presupuesto, 2, '.', ',');
$nuevo = '$'.$presupuesto_format;
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
        <h1>Cierre Mensual</h1>
        <?php echo ('<h3>'.$mes.'</h3>');?>    
        <?php echo ('<h3> Presupuesto '.$nuevo.'</h3><br>');?>      
        <a href="graph_closure.php" target="_blank"><canvas class="closure" id="myChart" width="400" height="300"></canvas></a>
        
        
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const name = [<?php echo json_encode($nombre)?>];
        const covertura = [<?php echo json_encode($total_format)?>];

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: name,
                datasets: [{
                    label: '% de Cobertura',
                    data: covertura,
                    backgroundColor:[
                        'rgba(193, 134, 178, 0.8)'
                        // 'rgba(255, 193, 24, 0.8)',
                        // 'rgba(255, 53, 53, 0.8)'
                        // 'rgba(121, 206, 220, 0.8)',
                        // 'rgba(250, 114, 46, 0.8)',
                        // 'rgba(56, 233, 210, 0.6)'
                    ],
                    borderColor:[
                        'rgba(134, 14, 104, 1)'
                        // 'rgba(255, 193, 24, 1)',
                        // 'rgba(255, 53, 53, 1)'
                        // 'rgba(75, 203, 223, 1)',
                        // 'rgba(246, 99, 26, 1)',
                        // 'rgba(1, 189, 165, 1)'
                    ],
                    borderWidth: 1.5
                }]
            } 
        })
    </script>
</body>
</html>