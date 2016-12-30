<?php
$_REQUEST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_REQUEST);
require 'provjeraAutorizacije.php';

if(!isset($_REQUEST['csvIzvjestaj']))
{
    header("Location: main.php");
    exit();
}

if(!file_exists('lib/xml/modeli.xml'))
{
    echo "<script type='text/javascript'>alert('Baza podataka modela trenutno nije dostupna');</script>";
    echo "<script type='text/javascript'>window.location.href='main.php'</script>";
    exit();
}
else
    $modeli = simplexml_load_file("lib/xml/modeli.xml");

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=izvjestaj.csv');

$fp = fopen('php://output', 'w');

$lista = array();
$prviRed = array('Naziv','Cijena');

fputcsv($fp,$prviRed);

foreach ($modeli->children() as $model)
{
    $red = array();
    array_push($red, $model->naziv, $model->cijena);
    array_push($lista, $red);
}
foreach ($lista as $polje) {
    fputcsv($fp, $polje);
}
fclose($fp);
exit();