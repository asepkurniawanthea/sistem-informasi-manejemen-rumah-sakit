<?php if(isset($_GET['idx']) and isset($_GET['ord'])){
$idx = $_GET['idx'];
$ord = $_GET['ord'];

$sql_tanggal = 'SELECT DATE_FORMAT(CURRENT_DATE(),"%d/%m/%Y") AS TANGGAL FROM DUAL';
$get_tanggal = mysql_query($sql_tanggal) or die(mysql_error());
$dat_tanggal = mysql_fetch_assoc($get_tanggal);
$tanggal = $dat_tanggal['TANGGAL'];

$idx = $_GET['idx'];
if($ord == 'irj'){
	$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				t_irja.PASIEN_MASUK,m_unit.NAMA_UNIT,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irja.JENIS_BAYAR_ID
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_irja.IRJA_ID = "' . $_GET['idx'] . '"';
}else{
	$qry_pasien = 'SELECT t_irna.IRNA_ID AS IRJA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,
				t_irna.RUANG_ID AS UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				t_irna.PASIEN_MASUK,CONCAT(m_ruang.NAMA_RUANG," ",t_irna.KELAS_RAWAT) AS NAMA_UNIT,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_irna.NO_SEP,t_irna.ST_PULANG,
				DATE_FORMAT(NOW(),"%Y-%m-%d %H:%i:%s") AS TANGGAL_PULANG,
				t_irna.JENIS_BAYAR_ID
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				WHERE t_irna.IRNA_ID = "' . $_GET['idx'] . '"';
}				
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];
$jenis_bayar_id = $dat_pasien['JENIS_BAYAR_ID'];

$irja_id = $dat_pasien['IRJA_ID'];
$pegawai_id = $dat_pasien['PEGAWAI_ID'];
$id_unit = $dat_pasien['UNIT_ID'];
$nama_unit = $dat_pasien['NAMA_UNIT'];
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
$userkasir = $_SESSION['SES_SIMRS_NAMA_PEGAWAI'];

