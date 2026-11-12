<?php
$irja_id = $_POST['irja_id'];
$resep_tp = $_POST['resep_tp'];
$resep_id = $_POST['resep_id'];

$persediaan_id = '';
$jumlah_keluar = '';
$satuan = '';
$harga = '';
$formularium = '';
$formularium_nasional = '';
$dosis = '';
$satuan_dosis = '';
$waktu_pakai = '';

$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if($resep_tp == '1'){
		if(isset($_POST['generik'])) $generik = '1';
		if(isset($_POST['psikotropika'])) $psikotropika = '1';
		
		$resep = $_POST['resep'];
		$jumlah = $_POST['jumlah'];

		foreach($arr_aturan_pakai as $idx=>$row){
			if(isset($_POST['dosis_' . $idx])) $dosis .= $_POST['dosis_' . $idx] . '|'; 
		}
		if($_POST['dosis_lain'] != '') $dosis .= $_POST['dosis_lain'] . '|';  
		if($dosis != '') $dosis = substr($dosis,0,strlen($dosis) - 1);

		foreach($arr_satuan_resep as $idx=>$row){
			if(isset($_POST['satuan_' . $idx])) $satuan_dosis .= $_POST['satuan_' . $idx] . '|'; 
		}
		if($_POST['satuan_lain'] != '') $satuan_dosis .= $_POST['satuan_lain'] . '|';  
		if($satuan_dosis != '') $satuan_dosis = substr($satuan_dosis,0,strlen($satuan_dosis) - 1);

		foreach($arr_waktu_pakai as $idx=>$row){
			if(isset($_POST['waktu_' . $idx])) $waktu_pakai .= $_POST['waktu_' . $idx] . '|'; 
		}
		if($_POST['waktu_lain'] != '') $waktu_pakai .= $_POST['waktu_lain'] . '|';  
		if($waktu_pakai != '') $waktu_pakai = substr($waktu_pakai,0,strlen($waktu_pakai) - 1);
		
		if(is_numeric($jumlah)) $jumlah_keluar = $jumlah; 
		$resep_array = explode('[',$resep);
		if(count($resep_array)> 1){
			$resep = $resep_array[0];
		}
		
		$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
		mysql_select_db($database_3, $connect_3) or die(mysql_error());
			
		$sql_farmasi = 'SELECT m_persediaan_farmasi.PERSEDIAAN_ID,m_persediaan_farmasi.SATUAN,
							m_persediaan_farmasi.HARGA_JUAL,m_persediaan_farmasi.GENERIK,
							m_persediaan_farmasi.FORMULARIUM,m_persediaan_farmasi.FORMULARIUM_NASIONAL,
							m_persediaan_farmasi.ALKES
							FROM m_persediaan_farmasi
							WHERE m_persediaan_farmasi.NAMA_PERSEDIAAN = "' . trim($resep) . '"';
		$get_farmasi = mysql_query($sql_farmasi) or die(mysql_error());
		if(mysql_num_rows($get_farmasi) > 0){
			$dat_farmasi = mysql_fetch_assoc($get_farmasi);
			$persediaan_id = $dat_farmasi['PERSEDIAAN_ID'];
			$satuan = $dat_farmasi['SATUAN'];
			$harga = $dat_farmasi['HARGA_JUAL'];
			$formularium = $dat_farmasi['FORMULARIUM'];
			$formularium_nasional = $dat_farmasi['FORMULARIUM_NASIONAL'];
		}
			
		$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
		mysql_select_db($database, $connect) or die(mysql_error());
		
		mysql_query('UPDATE t_irja_resep SET RESEP = "' . $resep . '", DOSIS = "' . $dosis . '", JUMLAH = "' . $jumlah . '", 
			GENERIK = "' . $generik . '", PSIKOTROPIKA = "' . $psikotropika . '",
			PERSEDIAAN_ID = "' . $persediaan_id . '",JUMLAH_KELUAR = "' . $jumlah_keluar . '",
			SATUAN = "' . $satuan . '",HARGA = "' . $harga . '",
			FORMULARIUM = "' . $formularium . '",FORMULARIUM_NASIONAL = "' . $formularium_nasional . '",
			SATUAN_DOSIS = "' . $satuan_dosis . '",WAKTU_PAKAI = "' . $waktu_pakai . '"
			WHERE IRJA_RESEP_ID = "' . $resep_id . '"') or die(mysql_error());
	
	}else if($resep_tp == '2'){
		if(isset($_POST['generik'])) $generik = '1';
		if(isset($_POST['psikotropika'])) $psikotropika = '1';
		
		foreach($arr_nama_racikan as $idx=>$row){
			if(isset($_POST['racikan_' . $idx])) $nama_racikan .= $_POST['racikan_' . $idx] . '|'; 
		}
		if($_POST['racikan_lain'] != '') $nama_racikan .= $_POST['racikan_lain'] . '|';  
		if($nama_racikan != '') $nama_racikan = substr($nama_racikan,0,strlen($nama_racikan) - 1);
		
		foreach($arr_aturan_pakai as $idx=>$row){
			if(isset($_POST['dosis_' . $idx])) $dosis .= $_POST['dosis_' . $idx] . '|'; 
		}
		if($_POST['dosis_lain'] != '') $dosis .= $_POST['dosis_lain'] . '|';  
		if($dosis != '') $dosis = substr($dosis,0,strlen($dosis) - 1);

		foreach($arr_satuan_resep as $idx=>$row){
			if(isset($_POST['satuan_' . $idx])) $satuan_dosis .= $_POST['satuan_' . $idx] . '|'; 
		}
		if($_POST['satuan_lain'] != '') $satuan_dosis .= $_POST['satuan_lain'] . '|';  
		if($satuan_dosis != '') $satuan_dosis = substr($satuan_dosis,0,strlen($satuan_dosis) - 1);

		foreach($arr_waktu_pakai as $idx=>$row){
			if(isset($_POST['waktu_' . $idx])) $waktu_pakai .= $_POST['waktu_' . $idx] . '|'; 
		}
		if($_POST['waktu_lain'] != '') $waktu_pakai .= $_POST['waktu_lain'] . '|';  
		if($waktu_pakai != '') $waktu_pakai = substr($waktu_pakai,0,strlen($waktu_pakai) - 1);
		
		
		mysql_query('UPDATE t_irja_resep SET RESEP = "' . $nama_racikan . '", DOSIS = "' . $dosis . '",  
			GENERIK = "' . $generik . '", PSIKOTROPIKA = "' . $psikotropika . '",
			SATUAN_DOSIS = "' . $satuan_dosis . '",WAKTU_PAKAI = "' . $waktu_pakai . '"
			WHERE IRJA_RESEP_ID = "' . $resep_id . '"') or die(mysql_error());
			
			if(!empty($_POST['resep'])){
				$resep = $_POST['resep'];
				$jumlah = $_POST['jumlah'];
		
				$persediaan_id = '';
				$jumlah_keluar = '';
				$satuan = '';
				$harga = '';
				$formularium = '';	
				$formularium_nasional = '';
				
				if(is_numeric($jumlah)) $jumlah_keluar = $jumlah; 
				$resep_array = explode('[',$resep);
				if(count($resep_array)> 1){
					$resep = $resep_array[0];
				}
				
				$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
				mysql_select_db($database_3, $connect_3) or die(mysql_error());
			
				$sql_farmasi = 'SELECT m_persediaan_farmasi.PERSEDIAAN_ID,m_persediaan_farmasi.SATUAN,
							m_persediaan_farmasi.HARGA_JUAL,m_persediaan_farmasi.GENERIK,
							m_persediaan_farmasi.FORMULARIUM,m_persediaan_farmasi.FORMULARIUM_NASIONAL,
							m_persediaan_farmasi.ALKES
							FROM m_persediaan_farmasi
							WHERE m_persediaan_farmasi.NAMA_PERSEDIAAN = "' . trim($resep) . '"';
				$get_farmasi = mysql_query($sql_farmasi) or die(mysql_error());
				if(mysql_num_rows($get_farmasi) > 0){
					$dat_farmasi = mysql_fetch_assoc($get_farmasi);
					$persediaan_id = $dat_farmasi['PERSEDIAAN_ID'];
					$satuan = $dat_farmasi['SATUAN'];
					$harga = $dat_farmasi['HARGA_JUAL'];
					$formularium = $dat_farmasi['FORMULARIUM'];
					$formularium_nasional = $dat_farmasi['FORMULARIUM_NASIONAL'];
				}
			
				$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
				mysql_select_db($database, $connect) or die(mysql_error());
			
				mysql_query('INSERT INTO t_irja_resep_racikan(IRJA_RESEP_ID,RESEP,JUMLAH,
					PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL) 
					VALUES("' . $resep_id . '","' . $resep . '","' . $jumlah . '",
					"' . $persediaan_id . '","' . $jumlah_keluar . '","' . $satuan . '","' . $harga . '",
						"' . $formularium . '","' . $formularium_nasional . '")') or die(mysql_error());
			}	
	}else if($resep_tp == '3'){
		$resep = $_POST['resep'];
		$jumlah = $_POST['jumlah'];
		
		$persediaan_id = '';
		$jumlah_keluar = '';
		$satuan = '';
		$harga = '';
		$formularium = '';	
		$formularium_nasional = '';
		
		if(is_numeric($jumlah)) $jumlah_keluar = $jumlah; 
		$resep_array = explode('[',$resep);
		if(count($resep_array)> 1){
			$resep = $resep_array[0];
		}
		
		$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
		mysql_select_db($database_3, $connect_3) or die(mysql_error());
			
		$sql_farmasi = 'SELECT m_persediaan_farmasi.PERSEDIAAN_ID,m_persediaan_farmasi.SATUAN,
							m_persediaan_farmasi.HARGA_JUAL,m_persediaan_farmasi.GENERIK,
							m_persediaan_farmasi.FORMULARIUM,m_persediaan_farmasi.FORMULARIUM_NASIONAL,
							m_persediaan_farmasi.ALKES
							FROM m_persediaan_farmasi
							WHERE m_persediaan_farmasi.NAMA_PERSEDIAAN = "' . trim($resep) . '"';
		$get_farmasi = mysql_query($sql_farmasi) or die(mysql_error());
		if(mysql_num_rows($get_farmasi) > 0){
			$dat_farmasi = mysql_fetch_assoc($get_farmasi);
			$persediaan_id = $dat_farmasi['PERSEDIAAN_ID'];
			$satuan = $dat_farmasi['SATUAN'];
			$harga = $dat_farmasi['HARGA_JUAL'];
			$formularium = $dat_farmasi['FORMULARIUM'];
			$formularium_nasional = $dat_farmasi['FORMULARIUM_NASIONAL'];
		}
			
		$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
		mysql_select_db($database, $connect) or die(mysql_error());
		
		mysql_query('UPDATE t_irja_resep_racikan SET RESEP = "' . $resep . '", JUMLAH = "' . $jumlah . '",
				PERSEDIAAN_ID = "' . $persediaan_id . '",JUMLAH_KELUAR = "' . $jumlah_keluar . '",
				SATUAN = "' . $satuan . '",HARGA = "' . $harga . '",
				FORMULARIUM = "' . $formularium . '",FORMULARIUM_NASIONAL = "' . $formularium_nasional . '"
				WHERE IRJA_RESEP_RACIKAN_ID = "' . $resep_id . '"') or die(mysql_error());
	}
}
?>
	  <script language="JavaScript" >
		opener.location.reload();
		window.close();
    </script>