<?php
session_start();
 if (empty($_SESSION['admin_id']) || empty($_SESSION['admin_password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/jadwal/aksi_jadwal.php";
switch($_GET[act]){
  // Tampil pesawat
  default:
    echo "<h2>Data Jadwal Keberangkatan</h2>
          <input type=button class='tombol' value='Tambah Jadwal' 
          onclick=\"window.location.href='?p=jadwal&act=tambahjadwal';\">
          <table>
          <tr>
		  	<th>No</th>
			<th>Nama Maskapai</th>
			<th>Pesawat Kode</th>
			<th>Kota Berangkat</th>
			<th>Kota Tujuan</th>
			<th>Waktu Berangkat</th>
			<th>Waktu Tiba</th>
			<th>Aksi</th>
		</tr>"; 
    $tampil=mysql_query("SELECT tm_maskapai.maskapai_nama,
							tm_pesawat.pesawat_id,
							tt_jadwal.jadwal_id,
							(SELECT tp_kota.kota_nama 
							FROM tp_kota 
							WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_asal) AS kota_nama_asal,
							(SELECT tp_kota.kota_nama 
							FROM tp_kota 
							WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_tujuan) AS kota_nama_tujuan,
							tt_jadwal.jadwal_berangkat,
							tt_jadwal.jadwal_tiba
						FROM tt_jadwal
							INNER JOIN tt_pesawat_kota ON tt_pesawat_kota.pesawat_kota_id = tt_jadwal.pesawat_kota_id
							INNER JOIN tm_pesawat ON tm_pesawat.pesawat_id = tt_pesawat_kota.pesawat_id
							INNER JOIN tm_maskapai ON tm_maskapai.maskapai_id=tm_pesawat.maskapai_id
						ORDER BY tt_jadwal.jadwal_berangkat");
    $no=1;
    while ($r=mysql_fetch_array($tampil))
	{
		$berangkat= tgl_indo($r[jadwal_berangkat]);
		$tiba= tgl_indo($r[jadwal_tiba]);
		echo "<tr>
			<td>$no</td>
			<td>$r[maskapai_nama]</td>
			<td>$r[pesawat_id]</td>
			<td>$r[kota_nama_asal]</td>
			<td>$r[kota_nama_tujuan]</td>
			<td>$berangkat</td>
			<td>$tiba</td>
			<td><a href=?p=jadwal&act=detailjadwal&jadwal_id=$r[jadwal_id]><b>Detail</b></a>
			&nbsp;&nbsp;&nbsp;<a href=?p=jadwal&act=editjadwal&jadwal_id=$r[jadwal_id]><b>Edit</b></a>
			&nbsp;&nbsp;&nbsp;<a href=$aksi?act=delete&jadwal_id=$r[jadwal_id]><b>Hapus</b></a>
           	</td>
		</tr>";
      $no++;
    }
    echo "</table>";
    break;
  
  // Form Tambah pesawat
  case "tambahjadwal":
    echo "<h2>Tambah Jadwal</h2>
          <form method=POST action='$aksi?act=input'>
          <table>
          <tr><td>Rute Pesawat</td><td> : <select name='pesawat_kota_id'>";
		  $q_pesawat=mysql_query("SELECT tt_pesawat_kota.pesawat_kota_id,
									(SELECT tp_kota.kota_nama 
									FROM tp_kota 
									WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_asal) AS kota_nama_asal,
									(SELECT tp_kota.kota_nama 
									FROM tp_kota 
									WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_tujuan) AS kota_nama_tujuan
		  						FROM tt_pesawat_kota
									INNER JOIN tp_kota ON tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_asal
								ORDER BY tp_kota.kota_nama
								");
		  while($r_pesawat=mysql_fetch_array($q_pesawat))
		  {
			  echo"<option value='$r_pesawat[pesawat_kota_id]'>$r_pesawat[kota_nama_asal] &nbsp;&nbsp;-&nbsp;&nbsp; $r_pesawat[kota_nama_tujuan]</option>";
		  }
		  echo"</select>
		  </td></tr>
		  
          <tr><td>Waktu Berangkat</td><td> : <input type=text name='tanggal_berangkat' id='berangkat'>
		  									&nbsp;&nbsp;&nbsp; Jam &nbsp;&nbsp;&nbsp; <input type=text name='jam_berangkat'> Contoh. 01:00
									</td></tr>
          <tr><td>Waktu Tiba</td><td> : <input type=text name='tanggal_tiba' id='tiba'>
	  									&nbsp;&nbsp;&nbsp; Jam &nbsp;&nbsp;&nbsp; <input type=text name='jam_tiba'> Contoh. 01:00
		  							</td></tr>

          <tr><td colspan=2><input type=submit name=submit class='tombol' value=Simpan>
                            <input type=button class='tombol' value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
  
  // Form Edit Menu Utama
  case "editjadwal":
    $edit=mysql_query("SELECT * FROM tt_jadwal WHERE jadwal_id='$_GET[jadwal_id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit Jadwal</h2>
          <form method=POST action=$aksi?act=update>
		  <input type='hidden' name='jadwal_id' value='$r[jadwal_id]'>
          <table>
          <tr><td>Rute Pesawat</td><td> : <select name='pesawat_kota_id'>";
		  $q_pesawat=mysql_query("SELECT tt_pesawat_kota.pesawat_kota_id,
									(SELECT tp_kota.kota_nama 
									FROM tp_kota 
									WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_asal) AS kota_nama_asal,
									(SELECT tp_kota.kota_nama 
									FROM tp_kota 
									WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_tujuan) AS kota_nama_tujuan
		  						FROM tt_pesawat_kota
									INNER JOIN tp_kota ON tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_asal
								ORDER BY tp_kota.kota_nama
								");
		  while($r_pesawat=mysql_fetch_array($q_pesawat))
		  {
			  if($r[pesawat_kota_id] == $r_pesawat[pesawat_kota_id])
				  echo"<option value='$r_pesawat[pesawat_kota_id]' selected='selected'>$r_pesawat[kota_nama_asal] &nbsp;&nbsp;-&nbsp;&nbsp; $r_pesawat[kota_nama_tujuan]</option>";
			  else
				  echo"<option value='$r_pesawat[pesawat_kota_id]'>$r_pesawat[kota_nama_asal] &nbsp;&nbsp;-&nbsp;&nbsp; $r_pesawat[kota_nama_tujuan]</option>";
		  }
		  echo"</select>
		  </td></tr>
		  
          <tr><td>Waktu Berangkat</td><td> : <input type=text name='tanggal_berangkat' id='berangkat' value='".substr($r[jadwal_berangkat],0,10)."'>
		  									&nbsp;&nbsp;&nbsp; Jam &nbsp;&nbsp;&nbsp; <input type=text name='jam_berangkat' value='".substr($r[jadwal_berangkat],11)."'> Contoh. 01:00
									</td></tr>
          <tr><td>Waktu Tiba</td><td> : <input type=text name='tanggal_tiba' id='tiba' value='".substr($r[jadwal_tiba],0,10)."'>
	  									&nbsp;&nbsp;&nbsp; Jam &nbsp;&nbsp;&nbsp; <input type=text name='jam_tiba' value='".substr($r[jadwal_tiba],11)."'> Contoh. 01:00
		  							</td></tr>

		  <tr><td colspan=2><input type=submit class='tombol'  value=Update>
                            <input type=button class='tombol' value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
	
	case "detailjadwal" :
    echo "<h2>Detail Jadwal Keberangkatan</h2>
          <input type=button class='tombol' value='Tambah Kelas Penumpang' 
          onclick=\"window.location.href='?p=jadwal&act=tambahkelas&jadwal_id=$_GET[jadwal_id]';\">

          <input type=button class='tombol' value='Kembali' 
          onclick=\"window.location.href='?p=jadwal';\">
          <table>
          <tr>
			<th>Nama Maskapai</th>
			<th>Pesawat Kode</th>
			<th>Kota Berangkat</th>
			<th>Kota Tujuan</th>
			<th>Waktu Berangkat</th>
			<th>Waktu Tiba</th>
		</tr>"; 
    $tampil=mysql_query("SELECT tm_maskapai.maskapai_nama,
							tm_pesawat.pesawat_id,
							tt_jadwal.jadwal_id,
							(SELECT tp_kota.kota_nama 
							FROM tp_kota 
							WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_asal) AS kota_nama_asal,
							(SELECT tp_kota.kota_nama 
							FROM tp_kota 
							WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_tujuan) AS kota_nama_tujuan,
							tt_jadwal.jadwal_berangkat,
							tt_jadwal.jadwal_tiba
						FROM tt_jadwal
							INNER JOIN tt_pesawat_kota ON tt_pesawat_kota.pesawat_kota_id = tt_jadwal.pesawat_kota_id
							INNER JOIN tm_pesawat ON tm_pesawat.pesawat_id = tt_pesawat_kota.pesawat_id
							INNER JOIN tm_maskapai ON tm_maskapai.maskapai_id=tm_pesawat.maskapai_id
						WHERE tt_jadwal.jadwal_id='$_GET[jadwal_id]'
						ORDER BY tt_jadwal.jadwal_berangkat");
    while ($r=mysql_fetch_array($tampil))
	{
		$berangkat= tgl_indo($r[jadwal_berangkat]);
		$tiba= tgl_indo($r[jadwal_tiba]);
		echo "<tr>
			<td>$r[maskapai_nama]</td>
			<td>$r[pesawat_id]</td>
			<td>$r[kota_nama_asal]</td>
			<td>$r[kota_nama_tujuan]</td>
			<td>$berangkat</td>
			<td>$tiba</td>
		</tr>";
    }
    echo "</table>
          <table>
          <tr>
			<th>No</th>
			<th>Kelas</th>
			<th>Harga</th>
			<th>Penumpang Maksimal</th>
			<th>Jumlah Pemesan</th>
			<th>Aksi</th>
		</tr>"; 
    $tampil2=mysql_query("SELECT tm_kelas.kelas_nama,
							tt_jadwal_kelas.jadwal_kelas_id,
							tt_jadwal_kelas.jadwal_kelas_max,
							tt_jadwal_kelas.jadwal_kelas_harga,
							(SELECT COUNT(*) 
							FROM tm_pemesan 
							WHERE tm_pemesan.jadwal_id ='$_GET[jadwal_id]'
								AND tm_pemesan.kelas_id = tm_kelas.kelas_id) AS jumlah_pemesan
						FROM tt_jadwal_kelas
							INNER JOIN tm_kelas ON tm_kelas.kelas_id=tt_jadwal_kelas.kelas_id
						WHERE tt_jadwal_kelas.jadwal_id='$_GET[jadwal_id]'");
    $no=1;
	while ($r=mysql_fetch_array($tampil2))
	{
		echo "<tr>
			<td>$no</td>
			<td>$r[kelas_nama]</td>
			<td>$r[jadwal_kelas_harga]</td>
			<td>$r[jadwal_kelas_max]</td>
			<td>$r[jumlah_pemesan]</td>
			<td><a href=?p=jadwal&act=editkelas&jadwal_kelas_id=$r[jadwal_kelas_id]&jadwal_id=$_GET[jadwal_id]><b>Edit</b></a>
			&nbsp;&nbsp;&nbsp;<a href=modul/jadwal/aksi_kelas.php?act=delete&jadwal_kelas_id=$r[jadwal_kelas_id]&jadwal_id=$_GET[jadwal_id]><b>Hapus</b></a>
			</td>
		</tr>";
		$no++;
    }
    echo "</table>";
	
	break;

  case "tambahkelas":
    echo "<h2>Tambah Kelas</h2>
          <form method=POST action='modul/jadwal/aksi_kelas.php?act=input&jadwal_id=$_GET[jadwal_id]'>
		  <table>
          <tr><td>Nama Kelas</td><td> : <select name='kelas_id'>";
		  $q_kelas=mysql_query("SELECT * FROM tm_kelas");
		  while($r_kelas=mysql_fetch_array($q_kelas))
		  {
			  echo "<option value='$r_kelas[kelas_id]'>$r_kelas[kelas_nama]</option>";
		  }
		  echo "</td></tr>
          <tr><td>Harga</td><td> : <input type=text name='jadwal_kelas_harga'></td></tr>
          <tr><td>Penumpang Maksimal</td><td> : <input type=text name='jadwal_kelas_max'></td></tr>
          <tr><td colspan=2><input type=submit name=submit class='tombol' value=Simpan>
                            <input type=button class='tombol' value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;

  case "editkelas":
    $edit=mysql_query("SELECT * FROM tt_jadwal_kelas WHERE jadwal_kelas_id='$_GET[jadwal_kelas_id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit Kelas</h2>
          <form method=POST action='modul/jadwal/aksi_kelas.php?act=update&jadwal_id=$_GET[jadwal_id]'>
		  <input type='hidden' name='jadwal_kelas_id' value='$r[jadwal_kelas_id]'>
		  <table>
          <tr><td>Nama Kelas</td><td> : <select name='kelas_id'>";
		  $q_kelas=mysql_query("SELECT * FROM tm_kelas");
		  while($r_kelas=mysql_fetch_array($q_kelas))
		  {
			  if($r[kelas_id] == $r_kelas[kelas_id])
				  echo "<option value='$r_kelas[kelas_id]' selected='selected'>$r_kelas[kelas_nama]</option>";
			  else
				  echo "<option value='$r_kelas[kelas_id]'>$r_kelas[kelas_nama]</option>";
		  }
		  echo "</td></tr>
          <tr><td>Harga</td><td> : <input type=text name='jadwal_kelas_harga' value='$r[jadwal_kelas_harga]'></td></tr>
          <tr><td>Penumpang Maksimal</td><td> : <input type=text name='jadwal_kelas_max' value='$r[jadwal_kelas_max]'></td></tr>
          <tr><td colspan=2><input type=submit name=submit class='tombol' value=Update>
                            <input type=button class='tombol' value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
}
}
?>
