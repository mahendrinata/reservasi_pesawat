<?php
session_start();
 if (empty($_SESSION['admin_id']) || empty($_SESSION['admin_password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/kelas/aksi_kelas.php";
switch($_GET[act]){
  // Tampil kelas
  default:
    echo "<h2>Data Kelas</h2>
          <input type=button class='tombol' value='Tambah Kelas' 
          onclick=\"window.location.href='?p=kelas&act=tambahkelas';\">
          <table>
          <tr><th>No</th><th>kelas Kode</th><th>Nama kelas</th><th>Aksi</th></tr>"; 
    $tampil=mysql_query("SELECT * FROM tm_kelas");
    $no=1;
    while ($r=mysql_fetch_array($tampil))
	{
       echo "<tr><td>$no</td>
             <td>$r[kelas_id]</td>
             <td>$r[kelas_nama]</td>
             <td><a href=?p=kelas&act=editkelas&kelas_id=$r[kelas_id]><b>Edit</b></a>
			 &nbsp;&nbsp;&nbsp;<a href=$aksi?act=delete&kelas_id=$r[kelas_id]><b>Hapus</b></a>
             </td></tr>";
      $no++;
    }
    echo "</table>";
    break;
  
  // Form Tambah kelas
  case "tambahkelas":
    echo "<h2>Tambah Kelas</h2>
          <form method=POST action='$aksi?act=input'>
          <table>
          <tr><td>Kelas Kode</td><td> : <input type=text name='kelas_id' size='40'></td></tr>
          <tr><td>Nama Kelas</td><td> : <input type=text name='kelas_nama' size='40'></td></tr>
          <tr><td colspan=2><input type=submit name=submit class='tombol' value=Simpan>
                            <input type=button class='tombol' value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
  
  // Form Edit Menu Utama
  case "editkelas":
    $edit=mysql_query("SELECT * FROM tm_kelas WHERE kelas_id='$_GET[kelas_id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit Kelas</h2>
          <form method=POST action=$aksi?act=update>
          <table>
          <tr><td>Kelas Kode</td><td> : <input type=text name='kelas_id' size='40' value='$r[kelas_id]' readonly></td></tr>
          <tr><td>Nama Kelas</td><td> : <input type=text name='kelas_nama' size='40' value='$r[kelas_nama]'></td></tr>
		  <tr><td colspan=2><input type=submit class='tombol'  value=Update>
                            <input type=button class='tombol' value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
}
}
?>
