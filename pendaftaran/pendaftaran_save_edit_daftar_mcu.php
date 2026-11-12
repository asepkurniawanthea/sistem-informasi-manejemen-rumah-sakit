<?php
include('lis/simrs2lis.php');

$irja_id = $_POST['irja_id'];
$ls_unit = $_POST['ls_unit_id'];
$batal = '0';
$st_edit = $_POST['st_edit'];
$nomor = '';
$no_pendaftaran = $_POST['no_pendaftaran'];
$ambil_resep = '';
if(isset($_POST['ambil_resep'])) $ambil_resep = $_POST['ambil_resep'];
$st_rujukan = '';

if(isset($_POST['st_batal'])){
$_err = '';
if (empty($_POST['keterangan_batal']))
    $_err = $_err . 'Keterangan Pembatalan Harus Diisi. \n';
	
	if(empty($_err)){
		$batal = '1';
		mysql_query('UPDATE t_irja SET ST_BATAL = "1",KETERANGAN_BATAL = "' . $_POST['keterangan_batal'] . '",
					USER_PENDAFTARAN = "' . $user_name . '"
					WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
					
		$sql_lab = 'SELECT NO_ORDER FROM t_ipenunjang WHERE RAWAT_ID = "' . $irja_id . '"
					AND MCU = "' . $ls_unit . '"';
		$get_lab = mysql_query($sql_lab) or die(mysql_error());
		$dat_lab = mysql_fetch_assoc($get_lab);	
		$no_order = $dat_lab['NO_ORDER'];

		if(mysql_num_rows($get_lab) > 0){
			lis_cancel_order($irja_id,$no_order);
		}
		
		$st_edit = '1';
	}
}else{
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
		
		$nama_pasien = $_POST['jkn_nama_pasien'];
		$tgl_lahir = $_POST['jkn_tgl_lahir'];
		$jns_kelamin = $_POST['jns_kelamin'];
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

	$st_rujukan = $_POST['st_rujukan'];
	$no_sjp = $_POST['no_sjp'];

	$_err = '';
	if (empty($unit_id))
		$_err = $_err . 'Paket MCU Harus Diisi. \n';
	if (empty($jenis_bayar_id))
		$_err = $_err . 'Jenis Pembayaran Harus Diisi. \n';
	if (!in_array($jenis_bayar_id,getArrNonJaminan())){	
		if (empty($no_peserta))
			$_err = $_err . 'Nomor Peserta Harus Diisi. \n';	
	}		
	if (empty($asal_pasien_id))
		$_err = $_err . 'Asal Pasien Harus Diisi. \n';	
	if ($asal_pasien_id != '1'){
		if (empty($ket_asal_pasien))
		$_err = $_err . 'Keterangan Asal Pasien Harus Diisi. \n';	
	}	

    $st_save = true;
	if (empty($_err)) {
    if (!empty($_POST['irja_id'])) {
		if($st_edit == '2'){
		$st_save = mysql_query('UPDATE t_irja SET UNIT_ID = "61",PEGAWAI_ID = "' . $pegawai_id . '",
						JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",ASAL_PASIEN_ID = "' . $asal_pasien_id . '",
						KET_ASAL_PASIEN = "' . $ket_asal_pasien . '",NO_PESERTA = "' . $no_peserta . '",NO_SEP = "' . $no_sep . '",NO_SJP = "' . $no_sjp . '",
						P_JAWAB_NAMA = "' . $p_jawab_nama . '",P_JAWAB_NO_TELP = "' . $p_jawab_no_telp . '",P_JAWAB_ALAMAT = "' . $p_jawab_alamat . '",P_JAWAB_ALAMAT_RT = "' . $p_jawab_alamat_rt . '",
						P_JAWAB_ALAMAT_RW = "' . $p_jawab_alamat_rw . '",P_JAWAB_KELURAHAN_ID = "' . $p_jawab_kelurahan_id . '",P_JAWAB_KECAMATAN_ID = "' . $p_jawab_kecamatan_id . '",
						P_JAWAB_KOTA_ID = "' . $p_jawab_kota_id . '",P_JAWAB_PROPINSI_ID = "' . $p_jawab_propinsi_id . '",P_JAWAB_HUBUNGAN = "' . $p_jawab_hubungan . '",
						USER_PENDAFTARAN = "' . $user_name . '",NO_PENDAFTARAN = "' . $no_pendaftaran . '",
						JKN_TGL_RUJUK = STR_TO_DATE("' . $jkn_tgl_rujuk . '","%d/%m/%Y"),JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",
						JKN_KD_PKK = "' . $jkn_kd_pkk . '",JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
						JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
						JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",
						JKN_COB = "' . $jkn_cob . '",JKN_KATARAK = "' . $jkn_katarak . '",
						JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",
						JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",
						JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '",
						MCU = "' . $unit_id . '",AMBIL_RESEP = "' . $ambil_resep . '"
						WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
				
			if($jenis_bayar_id == 12){
				if(!empty($nama_pasien) and !empty($tgl_lahir) and !empty($jns_kelamin)){
					mysql_query('UPDATE m_pasien SET JNS_KELAMIN = "' . $jns_kelamin . '",
					TGL_LAHIR = STR_TO_DATE("' . $tgl_lahir . '","%d/%m/%Y"),
					NAMA_PASIEN = "' . trim($nama_pasien) . '"
				WHERE NOMR = "' . $nomr . '"') or die(mysql_error());
				}
			}			
			
			if ($st_save) {
				$sql_lab = 'SELECT NO_ORDER FROM t_ipenunjang WHERE RAWAT_ID = "' . $irja_id . '"
					AND MCU = "' . $ls_unit . '"';
				$get_lab = mysql_query($sql_lab) or die(mysql_error());
				$dat_lab = mysql_fetch_assoc($get_lab);	
				$no_order_ca = $dat_lab['NO_ORDER'];

				if(mysql_num_rows($get_lab) > 0){
					lis_cancel_order($irja_id,$no_order_ca);
				}	
		
				mysql_query('DELETE FROM t_irja_tarif
							WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());			
							
				mysql_query('DELETE t_ipenunjang_tarif FROM t_ipenunjang_tarif 
					INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '"
					AND t_ipenunjang.JNS_ORDER = "IRJ"
					AND t_ipenunjang_tarif.ST_PERIKSA IS NULL
					AND t_ipenunjang_tarif.ST_DIAGNOSA IS NULL') or die(mysql_error());
					
				mysql_query('DELETE t_ipenunjang FROM t_ipenunjang  
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					WHERE RAWAT_ID = "' . $irja_id . '"
					AND JNS_ORDER = "IRJ"
					AND t_ipenunjang_tarif.ST_PERIKSA IS NULL
					AND t_ipenunjang_tarif.ST_DIAGNOSA IS NULL') or die(mysql_error());	
				 
			if($ambil_resep != '1'){
				 $arr_mcu_s = '"00000",';
				 $sql = 'SELECT KODE_TARIF FROM m_tarif WHERE TARIF_ID = "' . $unit_id . '"';
				 $get = mysql_query($sql) or die(mysql_error());
				 $dat = mysql_fetch_assoc($get);
				 $arr_mcu_s .= '"' . $dat['KODE_TARIF'] . '",';
				 $sql = 'SELECT KODE_TARIF FROM m_tarif WHERE KODE_TARIF LIKE "MCU' . $dat['KODE_TARIF'] . '%"';
				 $get = mysql_query($sql) or die(mysql_error());
				 while($dat = mysql_fetch_array($get)){
					$arr_mcu_s .= '"' . $dat['KODE_TARIF'] . '",'; 
				 }
				 $arr_mcu_s = substr($arr_mcu_s,0,strlen($arr_mcu_s) - 1);
			}else{
				$arr_mcu_s = '"01001"';
			}	
			
			$arr_tindakan = array();
			$arr_laboratorium = array();	
			$arr_radiologi = array();
			$arr_ekgusg = array();		
			
			$get_tarif = mysql_query('SELECT m_tarif.TARIF_ID,m_tarif.KODE_TARIF,m_tarif_group.LABORATORIUM,
						m_tarif_group.LABORATORIUM_CITO,m_tarif_group.RADIOLOGI,m_tarif_group.RADIOLOGI_CITO,
						m_tarif.UNIT_ID,m_tarif.NAMA_TARIF
						FROM m_tarif
						INNER JOIN m_tarif_group 
						ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE m_tarif.KODE_TARIF IN (' . $arr_mcu_s . ') 
						AND (m_tarif.MCU = "1" OR m_tarif.ST_AKTIF = "1")') or die(mysql_error());
						
			while($dat_tarif = mysql_fetch_array($get_tarif)){
				if($dat_tarif['LABORATORIUM'] == '' and $dat_tarif['LABORATORIUM_CITO'] == ''
					and $dat_tarif['RADIOLOGI'] == '' and $dat_tarif['RADIOLOGI_CITO'] == ''
					and ($dat_tarif['UNIT_ID'] == '' or $dat_tarif['UNIT_ID'] == '0')) array_push($arr_tindakan,$dat_tarif['TARIF_ID']);
					
				if($dat_tarif['LABORATORIUM'] == '1' or $dat_tarif['LABORATORIUM_CITO'] == '1' 
					or $dat_tarif['UNIT_ID'] == '45') array_push($arr_laboratorium,$dat_tarif['TARIF_ID']);
				if($dat_tarif['RADIOLOGI'] == '1' or $dat_tarif['RADIOLOGI_CITO'] == '1'
					or $dat_tarif['UNIT_ID'] == '17') array_push($arr_radiologi,$dat_tarif['TARIF_ID']);
				if($dat_tarif['UNIT_ID'] == '52') array_push($arr_ekgusg,$dat_tarif['TARIF_ID']); 	
			}
			
			$no_bayar = 'NULL';
			$st_bayar = 'NULL';
			if(in_array($jenis_bayar_id,getArrNonJaminan())){
				$no_bayar = '"' . getNomorHarian('Kasir') . '"';
				$st_bayar = '"Lunas"';
			}
			$nomor = getNomorHarian('Tarif');
			$tgl_tarif = 'STR_TO_DATE("' . $tgl_trans . '","%d/%m/%Y %H:%i:%s")';	
			$nomor_order = getNomorBulanan('IPENUNJANG');
			
			if(sizeof($arr_tindakan) > 0){
				foreach($arr_tindakan as $tarif){
					$kuantiti = '0';
					if($tarif == $unit_id) $kuantiti = '1';
					mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,
							DESKRIPSI,ST_BAYAR,JENIS_BAYAR_ID,USER_PENDAFTARAN,ST_PRINT)
							VALUES("' . $irja_id . '",' . $tgl_tarif . ',"' . $tarif . '","' . $kuantiti . '","' . $nomor . '", ' . $no_bayar . ',
							"Paket MCU",' . $st_bayar . ',"' . $jenis_bayar_id . '","' . $user_name . '",NULL)') or die(mysql_error());	
				}
			}	
			
			if(sizeof($arr_laboratorium) > 0){
				mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
								NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
								"LAB","IRJ","' . $irja_id . '","' . $nomor_order . '","Paket MCU",
								"' . $pegawai_id . '","' . $nomr . '",' . $tgl_tarif . ',"61","' . $user_name . '",
								"' . $jenis_bayar_id . '","' . $unit_id . '")') or die(mysql_error());
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "LAB" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
				$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
				$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
								
				foreach($arr_laboratorium as $tarif){
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_PRINT) 
						VALUES("' . $penunjang_id . '","' . $tarif . '",0,NULL)') or die(mysql_error());
				}
				
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = ' . $tgl_tarif . ',
									UNIT_PENUNJANG_ID = "45",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
									ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
									NO_PEMBAYARAN = ' . $no_bayar . ',
									SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_PENDAFTARAN = "' . $user_name . '",
									ST_TPP = "1",PEGAWAI_PERIKSA_ID = NULL,NO_SEP = "' . $no_sep . '",TANGGAL_SEP = ' . $tgl_tarif . ',
									NO_PESERTA = "' . $no_peserta . '",JKN_TGL_RUJUK = ' . fieldDate($jkn_tgl_rujuk) . ',
									JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",JKN_KD_PKK = "' . $jkn_kd_pkk . '",
									JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
									JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
									JKN_KELAS_RAWAT = NULL,JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",
									JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",
									JKN_PENJAMIN = "' . $jkn_penjamin . '",JKN_KATARAK = "' . $jkn_katarak . '",
									JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",
									JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '"
									WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
									
				lis_create_order($irja_id,$nomor_order,'IRJ');						
			}
			
			if(sizeof($arr_radiologi) > 0){
				mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
								NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
								"RAD","IRJ","' . $irja_id . '","' . $nomor_order . '","Paket MCU",
								"' . $pegawai_id . '","' . $nomr . '",' . $tgl_tarif . ',"61","' . $user_name . '",
								"' . $jenis_bayar_id . '","' . $unit_id . '")') or die(mysql_error());
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "RAD" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
				$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
				$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
								
				foreach($arr_radiologi as $tarif){
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_PRINT) 
						VALUES("' . $penunjang_id . '","' . $tarif . '",0,NULL)') or die(mysql_error());
				}
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = ' . $tgl_tarif . ',
									UNIT_PENUNJANG_ID = "17",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
									ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
									NO_PEMBAYARAN = ' . $no_bayar . ',
									SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_PENDAFTARAN = "' . $user_name . '",
									ST_TPP = "1",PEGAWAI_PERIKSA_ID = NULL,NO_SEP = "' . $no_sep . '",TANGGAL_SEP = ' . $tgl_tarif . ',
									NO_PESERTA = "' . $no_peserta . '",JKN_TGL_RUJUK = ' . fieldDate($jkn_tgl_rujuk) . ',
									JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",JKN_KD_PKK = "' . $jkn_kd_pkk . '",
									JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
									JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
									JKN_KELAS_RAWAT = NULL,JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",
									JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",
									JKN_PENJAMIN = "' . $jkn_penjamin . '",JKN_KATARAK = "' . $jkn_katarak . '",
									JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",
									JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '"
									WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
			}
			
			if(sizeof($arr_ekgusg) > 0){
				mysql_query('INSERT INTO t_ipenunjang(JNS_PENUNJANG,JNS_ORDER,RAWAT_ID,NO_ORDER,DESKRIPSI,PEGAWAI_ID,
								NOMR,TANGGAL_ORDER,UNIT_ID,USER_ORDER,JENIS_BAYAR_ID,MCU) VALUES(
								"EKG","IRJ","' . $irja_id . '","' . $nomor_order . '","Paket MCU",
								"' . $pegawai_id . '","' . $nomr . '",' . $tgl_tarif . ',"61","' . $user_name . '",
								"' . $jenis_bayar_id . '","' . $unit_id . '")') or die(mysql_error());
				$qry_penunjang_order = 'SELECT t_ipenunjang.PENUNJANG_ID
									FROM t_ipenunjang 
									WHERE t_ipenunjang.JNS_PENUNJANG = "EKG" AND t_ipenunjang.JNS_ORDER = "IRJ"
									AND t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.NO_ORDER = "' . $nomor_order . '"
									ORDER BY t_ipenunjang.PENUNJANG_ID DESC LIMIT 1';
				$get_penunjang_order = mysql_query($qry_penunjang_order) or die(mysql_error());				
				$dat_penunjang_order = mysql_fetch_assoc($get_penunjang_order);
				$penunjang_id = $dat_penunjang_order['PENUNJANG_ID'];				
								
				foreach($arr_ekgusg as $tarif){
					mysql_query('INSERT INTO t_ipenunjang_tarif(PENUNJANG_ID,TARIF_ID,KUANTITI,ST_PRINT) 
						VALUES("' . $penunjang_id . '","' . $tarif . '",0,NULL)') or die(mysql_error());
				}
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = ' . $tgl_tarif . ',
									UNIT_PENUNJANG_ID = "52",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
									ST_BAYAR = ' . $st_bayar . ',NO_TARIF = "' . $nomor . '",NO_SJP = "' . $no_sjp . '",
									NO_PEMBAYARAN = ' . $no_bayar . ',
									SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",USER_PENDAFTARAN = "' . $user_name . '",
									ST_TPP = "1",PEGAWAI_PERIKSA_ID = NULL,NO_SEP = "' . $no_sep . '",TANGGAL_SEP = ' . $tgl_tarif . ',
									NO_PESERTA = "' . $no_peserta . '",JKN_TGL_RUJUK = ' . fieldDate($jkn_tgl_rujuk) . ',
									JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",JKN_KD_PKK = "' . $jkn_kd_pkk . '",
									JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
									JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
									JKN_KELAS_RAWAT = NULL,JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",
									JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",
									JKN_PENJAMIN = "' . $jkn_penjamin . '",JKN_KATARAK = "' . $jkn_katarak . '",
									JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",
									JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '"
									WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());
			}
		}	
						
		}else if($st_edit == '1'){
		$st_save = mysql_query('UPDATE t_irja SET NO_PESERTA = "' . $no_peserta . '",NO_SEP = "' . $no_sep . '",
							P_JAWAB_NAMA = "' . $p_jawab_nama . '",P_JAWAB_NO_TELP = "' . $p_jawab_no_telp . '",P_JAWAB_ALAMAT = "' . $p_jawab_alamat . '",P_JAWAB_ALAMAT_RT = "' . $p_jawab_alamat_rt . '",
							P_JAWAB_ALAMAT_RW = "' . $p_jawab_alamat_rw . '",P_JAWAB_KELURAHAN_ID = "' . $p_jawab_kelurahan_id . '",P_JAWAB_KECAMATAN_ID = "' . $p_jawab_kecamatan_id . '",
							P_JAWAB_KOTA_ID = "' . $p_jawab_kota_id . '",P_JAWAB_PROPINSI_ID = "' . $p_jawab_propinsi_id . '",P_JAWAB_HUBUNGAN = "' . $p_jawab_hubungan . '",
							USER_PENDAFTARAN = "' . $user_name . '",
							JKN_TGL_RUJUK = STR_TO_DATE("' . $jkn_tgl_rujuk . '","%d/%m/%Y"),JKN_NO_RUJUK = "' . $jkn_no_rujuk . '",
							JKN_KD_PKK = "' . $jkn_kd_pkk . '",JKN_NAMA_PKK = "' . $jkn_nama_pkk . '",JKN_CATATAN = "' . $jkn_catatan . '",
							JKN_DIAGNOSA = "' . $jkn_diagnosa . '",JKN_POLIKLINIK = "' . $jkn_poliklinik . '",
							JKN_PBI_NONPBI = "' . $jkn_pbi_nonpbi . '",JKN_KELAS_RAWAT = "' . $jkn_kelas_rawat . '",
							JKN_ASAL_RUJUKAN = "' . $jkn_asal_rujukan . '",JKN_COB = "' . $jkn_cob . '",JKN_PENJAMIN = "' . $jkn_penjamin . '",
							JKN_KATARAK = "' . $jkn_katarak . '",JKN_SUPLESI = "' . $jkn_suplesi . '",JKN_NO_SEP_SUPLESI = "' . $jkn_nosep_suplesi . '",JKN_NOSURAT_SKDP = "' . $jkn_nosurat_skdp . '",
							JKN_DPJP_SKDP = "' . $jkn_dpjp_skdp . '",JKN_NAMA_DPJP_SKDP = "' . $jkn_nama_dpjp_skdp . '",
							JKN_SPESIALISASI_DPJP_SKDP = "' . $jkn_spesialis_dpjp_skdp . '",KD_LOKASI_KECELAKAAN_PROPINSI = "' . $kd_lokasi_kecelakaan_propinsi . '",
							NAMA_LOKASI_KECELAKAAN_PROPINSI = "' . $nama_lokasi_kecelakaan_propinsi . '",KD_LOKASI_KECELAKAAN_KABUPATEN = "' . $kd_lokasi_kecelakaan_kota . '",
							NAMA_LOKASI_KECELAKAAN_KABUPATEN = "' . $nama_lokasi_kecelakaan_kota . '",KD_LOKASI_KECELAKAAN_KECAMATAN = "' . $kd_lokasi_kecelakaan_kecamatan . '",
							NAMA_LOKASI_KECELAKAAN_KECAMATAN = "' . $nama_lokasi_kecelakaan_kecamatan . '",TGL_KEJADIAN_KECELAKAAN = STR_TO_DATE("' . $tgl_kejadian_kecelakaan . '","%d/%m/%Y"),
							KETERANGAN_KECELAKAAN = "' . $keterangan_kecelakaan . '",KECELAKAAN = "' . $pasien_kecelakaan . '"
							WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
			if($jenis_bayar_id == 12){
				if(!empty($nama_pasien) and !empty($tgl_lahir) and !empty($jns_kelamin)){
					mysql_query('UPDATE m_pasien SET JNS_KELAMIN = "' . $jns_kelamin . '",
					TGL_LAHIR = STR_TO_DATE("' . $tgl_lahir . '","%d/%m/%Y"),
					NAMA_PASIEN = "' . $nama_pasien . '"
				WHERE NOMR = "' . $nomr . '"') or die(mysql_error());
				}
			}
			
		}else if($st_edit == '3'){
			$sql_no = 'SELECT NO_TARIF FROM t_irja_tarif
						WHERE IRJA_ID = "' . $irja_id . '"';
			$get_no = mysql_query($sql_no) or die(mysql_error());
			$dat_no = mysql_fetch_assoc($get_no);
			$nomor = $dat_no['NO_TARIF'];
       }
    }
 }
}
if (empty($_err)) {
	$link = 'pendaftaranlistkunjungan';
        ?>
        <script language="JavaScript" >
		<?php if($st_edit != '1'){ ?>
		var p_sjp = 'no';
		var p_resep = 'no';
		var p_sep = 'no';
		if(confirm('Print Juga SJP?')){
		 p_sjp = 'yes';
		}
		<?php if($jenis_bayar_id == '12' and !empty($no_sep)){ ?>
		if(confirm('Print Juga SEP?')){
		 p_sep = 'yes';
		}
		<?php } ?>
		
		window.open('http://localhost/nsimrs_print/print_pembayaran_karcis_mcu.php?idx=<?php echo $irja_id; ?>&no=<?php echo $nomor; ?>&sjp=' + p_sjp + '&resep=' + p_resep + '&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220'); 
		<?php } ?>
		alert('Simpan Perubahan Data Kunjungan Berhasil.');
		window.location = "index.php?link=<?php echo md5($link); ?>";
        </script> 
        <?php
} else {
    $msg_info = $_err;
}
?>