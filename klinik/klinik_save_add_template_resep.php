<?php
$no_resep = $_POST['no_resep'];
$nama_resep = $_POST['nama_resep'];
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
	
if(isset($_POST['generik'])) $generik = '1';
if(isset($_POST['psikotropika'])) $psikotropika = '1';

$_err = '';
if(empty($nama_resep))
	$_err = $_err . 'Nama Resep Harus Diisi. \n';	
	
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

$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
mysql_select_db($database, $connect) or die(mysql_error());	
	
if($_err == ''){	
	if(empty($no_resep)){
		$no_resep = getNomorBulanan('TEMPLATE RESEP');
		mysql_query('INSERT INTO t_irja_template_resep(NAMA_RESEP,RESEP,PEGAWAI_ID,DOSIS,GENERIK,PSIKOTROPIKA,NO_TEMPLATE,
				PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,FORMULARIUM,FORMULARIUM_NASIONAL,SATUAN_DOSIS,WAKTU_PAKAI)
				VALUES("' . $nama_resep . '","' . $resep . '","' . $_SESSION['SES_SIMRS_UNIT_ID'] . '","' . $dosis . '",
				"' . $generik . '","' . $psikotropika . '","' . $no_resep . '","' . $persediaan_id . '",
				"' . $jumlah . '","' . $satuan . '","' . $formularium . '","' . $formularium_nasional . '",
				"' . $satuan_dosis . '","' . $waktu_pakai . '")') or die(mysql_error());
	}else{
		mysql_query('UPDATE t_irja_template_resep
				SET NAMA_RESEP = "' . $nama_resep . '"
				WHERE NO_TEMPLATE = "' . $no_resep . '"') or die(mysql_error());
		mysql_query('INSERT INTO t_irja_template_resep(NAMA_RESEP,RESEP,PEGAWAI_ID,DOSIS,GENERIK,PSIKOTROPIKA,NO_TEMPLATE,
				PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,FORMULARIUM,FORMULARIUM_NASIONAL,SATUAN_DOSIS,WAKTU_PAKAI)
				VALUES("' . $nama_resep . '","' . $resep . '","' . $_SESSION['SES_SIMRS_UNIT_ID'] . '","' . $dosis . '",
				"' . $generik . '","' . $psikotropika . '","' . $no_resep . '","' . $persediaan_id . '",
				"' . $jumlah . '","' . $satuan . '","' . $formularium . '","' . $formularium_nasional . '",
				"' . $satuan_dosis . '","' . $waktu_pakai . '")') or die(mysql_error());
	}	
$resep = '';
$jumlah = '';
$dosis = '';
$dosis_lain = '';
$satuan_dosis = '';
$satuan_lain = '';
$waktu_pakai = '';
$waktu_lain = '';
$generik = '';
$psikotropika = '';
?>
	  <script language="JavaScript" >
		document.getElementById("resep").focus();
    </script>
<?php	
}else{
	$arr_atp = explode('|',$dosis);
	$arr_str = explode('|',$satuan_dosis);
	$arr_wkp = explode('|',$waktu_pakai);
?>
	<script language="JavaScript" >
		alert('<?php echo $_err; ?>');
		document.getElementById("resep").focus();
    </script>

<?php
}	
?>