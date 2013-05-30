<?php
session_start();
 if (empty($_SESSION['admin_id']) || empty($_SESSION['admin_password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/maskapai/aksi_maskapai.php";
switch($_GET[act]){
  // Tampil Maskapai
  default:
    echo "<h2>Maskapai Penerbangan</h2>
          <input type=button class='tombol' value='Tambah Maskapai' 
          onclick=\"window.location.href='?p=maskapai&act=tambahmaskapai';\">
          <table>
          <tr><th>No</th><th>Maskapai Kode</th><th>Nama Maskapai</th><th>Telepon</th><th>Alamat</th><th>Aksi</th></tr>"; 
    $tampil=mysql_query("SELECT * FROM tm_maskapai");
    $no=1;
    while ($r=mysql_fetch_array($tampil))
	{
       echo "<tr><td>$no</td>
             <td>$r[maskapai_id]</td>
             <td>$r[maskapai_nama]</td>
             <td>$r[maskapai_telp]</td>
             <td>$r[maskapai_alamat]</td>
             <td><a href=?p=maskapai&act=editmaskapai&maskapai_id=$r[maskapai_id]><b>Edit</b></a>
			 &nbsp;&nbsp;&nbsp;<a href=$aksi?act=delete&maskapai_id=$r[maskapai_id]><b>Hapus</b></a>
             </td></tr>";
      $no++;
    }
    echo "</table>";
    break;
  
  // Form Tambah Maskapai
  case "tambahmaskapai":
    echo "<h2>Tambah Maskapai Penerbangan</h2>
          <form method=POST action='$aksi?act=input'>
          <table>
          <tr><td>Maskapai Kode</td><td> : <input type=text name='maskapai_id' size='40'></td></tr>
          <tr><td>Nama Maskapai</td><td> : <input type=text name='maskapai_nama' size='40'></td></tr>
          <tr><td>Telepon</td><td> : <input type=text name='maskapai_telp' size='40'></td></tr>
          <tr><td>Alamat</td><td> : <textarea name='maskapai_alamat' rows='5' cols='43'></textarea></td></tr>
          <tr><td colspan=2><input type=submit name=submit class='tombol' value=Simpan>
                            <input type=button class='tombol' value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
  
  // Form Edit Menu Utama
  case "editmaskapai":
    $edit=mysql_query("SELECT * FROM tm_maskapai WHERE maskapai_id='$_GET[maskapai_id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit Maskapai Penerbangan</h2>
          <form method=POST action=$aksi?act=update>
          <input type=hidden name=maskapai_id value='$r[maskapai_id]'>
          <table>
          <tr><td>Nama Maskapai</td><td> : <input type=text name='maskapai_nama' size='40' value='$r[maskapai_nama]'></td></tr>
          <tr><td>Telepon</td><td> : <input type=text name='maskapai_telp' size='40' value='$r[maskapai_telp]'></td></tr>
          <tr><td>Alamat</td><td> : <textarea name='maskapai_alamat' rows='5' cols='43'>$r[maskapai_alamat]</textarea></td></tr>
		  <tr><td colspan=2><input type=submit class='tombol'  value=Update>
                            <input type=button class='tombol' value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
}
}
?>
