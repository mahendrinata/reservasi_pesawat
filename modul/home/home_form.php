<?php
	echo "<form method='post' action='index.php?p=pemesanan&act=jadwal'>
		<input type='hidden' name='maskapai' value='$_GET[maskapai]'>
		<input type='hidden' name='asal' value='$_GET[asal]'>
		<input type='hidden' name='tujuan' value='$_GET[tujuan]'>
		<input type='hidden' name='tanggal' value='$_GET[tanggal]'>
		<input type='submit' name='search' id='search-btn' value='Cari'>
	</form>";
?>
