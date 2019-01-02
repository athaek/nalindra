<?php
include "root.php";

if (isset($_GET['action'])) {
	$action=$_GET['action'];
	if ($action=="login") {
		$root->login($_POST['username'],$_POST['pass'],$_POST['loginas']);
	}
	if ($action=="logout") {
		session_start();
		session_destroy();
		$root->redirect("index.php");
	}
	if ($action=="tambah_pengeluaran") {
		$root->tambah_pengeluaran($_POST['keterangan']);
	}
	if ($action=="tambah_saldo") {
		$root->tambah_saldo($_POST['id_saldo'],$_POST['saldo']);
	}
	if ($action=="hapus_pengeluaran") {
		$root->hapus_pengeluaran($_GET['id_pengeluaran_jenis']);
	}
	if ($action=="edit_pengeluaran") {
		$root->aksi_edit_pengeluaran($_POST['keterangan'],$_POST['id_pengeluaran_jenis']);
	}
	if ($action=="tambah_agen") {
		$root->tambah_agen($_POST['kode_agen'],$_POST['nama_agen'],$_POST['alamat'],$_POST['facebook'],$_POST['instagram'],$_POST['whastapp'],$_POST['bbm'],$_POST['hp']);
	}
	if ($action=="tambah_supplier") {
		$root->tambah_supplier($_POST['kode_supplier'],$_POST['nama_supplier'],$_POST['alamat'],$_POST['hp'],$_POST['info']);
	}
	if ($action=="hapus_supplier") {
		$root->hapus_supplier($_GET['id_supplier']);
	}
	if ($action=="hapus_agen") {
		$root->hapus_agen($_GET['id_agen']);
	}
	if ($action=="edit_supplier") {
		$root->aksi_edit_supplier($_POST['nama_supplier'],$_POST['alamat'],$_POST['hp'],$_POST['info'],$_POST['id_supplier']);
	}

	if ($action=="edit_agen") {
		$root->aksi_edit_agen($_POST['nama_agen'],$_POST['alamat'],$_POST['facebook'],$_POST['instagram'],$_POST['whastapp'],$_POST['bbm'],$_POST['hp'],$_POST['id_agen']);
	}
	if ($action=="tambah_barang") {
		$root->tambah_barang(addslashes($_POST['nama_barang']),$_POST['stok'],$_POST['harga_beli'],$_POST['harga_jual'],$_POST['kategori']);
	}
	if ($action=="tambah_kategori") {
		$root->tambah_kategori($_POST['nama_kategori']);
	}
	if ($action=="hapus_kategori") {
		$root->hapus_kategori($_GET['id_kategori']);
	}
	if ($action=="edit_kategori") {
		$root->aksi_edit_kategori($_POST['id_kategori'],$_POST['nama_kategori']);
	}
	if ($action=="hapus_barang") {
		$root->hapus_barang($_GET['id_barang']);
	}
	if ($action=="edit_barang") {
		$query = $root->con->query("select * from barang where id_barang ='$_POST[id_barang]'");
		$data = $query->fetch_assoc();
		if ($_POST['stok'] != $data['stok']){
			$update = $_POST['stok'] - $data['stok'];
		$root->con->query("insert into tempo_pem set nama_barang='$_POST[nama_barang]',id_kategori='$_POST[kategori]',stok='$update',harga_beli='$_POST[harga_beli]',harga_jual='$_POST[harga_jual]'");
		}
		
		$root->aksi_edit_barang($_POST['id_barang'],$_POST['nama_barang'],$_POST['stok'],$_POST['harga_beli'],$_POST['harga_jual'],$_POST['kategori']);
	}
	if ($action=="tambah_agen") {
		$root->tambah_agen($_POST['kode_agen'],$_POST['nama_agen'],$_POST['alamat'],$_POST['facebook'],$_POST['instagram'],$_POST['whastapp'],$_POST['bbm'],$_POST['hp']);
	}
	if ($action=="hapus_agen") {
		$root->hapus_agen($_GET['id_agen']);
	}
	if ($action=="edit_agen") {
		$root->edit_agen($_POST['kode_agen'],$_POST['nama_agen'],$_POST['alamat'],$_POST['facebook'],$_POST['instagram'],$_POST['whastapp'],$_POST['bbm'],$_POST['hp'],$_POST['id_agen']);
	}
	if ($action=="tambah_kasir") {
		$root->tambah_kasir($_POST['nama_kasir'],$_POST['password']);
	}
	if ($action=="hapus_user") {
		$root->hapus_user($_GET['id_user']);
	}
	if ($action=="edit_kasir") {
		$root->aksi_edit_kasir($_POST['nama_kasir'],$_POST['password'],$_POST['id']);
	}
	if ($action=="edit_admin") {
		$root->aksi_edit_admin($_POST['username'],$_POST['password']);
	}
	if ($action=="reset_admin") {
		$pass=sha1("admin");
		$q=$root->con->query("update user set username='admin',password='$pass',date_created=date_created where id='1'");
		if ($q === TRUE) {
			$root->alert("admin berhasil direset, username & password = 'admin'");
			session_start();
			session_destroy();
			$root->redirect("index.php");
		}
	}
	if ($action=="tambah_tempo") {
		$root->tambah_tempo($_POST['id_barang'],$_POST['jumlah'],$_POST['trx'],$_POST['diskon']);
	}
	if ($action=="tambah_tempo_return_penjualan") {
		$root->tambah_tempo_return_penjualan($_POST['id_barang'],$_POST['jumlah'],$_POST['trx'],$_POST['diskon']);
	}
	if ($action=="tambah_tempo_return_pembelian") {
		$root->tambah_tempo_return_pembelian($_POST['id_barang'],$_POST['jumlah'],$_POST['trx'],$_POST['diskon']);
	}
	if ($action=="tambah_tempo_peng") {
		$root->tambah_tempo_peng($_POST['jenis'],$_POST['jumlah'],$_POST['trx'],$_POST['total'],$_POST['detail']);
	}
	if ($action=="tambah_tempo_pem") {
		$root->tambah_tempo_pem($_POST['id_barang'],$_POST['nama_barang'],$_POST['stok'],$_POST['harga_beli'],$_POST['harga_jual'],$_POST['kategori'],$_POST['trx']);
	}
	if ($action=="hapus_tempo") {
		$root->hapus_tempo($_GET['id_tempo'],$_GET['id_barang'],$_GET['jumbel'],$_POST['diskon']);
	}
	if ($action=="hapus_tempo_pem") {
		$root->hapus_tempo_pem($_GET['id_tempo_pem'],$_GET['id_barang'],$_GET['jumbel']);
	}
	if ($action=="hapus_tempo_return_pem") {
		$root->hapus_tempo_return_pem($_GET['id_tempo_return_pem'],$_GET['id_barang'],$_GET['jumbel']);
	}
	if ($action=="hapus_tempo_return_penj") {
		$root->hapus_tempo_return_penj($_GET['id_tempo_return_penj'],$_GET['id_barang'],$_GET['jumbel']);
	}
	if ($action=="hapus_tempo_peng") {
		$root->hapus_tempo_peng($_GET['id_tempo_peng']);
	}
	if ($action=="selesai_transaksi") {
		session_start();
		$trx=date("d")."/ND/".$_SESSION['id']."/".date("y/h/i/s");
            $jumlah=$_POST[total_bayar]+$_POST[pengi];
			$query=$root->con->query("insert into transaksi set kode_kasir='$_SESSION[id]',total_bayar='$jumlah',no_invoice='$trx',nama_pembeli='$_POST[nama_pembeli]',biaya_pengiriman='$_POST[pengi]'");

		$trx2=date("d")."/ND/".$_SESSION['id']."/".date("y");
		$get1=$root->con->query("select *  from transaksi where no_invoice='$trx'");
		$datatrx=$get1->fetch_assoc();
		$id_transaksi2=$datatrx['id_transaksi'];

		$query2=$root->con->query("select * from tempo where trx='$trx2'");
		while ($f=$query2->fetch_assoc()) {
			$root->con->query("insert into sub_transaksi set id_barang='$f[id_barang]',id_transaksi='$id_transaksi2',jumlah_beli='$f[jumlah_beli]',total_harga='$f[total_harga]',no_invoice='$trx',diskon='$f[diskon]',harga_set='$f[harga_set]'");
			$query3=$root->con->query("select * from jumlah_saldo");
		$s=$query3->fetch_assoc();
		$id_saldo =1;
		$saldo = $f['hasil']+$s['saldo']; 
		$root->con->query("update jumlah_saldo set saldo='$saldo' where id_saldo='$id_saldo' ");
		}
		
		$root->con->query("delete from tempo where trx='$trx2'");
		$root->alert("Transaksi berhasil");
		$root->redirect("transaksi.php");


	}
	if ($action=="selesai_return") {
		session_start();
		$trx=date("d")."/ND/".$_SESSION['id']."/".date("y/h/i/s");

			$query=$root->con->query("insert into return_penjualan set kode_kasir='$_SESSION[id]',total_bayar='$_POST[total_bayar]',no_invoice='$trx',nama_pembeli='$_POST[nama_pembeli]'");

		$trx2=date("d")."/ND/".$_SESSION['id']."/".date("y");
		$get1=$root->con->query("select *  from return_penjualan where no_invoice='$trx'");
		$datatrx=$get1->fetch_assoc();
		$id_transaksi2=$datatrx['id_return_penjualan'];

		$query2=$root->con->query("select * from tempo_return_penjualan where trx='$trx2'");
		while ($f=$query2->fetch_assoc()) {
			$root->con->query("insert into sub_return_penjualan set id_barang='$f[id_barang]',id_return_penjualan='$id_transaksi2',jumlah_beli='$f[jumlah_beli]',total_harga='$f[total_harga]',no_invoice='$trx'");
		}
		$root->con->query("delete from tempo_return_penjualan where trx='$trx2'");
		$root->alert("Transaksi berhasil");
		$root->redirect("transaksi.php");


	}
	if ($action=="selesai_return_pembelian") {
		session_start();
		$trx=date("d")."/ND/".$_SESSION['id']."/".date("y/h/i/s");

			$query=$root->con->query("insert into return_pembelian set kode_kasir='$_SESSION[id]',total_bayar='$_POST[total_bayar]',no_invoice='$trx',id_supplier='$_POST[id_supplier]'");

		$trx2=date("d")."/ND/".$_SESSION['id']."/".date("y");
		$get1=$root->con->query("select * from return_pembelian where no_invoice='$trx'");
		$datatrx=$get1->fetch_assoc();
		$id_transaksi2=$datatrx['id_return_pembelian'];

		$query2=$root->con->query("select * from tempo_return_pembelian where trx='$trx2'");
		while ($f=$query2->fetch_assoc()) {
			$root->con->query("insert into detail_return_pembelian set id_barang='$f[id_barang]',id_return_pembelian ='$id_transaksi2',jumlah_beli='$f[jumlah_beli]',total_harga='$f[total_harga]',no_invoice='$trx'");
		}
		$root->con->query("delete from tempo_return_pembelian where trx='$trx2'");
		$root->alert("Transaksi berhasil");
		$root->redirect("transaksi.php");


	}
	if ($action=="selesai_pengeluaran") {
		session_start();
		$trx=date("d")."/ND/".$_SESSION['id']."/".date("y/h/i/s");

			$query=$root->con->query("insert into pengeluaran set kode_kasir='$_SESSION[id]',total_pengeluaran='$_POST[total_bayar]',no_invoice='$trx'");

		$trx2=date("d")."/ND/".$_SESSION['id']."/".date("y");
		$get1=$root->con->query("select *  from pengeluaran where no_invoice='$trx'");
		$datatrx=$get1->fetch_assoc();
		$id_transaksi2=$datatrx['id_pengeluaran'];

		$query2=$root->con->query("select * from tempo_peng where trx='$trx2'");
		while ($f=$query2->fetch_assoc()) {
			$root->con->query("insert into detail_pengeluaran set id_pengeluaran_jenis='$f[id_pengeluaran_jenis]',id_pengeluaran='$id_transaksi2',jumlah='$f[jumlah]',uang='$f[uang]',total_uang='$f[total_uang]',no_invoice='$trx',detail_keperluan='$f[detail_keperluan]'");
		}
		$query3=$root->con->query("select * from jumlah_saldo");
		$s=$query3->fetch_assoc();
		$id_saldo =1;
		$saldo = $s['saldo']-$_POST['total_bayar']; 
		$root->con->query("update jumlah_saldo set saldo='$saldo' where id_saldo='$id_saldo' ");
		$root->con->query("delete from tempo_peng where trx='$trx2'");
		$root->alert("Transaksi berhasil");
		$root->redirect("pengeluaran.php");


	}
	if ($action=="selesai_pembelian") {
		session_start();
		$trx=date("d")."/ND/".$_SESSION['id']."/".date("y/h/i/s");

			$query=$root->con->query("insert into pembelian set kode_kasir='$_SESSION[id]',total_bayar='$_POST[total_bayar]',no_invoice='$trx',id_supplier='$_POST[id_supplier]'");

		$trx2=date("d")."/ND/".$_SESSION['id']."/".date("y");
		$get1=$root->con->query("select *  from pembelian where no_invoice='$trx'");
		$datatrx=$get1->fetch_assoc();
		$id_transaksi2=$datatrx['id_pembelian'];

		$query2=$root->con->query("select * from tempo_pem where trx='$trx2'");
		while ($f=$query2->fetch_assoc()) {
			$root->con->query("insert into detail_pembelian set id_pembelian='$id_transaksi2',id_barang='$f[id_barang]',total_harga='$f[total_harga]',no_invoice='$trx'");
			$root->con->query("insert into barang set id_barang='$f[id_barang]',nama_barang='$f[nama_barang]',id_kategori='$f[id_kategori]',stok='$f[stok]',harga_beli='$f[harga_beli]',harga_jual='$f[harga_jual]' ");
		}
		$root->con->query("delete from tempo_pem where trx='$trx2'");
		$root->alert("Transaksi berhasil");
		$root->redirect("pembelian.php");


	}

	if ($action=="delete_transaksi") {
		$q1=$root->con->query("delete from transaksi where id_transaksi='$_GET[id]'");
		$q2=$root->con->query("delete from sub_transaksi where id_transaksi='$_GET[id]'");
		if ($q1===TRUE && $q2 === TRUE) {
			$root->alert("Transaksi No $_GET[id] Berhasil Dihapus");
			$root->redirect("laporan.php");
		}
	}

	if ($action=="delete_pembelian") {
		$q1=$root->con->query("delete from tempo_pem where id_subpem='$_GET[id]'");
		if ($q1===TRUE) {
			$root->alert("Pembelian No $_GET[id] Berhasil Dihapus");
			$root->redirect("laporan_pembelian.php");
		}
	}

	if ($action=="delete_pengeluaran") {
		$q1=$root->con->query("delete from pengeluaran where id_pengeluaran='$_GET[id]'");
		$q2=$root->con->query("delete from detail_pengeluaran where id_pengeluaran='$_GET[id]'");
		if ($q1===TRUE && $q2 === TRUE) {
			$root->alert("Pengeluaran No $_GET[id] Berhasil Dihapus");
			$root->redirect("laporan_pengeluaran.php");
		}
	}

		if ($action=="delete_return_pembelian") {
		$q1=$root->con->query("delete from return_pembelian where id_return_pembelian='$_GET[id]'");
		$q2=$root->con->query("delete from detail_return_pembelian where id_return_pembelian='$_GET[id]'");
		if ($q1===TRUE && $q2 === TRUE) {
			$root->alert("Pengeluaran No $_GET[id] Berhasil Dihapus");
			$root->redirect("return.php");
		}
	}
		if ($action=="delete_return_penjualan") {
		$q1=$root->con->query("delete from return_penjualan where id_return_penjualan='$_GET[id]'");
		$q2=$root->con->query("delete from sub_return_penjualan where id_return_penjualan='$_GET[id]'");
		if ($q1===TRUE && $q2 === TRUE) {
			$root->alert("Pengeluaran No $_GET[id] Berhasil Dihapus");
			$root->redirect("return.php");
		}
	}




}else{
	echo "no direct script are allowed";
}



?>
