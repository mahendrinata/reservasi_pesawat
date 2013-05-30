<?php
session_start();
 if (empty($_SESSION['admin_id']) || empty($_SESSION['admin_password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/pesawat/aksi_pesawat.php";
switch($_GET[act]){
  // Tampil pesawat
  default:
    echo "<h2>Data Pesawat</h2>
          <input type=button class='tombol' value='Tambah Pesawat' 
          onclick=\"window.location.href='?p=pesawat&act=tambahpesawat';\">
          <table>
          <tr><th>No</th><th>Pesawat Kode</th><th>Tipe Pesawat</th><th>Keterangan</th><th>Nama Maskapai</th><th>Aksi</th></tr>"; 
    $tampil=mysql_query("SELECT tm_pesawat.*,maskapai_nama FROM tm_pesawat
									INNER JOIN tm_maskapai ON tm_maskapai.maskapai_id=tm_pesawat.maskapai_id");
    $no=1;
    while ($r=mysql_fetch_array($tampil))
	{
       echo "<tr><td>$no</td>
             <td>$r[pesawat_id]</td>
             <td>$r[pesawat_tipe]</td>
             <td>$r[pesawat_keterangan]</td>
             <td>$r[maskapai_nama]</td>
             <td><a href=?p=pesawat&act=editpesawat&pesawat_id=$r[pesawat_id]><b>Edit</b></a>
			 &nbsp;&nbsp;&nbsp;<a href=$aksi?act=delete&pesawat_id=$r[pesawat_id]><b>Hapus</b></a>
             </td></tr>";
      $no++;
    }
    echo "</table>";
    break;
  
  // Form Tambah pesawat
  case "tambahpesawat":
    echo "<h2>Tambah Pesawat</h2>
          <form method=POST action='$aksi?act=input'>
          <table>
          <tr><td>Pesawat Kode</td><td> : <input type=text name='pesawat_id' size='40'></td></tr>
          <tr><td>Pesawat Tipe</td><td> : <input type=text name='pesawat_tipe' size='40'></td></tr>
          <tr><td>Keterangan</td><td> : <textarea name='pesawat_keterangan' rows='5' cols='43'></textarea></td></tr>
          <tr><td>Nama Maskapai</td><td> :<select name='maskapai_id'>"; 
		  $q_maskapai=mysql_query("SELECT * FROM tm_maskapai");
		  while($r_maskapai=mysql_fetch_array($q_maskapai))
		  {
			  echo "<option value='$r_maskapai[maskapai_id]'>$r_maskapai[maskapai_nama]</option>";
		  }
		  echo"</select>
		  </td></tr>
          <tr><td colspan=2><input type=submit name=submit class='tombol' value=Simpan>
                            <input type=button class='tombol' value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
  
  // Form Edit Menu Utama
  case "editpesawat":
    $edit=mysql_query("SELECT * FROM tm_pesawat WHERE pesawat_id='$_GET[pesawat_id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit Pesawat</h2>
          <form method=POST action=$aksi?act=update>
          <table>
          <tr><td>Kode Pesawat</td><td> : <input type=text name='pesawat_id' size='40' value='$r[pesawat_id]' readonly></td></tr>
          <tr><td>Pesawat Tipe</td><td> : <input type=text name='pesawat_tipe' size='40' value='$r[pesawat_tipe]'></td></tr>
          <tr><td>Keterangan</td><td> : <textarea name='pesawat_keterangan' rows='5' cols='43'>$r[pesawat_keterangan]</textarea></td></tr>
          <tr><td>Nama Maskapai</td><td> :<select name='maskapai_id'>"; 
		  $q_maskapai=mysql_query("SELECT * FROM tm_maskapai");
		  while($r_maskapai=mysql_fetch_array($q_maskapai))
		  {
			  if($r_maskapai[maskapai_id] == $r[maskapai_id])
				  echo "<option value='$r_maskapai[maskapai_id]' selected='selected'>$r_maskapai[maskapai_nama]</option>";
			  else
				  echo "<option value='$r_maskapai[maskapai_id]'>$r_maskapai[maskapai_nama]</option>";
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
