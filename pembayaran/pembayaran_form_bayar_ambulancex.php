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
				t_irna.RUANG_ID,m_jaminan.NAMA_JAMINAN,
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
$nama_unit = $dat_pasien['NAMA_UNIT'];
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
$userkasir = $_SESSION['SES_SIMRS_NAMA_PEGAWAI'];

if (isset($_POST['penunjang_id']))
    include('pembayaran/pembayaran_save_penunjang.php');

if (isset($_GET['idk']))
    include('pembayaran/pembayaran_del_add_penunjang.php');
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
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=key=AIzaSyCp8rIQp2ab704BKKWHzVGLOJ1hCVIi5bQ&sensor=false&libraries=places&language=id"></script>
<script src="script/jquery_geo.js"></script>
    <script>
    var dest;
    var directionsDisplay;

    // memanggil service Google Maps Direction
	var directionsService = new google.maps.DirectionsService();
	directionsDisplay = new google.maps.DirectionsRenderer();

    $(document).ready(function() {
        var myOptions = {
            zoom: 4,
            center: new google.maps.LatLng(-2.548926,118.0148634),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        // posisi awal ketika halaman pertama kali dimuat
        var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

        // memanggil fungsi geocoder autocomplete
        var autocomplete = new google.maps.places.Autocomplete((document.getElementById('dest')),{ types: ['geocode'] });
    	
    	/*	
    		fungsi geolocation pada geocoder ini sangat penting
    		agar pencarian daerah tujuan pada textbox ga ngaco 
    	*/
    	if (navigator.geolocation) {
        	navigator.geolocation.getCurrentPosition(function(position) {
            	var geolocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            	autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,geolocation));
        	});
    	}

	});

	$(document).ready(function() {
		// ketika tombol cari di klik, maka proses pencarian rute dimulai
		$("#cari").click(function(){

			dest = $("#dest").val();

			var defaultLatLng = new google.maps.LatLng(-2.548926,118.0148634);

			/*	
				nah, pada fungsi geolocation disini adalah
				ketika koordinat user berhasil didapat maka peta koordinat yang digunakan
				adalah koordinat user, namun jika tidak berhasil maka koordinat yang digunakan
				adalah koordinat default (pada variable defaultLatLng)
			*/
		    if (navigator.geolocation) {
		        function success(pos) {
		            drawMap(pos.coords.latitude,pos.coords.longitude);
		        }

		        function fail(error) {
		            drawMap(defaultLatLng);
		        }
		        
		        navigator.geolocation.getCurrentPosition(success, fail, { maximumAge: 500000, enableHighAccuracy:true, timeout: 6000 });

		    } else {
		        drawMap(defaultLatLng);  
		    }

		    function drawMap(lat,lng) {

		        var myOptions = {
		            zoom: 15,
		            center: new google.maps.LatLng(lat,lng),
		            mapTypeId: google.maps.MapTypeId.ROADMAP
		        };

		        var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

		        // kita bikin marker untuk asal dengan koordinat user hasil dari geolocation
		        var markerorigin = new google.maps.Marker({
	                position: new google.maps.LatLng(parseFloat(lat),parseFloat(lng)),
	                map: map,
	                title: "Origin",
	                visible:false // kita ga perlu menampilkan markernya, jadi visibilitasnya kita set false
				});

		        // membuat request ke Direction Service
		        var request = {
					origin: markerorigin.getPosition(), // untuk daerah asal, kita ambil posisi user
				    destination: dest, // untuk daerah tujuan, kita ambil value dari textbox tujuan
				    provideRouteAlternatives:true, // set true, karena kita ingin menampilkan rute alternatif

				    /**
				     * kamu bisa tambahkan opsi yang lain seperti
				     * avoidHighways:true (set true untuk menghindari jalan raya, set false untuk menonantifkan opsi ini)
				     * atau kamu bisa juga menambahkan opsi seperti
				     * avoidTolls:true (set true untuk menghindari jalan tol, set false untuk menonantifkan opsi ini)
				     */
				    travelMode: google.maps.TravelMode.DRIVING // set mode DRIVING (mode berkendara / kendaraan pribadi)
				    /**
				     * kamu bisa ganti dengan 
				     * google.maps.TravelMode.BICYCLING (mode bersepeda)
				     * google.maps.TravelMode.WALKING (mode berjalan)
				     * google.maps.TravelMode.TRANSIT (mode kendaraan / transportasi umum)
				     */
				};


				directionsService.route(request, function(response, status) {
				    if (status == google.maps.DirectionsStatus.OK) {
				      directionsDisplay.setDirections(response); 
				    }
			  	});
				// menampiklkan rute pada peta dan juga direction panel sebagai petunjuk text
			  	directionsDisplay.setMap(map);
		  		directionsDisplay.setPanel(document.getElementById('directions-panel'));
		  		
		  		// menampilkan layer traffic atau lalu-lintas pada peta
		  		var trafficLayer = new google.maps.TrafficLayer();
  				trafficLayer.setMap(map);

		    }
		});
	});
    </script>
	<input type="text" id="dest" style="width:500px;">
  		<button type="button" id="cari">Cari Rute</button>
  		<br><br>
	    <div id="directions-panel" style="float:right; width:48%; height:600px; overflow:auto;"></div>
	    <div id="map-canvas" style="width:50%; height:600px;"></div>
</div>
</div>
<?php } ?>