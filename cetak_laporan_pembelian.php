<?php
require('assets/lib/fpdf.php');
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial','B',30);
        $this->Cell(30,10,'Laporan Pembelian Barang');


        $this->Ln(10);
        $this->SetFont('Arial','i',10);
        $this->cell(30,10,'Data Laporan Tanggal : '.$_POST['tgl_laporan'].'');

        $this->Ln(5);
        $this->SetFont('Arial','i',10);
        $this->cell(30,10,'Jenis : '.$_POST['jenis_laporan'].'');

        $this->cell(130);
        $this->SetFont('Arial','',10);
        $this->cell(30,10,'Tuban, '.date("d-m-Y").'');

        $this->Line(10,35,200,35);
    }
    function data_barang(){
        $this->con=new mysqli ("101.50.1.68","nalindra_N4L1nD7RaPip","*B4nkJ4t1m#","nalindra_str");
        $tanggal=$_POST['tgl_laporan'];
        if ($_POST['jenis_laporan']=="perhari") {
            $split1=explode('-',$tanggal);
            $tanggal=$split1[2]."-".$split1[1]."-".$split1[0];
            $query=$this->con->query("select * from tempo_pem where tgl_add like '%$tanggal%' order by tgl_add desc");
        }else{
            $split1=explode('-',$tanggal);
            $tanggal=$split1[1]."-".$split1[0];
            $query=$this->con->query("select * from tempo_pem where tgl_add like '%$tanggal%' order by tgl_add desc");
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
        $this->Cell(40,7,"Tanggal Pembelian",1);
        $this->Cell(70,7,"Nama Barang",1);
        $this->Cell(20,7,"Stok",1);
        $this->Cell(50,7,"Harga Beli",1);
        $this->Ln();

        $this->SetFont('Arial','',9);
        $no=1;
        foreach($data as $row)
        {
            $this->Cell(10,7,$no++,1);
            $this->Cell(40,7,date("d-m-Y h:i:s",strtotime($row['tgl_add'])),1);
            $this->Cell(70,7,$row['nama_barang'],1);
            $this->Cell(20,7,$row['stok'],1);     
            $this->Cell(50,7,"Rp. ".number_format($row['harga_beli']),1);
            $this->Ln();
        }
         $tanggal=$_POST['tgl_laporan'];
        if ($_POST['jenis_laporan']=="perhari") {
            $split1=explode('-',$tanggal);
            $tanggal=$split1[2]."-".$split1[1]."-".$split1[0];
            $query1=$this->con->query("select tgl_add,nama_barang,stok,harga_beli,sum(harga_beli) as total from tempo_pem where tgl_add like '%$tanggal%' order by tgl_add desc");
        }else{
            $split1=explode('-',$tanggal);
            $tanggal=$split1[1]."-".$split1[0];
            $query1=$this->con->query("select tgl_add,nama_barang,stok,harga_beli,sum(harga_beli) as total from tempo_pem where tgl_add like '%$tanggal%' order by tgl_add desc");
        }
          while ($data1= $query1->fetch_assoc())
                {
        	$this->cell(70);
	$this->cell(70,7,'Sub total : ');
	$this->cell(50,7,'Rp. '.number_format($data1['total']).'',1);
                }
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
