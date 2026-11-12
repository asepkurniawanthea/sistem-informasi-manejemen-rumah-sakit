<?php
$pasien = 'umumkusta';
$jns_rawat = '2';
$irja_id = '';
$irja_id_rujuk = '';
$nomr = '';
$jenis_bayar_id = '';
$jenis_bayar_id_rujuk = '';
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
$dokter = '';
$unit = '';
$asal_pasien = '';
$jaminan = '';
$jkn_unit_id = '';

$rujukan = '';

if (isset($_GET['idx'])) {
    $irja_id_rujuk = $_GET['idx'];
	
	$sql_kunjungan = 'SELECT  t_irja.*,m_icd_x.DESKRIPSI,m_pegawai.NAMA_PEGAWAI,m_unit.NAMA_UNIT,m_asal_pasien.KET_ASAL_PASIEN,
					m_jaminan.NAMA_JAMINAN,t_irja.KET_ASAL_PASIEN AS KETERANGAN_ASAL_PASIEN,
					DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_DAFTAR	
					FROM t_irja 
					INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					INNER JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
					INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					LEFT JOIN m_icd_x ON (t_irja.JKN_DIAGNOSA = m_icd_x.ICD_CODE)
					WHERE IRJA_ID = "' . $irja_id_rujuk . '"';
    $get_kunjungan = mysql_query($sql_kunjungan);
    $dat_kunjungan = mysql_fetch_assoc($get_kunjungan);
    
	$unit_id = $dat_kunjungan['RUJUKAN_UNIT_ID'];
	$jkn_unit_id = $dat_kunjungan['RUJUKAN_UNIT_ID'];
    $jenis_bayar_id_rujuk = $dat_kunjungan['JENIS_BAYAR_ID'];
	$jenis_bayar_id = $dat_kunjungan['JENIS_BAYAR_ID'];
	$no_peserta = $dat_kunjungan['NO_PESERTA'];
	$no_sep = $dat_kunjungan['NO_SEP'];
	$asal_pasien_id = $dat_kunjungan['ASAL_PASIEN_ID'];
	$ket_asal_pasien = $dat_kunjungan['KETERANGAN_ASAL_PASIEN'];
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
	$no_peserta = $dat_kunjungan['NO_PESERTA'];
	
	$jkn_kd_pkk = $dat_kunjungan['JKN_KD_PKK'];
	$jkn_nama_pkk = $dat_kunjungan['JKN_NAMA_PKK'];
	$jkn_kelas_rawat = $dat_kunjungan['JKN_KELAS_RAWAT'];
	$jkn_pbi_nonpbi = $dat_kunjungan['JKN_PBI_NONPBI'];
	
	$jkn_tgl_rujuk = changeDateFormat($dat_kunjungan['JKN_TGL_RUJUK']);
	$jkn_no_rujuk = $dat_kunjungan['JKN_NO_RUJUK'];
	$jkn_catatan = $dat_kunjungan['JKN_CATATAN'];
	$jkn_diagnosa = $dat_kunjungan['JKN_DIAGNOSA'];
	$jkn_nama_diagnosa = $dat_kunjungan['DESKRIPSI'];
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
	
	$jkn_katarak = $dat_kunjungan['JKN_KATARAK'];
	$jkn_suplesi = $dat_kunjungan['JKN_SUPLESI'];
	$jkn_nosep_suplesi = $dat_kunjungan['JKN_NO_SEP_SUPLESI'];
	$jkn_nosurat_skdp = $dat_kunjungan['JKN_NOSURAT_SKDP'];
	$jkn_dpjp_skdp = $dat_kunjungan['JKN_DPJP_SKDP'];
	$jkn_nama_dpjp_skdp = $dat_kunjungan['JKN_NAMA_DPJP_SKDP'];
	$jkn_spesialis_dpjp_skdp = $dat_kunjungan['JKN_SPESIALISASI_DPJP_SKDP'];
	
	$tgl_daftar = $dat_kunjungan['TGL_DAFTAR'];
	$dokter = $dat_kunjungan['NAMA_PEGAWAI'];
	$unit = $dat_kunjungan['NAMA_UNIT'];
	$asal_pasien = $dat_kunjungan['KET_ASAL_PASIEN'];
	$jaminan = $dat_kunjungan['NAMA_JAMINAN'];
	
	$rujukan = $dat_kunjungan['PASIEN_PULANG_ID'];
	
}else if(isset($_POST['irja_id_rujuk'])){
	$irja_id_rujuk = $_POST['irja_id_rujuk'];
	$nomr = $_POST['nomr'];
}	