if (isset($_POST['tuj_ambulance']))
    include('pembayaran/pembayaran_save_ambulance.php');
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik/Ruang</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br /><br />
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCp8rIQp2ab704BKKWHzVGLOJ1hCVIi5bQ&sensor=false&libraries=places&language=id"></script>
    <script src="script/jquery_geo.js"></script>
    <script>
    var dest;
    var directionsDisplay;

    var directionsService = new google.maps.DirectionsService();
	directionsDisplay = new google.maps.DirectionsRenderer();

    $(document).ready(function() {
        var myOptions = {
            zoom: 4,
            center: new google.maps.LatLng(-6.162104, 106.634676),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
        var autocomplete = new google.maps.places.Autocomplete((document.getElementById('dest')),{ types: ['geocode'] });
    	
    	if (navigator.geolocation) {
        	navigator.geolocation.getCurrentPosition(function(position) {
            	var geolocation = new google.maps.LatLng(-6.162104, 106.634676);
            	autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,geolocation));
        	});
    	}

	});

	$(document).ready(function() {
		$("#cari").click(function(){

			dest = $("#dest").val();

			var defaultLatLng = new google.maps.LatLng(-6.162104, 106.634676);
			
		    if (navigator.geolocation) {
		        function success(pos) {
		            drawMap(-6.162104, 106.634676);
		        }

		        function fail(error) {
		            drawMap(-6.162104, 106.634676);
		        }
		        
		        navigator.geolocation.getCurrentPosition(success, fail, { maximumAge: 500000, enableHighAccuracy:true, timeout: 6000 });

		    } else {
		        drawMap(-6.162104, 106.634676);  
		    }

		    function drawMap(lat,lng) {

		        var myOptions = {
		            zoom: 15,
		            center: new google.maps.LatLng(lat,lng),
		            mapTypeId: google.maps.MapTypeId.ROADMAP
		        };

		        var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

		        var markerorigin = new google.maps.Marker({
	                position: new google.maps.LatLng(parseFloat(lat),parseFloat(lng)),
	                map: map,
	                title: "Origin",
	                visible:false 
				});

		        var request = {
					origin: markerorigin.getPosition(), 
				    destination: dest, 
				    provideRouteAlternatives:false, 

				    travelMode: google.maps.TravelMode.DRIVING
				};


				directionsService.route(request, function(response, status) {
				    if (status == google.maps.DirectionsStatus.OK) {
						setData(response.routes[0].legs[0].end_address,response.routes[0].summary,response.routes[0].legs[0].distance.value,response.routes[0].legs[0].duration.value);
						directionsDisplay.setDirections(response); 
				    }
			  	});
				
			  	directionsDisplay.setMap(map);
		  		directionsDisplay.setPanel(document.getElementById('directions-panel'));
		  		
		  		var trafficLayer = new google.maps.TrafficLayer();
  				trafficLayer.setMap(map);

		    }
		});
	});
	
	function secondsToHms(d) {
		d = Number(d);
		var h = Math.floor(d / 3600);
		var m = Math.floor(d % 3600 / 60);
		var s = Math.floor(d % 3600 % 60);

		var hDisplay = h > 0 ? h + (h == 1 ? " jam " : " jam ") : "";
		var mDisplay = m > 0 ? m + (m == 1 ? " menit " : " menit ") : "";
		var sDisplay = s > 0 ? s + (s == 1 ? " detik" : " detik") : "";
		
		return hDisplay + mDisplay; 
	}
	
	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	}
	
	function setData(tujuan,rute,jarak,durasi){
		var jarakx = jarak / 1000;
		var jaraky = jarakx.toFixed(1);
		var durasix = secondsToHms(durasi);
		$('#tuj_ambulance').val(tujuan + ' - ' + jaraky + ' km - ' + rute + ' - '  + durasix);
		
		$('#tujuan').val(tujuan);
		$('#rute').val(rute);
		$('#jarak').val(jaraky);
		$('#durasi').val(durasix);
		
		$('#ambulance_lengkap').val('1');
		$('#ambulance_reguler').val('1');
		$('#ambulance_jenazah').val('1');
		
		$('#harga_ambulance_lengkap').val($('#tarif_ambulance_lengkap').val());
		$('#harga_ambulance_reguler').val($('#tarif_ambulance_reguler').val());
		$('#harga_ambulance_jenazah').val($('#tarif_ambulance_jenazah').val());
		
		if(jaraky > 12){
			document.getElementById("ambulance_tambahan").checked = true;
			var jarak_tambahan = Math.floor(jaraky) - 12;
			var jarak_str = jaraky + '';
			var jarak_arr = jarak_str.split('.');
			if(jarak_arr.length > 0){
				if(jarak_arr[1] > 0){
					jarak_tambahan = jarak_tambahan + 1;
				}
			}
			$('#jml_ambulance_tambahan').val(jarak_tambahan);
			$('#harga_ambulance_tambahan').val(jarak_tambahan * $('#tarif_ambulance_tambahan').val());
		}
		
		if(jaraky > 20){
			var jarak_tambahan = Math.floor(jaraky) - 20;
			var jarak_str = jaraky + '';
			var jarak_arr = jarak_str.split('.');
			if(jarak_arr.length > 0){
				if(jarak_arr[1] > 0){
					jarak_tambahan = jarak_tambahan + 1;
				}
			}
			$('#jml_ambulance_jenazah_tambahan').val(jarak_tambahan);
			$('#harga_ambulance_jenazah_tambahan').val(jarak_tambahan * $('#tarif_ambulance_jenazah_tambahan').val());
		}
		$("#ambulance_tipe_2").prop("checked", true);
		clickTipeAmbulance(1);
		hitungTotal();
	}
	
	function clickTipeAmbulance(opt){
		if(opt==1 || opt==2){
			$("#ambulance_tambahan").prop("checked", false);
			$("#ambulance_jenazah_tambahan").prop("checked", false);
			$("#ambulance_pendamping_1").prop("checked", false);
			$("#ambulance_pendamping_2").prop("checked", false);
			document.getElementById("ambulance_tambahan").disabled= false;
			document.getElementById("ambulance_jenazah_tambahan").disabled= true;
			document.getElementById("ambulance_pendamping_1").disabled= false;
			document.getElementById("ambulance_pendamping_2").disabled= false;
		}else{
			$("#ambulance_tambahan").prop("checked", false);
			$("#ambulance_jenazah_tambahan").prop("checked", false);
			$("#ambulance_pendamping_1").prop("checked", false);
			$("#ambulance_pendamping_2").prop("checked", false);
			document.getElementById("ambulance_tambahan").disabled= true;
			document.getElementById("ambulance_jenazah_tambahan").disabled= false;
			document.getElementById("ambulance_pendamping_1").disabled= true;
			document.getElementById("ambulance_pendamping_2").disabled= true;
		}	
	}
	
	function hitungTotal(){
		var total = 0;
		
			if($('#ambulance_tipe_1').is(':checked')) { 
				total = total + parseInt($('#harga_ambulance_lengkap').val()); 
			}
			
			if($('#ambulance_tipe_2').is(':checked')) { 
				total = total + parseInt($('#harga_ambulance_reguler').val()); 
			}
			
			if($('#ambulance_tipe_3').is(':checked')) { 
				total = total + parseInt($('#harga_ambulance_jenazah').val()); 
			}
			
			if($('#ambulance_tambahan').is(':checked')) { 
				total = total + parseInt($('#harga_ambulance_tambahan').val());
			}
			
			if($('#ambulance_jenazah_tambahan').is(':checked')) { 
				total = total + parseInt($('#harga_ambulance_jenazah_tambahan').val());
			}
			
			if($('#ambulance_pendamping_1').is(':checked')) { 
				total = total + parseInt($('#harga_ambulance_pendamping_dalam_kota').val()); 
			}
			
			if($('#ambulance_pendamping_2').is(':checked')) { 
				total = total + parseInt($('#harga_ambulance_pendamping_luar_kota').val()); 
			}	
		
		$('#total').html(numberWithCommas(total));
	}
	
	function clickCkPerawat(opt){
		if(opt == 1){
			if($('#ambulance_pendamping_1').is(':checked')) {
				document.getElementById("ambulance_pendamping_2").checked = false;
			}	
		}
		
		if(opt == 2){
			if($('#ambulance_pendamping_2').is(':checked')) {
				document.getElementById("ambulance_pendamping_1").checked = false;
			}	
		}
		
		hitungTotal();
	}
	
	function textPerawat(opt){
		if(opt == 1){
			document.getElementById("ambulance_pendamping_1").checked = true;
			document.getElementById("ambulance_pendamping_2").checked = false;
		}
		
		if(opt == 2){
			document.getElementById("ambulance_pendamping_1").checked = false;
			document.getElementById("ambulance_pendamping_2").checked = true;
		}
		
		var qty = parseInt($('#ambulance_pendamping_dalam_kota').val());
		var hrg = parseInt($('#tarif_ambulance_pendamping_dalam_kota').val());
		$('#harga_ambulance_pendamping_dalam_kota').val(qty * hrg);
		
		var qty = parseInt($('#ambulance_pendamping_luar_kota').val());
		var hrg = parseInt($('#tarif_ambulance_pendamping_luar_kota').val());
		$('#harga_ambulance_pendamping_luar_kota').val(qty * hrg);
		
		hitungTotal();
	}
	
	function selesai(link){
		window.location = link;
	}
	
	function validSubmit(t){
		/*if($('#tuj_ambulance').val() != ''){
		
			var _err = '';
			var _pend = 0;
			var _st = true;
			var _jm = 0;
			
			if($('#ambulance_pendamping_1').is(':checked')) {
				var jmlPendamping_dk = $('#ambulance_pendamping_dalam_kota').val();
				
				if(isNaN(jmlPendamping_dk) || (jmlPendamping_dk == '0')){
					_err = 'Isian Jumlah Perawat Pendamping Dalam Kota Tidak Valid. \n ';
					_st = false;
				}else{
					_jm = parseInt(jmlPendamping_dk);
				}
			}

			if($('#ambulance_pendamping_2').is(':checked')) {
				var jmlPendamping_lk = $('#ambulance_pendamping_luar_kota').val();
				
				if(isNaN(jmlPendamping_lk) || (jmlPendamping_lk == '0')){
					_err = _err + 'Isian Jumlah Perawat Pendamping Luar Kota Tidak Valid. \n ';
					_st = false;
				}else{
					_jm = parseInt(jmlPendamping_lk);
				}
			}

			if($('#no_polisi').val() == ''){
				_err = _err + 'Nomor Polisi Harus Diisi. \n ';
			}

			if($('#driver').val() == ''){
				_err = _err + 'Driver Harus Diisi. \n ';
			}
			
			var select_id1 = document.getElementById("pendamping_1");
			if(select_id1[select_id1.selectedIndex].value != ''){
				_pend = _pend + 1;
			}
			
			var select_id2 = document.getElementById("pendamping_2");
			if(select_id2[select_id2.selectedIndex].value != ''){
				_pend = _pend + 1;
			}
			
			var select_id3 = document.getElementById("pendamping_3");
			if(select_id3[select_id3.selectedIndex].value != ''){
				_pend = _pend + 1;
			}
			
			if(_st == true){
				if(_pend < _jm){
					_err = _err + 'Pendamping Belum Diisi. \n ';
				}
			}
			
			if(_err != ''){
				alert(_err);
			}else{
				$('#gform').submit();
			}
		}	*/
		
		$('#gform').submit();
	}
    </script>
		Tujuan&nbsp;&nbsp;
  		<input type="text" id="dest" style="width:600px;" class="text_dt">
  		<button type="button" id="cari" class="myButton">cari rute</button>
  		<br><br>
	    <div id="directions-panel" style="float:right; width:48%; height:600px; overflow:auto;"></div>
	    <div id="map-canvas" style="width:50%; height:600px;"></div>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<form name="gform" id="gform" method="post" action="<?php echo currentUrl(); ?>">
