<?php
$penunjang_id = $_POST['penunjang_id'];
$cnz = $_POST['cnz'];
$catatan_spesimen = $_POST['catatan_spesimen'];
$pemeriksa = $_POST['pemeriksa'];
$dokter = $_POST['dokter'];
$hasil_tes_kritis = '';
if(isset($_POST['hasil_tes_kritis'])) $hasil_tes_kritis = $_POST['hasil_tes_kritis'];

$tgl_sampling = $_POST['tgl_sampling'];
$jam_sampling = $_POST['jam_sampling'];
$menit_sampling = $_POST['menit_sampling'];
		
$tgl_hasil = $_POST['tgl_hasil'];
$jam_hasil = $_POST['jam_hasil'];
$menit_hasil = $_POST['menit_hasil'];

$tgl_jam_sampling = $tgl_sampling . ' ' . $jam_sampling . ':' . $menit_sampling . ':00';
$tgl_jam_hasil = $tgl_hasil . ' ' . $jam_hasil . ':' . $menit_hasil . ':00';

$tgl_diagnosa = getNow();
$nomor = getNomorHarian('Laboratorium');

function cekStatus($id){
	$ret = false;
	$sql_status = 'SELECT DISTINCT ST_DIAGNOSA FROM t_ipenunjang_tarif
					WHERE PENUNJANG_TARIF_ID = "' . $id . '"';
	$get_status = mysql_query($sql_status) or die(mysql_error());
	$dat_status = mysql_fetch_assoc($get_status);
	if($dat_status['ST_DIAGNOSA'] == '1') $ret = true;
	if($_SESSION['SES_SIMRS_ADMIN'] == '1') $ret = false;
return $ret;	
}

