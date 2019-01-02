<script type="text/javascript">
	document.title="Pembelian Baru";
	document.getElementById('pembelian').classList.add('active');
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
				<form class="form-input" method="post" action="handler.php?action=tambah_tempo_pem" style="padding-top: 30px;">
					<input type="text" name="id_barang" placeholder="Kode Barang" required="required">
					<input type="text" name="nama_barang" placeholder="Nama Barang" required="required">
					<input type="number" name="stok" placeholder="Stok" required="required">
					<input type="number" name="harga_beli" placeholder="Harga Beli" required="required">
					<input type="number" name="harga_jual" placeholder="Harga Jual" required="required">
					<select style="width: 372px;cursor: pointer;" required="required" name="kategori">
						<option value="">Pilih Kategori :</option>
						<?php $root->tampil_kategori2(); ?>
					</select>
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
					<th>Harga Beli</th>
					<th>Total Harga</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody id="contenth">
				<?php
				$trx=date("d")."/ND/".$_SESSION['id']."/".date("y");
				$data=$root->con->query("select * from tempo_pem where trx='$trx'");
				$getsum=$root->con->query("select sum(total_harga) as grand_total from tempo_pem where trx='$trx'");
				$getsum1=$getsum->fetch_assoc();
				$no=1;
				while ($f=$data->fetch_assoc()) {
					?><tr>
						<td><?= $no++ ?></td>
						<td><?= $f['id_barang'] ?></td>
						<td><?= $f['nama_barang'] ?></td>
						<td><?= $f['stok'] ?></td>
						<td>Rp. <?= number_format($f['harga_beli']) ?></td>
						<td>Rp. <?= number_format($f['total_harga']) ?></td>
						<td><a href="handler.php?action=hapus_tempo_pem&id_tempo_pem=<?= $f['id_subpem'] ?> ?>" class="btn redtbl"><span class="btn-hapus-tooltip">Cancel</span><i class="fa fa-close"></i></a></td>
						</tr>
					<?php
				}
				?>
			</tbody>

				<tr>
					<?php if ($getsum1['grand_total']>0) { ?>
					<td colspan="4"></td><td>Grand Total :</td>
					<td> Rp. <?= number_format($getsum1['grand_total']) ?></td>
					<td></td>
					<?php }else{ ?>
					<td colspan="6">Data masih kosong</td>
					<?php } ?>
				</tr>

			</table>
			<br>
			<form class="form-input" action="handler.php?action=selesai_pembelian" method="post">
					<label>Nama Supplier :</label>
					<select style="width: 372px;cursor: pointer;" required="required" name="id_supplier">
						<?php
						$data=$root->con->query("select * from supplier");
						while ($f=$data->fetch_assoc()) {
							echo "<option value='$f[id_supplier]'>$f[nama_supplier]</option>";
						}
						?>
					</select>
					<input type="hidden" name="total_bayar" value="<?= $getsum1['grand_total'] ?>">
					<button class="btnblue" id="prosestran" type="submit"><i class="fa fa-save"></i> Proses Transaksi</button>
			</form>

			</div>
		</div>


	</div>
</div>

<?php
include "foot.php";
?>
