<?php
$nomr = $_POST['nomr'];
$irja_id = $_POST['irja_id'];
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$no_peserta = $_POST['no_peserta'];

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
$jkn_katarak = '';
$jkn_suplesi = '';
$jkn_nosep_suplesi = '';
$jkn_nosurat_skdp = '';
$jkn_dpjp_skdp = '';
$jkn_nama_dpjp_skdp = '';
$jkn_spesialis_dpjp_skdp = '';

if($jenis_bayar_id != '12'){ 
	$unit_id = $_POST['unit_id'];
	$pegawai_id = $_POST['pegawai_id'];
	$asal_pasien_id = $_POST['asal_pasien_id'];
	$ket_asal_pasien = $_POST['ket_asal_pasien'];
	$no_sep = $_POST['no_sep'];
}else{
	
	$jkn_unit_id = $_POST['jkn_unit_id'];
	$unit_id = $jkn_unit_id;
	
	$pegawai_id = $_POST['jkn_pegawai_id'];
	$asal_pasien_id = '2';
	$ket_asal_pasien = '-';
	$no_sep = $_POST['jkn_no_sep'];
	
	$jkn_tgl_rujuk = $_POST['jkn_tgl_rujuk'];
	$jkn_no_rujuk = $_POST['jkn_no_rujuk'];
	$jkn_asal_rujukan = $_POST['jkn_asal_rujukan'];
	$arr_pkk = explode('--',$_POST['jkn_kd_pkk']);
	if(sizeof($arr_pkk) > 1){
		$jkn_kd_pkk = $arr_pkk[0];
		$jkn_nama_pkk = $arr_pkk[1];
	}	
	$arr_diagnosa = explode('--',$_POST['jkn_diagnosa']);
	if(sizeof($arr_diagnosa) > 1){
		$jkn_diagnosa = $arr_diagnosa[0]; 
	}
	$jkn_catatan = $_POST['jkn_catatan'];
	$jkn_pbi_nonpbi = $_POST['jkn_pbi_nonpbi'];
	if(isset($_POST['jkn_cob'])) $jkn_cob = $_POST['jkn_cob'];
	if(isset($_POST['jkn_katarak'])) $jkn_katarak = $_POST['jkn_katarak']; 
	$jkn_nosurat_skdp = $_POST['jkn_nosurat_skdp'];
	$arr_dpjp = explode('--',$_POST['jkn_dpjp_skdp']);
	if(sizeof($arr_dpjp) > 0){
		$jkn_dpjp_skdp = $arr_dpjp[0];
		$jkn_nama_dpjp_skdp = $arr_dpjp[1];
	}	
	$jkn_spesialis_dpjp_skdp = $_POST['spesialisasi_dpjp'];
}

if($jenis_bayar_id == '9' or $jenis_bayar_id == '14') $no_sep = $no_peserta;

$p_jawab_nama = $_POST['p_jawab_nama'];
$p_jawab_no_telp = $_POST['p_jawab_no_telp'];
$p_jawab_alamat = $_POST['p_jawab_alamat'];
$p_jawab_alamat_rt = $_POST['p_jawab_alamat_rt'];
$p_jawab_alamat_rw = $_POST['p_jawab_alamat_rw'];
$p_jawab_kelurahan_id = $_POST['p_jawab_kelurahan_id'];
$p_jawab_kecamatan_id = $_POST['p_jawab_kecamatan_id'];
$p_jawab_kota_id = $_POST['p_jawab_kota_id'];
$p_jawab_propinsi_id = $_POST['p_jawab_propinsi_id'];
$p_jawab_hubungan = $_POST['p_jawab_hubungan'];

$st_rujukan = 'NULL';
if($_POST['rujukan'] == '5') $st_rujukan = '"1"';
$st_karcis = '0';
if(!in_array($_POST['jenis_bayar_id_rujuk'],getArrNonJaminan()) 
	and in_array($jenis_bayar_id,getArrNonJaminan())) $st_karcis = '1';

$_err = '';
if (empty($unit_id))
    $_err = $_err . 'Klinik Tujuan Harus Diisi. \n';
if (empty($pegawai_id))
    $_err = $_err . 'Dokter Harus Diisi. \n';	
if (empty($jenis_bayar_id))
    $_err = $_err . 'Jenis Pembayaran Harus Diisi. \n';
if (!in_array($jenis_bayar_id,getArrNonJaminan())){	
	if (empty($no_peserta))
		$_err = $_err . 'Nomor Peserta Harus Diisi. \n';	
	//if (empty($no_sep))
		//$_err = $_err . 'Nomor SEP Harus Diisi. \n';
}		
if (empty($asal_pasien_id))
	$_err = $_err . 'Asal Pasien Harus Diisi. \n';	
