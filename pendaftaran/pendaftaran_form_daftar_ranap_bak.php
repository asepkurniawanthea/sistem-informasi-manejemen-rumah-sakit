<?php
if(isset($_GET['booking'])){
	mysql_query('UPDATE t_irna_booking_kamar
					SET ST_BOOKING = "Rawat Inap"
					WHERE BOOKING_KAMAR_ID = "' . $_GET['idb'] . '"') or die(mysql_error());
}

$irja_id_rujuk = '';

$ruang_id = '';
$tmp_tidur = '';
$diagnosa_awal = '';
$pegawai_id = '';
$jenis_bayar_id = '';
$no_peserta = '';
$no_sep = '';

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

$tgl_daftar = '';
$kelas_jaminan = '';

$pasien_kecelakaan = '';
$lokasi_kecelakaan = '';
$kasus_polisi = '';

if (isset($_GET['idx'])) {
    $irja_id_rujuk = $_GET['idx'];
	$sql_kunjungan = 'SELECT t_irja.*,m_pegawai.NAMA_PEGAWAI,m_unit.NAMA_UNIT,m_asal_pasien.KET_ASAL_PASIEN,
					m_jaminan.NAMA_JAMINAN,
					DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_DAFTAR
					FROM t_irja 
					INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					INNER JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
					INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE IRJA_ID = "' . $irja_id_rujuk . '"';
    $get_kunjungan = mysql_query($sql_kunjungan);
    $dat_kunjungan = mysql_fetch_assoc($get_kunjungan);
    
	$asal_pasien_id = $dat_kunjungan['ASAL_PASIEN_ID'];
	$ket_asal_pasien = $dat_kunjungan['KET_ASAL_PASIEN'];
	$dokter = $dat_kunjungan['NAMA_PEGAWAI'];
	$unit = $dat_kunjungan['NAMA_UNIT'];
	$asal_pasien = $dat_kunjungan['KET_ASAL_PASIEN'];
	$jaminan = $dat_kunjungan['NAMA_JAMINAN'];
	$jenis_bayar_id = $dat_kunjungan['JENIS_BAYAR_ID'];
    
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
	
	$sql_diagnosa = 'SELECT CONCAT(t_irja_diagnosa.ICD_CODE," ",t_irja_diagnosa.DIAGNOSA) AS DIAGNOSA
					FROM t_irja_diagnosa
					WHERE t_irja_diagnosa.IRJA_ID = "' . $irja_id_rujuk . '"
					AND t_irja_diagnosa.DIAGNOSA_ORDER = 0';
	$get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());
	$dat_diagnosa = mysql_fetch_assoc($get_diagnosa);
	$diagnosa_awal = $dat_diagnosa['DIAGNOSA'];
	$no_peserta = $dat_kunjungan['NO_PESERTA'];
	
	$jkn_kd_pkk = $dat_kunjungan['JKN_KD_PKK'];
	$jkn_nama_pkk = $dat_kunjungan['JKN_NAMA_PKK'];
	$jkn_kelas_rawat = $dat_kunjungan['JKN_KELAS_RAWAT'];
	$jkn_pbi_nonpbi = $dat_kunjungan['JKN_PBI_NONPBI'];
	$jkn_tgl_rujuk = changeDateFormat($dat_kunjungan['JKN_TGL_RUJUK']);
	$jkn_no_rujuk = $dat_kunjungan['JKN_NO_RUJUK'];
	
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
	
	$tgl_daftar = $dat_kunjungan['TGL_DAFTAR'];
	
	if($dat_kunjungan['PASIEN_PULANG_ID'] == '2') $ruang_id = $dat_kunjungan['RUJUKAN_RUANG_ID']; 

	$pasien_kecelakaan = $dat_kunjungan['KECELAKAAN'];
	$lokasi_kecelakaan = $dat_kunjungan['LOKASI_KECELAKAAN'];	
	$kasus_polisi = $dat_kunjungan['KASUS_POLISI'];	
}	

$sql_pasien = 'SELECT * FROM m_pasien WHERE NOMR = "' . $nomr . '"';
$get_pasien = mysql_query($sql_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);

$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = changeDateFormat($dat_pasien['TGL_LAHIR']);
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
$jkn_no_telp = $dat_pasien['NO_TELEPON'];

if (isset($_POST['irja_id_rujuk'])) {
    include('pendaftaran/pendaftaran_save_daftar_ranap.php');
}
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#jkn_diagnosa").autocomplete("index.php?autocomp=autocompjkndiagnosa",{width: 350});
    });
