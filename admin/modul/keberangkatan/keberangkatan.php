<?php
session_start();
 if (empty($_SESSION['admin_id']) || empty($_SESSION['admin_password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/keberangkatan/aksi_keberangkatan.php";
switch($_GET[act]){
  // Tampil pesawat
  default:
    echo "<h2>Data Pesawat Rute</h2>
          <input type=button class='tombol' value='Tambah Rute Pesawat' 
          onclick=\"window.location.href='?p=keberangkatan&act=tambahpesawat';\">
          <table>
          <tr><th>No</th><th>Pesawat Kode</th><th>Nama Maskapai</th><th>Berangkat</th><th>Tujuan</th><th>Aksi</th></tr>"; 
    $tampil=mysql_query("SELECT tm_pesawat.pesawat_id,
							tt_pesawat_kota.pesawat_kota_id,
							tm_maskapai.maskapai_nama,
							(SELECT tp_kota.kota_nama 
							FROM tp_kota 
							WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_asal) AS kota_asal,
							(SELECT tp_kota.kota_nama 
							FROM tp_kota 
							WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_tujuan) AS kota_tujuan
						FROM tt_pesawat_kota
							INNER JOIN tm_pesawat ON tm_pesawat.pesawat_id = tt_pesawat_kota.pesawat_id
							INNER JOIN tm_maskapai ON tm_maskapai.maskapai_id=tm_pesawat.maskapai_id");
    $no=1;
    while ($r=mysql_fetch_array($tampil))
	{
       echo "<tr><td>$no</td>
             <td>$r[pesawat_id]</td>
             <td>$r[maskapai_nama]</td>
             <td>$r[kota_asal]</td>
             <td>$r[kota_tujuan]</td>
             <td><a href=?p=keberangkatan&act=editpesawat&pesawat_id=$r[pesawat_kota_id]><b>Edit</b></a>
			 &nbsp;&nbsp;&nbsp;<a href=$aksi?act=delete&pesawat_id=$r[pesawat_kota_id]><b>Hapus</b></a>
             </td></tr>";
      $no++;
    }
    echo "</table>";
    break;
  
  // Form Tambah pesawat
  case "tambahpesawat":
    echo "<h2>Tambah Rute Pesawat</h2>
          <form method=POST action='$aksi?act=input'>
          <table>
          <tr><td>Pesawat Kode</td><td> : <select name='pesawat_id'>";
		  $q_pesawat=mysql_query("SELECT tm_pesawat.*,maskapai_nama FROM tm_pesawat
									INNER JOIN tm_maskapai ON tm_maskapai.maskapai_id=tm_pesawat.maskapai_id");
		  while($r_pesawat=mysql_fetch_array($q_pesawat))
		  {
			  echo"<option value='$r_pesawat[pesawat_id]'>$r_pesawat[pesawat_id] $r_pesawat[maskapai_id]</option>";
		  }
		  echo"</select>
		  </td></tr>
		  
          <tr><td>Kota Berangkat</td><td> : <select name='pesawat_kota_asal'>";
		  $q_kota=mysql_query("SELECT * FROM tp_kota");
		  while($r_kota=mysql_fetch_array($q_kota))
		  {
			  echo"<option value='$r_kota[kota_id]'>$r_kota[kota_nama]</option>";
		  }
		  echo"</select>
		  </td></tr>

          <tr><td>Kota Tujuan</td><td> : <select name='pesawat_kota_tujuan'>";
		  $q_kota=mysql_query("SELECT * FROM tp_kota");
		  while($r_kota=mysql_fetch_array($q_kota))
		  {
			  echo"<option value='$r_kota[kota_id]'>$r_kota[kota_nama]</option>";
		  }
		  echo"</select>
		  </td></tr>

          <tr><td colspan=2><input type=submit name=submit class='tombol' value=Simpan>
                            <input type=button class='tombol' value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
  
  // Form Edit Menu Utama
  case "editpesawat":
    $edit=mysql_query("SELECT * FROM tt_pesawat_kota WHERE pesawat_kota_id='$_GET[pesawat_id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit Rute Pesawat</h2>
          <form method=POST action=$aksi?act=update>
		  <input type='hidden' name='pesawat_kota_id' value='$r[pesawat_kota_id]'>
          <table>
          <tr><td>Pesawat Kode</td><td> : <select name='pesawat_id'>";
		  $q_pesawat=mysql_query("SELECT tm_pesawat.*,maskapai_nama FROM tm_pesawat
									INNER JOIN tm_maskapai ON tm_maskapai.maskapai_id=tm_pesawat.maskapai_id");
		  while($r_pesawat=mysql_fetch_array($q_pesawat))
		  {
			  if($r[pesawat_id] == $r_pesawat[pesawat_id])
				  echo"<option value='$r_pesawat[pesawat_id]' selected='selected'>$r_pesawat[pesawat_id] $r_pesawat[maskapai_id]</option>";
			  else
				  echo"<option value='$r_pesawat[pesawat_id]'>$r_pesawat[pesawat_id] $r_pesawat[maskapai_id]</option>";
		  }
		  echo"</select>
		  </td></tr>
		  
          <tr><td>Kota Berangkat</td><td> : <select name='pesawat_kota_asal'>";
		  $q_kota=mysql_query("SELECT * FROM tp_kota");
		  while($r_kota=mysql_fetch_array($q_kota))
		  {
			  if($r[pesawat_kota_awal] == $r_kota[kota_id])
				  echo"<option value='$r_kota[kota_id]' selected='selected'>$r_kota[kota_nama]</option>";
			  else
				  echo"<option value='$r_kota[kota_id]'>$r_kota[kota_nama]</option>";
		  }
		  echo"</select>
		  </td></tr>

          <tr><td>Kota Tujuan</td><td> : <select name='pesawat_kota_tujuan'>";
		  $q_kota=mysql_query("SELECT * FROM tp_kota");
		  while($r_kota=mysql_fetch_array($q_kota))
		  {
			  if($r[pesawat_kota_tujuan] == $r_kota[kota_id])
				  echo"<option value='$r_kota[kota_id]' selected='selected'>$r_kota[kota_nama]</option>";
			  else
				  echo"<option value='$r_kota[kota_id]'>$r_kota[kota_nama]</option>";
		  }
		  echo"</select>
		  </td></tr>

		  <tr><td colspan=2><input type=submit class='tombol'  value=Update>
                            <input type=button class='tombol' value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
}
}
?>
