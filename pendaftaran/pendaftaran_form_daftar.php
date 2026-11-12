<?php
$irja_id = '';
$nomr = '';
$jenis_bayar_id = '';
$pasien = 'umum';
$unit_id_daftar = '';
$unit_id = '';
$jkn_unit_id = '';
$j_tarif = '';
$jns_rawat = '2';
if(isset($_GET['pasien'])){
	$pasien = $_GET['pasien'];
	if($pasien == 'igd'){
		$unit_id_daftar = '9';
		$pasien = 'igd';
	}
	if($pasien == 'kusta'){
		$unit_id_daftar = '35';
		$pasien = 'kusta';
	}	
}
$pegawai_id = '';
$asal_pasien_id = '';
$ket_asal_pasien = '';
$no_peserta = '';
$no_sep = '';
$pasien_kecelakaan = '';
$kd_lokasi_kecelakaan_propinsi = '';
$kd_lokasi_kecelakaan_kota = '';
$kd_lokasi_kecelakaan_kecamatan = '';
$nama_lokasi_kecelakaan_propinsi = '';
$nama_lokasi_kecelakaan_kota = '';
$nama_lokasi_kecelakaan_kecamatan = '';
$tgl_kejadian_kecelakaan = '';
$keterangan_kecelakaan = '';
$kasus_polisi = '';

$p_jawab_nama = '';
$p_jawab_no_telp = '';
$p_jawab_alamat = '';
$p_jawab_alamat_rt = '';
$p_jawab_alamat_rw = '';
$p_jawab_kelurahan_id = '';
$p_jawab_kecamatan_id = '';
$p_jawab_kota_id = '';
$p_jawab_propinsi_id = '';
$p_jawab_hubungan = '';

$jkn_tgl_rujuk = '';
$jkn_no_rujuk = '';
$jkn_kd_pkk = '';
$jkn_nama_pkk = '';
$jkn_catatan = '';
$jkn_diagnosa = '';
$jkn_nama_diagnosa = '';
$jkn_poliklinik = '';
$jkn_kelas_rawat = '';
$jkn_pbi_nonpbi = '';
$jkn_asal_rujukan = '';
$jkn_cob = '';
$jkn_penjamin = '';
$jkn_penjamin_1 = '';
$jkn_penjamin_2 = '';
$jkn_penjamin_3 = '';
$jkn_penjamin_4 = '';
$jkn_katarak = '';
$jkn_suplesi = '';
$jkn_nosep_suplesi = '';
$jkn_nosurat_skdp = '';
$jkn_dpjp_skdp = '';
$jkn_nama_dpjp_skdp = '';
$jkn_spesialis_dpjp_skdp = '';

$tgl_daftar = '';
$jam_triage = '';
$ambil_resep = '';

