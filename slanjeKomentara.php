<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
         header("Location: main.php");
         exit();
    }
    $_REQUEST = array(); //workaround for broken PHPstorm
    parse_str(file_get_contents('php://input'), $_REQUEST);
    require 'validacija.php';
// Da li je zaista poslan request?
    if (!isset($_REQUEST['tekst'])) {
        header("Location: kontakt.php");
        exit();
    }
// Provjera da li su submit-ani podaci prazni
    if (praznoPolje($_REQUEST['tekst'])) {
        echo "<script type='text/javascript'>alert('Niste ispunili sva polja!');</script>";
        echo "<script type='text/javascript'>window.location.href='kontakt.php'</script>";
        exit();
    }
// Potrebno je obezbijediti zastitu od XSS-a
    $tekst = xssPrevencija($_REQUEST['tekst']);
// Validacija podataka
    if (!validacijaKomentar($tekst)) {
        echo "<script type='text/javascript'>alert('Unesite validan email');</script>";
        echo "<script type='text/javascript'>window.location.href='kontakt.php'</script>";
        exit();
    }

    $veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
    $veza->exec("set names utf8");

    $query = "SELECT id FROM korisnik WHERE username = ?";
    $iskaz2 = $veza->prepare($query);
    $iskaz2->bindValue(1, $_SESSION['username'], PDO::PARAM_STR);
    $iskaz2->execute();
    $rezultat1 = $iskaz2->fetch(PDO::FETCH_ASSOC);
    if($rezultat1 == false)
    {
        echo "<script type='text/javascript'>alert('Greska u provjeri username-a u bazi');</script>";
        echo "<script type='text/javascript'>window.location.href='narudzba.php'</script>";
        exit();
    }
    $id = $rezultat1['id'];
    $iskaz2 = null;
   
    $insert = "INSERT INTO komentar (tekst, korisnik) " . "VALUES (:tekst, :korisnik)";
    $iskaz = $veza->prepare($insert);
    $iskaz->bindParam(':tekst', $tekst);
    $iskaz->bindParam(':korisnik', $id);
    $rezultat = $iskaz->execute();
    //Konekcija kod PDO objekta se zatvara setovanjem objekta na null za razliku
    // od mysqli gdje je potrebno pozvati metodu closedir
    $iskaz = null;
    $veza = null;
    if($rezultat == false)
    {
        echo "<script type='text/javascript'>alert('Doslo je do pogreske pri unosu u bazu');</script>";
        echo "<script type='text/javascript'>window.location.href='main.php'</script>";
        exit();
    }
 
    echo "<script type='text/javascript'>alert('Uspjesno ste poslali komentar');</script>";
    echo "<script type='text/javascript'>window.location.href='kontakt.php'</script>";
    exit();
