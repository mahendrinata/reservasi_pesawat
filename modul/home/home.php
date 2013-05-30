		<script type="text/javascript">
		function asal()
		{
			var htmlobjek;
			var maskapai = $("#maskapai").val();
			$.ajax(
			{
				url: "modul/home/home_asal.php",
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
				url: "modul/home/home_tujuan.php",
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
				url: "modul/home/home_form.php",
				data: "maskapai="+maskapai+"&asal="+asal+"&tujuan="+tujuan+"&tanggal="+tanggal,
				cache: false,
				success: function(msg)
				{
					$("#form_data").html(msg);
				}
			});
		}
		</script>
        <div id="search-area">
			<h3>Pencarian</h3>
            <br />
				  <div id="t1">
					<div id="kolom1">
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
                        </select>
						<small>Kota keberangkatan pesawat</small><br><br>
						<b>Kota Tujuan</b><br>
						<select id="tujuan" class="field2" name="tujuan" onChange="javascript:form_data(this)">
                        <option>Pilih Kota Tujuan</option>
                        </select>
						<small>Kota kedatangan pesawat</small>
                    </div>
					<div id="kolom2">
                    
						<table width="200">
						<tr><td><b>Tanggal Keberangkatan</b></td></tr>
						<tr><td><input type="text" id="datepicker" onChange="javascript:form_data(this)"/></td></tr>
						<tr><td><br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <div id="form_data"> 
                        <input type="submit" name="search" id="search-btn" value="Cari"></td></tr>
						</div>
                        </table>
					</div>
			</div> 
		</div>
		<div id="sign-area">
			<b>Maskapai Penerbangan</b>, digunakan untuk memilih maskapai penerbangan<br><br />
			<b>Kota  Berangkat</b>, digunakan untuk memilih kota keberangkatan pesawat<br><br />
			<b>Kota Kedatangan</b>, digunakan untuk memilih kota kedatangan pesawat<br><br />
			<b>Tanggal Keberangktan</b>, digunakan untuk memilih tanggal penerbangan<br><br />
		</div>