if (isset($_GET['idx'])) {
    $irja_id = $_GET['idx'];
    $sql_kunjungan = 'SELECT *,
						DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_DAFTAR,
						DATE_FORMAT(t_irja.JAM_TRIAGE,"%d/%m/%Y %H:%i:%s") AS JAM_TRIAGE,
						m_pasien.NO_TELEPON
						FROM t_irja 
						INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
						LEFT JOIN m_icd_x ON (t_irja.JKN_DIAGNOSA = m_icd_x.ICD_CODE)
						WHERE IRJA_ID = "' . $irja_id . '"';
    $get_kunjungan = mysql_query($sql_kunjungan);
    $dat_kunjungan = mysql_fetch_assoc($get_kunjungan);
    
	$unit_id = $dat_kunjungan['UNIT_ID'];
	$pegawai_id = $dat_kunjungan['PEGAWAI_ID']; 
    $jenis_bayar_id = $dat_kunjungan['JENIS_BAYAR_ID'];
	$no_peserta = $dat_kunjungan['NO_PESERTA'];
	$no_sep = $dat_kunjungan['NO_SEP'];
	$asal_pasien_id = $dat_kunjungan['ASAL_PASIEN_ID'];
	$ket_asal_pasien = $dat_kunjungan['KET_ASAL_PASIEN'];
	$pasien_kecelakaan = $dat_kunjungan['KECELAKAAN'];
	$kd_lokasi_kecelakaan_propinsi = $dat_kunjungan['KD_LOKASI_KECELAKAAN_PROPINSI'];
	$kd_lokasi_kecelakaan_kota = $dat_kunjungan['KD_LOKASI_KECELAKAAN_KABUPATEN'];
	$kd_lokasi_kecelakaan_kecamatan = $dat_kunjungan['KD_LOKASI_KECELAKAAN_KECAMATAN'];
	$nama_lokasi_kecelakaan_propinsi = $dat_kunjungan['NAMA_LOKASI_KECELAKAAN_PROPINSI'];
	$nama_lokasi_kecelakaan_kota = $dat_kunjungan['NAMA_LOKASI_KECELAKAAN_KABUPATEN'];
	$nama_lokasi_kecelakaan_kecamatan = $dat_kunjungan['NAMA_LOKASI_KECELAKAAN_KECAMATAN'];
	$tgl_kejadian_kecelakaan = changeDateFormat($dat_kunjungan['TGL_KEJADIAN_KECELAKAAN']);
	$keterangan_kecelakaan = $dat_kunjungan['KETERANGAN_KECELAKAAN'];
	$kasus_polisi = $dat_kunjungan['KASUS_POLISI'];
    
	$p_jawab_nama = $dat_kunjungan['P_JAWAB_NAMA'];
    $p_jawab_no_telp = $dat_kunjungan['P_JAWAB_NO_TELP'];
    $p_jawab_alamat = $dat_kunjungan['P_JAWAB_ALAMAT'];
    $p_jawab_alamat_rt = $dat_kunjungan['P_JAWAB_ALAMAT_RT'];
    $p_jawab_alamat_rw = $dat_kunjungan['P_JAWAB_ALAMAT_RW'];
    $p_jawab_kelurahan_id = $dat_kunjungan['P_JAWAB_KELURAHAN_ID'];
    $p_jawab_kecamatan_id = $dat_kunjungan['P_JAWAB_KECAMATAN_ID'];
    $p_jawab_kota_id = $dat_kunjungan['P_JAWAB_KOTA_ID'];
    $p_jawab_propinsi_id = $dat_kunjungan['P_JAWAB_PROPINSI_ID'];
    $p_jawab_hubungan = $dat_kunjungan['P_JAWAB_HUBUNGAN'];
	
	$nomr = $dat_kunjungan['NOMR'];
	
	$jkn_tgl_rujuk = changeDateFormat($dat_kunjungan['JKN_TGL_RUJUK']);
	$jkn_no_rujuk = $dat_kunjungan['JKN_NO_RUJUK'];
	$jkn_kd_pkk = $dat_kunjungan['JKN_KD_PKK'];
	$jkn_nama_pkk = $dat_kunjungan['JKN_NAMA_PKK'];
	$jkn_catatan = $dat_kunjungan['JKN_CATATAN'];
	$jkn_diagnosa = $dat_kunjungan['JKN_DIAGNOSA'];
	$jkn_nama_diagnosa = $dat_kunjungan['DESKRIPSI'];
	$jkn_poliklinik = $dat_kunjungan['JKN_POLIKLINIK'];
	$jkn_kelas_rawat = $dat_kunjungan['JKN_KELAS_RAWAT'];
	$jkn_pbi_nonpbi = $dat_kunjungan['JKN_PBI_NONPBI'];
	$jkn_asal_rujukan = $dat_kunjungan['JKN_ASAL_RUJUKAN'];
	$jkn_cob = $dat_kunjungan['JKN_COB'];
	$jkn_penjamin = $dat_kunjungan['JKN_PENJAMIN'];
	$jkn_penjamin_r = explode(',',$jkn_penjamin);
	foreach($jkn_penjamin_r as $jp){
		if($jp == '1') $jkn_penjamin_1 = '1';
		if($jp == '2') $jkn_penjamin_2 = '2';
		if($jp == '3') $jkn_penjamin_3 = '3';
		if($jp == '4') $jkn_penjamin_4 = '4';
	}
	
	$jkn_unit_id = $dat_kunjungan['UNIT_ID'];
	$tgl_daftar = $dat_kunjungan['TGL_DAFTAR'];
	$jkn_no_telp = $dat_kunjungan['NO_TELEPON'];
	
	$jkn_katarak = $dat_kunjungan['JKN_KATARAK'];
	$jkn_suplesi = $dat_kunjungan['JKN_SUPLESI'];
	$jkn_nosep_suplesi = $dat_kunjungan['JKN_NO_SEP_SUPLESI'];
	$jkn_nosurat_skdp = $dat_kunjungan['JKN_NOSURAT_SKDP'];
	$jkn_dpjp_skdp = $dat_kunjungan['JKN_DPJP_SKDP'];
	$jkn_nama_dpjp_skdp = $dat_kunjungan['JKN_NAMA_DPJP_SKDP'];
	$jkn_spesialis_dpjp_skdp = $dat_kunjungan['JKN_SPESIALISASI_DPJP_SKDP'];
	
	if(!empty($dat_kunjungan['MCU'])){
		$unit_id = $dat_kunjungan['MCU'];
		$jkn_unit_id = $dat_kunjungan['MCU'];
	}
	
	$jam_triage = $dat_kunjungan['JAM_TRIAGE'];
	$ambil_resep = $dat_kunjungan['AMBIL_RESEP'];
	$ol_daftar_id = $dat_kunjungan['ONLINE_ID'];
}

