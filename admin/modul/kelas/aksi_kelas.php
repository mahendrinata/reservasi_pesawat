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
  mysql_query("INSERT INTO tm_kelas(kelas_id,
  										kelas_nama) 
								VALUES('$_POST[kelas_id]',
								'$_POST[kelas_nama]')
								");
}

// Update menu utama
elseif ($_GET[act]=='update'){
  mysql_query("UPDATE tm_kelas SET kelas_nama='$_POST[kelas_nama]' 
               WHERE kelas_id = '$_POST[kelas_id]'");
}

elseif ($_GET[act]=='delete'){
  mysql_query("DELETE FROM tm_kelas WHERE kelas_id = '$_GET[kelas_id]'");
}


header("Location:../../media.php?p=kelas");
}
?>
