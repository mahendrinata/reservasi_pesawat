<?php
include "../config/koneksi.php";
function antiinjection($data){
  $filter_sql = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter_sql;
}

$username = antiinjection($_POST[username]);
$pass     = antiinjection(md5($_POST[password]));

$login=mysql_query("SELECT * FROM tm_admin WHERE admin_id='$username' AND admin_password='$pass' AND admin_aktif='Y'");
$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);

// Apabila username dan password ditemukan
if ($ketemu > 0){
  session_start();
  session_register("admin_id");
  session_register("admin_nama");
  session_register("admin_password");

  $_SESSION[admin_id]     		= $r[admin_id];
  $_SESSION[admin_nama]     	= $r[admin_nama];
  $_SESSION[admin_password]  	= $r[admin_password];
  
  header('location:media.php?p=home');
}
else{
echo "<link href='css/screen.css' rel='stylesheet' type='text/css'><link href='css/reset.css' rel='stylesheet' type='text/css'>";
  echo "<center><br><br><br><br><br><br><b>LOGIN GAGAL! </b><br> 
        Username atau Password Anda tidak benar.<br>
        Atau account Anda sedang diblokir.<br><br>";
		echo "<div> <a href='index.php'><img src='images/seru.png'  height=147 width=176><br><br></a>
             </div>";
  echo "<input type=button class='tombol' value='ULANGI LAGI' onclick=location.href='index.php'></a></center>";

}
?>
