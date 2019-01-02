<script type="text/javascript">
	document.title="Edit Agen";
	document.getElementById('agen').classList.add('active');
</script>

<div class="content">
	<div class="padding">
		<div class="bgwhite">
			<div class="padding">
				<h3 class="jdl">Edit Barang</h3>
				<?php
				$f=$root->edit_agen($_GET['id_agen']);
				?>
				<form class="form-input" method="post" action="handler.php?action=edit_agen" style="padding-top: 30px;">	<input type="text" name="id_agen" value="<?= $f['id_agen'] ?>">
					<input type="text" name="kode_agen" placeholder="NIK" disabled="disabled" value="NIK : <?= $f['kode_agen'] ?>">
					<label>Nama Agen :</label>
					<input type="text" name="nama_agen" placeholder="Nama Agen" required="required" value="<?= $f['nama_agen'] ?>">
					<label>Alamat :</label>
					<input type="text" name="alamat" placeholder="Alamat" required="required" value="<?= $f['alamat'] ?>">
					<label>Facebook :</label>
					<input type="text" name="facebook" placeholder="Facebook" required="required" value="<?= $f['facebook'] ?>">
					<label>Instagram :</label>
					<input type="text" name="instagram" placeholder="Instagram" required="required" value="<?= $f['instagram'] ?>">
					<label>Whatsapp :</label>
					<input type="text" name="whastapp" placeholder="Whatsapp" required="required" value="<?= $f['whastapp'] ?>">
					<label>BBM :</label>
					<input type="text" name="bbm" placeholder="BBM" required="required" value="<?= $f['bbm'] ?>">
					<label>No Hp :</label>
					<input type="number" name="hp" placeholder="No Hp" required="required" value="<?= $f['hp'] ?>">
					<button class="btnblue" type="submit"><i class="fa fa-save"></i> Simpan</button>
					<a href="supplier.php" class="btnblue" style="background: #f33155"><i class="fa fa-close"></i> Batal</a>
				</form>
			</div>
		</div>
	</div>
</div>
