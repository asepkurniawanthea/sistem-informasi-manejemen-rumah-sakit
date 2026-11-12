<?php
$jns_rawat = '1';
$pasien = 'rawatinap';

$irna_id = '';
$nomr = '';
$jenis_bayar_id = '';
$ruang_id = '';
$tmp_tidur = '';
$pegawai_id = '';
$no_peserta = '';
$no_sep = '';
$diagnosa_awal = '';

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
$pasien_masuk = '';

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
$jkn_no_telp = '';

$nama_pasien = '';
$tgl_lahir = '';
$jns_kelamin = '';

$tgl_daftar = '';
$kelas_jaminan = '';
$kelas_rawat = '';

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
$unit_id = '';

if (isset($_GET['idx'])) {
    $irna_id = $_GET['idx'];
    $sql_rawat = 'SELECT t_irna.*,m_pasien.*,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_DAFTAR_IRJA,m_icd_x.DESKRIPSI
				FROM t_irna 
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
				LEFT JOIN m_icd_x ON (t_irna.JKN_DIAGNOSA = m_icd_x.ICD_CODE)
				WHERE t_irna.IRNA_ID = "' . $irna_id . '"';
    $get_rawat = mysql_query($sql_rawat);
    $dat_rawat = mysql_fetch_assoc($get_rawat);
    
	$ruang_id = $dat_rawat['RUANG_ID'];
	$pegawai_id = $dat_rawat['PEGAWAI_ID']; 
    $jenis_bayar_id = $dat_rawat['JENIS_BAYAR_ID'];
	$no_peserta = $dat_rawat['NO_PESERTA'];
	$no_sep = $dat_rawat['NO_SEP'];
	$tmp_tidur = $dat_rawat['NO_TMP_TIDUR'];
	$diagnosa_awal = $dat_rawat['DIAGNOSA_AWAL'];
    
	$p_jawab_nama = $dat_rawat['P_JAWAB_NAMA'];
    $p_jawab_no_telp = $dat_rawat['P_JAWAB_NO_TELP'];
    $p_jawab_alamat = $dat_rawat['P_JAWAB_ALAMAT'];
    $p_jawab_alamat_rt = $dat_rawat['P_JAWAB_ALAMAT_RT'];
    $p_jawab_alamat_rw = $dat_rawat['P_JAWAB_ALAMAT_RW'];
    $p_jawab_kelurahan_id = $dat_rawat['P_JAWAB_KELURAHAN_ID'];
    $p_jawab_kecamatan_id = $dat_rawat['P_JAWAB_KECAMATAN_ID'];
    $p_jawab_kota_id = $dat_rawat['P_JAWAB_KOTA_ID'];
    $p_jawab_propinsi_id = $dat_rawat['P_JAWAB_PROPINSI_ID'];
    $p_jawab_hubungan = $dat_rawat['P_JAWAB_HUBUNGAN'];
	
	$nomr = $dat_rawat['NOMR'];
	$pasien_masuk = $dat_rawat['PASIEN_MASUK'];
	$no_sjp = $dat_rawat['NO_SJP'];
	$tgl_masuk = $dat_rawat['TANGGAL_DAFTAR'];
	
	$jkn_tgl_rujuk = changeDateFormat($dat_rawat['JKN_TGL_RUJUK']);
	$jkn_no_rujuk = $dat_rawat['JKN_NO_RUJUK'];
	$jkn_kd_pkk = $dat_rawat['JKN_KD_PKK'];
	$jkn_nama_pkk = $dat_rawat['JKN_NAMA_PKK'];
	$jkn_catatan = $dat_rawat['JKN_CATATAN'];
	$jkn_diagnosa = $dat_rawat['JKN_DIAGNOSA'];
	$jkn_nama_diagnosa = $dat_rawat['DESKRIPSI'];
	$jkn_poliklinik = $dat_rawat['JKN_POLIKLINIK'];
	$jkn_kelas_rawat = $dat_rawat['JKN_KELAS_RAWAT'];
	$jkn_pbi_nonpbi = $dat_rawat['JKN_PBI_NONPBI'];
	$jkn_asal_rujukan = $dat_rawat['JKN_ASAL_RUJUKAN'];
	$jkn_cob = $dat_rawat['JKN_COB'];
	$jkn_penjamin = $dat_rawat['JKN_PENJAMIN'];
	$jkn_penjamin_r = explode(',',$jkn_penjamin);
	foreach($jkn_penjamin_r as $jp){
		if($jp == '1') $jkn_penjamin_1 = '1';
		if($jp == '2') $jkn_penjamin_2 = '2';
		if($jp == '3') $jkn_penjamin_3 = '3';
		if($jp == '4') $jkn_penjamin_4 = '4';
	}
	
	$jkn_ruang_id = $dat_rawat['RUANG_ID'];
	$tgl_daftar = $dat_rawat['TGL_DAFTAR_IRJA'];
	
	$jkn_katarak = $dat_rawat['JKN_KATARAK'];
	$jkn_suplesi = $dat_rawat['JKN_SUPLESI'];
	$jkn_nosep_suplesi = $dat_rawat['JKN_NO_SEP_SUPLESI'];
	$jkn_nosurat_skdp = $dat_rawat['JKN_NOSURAT_SKDP'];
	$jkn_dpjp_skdp = $dat_rawat['JKN_DPJP_SKDP'];
	$jkn_nama_dpjp_skdp = $dat_rawat['JKN_NAMA_DPJP_SKDP'];
	$jkn_spesialis_dpjp_skdp = $dat_rawat['JKN_SPESIALISASI_DPJP_SKDP'];

	$nama_pasien = $dat_rawat['NAMA_PASIEN'];
	$tgl_lahir = $dat_rawat['TGL_LAHIR'];
	$jns_kelamin = $dat_rawat['JNS_KELAMIN'];

	$tgl_daftar = $dat_rawat['TGL_DAFTAR_IRJA'];	
	$kelas_jaminan = $dat_rawat['KELAS_JAMINAN'];	
	$kelas_rawat = $dat_rawat['KELAS_RAWAT'];	
	
	$pasien_kecelakaan = $dat_rawat['KECELAKAAN'];
	$kd_lokasi_kecelakaan_propinsi = $dat_rawat['KD_LOKASI_KECELAKAAN_PROPINSI'];
	$kd_lokasi_kecelakaan_kota = $dat_rawat['KD_LOKASI_KECELAKAAN_KABUPATEN'];
	$kd_lokasi_kecelakaan_kecamatan = $dat_rawat['KD_LOKASI_KECELAKAAN_KECAMATAN'];
	$nama_lokasi_kecelakaan_propinsi = $dat_rawat['NAMA_LOKASI_KECELAKAAN_PROPINSI'];
	$nama_lokasi_kecelakaan_kota = $dat_rawat['NAMA_LOKASI_KECELAKAAN_KABUPATEN'];
	$nama_lokasi_kecelakaan_kecamatan = $dat_rawat['NAMA_LOKASI_KECELAKAAN_KECAMATAN'];
	$tgl_kejadian_kecelakaan = changeDateFormat($dat_rawat['TGL_KEJADIAN_KECELAKAAN']);
	$keterangan_kecelakaan = $dat_rawat['KETERANGAN_KECELAKAAN'];
	$kasus_polisi = $dat_rawat['KASUS_POLISI'];
	
	$jkn_no_telp = $dat_rawat['NO_TELEPON'];
}

