<?php
$jns_rawat = '2';
$pasien = 'mcu';
$irja_id = '';
$nomr = '';
$jenis_bayar_id = '';

$unit_id = '';
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

$keterangan_batal = '';
$st_rujukan = '';
$pasien_masuk = '';

$jkn_tgl_rujuk = '';
$jkn_no_rujuk = '';
$jkn_kd_pkk = '';
$jkn_nama_pkk = '';
$jkn_catatan = '';
$jkn_diagnosa = '';
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

$nama_pasien = '';
$tgl_lahir = '';
$jns_kelamin = '';
$tgl_daftar = '';

$no_pendaftaran = '';
$ambil_resep = '';

$tgl_trans = '';

if (isset($_GET['idx'])) {
    $irja_id = $_GET['idx'];
    $sql_kunjungan = 'SELECT t_irja.*,m_pasien.*,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
					DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_DAFTAR,m_icd_x.DESKRIPSI,
					DATE_FORMAT(t_irja.TGL_TRANS,"%d/%m/%Y %H:%i:%s") AS TGL_TRANS
					FROM t_irja 
					INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
					LEFT JOIN m_icd_x ON (t_irja.JKN_DIAGNOSA = m_icd_x.ICD_CODE)
					WHERE IRJA_ID = "' . $irja_id . '"';
    $get_kunjungan = mysql_query($sql_kunjungan);
    $dat_kunjungan = mysql_fetch_assoc($get_kunjungan);
    
	$unit_id = $dat_kunjungan['UNIT_ID'];
	if(!empty($dat_kunjungan['MCU'])) $unit_id = $dat_kunjungan['MCU'];
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
	$st_rujukan = $dat_kunjungan['ST_RUJUKAN'];
	$pasien_masuk = $dat_kunjungan['PASIEN_MASUK'];
	$no_sjp = $dat_kunjungan['NO_SJP'];
	
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
	if(!empty($dat_kunjungan['MCU'])) $jkn_unit_id = $dat_kunjungan['MCU'];
	$tgl_daftar = $dat_kunjungan['TGL_DAFTAR'];
	$jkn_no_telp = $dat_kunjungan['NO_TELEPON'];
	
	$nama_pasien = $dat_kunjungan['NAMA_PASIEN'];
	$tgl_lahir = $dat_kunjungan['TGL_LAHIR'];
	$jns_kelamin = $dat_kunjungan['JNS_KELAMIN'];
	$tgl_daftar = $dat_kunjungan['TGL_DAFTAR'];
	
	$jkn_katarak = $dat_kunjungan['JKN_KATARAK'];
	$jkn_suplesi = $dat_kunjungan['JKN_SUPLESI'];
	$jkn_nosep_suplesi = $dat_kunjungan['JKN_NO_SEP_SUPLESI'];
	$jkn_nosurat_skdp = $dat_kunjungan['JKN_NOSURAT_SKDP'];
	$jkn_dpjp_skdp = $dat_kunjungan['JKN_DPJP_SKDP'];
	$jkn_nama_dpjp_skdp = $dat_kunjungan['JKN_NAMA_DPJP_SKDP'];
	$jkn_spesialis_dpjp_skdp = $dat_kunjungan['JKN_SPESIALISASI_DPJP_SKDP'];
	
	$no_pendaftaran = $dat_kunjungan['NO_PENDAFTARAN'];
	$ambil_resep = $dat_kunjungan['AMBIL_RESEP'];
	
	$tgl_trans = $dat_kunjungan['TGL_TRANS'];
}

