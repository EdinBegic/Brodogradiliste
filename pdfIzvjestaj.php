<?php
session_start();
$_POST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_POST);

if(!isset($_SESSION['username']))
{
    header("Location: main.php");
    exit();
}
else
{
    if(isset($_POST['kreirajPdf']))
    {
        ob_start();
        require('fpdf/fpdf.php');
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Image('Pictures/logo_brod.jpg',10,10,-200);
        $pdf->SetFont('Arial','B',24);
        $pdf->Cell(190,30,'Brodogradiliste',0, 2, 'C', false );
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(190,5,"Brodogradiliste je veci ili manji pogon za izgradnju i remont brodova i drugih plovnih objekata",0,1);
        $pdf->Cell(190,5,"(podmornica, platformi za busenje nafte, hidrokrilaca, lebdjelica).",0,1);
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(195,20,'Katalog',0,1,'C');
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(95,10,'Ponudjeni modeli',1,0,'C');
        $pdf->Cell(95,10,'Cijena',1,1,'C');
        $pdf->SetFont('Arial','',12);
        // Podaci iz baze
            $veza = new PDO('mysql:host=' . getenv('MYSQL_SERVICE_HOST') . ';port=3306;dbname=brodogradiliste', 'admin', 'password');
            $veza->exec("set names utf8");
        
             $query = "SELECT * FROM modeli";
             $iskaz = $veza->query($query);
        if(!$veza)
        {
            $pdf->Cell(95,10,"Modeli nedostupni u bazi",1,1);
        }
        else {
            while ($row = $iskaz->fetch(PDO::FETCH_ASSOC))
            {
                $pdf->Cell(95, 10, $row['naziv'], 1, 0, 'C');
                $pdf->Cell(95, 10, $row['cijena'], 1, 1, 'C');

            }
        }
        $query = "SELECT COUNT(*) AS brojac FROM narudzba";
        $iskaz = $veza->query($query);
        $row = $iskaz->fetch(PDO::FETCH_ASSOC);
        
        if(!$veza)
        {
            $pdf->Cell(95,10,"Narudzbe nedostupne u bazi",1,1);
        }
        else
        {
            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(90,20,'Broj trenutnih narudzbi u procesiranju:',0,0,'L');
            $pdf->Cell(50,20,$row['brojac'],0,1,'C'); // Podaci iz xml-a
        }
        $query = "SELECT COUNT(*) AS brojac FROM korisnik";
        $iskaz = $veza->query($query);
        $row = $iskaz->fetch(PDO::FETCH_ASSOC);
        if(!$veza)
        {
            $pdf->Cell(95,10,"Korisnici nedostupni u bazi",1,1);
        }
        else
        {
            $kor = simplexml_load_file("lib/xml/korisnici.xml");
            $pdf->Cell(90,20,'Broj registrovanih korisnika:',0,0,'L');
            $pdf->Cell(50,20,$row['brojac'],0,1,'C'); // Podaci iz xml-a (ukljucujuci administratora)
        }
        $query = "SELECT COUNT(*) AS brojac FROM komentar";
        $iskaz = $veza->query($query);
        $row = $iskaz->fetch(PDO::FETCH_ASSOC);
        if(!$veza)
        {
            $pdf->Cell(95,10,"Komentari nedostupni u bazi",1,1);
        }
        else
        {
            $kom = simplexml_load_file("lib/xml/komentari.xml");
            $pdf->Cell(90,20,'Broj poslanih komenatara:',0,0,'L');
            $pdf->Cell(50,20,$row['brojac'],0,1,'C'); // Podaci iz xml-a
        }

        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(195,20,'Kontakt informacije',0,1,'C');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(40,10,'Lokacija: Neum, Federacija BiH, BiH',0,2,'L');
        $pdf->Cell(40,10,'Ulica: Ulica Safeta Isovica, br.23',0,2,'L');
        $pdf->Cell(40,10,'Broj telefona: +387 62 111 111',0,2,'L');
        $pdf->Cell(40,10,'Fax: 123 456',0,2,'L');
        $pdf->Cell(40,10,'Email: ebegic2@etf.unsa.ba',0,2,'L');

        $pdf->Output('I', 'Izvjestaj.pdf');
        $veza = null;
        $iskaz = null;
        ob_end_flush();
        exit();
    }
    else
        header('Location: main.php');
}


?>