if (isset($_POST['irna_id'])) {
    include('pendaftaran/pendaftaran_save_edit_daftar_irna.php');
}
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#jkn_diagnosa").autocomplete("index.php?autocomp=autocompjkndiagnosa",{width: 350});
    });
</script>
<div style=" height:auto; padding:15px;">
<form name="pendaftaranedit" action="<?php echo currentURL(); ?>" method="post" >
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
            <div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Medical Record</div>
			<div style=" width:20px; float:left; ">:</div>
            <div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo formatNoMr($nomr); ?></div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div>
			<div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
        
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Pembayaran</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<select name="jenis_bayar_id" id="jenis_bayar_id" style="width:228px;" class="text_dt" onchange="javascript : MyAjaxRequest('cnopeserta','index.php?ajaxrequest=cnopesertaranap&idx=<?php echo $irna_id; ?>&nomr=<?php echo $nomr; ?>&jenis_bayar_id=' + this.value);ubah_formbayar(this.value);ubah_isian_sep(this.value,<?php echo $jenis_bayar_id; ?>,<?php echo $irna_id; ?>);return false;">
                    <option value=""> - </option>
                    <?php echo getJnsBayar($jenis_bayar_id,'1'); ?>
                </select>
			</div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left">
			<div id="cnopeserta" >
			<?php if($jenis_bayar_id == '12'){ ?>
			<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $no_peserta; ?>" size="34" />
			<br />
			<button type="button" onClick="getPeserta(1, 1)" class="myButton1">cari kartu</button>
			<button type="button" onClick="getPeserta(2, 1)" class="myButton1">cari ktp</button>
			<button type="button" onClick="showPeserta()" class="myButton1" id="pesertaDetail" style="display:none">detail</button>
			<?php }else{ ?>
			<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $no_peserta; ?>" size="34" />
			<?php } ?>
			</div></div>
            <div style=" width:20px; float:right; ">:</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Peserta</div><br><br>
	
			<div id="form_bayar1">
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Kelas Peserta</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<select name="kelas_jaminan" id="kelas_jaminan" style="width:128px;" class="text_dt" >
			<option value=""> - </option>
			<option value="1" <?php if($kelas_jaminan == '1') echo 'selected="selected"'; ?> > 1 </option>
			<option value="2" <?php if($kelas_jaminan == '2') echo 'selected="selected"'; ?> > 2 </option>
			<option value="3" <?php if($kelas_jaminan == '3') echo 'selected="selected"'; ?> > 3 </option>
			</select>
			</div>
			<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
            <div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br> 
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
   	<!------------------------------------------------------------------------------------->            