<table width="90%" border="1" class="tableData" >
<tr>
	<th>&nbsp;</th>
	<th>Tindakan</th>
	<th>Jumlah</th>
	<th>Satuan</th>
	<th>Harga</th>
	<!--<th>Jumlah Harga</th>-->
</tr>
<tr>
	<td colspan="5" align="center">Tujuan - Rute - Jarak Tempuh - Durasi&nbsp;&nbsp;<input type="text" name="tuj_ambulance" id="tuj_ambulance" class="text_dt" readonly style="width:700px;"/>
	<input type="hidden" name="tujuan" id="tujuan" value="" />
	<input type="hidden" name="rute" id="rute" value="" />
	<input type="hidden" name="jarak" id="jarak" value="" />
	<input type="hidden" name="durasi" id="durasi" value="" />
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="unit_id" id="unit_id" value="<?php echo $id_unit; ?>" />
	<input type="hidden" name="ord" id="ord" value="<?php echo $ord; ?>" />
	<input type="hidden" name="jenis_bayar_id" id="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
	</td>
</tr>
<!--<tr>
	<td><input type="radio" name="ambulance_tipe" id="ambulance_tipe_1" value="1" onclick="clickTipeAmbulance(1);hitungTotal();" /></td>
	<td>Ambulance Lengkap</td>
	<td><input type="text" name="ambulance_lengkap" id="ambulance_lengkap" value="0" readonly class="text_dt" style="width:100px;text-align:right;"/></td>
	<td>sd 12 km</td>
	<td><input type="text" name="tarif_ambulance_lengkap" id="tarif_ambulance_lengkap" class="text_dt" value="100000"  readonly style="width:100px;text-align:right;"/></td>
	<td align="right"><input type="text" name="harga_ambulance_lengkap" id="harga_ambulance_lengkap" class="text_dt" value="0" readonly style="width:100px;text-align:right;"/></td>
