<?php
$no_penunjang = '';
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
$telp_instansi_pengirim = '';
$instansi_pengirim = '';
$alamat_instansi_pengirim = '';
$tgl_permintaan = '';
$diagnosa = '';
$unit_id = '';

$st_baru = '';
$jenis_bayar_id = '1';

if(isset($_GET['no_pnj']) and !empty($_GET['no_pnj'])){
	$no_penunjang = $_GET['no_pnj']; 
	if(strlen($no_penunjang) == 6){
		$sql_pasien = 'SELECT * FROM m_pasien WHERE NOMR = "' . $no_penunjang . '"';
	}else{
		$sql_pasien = 'SELECT * FROM t_ipenunjang WHERE NO_PASIEN_PENUNJANG = "' . $no_penunjang . '" ORDER BY PENUNJANG_ID DESC LIMIT 1';
	}	
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
	
	if($tgl_lahir == '30/11/-0001') $tgl_lahir = '';
}

if(isset($_GET['no_pnj']) and empty($_GET['no_pnj'])) $st_baru = '1';

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
	$telp_instansi_pengirim = $dat_pasien['NO_TELP_INSTANSI_PENGIRIM'];
	$instansi_pengirim = $dat_pasien['INSTANSI_PENGIRIM'];
	$alamat_instansi_pengirim = $dat_pasien['ALAMAT_INSTANSI_PENGIRIM'];
	$tgl_permintaan = $dat_pasien['TANGGAL_PERMINTAAN'];
	$diagnosa = $dat_pasien['DIAGNOSA_PENGIRIM'];
	$unit_id = $dat_pasien['UNIT_ID'];
	
	$no_penunjang  = $dat_pasien['NO_PASIEN_PENUNJANG'];
	if($tgl_lahir == '30/11/-0001') $tgl_lahir = '';
}

if (isset($_POST['penunjang_id'])) {
    include('pendaftaran/pendaftaran_save_penunjang_aps_pasien.php');
}
?>
<div style=" height:auto; padding:15px; ">	
<form name="pendaftaranedit" action="<?php echo currentURL(); ?>" method="post" >
	<div class="div_menu" style=" height:auto; width:auto; padding:15px;  border:1px solid #999; border-radius:5px; margin:5px; ">
		<?php 
		$aps = '1';
		include('pasien/pasien_edit.php'); ?>
		<br />
		<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:20px; float:left; ">&nbsp;</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:20px; float:right; ">&nbsp;</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br>
		<br />
		<div style=" width:250px; float:left; text-indent:5px; " align="left">Jenis Pembayaran</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<select name="jenis_bayar_id" id="jenis_bayar_id" style="width:228px;" class="text_dt">
			<?php $arr_jenis_bayar = getArrJnsBayar(); 
				foreach($arr_jenis_bayar as $row){
					//if(in_array($row['id'],getArrNonJaminan())){
						echo '<option value="' . $row['id'] . '" ' . (($row['id'] == '1') ? 'selected':'') .  ' >' . $row['nama'] . '</option>';
					//}	
				}	
			?>
			</select>
		</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:20px; float:right; ">&nbsp;</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<br /><br />
		<div style=" width:250px; float:left; text-indent:5px; " align="left">Penunjang Tujuan</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<select name="unit_id" id="unit_id" style="width:228px;" class="text_dt">
			<option value=""> - </option>
			<?php echo getUnit('pnj',$unit_id); ?>
		</select>
		</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:20px; float:right; ">&nbsp;</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<br /><br />
		
		<div style=" width:250px; float:left; text-indent:5px; " align="left">Instansi Pengirim</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="text" name="instansi_pengirim" id="instansi_pengirim" class="text_dt" value="<?php echo $instansi_pengirim; ?>" size="50" />
		</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left"><input type="text" name="dokter_pengirim" id="dokter_pengirim" class="text_dt" value="<?php echo $dokter_pengirim; ?>" size="35" /></div>
		<div style=" width:20px; float:right; ">:</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">Dokter Pengirim</div>
		<br /><br />
		<div style=" width:250px; float:left; text-indent:5px; " align="left">Alamat Instansi</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="text" name="alamat_instansi_pengirim" id="alamat_instansi_pengirim" class="text_dt" value="<?php echo $alamat_instansi_pengirim; ?>" size="50" />
		</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:20px; float:right; ">&nbsp;</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<br /><br />
		<div style=" width:250px; float:left; text-indent:5px; " align="left">Nomor Telepon</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<input type="text" name="telp_instansi_pengirim" id="telp_instansi_pengirim" class="text_dt" value="<?php echo $telp_instansi_pengirim; ?>" size="35" />
		</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left"><input type="text" name="tgl_permintaan" id="tgl_minta" value="<?php echo $tgl_permintaan; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar10')"/></div>
		<div style=" width:20px; float:right; ">:</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">Tanggal Permintaan</div>
		<br><br>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">Diagnosa</div>
		<div style=" width:20px; float:left; ">:</div>
		<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<textarea name="diagnosa" id="diagnosa" class="text_dt3" ><?php echo $diagnosa; ?></textarea>
		</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
		<div style=" width:20px; float:right; ">&nbsp;</div>
		<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div><br><br><br><br><br><br>
	</div>
    <div class="div_menu" style=" height:auto; padding:15px; border:1px solid #999; border-radius:5px; margin:5px;" align="right">
			<a href="index.php?link=<?php echo md5('pendaftaransearchpasienaps'); ?>" ><input type="button" value="batal" class="myButton" /></a>
			<input type="submit" value="simpan >>" class="myButton1" />
    </div>	
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="penunjang_id" id="penunjang_id" value="<?php echo $penunjang_id; ?>" />
	<input type="hidden" name="st_baru" id="st_baru" value="<?php echo $st_baru; ?>" />
</form>
</div>
<script type="text/javascript">
document.getElementById("nama_pasien").focus();
</script>