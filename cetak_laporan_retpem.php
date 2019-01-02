<?php
require('assets/lib/fpdf.php');
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial','B',30);
        $this->Cell(30,10,'Laporan Detail Return Pembelian');

        $this->Ln(10);
        $this->Ln(5);
        $this->SetFont('Arial','i',10);
        $this->cell(30,10,'Data Laporan Tanggal : '.$_POST['tgl_laporan'].'');

        $this->Ln(5);
        $this->SetFont('Arial','i',10);
        $this->cell(30,10,'Jenis : '.$_POST['jenis_laporan'].'');

        $this->cell(130);
        $this->SetFont('Arial','',10);
        $this->cell(30,10,'Tuban, '.date("d-m-Y").'');

        $this->Line(10,45,200,45);
    }
    function data_barang(){
        $this->con=new mysqli ("101.50.1.68","nalindra_N4L1nD7RaPip","*B4nkJ4t1m#","nalindra_str");
        $tanggal=$_POST['tgl_laporan'];
        if ($_POST['jenis_laporan']=="perhari") {
            $split1=explode('-',$tanggal);
            $tanggal=$split1[2]."-".$split1[1]."-".$split1[0];
            $query=$this->con->query("SELECT return_pembelian.no_invoice,supplier.nama_supplier,user.username,return_pembelian.tgl_return_pembelian,return_pembelian.total_bayar FROM return_pembelian INNER JOIN supplier ON supplier.id_supplier = return_pembelian.id_supplier INNER JOIN user ON user.id = return_pembelian.kode_kasir where return_pembelian.tgl_return_pembelian like '%$tanggal%' order by return_pembelian.id_return_pembelian desc");
        }else{
            $split1=explode('-',$tanggal);
            $tanggal=$split1[1]."-".$split1[0];
            $query=$this->con->query("SELECT return_pembelian.no_invoice,supplier.nama_supplier,user.username,return_pembelian.tgl_return_pembelian,return_pembelian.total_bayar FROM return_pembelian INNER JOIN supplier ON supplier.id_supplier = return_pembelian.id_supplier INNER JOIN user ON user.id = return_pembelian.kode_kasir where return_pembelian.tgl_return_pembelian like '%$tanggal%' order by return_pembelian.id_return_pembelian desc");
        }
        while ($data= $query->fetch_assoc())
                {
                    $hasil[]=$data;
                }
                return $hasil;

    }
    function set_table($data){
        $this->SetFont('Arial','B',9);
        $this->Cell(10,7,"No",1);
        $this->Cell(40,7,"No Invoice",1);
        $this->Cell(40,7,"Supplier",1);
        $this->Cell(20,7,"Kasir",1);
        $this->Cell(40,7,"Tanggal Return",1);
        $this->Cell(40,7,"Total Return",1);
        $this->Ln();

        $this->SetFont('Arial','',9);
        $no=1;
        foreach($data as $row)
        {
            $this->Cell(10,7,$no++,1);
            $this->Cell(40,7,$row['no_invoice'],1);
            $this->Cell(40,7,$row['nama_supplier'],1);
            $this->Cell(20,7,$row['username'],1);
            $this->Cell(40,7,date("d-m-Y h:i:s",strtotime($row['tgl_return_pembelian'])),1);
            $this->Cell(40,7,"Rp. ".number_format($row['total_bayar']),1);
            $this->Ln();
        }
         $tanggal=$_POST['tgl_laporan'];
        if ($_POST['jenis_laporan']=="perhari") {
            $split1=explode('-',$tanggal);
            $tanggal=$split1[2]."-".$split1[1]."-".$split1[0];
            $quer1y=$this->con->query("select sum(return_pembelian.total_bayar) as total  from return_pembelian where return_pembelian.tgl_return_pembelian like '%$tanggal%'");
        }else{
            $split1=explode('-',$tanggal);
            $tanggal=$split1[1]."-".$split1[0];
            $query1=$this->con->query("select sum(return_pembelian.total_bayar) as total  from return_pembelian where return_pembelian.tgl_return_pembelian like '%$tanggal%'");
        }
        while ($data1= $query1->fetch_assoc())
                {
         $this->cell(70);
	    $this->cell(80,7,'Sub total : ');
    	$this->cell(40,7,'Rp. '.number_format($data1['total']).'',1);
                }
    }
}

$pdf = new PDF();
$pdf->SetTitle('Cetak Data Barang');

$data = $pdf->data_barang();

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(20);
$pdf->set_table($data);
$pdf->Output('','Nalindra/Barang/'.date("d-m-Y").'.pdf');
?>