</tr>
<tr>
	<td><input type="radio" name="ambulance_tipe" id="ambulance_tipe_2" value="2" onclick="clickTipeAmbulance(2);hitungTotal();" /></td>
	<td>Ambulance Reguler</td>
	<td><input type="text" name="ambulance_reguler" id="ambulance_reguler" value="0" readonly class="text_dt" style="width:100px;text-align:right;"/></td>
	<td>sd 12 km</td>
	<td><input type="text" name="tarif_ambulance_reguler" id="tarif_ambulance_reguler" class="text_dt" value="60000" readonly style="width:100px;text-align:right;"/></td>
	<td align="right"><input type="text" name="harga_ambulance_reguler" id="harga_ambulance_reguler" class="text_dt" value="0" readonly style="width:100px;text-align:right;"/></td>
</tr>
<tr>
	<td><input type="radio" name="ambulance_tipe" id="ambulance_tipe_3" value="3" onclick="clickTipeAmbulance(3);hitungTotal();" /></td>
	<td>Ambulance Jenazah</td>
	<td><input type="text" name="ambulance_jenazah" id="ambulance_jenazah" value="0" readonly class="text_dt" style="width:100px;text-align:right;"/></td>
	<td>sd 20 km</td>
	<td><input type="text" name="tarif_ambulance_jenazah" id="tarif_ambulance_jenazah" class="text_dt" value="120000" readonly style="width:100px;text-align:right;"/></td>
	<td align="right"><input type="text" name="harga_ambulance_jenazah" id="harga_ambulance_jenazah" class="text_dt" value="0" readonly style="width:100px;text-align:right;"/></td>
