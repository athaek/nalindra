<?php include "head.php" ?>
<?php
	if (isset($_GET['action']) && $_GET['action']=="transaksi_baru") {
		include "pembelian_baru.php";
	}
	else if (isset($_GET['action']) && $_GET['action']=="detail_pembelian") {
		include "detail_pembelian.php";
	}
	else if (isset($_GET['action']) && $_GET['action']=="return_pembelian") {
		include "return_pembelian.php";
	}

	else{
?>
<script type="text/javascript">
	document.title="Pembelian";
	document.getElementById('pembelian').classList.add('active');
</script>
<div class="content">
	<div class="padding">
		<div class="bgwhite">
			<div class="padding">
			<div class="contenttop">
				<div class="left">
					<a href="?action=return_pembelian" class="btnblue" style="background: #f33155"><i class="fa fa-mail-reply"></i> Return Pembelian</a>
				</div>
				<div class="both"></div>
			</div>
			<span class="label">Jumlah Transaksi : <?= $root->show_jumlah_barang() ?></span>
			<table class="datatable">
				<thead>
				<tr>
					<th width="35px">NO</th>
					<th>Tanggal Transaksi</th>
					<th>Nama Barang</th>
					<th>Stok</th>
					<th>Harga beli</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no=1;
				
				$q=$root->con->query("select * from tempo_pem");
				if ($q->num_rows > 0) {
				while ($f=$q->fetch_assoc()) {
					?>
					<tr>
						<td><?= $no++ ?></td>
						<td><?= date("d-m-Y",strtotime($f['tgl_add'])) ?></td>
						<td><?= $f['nama_barang'] ?></td>
						<td><?= $f['stok'] ?></td>
						<td>Rp. <?= number_format($f['harga_beli']) ?></td>
						<td>
							<a href="?action=detail_pembelian&id_pembelian=<?= $f['id_pembelian'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Detail</span><i class="fa fa-eye"></i></a>
							<a href="cetak_nota_pem.php?oid=<?= base64_encode($f['id_subpem']) ?>&id-uid=<?= base64_encode($f['nama_supplier']) ?>&inf=<?= base64_encode($f['no_invoice']) ?>&tb=<?= base64_encode($f['total_bayar']) ?>&uuid=<?= base64_encode(date("d-m-Y",strtotime($f['tgl_pembelian']))) ?>" target="_blank" class="btn bluetbl"><span class="btn-hapus-tooltip">Cetak</span><i class="fa fa-print"></i></a>
						</td>
					</tr>
					<?php
				}
			}else{
				?>
				<td><?= $no++ ?></td>
				<td colspan="5">Belum Ada Transaksi</td>
				<?php
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
