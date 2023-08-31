<?php 
include_once 'php/conexion.php';
session_start();
date_default_timezone_set('America/Mexico_City');
$mes = date('m');
$año = date("Y");
// $fcha = date('Y-m-d');
$fcha = "2022-10-15";
echo $fcha;
echo $mes;
$numero=3;
        
$sql=$conn->prepare('select t7.MetaVentaDiaria, (t7.VDD / t7.MetaVentaDiaria) * 100 AS cubierto,(1 - (t7.VDD / t7.MetaVentaDiaria)) * 100 AS faltante  from 
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
    print ('<br>');
    print_r ('Meta de Venta Diaria: $'.$meta = $data['MetaVentaDiaria'].'<br>');
    print_r ('Porcentaje de Venta Diaria Alcanzado: '.$cubierto = $data['cubierto'].'% <br>');
    print_r ('Porcentaje de Venta Diaria por Alcanzar: '.$faltante = $data['faltante'].'<br><br>');
}
$porcentajes = array(2);
$i=0;
while($i<2){
    array_push($porcentajes, $cubierto);
    $i++;
    array_push($porcentajes, $faltante);
    $i++;
}
foreach($porcentajes as $datos){
    print_r ($porcentajes);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
</body>
</html>