</tr>
<tr>
	<td><input type="checkbox" name="ambulance_tambahan" id="ambulance_tambahan" value="1" onclick="hitungTotal();" /></td>
	<td>Biaya Tambahan</td>
	<td><input type="text" name="jml_ambulance_tambahan" id="jml_ambulance_tambahan" value="0" readonly class="text_dt" style="width:100px;text-align:right;"/></td>
	<td>per km</td>
	<td><input type="text" name="tarif_ambulance_tambahan" id="tarif_ambulance_tambahan" class="text_dt" value="7000" readonly style="width:100px;text-align:right;"/></td>
	<td align="right"><input type="text" name="harga_ambulance_tambahan" id="harga_ambulance_tambahan" class="text_dt" value="0" readonly style="width:100px;text-align:right;"/></td>
</tr>
<tr>
	<td><input type="checkbox" name="ambulance_jenazah_tambahan" id="ambulance_jenazah_tambahan" value="1" onclick="hitungTotal();" /></td>
	<td>Biaya Tambahan Ambulance Jenazah</td>
	<td><input type="text" name="jml_ambulance_jenazah_tambahan" id="jml_ambulance_jenazah_tambahan" value="0" readonly class="text_dt" style="width:100px;text-align:right;"/></td>
	<td>per km</td>
	<td><input type="text" name="tarif_ambulance_jenazah_tambahan" id="tarif_ambulance_jenazah_tambahan" class="text_dt" value="8400" readonly style="width:100px;text-align:right;"/></td>
	<td align="right"><input type="text" name="harga_ambulance_jenazah_tambahan" id="harga_ambulance_jenazah_tambahan" class="text_dt" value="0" readonly style="width:100px;text-align:right;"/></td>
</tr>
<tr>
	<td><input type="checkbox" name="ambulance_pendamping_1" id="ambulance_pendamping_1" value="1" onclick="clickCkPerawat(1);" /></td>
	<td>Biaya Tambahan Perawat Pendamping (Kota Tangerang, Kabupaten Tangerang, Tangerang Selatan)</td>
	<td><input type="text" name="ambulance_pendamping_dalam_kota" id="ambulance_pendamping_dalam_kota" value="0" class="text_dt" style="width:100px;text-align:right;" onchange="textPerawat(1);" /></td>
	<td>per perawat</td>
	<td><input type="text" name="tarif_ambulance_pendamping_dalam_kota" id="tarif_ambulance_pendamping_dalam_kota" class="text_dt" value="75000" readonly style="width:100px;text-align:right;"/></td>
	<td align="right"><input type="text" name="harga_ambulance_pendamping_dalam_kota" id="harga_ambulance_pendamping_dalam_kota" class="text_dt" value="0" readonly style="width:100px;text-align:right;"/></td>
