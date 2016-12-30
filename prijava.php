<?php
if(!file_exists("lib/xml/korisnici.xml")) // Ukoliko ne postoji fajl, kreiraj novi
{
    $korisnici = new SimpleXMLElement("<korisnici></korisnici>");
    header("Content-type: text/xml");
    $korisnici->asXML("lib/xml/korisnici.xml");
    header("Location: main.php");
    exit();
}
else
{
    $_REQUEST = array(); //workaround for broken PHPstorm
    parse_str(file_get_contents('php://input'), $_REQUEST);
    require 'validacija.php';

// Da li je zaista poslan request?
    if(!isset($_REQUEST['username']) || !isset($_REQUEST['password']))
    {
        header("Location: main.php");
        exit();
    }
// Provjera da li su submit-ani podaci prazni
    if(praznoPolje($_REQUEST['username']) || praznoPolje($_REQUEST['password']))
    {
        echo "<script type='text/javascript'>alert('Niste ispunili sva polja!');</script>";
        echo "<script type='text/javascript'>window.location.href='main.php'</script>";
        exit();
    }
// Potrebno je obezbijediti zastitu od XSS-a
    $usernameIzForme = xssPrevencija($_REQUEST['username']);
    $passwordIzForme = xssPrevencija($_REQUEST['password']);
// Validacija podataka
    if(!validacijaUsername($usernameIzForme))
    {
        echo "<script type='text/javascript'>alert('Username se moze sastojati samo od alfanumerickih znakova duzine od 2 do 18 karaktera');</script>";
        echo "<script type='text/javascript'>window.location.href='main.php'</script>";
        exit();
    }
    if(!validacijaPassword($passwordIzForme))
    {
        echo "<script type='text/javascript'>alert('Minimalna duzina passworda je 6 znakova');</script>";
        echo "<script type='text/javascript'>window.location.href='main.php'</script>";
        exit();
    }
    $korisnici = simplexml_load_file("lib/xml/korisnici.xml");
    $brojac = 0;
    foreach($korisnici->children() as $korisnik)
    {
        if((string)$korisnik->username == $usernameIzForme)
        {
            if((string)$korisnik->password == $passwordIzForme)
            {
                session_start();
                $_SESSION['username'] = $usernameIzForme;
                echo "<script type='text/javascript'>alert('Uspjesno ste se prijavili.');</script>";
                echo "<script type='text/javascript'>window.location.href='main.php'</script>";
                exit();
            }
            else
            {
                echo "<script type='text/javascript'>alert('Unijeli ste pogresan password');</script>";
                echo "<script type='text/javascript'>window.location.href='main.php'</script>";
                exit();
            }
            $brojac++;
            break;
        }
    }
    if($brojac == 0)
    {
        echo "<script type='text/javascript'>alert('Ne postoji korisnik s takvim username-om.');</script>";
        echo "<script type='text/javascript'>window.location.href='main.php'</script>";
        exit();
    }

}

