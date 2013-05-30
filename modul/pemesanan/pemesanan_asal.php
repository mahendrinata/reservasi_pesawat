<?php
	include "../../config/koneksi.php";
	$q=mysql_query("SELECT tt_pesawat_kota.pesawat_kota_asal,
							tp_kota.kota_nama
					FROM tt_pesawat_kota
						INNER JOIN tm_pesawat ON tm_pesawat.pesawat_id = tt_pesawat_kota.pesawat_id
						INNER JOIN tm_maskapai ON tm_maskapai.maskapai_id = tm_pesawat.maskapai_id
							AND tm_maskapai.maskapai_id = '$_GET[maskapai]'
						INNER JOIN tp_kota ON tp_kota.kota_id = tt_pesawat_kota.pesawat_kota_asal
					ORDER BY tt_pesawat_kota.pesawat_kota_asal");
	echo "<option>Pilih Kota Asal</option>";
	while($r=mysql_fetch_array($q))
	{
		echo "<option value='$r[pesawat_kota_asal]'>$r[kota_nama]</option>";
	}
?>