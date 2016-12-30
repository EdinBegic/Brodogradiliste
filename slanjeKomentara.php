<?php
if(!file_exists("lib/xml/komentari.xml")) // Ukoliko ne postoji fajl, kreiraj novi
{
    $komentari = new SimpleXMLElement("<komentari></komentari>");
    header("Content-type: text/xml");
    $komentari->asXML("lib/xml/komentari.xml");
    header("Location: kontakt.php");
    exit();
}
else {
    $_REQUEST = array(); //workaround for broken PHPstorm
    parse_str(file_get_contents('php://input'), $_REQUEST);
    require 'validacija.php';
// Da li je zaista poslan request?
    if (!isset($_REQUEST['tekst']) || !isset($_REQUEST['email'])) {
        header("Location: kontakt.php");
        exit();
    }
// Provjera da li su submit-ani podaci prazni
    if (praznoPolje($_REQUEST['tekst']) || praznoPolje($_REQUEST['email'])) {
        echo "<script type='text/javascript'>alert('Niste ispunili sva polja!');</script>";
        echo "<script type='text/javascript'>window.location.href='kontakt.php'</script>";
        exit();
    }
// Potrebno je obezbijediti zastitu od XSS-a
    $tekst = xssPrevencija($_REQUEST['tekst']);
    $email = xssPrevencija($_REQUEST['email']);
// Validacija podataka
    if (!validacijaEmail($email)) {
        echo "<script type='text/javascript'>alert('Unesite validan email');</script>";
        echo "<script type='text/javascript'>window.location.href='kontakt.php'</script>";
        exit();

    }
    if (!validacijaKomentar($tekst)) {
        echo "<script type='text/javascript'>alert('Unesite validan email');</script>";
        echo "<script type='text/javascript'>window.location.href='kontakt.php'</script>";
        exit();
    }

    $komentari = simplexml_load_file("lib/xml/komentari.xml");
    $vel = $komentari->count();
    if($vel == 0)
        $id = 1;
    else {
        $cvor = $komentari->komentar[$vel - 1];
        $id = $cvor->id + 1;
    }
    $komentar = $komentari->addChild('komentar');
    $komentar->addChild('id', $id);
    $komentar->addChild('email', $email);
    $komentar->addChild('tekst', $tekst);
    $komentari->asXML("lib/xml/komentari.xml");

    echo "<script type='text/javascript'>alert('Uspjesno ste poslali komentar');</script>";
    echo "<script type='text/javascript'>window.location.href='kontakt.php'</script>";
    exit();
}