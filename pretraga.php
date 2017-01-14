<?php
require 'validacija.php';
if(!isset($_GET['q']))
{
    header("Location: main.php");
    exit();
}

 $veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
 $veza->exec("set names utf8");
 $query = "SELECT * FROM modeli";
 $iskaz = $veza->query($query);
//pokupimo vrijednost parametra q koji je proslijedjen
$rezultati = '';
if(isset($_GET["q"]))
{
    $q=xssPrevencija($_GET["q"]);
    if($q != '')
    {
        $brojac = 0;
        while ($row = $iskaz->fetch(PDO::FETCH_ASSOC))
        {
            if($brojac >= 10)
                break;
            if(stristr($row['naziv'],$q) || stristr($row['cijena'],$q))
            {
                if($brojac == 0) // Prvi element
                {
                    $rezultati .= "<table border='1' style='width: inherit; border-collapse: collapse'>";
                }
                $rezultati .= "<tr><td>".$row['naziv']."</td><td>".$row['cijena']."</td></tr>";
                $brojac++;
            }
        }
        if($brojac > 0)
        {
            $rezultati .= "</table>";
        }
        // Postavi ispis na "Nema prijedloga" ukoliko nije pronadjen model koji odgovara kljucnoj rijeci
        // ili vrati podatke o pronadjenom modelu
        if ($rezultati=='') {
            $odgovor="Nema prijedloga";
        } else {
            $odgovor=$rezultati;
        }
        echo $odgovor;
    }
}
$iskaz = null;
$veza = null;