if ($asal_pasien_id != '1'){
	if (empty($ket_asal_pasien))
	$_err = $_err . 'Keterangan Asal Pasien Harus Diisi. \n';	
}	

    $st_save = true;
	if (empty($_err)) {
    if (empty($_POST['irja_id'])) {
		$no_sjp = getNomorHarian('SJP');
		$no_pendaftaran = getNomorBulanan('IRJA');
        $st_save = mysql_query('INSERT INTO t_irja(NOMR,TANGGAL_DAFTAR,UNIT_ID,PEGAWAI_ID,JENIS_BAYAR_ID,
								NO_PESERTA,NO_SEP,NO_SJP,ASAL_PASIEN_ID,KET_ASAL_PASIEN,
								P_JAWAB_NAMA,P_JAWAB_NO_TELP,P_JAWAB_ALAMAT,P_JAWAB_ALAMAT_RT,P_JAWAB_ALAMAT_RW,
								P_JAWAB_KELURAHAN_ID,P_JAWAB_KECAMATAN_ID,P_JAWAB_KOTA_ID,P_JAWAB_PROPINSI_ID,
								P_JAWAB_HUBUNGAN,NO_PENDAFTARAN,SHIFT_ID,ST_RUJUKAN,USER_PENDAFTARAN,
								JKN_TGL_RUJUK,JKN_NO_RUJUK,
								JKN_KD_PKK,JKN_NAMA_PKK,
								JKN_CATATAN,JKN_DIAGNOSA,
								JKN_POLIKLINIK,JKN_KELAS_RAWAT,
								JKN_PBI_NONPBI,JKN_ASAL_RUJUKAN,JKN_COB,
								JKN_KATARAK,JKN_NOSURAT_SKDP,JKN_DPJP_SKDP,
								JKN_NAMA_DPJP_SKDP,JKN_SPESIALISASI_DPJP_SKDP)
								VALUES("' . $nomr . '",NOW(),"' . $unit_id . '","' . $pegawai_id . '","' . $jenis_bayar_id . '",
								"' . $no_peserta . '","' . $no_sep . '","' . $no_sjp . '","' . $asal_pasien_id . '","' . $ket_asal_pasien . '",
								"' . $p_jawab_nama . '","' . $p_jawab_no_telp . '","' . $p_jawab_alamat . '","' . $p_jawab_alamat_rt . '","' . $p_jawab_alamat_rw . '",
								"' . $p_jawab_kelurahan_id . '","' . $p_jawab_kecamatan_id . '","' . $p_jawab_kota_id . '","' . $p_jawab_propinsi_id . '",
								"' . $p_jawab_hubungan . '","' . $no_pendaftaran . '","' . $_SESSION['SES_SIMRS_SHIFT'] . '",' . $st_rujukan . ',"' . $user_name . '",
								STR_TO_DATE("' . $jkn_tgl_rujuk . '","%d/%m/%Y"),"' . $jkn_no_rujuk . '",
								"' . $jkn_kd_pkk . '","' . $jkn_nama_pkk . '",
								"' . $jkn_catatan . '","' . $jkn_diagnosa . '",
								"' . $jkn_poliklinik . '","' . $jkn_kelas_rawat . '",
								"' . $jkn_pbi_nonpbi . '","' . $jkn_asal_rujukan . '","' . $jkn_cob . '",
								"' . $jkn_katarak . '","' . $jkn_nosurat_skdp . '","' . $jkn_dpjp_skdp . '",
								"' . $jkn_nama_dpjp_skdp . '","' . $jkn_spesialis_dpjp_skdp . '"
								)') or die(mysql_error());
        if ($st_save) {
			$sql_daftar = 'SELECT IRJA_ID FROM t_irja WHERE NOMR = "' . $nomr . '" ORDER BY IRJA_ID DESC';
			$get_daftar = mysql_query($sql_daftar) or die(mysql_error());
			$dat_daftar = mysql_fetch_assoc($get_daftar);
			$irja_id = $dat_daftar['IRJA_ID']; 
			
			//edoc rekam medic
			/*include('edoc_rekammedik/edoc_main.php');
			create_pdf_identitas($irja_id,'RJ');
			create_pdf_ringkasan_kunjungan_rawat_jalan($irja_id);*/
			//	
            
			$no_bayar = 'NULL';
			$st_bayar = 'NULL';
			if(!in_array($jenis_bayar_id,getArrNonJaminan())){
				$no_bayar = '"' . getNomorHarian('Kasir') . '"';
				$st_bayar = '"Lunas"';
			}
			$nomor = getNomorHarian('Tarif');
			//karcis
			if($st_karcis == '1'){
				$kode_tarif = '01001';
				$sql_tarif_karcis = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tarif . '" AND ST_AKTIF = "1"';
				$get_tarif_karcis = mysql_query($sql_tarif_karcis) or die(mysql_error());
				$dat_tarif_karcis = mysql_fetch_assoc($get_tarif_karcis);
				$tarif_karcis_id = $dat_tarif_karcis['TARIF_ID'];
				mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,
						ST_BAYAR,JENIS_BAYAR_ID,USER_PENDAFTARAN,ST_PRINT)
						VALUES("' . $irja_id . '",NOW(),"' . $tarif_karcis_id . '",1,"' . $nomor . '", ' . $no_bayar . ',
						"Karcis & Konsultasi",' . $st_bayar . ',"' . $jenis_bayar_id . '","' . $user_name . '",NULL)') or die(mysql_error());	
			}		
			//konsultasi
			$sql_dokter_tipe = 'SELECT TIPE_PEGAWAI_ID FROM m_pegawai WHERE PEGAWAI_ID = "' . $pegawai_id . '"';
			$get_dokter_tipe = mysql_query($sql_dokter_tipe) or die(mysql_error());
			$dat_dokter_tipe = mysql_fetch_assoc($get_dokter_tipe);
			$dokter_tipe = $dat_dokter_tipe['TIPE_PEGAWAI_ID']; 
			if(in_array($unit_id,getArrUnitIGD())){
					if($dokter_tipe == '2'){
						$kode_tarif_konsul = '09001';
					}else{
						$kode_tarif_konsul = '09002';
					}
			}else if(in_array($unit_id,getArrIrjaEksekutif())){
					if($dokter_tipe == '1'){
						$kode_tarif_konsul = '93002';
					}else if($dokter_tipe == '2'){
						$kode_tarif_konsul = '93001';
					}else if($dokter_tipe == '3'){
						$kode_tarif_konsul = '93003';
					}else if($dokter_tipe == '4'){
						$kode_tarif_konsul = '93004';
					}
			}else{
					if($dokter_tipe == '1'){
						$kode_tarif_konsul = '02002';
					}else if($dokter_tipe == '2'){
						$kode_tarif_konsul = '02001';
					}else if($dokter_tipe == '3'){
						$kode_tarif_konsul = '02003';
					}else if($dokter_tipe == '4'){
						$kode_tarif_konsul = '02004';
					}else if($dokter_tipe == '9'){
						$kode_tarif_konsul = '02005';
					}
			}
			$sql_tarif_konsul = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tarif_konsul . '" AND ST_AKTIF = "1"';
			$get_tarif_konsul = mysql_query($sql_tarif_konsul) or die(mysql_error());
			$dat_tarif_konsul = mysql_fetch_assoc($get_tarif_konsul);
			$tarif_konsul_id = $dat_tarif_konsul['TARIF_ID'];
			mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,
						ST_BAYAR,JENIS_BAYAR_ID,USER_PENDAFTARAN,ST_PRINT)
						VALUES("' . $irja_id . '",NOW(),"' . $tarif_konsul_id . '",1,"' . $nomor . '", ' . $no_bayar . ',
						"Konsultasi",' . $st_bayar . ',"' . $jenis_bayar_id . '","' . $user_name . '",NULL)') or die(mysql_error());	
			}
    }
}
if (empty($_err)) {
	$link = 'pendaftaranpasienrujuk';
    ?>
        <script language="JavaScript" >
		var p_sjp = 'no';
		var p_resep = 'no';
		var p_sep = 'no';
		//if(confirm('Print Juga SJP?')){
		 p_sjp = 'yes';
		//}
		<?php if($jenis_bayar_id == '12' and $jenis_bayar_id_rujuk != '12' and !empty($no_sep)){ ?>
		if(confirm('Print Juga SEP?')){
		 p_sep = 'yes';
		}
		<?php } ?>
		window.open('http://localhost/nsimrs_print/print_pembayaran_karcis.php?idx=<?php echo $irja_id; ?>&no=<?php echo $nomor; ?>&sjp=' + p_sjp + '&resep=' + p_resep + '&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
		window.location = "index.php?link=<?php echo md5($link); ?>";
        </script> 
        <?php
} else {
    $msg_info = $_err;
}
?>