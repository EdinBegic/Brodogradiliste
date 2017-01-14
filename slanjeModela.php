<!DOCTYPE html>
<html lang="en">
<head>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="lib/css/header.css">
    <link rel="stylesheet" type="text/css" href="lib/css/katalog.css">
    <script type="text/javascript" src="lib/javascript/katalog.js"></script>
</head>
<body>
<?php
$_REQUEST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_REQUEST);
require 'provjeraAutorizacije.php';

$br = 0;
$veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
$veza->exec("set names utf8");       
$query = "SELECT * FROM modeli";
$iskaz = $veza->query($query);

while ($row = $iskaz->fetch(PDO::FETCH_ASSOC))
{
    $str = 'opt_'.$row['id'];

    if(isset($_REQUEST[$str]))
    {
        $br++;
        if($_REQUEST[$str] == 'obrisi') // funkcija brisanja
        {
            $delete = "DELETE FROM modeli WHERE id = :id";
            $iskaz2 = $veza->prepare($delete);
            $iskaz2->bindParam(":id", $row['id']);
            $rezultat = $iskaz2->execute();
            if($rezultat == false)
                die('Doslo je do greske prilikom brisanja iz baze');
            $iskaz2 = null;
            $iskaz = null;
            $veza = null;
            header("Location: katalog.php");

        }

    }
}
if($br == 0 && !isset($_REQUEST['dodaj'])) {
    $iskaz = null;
    $veza = null;
    header("Location: katalog.php");
    exit();
}
$iskaz = null;
$veza = null;
?>
<div class="row" id="vrh">
    <div class="kolona-12">
        <img id="logo" src="Pictures/logo_brod.jpg" alt="Nije se mogla ucitati slika">
    </div>
    <div class="kolona-2 meni" id="prviButton">
        <ul>
            <li id="prvi">
                <a href="main.php" class="meni_link" > <b>Početna</b></a>
            </li>
        </ul>
    </div>
    <div class="kolona-2 meni" id="drugiButton">
        <ul>
            <li id="drugi">
                <a href="narudzba.php" class="meni_link" ><b>Narudžba</b></a>
            </li>
        </ul>
    </div>
    <div class="kolona-2 meni" id="treciButton">
        <ul>
            <li id="treci">
                <a href="kontakt.php" class="meni_link" ><b>Kontakt</b></a>
            </li>
        </ul>
    </div>
    <div class="kolona-2 meni_aktivan" id="cetvrtiButton">
        <ul>
            <li id="cetvrti">
                <a href="katalog.php" class="meni_link" ><b>Katalog</b></a>
            </li>
        </ul>
    </div>
    <div class="kolona-2 meni" id="petiButton">
        <ul>
            <li id="peti">
                <a href="registracija.php" class="meni_link" ><b>Registracija</b></a>
            </li>
        </ul>
    </div>
    <div class="kolona-2 meni" id="sestiButton">
        <ul>
            <li id="sesti">
                <a class="meni_link" id="stanjeButton" href="dashboard.php">&nbsp; </a>
            </li>
        </ul>
    </div>
</div>
<?php
if(isset($_SESSION['username']))
{
    if($_SESSION['username'] == 'admin')
    {
        // Kreiraj dashboard podstranicu za admina
        echo '<script language="javascript">';
        echo "document.getElementById('stanjeButton').innerHTML = '<a><b>Dashboard</b></a>';";
        echo "document.getElementById('sesti').style.backgroundColor ='black';";
        echo '</script>';

        echo "<div class='row' id='trakaOnline' >";
        echo "<div class='altKolona-2' style='text-align: center; background-color: lightgreen; border-radius: 10px'>";
        echo "Dobro došao ".$_SESSION['username'];
        echo "<form action='odjava.php' method='post'>";
        echo "<button type='submit' name='odjava'>Odjavi se</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }
    else
    {
        echo "<div class='row' id='trakaOnline'>";
        echo "<div class='altKolona-2' style='text-align: center; background-color: yellow; border-radius: 10px'>";
        echo "Dobro došao ".$_SESSION['username'];
        echo "<form action='odjava.php' method='post'>";
        echo "<button type='submit' name='odjava'>Odjavi se</button>";
        echo "</form>";
        echo "</div>";

    }
}
?>
<div class = "row" id="ispod_headera">
    <div class="kolona-12" id="catalog">
    </div>
</div>
<div class="sredina">
    <div class="row" id="ponudjeniModeliRed">
        <div class="kolona-12"  id="ponudjeniModeli">
            <?php
                if(isset($_REQUEST['dodaj']))
                {
                    echo "<p>NOVI MODEL</p>";
                }
                else
                    echo "<p>IZMIJENI MODEL</p>";
            ?>
        </div>
    </div>
    <?php
        
        $veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
        $veza->exec("set names utf8");
        
        $query = "SELECT * FROM modeli";
        $iskaz = $veza->query($query);

        $temp;
        while ($row = $iskaz->fetch(PDO::FETCH_ASSOC))
        {
            $str = 'opt_'.$row['id'];

            if(isset($_REQUEST[$str])) {
                if ($_REQUEST[$str] == 'izmijeni') {
                    $temp = $row;
                    break;
                }
            }
        }
        echo "<form action='spasiModel.php' method='post'>";
        echo "<div class='row generisaniRedovi'>";
        echo "<div class='kolona-6 dodatna1' style='text-align: right'>";
        echo "<img class='slika' width='180px' height='90px'  src='Pictures/brodRatni.jpg'  alt='Nije se mogla ucitati slika' />";
        echo "</div>";
        echo "<div class='kolona-6 dodatna2' style='text-align: left'>";
        echo "<div class='row'>";
        echo "<div class='kolona-3 dodatna2' style='text-align: left'>";
        echo "<p style='font-size: 165%;'><b>Naziv</b></p>";
        echo "</div>";
        echo "<div class='kolona-6 dodatna2' style='padding-top: 2%' style='text-align: left'>";
        if(isset($_REQUEST['dodaj']))
        {
            echo "<input type='text' style='border: none !important;' name='naziv' value=''>";
        }
        elseif(isset($temp))
        {
            echo "<input type='text' style='border: none !important;' name='naziv' value='".$temp['naziv']."'>";
        }
        echo "</div>";
        echo "</div>";

        echo "<div class='row'>";
        echo "<div class='kolona-3 dodatna2' style='text-align: left'>";
        echo "<p style='font-size: 165%'><b>Cijena</b></p>";
        echo "</div>";
        echo "<div class='kolona-6 dodatna2' style='text-align: left; padding-top: 2%'>";
        if(isset($_REQUEST['dodaj']))
        {
            echo "<input type='text' style='border: none !important;' name='cijena' value=''>";
        }
        elseif(isset($temp))
        {
            echo "<input type='text' style='border: none !important;' name='cijena' value='".$temp['cijena']."'>";
        }
        echo "</div>";
        echo "</div>";

        echo "<div class='row'>";
        echo "<div class='kolona-6 dodatna2' style='text-align: center'>";
        if(isset($_REQUEST['dodaj']))
        {
            echo "<input class='dugmeZaSlanje' style='font-size: 120%;' type='submit' name='dodajModel' value='Dodaj model'>";
        }
        elseif(isset($temp))
        {
            echo "<input type='hidden' name='idModel' value='".$temp['id']."'>";
            echo "<input class='dugmeZaSlanje' style='font-size: 120%;' type='submit' name='izmijeniModel' value='Izmijeni model'>";
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</form>";
        $iskaz = null;
        $veza = null;

    ?>
</body>
</html>