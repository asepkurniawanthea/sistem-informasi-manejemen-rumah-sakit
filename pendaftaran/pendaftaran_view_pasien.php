<?php
if (isset($_GET['nomr'])) {
    $nomr = $_GET['nomr'];
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
    ?>
   <div style=" height:auto; padding:15px; ">
		<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD; ">
        <?php
        include('pasien/pasien_view.php');
        ?>
    	</div>
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px;" align="right">
		<a href="index.php?link=<?php echo md5('pendaftarandatapasien'); ?>" >
		<input type="button" value="tutup" class="myButton" /></a>
		<?php if((currentModul() == 'rekam medik' or currentModul() == 'pendaftaran') and $_SESSION['SES_SIMRS_ADMIN'] == '1'){ ?>
		<a href="index.php?link=<?php echo md5('pendaftaranformeditpasien'); ?>&nomr=<?php echo $nomr; ?>" >
		<input type="button" value="ubah" class="myButton1" /></a>
		<?php } ?>
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
