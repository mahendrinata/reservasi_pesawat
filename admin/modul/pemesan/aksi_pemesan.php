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

// Update menu utama
if ($_GET[act]=='update'){
  		mysql_query("UPDATE tm_pemesan SET pemesan_transfer_nilai='$_POST[pemesan_transfer_nilai]',
  									pemesan_disetujui = '$_POST[pemesan_disetujui]' 
               WHERE pemesan_id = '$_POST[pemesan_id]'");
}

header("Location:../../media.php?p=pemesan");
}
?>
