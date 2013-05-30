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
  mysql_query("INSERT INTO tt_pesawat_kota (pesawat_id,
										pesawat_kota_asal,
										pesawat_kota_tujuan) 
								VALUES('$_POST[pesawat_id]',
								'$_POST[pesawat_kota_asal]',
								'$_POST[pesawat_kota_tujuan]')
								");
}

// Update menu utama
elseif ($_GET[act]=='update'){
  mysql_query("UPDATE tt_pesawat_kota SET pesawat_id='$_POST[pesawat_id]',
  										pesawat_kota_asal='$_POST[pesawat_kota_asal]', 
  										pesawat_kota_tujuan='$_POST[pesawat_kota_tujuan]'
               WHERE pesawat_kota_id = '$_POST[pesawat_kota_id]'");
}


elseif ($_GET[act]=='delete'){
  mysql_query("DELETE FROM tt_pesawat_kota WHERE pesawat_kota_id = '$_GET[pesawat_id]'");
}


header("Location:../../media.php?p=keberangkatan");
}
?>
