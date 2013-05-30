<?php
	include "../../config/koneksi.php";
	include "../../config/library.php";
	$kode= md5(md5($_POST[pengenal]).md5($_POST[telp]));
	mysql_query("INSERT INTO tm_pemesan (jadwal_id,
										kelas_id,
										pemesan_nama,
										pemesan_telp,
										pemesan_email,
										pemesan_pengenal,
										pemesan_alamat,
										pemesan_tanggal,
										pemesan_kode)
								VALUES('$_POST[jadwal]',
										'$_POST[kelas]',
										'$_POST[nama]',
										'$_POST[telp]',
										'$_POST[email]',
										'$_POST[pengenal]',
										'$_POST[alamat]',
										'$waktu_sekarang',
										'$kode')
				");
	header("Location:../../index.php?p=pemesanan&act=messege&kode=$kode");
?>