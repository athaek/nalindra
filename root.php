<?php

error_reporting(0);
class penjualan
{

	public $con;
	function __construct()
	{
		$this->con=new mysqli("101.50.1.68","nalindra_N4L1nD7RaPip","*B4nkJ4t1m#","nalindra_str");
	}
	function __destruct()
	{
		$this->con->close();
	}
	function alert($text){
		?><script type="text/javascript">
            alert( "<?= $text ?>" );
        </script>
        <?php
	}

	function redirect($url){
		?>
		<script type="text/javascript">
		window.location.href="<?= $url ?>";
		</script>
		<?php
	}

	function go_back(){
		?>
		<script type="text/javascript">
		window.history.back();
		</script>
		<?php
	}
	function login($username,$password,$loginas){
		if (trim($username)=="") {
			$error[]="Username";
		}
		if (trim($password)=="") {
			$error[]="Password";
		}
		if (isset($error)) {
			echo "<div class='red'><i class='fa fa-warning'></i> Maaf sepertinya ".implode(' dan ', $error)." anda kosong.</div>";
		}else{
		$password=sha1($password);
		$query=$this->con->query("select * from user where username='$username' and password='$password' and status='$loginas'");

		if ($query->num_rows > 0) {
			echo "<div class='green'><i class='fa fa-check'></i> Login Berhasil, silahkan tunggu beberapa saat.</div>";
			$data=$query->fetch_assoc();
			session_start();
			$_SESSION['username']=$data['username'];
			$_SESSION['status']=$data['status'];
			$_SESSION['id']=$data['id'];
			if ($data['status']=='1') {
				$this->redirect("home.php");
			}else{
				$this->redirect("transaksi.php");
			}


		}else{
			echo "<div class='red'><i class='fa fa-warning'></i> Maaf sepertinya username atau password anda salah.</div>";
		}
		}
	}
	function tambah_supplier($kode_supplier,$nama_supplier,$alamat,$hp,$info){
		$query=$this->con->query("select * from supplier where nama_supplier='$nama_supplier'");
		if ($query->num_rows > 0) {
			$this->alert("Data Supplier Sudah Ada");
			$this->go_back();

		}else{
			$query2=$this->con->query("insert into supplier set kode_supplier='$kode_supplier',nama_supplier='$nama_supplier',alamat='$alamat',hp='$hp',info='$info'");
			if ($query2===TRUE) {
				$this->alert("Supplier Berhasil Ditambahkan");
				$this->redirect("supplier.php");
			}
			else{
				$this->alert("Supplier Gagal Ditambahkan");
				$this->redirect("supplier.php");
			}
		}
	}

	function tambah_agen($kode_agen,$nama_agen,$alamat,$fb,$ig,$wa,$bbm,$hp){
		$query=$this->con->query("select * from agen where nama_agen='$nama_agen'");
		if ($query->num_rows > 0) {
			$this->alert("Data Agen Sudah Ada");
			$this->go_back();

		}else{
			 $query2=$this->con->query("insert into agen set kode_agen='$kode_agen',nama_agen='$nama_agen',alamat='$alamat',facebook='$fb',instagram='$ig',whastapp='$wa',bbm='$bbm',hp='$hp'");
			if ($query2===TRUE) {
				$this->alert("Agen Berhasil Ditambahkan");
				$this->redirect("agen.php");
			}
			else{
				$this->alert("Agen Gagal Ditambahkan");
				$this->redirect("agen.php");
			}
		}
	}
	function tambah_barang($nama_barang,$stok,$harga_beli,$harga_jual,$id_kategori){
		$query=$this->con->query("select * from barang where nama_barang='$nama_barang'");
		if ($query->num_rows > 0) {
			$this->alert("Data barang sudah ada");
			$this->go_back();
		}
		else{
			$query2=$this->con->query("insert into barang set nama_barang='$nama_barang',id_kategori='$id_kategori',stok='$stok',harga_beli='$harga_beli',harga_jual='$harga_jual'");
			   $sub=$stok*$harga_beli;
			$query3 = $this->con->query("insert into tempo_pem set nama_barang='$nama_barang',id_kategori='$id_kategori',stok='$stok',harga_beli='$harga_beli',harga_jual='$harga_jual',sub_total='$sub'");
			if ($query2===TRUE) {
				$this->alert("Barang Berhasil Ditambahkan");
				$this->redirect("barang.php");
			}
			else{
				$this->alert("Barang Gagal Ditambahkan");
				$this->redirect("barang.php");
			}
		}
	}
	function tambah_kasir($nama_kasir,$password){
		$nama_kasir=str_replace(" ", "", $nama_kasir);
		$query=$this->con->query("select * from  user where username='$nama_kasir' and status='2'");
		if ($query->num_rows > 0) {
			$this->alert("Username  untuk kasir  sudah ada.");
			$this->go_back();
		}
		else{
			$password=sha1($password);
			$query2=$this->con->query("insert into user set username='$nama_kasir',password='$password',status='2'");
			if ($query2 ===  TRUE) {
				$this->alert("Data kasir berhasil dismpan");
				$this->redirect("users.php");
			}
			else{
				$this->alert("Kasir Gagal Ditambahkan");
				$this->redirect("users.php");
			}
		}
	}

	function tambah_kategori($nama_kategori){
		$query=$this->con->query("select * from kategori where nama_kategori='$nama_kategori'");
		if ($query->num_rows > 0) {
			$this->alert("Kategori Sudah Ada");
			$this->redirect("kategori.php");
		}else{
			$query2=$this->con->query("insert into kategori set nama_kategori='$nama_kategori'");
			if ($query2===TRUE) {
				$this->alert("kategori Berhasil Ditambahkan");
				$this->redirect("kategori.php");
			}
			else{
				$this->alert("kategori Gagal Ditambahkan");
				$this->redirect("kategori.php");
			}
		}
	}
	function tambah_pengeluaran($keterangan){
		$query=$this->con->query("select * from pengeluaran_jenis where keterangan='$keterangan'");
		if ($query->num_rows > 0) {
			$this->alert("Jenis Pengeluaran Sudah Ada");
			$this->redirect("pengeluaran.php");
		}else{
			$query2=$this->con->query("insert into pengeluaran_jenis set keterangan='$keterangan'");
			if ($query2===TRUE) {
				$this->alert("Jenis Pengeluaran Berhasil Ditambahkan");
				$this->redirect("pengeluaran.php");
			}
			else{
				$this->alert("Jenis Pengeluaran Gagal Ditambahkan");
				$this->redirect("pengeluaran.php");
			}
		}
	}
		function tambah_saldo($id_saldo,$saldo){
		$query=$this->con->query("select * from jumlah_saldo ");
		if ($query->num_rows > 0) {
			$this->alert("Saldo Sudah Ada");
			$this->redirect("setting_saldo.php");
		}else{
			$query2=$this->con->query("insert into jumlah_saldo set id_saldo='$id_saldo', saldo='$saldo'");
			if ($query2===TRUE) {
				$this->alert("Saldo Berhasil Ditambahkan");
				$this->redirect("home.php");
			}
			else{
				$this->alert("Saldo Gagal Ditambahkan");
				$this->redirect("setting_saldo.php");
			}
		}
	}

