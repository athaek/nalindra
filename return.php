<?php include "head.php" ?>
<?php
	if (isset($_GET['action']) && $_GET['action']=="detail_return_pembelian") {
		include "detail_return_pembelian.php";
	}else if (isset($_GET['action']) && $_GET['action']=="detail_return_penjualan") {
		include "detail_return_penjualan.php";
	}
	else{
?>
<script type="text/javascript">
	document.title="Return";
	document.getElementById('return').classList.add('active');
</script>

<div class="content">
	<div class="padding">
		<div class="bgwhite">
			<div class="padding">
			<div class="contenttop">
				<div class="left">
					<h3 class="jdl">Laporan Return Pembelian</h3>
				</div>
				<div class="right">
					<script type="text/javascript">
						function gotojenis(val){
							var value=val.options[val.selectedIndex].value;
							window.location.href="return.php?jenis="+value+"";
						}
						function gotofilter(val){
							var value=val.options[val.selectedIndex].value;
							
							window.location.href="return.php?jenis=<?php if (isset($_GET['jenis'])) {
								echo $_GET['jenis'];
							} ?>&filter_record="+value;
						}
					</script>
					<span style="float: left;
    padding: 5px;
    margin-right: 10px;
    color: #666;">Filter dan cetak :</span>
    <form action="cetak_laporan_retpem.php" style="display: inline;" target="_blank" method="post">
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
								$data=$root->con->query("select distinct date(tgl_return_pembelian) as tgl_return_pembelian from return_pembelian order by id_return_pembelian desc");
								while ($f=$data->fetch_assoc()) {
									?>
										<option <?php if (isset($_GET['filter_record'])) { if ($_GET['filter_record'] == date('d-m-Y',strtotime($f['tgl_return_pembelian']))) { echo "selected"; } } ?> value="<?= date('d-m-Y',strtotime($f['tgl_return_pembelian'])) ?>"><?= date('d-m-Y',strtotime($f['tgl_return_pembelian'])) ?></option>
									<?php
								}
							}else if(isset($_GET['jenis'])&&$_GET['jenis']=='perbulan') {
						?>
						<option value="">Pilih Bulan</option>
						<?php
							$data=$root->con->query("select distinct EXTRACT(YEAR FROM tgl_return_pembelian) AS OrderYear,EXTRACT(MONTH FROM tgl_return_pembelian) AS OrderMonth from return_pembelian order by id_return_pembelian desc");
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
					</form>
				</div>
				<div class="both"></div>
			</div>
			<table class="datatable" id="datatable">
				<thead>
				<tr>
					<th width="10px">#</th>
					<th>No Invoice</th>
					<th>Kasir</th>
					<th>Supplier</th>
					<th>Tanggal Transaksi</th>
					<th>Total Pembelian</th>
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
						$root->filter_tampil_laporan_return_pembelian($_GET['filter_record'],$aksi1);
					}else{
					$root->tampil_laporan_return_pembelian();
					}
					?>
</tbody>

			</table>
			</div>
		</div>
	</div>
</div>

<div class="content">
	<div class="padding">
		<div class="bgwhite">
			<div class="padding">
			<div class="contenttop">
				<div class="left">
					<h3 class="jdl">Laporan return penjualan</h3>
				</div>
				<div class="right">
					<script type="text/javascript">
						function gotojenis1(val1){
							var value=val1.options[val1.selectedIndex].value;
							window.location.href="return.php?jenis1="+value+"";
						}
						function gotofilter1(val1){
							var value=val1.options[val1.selectedIndex].value;
							
							window.location.href="return.php?jenis1=<?php if (isset($_GET['jenis1'])) {
								echo $_GET['jenis1'];
							} ?>&filter_record1="+value;
						}
					</script>
					<span style="float: left;
    padding: 5px;
    margin-right: 10px;
    color: #666;">Filter dan cetak :</span>
    <form action="cetak_laporan_retpen.php" style="display: inline;" target="_blank" method="post">
					<select class="leftin1" onchange="gotojenis1(this)" name="jenis_laporan1" required="required">
						<option>Pilih Jenis</option>
						<option value="perhari1" <?php if (isset($_GET['jenis1'])&&$_GET['jenis1']=='perhari1'){ echo "selected"; } ?>>Perhari</option>
						<option value="perbulan1" <?php if (isset($_GET['jenis1'])&&$_GET['jenis1']=='perbulan1'){ echo "selected"; } ?>>Perbulan</option>
					</select>
					<select class="leftin1" onchange="gotofilter1(this)" required="required" name="tgl_laporan1">
						<?php
							if (isset($_GET['jenis1'])&&$_GET['jenis1']=='perhari1') {
								?>
								<option>Pilih Hari</option>
								<?php
								$data=$root->con->query("select distinct date(tgl_return_penjualan) as tgl_return_penjualan from return_penjualan order by id_return_penjualan desc");
								while ($f=$data->fetch_assoc()) {
									?>
										<option <?php if (isset($_GET['filter_record1'])) { if ($_GET['filter_record1'] == date('d-m-Y',strtotime($f['tgl_return_penjualan']))) { echo "selected"; } } ?> value="<?= date('d-m-Y',strtotime($f['tgl_return_penjualan'])) ?>"><?= date('d-m-Y',strtotime($f['tgl_return_penjualan'])) ?></option>
									<?php
								}
							}else if(isset($_GET['jenis1'])&&$_GET['jenis1']=='perbulan1') {
						?>
						<option value="">Pilih Bulan</option>
						<?php
							$data=$root->con->query("select distinct EXTRACT(YEAR FROM tgl_return_penjualan) AS OrderYear,EXTRACT(MONTH FROM tgl_return_penjualan) AS OrderMonth from return_penjualan order by id_return_penjualan desc");
							while ($f=$data->fetch_assoc()) {
								?>
									<option <?php if (isset($_GET['filter_record1'])) { 

										if($f['OrderMonth']<=9){
										$aaaa="0".$f['OrderMonth']."-".$f['OrderYear'];
									}else{
										$aaaa=$f['OrderMonth']."-".$f['OrderYear'];
									}

										if ($_GET['filter_record1'] == $aaaa) { 
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
					<button class="btn-ctk" style="background: #41b3f9;color: #fff;border-radius: 3px;border-color: #41b3f9;border:1px solid #41b3f9" <?php if (isset($_GET['filter_record1'])) {}else{ ?> disabled="disabled" title="Pilih jenis dan tanggal lebih dulu"<?php } ?>>Cetak</button>
					</form>
				</div>
				<div class="both"></div>
			</div>
			<table class="datatable" id="datatable">
				<thead>
				<tr>
					<th width="10px">#</th>
					<th>No Invoice</th>
					<th>Kasir</th>
					<th>Nama</th>
					<th>Tanggal Transaksi</th>
					<th>Total Pembelian</th>
					<th width="60px">Aksi</th>
				</tr>
			</thead>
			<tbody>
					<?php
					if (isset($_GET['filter_record1'])) {
						if ($_GET['jenis1']=='perhari1') {
							$aksi1=1;
						}else{
							$aksi1=2;
						}
						$root->filter_tampil_laporan_return_penjualan($_GET['filter_record1'],$aksi1);
					}else{
					$root->tampil_laporan_return_penjualan();
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
