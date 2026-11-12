<?php
$irna_id = $_POST['irna_id'];
$nomr = $_POST['nomr'];
if(isset($_POST['racikan'])) $racikan = '1';
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
if(empty($resep))
	$_err = 'Resep Harus Diisi. \n';	
if(empty($jumlah))
	$_err .= 'Jumlah Harus Diisi. \n';
if(empty($dosis))
	$_err = $_err . 'Aturan Pakai Harus Diisi. \n';
if(empty($satuan_dosis))
	$_err = $_err . 'Satuan Aturan Pakai Harus Diisi. \n';
if(empty($waktu_pakai))
	$_err = $_err . 'Waktu Pakai Harus Diisi. \n';	

if($_err == ''){	
	$sql_cek_no_rawat = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
	$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
	$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
	if (empty($dat_cek_no_rawat['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
		       
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

			$tgl_resep = 'NOW()';
			$sql_temp_resep = 'SELECT DATE_FORMAT(TGL_RESEP_TEMP,"%Y-%m-%d %H:%i:%s") AS TGL_RESEP FROM t_irna_resep 
							WHERE IRNA_ID = "' . $irna_id . '"
							AND NO_RESEP IS NULL AND NO_RESEP_TEMP IS NOT NULL';
			$get_temp_resep = mysql_query($sql_temp_resep) or die(mysql_error());
			if(mysql_num_rows($get_temp_resep) > 0){
				$dat_temp_resep = mysql_fetch_assoc($get_temp_resep);
				$tgl_resep = 'STR_TO_DATE("' . $dat_temp_resep['TGL_RESEP'] . '","%Y-%m-%d %H:%i:%s")';
			}
			
			mysql_query('INSERT INTO t_irna_resep(IRNA_ID,RESEP,DOSIS,JUMLAH,RACIKAN,GENERIK,PSIKOTROPIKA,
						PERSEDIAAN_ID,JUMLAH_KELUAR,SATUAN,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL,TGL_RESEP,
						SATUAN_DOSIS,WAKTU_PAKAI)
						VALUES("' . $irna_id . '","' . $resep . '","' . $dosis . '","' . $jumlah . '","' . $racikan . '","' . $generik . '","' . $psikotropika . '",
						"' . $persediaan_id . '","' . $jumlah_keluar . '","' . $satuan . '","' . $harga . '",
						"' . $formularium . '","' . $formularium_nasional . '",' . $tgl_resep . ',
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
		setTimeout(opener.location.reload(), 3000);
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