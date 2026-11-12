<?php
$irja_id = $_POST['irja_id'];
$resep_id = $_POST['resep_id'];
$jns_order = $_POST['jns_order'];

if(isset($_POST['racikan'])) $racikan = '1';
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

$_err = '';
if(empty($nama_racikan))
	$_err = 'Racikan Harus Diisi. \n';
if(empty($resep))
	$_err .= 'Resep Harus Diisi. \n';
if(empty($jumlah))
	$_err .= 'Jumlah Harus Diisi. \n';
/*if(empty($dosis))
	$_err = $_err . 'Aturan Pakai Harus Diisi. \n';
if(empty($satuan_dosis))
	$_err = $_err . 'Satuan Aturan Pakai Harus Diisi. \n';
if(empty($waktu_pakai))
	$_err = $_err . 'Waktu Pakai Harus Diisi. \n';*/

$arr_nrc = explode('|',$nama_racikan);
$arr_atp = explode('|',$dosis);
$arr_str = explode('|',$satuan_dosis);
$arr_wkp = explode('|',$waktu_pakai);

if($_err == ''){	
	if(empty($jns_order)){
			$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
			$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
			$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
			if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
					   
					if(empty($resep_id)){
						if(empty($nama_racikan)) $nama_racikan = 'Racikan';
						
						$tgl_resep = 'NOW()';
						$sql_temp_resep = 'SELECT DATE_FORMAT(TGL_RESEP_TEMP,"%Y-%m-%d %H:%i:%s") AS TGL_RESEP FROM t_irja_resep 
										WHERE IRJA_ID = "' . $irja_id . '"
										AND NO_RESEP IS NULL AND NO_RESEP_TEMP IS NOT NULL';
						$get_temp_resep = mysql_query($sql_temp_resep) or die(mysql_error());
						if(mysql_num_rows($get_temp_resep) > 0){
							$dat_temp_resep = mysql_fetch_assoc($get_temp_resep);
							$tgl_resep = 'STR_TO_DATE("' . $dat_temp_resep['TGL_RESEP'] . '","%Y-%m-%d %H:%i:%s")';
						}
				
						mysql_query('INSERT INTO t_irja_resep(IRJA_ID,TGL_RESEP,RESEP,DOSIS,RACIKAN,GENERIK,PSIKOTROPIKA,
								SATUAN_DOSIS,WAKTU_PAKAI)
								VALUES("' . $irja_id . '",' . $tgl_resep . ',"' . $nama_racikan . '","' . $dosis . '",
								"' . $racikan . '","' . $generik . '","' . $psikotropika . '","' . $satuan_dosis . '",
								"' . $waktu_pakai . '")') or die(mysql_error());
						$sql_id = 'SELECT IRJA_RESEP_ID FROM t_irja_resep WHERE IRJA_ID = "' . $irja_id . '"
									ORDER BY IRJA_RESEP_ID DESC';
						$get_id = mysql_query($sql_id) or die(mysql_error());
						$dat_id = mysql_fetch_assoc($get_id);
						$resep_id = $dat_id['IRJA_RESEP_ID']; 	
					}else{
						if(empty($nama_racikan)) $nama_racikan = 'Racikan';
						mysql_query('UPDATE t_irja_resep SET RESEP = "' . $nama_racikan . '",DOSIS = "' . $dosis . '",
									GENERIK = "' . $generik . '",PSIKOTROPIKA = "' . $psikotropika . '",
									SATUAN_DOSIS = "' . $satuan_dosis . '",WAKTU_PAKAI = "' . $waktu_pakai . '"
									WHERE IRJA_RESEP_ID = "' . $resep_id . '"') or die(mysql_error());
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
	}else{
			$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $irja_id . '"';
			$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
			$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
			if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
					   
					if(empty($resep_id)){
						if(empty($nama_racikan)) $nama_racikan = 'Racikan';
						$tgl_resep = 'NOW()';
						$sql_temp_resep = 'SELECT DATE_FORMAT(TGL_RESEP_TEMP,"%Y-%m-%d %H:%i:%s") AS TGL_RESEP FROM t_irja_resep 
										WHERE IRJA_ID = "' . $irja_id . '"
										AND NO_RESEP IS NULL AND NO_RESEP_TEMP IS NOT NULL';
						$get_temp_resep = mysql_query($sql_temp_resep) or die(mysql_error());
						if(mysql_num_rows($get_temp_resep) > 0){
							$dat_temp_resep = mysql_fetch_assoc($get_temp_resep);
							$tgl_resep = 'STR_TO_DATE("' . $dat_temp_resep['TGL_RESEP'] . '","%Y-%m-%d %H:%i:%s")';
						}
						
						mysql_query('INSERT INTO t_hemodialisa_resep(HEMODIALISA_ID,TGL_RESEP,RESEP,DOSIS,RACIKAN,GENERIK,PSIKOTROPIKA,
								SATUAN_DOSIS,WAKTU_PAKAI)
								VALUES("' . $irja_id . '",' . $tgl_resep . ',"' . $nama_racikan . '","' . $dosis . '","' . $racikan . '",
								"' . $generik . '","' . $psikotropika . '","' . $satuan_dosis . '","' . $waktu_pakai . '")') or die(mysql_error());
						$sql_id = 'SELECT HEMODIALISA_RESEP_ID FROM t_hemodialisa_resep WHERE HEMODIALISA_ID = "' . $irja_id . '"
									ORDER BY HEMODIALISA_RESEP_ID DESC';
						$get_id = mysql_query($sql_id) or die(mysql_error());
						$dat_id = mysql_fetch_assoc($get_id);
						$resep_id = $dat_id['HEMODIALISA_RESEP_ID']; 	
					}else{
						if(empty($nama_racikan)) $nama_racikan = 'Racikan';
						mysql_query('UPDATE t_hemodialisa_resep SET RESEP = "' . $nama_racikan . '",DOSIS = "' . $dosis . '",
									GENERIK = "' . $generik . '",PSIKOTROPIKA = "' . $psikotropika . '",
									SATUAN_DOSIS = "' . $satuan_dosis . '",WAKTU_PAKAI = "' . $waktu_pakai . '"
									WHERE HEMODIALISA_RESEP_ID = "' . $resep_id . '"') or die(mysql_error());
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
					
					mysql_query('INSERT INTO t_hemodialisa_resep_racikan(HEMODIALISA_RESEP_ID,RESEP,JUMLAH,
								PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL) 
								VALUES("' . $resep_id . '","' . $resep . '","' . $jumlah . '",
								"' . $persediaan_id . '","' . $jumlah_keluar . '","' . $satuan . '","' . $harga . '",
								"' . $formularium . '","' . $formularium_nasional . '")') or die(mysql_error()); 
			}
	}		
$resep = '';
$jumlah = '';
?>
	  <script language="JavaScript" >
		document.getElementById("resep").focus();
    </script>
<?php	
}else{
?>
	<script language="JavaScript" >
		alert('<?php echo $_err; ?>');
		document.getElementById("resep").focus();
    </script>

<?php
}	
?>