if (isset($_POST['irja_id'])) {
    include('pendaftaran/pendaftaran_save_edit_daftar_mcu.php');
}
?>
<div style=" height:auto; padding:15px;">
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
				<select name="jenis_bayar_id" id="jenis_bayar_id" style="width:228px;" class="text_dt" onchange="javascript : MyAjaxRequest('cnopeserta','index.php?ajaxrequest=cnopesertaedit&idx=<?php echo $irja_id; ?>&nomr=<?php echo $nomr; ?>&jenis_bayar_id=' + this.value); ubah_formbayar(this.value);ubah_isian_sep(this.value,<?php echo $jenis_bayar_id; ?>,<?php echo $irja_id; ?>);return false;">
                    <option value=""> - </option>
                    <?php echo getJnsBayar($jenis_bayar_id,'1'); ?>
                </select>
			</div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left">
			<div id="cnopeserta" >
			<?php if($jenis_bayar_id == '12'){ ?>
			<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $no_peserta; ?>" size="34" />
			<button type="button" onClick="getPeserta(1, 2)" class="myButton1">cari kartu</button>
			<button type="button" onClick="getPeserta(2, 2)" class="myButton1">cari ktp</button>
			<button type="button" onClick="showPeserta()" class="myButton1" id="pesertaDetail" style="display:none">detail</button>
			<?php }else{ ?>
			<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $no_peserta; ?>" size="34" />
			<?php } ?>
			</div></div>
            <div style=" width:20px; float:right; ">:</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Peserta</div><br><br>
			
			<div id="form_bayar1">
			<?php include('pendaftaran/pendaftaran_form_nonjkn.php'); ?>
			</div>	

		<div id="form_bayar2">
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Nama Pasien</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input type="text" name="jkn_nama_pasien" id="nama_pasien" value="<?php echo $nama_pasien; ?>" size="34" class="text_dt" readonly="readonly" /></div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
				<div style=" width:20px; float:right; ">&nbsp;</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br> 
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Lahir</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input type="text" name="jkn_tgl_lahir" id="tgl_lahir" value="<?php echo $tgl_lahir; ?>" size="15" class="text_dt" readonly="readonly" /></div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input type="radio" name="jns_kelamin" id="jns_kelamin" value="L" <?php if($jns_kelamin == 'L') echo 'checked="checked"'; ?>/>
				&nbsp;Laki-laki&nbsp;&nbsp;
				<input type="radio" name="jns_kelamin" id="jns_kelamin" value="P" <?php if($jns_kelamin == 'P') echo 'checked="checked"'; ?> />
				&nbsp;Perempuan</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Jenis Kelamin</div><br><br>
				<?php include('pendaftaran/pendaftaran_form_jkn.php'); ?>
		</div>   

		<!-- pasien ambil resep -->
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Hanya Ambil Resep</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left"><input type="checkbox" name="ambil_resep" id="ambil_resep" value="1" <?php if($ambil_resep == '1') echo 'checked="checked"'; ?> />&nbsp;Ya</div>
            <div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
            <div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
			<!-- end pasien ambil resep -->	
</div>   
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">	
        <?php include('pendaftaran/pendaftaran_edit_daftar.php'); ?>
</div>   
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">	      		
		<input type="radio" name="st_edit" value="3" checked="checked">&nbsp;Cetak Ulang Karcis/SJP/SEP&nbsp;
		<input type="radio" name="st_edit" value="1">&nbsp;Perubahan Hanya Nomor Peserta dan SEP/Penanggung Jawab<?php if($_SESSION['SES_SIMRS_ADMIN'] == '1'){ ?>&nbsp;&nbsp;<input type="radio" name="st_edit" value="2">&nbsp;Semua Diubah
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Batal&nbsp;<input type="checkbox" name="st_batal" value="1" <?php if(isset($_POST['st_batal'])) echo 'checked="checked"'; ?> >&nbsp;&nbsp;&nbsp;Keterangan
            &nbsp;<input type="text" name="keterangan_batal" size="40" class="text_dt" />
		<?php } ?> 
</div>    

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px;  " align="right">
<a href="index.php?link=<?php echo md5('pendaftaranlistkunjungan'); ?>" >
<input type="button" value="tutup" class="myButton" /></a>
<?php
	if($jenis_bayar_id == 12) {
		echo('<button type="submit" onClick="deleteSEP(\'' . $no_sep . '\')" class="myButton1" />simpan</button>');
	} else {
		echo('<input type="submit" value="simpan" class="myButton1" />');
	}
?>
<input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
<input type="hidden" name="st_rujukan" id="st_rujukan" value="<?php echo $st_rujukan; ?>" />
<input type="hidden" name="no_sjp" id="no_sjp" value="<?php echo $no_sjp; ?>" />
<input type="hidden" name="no_pendaftaran" id="no_sjp" value="<?php echo $no_pendaftaran; ?>" />
<input type="hidden" name="tgl_daftar" id="tgl_daftar" value="<?php echo $tgl_daftar; ?>" />
<input type="hidden" name="jkn_jns_rawat" id="jkn_jns_rawat" value="2" />
<input type="hidden" name="jkn_no_telp" id="jkn_no_telp" value="<?php echo $jkn_no_telp; ?>" />
<input type="hidden" name="ls_unit_id" id="ls_unit_id" value="<?php echo $unit_id; ?>" />
</div>
</form>
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

function ubah_isian_sep(jns,jns_a,idx){
	if(jns == 12){
		MyAjaxRequest('div_jkn_no_sep','index.php?ajaxrequest=tampilnosep&opt=1&jns=' + jns + '&jns_a=' + jns_a + '&idx=' + idx);
	}else{
		MyAjaxRequest('div_no_sep','index.php?ajaxrequest=tampilnosep&opt=2&jns=' + jns + '&jns_a=' + jns_a + '&idx=' + idx);
	}
}
</script>