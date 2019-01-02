<?php include "head.php"; ?>
<script type="text/javascript">
	document.title="Dashboard";
	document.getElementById('dash').classList.add('active');
</script>
<div class="content">
	<div class="padding">
		<div class="box">
			<div class="padding">
			<i class="fa fa-user"></i>
			Login sebagai
			<span class="status greend">

				<?php if ($_SESSION['status']==1) {
					echo "Admin";
				}else{
					echo "Kasir";
					} ?>
			</span>
			</div>
		</div>
		<?php 
					$saldo=$root->con->query("select * from jumlah_saldo");
					$tsaldo=$saldo->fetch_assoc();
					
		 ?>
		<div class="box">
			<div class="padding">
				<i class="fa fa-money"></i>
				Saldo
				<span class="status blued">Rp. <?= number_format($tsaldo['saldo']); ?> </span>

			</div>
		</div>
		<div class="box">
			<div class="padding">
				<i class="fa fa-bars"></i>
				Data Barang
				<span class="status blued"><?= $root->show_jumlah_barang() ?></span>
			</div>
		</div>

		<div class="box">
			<div class="padding">
				<i class="fa fa-book"></i>
				Laporan Laba Rugi
				<span class="status blued"><a href="labarugi.php">Cetak</a></span>
			</div>
		</div>

	</div>
</div>
<?php 
  $bulan = array('01'=>"Januari",'02'=>"Februari", '03'=>"Maret", '04'=>"April", '05'=>"Mei", '06'=>"Juni", '07'=>"Juli", '08'=>"Agustus", '09'=>"September", '10'=>"Oktober", '11'=>"November", '12'=>"Desember");
?>


<div class="content">
  <div class="padding">
    <div class="bgwhite">
      <div class="padding">
  
<?php 
foreach ($bulan as $ind=>$bulan1) {
  $nama[] = $bulan1;
  $chart=$root->con->query("select sub_transaksi.jumlah_beli,sub_transaksi.total_harga,barang.harga_beli,transaksi.tgl_transaksi, sum(total_harga) as total,sum(harga_beli * jumlah_beli) as total1 from sub_transaksi inner join barang on barang.id_barang = sub_transaksi.id_barang inner join transaksi on transaksi.id_transaksi = sub_transaksi.id_transaksi where month(transaksi.tgl_transaksi)='$ind'");

    while($d=$chart->fetch_array()){
      $data[] =$d['total']-$d['total1'];

    }
   
   
}
 ?>

 <div class="chart">
   <canvas id="myChart" width="400" height="200"></canvas>
 </div>
</div>
</div>
</div>
</div>

<script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($nama); ?>,
        datasets: [{
            label: 'Transaksi',
            data: <?php echo json_encode($data); ?>,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255,99,132,1)',
            borderWidth: 1
        }]
    },
    options: {
        'legend' : false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
<?php include"foot.php" ?>
