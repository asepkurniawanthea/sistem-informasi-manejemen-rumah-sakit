<?php
if (isset($_GET['idx'])) {
	$irja_id = $_GET['idx'];
    $sql_kunjungan = 'SELECT t_irja.NOMR,t_irja.IRJA_ID,t_irja.TANGGAL_DAFTAR,t_irja.ST_BARU,t_irja.UNIT_ID,
					t_irja.JENIS_BAYAR_ID,t_irja.P_JAWAB_NAMA,t_irja.P_JAWAB_NO_TELP,t_irja.P_JAWAB_ALAMAT,
					t_irja.P_JAWAB_ALAMAT_RT,t_irja.P_JAWAB_ALAMAT_RW,t_irja.P_JAWAB_KELURAHAN_ID,t_irja.P_JAWAB_KECAMATAN_ID,
					t_irja.P_JAWAB_KOTA_ID,t_irja.P_JAWAB_PROPINSI_ID,t_irja.P_JAWAB_HUBUNGAN,m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,
					m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_propinsi.NAMA_PROPINSI,m_kota.NAMA_KOTA,m_pegawai.NAMA_PEGAWAI,
					t_irja.NO_PESERTA,t_irja.NO_SEP,t_irja.NO_SJP,m_asal_pasien.KET_ASAL_PASIEN AS ASAL_PASIEN,t_irja.KET_ASAL_PASIEN,
					t_irja.JKN_TGL_RUJUK,t_irja.JKN_NO_RUJUK,t_irja.JKN_KD_PKK,t_irja.JKN_NAMA_PKK,t_irja.JKN_CATATAN,
					t_irja.JKN_DIAGNOSA,t_irja.JKN_POLIKLINIK,t_irja.JKN_KELAS_RAWAT,t_irja.JKN_PBI_NONPBI,t_irja.KECELAKAAN,
					t_irja.LOKASI_KECELAKAAN,t_irja.KASUS_POLISI
					FROM t_irja
				  LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				  LEFT JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				  LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				  LEFT JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
				  LEFT JOIN m_kelurahan ON (t_irja.P_JAWAB_KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				  LEFT JOIN m_kecamatan ON (t_irja.P_JAWAB_KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				  LEFT JOIN m_propinsi ON (t_irja.P_JAWAB_PROPINSI_ID = m_propinsi.PROPINSI_ID)
				  LEFT JOIN m_kota ON (t_irja.P_JAWAB_KOTA_ID = m_kota.KOTA_ID) WHERE IRJA_ID = "' . $irja_id . '"
				  AND (t_irja.MCU IS NULL OR t_irja.MCU = "")	
				  UNION
				  SELECT t_irja.NOMR,t_irja.IRJA_ID,t_irja.TANGGAL_DAFTAR,t_irja.ST_BARU,t_irja.UNIT_ID,
					t_irja.JENIS_BAYAR_ID,t_irja.P_JAWAB_NAMA,t_irja.P_JAWAB_NO_TELP,t_irja.P_JAWAB_ALAMAT,
					t_irja.P_JAWAB_ALAMAT_RT,t_irja.P_JAWAB_ALAMAT_RW,t_irja.P_JAWAB_KELURAHAN_ID,t_irja.P_JAWAB_KECAMATAN_ID,
					t_irja.P_JAWAB_KOTA_ID,t_irja.P_JAWAB_PROPINSI_ID,t_irja.P_JAWAB_HUBUNGAN,
					m_tarif.NAMA_TARIF AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN,
					m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_propinsi.NAMA_PROPINSI,m_kota.NAMA_KOTA,m_pegawai.NAMA_PEGAWAI,
					t_irja.NO_PESERTA,t_irja.NO_SEP,t_irja.NO_SJP,m_asal_pasien.KET_ASAL_PASIEN AS ASAL_PASIEN,t_irja.KET_ASAL_PASIEN,
					t_irja.JKN_TGL_RUJUK,t_irja.JKN_NO_RUJUK,t_irja.JKN_KD_PKK,t_irja.JKN_NAMA_PKK,t_irja.JKN_CATATAN,
					t_irja.JKN_DIAGNOSA,t_irja.JKN_POLIKLINIK,t_irja.JKN_KELAS_RAWAT,t_irja.JKN_PBI_NONPBI,t_irja.KECELAKAAN,
					t_irja.LOKASI_KECELAKAAN,t_irja.KASUS_POLISI
					FROM t_irja
				  LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				  LEFT JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				  LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				  LEFT JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
				  LEFT JOIN m_kelurahan ON (t_irja.P_JAWAB_KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				  LEFT JOIN m_kecamatan ON (t_irja.P_JAWAB_KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				  LEFT JOIN m_propinsi ON (t_irja.P_JAWAB_PROPINSI_ID = m_propinsi.PROPINSI_ID)
				  LEFT JOIN m_kota ON (t_irja.P_JAWAB_KOTA_ID = m_kota.KOTA_ID) 
				  LEFT JOIN m_tarif ON (t_irja.MCU = m_tarif.TARIF_ID)
				  WHERE IRJA_ID = "' . $irja_id . '"
				  AND (t_irja.MCU IS NOT NULL OR t_irja.MCU <> "")';
    $get_kunjungan = mysql_query($sql_kunjungan);
    $dat_kunjungan = mysql_fetch_assoc($get_kunjungan);

    $nomr = $dat_kunjungan['NOMR'];
	$unit_id = $dat_kunjungan['NAMA_UNIT'];
    $jenis_bayar_id = $dat_kunjungan['NAMA_JAMINAN'];
	$tanggal_daftar = $dat_kunjungan['TANGGAL_DAFTAR'];
	$dokter = $dat_kunjungan['NAMA_PEGAWAI'];
	$no_peserta = $dat_kunjungan['NO_PESERTA'];
	$no_sep = $dat_kunjungan['NO_SEP'];
	$no_sjp = $dat_kunjungan['NO_SJP'];
	$asal_pasien = $dat_kunjungan['ASAL_PASIEN'];
	$ket_asal_pasien = $dat_kunjungan['KET_ASAL_PASIEN']; 	
	$pasien_kecelakaan = $dat_kunjungan['KECELAKAAN']; 	
	$lokasi_kecelakaan = $dat_kunjungan['LOKASI_KECELAKAAN']; 	
	$kasus_polisi = $dat_kunjungan['KASUS_POLISI']; 	
	
    $p_jawab_nama = $dat_kunjungan['P_JAWAB_NAMA'];
    $p_jawab_no_telp = $dat_kunjungan['P_JAWAB_NO_TELP'];
    $p_jawab_alamat = $dat_kunjungan['P_JAWAB_ALAMAT'];
    $p_jawab_alamat_rt = $dat_kunjungan['P_JAWAB_ALAMAT_RT'];
    $p_jawab_alamat_rw = $dat_kunjungan['P_JAWAB_ALAMAT_RW'];
    $p_jawab_kelurahan_id = $dat_kunjungan['NAMA_KELURAHAN'];
    $p_jawab_kecamatan_id = $dat_kunjungan['NAMA_KECAMATAN'];
    $p_jawab_kota_id = $dat_kunjungan['NAMA_KOTA'];
    $p_jawab_propinsi_id = $dat_kunjungan['NAMA_PROPINSI'];
    $p_jawab_hubungan = $dat_kunjungan['P_JAWAB_HUBUNGAN'];
	
	$jkn_tgl_rujuk = changeDateFormat($dat_kunjungan['JKN_TGL_RUJUK']);
	$jkn_no_rujuk = $dat_kunjungan['JKN_NO_RUJUK'];
	$jkn_kd_pkk = $dat_kunjungan['JKN_KD_PKK'];
	$jkn_nama_pkk = $dat_kunjungan['JKN_NAMA_PKK'];
	$jkn_catatan = $dat_kunjungan['JKN_CATATAN'];
	$jkn_diagnosa = $dat_kunjungan['JKN_DIAGNOSA'];
	$jkn_poliklinik = $dat_kunjungan['JKN_POLIKLINIK'];
	$jkn_kelas_rawat = $dat_kunjungan['JKN_KELAS_RAWAT'];
	$jkn_pbi_nonpbi = $dat_kunjungan['JKN_PBI_NONPBI'];
	
	if($jkn_nama_pkk == '') $jkn_nama_pkk  = '-';
	if($jkn_pbi_nonpbi == '') $jkn_pbi_nonpbi  = '-';
       
    $sql_pasien = 'SELECT m_pasien.PASIEN_ID,m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TMP_LAHIR,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ST_KAWIN,
				m_pasien.AGAMA_ID,m_pasien.PENDIDIKAN_ID,m_pasien.PEKERJAAN,m_pasien.ALAMAT,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_pasien.KELURAHAN_ID,
				m_pasien.KECAMATAN_ID,m_pasien.KOTA_ID,m_pasien.PROPINSI_ID,m_pasien.KODE_POS,m_pasien.NO_TELEPON,m_pasien.NAMA_IBU,m_pasien.NAMA_AYAH,
				m_pasien.NAMA_SUAMI_ISTERI,m_pasien.NIK,m_pasien.KHUSUS,m_agama.NAMA_AGAMA,m_pendidikan.NAMA_PENDIDIKAN,
				m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,m_propinsi.NAMA_PROPINSI
				FROM m_pasien
				  LEFT JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
				  LEFT JOIN m_pendidikan ON (m_pasien.PENDIDIKAN_ID = m_pendidikan.PENDIDIKAN_ID)
				  LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				  LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				  LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				  LEFT JOIN m_propinsi ON (m_pasien.PROPINSI_ID = m_propinsi.PROPINSI_ID) WHERE m_pasien.NOMR = "' . $nomr . '"';
    $get_pasien = mysql_query($sql_pasien);
    $dat_pasien = mysql_fetch_assoc($get_pasien);

    $nama_pasien = $dat_pasien['NAMA_PASIEN'];
    $tmp_lahir = $dat_pasien['TMP_LAHIR'];
    $tgl_lahir = changeDateFormat($dat_pasien['TGL_LAHIR']);
    $jns_kelamin = $dat_pasien['JNS_KELAMIN'];
    $st_kawin = $dat_pasien['ST_KAWIN'];
    $agama_id = $dat_pasien['NAMA_AGAMA'];
    $pendidikan_id = $dat_pasien['NAMA_PENDIDIKAN'];
    $pekerjaan_id = $dat_pasien['PEKERJAAN'];
    $alamat = $dat_pasien['ALAMAT'];
    $alamat_rt = $dat_pasien['ALAMAT_RT'];
    $alamat_rw = $dat_pasien['ALAMAT_RW'];
    $kelurahan_id = $dat_pasien['NAMA_KELURAHAN'];
    $kecamatan_id = $dat_pasien['NAMA_KECAMATAN'];
    $kota_id = $dat_pasien['NAMA_KOTA'];
    $propinsi_id = $dat_pasien['NAMA_PROPINSI'];
    $kode_pos = $dat_pasien['KODE_POS'];
    $no_telepon = $dat_pasien['NO_TELEPON'];
    $nama_ibu = $dat_pasien['NAMA_IBU'];
    $nama_ayah = $dat_pasien['NAMA_AYAH'];
    $nama_suami_isteri = $dat_pasien['NAMA_SUAMI_ISTERI'];
    $nik = $dat_pasien['NIK'];
    $khusus = $dat_pasien['KHUSUS'];
    ?>
	<div style=" height:auto; padding:15px; ">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; padding-left:35px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">   
		
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik Tujuan</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:25px; " align="left"><?php echo $unit_id; ?></div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left"><?php echo $dokter; ?></div>
			<div style=" width:20px; float:right; ">:</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">Dokter</div><br><br>            
       
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Pembayaran</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:25px; " align="left"><?php echo $jenis_bayar_id; ?></div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">
				<?php 
					if ($no_peserta=='') {
						echo "-";
					}else {					
						echo $no_peserta; 
					}
				?>
			</div>
			<div style=" width:20px; float:right; ">:</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Peserta</div><br><br>            
        
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Nomor SEP</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:25px; " align="left"><?php echo $no_sep; ?></div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left"><?php echo $no_sjp; ?></div>
			<div style=" width:20px; float:right; ">:</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor SJP</div><br><br>           
       
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Asal Pasien</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:25px; " align="left"><?php echo $asal_pasien; ?></div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">
				<?php 
					if($ket_asal_pasien=='') {
						echo "-"; 
					} else {
						echo $ket_asal_pasien;
					}
				?>
			</div>
			<div style=" width:20px; float:right; ">:</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">Keterangan Asal Pasien</div><br><br> 
			
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Pasien Kecelakaan</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:25px; " align="left"><?php 
			if($pasien_kecelakaan == '1') echo 'Darat';
			if($pasien_kecelakaan == '2') echo 'Perairan';
			if($pasien_kecelakaan == '3') echo 'Udara';
			if($pasien_kecelakaan == '') echo '-';
			?></div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left"><?php echo setIfNull($lokasi_kecelakaan); ?></div>
			<div style=" width:20px; float:right; ">:</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">Lokasi</div><br><br> 
			
			<div style=" width:250px; float:left; text-indent:25px; " align="left">Kasus Polisi</div>
			<div style=" width:20px; float:left; ">:</div>
			<div style=" width:250px; float:left; text-indent:25px; " align="left"><?php 
			if($kasus_polisi == '1') {
				echo 'Ya';
			}else{
				echo '-';
			}	
			?></div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div>
			<div style=" width:20px; float:right; ">&nbsp;</div>
			<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br> 
		</div>
	<?php if($jenis_bayar_id == 'JKN'){ ?>
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; padding-left:35px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">   
		<div style=" width:250px; float:left; text-indent:25px; " align="left">Tanggal Rujukan</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:25px; " align="left">
				<?php echo $jkn_tgl_rujuk; ?></div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">
				<?php if(!empty($jkn_no_rujuk)) { echo $jkn_no_rujuk; }else{ echo '-'; } ?></div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Nomor Rujukan</div><br><br> 	
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Diagnosa</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:25px; " align="left">
				<?php echo $jkn_diagnosa; ?></div>
				
				<div style=" width:250px; float:right; text-indent:25px; " align="left">
				<?php if(!empty($jkn_catatan)) { echo $jkn_catatan; }else{ echo '-'; } ?></div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Catatan</div><br><br><br><br><br> 
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Kode Puskesmas</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:25px; " align="left">
				<?php echo $jkn_kd_pkk; ?></div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">
				<?php echo $jkn_nama_pkk; ?></div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Nama Puskesmas</div><br><br> 
				
				<div style=" width:250px; float:left; text-indent:25px; " align="left">Kelas Rawat</div>
				<div style=" width:20px; float:left; ">:</div>
				<div style=" width:250px; float:left; text-indent:25px; " align="left">
				<?php echo $jkn_kelas_rawat; ?></div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">
				<?php echo $jkn_pbi_nonpbi; ?></div>
				<div style=" width:20px; float:right; ">:</div>
				<div style=" width:250px; float:right; text-indent:25px; " align="left">Jenis Peserta</div><br><br>
	</div>
	<?php } ?>
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; padding-left:35px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;"> 
			
        <?php
        include('pasien/pasien_view.php');
        ?>
	</div>
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; padding-left:35px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">        
        <?php
        include('pendaftaran/pendaftaran_view_pjawab.php');
        ?>
  	</div>
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;" align="right">
		<?php $link = md5('pendaftaranlistonline') . '&pasien=online'; ?>
        <a href="index.php?link=<?php echo $link; ?>" ><input type="button" value="tutup" class="myButton" /></a>
        <a href="#" onclick="javascript : cetak_kartu('<?php echo formatNoMR($nomr); ?>','<?php echo $nama_pasien; ?>','<?php echo $alamat . ' ' . $alamat_rt . ' ' . $alamat_rw . ' ' . $kelurahan_id . ' ' . $kecamatan_id . ' ' . $kota_id; ?>','<?php echo $jns_kelamin; ?>','<?php echo $tgl_lahir; ?>');return false;" ><input type="button" value="cetak kartu pasien" class="myButton1" /></a>
    </div>
	</div>
<script language="javascript" type="text/javascript">
function cetak_kartu(nomr,nama,alamat,jnskel,tgllahir){
	window.open("pdf/kartupasien.php?nomr="+ nomr +"&nama="+ nama +"&alamat="+ alamat +"&jnskel="+ jnskel +"&tgllahir="+ tgllahir,"Kartu Pasien");
}
</script>
	
    <?php
}
?>
