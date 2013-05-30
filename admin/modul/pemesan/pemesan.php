<?php
session_start();
 if (empty($_SESSION['admin_id']) || empty($_SESSION['admin_password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/pemesan/aksi_pemesan.php";
switch($_GET[act]){
  // Tampil pemesan
  default:
    echo "<h2>Data Pemesan</h2>
          <table>
          <tr>
		  	<th>No</th>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Telepon</th>
			<th>Email</th>
			<th>Pengenal ID</th>
			<th>Tanggal</th>
			<th>Status Pemesanan</th>
			<th>Status Pemesan</th>
			<th>Aksi</th>
		</tr>"; 
    $tampil=mysql_query("SELECT tm_pemesan.* FROM tm_pemesan ORDER BY pemesan_tanggal DESC");
    $no=1;
    while ($r=mysql_fetch_array($tampil))
	{
	$tanggal= tgl_indo($r[pemesan_tanggal]);
       echo "<tr><td>$no</td>
             <td>$r[pemesan_nama]</td>
             <td>$r[pemesan_alamat]</td>
             <td>$r[pemesan_telp]</td>
             <td>$r[pemesan_email]</td>
             <td>$r[pemesan_pengenal]</td>
             <td>$tanggal</td>
             <td>";
			 if($r[pemesan_disetujui]=="Y")
			 	echo "Disetujui";
			else
				echo "Belum Disetuji";
			 echo"</td>
             <td>";
			 if($r[pemesan_aktif]=="Y")
			 	echo "Aktif";
			else
				echo "Tidak Aktif";
			 echo"</td>
             <td><a href=?p=pemesan&act=editpemesan&pemesan_id=$r[pemesan_id]><b>Detail</b></a>
             </td></tr>";
      $no++;
    }
    echo "</table>";
    break;
    
  // Form Edit Menu Utama
  case "editpemesan":
    echo "<h2>Data Pemesan</h2>
          <input type=button class='tombol' value='Kembali' 
          onclick=\"window.location.href='?p=pemesan';\">";
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
							AND tm_pemesan.pemesan_id='$_GET[pemesan_id]'
						INNER JOIN tt_jadwal_kelas ON tt_jadwal_kelas.jadwal_id = tt_jadwal.jadwal_id
							AND tt_jadwal_kelas.kelas_id = tm_pemesan.kelas_id
						INNER JOIN tm_kelas ON tm_kelas.kelas_id=tt_jadwal_kelas.kelas_id
					");
		$r=mysql_fetch_array($q);
		if($r[pemesan_pengenal] != "")
		{
		$berangkat= tgl_indo($r[jadwal_berangkat]);
		$datang= tgl_indo($r[jadwal_tiba]);
		echo"
		<form method='post' action='$aksi?act=update'>
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
			<td> : $r[pemesan_kode_transfer] <input type='hidden' name='pemesan_id' value='$r[pemesan_id]'></td>
		</tr>";
		if($r[pemesan_transfer_nilai] != "" AND $r[pemesan_transfer_nilai] != 0)
		{
		echo"<tr>
			<th>Nominal Transfer<th>
			<td> : Rp. $r[pemesan_transfer_nilai]
			<input type='hidden' name='pemesan_transfer_nilai' value='$r[pemesan_transfer_nilai]'>
			</td>
		</tr>";
		}
		else
		{
		echo"<tr>
			<th>Nominal Transfer<th>
			<td> : <input type='text' name='pemesan_transfer_nilai' size='40'></td>
		</tr>";
		}
		echo "<tr>
			<th>Status Pemesanan<th>
			<td> : ";
			if($r[pemesan_disetujui] == "Y")
			{
				echo"<input type='radio' name='pemesan_disetujui' value='Y' checked='checked'> Disetujui 
				 <input type='radio' name='pemesan_disetujui' value='N'> Belum Disetujui";
			}
			else
			{
				echo"<input type='radio' name='pemesan_disetujui' value='Y'> Disetujui 
				 <input type='radio' name='pemesan_disetujui' value='N' checked='checked'> Belum Disetujui";
			}
			echo"</td>
		</tr>";		
		if(($r[pemesan_transfer_nilai] == "" AND $r[pemesan_transfer_nilai] == 0) || $r[pemesan_disetujui] == "N")
		{
		echo"<tr>
			<th>&nbsp;<th>
			<td><input type='submit' class='submit' value='Simpan'></td>
		</tr>";
		}
		}
		echo "</table>
		</form>
";
    break;  
}
}
}
?>