if(empty($tgl_daftar)){
	$sql_tanggal = 'SELECT DATE_FORMAT(NOW,"%d/%m/%Y") AS TANGGAL FROM DUAL';
	$get_tanggal = mysql_query($sql_tanggal) or die(mysql_error());
	$dat_tanggal = mysql_fetch_assoc($get_tanggal);
	$tgl_daftar = $dat_tanggal['TANGGAL']; 
}

if (isset($_POST['irja_id'])) {
    include('pendaftaran/pendaftaran_save_daftar.php');
}
?>
<div style=" height:auto; padding:15px; ">
<form name="pendaftaranedit" action="<?php echo currentURL(); ?>" method="post" >
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
    
            <div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Medical Record</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo formatNoMr($nomr); ?></div>
            <div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
            <div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
        
            <div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Pembayaran</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<select name="jenis_bayar_id" id="jenis_bayar_id" style="width:228px;" class="text_dt" onchange="javascript : MyAjaxRequest('cnopeserta','index.php?ajaxrequest=cnopeserta&idx=<?php echo $irja_id; ?>&nomr=<?php echo $nomr; ?>&jenis_bayar_id=' + this.value); ubah_formbayar(this.value);return false;">
                    <option value=""> - </option>
                    <?php echo getJnsBayar($jenis_bayar_id,'1'); ?>
                </select>
			</div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left">
			<div id="cnopeserta" ><input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $no_peserta; ?>" size="34" /></div>
			</div>
            <div style=" width:20px; float:right; ">:</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Peserta</div><br><br>
			
			<div id="form_bayar1">
			<?php include('pendaftaran/pendaftaran_form_nonjkn.php'); ?>	
			</div>	

			<div id="form_bayar2">
			<?php include('pendaftaran/pendaftaran_form_jkn.php'); ?>	
			</div>
			
			<!-- pasien ambil resep -->
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Hanya Ambil Resep</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="checkbox" name="ambil_resep" id="ambil_resep" value="1" <?php if($ambil_resep == '1') echo 'checked="checked"'; ?> />&nbsp;Ya</div>
            <div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
            <div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;
			<?php 
				$tgl_trg = date('d/m/Y');
				$jm_trg = date('H');
				$mt_trg = date('i');
				$arr_trg = explode(' ',$jam_triage);
				if(sizeof($arr_trg) == 2){
					$tgl_trg = $arr_trg[0];
					$arr_jm = explode(':',$arr_trg[1]);
					$jm_trg = $arr_jm[0];
					$mt_trg = $arr_jm[1]; 
				} ?>
				<input type="hidden" name="tgl_triage" id="tgl_triage" value="<?php echo $tgl_trg; ?>"/>
				<input type="hidden" name="jm_trg" id="jm_trg" value="<?php echo $jm_trg; ?>"/>
				<input type="hidden" name="mt_trg" id="mt_trg" value="<?php echo $mt_trg; ?>"/>
			</div><br><br>
			<!-- end pasien ambil resep -->
			
		</div>	
        <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
        <?php include('pendaftaran/pendaftaran_edit_daftar.php'); ?>
		</div>
        <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;" align="right">
			<div style=" width:200px; float:left; text-indent:25px;" align="left">&nbsp;</div>
			<div style=" width:60px; float:left;">&nbsp;&nbsp;&nbsp;</div>
			<div style=" width:250px; float:left; text-indent:15px; " align="left">
			<input type="hidden" name="j_tarif" value="" />
			<!--
			<select name="j_tarif" class="text_dt" style="width:228px;" >
			<option value="" > - </option>	
			<option value="1" <?php if($j_tarif == '1') echo 'selected="selected"'; ?> >Hanya bayar Karcis</option>	
			<option value="2" <?php if($j_tarif == '2') echo 'selected="selected"'; ?> >Hanya bayar Konsultasi Dokter</option>	
			</select>-->
			
			</div>
			<?php if($pasien == 'igd'){ ?>
			<a href="index.php?link=<?php echo md5('pendaftaranformpasienigd'); ?>&pasien=igd&idx=<?php echo $irja_id; ?>" ><input type="button" value="<< kembali" class="myButton1" /></a>
            <?php } else if($pasien == 'kusta'){ ?>
			<a href="index.php?link=<?php echo md5('pendaftaranformpasienkusta'); ?>&pasien=kusta&idx=<?php echo $irja_id; ?>" ><input type="button" value="<< kembali" class="myButton1" /></a>
			<?php } else if($pasien == 'umum'){ ?>
			<a href="index.php?link=<?php echo md5('pendaftaranformpasienpoliklinik'); ?>&pasien=umum&idx=<?php echo $irja_id; ?>" ><input type="button" value="<< kembali" class="myButton1" /></a>
			<?php } else if($pasien == 'mcu'){ ?>
			<a href="index.php?link=<?php echo md5('pendaftaranformpasienmcu'); ?>&pasien=mcu&idx=<?php echo $irja_id; ?>" ><input type="button" value="<< kembali" class="myButton1" /></a>
			<?php } ?>
			<input type="submit" value="simpan" class="myButton1" />
        
	</div>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
	<input type="hidden" name="pasien" id="pasien" value="<?php echo $pasien; ?>" />
	<input type="hidden" name="jkn_jns_rawat" id="jkn_jns_rawat" value="2" />
	<input type="hidden" name="jkn_no_telp" id="jkn_no_telp" value="<?php echo $jkn_no_telp; ?>" />
	<input type="hidden" name="tgl_daftar" id="tgl_daftar" value="<?php echo $tgl_daftar; ?>" />
	<input type="hidden" name="ol_daftar_id" id="ol_daftar_id" value="<?php echo $ol_daftar_id; ?>" />
</form>
</div>
</div>
<script type="text/javascript">
document.getElementById("jenis_bayar_id").focus();
ubah_formbayar(<?php echo $jenis_bayar_id; ?>);

function ubah_formbayar(jns_bayar){
	if(jns_bayar == 12){
		document.getElementById("form_bayar2").style.display = 'block';
		document.getElementById("form_bayar1").style.display = 'none';
	}else{
		document.getElementById("form_bayar2").style.display = 'none';
		document.getElementById("form_bayar1").style.display = 'block';
	}
}
</script>