	function tampil_pengeluaran(){
		$query=$this->con->query("select * from pengeluaran_jenis order by id_pengeluaran_jenis desc");
		$no=1;
		while ($data=$query->fetch_assoc()) {
			?>
				<tr>
					<td><?= $no ?></td>
					<td><?= $data['keterangan'] ?></td>
					<td>
						<a href="?action=edit_pengeluaran&id_pengeluaran_jenis=<?= $data['id_pengeluaran_jenis'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Edit</span><i class="fa fa-pencil"></i></a>
						<a href="handler.php?action=hapus_pengeluaran&id_pengeluaran_jenis=<?= $data['id_pengeluaran_jenis'] ?>" class="btn redtbl" onclick="return confirm('yakin ingin menghapus kategori : <?= $data['keterangan'] ?> ?')"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
					</td>
				</tr>
				<?php

			$no++;
		}
	}

	function tampil_supplier($keyword){
		if ($keyword=="null"){
			$query=$this->con->query("select * from supplier");
		}else{
			$query=$this->con->query("select * from supplier where nama_supplier like '%$keyword%'");
		}
		if ($query->num_rows > 0) {
			$no=1;
			while ($data=$query->fetch_assoc()) {
				?>
				<tr>
						<td><?= $no ?></td>
						<td><?= $data['nama_supplier'] ?></td>
						<td><?= $data['alamat'] ?></td>
						<td><?= $data['hp'] ?></td>
						<td><?= $data['info'] ?></td>
						<td>
							<a href="?action=edit_supplier&id_supplier=<?= $data['id_supplier'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Edit</span><i class="fa fa-pencil"></i></a>
							<a href="handler.php?action=hapus_supplier&id_supplier=<?= $data['id_supplier'] ?>" class="btn redtbl" onclick="return confirm('yakin ingin menghapus <?= $data['nama_supplier']." (id : ".$data['kode_supplier'] ?>) ?')"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
						</td>
					</tr>
				<?php
				$no++;
			}
		}else{
			echo "<td></td><td colspan='5'>Maaf, barang yang anda cari tidak ada!</td>";
		}
	}
	function tampil_agen($keyword){
		if ($keyword=="null"){
			$query=$this->con->query("select * from agen");
		}else{
			$query=$this->con->query("select * from agen where nama_agen like '%$keyword%'");
		}
		if ($query->num_rows > 0) {
			$no=1;
			while ($data=$query->fetch_assoc()) {
				?>
				<tr>
						<td><?= $no ?></td>
						<td><?= $data['kode_agen'] ?></td>
						<td><?= $data['nama_agen'] ?></td>
						<td><?= $data['alamat'] ?></td>
						<td><?= $data['facebook'] ?></td>
						<td><?= $data['instagram'] ?></td>
						<td><?= $data['whastapp'] ?></td>
						<td><?= $data['bbm'] ?></td>
						<td><?= $data['hp'] ?></td>

						
						<td>
							<a href="?action=edit_agen&id_agen=<?= $data['id_agen'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Edit</span><i class="fa fa-pencil"></i></a>
							<a href="handler.php?action=hapus_agen&id_agen=<?= $data['id_agen'] ?>" class="btn redtbl" onclick="return confirm('yakin ingin menghapus <?= $data['nama_agen']." (id : ".$data['kode_agen'] ?>) ?')"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
						</td>
					</tr>
				<?php
				$no++;
			}
		}else{
			echo "<td></td><td colspan='10'>Maaf, barang yang anda cari tidak ada!</td>";
		}
	}

	function tampil_barang($keyword){
		if ($keyword=="null") {
			$query=$this->con->query("select barang.id_barang,barang.nama_barang,barang.stok,barang.harga_beli,barang.harga_jual,barang.date_added,kategori.nama_kategori from barang inner join kategori on kategori.id_kategori=barang.id_kategori");
		}else{
			$query=$this->con->query("select barang.id_barang,barang.nama_barang,barang.stok,barang.harga_beli,barang.harga_jual,barang.date_added,kategori.nama_kategori from barang inner join kategori on kategori.id_kategori=barang.id_kategori where nama_barang like '%$keyword%'");
		}
		if ($query->num_rows > 0) {
			$no=1;
			while ($data=$query->fetch_assoc()) {
				?>
					<tr>
						<td><?= $no ?></td>
						<td><?= $data['nama_barang'] ?></td>
						<td><?= $data['nama_kategori'] ?></td>
						<td><?= $data['stok'] ?></td>
						<td>Rp. <?= number_format($data['harga_beli']) ?></td>
						<td>Rp. <?= number_format($data['harga_jual']) ?></td>
						<td><?= date("d-m-Y",strtotime($data['date_added'])) ?></td>
						<td>
							<a href="?action=edit_barang&id_barang=<?= $data['id_barang'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Edit</span><i class="fa fa-pencil"></i></a>
							<a href="handler.php?action=hapus_barang&id_barang=<?= $data['id_barang'] ?>" class="btn redtbl" onclick="return confirm('yakin ingin menghapus <?= $data['nama_barang']." (id : ".$data['id_barang'] ?>) ?')"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
						</td>
					</tr>
					<?php
					$no++;
			}
		}else{
			echo "<td></td><td colspan='5'>Maaf, barang yang anda cari tidak ada!</td>";
		}

	}
	function tampil_barang_filter($id_cat){
			$query=$this->con->query("select barang.id_barang,barang.nama_barang,barang.stok,barang.harga_beli,barang.harga_jual,barang.date_added,kategori.nama_kategori from barang inner join kategori on kategori.id_kategori=barang.id_kategori where kategori.id_kategori='$id_cat'");
		if ($query->num_rows > 0) {

			$no=1;
			while ($data=$query->fetch_assoc()) {
				?>
					<tr>
						<td><?= $no ?></td>
						<td><?= $data['nama_barang'] ?></td>
						<td><?= $data['nama_kategori'] ?></td>
						<td><?= $data['stok'] ?></td>
						<td>Rp. <?= number_format($data['harga_beli']) ?></td>
						<td>Rp. <?= number_format($data['harga_jual']) ?></td>
						<td><?= date("d-m-Y",strtotime($data['date_added'])) ?></td>
						<td>
							<a href="?action=edit_barang&id_barang=<?= $data['id_barang'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Edit</span><i class="fa fa-pencil"></i></a>
							<a href="handler.php?action=hapus_barang&id_barang=<?= $data['id_barang'] ?>" class="btn redtbl" onclick="return confirm('yakin ingin menghapus <?= $data['nama_barang']." (id : ".$data['id_barang'] ?>) ?')"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
						</td>
					</tr>
					<?php
					$no++;
			}
		}else{
			echo "<td></td><td colspan='5'>Barang dengan kategori tersebut masih kosong</td>";
		}
	}
function tampil_cbarang($keyword){
		if ($keyword=="null") {
			$query=$this->con->query("select barang.id_barang,barang.nama_barang,barang.stok,barang.harga_beli,barang.harga_jual,barang.date_added,kategori.nama_kategori from barang inner join kategori on kategori.id_kategori=barang.id_kategori");
		}else{
			$query=$this->con->query("select barang.id_barang,barang.nama_barang,barang.stok,barang.harga_beli,barang.harga_jual,barang.date_added,kategori.nama_kategori from barang inner join kategori on kategori.id_kategori=barang.id_kategori where nama_barang like '%$keyword%'");
		}
		if ($query->num_rows > 0) {
			$no=1;
			while ($data=$query->fetch_assoc()) {
				?>
					<tr>
						<td><?= $no ?></td>
						<td><?= $data['nama_barang'] ?></td>
						<td><?= $data['nama_kategori'] ?></td>
						<td><?= $data['stok'] ?></td>
					
						<td>Rp. <?= number_format($data['harga_jual']) ?></td>
						<td><?= date("d-m-Y",strtotime($data['date_added'])) ?></td>
						<td>
							<a href="?action=transaksi_baru&id_barang=<?= $data['id_barang'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Edit</span><i class="fa fa-pencil"></i></a>
						</td>
					</tr>
					<?php
					$no++;
			}
		}else{
			echo "<td></td><td colspan='5'>Maaf, barang yang anda cari tidak ada!</td>";
		}

	}
	function tampil_cbarang_filter($id_cat1){
			$query=$this->con->query("select barang.id_barang,barang.nama_barang,barang.stok,barang.harga_beli,barang.harga_jual,barang.date_added,kategori.nama_kategori from barang inner join kategori on kategori.id_kategori=barang.id_kategori where kategori.id_kategori='$id_cat1'");
		if ($query->num_rows > 0) {

			$no=1;
			while ($data=$query->fetch_assoc()) {
				?>
					<tr>
						<td><?= $no ?></td>
						<td><?= $data['nama_barang'] ?></td>
						<td><?= $data['nama_kategori'] ?></td>
						<td><?= $data['stok'] ?></td>
					
						<td>Rp. <?= number_format($data['harga_jual']) ?></td>
						<td><?= date("d-m-Y",strtotime($data['date_added'])) ?></td>
						<td>
							<a href="?action=transaksi_baru&id_barang=<?= $data['id_barang'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Edit</span><i class="fa fa-pencil"></i></a>
						</td>
					</tr>
					<?php
					$no++;
			}
		}else{
			echo "<td></td><td colspan='5'>Barang dengan kategori tersebut masih kosong</td>";
		}
	}
	function tampil_kategori(){
		$query=$this->con->query("select * from kategori order by id_kategori desc");
		$no=1;
		while ($data=$query->fetch_assoc()) {
			?>
				<tr>
					<td><?= $no ?></td>
					<td><?= $data['nama_kategori'] ?></td>
					<td>
						<a href="?action=edit_kategori&id_kategori=<?= $data['id_kategori'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Edit</span><i class="fa fa-pencil"></i></a>
						<a href="handler.php?action=hapus_kategori&id_kategori=<?= $data['id_kategori'] ?>" class="btn redtbl" onclick="return confirm('yakin ingin menghapus kategori : <?= $data['nama_kategori'] ?> ?')"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
					</td>
				</tr>
				<?php

			$no++;
		}
	}
	function tampil_kategori2(){
		$query=$this->con->query("select * from kategori order by id_kategori desc");
		while ($data=$query->fetch_assoc()) {
			?>
				<option value="<?= $data['id_kategori'] ?>"><?= $data['nama_kategori'] ?></option>
			<?php
		}
	}
	function tampil_pengeluaran2(){
		$query=$this->con->query("select * from pengeluaran_jenis order by id_pengeluaran_jenis desc");
		while ($data=$query->fetch_assoc()) {
			?>
				<option value="<?= $data['id_pengeluaran_jenis'] ?>"><?= $data['keterangan'] ?></option>
			<?php
		}
	}
	function tampil_kategori3($id_barang){
		$q=$this->con->query("select * from barang where id_barang='$id_barang'");
		$q2=$q->fetch_assoc();
		$id_cat=$q2['id_kategori'];
		$query=$this->con->query("select * from kategori order by id_kategori desc");
		while ($data=$query->fetch_assoc()) {
			?>
				<option <?php if ($data['id_kategori']==$id_cat) { echo "selected"; } ?> value="<?= $data['id_kategori'] ?>"><?= $data['nama_kategori'] ?></option>
			<?php
		}
	}
	function tampil_kasir(){
		$query=$this->con->query("select * from user where status='2'");
		$no=1;
		while ($data=$query->fetch_assoc()) {
			?>
			<tr>
					<td><?= $no ?></td>
					<td><?= $data['username'] ?></td>
					<td>Kasir</td>
					<td><?= date("d-m-Y",strtotime($data['date_created'])) ?></td>
					<td>
						<a href="?action=edit_kasir&id_kasir=<?= $data['id'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Edit</span><i class="fa fa-pencil"></i></a>
						<a href="handler.php?action=hapus_user&id_user=<?= $data['id'] ?>" class="btn redtbl" onclick="return confirm('yakin ingin menghapus user : <?= $data['username'] ?> ?')"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
					</td>
			</tr>
			<?php
			$no++;
		}
	}
	
	function tampil_laporan_pengeluaran(){
		$query=$this->con->query("select pengeluaran.id_pengeluaran,pengeluaran.tgl_pengeluaran,pengeluaran.total_pengeluaran,pengeluaran.no_invoice,user.username from pengeluaran inner join user on pengeluaran.kode_kasir=user.id where pengeluaran.tgl_pengeluaran like '%$tanggal%' order by pengeluaran.id_pengeluaran desc");
		$no=1;
		while ($f=$query->fetch_assoc()) {
			?>
			<tr>
				<td><?= $no++ ?></td>
				<td><?= $f['no_invoice'] ?></td>
				<td><?= $f['username'] ?></td>
				<td><?= date("d-m-Y",strtotime($f['tgl_pengeluaran'])) ?></td>
				<td>Rp. <?= number_format($f['total_pengeluaran']) ?></td>
				<td>
					<a href="?action=detail_pengeluaran&id_pengeluaran=<?= $f['id_pengeluaran'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Lihat</span><i class="fa fa-eye"></i></a>
					<a onclick="return confirm('yakin ingin menghapus <?= $f['no_invoice']." (id : ".$f['id_pengeluaran'] ?>) ?')" href="handler.php?action=delete_pengeluaran&id=<?= $f['id_pengeluaran'] ?>" class="btn redtbl"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			<?php
		}
	}
	function tampil_laporan_pembelian(){
		$query=$this->con->query("select * from tempo_pem order by tgl_add desc");
		$no=1;
		while ($f=$query->fetch_assoc()) {
			?>
			<tr>
				<td><?= $no++ ?></td>
				<td><?= date("d-m-Y",strtotime($f['tgl_add'])) ?></td>
				<td><?= $f['nama_barang'] ?></td>
				<td><?= $f['stok'] ?></td>
				<td>Rp. <?= number_format($f['harga_beli']) ?></td>
				<td>Rp. <?= number_format($f['stok']*$f['harga_beli']) ?></td>
				<td>
					
					<a onclick="return confirm('yakin ingin menghapus <?= " (id : ".$f['id_subpem'] ?>) ?')" href="handler.php?action=delete_pembelian&id=<?= $f['id_subpem'] ?>" class="btn redtbl"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			<?php
		}
	}
	function tampil_laporan_return_pembelian(){
		$query=$this->con->query("select return_pembelian.id_return_pembelian,return_pembelian.tgl_return_pembelian,return_pembelian.kode_kasir,return_pembelian.total_bayar,return_pembelian.no_invoice,supplier.nama_supplier,user.username from return_pembelian inner join supplier on supplier.id_supplier=return_pembelian.id_supplier inner join user on user.id = return_pembelian.kode_kasir order by return_pembelian.tgl_return_pembelian desc");
		$no=1;
		while ($f=$query->fetch_assoc()) {
			?>
			<tr>
				<td><?= $no++ ?></td>
				<td><?= $f['no_invoice'] ?></td>
				<td><?= $f['username'] ?></td>
				<td><?= $f['nama_supplier'] ?></td>
				<td><?= date("d-m-Y",strtotime($f['tgl_return_pembelian'])) ?></td>
				<td>Rp. <?= number_format($f['total_bayar']) ?></td>
				<td>
					<a href="?action=detail_return_pembelian&id_return_pembelian=<?= $f['id_return_pembelian'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Lihat</span><i class="fa fa-eye"></i></a>
					<a onclick="return confirm('yakin ingin menghapus <?= $f['no_invoice']." (id : ".$f['id_return_pembelian'] ?>) ?')" href="handler.php?action=delete_return_pembelian&id=<?= $f['id_return_pembelian'] ?>" class="btn redtbl"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			<?php
		}
	}
	function tampil_laporan_return_penjualan(){
		$query=$this->con->query("select return_penjualan.id_return_penjualan,return_penjualan.tgl_return_penjualan,user.username,return_penjualan.total_bayar,return_penjualan.no_invoice,return_penjualan.nama_pembeli,user.id from return_penjualan inner join user on user.id = return_penjualan.kode_kasir order by return_penjualan.tgl_return_penjualan desc");
		$no=1;
		while ($f=$query->fetch_assoc()) {
			?>
			<tr>
				<td><?= $no++ ?></td>
				<td><?= $f['no_invoice'] ?></td>
				<td><?= $f['username'] ?></td>
				<td><?= $f['nama_pembeli'] ?></td>
				<td><?= date("d-m-Y",strtotime($f['tgl_return_penjualan'])) ?></td>
				<td>Rp. <?= number_format($f['total_bayar']) ?></td>
				<td>
					<a href="?action=detail_return_penjualan&id_return_penjualan=<?= $f['id_return_penjualan'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Lihat</span><i class="fa fa-eye"></i></a>
					<a onclick="return confirm('yakin ingin menghapus <?= $f['no_invoice']." (id : ".$f['id_return_penjualan'] ?>) ?')" href="handler.php?action=delete_return_penjualan&id=<?= $f['id_return_penjualan'] ?>" class="btn redtbl"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			<?php
		}
	}
	function tampil_laporan(){
		$query=$this->con->query("select transaksi.id_transaksi,transaksi.tgl_transaksi,transaksi.no_invoice,transaksi.total_bayar,transaksi.nama_pembeli,user.username from transaksi inner join user on transaksi.kode_kasir=user.id order by transaksi.id_transaksi desc");
		$no=1;
		while ($f=$query->fetch_assoc()) {
			?>
			<tr>
				<td><?= $no++ ?></td>
				<td><?= $f['no_invoice'] ?></td>
				<td><?= $f['username'] ?></td>
				<td><?= $f['nama_pembeli'] ?></td>
				<td><?= date("d-m-Y",strtotime($f['tgl_transaksi'])) ?></td>
			
				<td>Rp. <?= number_format($f['total_bayar']) ?></td>
				<td>
					<a href="?action=detail_transaksi&id_transaksi=<?= $f['id_transaksi'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Lihat</span><i class="fa fa-eye"></i></a>
					<a onclick="return confirm('yakin ingin menghapus <?= $f['no_invoice']." (id : ".$f['id_transaksi'] ?>) ?')" href="handler.php?action=delete_transaksi&id=<?= $f['id_transaksi'] ?>" class="btn redtbl"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			<?php
		}
	}
	
	function filter_tampil_laporan($tanggal,$aksi){
		if ($aksi==1) {
			$split1=explode('-',$tanggal);
			$tanggal=$split1[2]."-".$split1[1]."-".$split1[0];
			$query=$this->con->query("select transaksi.id_transaksi,transaksi.tgl_transaksi,transaksi.no_invoice,transaksi.total_bayar,transaksi.nama_pembeli,user.username from transaksi inner join user on transaksi.kode_kasir=user.id where transaksi.tgl_transaksi like '%$tanggal%' order by transaksi.id_transaksi desc");
		}else{
			$split1=explode('-',$tanggal);
			$tanggal=$split1[1]."-".$split1[0];
			$query=$this->con->query("select transaksi.id_transaksi,transaksi.tgl_transaksi,transaksi.no_invoice,transaksi.total_bayar,transaksi.nama_pembeli,user.username from transaksi inner join user on transaksi.kode_kasir=user.id where transaksi.tgl_transaksi like '%$tanggal%' order by transaksi.id_transaksi desc");
		}

		$no=1;
		while ($f=$query->fetch_assoc()) {
			?>
			<tr>
				<td><?= $no++ ?></td>
				<td><?= $f['no_invoice'] ?></td>
				<td><?= $f['username'] ?></td>
				<td><?= $f['nama_pembeli'] ?></td>
				<td><?= date("d-m-Y",strtotime($f['tgl_transaksi'])) ?></td>
				<td>Rp. <?= number_format($f['total_bayar']) ?></td>
				<td>
					<a href="?action=detail_transaksi&id_transaksi=<?= $f['id_transaksi'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Lihat</span><i class="fa fa-eye"></i></a>
					<a onclick="return confirm('yakin ingin menghapus <?= $f['no_invoice']." (id : ".$f['id_transaksi'] ?>) ?')" href="handler.php?action=delete_transaksi&id=<?= $f['id_transaksi'] ?>" class="btn redtbl"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			<?php
		}
	}
	function filter_tampil_laporan_pembelian($tanggal,$aksi){
		if ($aksi==1) {
			$split1=explode('-',$tanggal);
			$tanggal=$split1[2]."-".$split1[1]."-".$split1[0];
			$query=$this->con->query("select * from tempo_pem where tgl_add like '%$tanggal%' order by tgl_add desc");
		}else{
			$split1=explode('-',$tanggal);
			$tanggal=$split1[1]."-".$split1[0];
			$query=$this->con->query("select * from tempo_pem where tgl_add like '%$tanggal%' order by tgl_add desc");
		}

		$no=1;
		while ($f=$query->fetch_assoc()) {
			?>
			<tr>
				<td><?= $no++ ?></td>
				<td><?= date("d-m-Y",strtotime($f['tgl_add'])) ?></td>
				<td><?= $f['nama_barang'] ?></td>
				<td><?= $f['stok'] ?></td>
				<td>Rp. <?= number_format($f['harga_beli']) ?></td>
				<td>
					<a onclick="return confirm('yakin ingin menghapus <?= " (id : ".$f['id_subpem'] ?>) ?')" href="handler.php?action=delete_pembelian&id=<?= $f['id_subpem'] ?>" class="btn redtbl"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			<?php
		}
	}
	function filter_tampil_laporan_return_pembelian($tanggal,$aksi){
		if ($aksi==1) {
			$split1=explode('-',$tanggal);
			$tanggal=$split1[2]."-".$split1[1]."-".$split1[0];
			$query=$this->con->query("select return_pembelian.id_return_pembelian,return_pembelian.tgl_return_pembelian,return_pembelian.kode_kasir,return_pembelian.total_bayar,return_pembelian.no_invoice,supplier.nama_supplier,user.username from return_pembelian inner join supplier on supplier.id_supplier=return_pembelian.id_supplier inner join user on user.id = return_pembelian.kode_kasir where return_pembelian.tgl_return_pembelian like '%$tanggal%' order by return_pembelian.tgl_return_pembelian desc");
		}else{
			$split1=explode('-',$tanggal);
			$tanggal=$split1[1]."-".$split1[0];
			$query=$this->con->query("select return_pembelian.id_return_pembelian,return_pembelian.tgl_return_pembelian,return_pembelian.kode_kasir,return_pembelian.total_bayar,return_pembelian.no_invoice,supplier.nama_supplier,user.username from return_pembelian inner join supplier on supplier.id_supplier=return_pembelian.id_supplier inner join user on user.id = return_pembelian.kode_kasir where return_pembelian.tgl_return_pembelian like '%$tanggal%' order by return_pembelian.tgl_return_pembelian desc");
		}

		$no=1;
		while ($f=$query->fetch_assoc()) {
			?>
			<tr>
				<td><?= $no++ ?></td>
				<td><?= $f['no_invoice'] ?></td>
				<td><?= $f['username'] ?></td>
				<td><?= $f['nama_supplier'] ?></td>
				<td><?= date("d-m-Y",strtotime($f['tgl_return_pembelian'])) ?></td>
				<td>Rp. <?= number_format($f['total_bayar']) ?></td>
				<td>
					<a href="?action=detail_return_pembelian&id_return_pembelian=<?= $f['id_return_pembelian'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Lihat</span><i class="fa fa-eye"></i></a>
					<a onclick="return confirm('yakin ingin menghapus <?= $f['no_invoice']." (id : ".$f['id_return_pembelian'] ?>) ?')" href="handler.php?action=delete_return_pembelian&id=<?= $f['id_return_pembelian'] ?>" class="btn redtbl"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			<?php
		}
	}
		function filter_tampil_laporan_return_penjualan($tanggal,$aksi){
		if ($aksi==1) {
			$split1=explode('-',$tanggal);
			$tanggal=$split1[2]."-".$split1[1]."-".$split1[0];
			$query=$this->con->query("select return_penjualan.id_return_penjualan,return_penjualan.tgl_return_penjualan,user.username,return_penjualan.total_bayar,return_penjualan.no_invoice,return_penjualan.nama_pembeli,user.id from return_penjualan inner join user on user.id = return_penjualan.kode_kasir where return_penjualan.tgl_return_penjualan like '%$tanggal%' order by return_penjualan.tgl_return_penjualan desc");
		}else{
			$split1=explode('-',$tanggal);
			$tanggal=$split1[1]."-".$split1[0];
			$query=$this->con->query("select return_penjualan.id_return_penjualan,return_penjualan.tgl_return_penjualan,user.username,return_penjualan.total_bayar,return_penjualan.no_invoice,return_penjualan.nama_pembeli,user.id from return_penjualan inner join user on user.id = return_penjualan.kode_kasir where return_penjualan.tgl_return_penjualan like '%$tanggal%' order by return_penjualan.tgl_return_penjualan desc");
		}

		$no=1;
		while ($f=$query->fetch_assoc()) {
			?>
			<tr>
				<td><?= $no++ ?></td>
				<td><?= $f['no_invoice'] ?></td>
				<td><?= $f['username'] ?></td>
				<td><?= $f['nama_pembeli'] ?></td>
				<td><?= date("d-m-Y",strtotime($f['tgl_return_penjualan'])) ?></td>
				<td>Rp. <?= number_format($f['total_bayar']) ?></td>
				<td>
					<a href="?action=detail_return_penjualan&id_return_penjualan=<?= $f['id_return_penjualan'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Lihat</span><i class="fa fa-eye"></i></a>
					<a onclick="return confirm('yakin ingin menghapus <?= $f['no_invoice']." (id : ".$f['id_return_penjualan'] ?>) ?')" href="handler.php?action=delete_return_penjualan&id=<?= $f['id_return_penjualan'] ?>" class="btn redtbl"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			<?php
		}
	}
	function filter_tampil_laporan_pengeluaran($tanggal,$aksi){
		if ($aksi==1) {
			$split1=explode('-',$tanggal);
			$tanggal=$split1[2]."-".$split1[1]."-".$split1[0];
			$query=$this->con->query("select pengeluaran.id_pengeluaran,pengeluaran.tgl_pengeluaran,pengeluaran.total_pengeluaran,pengeluaran.no_invoice,user.username from pengeluaran inner join user on pengeluaran.kode_kasir=user.id where pengeluaran.tgl_pengeluaran like '%$tanggal%' order by pengeluaran.id_pengeluaran desc");
		}else{
			$split1=explode('-',$tanggal);
			$tanggal=$split1[1]."-".$split1[0];
			$query=$this->con->query("select pengeluaran.id_pengeluaran,pengeluaran.tgl_pengeluaran,pengeluaran.total_pengeluaran,pengeluaran.no_invoice,user.username from pengeluaran inner join user on pengeluaran.kode_kasir=user.id where pengeluaran.tgl_pengeluaran like '%$tanggal%' order by pengeluaran.id_pengeluaran desc");
		}

		$no=1;
		while ($f=$query->fetch_assoc()) {
			?>
			<tr>
				<td><?= $no++ ?></td>
				<td><?= $f['no_invoice'] ?></td>
				<td><?= $f['username'] ?></td>
				<td><?= date("d-m-Y",strtotime($f['tgl_pengeluaran'])) ?></td>
				<td>Rp. <?= number_format($f['total_pengeluaran']) ?></td>
				<td>
					<a href="?action=detail_pengeluaran&id_pengeluaran=<?= $f['id_pengeluaran'] ?>" class="btn bluetbl m-r-10"><span class="btn-edit-tooltip">Lihat</span><i class="fa fa-eye"></i></a>
					<a onclick="return confirm('yakin ingin menghapus <?= $f['no_invoice']." (id : ".$f['id_pengeluaran'] ?>) ?')" href="handler.php?action=delete_pengeluaran&id=<?= $f['id_pengeluaran'] ?>" class="btn redtbl"><span class="btn-hapus-tooltip">Hapus</span><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			<?php
		}
	}
	function show_jumlah_cat(){
		$query=$this->con->query("select * from kategori");
		echo $query->num_rows;
	}
	function show_jumlah_barang(){
		$query=$this->con->query("select * from barang");
		echo $query->num_rows;
	}
		function show_jumlah_agen(){
		$query=$this->con->query("select * from agen");
		echo $query->num_rows;
	}
	function show_jumlah_supplier(){
		$query=$this->con->query("select * from supplier");
		echo $query->num_rows;
	}
	function show_jumlah_kasir(){
		$query=$this->con->query("select * from user where status='2'");
		echo $query->num_rows;
	}
	function show_jumlah_trans(){
		$query=$this->con->query("select * from transaksi where kode_kasir='$_SESSION[id]'");
		echo $query->num_rows;
	}
	function show_jumlah_pembe(){
		$query=$this->con->query("select * from pembelian");
		echo $query->num_rows;
	}
	function show_jumlah_trans2(){
		$query=$this->con->query("select * from transaksi");
		echo $query->num_rows;
	}

	function hapus_pengeluaran($id_pengeluaran_jenis){
		$query=$this->con->query("delete from pengeluaran_jenis where id_pengeluaran_jenis='$id_pengeluaran_jenis'");
		if ($query === TRUE) {
			$this->alert("Pengeluaran id $id_pengeluaran_jenis telah dihapus");
			$this->redirect("pengeluaran.php");
		}
	}
	function hapus_kategori($id_kategori){
		$query=$this->con->query("delete from kategori where id_kategori='$id_kategori'");
		if ($query === TRUE) {
			$this->alert("Kategori id $id_kategori telah dihapus");
			$this->redirect("kategori.php");
		}
	}
	function hapus_barang($id_barang){
		$query=$this->con->query("delete from barang where id_barang='$id_barang'");
		if ($query === TRUE) {
			$this->alert("barang id $id_barang telah dihapus");
			$this->redirect("barang.php");
		}
	}
	function hapus_supplier($id_supplier){
		$query=$this->con->query("delete from supplier where id_supplier='$id_supplier'");
		if ($query === TRUE) {
			$this->alert("barang id $id_supplier telah dihapus");
			$this->redirect("supplier.php");
		}
	}
	function hapus_agen($id_agen){
		$query=$this->con->query("delete from agen where id_agen='$id_agen'");
		if ($query === TRUE) {
			$this->alert("Agen id $id_agen telah dihapus");
			$this->redirect("agen.php");
		}
	}
	function hapus_user($id_user){
		$query=$this->con->query("delete from user where id='$id_user'");
		if ($query === TRUE) {
			$this->alert("Kasir id : $id_user berhasil dihapus");
			$this->redirect("users.php");
		}
	}
	function edit_kategori($id_kategori){
		$query=$this->con->query("select * from kategori where id_kategori='$id_kategori'");
		$data=$query->fetch_assoc();
		return $data;
	}
	function edit_barang($id_barang){
		$query=$this->con->query("select * from barang where id_barang='$id_barang'");
		$data=$query->fetch_assoc();
		return $data;
	}
	function edit_supplier($id_supplier){
		$query=$this->con->query("select * from supplier where id_supplier='$id_supplier'");
		$data=$query->fetch_assoc();
		return $data;
	}
	function edit_agen($id_agen){
		$query=$this->con->query("select * from agen where id_agen='$id_agen'");
		$data=$query->fetch_assoc();
		return $data;
	}
	function edit_kasir($id_kasir){
		$query=$this->con->query("select * from user where id='$id_kasir'");
		$data=$query->fetch_assoc();
		return $data;
	}
	function edit_admin(){
		$query=$this->con->query("select * from user where id='1'");
		$data=$query->fetch_assoc();
		return $data;
	}
	function aksi_edit_kategori($id_kategori,$nama_kategori){
		$query=$this->con->query("update kategori set nama_kategori='$nama_kategori' where id_kategori='$id_kategori'");
		 if ($query === TRUE) {
		 	$this->alert("Kategori berhasil di update");
		 	$this->redirect("kategori.php");
		 }else{
		 	$this->alert("Kategori gagal di update");
		 	$this->redirect("kategori.php");

		 }
	}
	function aksi_edit_pengeluaran($id_pengeluaran_jenis,$keterangan){
		$query=$this->con->query("update pengeluaran_jenis set keterangan='$keterangan' where id_pengeluaran_jenis='$id_pengeluaran_jenis'");
		 if ($query === TRUE) {
		 	$this->alert("Pengeluaran berhasil di update");
		 	$this->redirect("pengeluaran.php");
		 }else{
		 	$this->alert("Pengeluaran gagal di update");
		 	$this->redirect("pengeluaran.php");

		 }
	}
	function aksi_edit_barang($id_barang,$nama_barang,$stok,$harga_beli,$harga_jual,$id_kategori){
		$query=$this->con->query("update barang set nama_barang='$nama_barang',stok='$stok',harga_beli='$harga_beli',harga_jual='$harga_jual',id_kategori='$id_kategori',date_added=date_added where id_barang='$id_barang'");
		if ($query === TRUE) {
		 	$this->alert("Barang berhasil di update");
		 	$this->redirect("barang.php");
		}
		else{
		 	$this->alert("Barang gagal di update");
		 	$this->redirect("barang.php");
		 }
	}
	function aksi_edit_supplier($nama_supplier,$alamat,$hp,$info,$id_supplier){
		$query=$this->con->query("update supplier set nama_supplier='$nama_supplier',alamat='$alamat',hp='$hp',info='$info' where id_supplier='$id_supplier'");
		if ($query === TRUE) {
		 	$this->alert("Data Supplier berhasil di update");
		 	$this->redirect("supplier.php");
		}
		else{
		 	$this->alert("Data Supplier gagal di update");
		 	$this->redirect("supplier.php");
		 }
	}
	function aksi_edit_agen($nama_agen,$alamat,$facebook,$instagram,$whastapp,$bbm,$hp,$id_agen){
		$query=$this->con->query("update agen set nama_agen='$nama_agen',alamat='$alamat',facebook='$facebook',instagram='$instagram',whastapp='$whastapp',bbm='$bbm' ,hp='$hp' where id_agen='$id_agen'");
		if ($query === TRUE) {
		 	$this->alert("Data Supplier berhasil di update");
		 	$this->redirect("agen.php");
		}
		else{
		 	$this->alert("Data Supplier gagal di update");
		 	$this->redirect("agen.php");
		 }
	}
	function aksi_edit_kasir($username,$password,$id){
		if (empty($password)) {
			$query=$this->con->query("update user set username='$username',date_created=date_created where id='$id'");
		}else{
			$password=sha1($password);
			$query=$this->con->query("update user set username='$username',password='$password',date_created=date_created where id='$id'");
		}

		if ($query === TRUE) {
			$this->alert("Kasir berhasil di update");
		 	$this->redirect("users.php");
		}else{
			$this->alert("User gagal di update");
		 	$this->redirect("user.php");
		}
	}
	function aksi_edit_admin($username,$password){
		if (empty($password)) {
			$query=$this->con->query("update user set username='$username',date_created=date_created where id='1'");
		}else{
			$password=sha1($password);
			$query=$this->con->query("update user set username='$username',password='$password',date_created=date_created where id='1'");
		}

		if ($query === TRUE) {
			$this->alert("admin berhasil di update, silahkan login kembali");
			session_start();
			session_destroy();
			$this->redirect("index.php");
		}else{
			$this->alert("admin gagal di update");
		 	$this->redirect("user.php");
		}
	}
	function tambah_tempo($id_barang,$jumlah,$trx,$diskon){
		$q1=$this->con->query("select * from barang where id_barang='$id_barang'");
		$data=$q1->fetch_assoc();
		if ($data['stok'] < $jumlah) {
			$this->alert("stock tidak mencukupi");
			$this->redirect("transaksi.php?action=transaksi_baru");
		}
		else{
			$q=$this->con->query("select * from tempo where id_barang='$id_barang'");
			if ($q->num_rows > 0) {
				$jumbel=$ubah['jumlah_beli']+$jumlah; 
				$total_diskon =$diskon/100;
				$tdiskon= $data['harga_jual']*$total_diskon;
				$hasil = $data['harga_jual']-$tdiskon;
				$totals = $jumlah*$hasil;
				$hasila = $ubah['total_harga']+$totals;

				//$diskonper=$diskon;
				$dbquery=$this->con->query("update tempo set jumlah_beli='$jumbel',total_harga='$hasila',diskon='$diskon' where id_barang='$id_barang'");
					if ($dbquery === TRUE) {
					$this->con->query("update barang set stok=stok-$jumlah where id_barang='$id_barang'");
					$this->alert("Tersimpan");
					$this->redirect("transaksi.php?action=transaksi_baru");

				}
			}else{
				$jlaba = $jumlah*$data['harga_beli'];
			$total_diskon =$diskon/100;
				$tdiskon= $data['harga_jual']*$total_diskon;
				$hasil = $data['harga_jual']-$tdiskon;
				$totals = $jumlah*$hasil;
				$laba = $totals-$jlaba;
				$query1=$this->con->query("insert into tempo set id_barang='$id_barang',jumlah_beli='$jumlah',total_harga='$totals',diskon='$diskon',harga_set='$hasil',trx='$trx',hasil='$laba'");
				if ($query1 === TRUE) {
					$this->con->query("update barang set stok=stok-$jumlah where id_barang='$id_barang'");
					$this->alert("Tersimpan");
					$this->redirect("transaksi.php?action=transaksi_baru");

				}
			}
		}
	}
	function tambah_tempo_return_penjualan($id_barang,$jumlah,$trx,$diskon){
		$q1=$this->con->query("select * from barang where id_barang='$id_barang'");
		$data=$q1->fetch_assoc();
		if ($data['stok'] < $jumlah) {
			$this->alert("stock tidak mencukupi");
			$this->redirect("transaksi.php?action=return_penjualan");
		}
		else{
			$q=$this->con->query("select * from tempo_return_penjualan where id_barang='$id_barang'");
			if ($q->num_rows > 0) {
				$ubah=$q->fetch_assoc();
				$jumbel=$ubah['jumlah_beli']+$jumlah;
				$total_harga=$jumlah*$data['harga_jual'];
				$total_diskon =$diskon/100;
				$tdiskon= $total_harga*$total_diskon;
				$hasil = $total_harga-$tdiskon;
				$hasila = $ubah['total_harga']+$hasil;
				//$diskonper=$diskon;
				$dbquery=$this->con->query("update tempo_return_penjualan set jumlah_beli='$jumbel',total_harga='$hasila',diskon='$diskon' where id_barang='$id_barang'");
					if ($dbquery === TRUE) {
					$this->con->query("update barang set stok=stok+$jumlah where id_barang='$id_barang'");
					$this->alert("Tersimpan");
					$this->redirect("transaksi.php?action=return_penjualan");

				}
			}else{
				$total_harga=$jumlah*$data['harga_jual'];
				$total_diskon =$diskon/100;
				$tdiskon= $total_harga*$total_diskon;
				$hasil = $total_harga-$tdiskon;
				//$diskonper = $diskon;
				$query1=$this->con->query("insert into tempo_return_penjualan set id_barang='$id_barang',jumlah_beli='$jumlah',total_harga='$hasil',diskon='$diskon',trx='$trx'");
				if ($query1 === TRUE) {
					$this->con->query("update barang set stok=stok+$jumlah where id_barang='$id_barang'");
					$this->alert("Tersimpan");
					$this->redirect("transaksi.php?action=return_penjualan");

				}
			}
		}
	}
	function tambah_tempo_return_pembelian($id_barang,$jumlah,$trx,$diskon){
		$q1=$this->con->query("select * from barang where id_barang='$id_barang'");
		$data=$q1->fetch_assoc();
		if ($data['stok'] < $jumlah) {
			$this->alert("stock tidak mencukupi");
			$this->redirect("transaksi.php?action=return_pembelian");
		}
		else{
			$q=$this->con->query("select * from tempo_return_pembelian where id_barang='$id_barang'");
			if ($q->num_rows > 0) {
				$ubah=$q->fetch_assoc();
				$jumbel=$ubah['jumlah_beli']+$jumlah;
				$total_harga=$jumbel*$data['harga_beli'];
				//$diskonper=$diskon;
				$dbquery=$this->con->query("update tempo_return_pembelian set jumlah_beli='$jumbel',total_harga='$total_harga' where id_barang='$id_barang'");
					if ($dbquery === TRUE) {
					$this->con->query("update barang set stok=stok-$jumlah where id_barang='$id_barang'");
					$this->alert("Tersimpan");
					$this->redirect("pembelian.php?action=return_pembelian");

				}
			}else{
				$total_harga=$jumlah*$data['harga_beli'];
				//$diskonper = $diskon;
				$query1=$this->con->query("insert into tempo_return_pembelian set id_barang='$id_barang',jumlah_beli='$jumlah',total_harga='$total_harga',trx='$trx'");
				if ($query1 === TRUE) {
					$this->con->query("update barang set stok=stok-$jumlah where id_barang='$id_barang'");
					$this->alert("Tersimpan");
					$this->redirect("pembelian.php?action=return_pembelian");

				}
			}
		}
	}
	function tambah_tempo_peng($jenis,$jumlah,$trx,$total,$detail){
		$q1=$this->con->query("select * from pengeluaran_jenis where id_pengeluaran_jenis='$jenis'");
				$query=$this->con->query("insert into tempo_peng set id_pengeluaran_jenis='$jenis',uang='$total',detail_keperluan='$detail',trx='$trx' ");
				if ($query === TRUE) {
					$this->alert("Tersimpan");
					$this->redirect("pengeluaran.php?action=pengeluaran_baru");

				}
	}
	function tambah_tempo_pem($id_barang,$nama_barang,$stok,$harga_beli,$harga_jual,$id_kategori,$trx){
			$total_harga=$stok*$harga_beli;
				$query1=$this->con->query("insert into tempo_pem set id_barang='$id_barang',nama_barang='$nama_barang',id_kategori='$id_kategori',stok='$stok',harga_beli='$harga_beli',harga_jual='$harga_jual',total_harga='$total_harga',trx='$trx'");
				if ($query1 === TRUE) {
					$this->alert("Tersimpan");
					$this->redirect("pembelian.php?action=transaksi_baru");

				}
	}
	function hapus_tempo_pem($id_tempo_pem){
		$query=$this->con->query("delete from tempo_pem where id_subpem='$id_tempo_pem'");
			if ($query===TRUE) {
			$this->alert("Barang berhasil dicancel");
			$this->redirect("pembelian.php?action=transaksi_baru");

		}
	}
	function hapus_tempo_peng($id_tempo_peng){
		$query=$this->con->query("delete from tempo_peng where id_detail_pengeluaran='$id_tempo_peng'");
			if ($query===TRUE) {
			$this->alert("Barang berhasil dicancel");
			$this->redirect("pengeluaran.php?action=pengeluaran_baru");

		}
	}
	function hapus_tempo($id_tempo,$id_barang,$jumbel){
		$query=$this->con->query("delete from tempo where id_subtransaksi='$id_tempo'");
			if ($query===TRUE) {
			$query2=$this->con->query("update barang set stok=stok+$jumbel where id_barang='$id_barang'");
			$this->alert("Barang berhasil dicancel");
			$this->redirect("transaksi.php?action=transaksi_baru");

		}
	}
	function hapus_tempo_return_penj($id_tempo_return_penj,$id_barang,$jumbel){
		$query=$this->con->query("delete from tempo_return_penjualan where id_subreturnpenj='$id_tempo_return_penj'");
			if ($query===TRUE) {
			$query2=$this->con->query("update barang set stok=stok-$jumbel where id_barang='$id_barang'");
			$this->alert("Barang berhasil dicancel");
			$this->redirect("transaksi.php?action=return_penjualan");

		}
	}
	function hapus_tempo_return_pem($id_tempo,$id_barang,$jumbel){
		$query=$this->con->query("delete from tempo_return_pembelian where id_subreturnpem='$id_tempo'");
			if ($query===TRUE) {
			$query2=$this->con->query("update barang set stok=stok+$jumbel where id_barang='$id_barang'");
			$this->alert("Barang berhasil dicancel");
			$this->redirect("pembelian.php?action=return_pembelian");

		}
	}
}

$root=new penjualan();
?>
