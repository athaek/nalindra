<?php include "head.php" ?>
<?php 
if (isset($_GET['action']) && $_GET['action']=="transaksi_baru") {
		include "transaksi_baru.php";
	}
 ?>
<script type="text/javascript">
	document.title="Cari Barang";
	document.getElementById('transaksi').classList.add('active');
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
        		6:{sorter:false},
        		7:{sorter:false},
        	}
    	});
    });
</script>

<div class="content">
	<div class="padding">
		<div class="bgwhite">
			<div class="padding">
			<div class="contenttop">
				<div class="right">
					<script type="text/javascript">
						function gotocar(val){
							var value=val.options[val.selectedIndex].value;
							window.location.href="cari_barang.php?id_cat1="+value+"";
						}
					</script>
					<select class="leftin1" onchange="gotocar(this)">
						<option value="">Filter kategori</option>
						<?php
							$data=$root->con->query("select * from kategori");
							while ($f=$data->fetch_assoc()) {
								?>
									<option <?php if (isset($_GET['id_cat1'])) { if ($_GET['id_cat1'] == $f['id_kategori']) { echo "selected"; } } ?> value="<?= $f['id_kategori'] ?>"><?= $f['nama_kategori'] ?></option>
								<?php
							}
						?>
					</select>
					<form class="leftin">
						<input type="search" name="q" placeholder="Cari Barang..." value="<?php echo $keyword=isset($_GET['q'])?$_GET['q']:""; ?>">
						<button><i class="fa fa-search"></i></button>
					</form>
				</div>
				<div class="both"></div>
			</div>
			<span class="label">Jumlah Barang : <?= $root->show_jumlah_barang() ?></span>
			<table class="datatable" id="datatable">
				<thead>
				<tr>
					<th width="10px">#</th>
					<th style="cursor: pointer;">Nama Barang <i class="fa fa-sort"></i></th>
					<th style="cursor: pointer;" width="100px">Kategori <i class="fa fa-sort"></i></th>
					<th>Stok</th>
					<th width="120px">Harga Jual</th>
					<th width="150px">Tanggal Ditambahkan</th>
					<th width="60px">Aksi</th>
				</tr>
			</thead>
			<tbody>
					<?php
					if (isset($_GET['id_cat1']) && $_GET['id_cat1']) {
						$root->tampil_cbarang_filter($_GET['id_cat1']);
					}else{
						$keyword=isset($_GET['q'])?addslashes($_GET['q']):"null";
						$root->tampil_cbarang($keyword);
					}
					?>
</tbody>

			</table>
			</div>
		</div>
	</div>
</div>


<?php 

include "foot.php" ?>
