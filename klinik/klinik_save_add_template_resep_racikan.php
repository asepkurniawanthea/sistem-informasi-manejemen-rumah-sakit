<?php
$resep_id = $_POST['resep_id'];
$nama_racikan = $_POST['nama_racikan'];
$resep = $_POST['resep'];
$jumlah = $_POST['jumlah'];

foreach($arr_nama_racikan as $idx=>$row){
	if(isset($_POST['racikan_' . $idx])) $racikan .= $_POST['racikan_' . $idx] . '|'; 
}
if($_POST['racikan_lain'] != '') $racikan .= $_POST['racikan_lain'] . '|';  
if($racikan != '') $racikan = substr($racikan,0,strlen($racikan) - 1);

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
	
if(isset($_POST['generik'])) $generik = '1';
if(isset($_POST['psikotropika'])) $psikotropika = '1';

$_err = '';
if(empty($nama_racikan))
	$_err = $_err . 'Nama Resep Harus Diisi. \n';
$_err = '';
if(empty($racikan))
	$_err = $_err . 'Racikan Harus Diisi. \n';
	
if(empty($resep)){
	$_err = $_err . 'Nama Obat Harus Diisi. \n';
}else{
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
	}else{
		$_err = $_err . 'Nama Obat Tidak Ditemukan. \n';
	}
}

if(empty($jumlah) or !is_numeric($jumlah))
	$_err = $_err . 'Jumlah Harus Diisi & Angka. \n';
/*if(empty($dosis))
	$_err = $_err . 'Aturan Pakai Harus Diisi. \n';
if(empty($satuan_dosis))
	$_err = $_err . 'Satuan Aturan Pakai Harus Diisi. \n';
if(empty($waktu_pakai))
	$_err = $_err . 'Waktu Pakai Harus Diisi. \n';*/

$arr_nrc = explode('|',$racikan);
$arr_atp = explode('|',$dosis);
$arr_str = explode('|',$satuan_dosis);
$arr_wkp = explode('|',$waktu_pakai);

$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
mysql_select_db($database, $connect) or die(mysql_error());	
	
if($_err == ''){		
	if(empty($resep_id)){
		$nomor = getNomorBulanan('TEMPLATE RESEP');
		mysql_query('INSERT INTO t_irja_template_resep(NAMA_RESEP,PEGAWAI_ID,DOSIS,GENERIK,PSIKOTROPIKA,NO_TEMPLATE,
				RACIKAN,SATUAN_DOSIS,WAKTU_PAKAI,NAMA_RACIKAN)
				VALUES("' . $nama_racikan . '","' . $_SESSION['SES_SIMRS_UNIT_ID'] . '","' . $dosis . '",
				"' . $generik . '","' . $psikotropika . '","' . $nomor . '","1",
				"' . $satuan_dosis . '","' . $waktu_pakai . '","' . $racikan . '")') or die(mysql_error());
		$sql_id = 'SELECT t_irja_template_resep.IRJA_TEMPLATE_RESEP_ID
				FROM t_irja_template_resep
				WHERE t_irja_template_resep.PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
				ORDER BY t_irja_template_resep.IRJA_TEMPLATE_RESEP_ID DESC LIMIT 1';
		$get_id = mysql_query($sql_id) or die(mysql_error());
		$dat_id = mysql_fetch_assoc($get_id);
		$resep_id = $dat_id['IRJA_TEMPLATE_RESEP_ID']; 	
	}else{
		mysql_query('UPDATE t_irja_template_resep
				SET NAMA_RESEP = "' . $nama_racikan . '",
				DOSIS = "' . $dosis . '",
				GENERIK = "' . $generik . '",
				PSIKOTROPIKA = "' . $psikotropika . '",
				SATUAN_DOSIS = "' . $satuan_dosis . '",
				WAKTU_PAKAI = "' . $waktu_pakai . '",
				NAMA_RACIKAN = "' . $racikan . '"
				WHERE IRJA_TEMPLATE_RESEP_ID = "' . $resep_id . '"') or die(mysql_error());
	}	
	mysql_query('INSERT INTO t_irja_template_resep_racikan(IRJA_TEMPLATE_RESEP_ID,RESEP,PERSEDIAAN_ID,
				JUMLAH_KELUAR,SATUAN,FORMULARIUM,FORMULARIUM_NASIONAL)
				VALUES("' . $resep_id . '","' . $resep . '","' . $persediaan_id . '",
				"' . $jumlah . '","' . $satuan . '","' . $formularium . '",
				"' . $formularium_nasional . '")') or die(mysql_error()); 

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