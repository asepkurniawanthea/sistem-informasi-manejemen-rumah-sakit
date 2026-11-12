<?php
$nomr = '';
$nama_pasien = '';
$tmp_lahir = '';
$tgl_lahir = '';
$jns_kelamin = '';
$st_kawin = '';
$agama_id = '';
$pendidikan_id = '';
$pekerjaan = '';
$alamat = '';
$alamat_rt = '';
$alamat_rw = '';
$kelurahan_id = '';
$kecamatan_id = '';
$kota_id = '';
$propinsi_id = '';
$kode_pos = '';
$no_telepon = '';
$nama_ibu = '';
$nama_ayah = '';
$nama_suami_isteri = '';
$nik = '';
$khusus = '';
$irja_id = '';
$st_baru = '';

$no_peserta = '';
$jkn_kd_pkk = '';
$jkn_nama_pkk = '';
$jkn_pbi_nonpbi = '';
$jkn_kls_rawat = '';
$pasien_jkn = '0';

if (isset($_GET['nomr'])) $nomr = $_GET['nomr'];

if(isset($_GET['ol']) or (isset($_SESSION['mqm_trans_id']) and $_SESSION['mqm_trans_id'] != '')){
	$connect_4 = mysql_connect($hostname_4, $username_4, $password_4) or die(mysql_error());
	mysql_select_db($database_4, $connect_4) or die(mysql_error());
	
	if(isset($_GET['ol'])) $ol_daftar_id = $_GET['ol']; 
	if(isset($_SESSION['mqm_trans_id']) and $_SESSION['mqm_trans_id'] != '') $ol_daftar_id = $_SESSION['mqm_trans_id']; 
	$sql_ol = 'SELECT ol.NOMR,ol.NAMA_PASIEN,ol.TMP_LAHIR,
			DATE_FORMAT(ol.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,AGAMA,
			ol.JNS_KELAMIN,ol.NAMA_IBU,ol.ALAMAT,ol.KLINIK_ID,ol.MCU_ID,ol.DOKTER_ID,
			ol.CARA_BAYAR,ol.NO_CONTACT,ol.NO_BPJS,ol.NIK
			FROM t_trans tr 
			LEFT JOIN t_daftar_irja_online ol
			ON (tr.DAFTAR_ID = ol.DAFTAR_ID)
			WHERE tr.TRANS_ID = "' . $ol_daftar_id . '"';
	$get_ol = mysql_query($sql_ol) or die(mysql_error());
	$dat_ol = mysql_fetch_assoc($get_ol);
	if(isset($_GET['baru'])){
		$nama_pasien = $dat_ol['NAMA_PASIEN'];
		$tmp_lahir = $dat_ol['TMP_LAHIR'];
		$tgl_lahir = $dat_ol['TGL_LAHIR'];
		$jns_kelamin = $dat_ol['JNS_KELAMIN'];
		$agama_id = $dat_ol['AGAMA'];
		$alamat = $dat_ol['ALAMAT'];
		$no_telepon = $dat_ol['NO_CONTACT'];
		$nama_ibu = $dat_ol['NAMA_IBU'];
		$nik = $dat_ol['NIK'];
		$no_peserta = $dat_ol['NO_BPJS'];
	}else{
		
		$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
		mysql_select_db($database, $connect) or die(mysql_error());
	
		$no_peserta = $dat_ol['NO_CONTACT'];
		mysql_query('UPDATE m_pasien SET NO_TELEPON = "' . $dat_ol['NO_CONTACT'] . '"
			WHERE NOMR = "' . $nomr . '"') or die(mysql_error());
	}

	$ol_unit_id = $dat_ol['KLINIK_ID'];	
	$ol_pegawai_id = $dat_ol['DOKTER_ID'];
	$ol_mcu_id = $dat_ol['MCU_ID'];	
	$ol_jenis_bayar_id = $dat_ol['CARA_BAYAR'];	
	
	$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
	mysql_select_db($database, $connect) or die(mysql_error());
}	

if (isset($_GET['idx'])) {
    $irja_id = $_GET['idx'];
	$sql_daftar = 'SELECT * FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
	$get_daftar = mysql_query($sql_daftar) or die(mysql_error());
	$dat_daftar = mysql_fetch_assoc($get_daftar);
	$nomr = $dat_daftar['NOMR'];

	$jenis_bayar_id = $dat_daftar['JENIS_BAYAR_ID'];
	if($jenis_bayar_id == 12){
		$no_peserta = $dat_daftar['NO_PESERTA'];
		$jkn_kd_pkk = $dat_daftar['JKN_KD_PKK'];
		$jkn_nama_pkk = $dat_daftar['JKN_NAMA_PKK'];
		$jkn_pbi_nonpbi = $dat_daftar['JKN_PBI_NONPBI'];
		$jkn_kls_rawat = $dat_daftar['JKN_KELAS_RAWAT'];
		$pasien_jkn = '1';	
	}	
}

if (!empty($nomr)) {
    $sql_pasien = 'SELECT * FROM m_pasien WHERE NOMR = "' . $nomr . '"';
    $get_pasien = mysql_query($sql_pasien);
    $dat_pasien = mysql_fetch_assoc($get_pasien);

    $nama_pasien = $dat_pasien['NAMA_PASIEN'];
    $tmp_lahir = $dat_pasien['TMP_LAHIR'];
    $tgl_lahir = changeDateFormat($dat_pasien['TGL_LAHIR']);
    $jns_kelamin = $dat_pasien['JNS_KELAMIN'];
    $st_kawin = $dat_pasien['ST_KAWIN'];
    $agama_id = $dat_pasien['AGAMA_ID'];
    $pendidikan_id = $dat_pasien['PENDIDIKAN_ID'];
    $pekerjaan = $dat_pasien['PEKERJAAN'];
    $alamat = $dat_pasien['ALAMAT'];
    $alamat_rt = $dat_pasien['ALAMAT_RT'];
    $alamat_rw = $dat_pasien['ALAMAT_RW'];
    $kelurahan_id = $dat_pasien['KELURAHAN_ID'];
    $kecamatan_id = $dat_pasien['KECAMATAN_ID'];
    $kota_id = $dat_pasien['KOTA_ID'];
    $propinsi_id = $dat_pasien['PROPINSI_ID'];
    $kode_pos = $dat_pasien['KODE_POS'];
    $no_telepon = $dat_pasien['NO_TELEPON'];
    $nama_ibu = $dat_pasien['NAMA_IBU'];
    $nama_ayah = $dat_pasien['NAMA_AYAH'];
    $nama_suami_isteri = $dat_pasien['NAMA_SUAMI_ISTERI'];
    $nik = $dat_pasien['NIK'];
    $khusus = $dat_pasien['KHUSUS'];
	
	if($tgl_lahir == '30/11/-0001') $tgl_lahir = '';
}

if (isset($_POST['nomr'])) {
    include('pendaftaran/pendaftaran_save_pasien.php');
}

if (isset($_GET['pasien'])) {
	$pasien = $_GET['pasien'];
    if ($pasien == 'kusta') {
        $khusus = '1';
    } else {
        $khusus = '0';
    }
}

if (isset($_GET['baru'])) {
    $st_baru = '1';
}
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#pekerjaan").autocomplete("index.php?autocomp=autocomppendaftaranpekerjaan",{width: 207});
    });
	jQuery(document).ready(function() {
        jQuery("#tmp_lahir").autocomplete("index.php?autocomp=autocomppendaftarantmplahir",{width: 207});
    });
