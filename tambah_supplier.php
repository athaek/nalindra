<script type="text/javascript">
	document.title="Tambah Supplier";
	document.getElementById('supplier').classList.add('active');
</script>

<div class="content">
	<div class="padding">
		<div class="bgwhite">
			<div class="padding">
				<h3 class="jdl">Tambah Barang</h3>
				<form class="form-input" method="post" action="handler.php?action=tambah_supplier">
					<input type="number" name="kode_supplier" placeholder="NIK" required="required">
					<input type="text" name="nama_supplier" placeholder="Nama Suplier" required="required">
					<input type="text" name="alamat" placeholder="Alamat" required="required">
					<input type="number" name="hp" placeholder="No Hp" required="required">
					<input type="text" name="info" placeholder="Info" required="required">
					<button class="btnblue" type="submit"><i class="fa fa-save"></i> Simpan</button>
					<a href="barang.php" class="btnblue" style="background: #f33155"><i class="fa fa-close"></i> Batal</a>
				</form>
			</div>
		</div>
	</div>
</div>
