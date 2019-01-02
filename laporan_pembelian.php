<?php include "head.php" ?>
<?php
	if (isset($_GET['action']) && $_GET['action']=="detail_pembelian") {
		include "detail_pembelian.php";
	}elseif (isset($_GET['action']) && $_GET['action']=="chart_pem") {
		include "chart_pem.php";
	}
	else{
?>
<script type="text/javascript">
	document.title="Laporan Pembelian Barang";
	document.getElementById('laporan_pembelian').classList.add('active');
</script>

<div class="content">
	<div class="padding">
		<div class="bgwhite">
			<div class="padding">
			<div class="contenttop">
				<div class="left">
					<h3 class="jdl">Laporan Pembelian Barang</h3>
				</div>
				<div class="right">
					<script type="text/javascript">
						function gotojenis(val){
							var value=val.options[val.selectedIndex].value;
							window.location.href="laporan_pembelian.php?jenis="+value+"";
						}
						function gotofilter(val){
							var value=val.options[val.selectedIndex].value;
							
							window.location.href="laporan_pembelian.php?jenis=<?php if (isset($_GET['jenis'])) {
								echo $_GET['jenis'];
							} ?>&filter_record="+value;
						}
					</script>
					<span style="float: left;
    padding: 5px;
    margin-right: 10px;
    color: #666;">Filter dan cetak :</span>
    <form action="cetak_laporan_pembelian.php" style="display: inline;" target="_blank" method="post">
					<select class="leftin1" onchange="gotojenis(this)" name="jenis_laporan" required="required">
						<option>Pilih Jenis</option>
						<option value="perhari" <?php if (isset($_GET['jenis'])&&$_GET['jenis']=='perhari'){ echo "selected"; } ?>>Perhari</option>
						<option value="perbulan" <?php if (isset($_GET['jenis'])&&$_GET['jenis']=='perbulan'){ echo "selected"; } ?>>Perbulan</option>
					</select>
					<select class="leftin1" onchange="gotofilter(this)" required="required" name="tgl_laporan">
						<?php
							if (isset($_GET['jenis'])&&$_GET['jenis']=='perhari') {
								?>
								<option>Pilih Hari</option>
								<?php
								$data=$root->con->query("select distinct date(tgl_add) as tgl_add from tempo_pem order by tgl_add desc");
								while ($f=$data->fetch_assoc()) {
									?>
										<option <?php if (isset($_GET['filter_record'])) { if ($_GET['filter_record'] == date('d-m-Y',strtotime($f['tgl_add']))) { echo "selected"; } } ?> value="<?= date('d-m-Y',strtotime($f['tgl_add'])) ?>"><?= date('d-m-Y',strtotime($f['tgl_add'])) ?></option>
									<?php
								}
							}else if(isset($_GET['jenis'])&&$_GET['jenis']=='perbulan') {
						?>
						<option value="">Pilih Bulan</option>
						<?php
							$data=$root->con->query("select distinct EXTRACT(YEAR FROM tgl_add) AS OrderYear,EXTRACT(MONTH FROM tgl_add) AS OrderMonth from tempo_pem order by tgl_add desc");
							while ($f=$data->fetch_assoc()) {
								?>
									<option <?php if (isset($_GET['filter_record'])) { 

										if($f['OrderMonth']<=9){
										$aaaa="0".$f['OrderMonth']."-".$f['OrderYear'];
									}else{
										$aaaa=$f['OrderMonth']."-".$f['OrderYear'];
									}

										if ($_GET['filter_record'] == $aaaa) { 
											echo "selected"; } } ?> 
									value="<?php 
									if($f['OrderMonth']<=9){
										echo "0".$f['OrderMonth']."-".$f['OrderYear'];
									}else{
										echo $f['OrderMonth']."-".$f['OrderYear'];
									} ?>"><?php 
									if($f['OrderMonth']<=9){
										echo "0".$f['OrderMonth']."-".$f['OrderYear'];
									}else{
										echo $f['OrderMonth']."-".$f['OrderYear'];
									}
									?></option>
								<?php
							}
							}else{
								echo "<option>Pilih Jenis Cetak terlebih dahulu</option>";
							}
						?>
					</select>
					<button class="btn-ctk" style="background: #41b3f9;color: #fff;border-radius: 3px;border-color: #41b3f9;border:1px solid #41b3f9" <?php if (isset($_GET['filter_record'])) {}else{ ?> disabled="disabled" title="Pilih jenis dan tanggal lebih dulu"<?php } ?>>Cetak</button>
					<a href="?action=chart_pem" class="btnblue" style="background: #f33155"><i class="fa fa-mail-reply"></i>Grafik</a>
					</form>
				</div>
				<div class="both"></div>
			</div>
			<table class="datatable" id="datatable">
				<thead>
				<tr>
					<th width="10px">#</th>
					<th>Tanggal Transaksi</th>
					<th>Nama Barang</th>
					<th>Stok</th>
					<th>Harga Beli</th>
					<th>Total</th>
					<th width="60px">Aksi</th>
				</tr>
			</thead>
			<tbody>
					<?php
					if (isset($_GET['filter_record'])) {
						if ($_GET['jenis']=='perhari') {
							$aksi1=1;
						}else{
							$aksi1=2;
						}
						$root->filter_tampil_laporan_pembelian($_GET['filter_record'],$aksi1);
					}else{
					$root->tampil_laporan_pembelian();
					}
					?>
</tbody>

			</table>
			</div>
		</div>
	</div>
</div>


<?php 
}
include "foot.php" ?>
