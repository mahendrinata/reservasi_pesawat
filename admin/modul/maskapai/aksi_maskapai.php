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
  mysql_query("INSERT INTO tm_maskapai(maskapai_id,
  										maskapai_nama,
										maskapai_telp,
										maskapai_alamat) 
								VALUES('$_POST[maskapai_id]',
								'$_POST[maskapai_nama]',
								'$_POST[maskapai_telp]',
								'$_POST[maskapai_alamat]')
								");
}

// Update menu utama
elseif ($_GET[act]=='update'){
  mysql_query("UPDATE tm_maskapai SET maskapai_nama='$_POST[maskapai_nama]',
  										maskapai_telp='$_POST[maskapai_telp]', 
										maskapai_alamat='$_POST[maskapai_alamat]' 
               WHERE maskapai_id = '$_POST[maskapai_id]'");
}

elseif ($_GET[act]=='delete'){
  mysql_query("DELETE FROM tm_maskapai WHERE maskapai_id = '$_GET[maskapai_id]'");
}


header("Location:../../media.php?p=maskapai");
}
?>
