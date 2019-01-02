<script type="text/javascript">
	<?php
	if ($_SESSION['status']==1) {
		?>
	document.title="Detail laporan_Pengeluaran";
	document.getElementById('laporan_pengeluaran').classList.add('active');
		<?php
	}else{
	?>
	document.title="Detail laporan_Pengeluaran";
	document.getElementById('laporan_pengeluaran').classList.add('active');
	<?php } ?>
</script>

<div class="content">
	<div class="padding">
		<div class="bgwhite">
			<div class="padding">
				<?php
				if ($_SESSION['status']==1) {
				?>
				<h3 class="jdl">Detail Laporan</h3>
				<?php }else{ ?>
				<h3 class="jdl">Detail Transaksi</h3>
				<?php } ?>
				<?php
				$getqheader=$root->con->query("select pengeluaran.id_pengeluaran,pengeluaran.tgl_pengeluaran,pengeluaran.total_pengeluaran,pengeluaran.no_invoice,user.username from pengeluaran inner join user on pengeluaran.kode_kasir=user.id where pengeluaran.id_pengeluaran='$_GET[id_pengeluaran]'");
				$getqheader=$getqheader->fetch_assoc();
				?>
				<table>
					<tr>
						<td><span class="label">Nama Pembeli</span></td><td><span class="label">:</span></td>
						<td><span class="label"><?= $getqheader['username'] ?></span></td>
					</tr>
					<tr>
						<td><span class="label">Tanggal Transaksi</span></td><td><span class="label">:</span></td>
						<td><span class="label"><?= date("d-m-Y",strtotime($getqheader['tgl_pengeluaran'])) ?></span></td>
					</tr>
					<tr>
						<td><span class="label">No Invoice</span></td><td><span class="label">:</span></td>
						<td><span class="label"><?= $getqheader['no_invoice'] ?></span></td>
					</tr>
				</table>
				<table class="datatable" style="width: 100%;">
					<thead>
				<tr>
					<th width="35px">NO</th>
					<th>Keterangan</th>
					<th>Total Biaya</th>
				</tr>
			</thead>
					<tbody>
				<?php
				$trx=date("d")."/AF/".$_SESSION['status']."/".date("y");
				$data=$root->con->query("select detail_pengeluaran.id_pengeluaran,pengeluaran_jenis.keterangan,detail_pengeluaran.uang,detail_pengeluaran.no_invoice from detail_pengeluaran inner join pengeluaran_jenis on pengeluaran_jenis.id_pengeluaran_jenis= detail_pengeluaran.id_pengeluaran_jenis where detail_pengeluaran.id_pengeluaran='$_GET[id_pengeluaran]'");
				$getsum=$root->con->query("select * from pengeluaran where id_pengeluaran='$_GET[id_pengeluaran]'");
				$getsum1=$getsum->fetch_assoc();
				$no=1;
				while ($f=$data->fetch_assoc()) {
					?><tr>
						<td><?= $no++ ?></td>
						<td><?= $f['keterangan'] ?></td>
						<td>Rp. <?= number_format($f['uang']) ?></td>
						</tr>
					<?php
				}
				?>
				<tr>
					<td></td><td>Grand Total :</td><td> Rp. <?= number_format($getsum1['total_pengeluaran']) ?></td>
				</tr>
			</tbody>
				</table>
				<br>
				<div class="left">
					<?php
						$link=($_SESSION['status']==1) ? "laporan_pengeluaran.php" : "pengeluaran.php";
					?>
					<a href="<?= $link ?>" class="btnblue" style="background: #f33155"><i class="fa fa-mail-reply"></i> Kembali</a>
					<?php if ($_SESSION['status']==1) {
					 ?>
					<a href="cetak_nota_peng.php?oid=<?= base64_encode($_GET['id_pengeluaran']) ?>&id-uid=<?= base64_encode($getqheader['username']) ?>&inf=<?= base64_encode($getqheader['no_invoice']) ?>&tb=<?= base64_encode($f['total_pengeluaran']) ?>&uuid=<?= base64_encode(date("d-m-Y",strtotime($getqheader['tgl_pengeluaran']))) ?>" class="btnblue" target="_blank"><i class="fa fa-print"></i> Cetak Nota</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
