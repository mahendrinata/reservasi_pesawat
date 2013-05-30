<?php
switch($_GET[act]){
  // Tampil jurusan Utama
	default:
?>
		<script type="text/javascript">
		function asal()
		{
			var htmlobjek;
			var maskapai = $("#maskapai").val();
			$.ajax(
			{
				url: "modul/pemesanan/pemesanan_asal.php",
				data: "maskapai="+maskapai,
				cache: false,
				success: function(msg)
				{
					$("#asal").html(msg);
				}
			});
		}

		function tujuan()
		{
			var htmlobjek;
			var maskapai = $("#maskapai").val();
			var asal = $("#asal").val();
			$.ajax(
			{
				url: "modul/pemesanan/pemesanan_tujuan.php",
				data: "maskapai="+maskapai+"&asal="+asal,
				cache: false,
				success: function(msg)
				{
					$("#tujuan").html(msg);
				}
			});
		}

		function form_data()
		{
			var htmlobjek;
			var maskapai = $("#maskapai").val();
			var asal = $("#asal").val();
			var tujuan = $("#tujuan").val();			
			var tanggal = $("#datepicker").val();			
			$.ajax(
			{
				url: "modul/pemesanan/pemesanan_form.php",
				data: "maskapai="+maskapai+"&asal="+asal+"&tujuan="+tujuan+"&tanggal="+tanggal,
				cache: false,
				success: function(msg)
				{
					$("#form_data").html(msg);
				}
			});
		}
		</script>
		<div id="signlayer">
			<div id="split1"><h2>Pemesanan Tiket</h2></div>
			<div style='clear : both'></div>	
			<hr><br>
						<h4>Maskapai Penerbangan</h4>
                        <select id="maskapai" class="field2" name="maskapai" onChange="javascript:asal(this)">
                        	<option selected> Pilih Maskapai Penerbangan</option>
                        <?php
						$q_maskapai=mysql_query("SELECT * from tm_maskapai ORDER BY maskapai_nama");
						while($r_maskapai=mysql_fetch_array($q_maskapai))
						{
                        	echo "<option value='$r_maskapai[maskapai_id]'>$r_maskapai[maskapai_nama]</option>";
						}
						?>
                        </select><br>
						<small>Maskapai Penerbangan</small><br><br>
						<b>Kota Berangkat</b><br>
						<select id="asal" class="field2" name="asal" onChange="javascript:tujuan(this)">
                        <option>Pilih Kota Asal</option>
                        </select><br>
						<small>Kota keberangkatan pesawat</small><br><br>
						<b>Kota Tujuan</b><br>
						<select id="tujuan" class="field2" name="tujuan" onChange="javascript:form_data(this)">
                        <option>Pilih Kota Tujuan</option>
                        </select><br>
						<small>Kota kedatangan pesawat</small><br><br>
						<table width="200">
						<tr><td><b>Tanggal Keberangkatan</b></td></tr>
						<tr><td><input type="text" id="datepicker" onChange="javascript:form_data(this)"></td></tr>
						<tr><td><br />
                        <div id="form_data">
                        <input type="submit" name="search" id="search-btn" value="Cari">
                        </div>
                        </td></tr>
						</table>
		</div>
		<div id="signads">
			<p id="judul">Why join househunt24</p>
			<hr>
	
			<p id="judul1"><img id="miniicon" src="images/email.png">See more with property alerts</p>
			Tell us what you're looking for and we'll send you 
			property alerts when a matching property is added to 
			the site.
			
			<hr id="line">
			
			<p id="judul1"><img id="miniicon" src="images/zoom.png">Make your home hunt easier</p>
			We will complete your details in emails you send to 
			companies displaying properties on Rightmove.
			
			<hr id="line">
			
			<p id="judul1"><img id="miniicon" src="images/comment_edit.png">Don't miss out</p>
			Sign up to receive newsletters, tips and special offers 
			from Rightmove and Rightmove estate agents and 
			new homes developers.
			
		</div>
		<?php
        break;
		
		case "jadwal":
			$q=mysql_query("SELECT tm_maskapai.maskapai_nama,
							tt_jadwal.jadwal_id,
							tm_kelas.kelas_id,
							tt_jadwal.jadwal_berangkat,
							tt_jadwal.jadwal_tiba,
							(SELECT tp_kota.kota_nama FROM tp_kota WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_asal) AS pesawat_kota_asal_nama,
							(SELECT tp_kota.kota_nama FROM tp_kota WHERE tp_kota.kota_id=tt_pesawat_kota.pesawat_kota_tujuan) AS pesawat_kota_tujuan_nama,
							tm_kelas.kelas_nama,
							tt_jadwal_kelas.jadwal_kelas_harga,
							tt_jadwal_kelas.jadwal_kelas_max,
							(SELECT COUNT(*) FROM tm_pemesan 
							WHERE tm_pemesan.jadwal_id = tt_jadwal.jadwal_id
								AND tm_pemesan.kelas_id = tm_kelas.kelas_id
								AND tm_pemesan.pemesan_aktif='Y') AS jumlah_pemesan
					FROM tt_pesawat_kota
						INNER JOIN tm_pesawat ON tm_pesawat.pesawat_id = tt_pesawat_kota.pesawat_id
						INNER JOIN tm_maskapai ON tm_maskapai.maskapai_id = tm_pesawat.maskapai_id
							AND tm_maskapai.maskapai_id = '$_POST[maskapai]'
						INNER JOIN tt_jadwal ON tt_jadwal.pesawat_kota_id = tt_pesawat_kota.pesawat_kota_id
								AND tt_jadwal.jadwal_berangkat LIKE '$_POST[tanggal]%'
						INNER JOIN tt_jadwal_kelas ON tt_jadwal_kelas.jadwal_id = tt_jadwal.jadwal_id
						INNER JOIN tm_kelas ON tm_kelas.kelas_id=tt_jadwal_kelas.kelas_id
					WHERE tt_pesawat_kota.pesawat_kota_asal = '$_POST[asal]'
							AND tt_pesawat_kota.pesawat_kota_tujuan = '$_POST[tujuan]'
					GROUP BY tm_maskapai.maskapai_nama,
							tt_jadwal.jadwal_berangkat,
							tt_jadwal.jadwal_tiba,
							pesawat_kota_asal_nama,
							pesawat_kota_tujuan_nama,
							tt_jadwal.jadwal_tiba,
							tm_kelas.kelas_nama,
							tt_jadwal_kelas.jadwal_kelas_harga,
							tt_jadwal_kelas.jadwal_kelas_max");
			echo "
			<div id='tengah'>
			<div id='split1'><h2>Jadwal Keberangkatan</h2></div>
			<div style='clear : both'></div>	
			<hr><br>
			<table width='100%'>
			<tr>
				<th>Maskapai Pesawat</th>
				<th>Waktu Berangkat</th>
				<th>Waktu Tiba</th>
				<th>Kota Berangkat</th>
				<th>Kota Tujuan</th>
				<th>Kelas</th>
				<th>Harga</th>
				<th>Kuota</th>
				<th>Jumlah Pemesan</th>
				<th>&nbsp;</th>
			</tr>";
			while($r=mysql_fetch_array($q))
			{
				$berangkat= tgl_indo($r[jadwal_berangkat]);
				$datang= tgl_indo($r[jadwal_tiba]);
				echo "<tr>
					<td>$r[maskapai_nama]</td>
					<td>$berangkat</td>
					<td>$datang</td>
					<td>$r[pesawat_kota_asal_nama]</td>
					<td>$r[pesawat_kota_tujuan_nama]</td>
					<td>$r[kelas_nama]</td>
					<td align='right'>$r[jadwal_kelas_harga]</td>
					<td align='right'>$r[jadwal_kelas_max]</td>
					<td align='right'>$r[jumlah_pemesan]</td>
					<td>";
					if($r[jadwal_kelas_max] > $r[jumlah_pemesan])
						echo "<a href='index.php?p=pemesanan&act=biodata&jadwal=$r[jadwal_id]&kelas=$r[kelas_id]' title='Pesan Tiket'>Pesan</a>";
					echo"</td>
				</tr>";
			}
			echo "</table>
			</div>";
		break;
		
		case "biodata":
		echo "
			<div id='tengah'>
			<div id='split1'><h2>Biodata Pemesan</h2></div>
			<div style='clear : both'></div>	
			<hr><br>
			<form method='post' action='modul/pemesanan/aksi_pemesanan.php'>
			<table width='100%'>
			<tr>
				<th>Nama</th>
				<td><input type='hidden' name='jadwal' value='$_GET[jadwal]'>
				<input type='hidden' name='kelas' value='$_GET[kelas]'>
				<input type='text' name='nama' class='field2'  required autofocus='autofocus'></td>
			</tr>
			<tr>
				<th>No. KTP/SIM</th>
				<td><input type='text' name='pengenal' class='field2' required></td>
			</tr>
			<tr>
				<th>No. Telepon</th>
				<td><input type='text' name='telp' class='field2' required></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><input type='text' name='email' class='field2'></td>
			</tr>
			<tr>
				<th>Alamat</th>
				<td><textarea name='alamat' rows='5' cols='38' required></textarea></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td><input type='submit' id='search-btn' value='Pesan Tiket'></td>
			</tr>
			</table>
			</form>
			</div>";		
			break;
			
			case "messege":
			echo "<div id='tengah'>
			<div id='split1'><h2>Data Berhasil Disimpan</h2></div>
			<div style='clear : both'></div>
			<hr><br>
			<table width='100%'>
			<tr>
				<th>Kode Pemesan</th>
				<td><h3>$_GET[kode]</h3></td>
			</tr>
			<tr>
				<td colspan='2'>Kode ini digunakan untuk melakukan perubahan tiket.</td>
			</tr>
			</table>
			<br>
			<br>
			<a href='modul/print/print_tiket.php?kode=$_GET[kode]&?Cetak' title='Cetak Tiket' target='_blank'><img src='images/print.jpg'></a>
			</div>";
			break;
        }
        ?>