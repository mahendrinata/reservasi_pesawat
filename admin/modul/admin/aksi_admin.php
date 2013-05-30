<?php
session_start();
 if (empty($_SESSION['admin_id']) || empty($_SESSION['admin_password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";

$password = md5($_POST[admin_password]);
// Input menu utama
if ($_GET[act]=='input'){
  mysql_query("INSERT INTO tm_admin(admin_id,
  										admin_nama,
										admin_password) 
								VALUES('$_POST[admin_id]',
								'$_POST[admin_nama]',
								'$password')
								");
}

// Update menu utama
elseif ($_GET[act]=='update'){

  if($_POST[admin_password] !="")
  {
  mysql_query("UPDATE tm_admin SET admin_nama='$_POST[admin_nama]',
  									admin_password='$password' 
               WHERE admin_id = '$_POST[admin_id]'");
  }
  else
  {
  mysql_query("UPDATE tm_admin SET admin_nama='$_POST[admin_nama]'
  				WHERE admin_id = '$_POST[admin_id]'");
  }
}

// Update menu utama
elseif ($_GET[act]=='delete'){
  mysql_query("DELETE FROM tm_admin WHERE admin_id = '$_GET[admin_id]'");
}

header("Location:../../media.php?p=admin");
}
?>
