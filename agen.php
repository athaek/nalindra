<?php include "head.php" ?>
<?php
	if (isset($_GET['action']) && $_GET['action']=="tambah_agen") {
		include "tambah_agen.php";
	}
	else if (isset($_GET['action']) && $_GET['action']=="edit_agen") {
		include "edit_agen.php";
	}
	else{
?>
<script type="text/javascript">
	document.title="Agen";
	document.getElementById('agen').classList.add('active');
</script>
<script type="text/javascript" src="assets/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
    $(function(){
    	$.tablesorter.addWidget({
    		id:"indexFirstColumn",
    		format:function(table){
    			$(table).find("tr td:first-child").each(function(index){
    				$(this).text(index+1);
    			})
    		}
    	});
    	$("table").tablesorter({
    		widgets:['indexFirstColumn'],
    		headers:{
        		0:{sorter:false},
        		3:{sorter:false},
        		4:{sorter:false},
        		5:{sorter:false},
        	}
    	});
    });
</script>
<div class="content">
	<div class="padding">
		<div class="bgwhite">
			<div class="padding">
			<div class="contenttop">
				<div class="left">
				<a href="?action=tambah_agen" class="btnblue"><i class="fa fa-plus"></i> Tambah Agen</a>
				<a href="cetak_agen.php" class="btnblue" target="_blank"><i class="fa fa-print"></i> Cetak</a>
				</div>
				<div class="right">
					<script type="text/javascript">
						function gotocat(val){
							var value=val.options[val.selectedIndex].value;
							window.location.href="barang.php?id_cat="+value+"";
						}
					</script>
					<form class="leftin">
						<input type="search" name="q" placeholder="Cari Agen..." value="<?php echo $keyword=isset($_GET['q'])?$_GET['q']:""; ?>">
						<button><i class="fa fa-search"></i></button>
					</form>
				</div>
				<div class="both"></div>
			</div>
			<span class="label">Jumlah Agen : <?= $root->show_jumlah_agen() ?></span>
			<table class="datatable" id="datatable">
				<thead>
				<tr>
					<th width="10px">#</th>
					<th width="120px">NIK</th>
					<th style="cursor: pointer;">Nama Agen <i class="fa fa-sort"></i></th>
					<th width="120px">Alamat</th>
					<th width="120px">Facebook</th>
					<th width="150px">Instagram</th>
					<th width="60px">Whatsapp</th>
					<th width="120px">BBM</th>
					<th width="120px">hp</th>
					<th width="120px">Aksi</th>

				</tr>
			</thead>
			<tbody>
					<?php
						$root->tampil_agen($keyword);

					?>
</tbody>

			</table>
			</div>
		</div>
	</div>
</div>


<?php 
}
include "foot.php" ?>
