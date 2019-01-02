<?php
require('assets/lib/fpdf.php');
class PDF extends FPDF
{
	function Header()
	{
	    $this->SetFont('Arial','B',30);
	    $this->Cell(30,10,'Data Agen');

	    $this->Ln(10);
	    $this->SetFont('Arial','i',10);
	    $this->cell(30,10,'Jl Jatirogo Jawa Timur');


	    $this->Ln(5);
	    $this->SetFont('Arial','i',10);
	    $this->cell(30,10,'Telp/Fax : 0812-xxx-xxx-xxx');
	    $this->Line(10,40,200,40);


	    $this->Ln(5);
	    $this->SetFont('Arial','i',10);
	    $this->cell(30,10,'Data Agen');

	    $this->cell(130);
	    $this->SetFont('Arial','',10);
	    $this->cell(30,10,'Tuban, '.date("d-m-Y").'');

	    $this->Line(10,40,200,40);
	}
	function data_supplier(){
		$this->con=new mysqli ("101.50.1.68","nalindra_N4L1nD7RaPip","*B4nkJ4t1m#","nalindra_str");
		$query=$this->con->query("SELECT * from agen");
		while ($data=$query->fetch_assoc())
		        {
		            $hasil[]=$data;
		        }
		        return $hasil;

	}
	function set_table($header,$data){
		$this->SetFont('Arial','B',9); 
		$this->Cell(10,7,"No",1);
        $this->Cell(40,7,$header[1],1);
        $this->Cell(50,7,$header[0],1);
        $this->Cell(30,7,$header[2],1);
        $this->Cell(30,7,$header[3],1);
        $this->Cell(30,7,$header[4],1);
        $this->Cell(30,7,$header[5],1);
        $this->Cell(30,7,$header[6],1);
    	$this->Ln();

    	$this->SetFont('Arial','',9);
    	$no=1;
	    foreach($data as $row)
	    {
	        $this->Cell(10,7,$no++,1);
	        $this->Cell(40,7,$row['nama_agen'],1);
	        $this->Cell(50,7,$row['alamat'],1);
	        $this->Cell(30,7,$row['facebook'],1);
	        $this->Cell(30,7,$row['instagram'],1);
	        $this->Cell(30,7,$row['whastapp'],1);
	        $this->Cell(30,7,$row['bbm'],1);
	        $this->Cell(30,7,$row['hp'],1);
	        $this->Ln();
	    }
	}
}

$pdf = new PDF();
$pdf->SetTitle('Cetak Data Barang');

$header = array('Alamat', 'Nama Supplier','Facebook' ,'Instagram','Whatsapp','BBM','HP');
$data = $pdf->data_supplier();

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(20);
$pdf->set_table($header,$data);
$pdf->Output('','Nalindra Hijab/Barang/'.date("d-m-Y").'.pdf');
?>
