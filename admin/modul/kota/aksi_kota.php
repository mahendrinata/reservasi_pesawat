<?php
session_start();
 if (empty($_SESSION['admin_id']) || empty($_SESSION['admin_password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";

// Input menu utama
if ($_GET[act]=='input'){
  mysql_query("INSERT INTO tp_kota(kota_id,
  										kota_nama) 
								VALUES('$_POST[kota_id]',
								'$_POST[kota_nama]')
								");
}

// Update menu utama
elseif ($_GET[act]=='update'){
  mysql_query("UPDATE tp_kota SET kota_nama='$_POST[kota_nama]' 
               WHERE kota_id = '$_POST[kota_id]'");
}

elseif ($_GET[act]=='delete'){
  mysql_query("DELETE FROM tp_kota WHERE kota_id = '$_GET[kota_id]'");
}


header("Location:../../media.php?p=kota");
}
?>
