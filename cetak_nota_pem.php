<?php
require('assets/lib/fpdf.php');
class PDF extends FPDF
{
function Header()
{
    $this->SetFont('Arial','B',30);
    $this->Cell(30,10,'Kuitansi Pembelian');

    $this->Ln(10);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'Jl Jatirogo Jawa Timur');

    $this->cell(80);
    $this->SetFont('Arial','',10);
    $this->cell(30,10,'Tuban, '.base64_decode($_GET['uuid']).'');
    $this->Line(10,40,200,40);

    $this->Ln(5);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'Telp/Fax : 0812-xxx-xxx-xxx');
    $this->Line(10,40,200,40);

    $this->Ln(5);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'No Invoice : '.base64_decode($_GET['inf']).'');
    $this->Line(10,40,200,40);
}
function LoadData(){
	$this->con=new mysqli ("101.50.1.68","nalindra_N4L1nD7RaPip","*B4nkJ4t1m#","nalindra_str");
	$id=base64_decode($_GET['oid']);
	$query=$this->con->query("select tempo_pem.id_subpem,tempo_pem.tgl_add,tempo_pem.nama_barang,kategori.nama_kategori,tempo_pem.stok,tempo_pem.harga_beli,tempo_pem.harga_jual from tempo_pem inner join kategori on kategori.id_kategori = tempo_pem.id_kategori where tempo_pem.id_subpem ='$id'");

	while ($data=$query->fetch_assoc())
		        {
		            $hasil[]=$data;
		        }
		        return $hasil;
}
function BasicTable($header, $data)
{

    $this->SetFont('Arial','B',12);
        $this->Cell(20,7,$header[0],1);
        $this->Cell(90,7,$header[1],1);
        $this->Cell(40,7,$header[2],1);

    $this->Ln();

    $this->SetFont('Arial','',12);
    foreach($data as $row)
    {
        $this->Cell(20,7,$row['stok'],1);
        $this->Cell(90,7,$row['nama_barang'],1);
        $this->Cell(40,7,"Rp ".number_format($row['harga_beli']),1);

        $this->Ln();
    }

	$id1=base64_decode($_GET['oid']);

    $query2=$this->con->query("select * from tempo_pem where id_subpem='$id1'");
	$getsum1=$query2->fetch_array();

	$this->cell(70);
	$this->cell(40,7,'Sub total : ');
	$this->cell(40,7,'Rp. '.number_format($getsum1['harga_beli']).'',1);
	$this->Ln(30);
    $this->SetFont('Arial','',15);
    session_start();
    $this->cell(30,-10,'Diterima Oleh : '.$_SESSION['username'].'');
    $this->Ln(10);
    $this->SetFont('Arial','',11);

}
}

$pdf = new PDF();
$pdf->SetTitle('Invoice : '.base64_decode($_GET['inf']).'');
$pdf->AliasNbPages();
$header = array('Jumlah', 'Nama Barang','Harga' ,'Total Harga');
$data = $pdf->LoadData();
$pdf->AddPage();
$pdf->Ln(20);
$pdf->BasicTable($header,$data);
$filename=base64_decode($_GET['inf']);
$pdf->Output('','Nalindra/'.$filename.'.pdf');
?>
