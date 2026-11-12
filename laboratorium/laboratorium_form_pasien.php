<?php
$penunjang_id = '';
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

$dokter_pengirim = '';
$instansi_pengirim = '';

if (isset($_GET['idx'])) {
    $penunjang_id = $_GET['idx'];
	
    $sql_pasien = 'SELECT * FROM t_ipenunjang WHERE PENUNJANG_ID = "' . $penunjang_id . '"';
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
	
	$dokter_pengirim = $dat_pasien['PENGIRIM'];
	$instansi_pengirim = $dat_pasien['INSTANSI_PENGIRIM'];
	
	if($tgl_lahir == '30/11/-0001') $tgl_lahir = '';
}

if (isset($_POST['penunjang_id'])) {
    include('laboratorium/laboratorium_save_pasien.php');
}
?>
<div style=" height:auto; padding:15px; ">	
<form name="pendaftaranedit" action="<?php echo currentURL(); ?>" method="post" >
	<div class="div_menu" style=" height:auto; width:auto; padding:15px;  border:1px solid #999; border-radius:5px; margin:5px; ">
		<?php include('pasien/pasien_edit.php'); ?>
		<br />
		<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:20px; float:left; ">&nbsp;</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:20px; float:right; ">&nbsp;</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br>
		<br />
		<div style=" width:250px; float:left; text-indent:5px; " align="left">Instansi Pengirim</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="text" name="instansi_pengirim" id="instansi_pengirim" class="text_dt" value="<?php echo $instansi_pengirim; ?>" size="50" />
		</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left"><input type="text" name="dokter_pengirim" id="dokter_pengirim" class="text_dt" value="<?php echo $dokter_pengirim; ?>" size="35" /></div>
		<div style=" width:20px; float:right; ">:</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">Dokter Pengirim</div><br><br>
	</div>
    <div class="div_menu" style=" height:auto; padding:15px; border:1px solid #999; border-radius:5px; margin:5px;" align="right">
			<a href="index.php?link=<?php echo md5('kasirpembayaranlaboratorium'); ?>" ><input type="button" value="batal" class="myButton" /></a>
			<input type="submit" value="simpan >>" class="myButton1" />
    </div>	
     <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="penunjang_id" id="penunjang_id" value="<?php echo $penunjang_id; ?>" />
</form>
</div>
<script type="text/javascript">
document.getElementById("nama_pasien").focus();
</script>