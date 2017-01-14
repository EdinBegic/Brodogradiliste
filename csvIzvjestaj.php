<?php
$_REQUEST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_REQUEST);
require 'provjeraAutorizacije.php';

if(!isset($_REQUEST['csvIzvjestaj']))
{
    header("Location: main.php");
    exit();
}

$veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
$veza->exec("set names utf8");

$query = "SELECT * FROM modeli";
$iskaz = $veza->query($query);

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=izvjestaj.csv');

$fp = fopen('php://output', 'w');

$lista = array();
$prviRed = array('Naziv','Cijena');

fputcsv($fp,$prviRed);

while ($row = $iskaz->fetch(PDO::FETCH_ASSOC))
{
    $red = array();
    array_push($red, $row['naziv'], $row['cijena']);
    array_push($lista, $red);
}
foreach ($lista as $polje) {
    fputcsv($fp, $polje);
}
fclose($fp);
exit();