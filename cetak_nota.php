<?php
require('assets/lib/fpdf.php');
class PDF extends FPDF
{
function Header()
{
    $this->SetFont('Arial','B',30);
    $this->Cell(30,10,'Nalindra Hijab Store');

    $this->Ln(10);
    $this->SetFont('Arial','B',15);
    $this->Cell(30,10,'Supplier Hijab Murah Tuban');

    $this->Ln(10);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'Jln.Sumber Indah 957 Wotsogo,Jatirogo');

    $this->cell(80);
    $this->SetFont('Arial','',10);
    $this->cell(30,10,'Tuban, '.base64_decode($_GET['uuid']).'');
    $this->Line(10,50,200,50);

    $this->Ln(5);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'Telp/Fax : 0812-xxx-xxx-xxx');
    $this->Line(10,50,200,50);

    $this->Cell(80);
    $this->SetFont('Arial','u',15);
    $this->Cell(30,10,'Kepada : '.base64_decode($_GET['id-uid']).'',0,'C');

    $this->Ln(5);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'No Invoice : '.base64_decode($_GET['inf']).'');
    $this->Line(10,50,200,50);
}
function LoadData(){
	$this->con=new mysqli ("101.50.1.68","nalindra_N4L1nD7RaPip","*B4nkJ4t1m#","nalindra_str");
	$id=base64_decode($_GET['oid']);
	$query=$this->con->query("select sub_transaksi.jumlah_beli,barang.nama_barang,barang.harga_jual,sub_transaksi.total_harga,sub_transaksi.diskon,sub_transaksi.harga_set from sub_transaksi inner join barang on barang.id_barang=sub_transaksi.id_barang where sub_transaksi.id_transaksi='$id'");

	while ($data=$query->fetch_assoc())
		        {
		            $hasil[]=$data;
		        }
		        return $hasil;
}
function BasicTable($header, $data)
{

    $this->SetFont('Arial','B',9);
        
        $this->Cell(50,7,$header[0],1);
        $this->Cell(10,7,$header[1],1);
        $this->Cell(30,7,$header[2],1);
        $this->Cell(15,7,$header[3],1);
        $this->Cell(40,7,$header[4],1);
        $this->Cell(30,7,$header[5],1);
    $this->Ln();

    $this->SetFont('Arial','',9);
    foreach($data as $row)
    {
        
        $this->Cell(50,7,$row['nama_barang'],1);
        $this->Cell(10,7,$row['jumlah_beli'],1);
        $this->Cell(30,7,"Rp ".number_format($row['harga_jual']),1);
        $this->Cell(15,7,$row['diskon'],1);
        $this->Cell(40,7,"Rp ".number_format($row['harga_set']),1);
        $this->Cell(30,7,"Rp ".number_format($row['total_harga']),1);
        $this->Ln();
    }


	$id=base64_decode($_GET['oid']);

   $query1=$this->con->query("select sum(total_harga) as grand_total,sum(jumlah_beli) as jumlah_beli from sub_transaksi where id_transaksi='$id'");
	$getsum1=$query1->fetch_assoc();
	$query3=$this->con->query("select * from transaksi where id_transaksi='$id'");
	$pengsub=$query3->fetch_assoc();
	
		
	$this->cell(15);
	$this->cell(90);
	$this->cell(40,7,'Sub total : ');
	$this->cell(30,7,'Rp. '.number_format($getsum1['grand_total']).'',1);
	$this->Ln();
		$this->cell(15);
	$this->cell(90);
	$this->cell(40,7,'Biaya Pengiriman : ');
	$this->cell(30,7,'Rp. '.number_format($pengsub['biaya_pengiriman']).'',1);
		$this->Ln();
			$this->cell(15);
	$this->cell(90);
	$this->cell(40,7,'Grand Total : ');
	$this->cell(30,7,'Rp. '.number_format($pengsub['biaya_pengiriman']+$getsum1['grand_total']).'',1);
	$this->Ln(30);
    $this->SetFont('Arial','',15);
    session_start();
    $this->cell(30,-10,'Diterima Oleh : '.$_SESSION['username'].'');
    $this->Ln(10);
    $this->SetFont('Arial','',11);
    $this->cell(30,-10,'Facebook: Sulis Bakur Jilbab');
       $this->Ln(10);
    $this->cell(30,-10,'Fanspage: Nalindra Hijab Store');
      $this->Ln(10);
    $this->cell(30,-10,'ig: @nalindrahijab_store');
}
}

$pdf = new PDF();
$pdf->SetTitle('Invoice : '.base64_decode($_GET['inf']).'');
$pdf->AliasNbPages();
$header = array('Nama Barang','Jml','Harga','Diskon','Harga Setelah Diskon' ,'Total Harga');
$data = $pdf->LoadData();
$pdf->AddPage();
$pdf->Ln(20);
$pdf->BasicTable($header,$data);
$filename=base64_decode($_GET['inf']);
$pdf->Output('','Nalindra/'.$filename.'.pdf');
?>
