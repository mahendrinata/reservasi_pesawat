<?php
	include "config/koneksi.php";
	include "config/fungsi_indotgl.php";
	include "config/library.php";
	include "config/aktivasi.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Reservasi Pesawat</title>

<link rel="stylesheet" type="text/css" href="css/style1.css"/>
<link rel="stylesheet" type="text/css" href="css/menu.css"/>  
<link rel="stylesheet" type="text/css" href="css/tab.css"/> 
<link rel="stylesheet" type="text/css" href="css/datepicker.css"/> 
<link rel="stylesheet" type="text/css" href="css/theme.css"/> 

<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.spasticNav.js"></script>
<script type="text/javascript" src="js/jquery.idTabs.min.js"></script>
<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
</script>
</head>

<body>
<div id="header">
	<img src="images/pesawat.jpeg" id="logo">
	<img src="images/isi.png" id="blurb">
</div>
<div id="container">
	<div id="top-menu">
		<div id="menu-area">
		    <ul id="nav">
		        <li <?php if($_GET[p] == "home" || $_GET[p] == ""){echo "id='selected'";} ?>><a href="index.php?p=home">Home</a></li>
		        <li <?php if($_GET[p] == "cara"){echo "id='selected'";} ?>><a href="index.php?p=cara">Cara Pemesanan</a></li>
		        <li <?php if($_GET[p] == "pemesanan"){echo "id='selected'";} ?>><a href="index.php?p=pemesanan">Pemesanan</a></li>
		        <li <?php if($_GET[p] == "pembayaran"){echo "id='selected'";} ?>><a href='index.php?p=pembayaran'>Pembayaran & Cetak Tiket</a></li>		
		        <li <?php if($_GET[p] == "pembatalan"){echo "id='selected'";} ?>><a href='index.php?p=pembatalan'>Pembatalan</a></li>		    
            </ul>
		    <div id="menu-text">
		    	Selamat Datang, <a href="index.php?p=contact">Kontak Kami</a>
		    </div>
	    </div>
    </div>
</div>
<div id="mainarea">
	<div id="mainbody">
    <?php
		if($_GET[p] == "home" || $_GET[p] == "")
		{
			include "modul/home/home.php";
		}
		elseif($_GET[p] == "cara")
		{
			include "modul/cara/cara.php";
		}
		elseif($_GET[p] == "pemesanan")
		{
			include "modul/pemesanan/pemesanan.php";
		}
		elseif($_GET[p] == "pembayaran")
		{
			include "modul/pembayaran/pembayaran.php";
		}
		elseif($_GET[p] == "pembatalan")
		{
			include "modul/pembatalan/pembatalan.php";
		}
		elseif($_GET[p] == "contact")
		{
			include "modul/contact/contact.php";
		}
	?>
        <div style='clear : both;'></div>	
		
		<hr>
		<div id="leftfooter">
			<div id="footer_menu">
				<a href="index.php?p=home">Home</a> 
                | <a href="index.php?p=cara">Cara Pemesanan</a> 
                | <a href="index.php?p=pemesanan">Pemesanan</a>
                | <a href='index.php?p=pembayaran'>Pembayaran</a>
                | <a href='index.php?p=pembatalan'>Pembatalan</a>
                | <a href="index.php?p=contact">Contact Us</a> 
			</div>
		</div>
		
		<div id="rightfooter">
			<a href="http://facebook.com"><img src="images/facebook.png" width="48"></a><a href="http://twitter.com"><img src="images/twitter.png" width="48"></a><br>
			<small>Reservasi Pesawat &copy; 2011 All Rights Reserved.</small><br><br>
		</div>
		<div style='clear : both'></div>	
	</div>
</div>

<script type="text/javascript"> 
  var settings = { start:2, change:false }; 
  $("#tab-search ul").idTabs(settings,true); 
</script>
<script type="text/javascript">
    $('#nav').spasticNav();
</script>
</body>