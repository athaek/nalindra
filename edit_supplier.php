<script type="text/javascript">
	document.title="Edit Supplier";
	document.getElementById('supplier').classList.add('active');
</script>

<div class="content">
	<div class="padding">
		<div class="bgwhite">
			<div class="padding">
				<h3 class="jdl">Edit Barang</h3>
				<?php
				$f=$root->edit_supplier($_GET['id_supplier']);
				?>
				<form class="form-input" method="post" action="handler.php?action=edit_supplier" style="padding-top: 30px;">	<input type="text" name="id_supplier" value="<?= $f['id_supplier'] ?>">
					<input type="text" name="kode_supplier" placeholder="ID Kategori" disabled="disabled" value="NIK : <?= $f['kode_supplier'] ?>">
					<label>Nama Supplier :</label>
					<input type="text" name="nama_supplier" placeholder="Nama Supplier" required="required" value="<?= $f['nama_supplier'] ?>">
					<label>Alamat :</label>
					<input type="text" name="alamat" placeholder="Alamat" required="required" value="<?= $f['alamat'] ?>">
					<label>No Hp :</label>
					<input type="number" name="hp" placeholder="No Hp" required="required" value="<?= $f['hp'] ?>">
					<label>Info :</label>
					<input type="text" name="info" placeholder="Info" required="required" value="<?= $f['info'] ?>">
					<button class="btnblue" type="submit"><i class="fa fa-save"></i> Simpan</button>
					<a href="supplier.php" class="btnblue" style="background: #f33155"><i class="fa fa-close"></i> Batal</a>
				</form>
			</div>
		</div>
	</div>
</div>
