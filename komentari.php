<!DOCTYPE html>
<html lang="en">
<head>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="lib/css/dashboard.css">

    <title>Dashboard-Komentari</title>
</head>
<body>
<?php
require 'provjeraAutorizacije.php';
require 'validacija.php';
   $veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
   $veza->exec("set names utf8");     
   $query = "SELECT * FROM komentar";
   $iskaz = $veza->query($query);   
    while ($row = $iskaz->fetch(PDO::FETCH_ASSOC))
    {
        $str = 'opt_' . $row['id'];

        if (isset($_REQUEST[$str])) {
            if ($_REQUEST[$str] == 'OBRISI') // funkcija brisanja
            {
                $delete = "DELETE FROM komentar WHERE id = :id";
                $iskaz2 = $veza->prepare($delete);
                $iskaz2->bindParam(":id", $row['id']);
                $rezultat = $iskaz2->execute();
                if($rezultat == false)
                    die('Doslo je do greske prilikom brisanja iz baze');
                $iskaz2 = null;

            } elseif ($_REQUEST[$str] == 'IZMIJENI') // funkcija izmjene
            {
                $_SESSION['izmijeni'] = "on";
                $_SESSION['polje'] = $row['id'] + 0;
            } elseif ($_REQUEST[$str] == 'SPASI') {
                // Da li je zaista poslan request?
                if (isset($_REQUEST['korisnik']) && isset($_REQUEST['tekst'])) {
                    // Provjera da li su submit-ani podaci prazni
                    if (!praznoPolje($_REQUEST['korisnik']) && !praznoPolje($_REQUEST['tekst'])) {
                        //Validacija podataka
                        if (!validacijaKomentar($_REQUEST['tekst'])) {
                            echo "<script type='text/javascript'>alert('Komentar ne moze bit duzi od 100 karaktera');</script>";
                            break;
                        }
                        if (!validacijaKorisnikID($_REQUEST['korisnik'])) {
                            echo "<script type='text/javascript'>alert('Ne postoji korisnik s takvim id-em');</script>";
                            break;
                        }
                        // Potrebno je obezbijediti zastitu od XSS-a
                        $row['korisnik'] = xssPrevencija($_REQUEST['korisnik']);
                        $row['tekst'] = xssPrevencija($_REQUEST['tekst']);
                        $update = "UPDATE komentar SET tekst = :tekst, korisnik = :korisnik  WHERE id = :id";
                        $iskaz3 = $veza->prepare($update);
                        $iskaz3->bindParam(':tekst',$row['tekst']);
                        $iskaz3->bindParam(':korisnik',$row['korisnik']);
                        $iskaz3->bindParam(':id',$row['id']);
                        $rezultat = $iskaz3->execute();

                        if($rezultat == false)
                        {
                            die('Doslo je do greske prilikom izmjene narudzbe u bazi');
                        }

                    } else {
                        echo "<script type='text/javascript'>alert('Niste ispunili sva polja!');</script>";
                    }
                }
            }
        }
    }


?>
<div class="row">
    <div class="kolona-3">
        <h1>Dashboard</h1>
    </div>
</div>
<div class="row">
    <div class="kolona-11">
        <ul>
            <li><a  href="dashboard.php">Narudzbe</a></li>
            <li><a  href="registrovaniClanovi.php">Korisnici</a></li>
            <li><a class="active" href="#">Komentari</a></li>
            <li><a href="modeli.php">Modeli</a></li>
        </ul>
    </div>
    <div class="kolona-1">
        <ul>
            <li style="background-color: #4CAF50">
                <a href="main.php">Pocetna</a>
            </li>
        </ul>
    </div>
</div>

<?php

   $veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
   $veza->exec("set names utf8");     
   $query = "SELECT * FROM komentar";
   $iskaz = $veza->query($query);   
    echo "<div class='row'>";
    echo "<div class='kolona-12'>";
    echo "<form action='komentari.php' method='get'>";
    echo "<table id='tabela'>";
    echo "<tr><th>ID</th><th>KOMENTAR</th><th>KORISNIK ID</th><th>OPCIJA 1</th><th>OPCIJA 2</th></tr>";

    while ($row = $iskaz->fetch(PDO::FETCH_ASSOC))
    {

        if(isset($_SESSION['izmijeni']))
        {
            if($_SESSION['polje'] == ($row['id'] + 0) && $_SESSION['izmijeni'] == 'on')
            {
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td><input type='text' name='tekst' value='". $row['tekst'] . "'></td>";
                echo "<td><input type='text' name='korisnik' value='".$row['korisnik']."'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $row['id'] . "' value='SPASI'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $row['id'] . "' value='OBRISI'></td>";
                echo "</tr>";
                $_SESSION['izmijeni'] = 'off';
            }
            else
            {
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['tekst']."</td>";
                echo "<td>".$row['korisnik']."</td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $row['id'] . "' value='IZMIJENI'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $row['id'] . "' value='OBRISI'></td>";
                echo "</tr>";
            }
        }
        else {

            echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['tekst']."</td>";
                echo "<td>".$row['korisnik']."</td>";
            echo "<td style='text-align: center'><input class='dugme' type='submit' name='opt_" . $row['id'] . "' value='IZMIJENI'></td>";
            echo "<td style='text-align: center'><input class='dugme' type='submit' name='opt_" . $row['id'] . "' value='OBRISI'></td>";
            echo "</tr>";


        }
    }
    echo "</table>";
    echo "</div>";
    echo "</div>";
    echo "</form>";
    $iskaz = null;
    $veza = null;


?>

</body>
</html>
