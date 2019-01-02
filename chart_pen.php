
<script type="text/javascript">
  document.title="Grafik Penjualan";
  document.getElementById('laporan_penjualan').classList.add('active');
</script>
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
  $chart=$root->con->query("select sum(total_bayar) as total from transaksi where month(tgl_transaksi)='$ind'");

  // $data[] = $chart->num_rows;

    while($d=$chart->fetch_array()){
      $data[] = $d['total'];

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