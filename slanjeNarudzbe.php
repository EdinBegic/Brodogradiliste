<?php
if(!file_exists("lib/xml/Narudzbe.xml")) // Ukoliko ne postoji fajl, kreiraj novi
{
    $narudzbe = new SimpleXMLElement("<Narudzbe></Narudzbe>");
    header("Content-type: text/xml");
    $narudzbe->asXML("lib/xml/Narudzbe.xml");
    header("Location: narudzba.php");
    exit();
}
else {
    $_REQUEST = array(); //workaround for broken PHPstorm
    parse_str(file_get_contents('php://input'), $_REQUEST);
    require 'validacija.php';

// Da li je zaista poslan request?
    if(!isset($_REQUEST['ime']) || !isset($_REQUEST['prezime']) || !isset($_REQUEST['email']) || !isset($_REQUEST['broj'])
        || !isset($_REQUEST['tipBroda']))
    {
        header("Location: main.php");
        exit();
    }
// Provjera da li su submit-ani podaci prazni
    if(praznoPolje($_REQUEST['ime']) || praznoPolje($_REQUEST['prezime']) || praznoPolje($_REQUEST['email']) || praznoPolje($_REQUEST['broj'])
        || praznoPolje($_REQUEST['tipBroda']))
    {
        echo "<script type='text/javascript'>alert('Niste ispunili sva polja!');</script>";
        echo "<script type='text/javascript'>window.location.href='narudzba.php'</script>";
        exit();
    }
// Potrebno je obezbijediti zastitu od XSS-a
    $imeIzForme = xssPrevencija($_REQUEST['ime']);
    $prezimeIzForme = xssPrevencija($_REQUEST['prezime']);
    $emailIzForme = xssPrevencija($_REQUEST['email']);
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
    if(!validacijaEmail($emailIzForme))
    {
        echo "<script type='text/javascript'>alert('Unesite validan email');</script>";
        echo "<script type='text/javascript'>window.location.href='narudzba.php'</script>";
        exit();
    }
    if(!validacijaTelefon($telefonIzForme))
    {
        echo "<script type='text/javascript'>alert('Validan oblik broja telefona: [111-111-111] ili [111 111 111] ili [111/111/111]');</script>";
        echo "<script type='text/javascript'>window.location.href='narudzba.php'</script>";
        exit();
    }
    $narudzbe = simplexml_load_file("lib/xml/Narudzbe.xml");
    $vel = $narudzbe->count();
    if($vel == 0)
        $id = 1;
    else
    {
        $cvor = $narudzbe->Narudzba[$vel-1];
        $id = $cvor->id + 1;
    }
    $narudzba = $narudzbe->addChild('Narudzba');
    $narudzba->addChild('id',$id);
    $narudzba->addChild('ime',$imeIzForme);
    $narudzba->addChild('prezime',$prezimeIzForme);
    $narudzba->addChild('email',$emailIzForme);
    $narudzba->addChild('telefon',$telefonIzForme);
    $narudzba->addChild('tipBroda',$tipBrodaIzForme);
    $narudzbe->asXML("lib/xml/Narudzbe.xml");
    echo "<script type='text/javascript'>alert('Uspjesno ste poslali narudzbu');</script>";
    echo "<script type='text/javascript'>window.location.href='narudzba.php'</script>";
    exit();
}

