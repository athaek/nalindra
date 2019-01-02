<?php include "head.php" ?>
<?php
	if (isset($_GET['action']) && $_GET['action']=="edit_pengeluaran") {
		include "edit_pengeluaran.php";
	}elseif (isset($_GET['action']) && $_GET['action']=="pengeluaran_baru") {
		include "pengeluaran_baru.php";
	}
	else{
?>
<script type="text/javascript">
	document.title="Pengeluaran Oprasional";
	document.getElementById('pengeluaran').classList.add('active');
</script>
<div class="content">
	<div class="padding">
		<div class="bgwhite">
			<div class="padding">
			<div class="contenttop">
				<div class="left">
					<form action="handler.php?action=tambah_pengeluaran" method="post">
						<input type="text" name="keterangan" placeholder="Nama Pengeluaran..." style="margin-right: 10px;border-right: 1px solid #ccc;border-radius: 3px;">
						<button style="background: #41b3f9;color: #fff;border-radius: 3px;border-color: #41b3f9;border:1px solid #41b3f9">Tambahkan</button>
						<a href="?action=pengeluaran_baru" class="btnblue" style="background: #f33155"><i class="fa fa-mail-add"></i> Pengeluaran Baru</a>
					</form>
				</div>
				<div class="both"></div>
			</div>
			<span class="label">Jumlah Pengeluaran : <?= $root->show_jumlah_cat() ?></span>
			<table class="datatable" style="width: 500px;">
				<thead>
				<tr>
					<th width="35px">NO</th>
					<th>Nama Pengeluaran</th>
					<th width="60px">Aksi</th>
				</tr>
			</thead>
			<tbody>
					<?php $root->tampil_pengeluaran() ?>
</tbody>

			</table>
			</div>
		</div>
	</div>
</div>

<?php
}
include "foot.php" ?>
