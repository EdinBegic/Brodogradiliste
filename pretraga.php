<?php
require 'validacija.php';
if(!isset($_GET['q']))
{
    header("Location: main.php");
    exit();
}
$modeli;
if(!file_exists("lib/xml/modeli.xml"))
{
    echo "Nije moguce pristupiti podacima o modelima u bazi";
    exit();
}
else
    $modeli = simplexml_load_file("lib/xml/modeli.xml");
//pokupimo vrijednost parametra q koji je proslijedjen
$rezultati = '';
if(isset($_GET["q"]))
{
    $q=xssPrevencija($_GET["q"]);
    if($q != '')
    {
        $brojac = 0;
        foreach ($modeli->children() as $model)
        {
            if($brojac >= 10)
                break;
            if(stristr($model->naziv,$q) || stristr($model->cijena,$q))
            {
                if($brojac == 0) // Prvi element
                {
                    $rezultati .= "<table border='1' style='width: inherit; border-collapse: collapse'>";
                }
                $rezultati .= "<tr><td>".$model->naziv."</td><td>".$model->cijena."</td></tr>";
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

