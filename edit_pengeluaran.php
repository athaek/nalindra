<script type="text/javascript">
	document.title="Edit Pengeluaran";
	document.getElementById('pengeluaran').classList.add('active');
</script>

<div class="content">
	<div class="padding">
		<div class="bgwhite">
			<div class="padding">
				<h3 class="jdl">Edit Pengeluaran</h3>
				<?php $f=$root->edit_pengeluaran($_GET['id_pengeluaran_jenis']) ?>
				<form class="form-input" method="post" action="handler.php?action=edit_pengeluaran">
					<input type="text" placeholder="ID Pengeluaran" disabled="disabled" value="ID kategori : <?= $f['id_pengeluaran_jenis'] ?>">
					<input type="text" name="keterangan" placeholder="Nama Pengeluaran" required="required" value="<?= $f['keterangan'] ?>">
					<input type="hidden" name="id_pengeluaran_jenis" value="<?= $f['id_pengeluaran_jenis'] ?>">
					<button class="btnblue" type="submit"><i class="fa fa-save"></i> Update</button>
					<a href="pengeluaran.php" class="btnblue" style="background: #f33155"><i class="fa fa-close"></i> Batal</a>
				</form>
			</div>
		</div>
	</div>
</div>
