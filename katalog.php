<!DOCTYPE html>
<html lang="en">
<head>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="lib/css/header.css">
    <link rel="stylesheet" type="text/css" href="lib/css/katalog.css">
    <script type="text/javascript" src="lib/javascript/katalog.js"></script>

    <title>Katalog</title>
</head>
<body>
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
                <a href="narudzba.php" class="meni_link" ><b>Narudžba</b> </a>
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
                <a href="#" class="meni_link" ><b>Katalog</b></a>
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
session_start();
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
        echo "</div>";

    }
}
?>
<div class = "row" id="ispod_headera">
    <div class="kolona-12" id="catalog">
        <h1 id="kat">Katalog</h1>
    </div>
</div>
<div class="sredina">
    <div class="row" id="ponudjeniModeliRed">
 			<div class="kolona-12"  id="ponudjeniModeli">
 			<p> DOSTUPNI MODELI BRODOVA </p>
            </div>
    </div>

    <?php
        $_REQUEST = array(); //workaround for broken PHPstorm
        parse_str(file_get_contents('php://input'), $_REQUEST);
        $modeli;
        if(!file_exists('lib/xml/modeli.xml'))
        {
            $modeli = new SimpleXMLElement("<modeli></modeli>");
            header("Content-type: text/xml");
            $modeli->asXML("lib/xml/modeli.xml");
            header("Location: katalog.php");
            exit();
        }
        else
            $modeli = simplexml_load_file("lib/xml/modeli.xml");
        if(isset($_SESSION['username'])) {

            if ($_SESSION['username'] == 'admin'){

                // Csv izvjestaj
                echo "<div class='row generisaniRedovi'>";
                echo "<div class='kolona-12'>";
                echo "<form action='csvIzvjestaj.php' method='post'>";
                echo "<input class='dugmeZaSlanje' style='font-size: 120%' type='submit' name='csvIzvjestaj' value='Generisi CSV izvjestaj'>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
                // Mogucnost dodavanja modela
                echo "<form action='slanjeModela.php' method='post'>";
                echo "<div class='row generisaniRedovi'>";
                echo "<div class='kolona-12' style='text-align: center'>";
                echo "<input class='dugmeZaSlanje' style='font-size: 120%' name='dodaj' type='submit' value='Dodaj model'>";
                echo "</div>";
                echo "</div>";
            }
        }
        foreach ($modeli->children() as $model)
        {
            if(isset($_GET['pretraga']))
            {
                if($_GET['pretraga'] != '')
                {
                    if(!stristr($model->naziv,$_GET['pretraga']) && !stristr($model->cijena,$_GET['pretraga']))
                    {
                        continue;
                    }
                }
                else
                    break;

            }

            echo "<div class='row generisaniRedovi'>";

            echo "<div class='kolona-6 dodatna1' style='text-align: right'>";
            if($model->id == 1)
            {
                echo "<img class='slika' width='180px' height='90px' id='1' src='Pictures/jahta2.jpg'  alt='Nije se mogla ucitati slika'  onclick='otvoriModal(this.id)'/>";

            }
            elseif ($model->id == 2)
            {
                echo "<img class='slika' width='180px' height='90px' id='2' src='Pictures/katamaran2.jpg'  alt='Nije se mogla ucitati slika'  onclick='otvoriModal(this.id)'/>";

            }
            elseif ($model->id == 3)
            {
                echo "<img class='slika' width='180px' height='90px' id='3' src='Pictures/trajekt2.jpg'  alt='Nije se mogla ucitati slika'  onclick='otvoriModal(this.id)'/>";
            }
            else
            {
                echo "<img class='slika' width='180px' height='90px' id=".$model->id." src='Pictures/brodRatni.jpg'  alt='Nije se mogla ucitati slika'  onclick='otvoriModal(this.id)'/>";

            }
            echo "</div>";

            echo "<div class='kolona-6 dodatna2' style='text-align: left'>";

            echo "<div class='row'>";
            echo "<div class='kolona-3 dodatna2' style='text-align: left'>";
            echo "<p style='font-size: 165%'><b>Naziv:</b></p>";
            echo "</div>";
            echo "<div class='kolona-5 dodatna2' style='text-align: left'>";
            echo "<p style='font-size: 165%'>".$model->naziv."</p>";
            echo "</div>";
            echo "</div>";

            echo "<div class='row'>";
            echo "<div class='kolona-3 dodatna2' style='text-align: left'>";
            echo "<p style='font-size: 165%'><b>Cijena:</b></p>";
            echo "</div>";
            echo "<div class='kolona-5 dodatna2' style='text-align: left'>";
            echo "<p style='font-size: 165%'>".$model->cijena."</p>";
            echo "</div>";
            echo "</div>";

            if(isset($_SESSION['username']))
            {
                if($_SESSION['username'] == 'admin') {
                    echo "<div class='row'>";
                    echo "<div class='kolona-3 dodatna2' style='text-align: left'>";
                    echo "<input style='font-size:120%' class='dugmeZaSlanje' type='submit' name='opt_" . $model->id . "'  value='izmijeni'>";
                    echo "</div>";
                    echo "<div class='kolona-3 dodatna2' style='text-align: left'>";
                    echo "<input style='font-size:120%' class='dugmeZaSlanje' type='submit' name='opt_" . $model->id . "'  value='obrisi'>";
                    echo "</div>";
                    echo "</div>";
                }
            }

            echo "</div>";

            echo "</div>";
        }
    ?>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="zatvoriModal()">x</span>
            <img  id="prosirenaSlikaID"  src="#" alt="Nije se mogla ucitati slika">
        </div>
    </div>

</body>
</html>