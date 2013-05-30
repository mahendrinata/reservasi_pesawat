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
  mysql_query("INSERT INTO tm_pesawat(pesawat_id,
  										pesawat_tipe,
										pesawat_keterangan,
										maskapai_id) 
								VALUES('$_POST[pesawat_id]',
								'$_POST[pesawat_tipe]',
								'$_POST[pesawat_keterangan]',
								'$_POST[maskapai_id]')
								");
}

// Update menu utama
elseif ($_GET[act]=='update'){
  mysql_query("UPDATE tm_pesawat SET pesawat_tipe='$_POST[pesawat_tipe]',
  										pesawat_keterangan='$_POST[pesawat_keterangan]', 
										maskapai_id='$_POST[maskapai_id]' 
               WHERE pesawat_id = '$_POST[pesawat_id]'");
}


elseif ($_GET[act]=='delete'){
  mysql_query("DELETE FROM tm_pesawat WHERE pesawat_id = '$_GET[pesawat_id]'");
}


header("Location:../../media.php?p=pesawat");
}
?>
