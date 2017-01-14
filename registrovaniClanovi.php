<!DOCTYPE html>
<html lang="en">
<head>
    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="lib/css/dashboard.css">

    <title>Dashboard-Clanovi</title>
</head>
<body>
<?php
require 'provjeraAutorizacije.php';
require 'validacija.php';
 $veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
   $veza->exec("set names utf8");     
   $query = "SELECT * FROM korisnik";
   $iskaz = $veza->query($query);   
    while ($row = $iskaz->fetch(PDO::FETCH_ASSOC))
    {
        if ($row['username'] == 'admin')
            continue;
        $str = 'opt_' . $row['id'];

        if (isset($_REQUEST[$str])) {
            if ($_REQUEST[$str] == 'OBRISI') // funkcija brisanja
            {
             $delete = "DELETE FROM korisnik WHERE id = :id";
                $iskaz2 = $veza->prepare($delete);
                $iskaz2->bindParam(":id", $row['id']);
                $rezultat = $iskaz2->execute();
                if($rezultat == false)
                    die('Doslo je do greske prilikom brisanja iz baze');
                $iskaz2 = null;
            }
             elseif ($_REQUEST[$str] == 'IZMIJENI') // funkcija izmjene
            {
                $_SESSION['izmijeni'] = "on";
                $_SESSION['polje'] = $row['id'] + 0;
            } 
            elseif ($_REQUEST[$str] == 'SPASI') {
                if (isset($_REQUEST['username']) && isset($_REQUEST['email'])) 
                {
                    if (!praznoPolje($_REQUEST['username']) && !praznoPolje($_REQUEST['email'])) 
                    {
                        if (!validacijaUsername($_REQUEST['username'])) {
                            echo "<script type='text/javascript'>alert('Username se moze sastojati samo od alfanumerickih znakova duzine od 2 do 18 karaktera');</script>";
                            break;
                        }
                        if (!validacijaEmail($_REQUEST['email'])) {
                            echo "<script type='text/javascript'>alert('Unesite validan email');</script>";
                            break;
                        }
                        if(!jedinstvenostUsername($_REQUEST['username']) && $_REQUEST['username'] != $row['username'])
                        {
                            echo "<script type='text/javascript'>alert('Postoji korisnik s takvim username-om');</script>";
                            break;
                        }

                        $row['username'] = xssPrevencija($_REQUEST['username']);
                        $row['email'] = xssPrevencija($_REQUEST['email']);
                        
                        $update = "UPDATE korisnik SET username = :username, email = :email  WHERE id = :id";
                        $iskaz3 = $veza->prepare($update);
                        $iskaz3->bindParam(':username',$row['username']);
                        $iskaz3->bindParam(':email',$row['email']);
                        $iskaz3->bindParam(':id',$row['id']);
                        $rezultat = $iskaz3->execute();
                        if($rezultat == false)
                            die('Doslo je do greske prilikom upisa u bazu');
                    } 
                    else 
                    {
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
            <li><a class="active" href="#">Korisnici</a></li>
            <li><a href="komentari.php">Komentari</a></li>
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
     $query = "SELECT * FROM korisnik";
     $iskaz = $veza->query($query);   

     echo "<div class='row'>";
     echo "<div class='kolona-12'>";
     echo "<form action='registrovaniClanovi.php' method='get'>";
     echo "<table id='tabela'>";
     echo "<tr><th>ID</th><th>USERNAME</th><th>EMAIL</th><th>OPCIJA 1</th><th>OPCIJA 2</th></tr>";

    while ($row = $iskaz->fetch(PDO::FETCH_ASSOC))
     {
        if($row['username'] == 'admin')
            continue;
        if(isset($_SESSION['izmijeni']))
        {
            if($_SESSION['polje'] == ($row['id'] + 0) && $_SESSION['izmijeni'] == 'on')
            {
                echo "<tr style='text-align: center'>";
                echo "<td>".$row['id']."</td>";
                echo "<td><input type='text' name='username' value='".$row['username']."'></td>";
                echo "<td><input type='text' name='email' value='".$row['email']."'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $row['id'] . "' value='SPASI'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $row['id'] . "' value='OBRISI'></td>";
                echo "</tr>";
                $_SESSION['izmijeni'] = 'off';
            }
            else
            {
                echo "<tr style='text-align: center'>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['username']."</td>";
                echo "<td>".$row['email']."</td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" .$row['id'] . "' value='IZMIJENI'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme' name='opt_" . $row['id'] . "' value='OBRISI'></td>";
                echo "</tr>";
            }
        }
        else {
         
                echo "<tr style='text-align: center'>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['username']."</td>";
                echo "<td>".$row['email']."</td>";
                echo "<td style='text-align: center'><input type='submit'  class='dugme' name='opt_" . $row['id'] . "' value='IZMIJENI'></td>";
                echo "<td style='text-align: center'><input type='submit' class='dugme'   name='opt_" . $row['id'] . "' value='OBRISI'></td>";
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
