<?php
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
$año = date("Y");
// $sql=$conn->query('Select distinct plaza from sucursales');                    
// $result=$sql->fetchAll();
// foreach($result as $data){
//     $plaza[] = $data['plaza'];
// }
$sql=$conn->query('select (t2.venta_total/t1.presupuesto_total)*100 As cobertura, t1.plaza from
    (select sum(presupuesto.presupuesto)  as presupuesto_total, sucursales.plaza from presupuesto 
        INNER JOIN sucursales on presupuesto.sucursal = sucursales.numero group by sucursales.plaza) AS t1,
            (select sum(venta_diaria.venta) as venta_total, sucursales.plaza from venta_diaria 
                INNER JOIN sucursales on venta_diaria.sucursal = sucursales.numero group by sucursales.plaza) AS t2
                    where t1.plaza = t2.plaza');                   
$result=$sql->fetchAll();
foreach($result as $data){
    $plaza[] = $data['plaza'];
    $total[] = $data['cobertura'];
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
<body class="grafica">    <br>
        <div class="grafica">
            <h1>Presupuesto Anúal</h1>
            <?php echo ('<h3>'.$año.'</h3><br>');?>
            <a href="graph_year.php" target="_blank"><canvas id="myChart" width="400" height="280"></canvas></a>
        </div>
        
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const names = <?php echo json_encode($plaza) ?>;
        const ages = <?php echo json_encode($total) ?>;

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: names,
                datasets: [{
                    label: '% de Cobertura',
                    data: ages,
                    backgroundColor:[
                        // 'rgba(63, 168, 236, 0.8)',
                        // 'rgba(255, 193, 24, 0.8)',
                        // 'rgba(255, 53, 53, 0.8)'
                        'rgba(106, 120, 209, 0.8)',  
                        'rgba(121, 206, 220, 0.8)',                      
                        'rgba(250, 114, 46, 0.8)'                        
                    ],
                    borderColor:[
                        // 'rgba(63, 168, 236, 1)',
                        // 'rgba(255, 193, 24, 1)',
                        // 'rgba(255, 53, 53, 1)'
                        'rgba(73, 91, 208, 1)',
                        'rgba(75, 203, 223, 1)',
                        'rgba(246, 99, 26, 1)'    
                    ],
                    borderWidth: 1.5
                }]
            } 
        })
    </script>
</body>
</html>