</script>
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
	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Diagnosa Awal</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:750px; float:left; text-indent:5px; " align="left">
		<?php echo $diagnosa_awal; ?>
	</div>
	<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;
	</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br>
   	<!------------------------------------------------------------------------------------->
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<!-- -->
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Pembayaran</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<select name="jenis_bayar_id" id="jenis_bayar_id" style="width:228px;" class="text_dt" onchange="javascript : MyAjaxRequest('cnopeserta','index.php?ajaxrequest=cnopesertaranap&idx=<?php echo $irja_id_rujuk; ?>&nomr=<?php echo $nomr; ?>&jenis_bayar_id=' + this.value);ubah_formbayar(this.value); return false;">
                    <option value=""> - </option>
                    <?php echo getJnsBayar($jenis_bayar_id,'1'); ?>
                </select>
			</div>
            <div style=" width:300px; float:right; text-indent:5px; " align="left">
			<div id="cnopeserta" >
			<?php if($jenis_bayar_id == '12'){ ?>
			<input type="text" name="no_peserta" id="no_peserta" class="text_dt" value="<?php echo $no_peserta; ?>" size="34" />
			<br />
			&nbsp;&nbsp;<button type="button" onClick="getPeserta(1, 1)" class="myButton1">cari kartu</button>
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
			
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Ruang Rawat</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<select name="ruang_id" id="ruang_id" style="width:228px;" class="text_dt" onchange="javascript : MyAjaxRequest('ctmptidur','index.php?ajaxrequest=ctmptidur&ruang_id=' + this.value);return false;" >
			<option value=""> - </option>
			<?php echo getRuangRawat($ruang_id); ?>
			</select>
			</div>
			<div style=" width:300px; float:right; text-indent:5px; " align="left">
			<div id="cdokter">
			<select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($pegawai_id); ?>
			</select>
			</div>
			</div>
            <div style=" width:20px; float:right; ">:</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">Dokter</div><br><br> 

			<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Tempat Tidur</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
			<div id="ctmptidur">
				<select name="tmp_tidur" id="tmp_tidur" style="width:128px;" class="text_dt" >
					<option value=""> - </option>
					<?php echo getTempatTidur($ruang_id,$tmp_tidur); ?>
				</select>
			</div>	
			</div>
			<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
			<div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>	
       
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor SEP</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input type="text" name="no_sep" id="no_sep" class="text_dt" value="<?php echo $no_sep; ?>" size="34" />
			</div>
            <div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
            <div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:300px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>            
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
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Rujukan</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input type="text" name="jkn_tgl_rujuk" id="tgl_minta" value="<?php echo $jkn_tgl_rujuk; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar10')"/>
				</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input type="text" name="jkn_no_rujuk" id="jkn_no_rujuk" class="text_dt" value="<?php echo $jkn_no_rujuk; ?>" size="34" />
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Rujukan</div><br><br> 
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Asal Rujukan</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<select name="jkn_asal_rujukan" id="jkn_asal_rujukan" style="width:228px;" class="text_dt" >
				<option value=""> - </option>
				<option value="1" <?php if($jkn_asal_rujukan == '1') echo 'selected="selected"'; ?>>Faskes 1</option>
				<option value="2" <?php if($jkn_asal_rujukan == '2') echo 'selected="selected"'; ?>>Faskes 2</option>
				</select>
				</div>
				
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				&nbsp;
				</div>
				<div style=" width:20px; float:right; ">&nbsp;</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Kode Puskesmas</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input type="text" name="jkn_kd_pkk" id="jkn_kd_pkk" value="<?php echo $jkn_kd_pkk; ?>" size="34" class="text_dt" readonly="readonly" />
				</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input type="text" name="jkn_nama_pkk" id="jkn_nama_pkk" class="text_dt" value="<?php echo $jkn_nama_pkk; ?>" size="34" readonly="readonly" />
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Nama Puskesmas</div><br><br> 
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Diagnosa</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input type="text" name="jkn_diagnosa" id="jkn_diagnosa" class="text_dt" value="<?php echo $jkn_diagnosa; ?>"  size="34"/>
				</div>
				
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input type="text" name="jkn_catatan" id="jkn_catatan" class="text_dt" value="<?php echo $jkn_catatan; ?>" size="34" />
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Catatan</div><br><br>
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Kelas Rawat</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<input type="text" name="jkn_kelas_rawat" id="jkn_kls_rawat" class="text_dt" value="<?php echo $jkn_kelas_rawat; ?>" size="15" readonly="readonly" />
				</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input type="text" name="jkn_pbi_nonpbi" id="jkn_pbi_nonpbi" class="text_dt" value="<?php echo $jkn_pbi_nonpbi; ?>" size="34" readonly="readonly" />
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Jenis Peserta</div><br><br>
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Ruang Rawat</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<select name="jkn_ruang_id" id="jkn_ruang_id" style="width:228px;" class="text_dt" onchange="javascript : MyAjaxRequest('ctmptidur2','index.php?ajaxrequest=ctmptidurjkn&ruang_id=' + this.value);return false;" >
				<option value=""> - </option>
				<?php echo getRuangRawat($ruang_id); ?>
				</select>
				</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<select name="jkn_pegawai_id" id="jkn_pegawai_id" style="width:228px;" class="text_dt" >
				<option value=""> - </option>
				<?php echo getDokterRanap($pegawai_id); ?>
				</select>
				</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Dokter</div><br><br>  

				<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor Tempat Tidur</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
				<div id="ctmptidur2">
					<select name="jkn_tmp_tidur" id="jkn_tmp_tidur" style="width:128px;" class="text_dt" >
						<option value=""> - </option>
						<?php echo getTempatTidur($ruang_id,$tmp_tidur); ?>
					</select>
				</div>	
				</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">&nbsp;</div>
				<div style=" width:20px; float:right; ">&nbsp;</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>

				<div style=" width:250px; float:left; text-indent:25px; " align="left">Pasien Kecelakaan</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:5px; " align="left">
					<select name="pasien_kecelakaan" id="pasien_kecelakaan" style="width:228px;" class="text_dt">
						<option value=""> - </option>
						<option value="1" <?php if($pasien_kecelakaan == '1') echo 'selected="selected"'; ?> >Darat</option>
						<option value="2" <?php if($pasien_kecelakaan == '2') echo 'selected="selected"'; ?> >Perairan</option>
						<option value="3" <?php if($pasien_kecelakaan == '3') echo 'selected="selected"'; ?> >Udara</option>
					</select>
				</div>
				<div style=" width:300px; float:right; text-indent:5px; " align="left">
				<input type="text" name="lokasi_kecelakaan" id="lokasi_kecelakaan" value="<?php echo $lokasi_kecelakaan; ?>" class="text_dt" size="34" /></div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px;" align="left">Lokasi Kecelakaan</div><br><br>

				<div style=" width:250px; float:left; text-indent:25px; " align="left">Penjamin</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:350px; float:left; text-indent:5px; " align="left">
					<input type="checkbox" name="jkn_penjamin_1" id="jkn_penjamin_1" value="1" 
					<?php if($jkn_penjamin_1 == '1') echo 'checked="checked"'; ?> />&nbsp;Jasa Raharja&nbsp;&nbsp;
					<input type="checkbox" name="jkn_penjamin_2" id="jkn_penjamin_2" value="2" 
					<?php if($jkn_penjamin_2 == '2') echo 'checked="checked"'; ?> />&nbsp;BPJS TK&nbsp;&nbsp;
					<input type="checkbox" name="jkn_penjamin_3" id="jkn_penjamin_3" value="3" 
					<?php if($jkn_penjamin_3 == '3') echo 'checked="checked"'; ?> />&nbsp;Taspen&nbsp;&nbsp;
					<input type="checkbox" name="jkn_penjamin_4" id="jkn_penjamin_4" value="4" 
					<?php if($jkn_penjamin_4 == '4') echo 'checked="checked"'; ?> />&nbsp;ASABRI</div>
				
				<div style=" width:300px; float:right; text-indent:5px; " align="left"><input type="checkbox" name="jkn_cob" id="jkn_cob" value="1" <?php if($jkn_cob == '1') echo 'checked="checked"'; ?> />&nbsp;Ya</div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px;" align="left">COB</div><br><br>	
		   
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor SEP</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:350px; float:left; text-indent:5px; " align="left">
					<input type="text" name="jkn_no_sep" id="jkn_no_sep" class="text_dt" value="<?php echo $no_sep; ?>" size="25" />
					<button type="button" onClick="createSEP(1)" class="myButton1">buat</button>
				</div>
				<div style=" width:250px; float:right; text-indent:5px; " align="left">
				&nbsp;
				</div>
				<div style=" width:20px; float:right; ">&nbsp;</div>
				<div style=" width:300px; float:right; text-indent:25px; " align="left"><image id="loader" src="/nsimrs/sep/image/loading_bar_green.gif" style="display:none" /></div><br><br>       
		</div>
   	<!------------------------------------------------------------------------------------->
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
        <?php include('pendaftaran/pendaftaran_edit_daftar.php'); ?>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;" align="right">
			<a href="index.php?link=<?php echo md5('pendaftaranbarurawatinap'); ?>" ><input type="button" value="batal" class="myButton" /></a>
			<input type="submit" value="simpan" class="myButton1" />

    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
	<input type="hidden" name="irja_id_rujuk" id="irja_id_rujuk" value="<?php echo $irja_id_rujuk; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
	<input type="hidden" name="diagnosa_awal" id="diagnosa_awal" value="<?php echo $diagnosa_awal; ?>" />
	<input type="hidden" name="tgl_daftar" id="tgl_daftar" value="<?php echo $tgl_daftar; ?>" />
	<input type="hidden" name="kasus_polisi" id="kasus_polisi" value="<?php echo $kasus_polisi; ?>" />
	<input type="hidden" name="jkn_no_telp" id="jkn_no_telp" value="<?php echo $jkn_no_telp; ?>" />
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