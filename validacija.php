<?php
// Regex stringovi za provjeru
$regexIme = "~^[a-zA-Z ]{2,18}$~";
$regexPrezime = "~^[a-zA-Z ]{2,18}$~";
$regexUsername = "~^\w{2,18}$~";
$regexPassword = "~^.{6,}$~";
$regexEmail = "~^(([^<>()\[\]\\.,;:\s@\"]+(\.[^<>()\[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$~i";
$regexTelefon = "~^\d{3}[ ,\-,/]\d{3}[ ,\-,/]\d{3}$~i";
$regexCijena = "~^[a-zA-Z0-9 .,\-]{2,18}$~";
$pathKorisnici = "lib/xml/korisnici.xml";
function xssPrevencija($podatak)
{
    $podatak = htmlentities($podatak);
    return $podatak;
}
function validacijaIme($ime)
{
    global $regexIme;

    if(preg_match($regexIme,$ime))
        return true;
    else
        return false;
}
function validacijaPrezime($prezime)
{
    global $regexPrezime;
    if(preg_match($regexPrezime, $prezime))
        return true;
    else
        return false;
}
function validacijaUsername($username)
{
    global $regexUsername;
    if(preg_match($regexUsername,$username))
        return true;
    else
        return false;
}
function validacijaPassword($password)
{
    global $regexPassword;
    if(preg_match($regexPassword,$password))
        return true;
    else
        return false;
}
function validacijaEmail($email)
{
    global $regexEmail;
    if(preg_match($regexEmail,$email))
        return true;
    else
        return false;
}
function validacijaTelefon($telefon)
{
    global $regexTelefon;
    if(preg_match($regexTelefon,$telefon))
        return true;
    else
        return false;
}
function validacijaCijena($cijena)
{
    global $regexCijena;
    if(preg_match($regexCijena,$cijena))
        return true;
    else
        return false;

}
function praznoPolje($string)
{
    if(empty($string) || strlen(trim($string)) == 0)
        return true;
    else
        return false;
}
function validacijaKorisnikID($id) // Provjera da li u bazi postoji korisnik s takvim username-om
{
    $veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
    $veza->exec("set names utf8");     
    $query = "SELECT COUNT(id) AS brojac FROM korisnik WHERE id = :id";   
    $iskaz = $veza->prepare($query);
    $iskaz->bindValue(':id', $id);
    $iskaz->execute();
    $row = $iskaz->fetch(PDO::FETCH_ASSOC);
     if($row['brojac'] == 0){
         return false;
     }
     $veza = null;
     $iskaz = null;
     return true;
}
function jedinstvenostUsername($username) // Provjera da li u bazi postoji korisnik s takvim username-om
{
    $veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
    $veza->exec("set names utf8");     
    $query = "SELECT COUNT(username) AS brojac FROM korisnik WHERE username = :username";   
    $iskaz = $veza->prepare($query);
    $iskaz->bindValue(':username', $username);
    $iskaz->execute();
    $row = $iskaz->fetch(PDO::FETCH_ASSOC);
     if($row['brojac'] > 0){
         return false;
     }
     $veza = null;
     $iskaz = null;
     return true;
}
function potvrdaPassworda($password, $potvrdaPassword)
{
    if($password === $potvrdaPassword)
        return true;
    else
        return false;
}
function validacijaKomentar($tekst)
{
    if(strlen($tekst)  > 100)
        return false;
    else
        return true;
}
