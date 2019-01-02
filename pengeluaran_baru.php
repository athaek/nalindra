<script type="text/javascript">
	document.title="Pengeluaran Baru";
	document.getElementById('pengeluaran').classList.add('active');
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
				<h3 class="jdl">Entry Pengeluaran Baru</h3>
				<form class="form-input" method="post" action="handler.php?action=tambah_tempo_peng" style="padding-top: 30px;">
					<label>Pilih Barang : </label>
					<select style="width: 372px;cursor: pointer;" required="required" name="jenis">
						<option value="">Pilih Kategori :</option>
						<?php $root->tampil_pengeluaran2(); ?>
					</select>
					<label>Total Biaya :</label>
					<input required="required" type="number" name="total">
					<label>Detail Keperluan :</label>
					<input required="required" type="text" name="detail">
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
					<th>Keterangan</th>
					<th>Total Biaya</th>
					<th>Detail Keperluan</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody id="contenth">
				<?php
				$trx=date("d")."/ND/".$_SESSION['id']."/".date("y");
				$data=$root->con->query("select tempo_peng.id_detail_pengeluaran,pengeluaran_jenis.keterangan,tempo_peng.uang,tempo_peng.detail_keperluan from tempo_peng inner join pengeluaran_jenis on pengeluaran_jenis.id_pengeluaran_jenis=tempo_peng.id_pengeluaran_jenis");
				$getsum=$root->con->query("select sum(uang) as grand_total from tempo_peng ");
				$getsum1=$getsum->fetch_assoc();
				$no=1;
				while ($f=$data->fetch_assoc()) {
					?><tr>
						<td><?= $no++ ?></td>
						<td><?= $f['keterangan'] ?></td>
						<td>Rp. <?= number_format($f['uang']) ?></td>
						<td><?= $f['detail_keperluan'] ?></td>
						<td><a href="handler.php?action=hapus_tempo_peng&id_tempo_peng=<?= $f['id_detail_pengeluaran'] ?>" class="btn redtbl"><span class="btn-hapus-tooltip">Cancel</span><i class="fa fa-close"></i></a></td>
						</tr>
					<?php
				}
				?>
			</tbody>

				<tr>
					<?php if ($getsum1['grand_total']>0) { ?>
					<td colspan="1"></td><td>Grand Total :</td>
					<td> Rp. <?= number_format($getsum1['grand_total']) ?></td>
					<td></td>
					<?php }else{ ?>
					<td colspan="6">Data masih kosong</td>
					<?php } ?>
				</tr>

			</table>
			<br>
			<form class="form-input" action="handler.php?action=selesai_pengeluaran" method="post">
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
