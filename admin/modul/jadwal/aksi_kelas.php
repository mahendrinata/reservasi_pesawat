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
  mysql_query("INSERT INTO tt_jadwal_kelas (jadwal_id,
										kelas_id,
										jadwal_kelas_max,
										jadwal_kelas_harga) 
								VALUES('$_GET[jadwal_id]',
								'$_POST[kelas_id]',
								'$_POST[jadwal_kelas_max]',
								'$_POST[jadwal_kelas_harga]')
								");
}

// Update menu utama
elseif ($_GET[act]=='update'){
  mysql_query("UPDATE tt_jadwal_kelas SET kelas_id='$_POST[kelas_id]',
  										jadwal_kelas_max='$_POST[jadwal_kelas_max]', 
  										jadwal_kelas_harga='$_POST[jadwal_kelas_harga]'
               WHERE jadwal_kelas_id = '$_POST[jadwal_kelas_id]'");
}


elseif ($_GET[act]=='delete'){
  mysql_query("DELETE FROM tt_jadwal_kelas WHERE jadwal_kelas_id = '$_GET[jadwal_kelas_id]'");
}


header("Location:../../media.php?p=jadwal&act=detailjadwal&jadwal_id=$_GET[jadwal_id]");
}
?>
