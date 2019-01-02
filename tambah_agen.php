<script type="text/javascript">
	document.title="Tambah Agen";
	document.getElementById('agen').classList.add('active');
</script>

<div class="content">
	<div class="padding">
		<div class="bgwhite">
			<div class="padding">
				<h3 class="jdl">Tambah Barang</h3>
				<form class="form-input" method="post" action="handler.php?action=tambah_agen">
					<input type="number" name="kode_agen" placeholder="NIK" required="required">
					<input type="text" name="nama_agen" placeholder="Nama Agen" required="required">
					<input type="text" name="alamat" placeholder="Alamat" required="required">
					<input type="text" name="facebook" placeholder="Facebook" required="required">
					<input type="text" name="instagram" placeholder="Instagram" required="required">
					<input type="text" name="whastapp" placeholder="Whatsapp" required="required">
					<input type="text" name="bbm" placeholder="BBM" required="required">
					<input type="number" name="hp" placeholder="No Hp" required="required">
					<button class="btnblue" type="submit"><i class="fa fa-save"></i> Simpan</button>
					<a href="barang.php" class="btnblue" style="background: #f33155"><i class="fa fa-close"></i> Batal</a>
				</form>
			</div>
		</div>
	</div>
</div>