$sql_pasien = 'SELECT * FROM m_pasien WHERE NOMR = "' . $nomr . '"';
$get_pasien = mysql_query($sql_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);

$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
$jkn_no_telp = $dat_pasien['NO_TELEPON'];

if (isset($_POST['irja_id'])) {
    include('pendaftaran/pendaftaran_save_daftar_rujuk.php');
}
?>
<div style=" height:auto; padding:15px; ">
<form name="pendaftaranedit" action="<?php echo currentURL(); ?>" method="post" >
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Medical Record</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo formatNoMr($nomr); ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">
		<?php 
			if ($nama_pasien==''){
				echo "-"; 
			} else {			
				echo $nama_pasien;
			}
		?>
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Nama Pasien</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Lahir</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $tgl_lahir; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">
		<?php 
			if ($tgl_lahir==''){
				echo "-"; 
			} else {			
				echo getUmur($tgl_lahir);
			}
			 
		?>
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Umur</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Kelamin</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo jenisKelamin($jns_kelamin); ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">
		<?php 
			if ($alamat==''){
				echo "-"; 
			} else {			
				echo $alamat;
			}
			 
		?>
	</div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Alamat</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">NIK</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left">
		<?php 
			if ($nik==''){
				echo "-"; 
			} else {			
				echo $nik;
			}
			 
		?>
	</div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Dokter Pengirim</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $dokter; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php echo $asal_pasien; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Asal Pasien</div><br><br>
   	<!------------------------------------------------------------------------------------->
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Kiriman Dari</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $unit; ?></div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left"><?php echo $jaminan; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Jenis Pembayaran</div><br><br>
   	<!------------------------------------------------------------------------------------->
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<!-- -->
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Pembayaran</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<select name="jenis_bayar_id" id="jenis_bayar_id" style="width:228px;" class="text_dt" onchange="javascript : MyAjaxRequest('cnopeserta','index.php?ajaxrequest=cnopesertarujuk&idx=<?php echo $irja_id_rujuk; ?>&nomr=<?php echo $nomr; ?>&jenis_bayar_id_rujuk=<?php echo $jenis_bayar_id_rujuk; ?>&jenis_bayar_id=' + this.value);ubah_formbayar(this.value); return false;">
                    <option value=""> - </option>
                    <?php echo getJnsBayar($jenis_bayar_id,'1'); ?>
                </select>
			</div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left">
			<div id="cnopeserta" >
			<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $no_peserta; ?>" size="34" />
			</div></div>
            <div style=" width:20px; float:right; ">:</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Peserta</div><br><br>
	
			<div id="form_bayar1">
			<?php include('pendaftaran/pendaftaran_form_nonjkn.php'); ?>	
			</div>

		<div id="form_bayar2">
		<?php if($jenis_bayar_id_rujuk != '12'){ ?>
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
			<?php }
			include('pendaftaran/pendaftaran_form_jkn.php'); 		
			?>
		</div>
   	<!------------------------------------------------------------------------------------->
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
        <?php include('pendaftaran/pendaftaran_edit_daftar.php'); ?>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;" align="right">
			<a href="index.php?link=<?php echo md5('pendaftaranpasienrujuk'); ?>" ><input type="button" value="batal" class="myButton" /></a>
			<input type="submit" value="simpan" class="myButton1" />

    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="irja_id_rujuk" id="irja_id_rujuk" value="<?php echo $irja_id_rujuk; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
	<input type="hidden" name="jkn_jns_rawat" id="jkn_jns_rawat" value="2" />
	<input type="hidden" name="tgl_daftar" id="tgl_daftar" value="<?php echo $tgl_daftar; ?>" />
	<input type="hidden" name="rujukan" id="rujukan" value="<?php echo $rujukan; ?>" />
	<input type="hidden" name="jenis_bayar_id_rujuk" id="jenis_bayar_id_rujuk" value="<?php echo $jenis_bayar_id_rujuk; ?>" />
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
document.getElementById("jenis_bayar_id").focus();
</script>