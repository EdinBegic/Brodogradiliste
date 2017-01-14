<html lang="en">
<head>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="lib/css/dashboard.css">

    <title>Dashboard-Modeli</title>
</head>
<body>
<?php
require 'provjeraAutorizacije.php';
require 'validacija.php';
 $veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
   $veza->exec("set names utf8");     
   $query = "SELECT * FROM modeli";
   $iskaz = $veza->query($query);   
    while ($row = $iskaz->fetch(PDO::FETCH_ASSOC))
    {
        $str = 'opt_' . $row['id'];

        if (isset($_REQUEST[$str])) {
            if ($_REQUEST[$str] == 'OBRISI') // funkcija brisanja
            {
                $delete = "DELETE FROM modeli WHERE id = :id";
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
                if (isset($_REQUEST['naziv']) && isset($_REQUEST['cijena'])) {
                    if (!praznoPolje($_REQUEST['naziv']) && !praznoPolje($_REQUEST['cijena'])) {
                        if (!validacijaCijena($_REQUEST['naziv'])) // koristim regex kao i za cijenu (jer nazivi brodova nisu sintaksno slicni imenima ljudi)
                        {
                            echo "<script type='text/javascript'>alert('Unijeli ste sintaksno neispravan naziv.');</script>";
                            break;
                        }
                        if (!validacijaCijena($_REQUEST['cijena'])) {
                            echo "<script type='text/javascript'>alert('Unijeli ste sintaksno neispravnu cijenu.');</script>";
                            break;
                        }
                        $row['naziv'] = xssPrevencija($_REQUEST['naziv']);
                        $row['cijena'] = xssPrevencija($_REQUEST['cijena']);
                        
                        $update = "UPDATE modeli SET naziv = :naziv, cijena = :cijena  WHERE id = :id";
                        $iskaz3 = $veza->prepare($update);
                        $iskaz3->bindParam(':naziv',$row['naziv']);
                        $iskaz3->bindParam(':cijena',$row['cijena']);
                        $iskaz3->bindParam(':id',$row['id']);
                        $rezultat = $iskaz3->execute();
                        if($rezultat == false)
                            die('Doslo je do greske prilikom upisa u bazu');
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
            <li><a  href="komentari.php">Komentari</a></li>
            <li><a class="active" href="#">Modeli</a></li>
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
     $query = "SELECT * FROM modeli";
     $iskaz = $veza->query($query);   
    echo "<div class='row'>";
    echo "<div class='kolona-12'>";
    echo "<form action='modeli.php' method='get'>";
    echo "<table id='tabela'>";
    echo "<tr><th>ID</th><th>NAZIV</th><th>CIJENA</th><th>OPCIJA 1</th><th>OPCIJA 2</th></tr>";

    while ($row = $iskaz->fetch(PDO::FETCH_ASSOC))
    {

        if(isset($_SESSION['izmijeni']))
        {
            if($_SESSION['polje'] == ($row['id'] + 0) && $_SESSION['izmijeni'] == 'on')
            {
                echo "<tr style='text-align: center'>";
                echo "<td>".$row['id']."</td>";
                echo "<td><input type='text' name='naziv' value='".$row['naziv']."'></td>";
                echo "<td><input type='text' name='cijena' value='".$row['cijena']."'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $row['id'] . "' value='SPASI'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $row['id'] . "' value='OBRISI'></td>";
                echo "</tr>";
                $_SESSION['izmijeni'] = 'off';
            }
            else
            {
                echo "<tr style='text-align: center'>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['naziv']."</td>";
                echo "<td>".$row['cijena']."</td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $row['id'] . "' value='IZMIJENI'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $row['id'] . "' value='OBRISI'></td>";
                echo "</tr>";
            }
        }
        else
        {
            echo "<tr style='text-align: center'>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['naziv']."</td>";
            echo "<td>".$row['cijena']."</td>";
            echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $row['id'] . "' value='IZMIJENI'></td>";
            echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $row['id'] . "' value='OBRISI'></td>";
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
