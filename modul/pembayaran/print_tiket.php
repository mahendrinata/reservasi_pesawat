<?php
	include "../../config/koneksi.php";
	include "../../config/fungsi_indotgl.php";
	
	$q=mysql_query("SELECT tm_maskapai.maskapai_nama,
							tt_jadwal.jadwal_berangkat,
							tt_jadwal.jadwal_tiba,
							(SELECT tp_kota.kota_nama FROM tp_kota WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_asal) AS pesawat_kota_asal_nama,
							(SELECT tp_kota.kota_nama FROM tp_kota WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_tujuan) AS pesawat_kota_tujuan_nama,
							tm_kelas.kelas_nama,
							tt_jadwal_kelas.jadwal_kelas_harga,
							tm_pemesan.pemesan_alamat,
							tm_pemesan.pemesan_email,
							tm_pemesan.pemesan_nama,
							tm_pemesan.pemesan_pengenal,
							tm_pemesan.pemesan_telp,
							tm_pemesan.pemesan_kode
					FROM tt_pesawat_kota
						INNER JOIN tm_pesawat ON tm_pesawat.pesawat_id = tt_pesawat_kota.pesawat_id
						INNER JOIN tm_maskapai ON tm_maskapai.maskapai_id = tm_pesawat.maskapai_id
						INNER JOIN tt_jadwal ON tt_jadwal.pesawat_kota_id = tt_pesawat_kota.pesawat_kota_id
						INNER JOIN tm_pemesan ON tm_pemesan.jadwal_id=tt_jadwal.jadwal_id
							AND tm_pemesan.pemesan_kode='$_GET[kode]'						
						INNER JOIN tt_jadwal_kelas ON tt_jadwal_kelas.jadwal_id = tt_jadwal.jadwal_id
							AND tt_jadwal_kelas.kelas_id = tm_pemesan.kelas_id
						INNER JOIN tm_kelas ON tm_kelas.kelas_id=tt_jadwal_kelas.kelas_id
					");
		$r=mysql_fetch_array($q);
		$berangkat= tgl_indo($r[jadwal_berangkat]);
		$datang= tgl_indo($r[jadwal_tiba]);
		echo"<body  onLoad='javascript:window.print()'>
		<font face='Arial Black, Gadget, sans-serif' size='16pt'>
		Tiket Pesawat
		<br>
		<table border='0' width='80%'>
		<tr align='left'>
			<th width='300px'>Nama<th>
			<td> : $r[pemesan_nama]</td>
		</tr>
		<tr align='left'>
			<th>No. KTP/SIM<th>
			<td> : $r[pemesan_pengenal]</td>
		</tr>
		<tr align='left'>
			<th>No. Telepon<th>
			<td> : $r[pemesan_telp]</td>
		</tr>
		<tr align='left'>
			<th>Email<th>
			<td> : $r[pemesan_email]</td>
		</tr>
		<tr align='left'>
			<th>Alamat<th>
			<td> : $r[pemesan_alamat]</td>
		</tr>
		<tr align='left'>
			<th>Kode Pemesanan<th>
			<td> : $r[pemesan_kode]</td>
		</tr>
		<tr align='left'>
			<th>Maskapai Penerbangan<th>
			<td> : $r[maskapai_nama]</td>
		</tr>
		<tr align='left'>
			<th>Kota Berangkat<th>
			<td> : $r[pesawat_kota_asal_nama]</td>
		</tr>
		<tr align='left'>
			<th>Kota Tujuan<th>
			<td> : $r[pesawat_kota_tujuan_nama]</td>
		</tr>
		<tr align='left'>
			<th>Waktu Berangkat<th>
			<td> : $berangkat</td>
		</tr>
		<tr align='left'>
			<th>Waktu Tiba<th>
			<td> : $datang</td>
		</tr>
		<tr align='left'>
			<th>Kelas<th>
			<td> : $r[kelas_nama]</td>
		</tr>
		<tr align='left'>
			<th>Harga Tiket<th>
			<td> : Rp. $r[jadwal_kelas_harga]</td>
		</tr>
		</table>
		";
	
?>