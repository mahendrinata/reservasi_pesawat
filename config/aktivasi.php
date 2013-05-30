<?php
	include "koneksi.php";
	include "library.php";
	
	$q=mysql_query("SELECT pemesan_id,pemesan_tanggal
				FROM tm_pemesan
				WHERE pemesan_aktif='Y'
				AND pemesan_disetujui='N'"
				);
	while($r=mysql_fetch_array($q))
	{
		$tanggal_data = substr($r[pemesan_tanggal],0,4).substr($r[pemesan_tanggal],5,2).substr($r[pemesan_tanggal],8,2);
		if($tgl_sekarang - $tanggal_data > 3)
		{
			mysql_query("UPDATE tm_pemesan SET pemesan_aktif = 'N' WHERE pemesan_id='$r[pemesan_id]'");
		}
	}
?>