</tr>
<tr>
	<td><input type="checkbox" name="ambulance_pendamping_2" id="ambulance_pendamping_2" value="1" onclick="clickCkPerawat(2);" /></td>
	<td>Biaya Tambahan Perawat Pendamping (Luar Tangerang)</td>
	<td><input type="text" name="ambulance_pendamping_luar_kota" id="ambulance_pendamping_luar_kota" value="0" class="text_dt" style="width:100px;text-align:right;" onchange="textPerawat(2);" /></td>
	<td>per perawat</td>
	<td><input type="text" name="tarif_ambulance_pendamping_luar_kota" id="tarif_ambulance_pendamping_luar_kota" class="text_dt" value="150000" readonly style="width:100px;text-align:right;"/></td>
	<td align="right"><input type="text" name="harga_ambulance_pendamping_luar_kota" id="harga_ambulance_pendamping_luar_kota" class="text_dt" value="0" readonly style="width:100px;text-align:right;"/></td>
</tr>-->
<?php 
$sql_tarif = 'SELECT TARIF_ID,KODE_TARIF,NAMA_TARIF,SATUAN,TARIF_NON_KELAS
				FROM m_tarif
				WHERE KODE_TARIF_GROUP = "49"
				AND ST_AKTIF = "1"';
$get_tarif = mysql_query($sql_tarif) or die(mysql_error());
$t = 1;
while($dat_tarif = mysql_fetch_array($get_tarif)){ ?>
<tr>
	<td><input type="checkbox" name="tarif<?php echo $t; ?>" value="<?php echo $dat_tarif['TARIF_ID']; ?>" /></td>
	<td><?php echo $dat_tarif['NAMA_TARIF']; ?></td>
	<td><input type="text" name="jumlah<?php echo $t; ?>" value="1" class="text_dt" style="width:100px;text-align:right;"/></td>
	<td><?php echo $dat_tarif['SATUAN']; ?></td>
	<td align="right"><?php echo currFormat($dat_tarif['TARIF_NON_KELAS']); ?></td>
	<!--<td align="right"><input type="text" name="harga_ambulance_pendamping_luar_kota" id="harga_ambulance_pendamping_luar_kota" class="text_dt" value="0" readonly style="width:100px;text-align:right;"/></td>-->
</tr>
<?php $t++;
} ?>
<!--<tr>
	<td colspan="5" align="right">Total Rp.</td>
	<td align="right"><div id="total">0</div></td>
</tr>-->
</table>
	<table width="100%" border="0">
	<tr>
		<td>&nbsp;</td>
		<td width="120px" >Nomor Polisi</td>
		<td><input type="text" name="no_polisi" id="no_polisi" class="text_dt" /></td>
		<td>&nbsp;</td>
		<td width="160px" >Perawat Pendamping</td>
		<td>
		<select name="pendamping_1" id="pendamping_1" class="text_dt" style="width:280px;">
		<option value=""> - </option>
		<?php echo getPerawat(''); ?>	
		</select>		
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>Driver</td>
		<td>
		<select name="driver" id="driver" class="text_dt" style="width:280px;">
		<option value=""> - </option>
		<?php echo getDriver(''); ?>	
		</select>		
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		<select name="pendamping_2" id="pendamping_2" class="text_dt" style="width:280px;">
		<option value=""> - </option>
		<?php echo getPerawat(''); ?>	
		</select>		
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		<select name="pendamping_3" id="pendamping_3" class="text_dt" style="width:280px;">
		<option value=""> - </option>
		<?php echo getPerawat(''); ?>	
		</select>		
		</td>
	</tr>
	<tr>
            <td colspan="6" align="right">
			<input type="hidden" name="cn_t" value="<?php echo $t; ?>" />
			<input type="button" value="selesai" class="myButton1" onclick="javascript : selesai('index.php?link=a24012d326ea009a2cdc16f4ed6b8894&idx=<?php echo $irja_id; ?>&ord=<?php echo $ord; ?>');return false;" />
			<input type="button" name="simpan" value="simpan" class="myButton1" onclick="validSubmit();" /></td>	
        </tr>
	</table>
</form>	
</div>
</div>
<?php } ?>		