</script>
<div style=" height:auto; padding:15px; ">	
<form name="pendaftaranedit" id="pendaftaran" action="<?php echo currentURL(); ?>" method="post" >
	<div class="div_menu" style=" height:auto; width:auto; padding:15px;  border:1px solid #999; border-radius:5px; margin:5px; ">
		<?php include('pasien/pasien_edit.php'); ?>
	</div>
    <div class="div_menu" style=" height:auto; padding:15px; border:1px solid #999; border-radius:5px; margin:5px;" align="right">
			<?php if($pasien == 'igd'){ ?>
			<a href="index.php?link=<?php echo md5('pendaftaranbaruigd'); ?>&pasien=igd" ><input type="button" value="batal" class="myButton" /></a>
            <?php } else if($pasien == 'kusta'){ ?>
			<a href="index.php?link=<?php echo md5('pendaftaranbarukusta'); ?>&pasien=kusta" ><input type="button" value="batal" class="myButton" /></a>
			<?php } else if($pasien == 'umum'){ ?>
			<a href="index.php?link=<?php echo md5('pendaftaranbarupoliklinik'); ?>&pasien=umum" ><input type="button" value="batal" class="myButton" /></a>
			<?php } else if($pasien == 'mcu'){ ?>
			<a href="index.php?link=<?php echo md5('pendaftaranbarumcu'); ?>&pasien=mcu" ><input type="button" value="batal" class="myButton" /></a>
			<?php } ?>
			<input type="submit"  value="simpan >>" class="myButton1" /><!-- onclick="javascript : cekSimpan(); return false;" -->
    </div>	
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
    <input type="hidden" name="st_baru" id="st_baru" value="<?php echo $st_baru; ?>" />
	<input type="hidden" name="pasien" id="pasien" value="<?php echo $pasien; ?>" />
	<?php if(isset($ol_daftar_id)){ ?>
		<input type="hidden" name="ol_unit_id" id="ol_unit_id" value="<?php echo $ol_unit_id; ?>" />
		<input type="hidden" name="ol_pegawai_id" id="ol_pegawai_id" value="<?php echo $ol_pegawai_id; ?>" />
		<input type="hidden" name="ol_mcu_id" id="ol_mcu_id" value="<?php echo $ol_mcu_id; ?>" />
		<input type="hidden" name="ol_jenis_bayar_id" id="ol_jenis_bayar_id" value="<?php echo $ol_jenis_bayar_id; ?>" />
		<input type="hidden" name="ol_daftar_id" id="ol_daftar_id" value="<?php echo $ol_daftar_id; ?>" />
	<?php } ?>
</form>
</div>
<script type="text/javascript">
document.getElementById("nama_pasien").focus();

/*function cekSimpan(){
	msg = '';
	if(document.getElementById("nama_pasien").value == ''){
			msg = msg + 'Nama Pasien Harus Diisi. \n';
	}
	if(document.getElementById("tmp_lahir").value == ''){
			msg = msg + 'Tempat Lahir Harus Diisi. \n';
	}
	if(document.getElementById("tgl_lahir").value == ''){
			msg = msg + 'Tanggal Lahir Harus Diisi. \n';
	}
	if(document.getElementById("jns_kelamin").checked == false){
			msg = msg + 'Jenis Kelamin Belum Dipilih. \n';
	}
	if(document.getElementById("agama_id").value == ''){
			msg = msg + 'Agama Belum Dipilih. \n';
	}
	if(document.getElementById("nama_ibu").value == ''){
			msg = msg + 'Nama Ibu Kandung Harus Diisi. \n';
	}
	if(msg != ''){
		alert(msg);
	}else{
		document.getElementById("pendaftaran").submit();
	}
} */
</script>