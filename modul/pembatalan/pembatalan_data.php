<?php
	include "../../config/koneksi.php";
	include "../../config/fungsi_indotgl.php";
	$tanggal= tgl_indo($_GET[tanggal]);
			$q=mysql_query("SELECT tm_maskapai.maskapai_nama,
							tt_jadwal.jadwal_id,
							tm_kelas.kelas_id,
							tt_jadwal.jadwal_berangkat,
							tt_jadwal.jadwal_tiba,
							(SELECT tp_kota.kota_nama FROM tp_kota WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_asal) AS pesawat_kota_asal_nama,
							(SELECT tp_kota.kota_nama FROM tp_kota WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_tujuan) AS pesawat_kota_tujuan_nama,
							tm_kelas.kelas_nama,
							tt_jadwal_kelas.jadwal_kelas_harga,
							tt_jadwal_kelas.jadwal_kelas_max,
							(SELECT COUNT(*) FROM tm_pemesan 
							WHERE tm_pemesan.jadwal_id = tt_jadwal.jadwal_id
								AND tm_pemesan.kelas_id = tm_kelas.kelas_id
								AND tm_pemesan.pemesan_aktif='Y') AS jumlah_pemesan
					FROM tt_pesawat_kota
						INNER JOIN tm_pesawat ON tm_pesawat.pesawat_id = tt_pesawat_kota.pesawat_id
						INNER JOIN tm_maskapai ON tm_maskapai.maskapai_id = tm_pesawat.maskapai_id
							AND tm_maskapai.maskapai_id = '$_GET[maskapai]'
						INNER JOIN tt_jadwal ON tt_jadwal.pesawat_kota_id = tt_pesawat_kota.pesawat_kota_id
								AND tt_jadwal.jadwal_berangkat LIKE '$_GET[tanggal]%'
						INNER JOIN tt_jadwal_kelas ON tt_jadwal_kelas.jadwal_id = tt_jadwal.jadwal_id
						INNER JOIN tm_kelas ON tm_kelas.kelas_id=tt_jadwal_kelas.kelas_id
					WHERE tt_pesawat_kota.pesawat_kota_asal = '$_GET[asal]'
							AND tt_pesawat_kota.pesawat_kota_tujuan = '$_GET[tujuan]'
					GROUP BY tm_maskapai.maskapai_nama,
							tt_jadwal.jadwal_berangkat,
							tt_jadwal.jadwal_tiba,
							pesawat_kota_asal_nama,
							pesawat_kota_tujuan_nama,
							tt_jadwal.jadwal_tiba,
							tm_kelas.kelas_nama,
							tt_jadwal_kelas.jadwal_kelas_harga,
							tt_jadwal_kelas.jadwal_kelas_max");
			echo "
			<div id='tengah'>
			<h2>Jadwal Alternatif Tanggal $tanggal</h2>
			<div style='clear : both'></div>	
			<hr><br>
			<table width='100%'>
			<tr>
				<th>Maskapai Pesawat</th>
				<th>Waktu Berangkat</th>
				<th>Waktu Tiba</th>
				<th>Kota Berangkat</th>
				<th>Kota Tujuan</th>
				<th>Kelas</th>
				<th>Harga</th>
				<th>Kuota</th>
				<th>Jumlah Pemesan</th>
				<th>&nbsp;</th>
			</tr>";
			while($r=mysql_fetch_array($q))
			{
				$berangkat= tgl_indo($r[jadwal_berangkat]);
				$datang= tgl_indo($r[jadwal_tiba]);
				echo "<tr>
					<td>$r[maskapai_nama]</td>
					<td>$berangkat</td>
					<td>$datang</td>
					<td>$r[pesawat_kota_asal_nama]</td>
					<td>$r[pesawat_kota_tujuan_nama]</td>
					<td>$r[kelas_nama]</td>
					<td align='right'>$r[jadwal_kelas_harga]</td>
					<td align='right'>$r[jadwal_kelas_max]</td>
					<td align='right'>$r[jumlah_pemesan]</td>
					<td>";
					if($r[jadwal_kelas_max] > $r[jumlah_pemesan])
						echo "<a href='modul/pembatalan/aksi_pembatalan.php?pemesan=$_GET[pemesan]&jadwal=$r[jadwal_id]&kelas=$r[kelas_id]' title='Ganti Jadwal'>Ganti</a>";
					echo"</td>
				</tr>";
			}
			echo "</table>
			</div>";
?>