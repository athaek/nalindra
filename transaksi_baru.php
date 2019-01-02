
<script type="text/javascript">
	document.title="Transaksi Baru";
	document.getElementById('transaksi').classList.add('active');
</script>
<script type="text/javascript">
		$(document).ready(function(){
			if ($.trim($('#contenth').text())=="") {
				$('#prosestran').attr("disabled","disabled");
				$('#prosestran').attr("title","tambahkan barang terlebih dahulu");
				$('#prosestran').css("background","#ccc");
				$('#prosestran').css("cursor","not-allowed");
			}
		})

</script>
<div class="content">
	<div class="padding">
		<div class="bgwhite">
			<div class="padding">

				<h3 class="jdl">Entry  Transaksi Baru</h3>
					<div class="contenttop">
				<div class="left">
					<a href="cari_barang.php" class="btnblue">Cari Barang</a>
				</div>
				<div class="both"></div>
			</div>
			<?php
				$f=$root->edit_barang($_GET['id_barang']);
				?>
				<form class="form-input" method="post" action="handler.php?action=tambah_tempo" style="padding-top: 30px;">
					<label>Nama Barang </label>
					<input required="required" readonly="readonly" type="text" name="id_barang" value=" <?= $f['id_barang']?>.<?= addslashes($f['nama_barang']) ?> ,Stok : <?= $f['stok'] ?> ">
					<label>Jumlah Beli :</label>
					<input required="required" type="number" name="jumlah">
					<label>Diskon :  %</label>
					<input required="required" type="number" name="diskon">
					<input type="hidden" name="trx" value="<?php echo date("d")."/ND/".$_SESSION['id']."/".date("y") ?>">
					<button class="btnblue" type="submit"><i class="fa fa-save"></i> Simpan</button>
				</form>

			</div>
		</div>
		<br>
		<div class="bgwhite">
			<div class="padding">
				<h3 class="jdl">Data transaksi</h3>
				<table class="datatable" style="width: 100%;">
				<thead>
				<tr>
					<th width="35px">NO</th>
					<th>ID Barang</th>
					<th>Nama Barang</th>
					<th>Jumlah Beli</th>
					<th>Diskon</th>
					<th>Harga
					Setelah Diskon</th>
					<th>Total Harga</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody id="contenth">
				<?php
				$trx=date("d")."/ND/".$_SESSION['id']."/".date("y");
				$data=$root->con->query("select barang.nama_barang,tempo.id_subtransaksi,tempo.id_barang,tempo.jumlah_beli,tempo.total_harga,tempo.diskon,tempo.harga_set from tempo inner join barang on barang.id_barang=tempo.id_barang where trx='$trx'");
				$getsum=$root->con->query("select sum(total_harga) as grand_total from tempo where trx='$trx'");
				$getsum1=$getsum->fetch_assoc();
				$no=1;
				while ($f=$data->fetch_assoc()) {
					?><tr>
						<td><?= $no++ ?></td>
						<td><?= $f['id_barang'] ?></td>
						<td><?= addslashes($f['nama_barang']) ?></td>
						<td><?= $f['jumlah_beli'] ?></td>
						<td><?= $f['diskon'] ?>%</td>
						<td>Rp. <?= number_format($f['harga_set']) ?></td>
						<td>Rp. <?= number_format($f['total_harga']) ?></td>
						<td><a href="handler.php?action=hapus_tempo&id_tempo=<?= $f['id_subtransaksi'] ?>&id_barang=<?= $f['id_barang'] ?>&jumbel=<?= $f['jumlah_beli'] ?>&diskon<?= $f['diskon'] ?>" class="btn redtbl"><span class="btn-hapus-tooltip">Cancel</span><i class="fa fa-close"></i></a></td>
						</tr>
					<?php
				}
				?>
			</tbody>

				<tr>
					<?php if ($getsum1['grand_total']>0) { ?>
					<td colspan="5"></td><td>Grand Total :</td>
					<td> Rp. <?= number_format($getsum1['grand_total']) ?></td>
					<td></td>
					<?php }else{ ?>
					<td colspan="8">Data masih kosong</td>
					<?php } ?>
				</tr>

			</table>
			<br>
			<form class="form-input" action="handler.php?action=selesai_transaksi" method="post">
					<label>Nama Pembeli :</label>
					<input required="required" type="text" name="nama_pembeli">
					<input type="hidden" name="total_bayar" value="<?= $getsum1['grand_total'] ?>">
					<label>Biaya Pengiriman :</label>
					<input required="required" type="number" name="pengi">
					<button class="btnblue" id="prosestran" type="submit"><i class="fa fa-save"></i> Proses Transaksi</button>
			</form>

			</div>
		</div>


	</div>
</div>

<?php
include "foot.php";

?>
