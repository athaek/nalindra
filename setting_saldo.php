<?php include "head.php" ?>
<script type="text/javascript">
	document.title="Setting Saldo";
</script>
<div class="content">
	<div class="padding">
		<div class="bgwhite">
			<div class="padding">
				<h3 class="jdl">Setting Saldo</h3>
				<span class="label">* silahkan melakukan Pengisian saldo</span>
				<form class="form-input" method="post" action="handler.php?action=tambah_saldo" style="padding-top: 30px;">
					<label>Jumlah Saldo : </label>
					<input type="hidden" name="id_saldo" value="1">
					<input type="number" name="saldo" placeholder="Saldo">
					<button class="btnblue" type="submit"><i class="fa fa-save"></i> Simpan</button>
					<a href="home.php" class="btnblue" style="background: #f33155"><i class="fa fa-close"></i> Batal</a>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
include "foot.php";
?>