function updateStatus($pti,$tgl,$catatan,$pmrks,$dktr,$uname,$jamhasil,$jamsample,$nmr,$kritis){
	$ret_id = true;
	$sqlstatus = 'SELECT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,
				t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_tarif_pemeriksaan.CH_REPORT,m_tarif_pemeriksaan.REPORT_FORMAT
				FROM t_ipenunjang_tarif
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (t_ipenunjang_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID = m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID)
				WHERE t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $pti . '"';
	$getstatus = mysql_query($sqlstatus) or die(mysql_query());
	while($datstatus = mysql_fetch_array($getstatus)){
		$hasil_diagnosa_array = explode('|!|',$datstatus['HASIL_DIAGNOSA']);
		if(sizeof($hasil_diagnosa_array) == 5){
			if(empty($hasil_diagnosa_array[0]) or empty($hasil_diagnosa_array[1]) or empty($hasil_diagnosa_array[2]) 
				or empty($hasil_diagnosa_array[3]) or empty($hasil_diagnosa_array[4])) $ret_id = false;
		}else{
			if(empty($datstatus['HASIL_DIAGNOSA'])) $ret_id = false; 
		}
	}
	
	$st_periksa = '"1"';
	if($ret_id == false) $st_periksa = 'NULL';
	mysql_query('UPDATE t_ipenunjang_tarif SET ST_PERIKSA = ' . $st_periksa . ',
						TANGGAL_DIAGNOSA = "' . $tgl . '",
						CATATAN_SPESIMEN = "' . $catatan . '",
						PEGAWAI_PERIKSA_ID = "' . $pmrks . '",
						PEGAWAI_DIAGNOSA_ID = "' . $dktr . '",
						HASIL_TES_KRITIS = "' . $kritis . '",
						USER_DIAGNOSA = "' . $uname . '",
						TANGGAL_PERIKSA = ' . fieldDatetime($jamhasil) . ',
						TANGGAL_SAMPLING = ' . fieldDatetime($jamsample) . ',
						SHIFT_PENUNJANG = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
						NO_TP = "' . $nmr . '",
						NO_PENUNJANG = "' . $nmr . '"
						WHERE PENUNJANG_TARIF_ID = "' . $pti . '"
						AND ST_DIAGNOSA IS NULL') or die(mysql_error()); 
}

$ret = true;
$l = 1;
$pti = array();
$pti_s = '';
if($cnz > 1){
	while($l < $cnz){
		if(isset($_POST['pemeriksaan_id' . $l]) and isset($_POST['report_ch' . $l])){
				
			$penunjang_tarif_id = $_POST['penunjang_tarif_id' . $l];
			
			if(!isset($_POST['diagnosa_a' . $l]) and !isset($_POST['diagnosa_b' . $l]) and !isset($_POST['diagnosa_c' . $l]) 
					and !isset($_POST['diagnosa_d' . $l]) and !isset($_POST['diagnosa_e' . $l])){
				
				if(empty($_POST['diagnosa' . $l]) and ($_POST['diagnosa' . $l] == '')) $ret = false;
				
				if(empty($_POST['pemeriksaan_id' . $l])){

					mysql_query('INSERT INTO t_ipenunjang_tarif_pemeriksaan(PENUNJANG_TARIF_ID,TARIF_PEMERIKSAAN_ID,HASIL_DIAGNOSA,NILAI_RUJUKAN,SATUAN,METHODE)
								VALUES("' . $penunjang_tarif_id . '","' . $_POST['tarif_pemeriksaan_id' . $l] . '","' . $_POST['diagnosa' . $l] . '",
								"' . $_POST['rujukan' . $l] . '","' . $_POST['satuan' . $l] . '","' . $_POST['methode' . $l] . '")') or die(mysql_error());
					
				}else{
					if(cekStatus($penunjang_tarif_id) == false){
						mysql_query('UPDATE t_ipenunjang_tarif_pemeriksaan SET HASIL_DIAGNOSA = "' . $_POST['diagnosa' . $l] . '",
								NILAI_RUJUKAN = "' . $_POST['rujukan' . $l] . '",
								SATUAN = "' . $_POST['satuan' . $l] . '",
								METHODE = "' . $_POST['methode' . $l] . '"
								WHERE PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $_POST['pemeriksaan_id' . $l] . '"') or die(mysql_error());
					}			
				}
				
			}else{
				if(empty($_POST['diagnosa_a' . $l]) or empty($_POST['diagnosa_b' . $l]) or empty($_POST['diagnosa_c' . $l]) 
					or empty($_POST['diagnosa_d' . $l]) or empty($_POST['diagnosa_e' . $l])) $ret = false;
					
					$diagnosa = $_POST['diagnosa_a' . $l] . '|!|' . $_POST['diagnosa_b' . $l] . '|!|' . $_POST['diagnosa_c' . $l] . '|!|' . $_POST['diagnosa_d' . $l] . '|!|' . $_POST['diagnosa_e' . $l];
					if(empty($_POST['pemeriksaan_id' . $l])){
					
						mysql_query('INSERT INTO t_ipenunjang_tarif_pemeriksaan(PENUNJANG_TARIF_ID,TARIF_PEMERIKSAAN_ID,HASIL_DIAGNOSA,NILAI_RUJUKAN,SATUAN,METHODE)
							VALUES("' . $penunjang_tarif_id . '","' . $_POST['tarif_pemeriksaan_id' . $l] . '","' . $diagnosa . '",
							"' . $_POST['rujukan' . $l] . '","' . $_POST['satuan' . $l] . '","' . $_POST['methode' . $l] . '")') or die(mysql_error());
					
					}else{
						if(cekStatus($penunjang_tarif_id) == false){
							mysql_query('UPDATE t_ipenunjang_tarif_pemeriksaan SET HASIL_DIAGNOSA = "' . $diagnosa . '",
								NILAI_RUJUKAN = "' . $_POST['rujukan' . $l] . '",
								SATUAN = "' . $_POST['satuan' . $l] . '",
								METHODE = "' . $_POST['methode' . $l] . '"
								WHERE PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $_POST['pemeriksaan_id' . $l] . '"') or die(mysql_error());
						}
						
					}
			}			
				
			if($pti_s != $penunjang_tarif_id){
				$pti_s = $penunjang_tarif_id;
				$pti[] = $pti_s; 
			}
			
			
			}
	$l++;
	}
}

$r = 0;
while($r < sizeof($pti)){
 updateStatus($pti[$r],$tgl_diagnosa,$catatan_spesimen,$pemeriksa,$dokter,$user_name,$tgl_jam_hasil,$tgl_jam_sampling,$nomor,$hasil_tes_kritis);
$r++;
}

//edoc rekam medic
include('lib/vendor/autoload.php');
//include('lib/vendor/rkorebrits/htmltoopenxml/Archives/Scripts/HTMLtoOpenXML.php');
include('edoc_rekammedik/new/erm_create_laboratorium.php');
erm_laboratorium($idx,$ord,$no,$fr,$_SESSION['SES_SIMRS_NAMA_PEGAWAI']);
//

$err = '';
if($ret == false) $err = $err . 'Isian Hasil Ada Yang Belum Diisi. \n';
//if(empty($catatan_spesimen)) $err = $err . 'Catatan Spesimen Belum Diisi. \n';
if(empty($pemeriksa)) $err = $err . 'Pelaksana Belum Diisi. \n';
if(empty($dokter)) $err = $err . 'Dokter Penanggung Jawab Belum Diisi. \n';

if(!empty($err)){
	?>
	<script language="JavaScript" >
	alert('<?php echo $err; ?>');
	window.location = "<?php echo currentUrl(); ?>";
</script> 
	<?php
}else{	
?>
<script language="JavaScript" >
	alert('Simpan Data Diagnosa Laboratorium Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script> 
<?php } ?>