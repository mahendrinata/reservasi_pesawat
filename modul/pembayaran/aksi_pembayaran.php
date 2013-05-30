<?php
	include "../../config/koneksi.php";
	mysql_query("UPDATE tm_pemesan SET pemesan_kode_transfer = '$_POST[kode_transfer]' WHERE pemesan_id='$_POST[pemesan]'");
	header("Location:../../index.php?p=pembayaran");
?>