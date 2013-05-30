<?php
session_start();
 if (empty($_SESSION['admin_id']) || empty($_SESSION['admin_password'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";

$berangkat=$_POST[tanggal_berangkat]." ".$_POST[jam_berangkat];
$tiba=$_POST[tanggal_tiba]." ".$_POST[jam_tiba];

// Input menu utama
if ($_GET[act]=='input'){
  mysql_query("INSERT INTO tt_jadwal (pesawat_kota_id,
										jadwal_berangkat,
										jadwal_tiba) 
								VALUES('$_POST[pesawat_kota_id]',
								'$berangkat',
								'$tiba')
								");
}

// Update menu utama
elseif ($_GET[act]=='update'){
  mysql_query("UPDATE tt_jadwal SET pesawat_kota_id='$_POST[pesawat_kota_id]',
  										jadwal_berangkat='$berangkat', 
  										jadwal_tiba='$tiba'
               WHERE jadwal_id = '$_POST[jadwal_id]'");
}


elseif ($_GET[act]=='delete'){
  mysql_query("DELETE FROM tt_jadwal WHERE jadwal_id = '$_GET[jadwal_id]'");
}


header("Location:../../media.php?p=jadwal");
}
?>
