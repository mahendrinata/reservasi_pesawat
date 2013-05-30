<?php
session_start();
 if (empty($_SESSION['admin_id']) || empty($_SESSION['admin_password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/admin/aksi_admin.php";
switch($_GET[act]){
  // Tampil admin
  default:
    echo "<h2>Data Admin</h2>
          <input type=button class='tombol' value='Tambah Admin' 
          onclick=\"window.location.href='?p=admin&act=tambahadmin';\">
          <table>
          <tr><th>No</th><th>Admin Kode</th><th>Nama Admin</th><th>Aksi</th></tr>"; 
    $tampil=mysql_query("SELECT * FROM tm_admin");
    $no=1;
    while ($r=mysql_fetch_array($tampil))
	{
       echo "<tr><td>$no</td>
             <td>$r[admin_id]</td>
             <td>$r[admin_nama]</td>
             <td><a href=?p=admin&act=editadmin&admin_id=$r[admin_id]><b>Edit</b></a>
			 &nbsp;&nbsp;&nbsp;<a href=$aksi?act=delete&admin_id=$r[admin_id]><b>Hapus</b></a>
             </td></tr>";
      $no++;
    }
    echo "</table>";
    break;
  
  // Form Tambah admin
  case "tambahadmin":
    echo "<h2>Tambah admin</h2>
          <form method=POST action='$aksi?act=input'>
          <table>
          <tr><td>Admin Kode</td><td> : <input type=text name='admin_id' size='40'></td></tr>
          <tr><td>Nama Admin</td><td> : <input type=text name='admin_nama' size='40'></td></tr>
          <tr><td>Password Admin</td><td> : <input type=password name='admin_password' size='40'></td></tr>
          <tr><td colspan=2><input type=submit name=submit class='tombol' value=Simpan>
                            <input type=button class='tombol' value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
  
  // Form Edit Menu Utama
  case "editadmin":
    $edit=mysql_query("SELECT * FROM tm_admin WHERE admin_id='$_GET[admin_id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit Admin</h2>
          <form method=POST action=$aksi?act=update>
          <table>
          <tr><td>Admin Kode</td><td> : <input type=text name='admin_id' size='40' value='$r[admin_id]' readonly></td></tr>
          <tr><td>Nama Admin</td><td> : <input type=text name='admin_nama' size='40' value='$r[admin_nama]'></td></tr>
          <tr><td>Password Admin</td><td> : <input type=password name='admin_password' size='40'></td></tr>
		  <tr><td colspan=2><input type=submit class='tombol'  value=Update>
                            <input type=button class='tombol' value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
}
}
?>
