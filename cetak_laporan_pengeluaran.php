<?php
require('assets/lib/fpdf.php');
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial','B',30);
        $this->Cell(30,10,'Laporan Detail Pengeluaran');

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
            $query=$this->con->query("select pengeluaran.id_pengeluaran,pengeluaran.tgl_pengeluaran,pengeluaran.total_pengeluaran,pengeluaran.no_invoice,user.username from pengeluaran inner join user on pengeluaran.kode_kasir=user.id where pengeluaran.tgl_pengeluaran like '%$tanggal%' order by pengeluaran.id_pengeluaran desc");
        }else{
            $split1=explode('-',$tanggal);
            $tanggal=$split1[1]."-".$split1[0];
            $query=$this->con->query("select pengeluaran.id_pengeluaran,pengeluaran.tgl_pengeluaran,pengeluaran.total_pengeluaran,pengeluaran.no_invoice,user.username from pengeluaran inner join user on pengeluaran.kode_kasir=user.id where pengeluaran.tgl_pengeluaran like '%$tanggal%' order by pengeluaran.id_pengeluaran desc");
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
        $this->Cell(20,7,"Kasir",1);
        $this->Cell(40,7,"Tanggal Transaksi",1);
        $this->Cell(40,7,"Total Bayar",1);
        $this->Ln();

        $this->SetFont('Arial','',9);
        $no=1;
        foreach($data as $row)
        {
            $this->Cell(10,7,$no++,1);
            $this->Cell(40,7,$row['no_invoice'],1);
            $this->Cell(20,7,$row['username'],1);
            $this->Cell(40,7,date("d-m-Y h:i:s",strtotime($row['tgl_pengeluaran'])),1);
            $this->Cell(40,7,"Rp. ".number_format($row['total_pengeluaran']),1);
            $this->Ln();
        }
         $tanggal=$_POST['tgl_laporan'];
        if ($_POST['jenis_laporan']=="perhari") {
            $split1=explode('-',$tanggal);
            $tanggal=$split1[2]."-".$split1[1]."-".$split1[0];
            $quer1y=$this->con->query("select sum(pengeluaran.total_pengeluaran) as total  from pengeluaran where pengeluaran.tgl_pengeluaran like '%$tanggal%'");
        }else{
            $split1=explode('-',$tanggal);
            $tanggal=$split1[1]."-".$split1[0];
            $query1=$this->con->query("select sum(pengeluaran.total_pengeluaran) as total  from pengeluaran where pengeluaran.tgl_pengeluaran like '%$tanggal%'");
        }
        while ($data1= $query1->fetch_assoc())
                {
         $this->cell(70);
	    $this->cell(40,7,'Sub total : ');
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
