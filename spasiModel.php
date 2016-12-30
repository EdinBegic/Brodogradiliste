<?php
$_REQUEST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_REQUEST);
require 'provjeraAutorizacije.php';
require 'validacija.php';

if(isset($_REQUEST['naziv']) && isset($_REQUEST['cijena']))
{
    if(file_exists("lib/xml/modeli.xml"))
    {
        // Provjera da li su submit-ani podaci prazni
        if(praznoPolje($_REQUEST['naziv']) || praznoPolje($_REQUEST['cijena']))
        {
            echo "<script type='text/javascript'>alert('Niste ispunili sva polja!');</script>";
            echo "<script type='text/javascript'>window.location.href='katalog.php'</script>";
            exit();
        }
        $modeli = simplexml_load_file("lib/xml/modeli.xml");
        // Potrebno je obezbijediti zastitu od XSS-a
        $naziv = xssPrevencija($_REQUEST['naziv']);
        $cijena = xssPrevencija($_REQUEST['cijena']);
        //Validacija podataka
        if(!validacijaCijena($naziv))
        {
            echo "<script type='text/javascript'>alert('Unijeli ste sintaksno neispravan naziv.');</script>";
            echo "<script type='text/javascript'>window.location.href='katalog.php'</script>";
            exit();
        }
        if(!validacijaCijena($cijena))
        {
            echo "<script type='text/javascript'>alert('Unijeli ste sintaksno neispravnu cijenu.');</script>";
            echo "<script type='text/javascript'>window.location.href='katalog.php'</script>";
            exit();
        }

        if(isset($_REQUEST['dodajModel']))
        {
            $vel = $modeli->count();
            $cvor = $modeli->model[$vel-1];
            $id = $cvor->id + 1;
            $model = $modeli->addChild('model');
            $model->addChild('id',$id);
            $model->addChild('naziv',$naziv);
            $model->addChild('cijena',$cijena);
            $modeli->asXML("lib/xml/modeli.xml");

            echo "<script type='text/javascript'>alert('Uspjesno ste dodali model.');</script>";
            echo "<script type='text/javascript'>window.location.href='katalog.php'</script>";
            exit();
        }
        elseif(isset($_REQUEST['izmijeniModel']) && isset($_REQUEST['idModel']))
        {
            foreach ($modeli->children() as $m)
            {
                if($m->id == $_REQUEST['idModel'])
                {
                    $m->naziv=$naziv;
                    $m->cijena=$cijena;
                    $modeli->asXML("lib/xml/modeli.xml");
                    echo "<script type='text/javascript'>alert('Uspjesno ste izmijenili model.');</script>";
                    echo "<script type='text/javascript'>window.location.href='katalog.php'</script>";
                    exit();
                }
            }
        }

    }
    else
    {
        header("Location: katalog.php");
        exit();
    }
}
else
{
    header("Location: katalog.php");
    exit();
}
