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
function jedinstvenostUsername($username) // Provjera da li u bazi postoji korisnik s takvim username-om
{
    global $pathKorisnici;

    if(file_exists($pathKorisnici))
    {
        $korisnici = simplexml_load_file($pathKorisnici);
        foreach($korisnici->children() as $korisnik)
        {
            if($korisnik->username == $username)
                return false;
        }
    }
    else // Ukoliko ne postoji xml, novi username ce biti sigurno jedinstven
    {
        return true;
    }

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
