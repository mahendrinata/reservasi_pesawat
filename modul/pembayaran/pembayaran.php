<?php
switch($_GET[act])
{
	default:
?>
	<div id='tengah'>
		<h2>Data Pemesanan</h2>
		<div style='clear : both'></div>
		<hr><br>
		<form method="post" action="index.php?p=pembayaran&act=data_pemesan">
		<table width='100%'>
			<tr>
				<th>Kode Pemesanan</th>
				<td><input type="text" class="field2" name="kode"></td>
			</tr>
		</table>
		<br>
		<br>
		<input type="submit" id="search-btn" value="Cari">
		</form>
	</div>
<?php
	break;
	
	case "data_pemesan":
		$q=mysql_query("SELECT tm_maskapai.maskapai_nama,
							tm_maskapai.maskapai_id,
							tt_jadwal.jadwal_id,
							tt_jadwal.jadwal_berangkat,
							tt_jadwal.jadwal_tiba,
							tt_pesawat_kota.pesawat_kota_asal,
							tt_pesawat_kota.pesawat_kota_tujuan,
							(SELECT tp_kota.kota_nama FROM tp_kota WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_asal) AS pesawat_kota_asal_nama,
							(SELECT tp_kota.kota_nama FROM tp_kota WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_tujuan) AS pesawat_kota_tujuan_nama,
							tm_kelas.kelas_nama,
							tt_jadwal_kelas.jadwal_kelas_harga,
							tm_pemesan.*
					FROM tt_pesawat_kota
						INNER JOIN tm_pesawat ON tm_pesawat.pesawat_id = tt_pesawat_kota.pesawat_id
						INNER JOIN tm_maskapai ON tm_maskapai.maskapai_id = tm_pesawat.maskapai_id
						INNER JOIN tt_jadwal ON tt_jadwal.pesawat_kota_id = tt_pesawat_kota.pesawat_kota_id
						INNER JOIN tm_pemesan ON tm_pemesan.jadwal_id=tt_jadwal.jadwal_id
							AND tm_pemesan.pemesan_kode='$_POST[kode]'
							AND (tm_pemesan.pemesan_aktif='Y')
						INNER JOIN tt_jadwal_kelas ON tt_jadwal_kelas.jadwal_id = tt_jadwal.jadwal_id
							AND tt_jadwal_kelas.kelas_id = tm_pemesan.kelas_id
						INNER JOIN tm_kelas ON tm_kelas.kelas_id=tt_jadwal_kelas.kelas_id
					");
		$r=mysql_fetch_array($q);
		if($r[pemesan_pengenal] != "")
		{
		$berangkat= tgl_indo($r[jadwal_berangkat]);
		$datang= tgl_indo($r[jadwal_tiba]);
		echo"<div id='tengah'>
		<h2>Data Pemesanan Tiket</h2>
		<div style='clear : both'></div>
		<hr><br>
		<form method='post' action='modul/pembayaran/aksi_pembayaran.php'>
		<table border='0' width='100%'>
		<tr>
			<th width='200px'>Nama<th>
			<td> : $r[pemesan_nama]</td>
		</tr>
		<tr>
			<th>No. KTP/SIM<th>
			<td> : $r[pemesan_pengenal]</td>
		</tr>
		<tr>
			<th>No. Telepon<th>
			<td> : $r[pemesan_telp]</td>
		</tr>
		<tr>
			<th>Email<th>
			<td> : $r[pemesan_email]</td>
		</tr>
		<tr>
			<th>Alamat<th>
			<td> : $r[pemesan_alamat]</td>
		</tr>
		<tr>
			<th>Kode Pemesanan<th>
			<td> : $r[pemesan_kode]</td>
		</tr>
		<tr>
			<th>Maskapai Penerbangan<th>
			<td> : $r[maskapai_nama]</td>
		</tr>
		<tr>
			<th>Kota Berangkat<th>
			<td> : $r[pesawat_kota_asal_nama]</td>
		</tr>
		<tr>
			<th>Kota Tujuan<th>
			<td> : $r[pesawat_kota_tujuan_nama]</td>
		</tr>
		<tr>
			<th>Waktu Berangkat<th>
			<td> : $berangkat</td>
		</tr>
		<tr>
			<th>Waktu Tiba<th>
			<td> : $datang</td>
		</tr>
		<tr>
			<th>Kelas<th>
			<td> : $r[kelas_nama]</td>
		</tr>
		<tr>
			<th>Harga Tiket<th>
			<td> : Rp. $r[jadwal_kelas_harga]</td>
		</tr>";
		if($r[pemesan_kode_transfer] !="")
		{
		echo "<tr>
			<th>Kode Transfer<th>
			<td> : $r[pemesan_kode_transfer]</td>
		</tr>";
		}
		else
		{
		echo "
		<tr>
			<th>Kode Transfer<th>
			<td> : <input type='hidden' name='pemesan' value='$r[pemesan_id]'>
			<input type='text' name='kode_transfer' class='field2'></td>
		</tr>
		<tr>
			<th>&nbsp;<th>
			<td><input type='submit' id='search-btn' value='Submit'></td>
		</tr>
		";
		}
		if(($r[pemesan_transfer_nilai] != 0) && ($r[pemesan_disetujui] == "Y"))
		{
		echo "<tr>
			<th>Nominal Transfer<th>
			<td> : Rp. $r[pemesan_transfer_nilai]</td>
		</tr>
		<tr>
			<th>&nbsp;<th>
			<td><input type='button' id='search-btn' value='Cetak Tiket' onclick=location.href='modul/pembayaran/print_tiket.php'></td>
		</tr>";
		}
		echo "</table>
		</form>
		</div>";
		}
		else
		{
		echo"<div id='tengah'>
		<h2>Pemesanan Sudah Dibatalkan Karena Melebihi Waktu Aktif</h2>
		<div style='clear : both'></div>
		<hr><br>
		</div>";
		}

	break;
}
?>