<?php
session_start();
 if (empty($_SESSION['admin_id']) || empty($_SESSION['admin_password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/kota/aksi_kota.php";
switch($_GET[act]){
  // Tampil kota
  default:
    echo "<h2>Data Kota</h2>
          <input type=button class='tombol' value='Tambah kota' 
          onclick=\"window.location.href='?p=kota&act=tambahkota';\">
          <table>
          <tr><th>No</th><th>Kota Kode</th><th>Nama Kota</th><th>Aksi</th></tr>"; 
    $tampil=mysql_query("SELECT * FROM tp_kota");
    $no=1;
    while ($r=mysql_fetch_array($tampil))
	{
       echo "<tr><td>$no</td>
             <td>$r[kota_id]</td>
             <td>$r[kota_nama]</td>
             <td><a href=?p=kota&act=editkota&kota_id=$r[kota_id]><b>Edit</b></a>
			 &nbsp;&nbsp;&nbsp;<a href=$aksi?act=delete&kota_id=$r[kota_id]><b>Hapus</b></a>
             </td></tr>";
      $no++;
    }
    echo "</table>";
    break;
  
  // Form Tambah kota
  case "tambahkota":
    echo "<h2>Tambah Kota</h2>
          <form method=POST action='$aksi?act=input'>
          <table>
          <tr><td>Kota Kode</td><td> : <input type=text name='kota_id' size='40'></td></tr>
          <tr><td>Nama Kota</td><td> : <input type=text name='kota_nama' size='40'></td></tr>
          <tr><td colspan=2><input type=submit name=submit class='tombol' value=Simpan>
                            <input type=button class='tombol' value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
  
  // Form Edit Menu Utama
  case "editkota":
    $edit=mysql_query("SELECT * FROM tp_kota WHERE kota_id='$_GET[kota_id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit Kota</h2>
          <form method=POST action=$aksi?act=update>
          <table>
          <tr><td>Kota Kode</td><td> : <input type=text name='kota_id' size='40' value='$r[kota_id]' readonly></td></tr>
          <tr><td>Nama kota</td><td> : <input type=text name='kota_nama' size='40' value='$r[kota_nama]'></td></tr>
		  <tr><td colspan=2><input type=submit class='tombol'  value=Update>
                            <input type=button class='tombol' value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
}
}
?>
