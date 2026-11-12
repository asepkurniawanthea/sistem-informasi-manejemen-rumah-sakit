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
if (isset($_GET['nomr'])) $nomr = $_GET['nomr'];
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
}

if (isset($_POST['nomr'])) {
    include('pendaftaran/pendaftaran_save_edit_pasien.php');
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
<form name="pendaftaranedit" action="<?php echo currentURL(); ?>" method="post" >
	<div style=" height:auto; padding:15px; ">
		<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD; ">    
        <?php include('pasien/pasien_edit.php'); ?>
        </div>
		
		<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD; " align="right">
			<a href="index.php?link=<?php echo md5('pendaftarandatapasien'); ?>" ><input type="button" value="batal" class="myButton" /></a>
			<input type="submit" value="simpan" class="myButton1" />
            </div></div>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
	</div>
</form>