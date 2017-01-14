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
    if(!isset($_REQUEST['ime']) || !isset($_REQUEST['prezime'])  || !isset($_REQUEST['broj'])
        || !isset($_REQUEST['tipBroda']))
    {
        header("Location: main.php");
        exit();
    }
// Provjera da li su submit-ani podaci prazni
    if(praznoPolje($_REQUEST['ime']) || praznoPolje($_REQUEST['prezime'])  || praznoPolje($_REQUEST['broj'])
        || praznoPolje($_REQUEST['tipBroda']))
    {
        echo "<script type='text/javascript'>alert('Niste ispunili sva polja!');</script>";
        echo "<script type='text/javascript'>window.location.href='narudzba.php'</script>";
        exit();
    }
// Potrebno je obezbijediti zastitu od XSS-a
    $imeIzForme = xssPrevencija($_REQUEST['ime']);
    $prezimeIzForme = xssPrevencija($_REQUEST['prezime']);
    $telefonIzForme = xssPrevencija($_REQUEST['broj']);
    $tipBrodaIzForme = xssPrevencija($_REQUEST['tipBroda']);
//Validacija podataka
    if(!validacijaIme($imeIzForme))
    {
        echo "<script type='text/javascript'>alert('Unijeli ste sintaksno neispravno ime.');</script>";
        echo "<script type='text/javascript'>window.location.href='narudzba.php'</script>";
        exit();
    }
    if(!validacijaPrezime($prezimeIzForme))
    {
        echo "<script type='text/javascript'>alert('Unijeli ste sintaksno neispravno prezime.');</script>";
        echo "<script type='text/javascript'>window.location.href='narudzba.php'</script>";
        exit();
    }
    if(!validacijaTelefon($telefonIzForme))
    {
        echo "<script type='text/javascript'>alert('Validan oblik broja telefona: [111-111-111] ili [111 111 111] ili [111/111/111]');</script>";
        echo "<script type='text/javascript'>window.location.href='narudzba.php'</script>";
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
   
    $insert = "INSERT INTO narudzba (ime, prezime, telefon, tipBroda, korisnik) " . "VALUES (:ime, :prezime, :telefon, :tipBroda, :korisnik)";
    $iskaz = $veza->prepare($insert);
    $iskaz->bindParam(':ime', $imeIzForme);
    $iskaz->bindParam(':prezime', $prezimeIzForme);
    $iskaz->bindParam(':telefon', $telefonIzForme) ;
    $iskaz->bindParam(':tipBroda', $tipBrodaIzForme);
    $iskaz->bindParam(':korisnik', $id);
    $rezultat = $iskaz->execute();
    //Konekcija kod PDO objekta se zatvara setovanjem objekta na null za razliku
    // od mysqli gdje je potrebno pozvati metodu closedir
    $iskaz = null;
    $veza = null;
    // ukoliko nije uspješan unos
    if($rezultat == false)
    {
        echo "<script type='text/javascript'>alert('Doslo je do pogreske pri unosu u bazu');</script>";
        echo "<script type='text/javascript'>window.location.href='main.php'</script>";
        exit();
    }
    echo "<script type='text/javascript'>alert('Uspjesno ste poslali narudzbu');</script>";
    echo "<script type='text/javascript'>window.location.href='narudzba.php'</script>";
    exit();