</div>   
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">	
        <?php include('pendaftaran/pendaftaran_edit_daftar.php'); ?>
</div>   
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">	      		
		<input type="radio" name="st_edit" value="3" checked="checked">&nbsp;Cetak Ulang SJP/Gelang Pasien&nbsp;
		<input type="radio" name="st_edit" value="1">&nbsp;Perubahan Hanya Nomor Peserta dan SEP/Penanggung Jawab&nbsp;&nbsp;<?php if($_SESSION['SES_SIMRS_ADMIN'] == '1'){ ?><input type="radio" name="st_edit" value="2">&nbsp;Semua Diubah
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Batal&nbsp;<input type="checkbox" name="st_batal" value="1" <?php if(isset($_POST['st_batal'])) echo 'checked="checked"'; ?> >&nbsp;&nbsp;&nbsp;Keterangan
            &nbsp;<input type="text" name="keterangan_batal" size="20" class="text_dt" />
        <?php } ?>
</div>    

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px;  " align="right">
<a href="index.php?link=<?php echo md5('pendaftaranlistrawat'); ?>" >
<input type="button" value="tutup" class="myButton" /></a>
<?php
	if($jenis_bayar_id == 12) {
			echo('<button type="submit" onClick="deleteSEP(\'' . $no_sep . '\')" class="myButton1" />simpan</button>');
	} else {
			echo('<input type="submit" value="simpan" class="myButton1" />');
	}
?>
<input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
<input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
<input type="hidden" name="no_sjp" id="no_sjp" value="<?php echo $no_sjp; ?>" />
<input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
<input type="hidden" name="tgl_daftar" id="tgl_daftar" value="<?php echo $tgl_daftar; ?>" />
<input type="hidden" name="jkn_no_telp" id="jkn_no_telp" value="<?php echo $jkn_no_telp; ?>" />
<input type="hidden" name="jenis_bayar_id_ls" id="jenis_bayar_id_ls" value="<?php echo $jenis_bayar_id; ?>" />
</div>
</form>
</div>
<script type="text/javascript">
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
		MyAjaxRequest('div_jkn_no_sep','index.php?ajaxrequest=tampilnosepranap&opt=1&jns=' + jns + '&jns_a=' + jns_a + '&idx=' + idx);
	}else{
		MyAjaxRequest('div_no_sep','index.php?ajaxrequest=tampilnosepranap&opt=2&jns=' + jns + '&jns_a=' + jns_a + '&idx=' + idx);
	}
}
document.getElementById("jenis_bayar_id").focus();
</script>