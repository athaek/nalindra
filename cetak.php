<?php
require('assets/lib/fpdf.php');
class PDF extends FPDF
{

    function data_barang(){
        $tglawal = $_POST['tgl1']; 
        $this->con=new mysqli ("101.50.1.68","nalindra_N4L1nD7RaPip","*B4nkJ4t1m#","nalindra_str");
        $query=$this->con->query("select detail_pengeluaran.uang,pengeluaran_jenis.keterangan,pengeluaran.total_pengeluaran,pengeluaran.tgl_pengeluaran from detail_pengeluaran inner join pengeluaran_jenis on pengeluaran_jenis.id_pengeluaran_jenis=detail_pengeluaran.id_pengeluaran_jenis inner join pengeluaran on pengeluaran.id_pengeluaran = detail_pengeluaran.id_pengeluaran where month(pengeluaran.tgl_pengeluaran)='$tglawal'");
        while ($data= $query->fetch_assoc())
                {
                    $hasil[]=$data;
                }
                return $hasil;


    }
    
    
    function set_table($data,$data1){
         $this->SetFont('Arial','B',30);
        $this->Cell(30,0,'Laporan Detail Laba Rugi');

        $this->Ln(5);
        $this->Ln(10);
        $this->SetFont('Arial','',10);
        $this->cell(30,0,'Tuban, '.date("d-m-Y").'');

        $this->Line(10,35,200,35);
        $this->Line(10,35,200,35);
        $this->Ln(5);
        
        $this->SetFont('Arial','B',11);
        $this->Cell(190,7,"Pendapatan Perbulan",1);
        $this->Ln();

        $this->SetFont('Arial','',9);
        $no=1;
         $tgl2=  $_POST['tgl1']; 
         $q2 = $this->con->query("select sum(detail_pengeluaran.uang) as total_peng,pengeluaran_jenis.keterangan,pengeluaran.total_pengeluaran,pengeluaran.tgl_pengeluaran from detail_pengeluaran inner join pengeluaran_jenis on pengeluaran_jenis.id_pengeluaran_jenis=detail_pengeluaran.id_pengeluaran_jenis inner join pengeluaran on pengeluaran.id_pengeluaran = detail_pengeluaran.id_pengeluaran where month(pengeluaran.tgl_pengeluaran)='$tgl2'");
         $data2 = $q2->fetch_assoc();
        //penualan
         $q1 = $this->con->query("select SUM(total_bayar) AS total from transaksi where month(tgl_transaksi)='$tgl2'");
           $data1 = $q1->fetch_assoc();
           
          $contoh = $this->con->query("select * from transaksi where month(tgl_transaksi)='$tgl2'");
            	while ($d=$contoh->fetch_assoc()) {
             $this->Cell(110,7,$d['nama_pembeli'],1);   
            $this->Cell(80,7,"Rp. ".number_format($d['total_bayar']),1);
            $this->Ln();
        

            	}
        $this->SetFont('Arial','B',11);
        $this->Cell(50);
         $this->Cell(60,7,"Total Penjualan",1);   
            $this->Cell(80,7,"Rp. ".number_format($data1['total']),1);
            $this->Ln();
            
            //return penjualan
             $this->SetFont('Arial','B',11);
        $this->Cell(190,7,"Return Penjualan",1);
        $this->Ln();
        $this->SetFont('Arial','',9);
         $r = $this->con->query("select * from return_penjualan where month(tgl_return_penjualan)='$tgl2'");
            	while ($dr=$r->fetch_assoc()) {
             $this->Cell(110,7,$dr['nama_pembeli'],1);   
            $this->Cell(80,7,"Rp. ".number_format($dr['total_bayar'],1));
            $this->Ln();
            	}
            	
            	 $r1 = $this->con->query("SELECT SUM(total_bayar) as rtotal FROM return_penjualan where month(tgl_return_penjualan)='$tgl2'");
            	  $dr1=$r1->fetch_assoc();
            	   $this->SetFont('Arial','B',11);
        $this->Cell(50);
         $this->Cell(60,7,"Total Return Penjualan",1);   
            $this->Cell(80,7,"Rp. ".number_format($dr1['rtotal']),1);
            $this->Ln();
            	 //pembelian
               $this->SetFont('Arial','B',11);
        $this->Cell(190,7,"Pembelian Perbulan",1);
        $this->Ln();
         $this->SetFont('Arial','',9);
            $p = $this->con->query("select * from tempo_pem where month(tgl_add)='$tgl2'");
            	while ($dp=$p->fetch_assoc()) {
             $this->Cell(110,7,$dp['nama_barang'],1);   
            $this->Cell(80,7,"Rp. ".number_format($dp['harga_beli']*$dp['stok']),1);
            $this->Ln();
            	}
            		   $p1 = $this->con->query("select SUM(harga_beli * stok) as ptotal from tempo_pem where month(tgl_add)='$tgl2'");
            	  $dp1=$p1->fetch_assoc();
            	   $this->SetFont('Arial','B',11);
        $this->Cell(50);
         $this->Cell(60,7,"Total Pembelian",1);   
            $this->Cell(80,7,"Rp. ".number_format($dp1['ptotal']),1);
            $this->Ln();
            //total laba kotor
            $this->SetFont('Arial','B',11);
        $this->Cell(50);
         $this->Cell(60,7,"Total Pembelian",1);   
            $this->Cell(80,7,"Rp. ".number_format($data1['total']-$dr1[rtotal]-$dp1['ptotal']),1);
            $this->Ln();
            

         $this->SetFont('Arial','B',11);
        $this->Cell(190,7,"Pengeluaran Perbulan",1);
        $this->Ln();
        $this->SetFont('Arial','',9);
        $no=1;
        foreach($data as $row)
        {
            $this->Cell(110,7,$row['keterangan'],1);   
            $this->Cell(80,7,"Rp. ".number_format($row['uang']),1);
            $this->Ln();
        }
        $tgl1=  $_POST['tgl1']; 
        $sumdata1 = $this->con->query("select sum(detail_pengeluaran.uang) as total2, detail_pengeluaran.uang,pengeluaran_jenis.keterangan,pengeluaran.total_pengeluaran,pengeluaran.tgl_pengeluaran from detail_pengeluaran inner join pengeluaran_jenis on pengeluaran_jenis.id_pengeluaran_jenis=detail_pengeluaran.id_pengeluaran_jenis inner join pengeluaran on pengeluaran.id_pengeluaran = detail_pengeluaran.id_pengeluaran where month(pengeluaran.tgl_pengeluaran)='$tgl2'");
        $getsum1 = $sumdata1->fetch_assoc();
          $this->SetFont('Arial','B',11);
        $this->Cell(50);
         $this->Cell(60,7,"Total Pengeluaran",1);   
            $this->Cell(80,7,"Rp. ".number_format($getsum1['total2']),1);
            $this->Ln();
            $this->SetFont('Arial','B',9);
         $this->Cell(110,7,"Total Laba Bersih",1);   
            $this->Cell(80,7,"Rp. ".number_format($data1['total']-$dr1[rtotal]-$dp1['ptotal']-$getsum1['total2']),1);
            $this->Ln();


    }
}

$pdf = new PDF();
$pdf->SetTitle('Cetak Pembelian Barang');

$data = $pdf->data_barang();


$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(20);
$pdf->set_table($data);
$pdf->Output('','Nalindra/Barang/'.date("d-m-Y").'.pdf');
?>
