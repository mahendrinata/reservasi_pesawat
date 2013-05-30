<?php
	include "../../config/koneksi.php";
	mysql_query("UPDATE tm_pemesan SET jadwal_id = '$_GET[jadwal]',
										kelas_id = '$_GET[kelas]'
								WHERE pemesan_id = '$_GET[pemesan]'
								");
	header("Location:../../index.php?p=pembatalan&act=messege");
?>