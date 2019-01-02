<?php
require('assets/lib/fpdf.php');
class PDF extends FPDF
{
function Header()
{
    $this->SetFont('Arial','B',30);
    $this->Cell(30,10,'Laporan Detail Pengeluaran');

    $this->Ln(10);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'Jl Jatirogo Jawa Timur');

    $this->cell(80);
    $this->SetFont('Arial','',10);
    $this->cell(30,10,'Tuban, '.base64_decode($_GET['uuid']).'');
    $this->Line(10,40,200,40);

    $this->Line(10,40,200,40);
    $this->Ln(5);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'No Invoice : '.base64_decode($_GET['inf']).'');
    $this->Line(10,40,200,40);
}
function LoadData(){
	$this->con=new mysqli ("101.50.1.68","nalindra_N4L1nD7RaPip","*B4nkJ4t1m#","nalindra_str");
	$id=base64_decode($_GET['oid']);
	$query=$this->con->query("select detail_pengeluaran.id_pengeluaran,pengeluaran_jenis.keterangan,detail_pengeluaran.uang,detail_pengeluaran.no_invoice from detail_pengeluaran inner join pengeluaran_jenis on pengeluaran_jenis.id_pengeluaran_jenis= detail_pengeluaran.id_pengeluaran_jenis where detail_pengeluaran.id_pengeluaran='$id'");

	while ($data=$query->fetch_assoc())
		        {
		            $hasil[]=$data;
		        }
		        return $hasil;
}
function BasicTable($header, $data)
{

    $this->SetFont('Arial','B',12);

        $this->Cell(10,7,$header[0],1);
        $this->Cell(90,7,$header[1],1);
        $this->Cell(50,7,$header[2],1);
    $this->Ln();

    $this->SetFont('Arial','',12);
    foreach($data as $row)
    {
        $this->Cell(10,7,1,1);
        $this->Cell(90,7,$row['keterangan'],1);
        $this->Cell(50,7,"Rp ".number_format($row['uang']),1);
        $this->Ln();
    }

	$id=base64_decode($_GET['oid']);

   $query1=$this->con->query("select * from pengeluaran where id_pengeluaran='$id'");
	$getsum1=$query1->fetch_assoc();
    $this->cell(10,7);
	$this->cell(90,7,'Sub total : ');
	$this->cell(50,7,'Rp. '.number_format($getsum1['total_pengeluaran']).'',1);
	$this->Ln(30);
    $this->SetFont('Arial','',15);
    session_start();
}
}

$pdf = new PDF();
$pdf->SetTitle('Invoice : '.base64_decode($_GET['inf']).'');
$pdf->AliasNbPages();
$header = array('No','Keterangan','Total Biaya');
$data = $pdf->LoadData();
$pdf->AddPage();
$pdf->Ln(20);
$pdf->BasicTable($header,$data);
$filename=base64_decode($_GET['inf']);
$pdf->Output('','Nalindra/'.$filename.'.pdf');
?>
