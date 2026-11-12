<?php
$irja_rencana_pulang_id = $_POST['irja_rencana_pulang_id'];
$jns_order = $_POST['jns_order'];

$obat_lanjut_nama = '';
if(isset($_POST['obat_lanjut_nama'])) $obat_lanjut_nama = $_POST['obat_lanjut_nama'];
$obat_lanjut_jumlah = '';
if(isset($_POST['obat_lanjut_jumlah'])) $obat_lanjut_jumlah = $_POST['obat_lanjut_jumlah'];
$obat_lanjut_waktu = '';
if(isset($_POST['obat_lanjut_waktu'])) $obat_lanjut_waktu = $_POST['obat_lanjut_waktu'];
$obat_lanjut_cara = '';
if(isset($_POST['obat_lanjut_cara'])) $obat_lanjut_cara = $_POST['obat_lanjut_cara'];
$lingkungan_air_bersih = '';
if(isset($_POST['lingkungan_air_bersih'])) $lingkungan_air_bersih = $_POST['lingkungan_air_bersih'];
$lingkungan_ventilasi = '';
if(isset($_POST['lingkungan_ventilasi'])) $lingkungan_ventilasi = $_POST['lingkungan_ventilasi'];
$lingkungan_fasilitas = '';
if(isset($_POST['lingkungan_fasilitas'])) $lingkungan_fasilitas = $_POST['lingkungan_fasilitas'];
$lingkungan_keterampilan_rawat_luka = '';
if(isset($_POST['lingkungan_keterampilan_rawat_luka'])) $lingkungan_keterampilan_rawat_luka = $_POST['lingkungan_keterampilan_rawat_luka'];
$lingkungan_keterampilan_injeksi = '';
if(isset($_POST['lingkungan_keterampilan_injeksi'])) $lingkungan_keterampilan_injeksi = $_POST['lingkungan_keterampilan_injeksi'];
$lingkungan_keterampilan_perawatan_bayi = '';
if(isset($_POST['lingkungan_keterampilan_perawatan_bayi'])) $lingkungan_keterampilan_perawatan_bayi = $_POST['lingkungan_keterampilan_perawatan_bayi'];
$lingkungan_keterampilan_lainnya = '';
if(isset($_POST['lingkungan_keterampilan_lainnya'])) $lingkungan_keterampilan_lainnya = $_POST['lingkungan_keterampilan_lainnya'];
$lingkungan_keterampilan_lainnya_ket = $_POST['lingkungan_keterampilan_lainnya_ket'];
$lingkungan_faskes = '';
if(isset($_POST['lingkungan_faskes'])) $lingkungan_faskes = $_POST['lingkungan_faskes'];
$home_care_makan = '';
if(isset($_POST['home_care_makan'])) $home_care_makan = $_POST['home_care_makan'];
$home_care_minum = '';
if(isset($_POST['home_care_minum'])) $home_care_minum = $_POST['home_care_minum'];
$home_care_mandi = '';
if(isset($_POST['home_care_mandi'])) $home_care_mandi = $_POST['home_care_mandi'];
$home_care_bak = '';
if(isset($_POST['home_care_bak'])) $home_care_bak = $_POST['home_care_bak'];
$home_care_bab = '';
if(isset($_POST['home_care_bab'])) $home_care_bab = $_POST['home_care_bab'];
$home_care_berpakaian = '';
if(isset($_POST['home_care_berpakaian'])) $home_care_berpakaian = $_POST['home_care_berpakaian'];
$home_care_alatbantu_tongkat = '';
if(isset($_POST['home_care_alatbantu_tongkat'])) $home_care_alatbantu_tongkat = $_POST['home_care_alatbantu_tongkat'];
$home_care_alatbantu_kursi = '';
if(isset($_POST['home_care_alatbantu_kursi'])) $home_care_alatbantu_kursi = $_POST['home_care_alatbantu_kursi'];
$home_care_alatbantu_walker = '';
if(isset($_POST['home_care_alatbantu_walker'])) $home_care_alatbantu_walker = $_POST['home_care_alatbantu_walker'];
$home_care_alatmedis_kateterurine = '';
if(isset($_POST['home_care_alatmedis_kateterurine'])) $home_care_alatmedis_kateterurine = $_POST['home_care_alatmedis_kateterurine'];
$home_care_alatmedis_ngt = '';
if(isset($_POST['home_care_alatmedis_ngt'])) $home_care_alatmedis_ngt = $_POST['home_care_alatmedis_ngt'];
$home_care_alatmedis_oksigen = '';
if(isset($_POST['home_care_alatmedis_oksigen'])) $home_care_alatmedis_oksigen = $_POST['home_care_alatmedis_oksigen'];
$home_care_alatmedis_lainnya = '';
if(isset($_POST['home_care_alatmedis_lainnya'])) $home_care_alatmedis_lainnya = $_POST['home_care_alatmedis_lainnya'];
$home_care_alatmedis_lainnya_ket = $_POST['home_care_alatmedis_lainnya_ket'];
$edukasi_obat = '';
if(isset($_POST['edukasi_obat'])) $edukasi_obat = $_POST['edukasi_obat'];
$edukasi_nyeri = '';
if(isset($_POST['edukasi_nyeri'])) $edukasi_nyeri = $_POST['edukasi_nyeri'];
$edukasi_diet = '';
if(isset($_POST['edukasi_diet'])) $edukasi_diet = $_POST['edukasi_diet'];
$edukasi_caritolong = '';
if(isset($_POST['edukasi_caritolong'])) $edukasi_caritolong = $_POST['edukasi_caritolong'];
$edukasi_perawatan = '';
if(isset($_POST['edukasi_perawatan'])) $edukasi_perawatan = $_POST['edukasi_perawatan'];
$edukasi_lainnya = '';
if(isset($_POST['edukasi_lainnya'])) $edukasi_lainnya = $_POST['edukasi_lainnya'];
$edukasi_lainnya_ket = $_POST['edukasi_lainnya_ket'];
$faskes_puskesmas = '';
if(isset($_POST['faskes_puskesmas'])) $faskes_puskesmas = $_POST['faskes_puskesmas'];
$faskes_rs = '';
if(isset($_POST['faskes_rs'])) $faskes_rs = $_POST['faskes_rs'];
$faskes_klinik = '';
if(isset($_POST['faskes_klinik'])) $faskes_klinik = $_POST['faskes_klinik'];
$faskes_dokter_keluarga = '';
if(isset($_POST['faskes_dokter_keluarga'])) $faskes_dokter_keluarga = $_POST['faskes_dokter_keluarga'];
$faskes_rumah_rawat = '';
if(isset($_POST['faskes_rumah_rawat'])) $faskes_rumah_rawat = $_POST['faskes_rumah_rawat'];
$faskes_bidan_praktek = '';
if(isset($_POST['faskes_bidan_praktek'])) $faskes_bidan_praktek = $_POST['faskes_bidan_praktek'];
$faskes_lainnya = '';
if(isset($_POST['faskes_lainnya'])) $faskes_lainnya = $_POST['faskes_lainnya'];
$faskes_lainnya_ket = $_POST['faskes_lainnya_ket'];
$diet_jenis = '';
if(isset($_POST['diet_jenis'])) $diet_jenis = $_POST['diet_jenis'];
$diet_jumlah = '';
if(isset($_POST['diet_jumlah'])) $diet_jumlah = $_POST['diet_jumlah'];
$diet_waktu = '';
if(isset($_POST['diet_waktu'])) $diet_waktu = $_POST['diet_waktu'];
$transportasi_ambulance = '';
if(isset($_POST['transportasi_ambulance'])) $transportasi_ambulance = $_POST['transportasi_ambulance'];
$transportasi_pribadi = '';
if(isset($_POST['transportasi_pribadi'])) $transportasi_pribadi = $_POST['transportasi_pribadi'];
$transportasi_umum = '';
if(isset($_POST['transportasi_umum'])) $transportasi_umum = $_POST['transportasi_umum'];
$yayasan_jantung = '';
if(isset($_POST['yayasan_jantung'])) $yayasan_jantung = $_POST['yayasan_jantung'];
$yayasan_stroke = '';
if(isset($_POST['yayasan_stroke'])) $yayasan_stroke = $_POST['yayasan_stroke'];
$yayasan_lainnya = '';
if(isset($_POST['yayasan_lainnya'])) $yayasan_lainnya = $_POST['yayasan_lainnya'];
$yayasan_lainnya_ket = $_POST['yayasan_lainnya_ket'];
$rencana_tindak_lanjut = $_POST['rencana_tindak_lanjut'];

$_err = '';
if (empty($_err)) {
	if(empty($jns_order)){	
		$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
		$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
		$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
		if (empty($dat_cek_no_klinik['NO_KLINIK'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {	
			if(empty($irja_rencana_pulang_id)){
				mysql_query('INSERT INTO t_irja_rencana_pulang (IRJA_RENCANA_PULANG_ID,OBAT_LANJUT_NAMA,OBAT_LANJUT_JUMLAH,OBAT_LANJUT_WAKTU,
						OBAT_LANJUT_CARA,LINGKUNGAN_AIR_BERSIH,LINGKUNGAN_VENTILASI,LINGKUNGAN_FASILITAS,LINGKUNGAN_KETERAMPILAN_RAWAT_LUKA,
						LINGKUNGAN_KETERAMPILAN_INJEKSI,LINGKUNGAN_KETERAMPILAN_PERAWATAN_BAYI,LINGKUNGAN_KETERAMPILAN_LAINNYA,
						LINGKUNGAN_KETERAMPILAN_LAINNYA_KET,LINGKUNGAN_FASKES,HOME_CARE_MAKAN,HOME_CARE_MINUM,HOME_CARE_MANDI,HOME_CARE_BAK,
						HOME_CARE_BAB,HOME_CARE_BERPAKAIAN,HOME_CARE_ALATBANTU_TONGKAT,HOME_CARE_ALATBANTU_KURSI,HOME_CARE_ALATBANTU_WALKER,
						HOME_CARE_ALATMEDIS_KATETERURINE,HOME_CARE_ALATMEDIS_NGT,HOME_CARE_ALATMEDIS_OKSIGEN,HOME_CARE_ALATMEDIS_LAINNYA,
						HOME_CARE_ALATMEDIS_LAINNYA_KET,EDUKASI_OBAT,EDUKASI_NYERI,EDUKASI_DIET,EDUKASI_CARITOLONG,EDUKASI_PERAWATAN,
						EDUKASI_LAINNYA,EDUKASI_LAINNYA_KET,FASKES_PUSKESMAS,FASKES_RS,FASKES_KLINIK,FASKES_DOKTER_KELUARGA,FASKES_RUMAH_RAWAT,
						FASKES_BIDAN_PRAKTEK,FASKES_LAINNYA,FASKES_LAINNYA_KET,DIET_JENIS,DIET_JUMLAH,DIET_WAKTU,TRANSPORTASI_AMBULANCE,
						TRANSPORTASI_PRIBADI,TRANSPORTASI_UMUM,YAYASAN_JANTUNG,YAYASAN_STROKE,YAYASAN_LAINNYA,YAYASAN_LAINNYA_KET,
						RENCANA_TINDAK_LANJUT) VALUES ("'.$irja_id.'","'.$obat_lanjut_nama.'","'.$obat_lanjut_jumlah.'","'.$obat_lanjut_waktu.'",
						"'.$obat_lanjut_cara.'","'.$lingkungan_air_bersih.'","'.$lingkungan_ventilasi.'","'.$lingkungan_fasilitas.'",
						"'.$lingkungan_keterampilan_rawat_luka.'","'.$lingkungan_keterampilan_injeksi.'","'.$lingkungan_keterampilan_perawatan_bayi.'",
						"'.$lingkungan_keterampilan_lainnya.'","'.$lingkungan_keterampilan_lainnya_ket.'","'.$lingkungan_faskes.'",
						"'.$home_care_makan.'","'.$home_care_minum.'","'.$home_care_mandi.'","'.$home_care_bak.'","'.$home_care_bab.'",
						"'.$home_care_berpakaian.'","'.$home_care_alatbantu_tongkat.'","'.$home_care_alatbantu_kursi.'","'.$home_care_alatbantu_walker.'",
						"'.$home_care_alatmedis_kateterurine.'","'.$home_care_alatmedis_ngt.'","'.$home_care_alatmedis_oksigen.'",
						"'.$home_care_alatmedis_lainnya.'","'.$home_care_alatmedis_lainnya_ket.'","'.$edukasi_obat.'","'.$edukasi_nyeri.'",
						"'.$edukasi_diet.'","'.$edukasi_caritolong.'","'.$edukasi_perawatan.'","'.$edukasi_lainnya.'","'.$edukasi_lainnya_ket.'",
						"'.$faskes_puskesmas.'","'.$faskes_rs.'","'.$faskes_klinik.'","'.$faskes_dokter_keluarga.'","'.$faskes_rumah_rawat.'",
						"'.$faskes_bidan_praktek.'","'.$faskes_lainnya.'","'.$faskes_lainnya_ket.'","'.$diet_jenis.'","'.$diet_jumlah.'",
						"'.$diet_waktu.'","'.$transportasi_ambulance.'","'.$transportasi_pribadi.'","'.$transportasi_umum.'","'.$yayasan_jantung.'",
						"'.$yayasan_stroke.'","'.$yayasan_lainnya.'","'.$yayasan_lainnya_ket.'","'.$rencana_tindak_lanjut.'")') or die(mysql_error());	
			}else{
				mysql_query('UPDATE t_irja_rencana_pulang SET OBAT_LANJUT_NAMA = "'.$obat_lanjut_nama.'",OBAT_LANJUT_JUMLAH = "'.$obat_lanjut_jumlah.'",
						OBAT_LANJUT_WAKTU = "'.$obat_lanjut_waktu.'",OBAT_LANJUT_CARA = "'.$obat_lanjut_cara.'",
						LINGKUNGAN_AIR_BERSIH = "'.$lingkungan_air_bersih.'",LINGKUNGAN_VENTILASI = "'.$lingkungan_ventilasi.'",
						LINGKUNGAN_FASILITAS = "'.$lingkungan_fasilitas.'",LINGKUNGAN_KETERAMPILAN_RAWAT_LUKA = "'.$lingkungan_keterampilan_rawat_luka.'",
						LINGKUNGAN_KETERAMPILAN_INJEKSI = "'.$lingkungan_keterampilan_injeksi.'",
						LINGKUNGAN_KETERAMPILAN_PERAWATAN_BAYI = "'.$lingkungan_keterampilan_perawatan_bayi.'",
						LINGKUNGAN_KETERAMPILAN_LAINNYA = "'.$lingkungan_keterampilan_lainnya.'",
						LINGKUNGAN_KETERAMPILAN_LAINNYA_KET = "'.$lingkungan_keterampilan_lainnya_ket.'",LINGKUNGAN_FASKES = "'.$lingkungan_faskes.'",
						HOME_CARE_MAKAN = "'.$home_care_makan.'",HOME_CARE_MINUM = "'.$home_care_minum.'",HOME_CARE_MANDI = "'.$home_care_mandi.'",
						HOME_CARE_BAK = "'.$home_care_bak.'",HOME_CARE_BAB = "'.$home_care_bab.'",HOME_CARE_BERPAKAIAN = "'.$home_care_berpakaian.'",
						HOME_CARE_ALATBANTU_TONGKAT = "'.$home_care_alatbantu_tongkat.'",HOME_CARE_ALATBANTU_KURSI = "'.$home_care_alatbantu_kursi.'",
						HOME_CARE_ALATBANTU_WALKER = "'.$home_care_alatbantu_walker.'",
						HOME_CARE_ALATMEDIS_KATETERURINE = "'.$home_care_alatmedis_kateterurine.'",HOME_CARE_ALATMEDIS_NGT = "'.$home_care_alatmedis_ngt.'",
						HOME_CARE_ALATMEDIS_OKSIGEN = "'.$home_care_alatmedis_oksigen.'",HOME_CARE_ALATMEDIS_LAINNYA = "'.$home_care_alatmedis_lainnya.'",
						HOME_CARE_ALATMEDIS_LAINNYA_KET = "'.$home_care_alatmedis_lainnya_ket.'",EDUKASI_OBAT = "'.$edukasi_obat.'",
						EDUKASI_NYERI = "'.$edukasi_nyeri.'",EDUKASI_DIET = "'.$edukasi_diet.'",EDUKASI_CARITOLONG = "'.$edukasi_caritolong.'",
						EDUKASI_PERAWATAN = "'.$edukasi_perawatan.'",EDUKASI_LAINNYA = "'.$edukasi_lainnya.'",
						EDUKASI_LAINNYA_KET = "'.$edukasi_lainnya_ket.'",FASKES_PUSKESMAS = "'.$faskes_puskesmas.'",FASKES_RS = "'.$faskes_rs.'",
						FASKES_KLINIK = "'.$faskes_klinik.'",FASKES_DOKTER_KELUARGA = "'.$faskes_dokter_keluarga.'",
						FASKES_RUMAH_RAWAT = "'.$faskes_rumah_rawat.'",FASKES_BIDAN_PRAKTEK = "'.$faskes_bidan_praktek.'",
						FASKES_LAINNYA = "'.$faskes_lainnya.'",FASKES_LAINNYA_KET = "'.$faskes_lainnya_ket.'",DIET_JENIS = "'.$diet_jenis.'",
						DIET_JUMLAH = "'.$diet_jumlah.'",DIET_WAKTU = "'.$diet_waktu.'",TRANSPORTASI_AMBULANCE = "'.$transportasi_ambulance.'",
						TRANSPORTASI_PRIBADI = "'.$transportasi_pribadi.'",TRANSPORTASI_UMUM = "'.$transportasi_umum.'",
						YAYASAN_JANTUNG = "'.$yayasan_jantung.'",YAYASAN_STROKE = "'.$yayasan_stroke.'",YAYASAN_LAINNYA = "'.$yayasan_lainnya.'",
						YAYASAN_LAINNYA_KET = "'.$yayasan_lainnya_ket.'",RENCANA_TINDAK_LANJUT = "'.$rencana_tindak_lanjut.'"	
						WHERE IRJA_RENCANA_PULANG_ID = "'.$irja_rencana_pulang_id.'"') or die(mysql_error());
			}	
		}	
	}else{
		$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $irja_id . '"';
		$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
		$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
		if (empty($dat_cek_no_klinik['NO_KLINIK'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {	
			if(empty($irja_rencana_pulang_id)){
				mysql_query('INSERT INTO t_hemodialisa_rencana_pulang (HEMODIALISA_RENCANA_PULANG_ID,OBAT_LANJUT_NAMA,OBAT_LANJUT_JUMLAH,OBAT_LANJUT_WAKTU,
						OBAT_LANJUT_CARA,LINGKUNGAN_AIR_BERSIH,LINGKUNGAN_VENTILASI,LINGKUNGAN_FASILITAS,LINGKUNGAN_KETERAMPILAN_RAWAT_LUKA,
						LINGKUNGAN_KETERAMPILAN_INJEKSI,LINGKUNGAN_KETERAMPILAN_PERAWATAN_BAYI,LINGKUNGAN_KETERAMPILAN_LAINNYA,
						LINGKUNGAN_KETERAMPILAN_LAINNYA_KET,LINGKUNGAN_FASKES,HOME_CARE_MAKAN,HOME_CARE_MINUM,HOME_CARE_MANDI,HOME_CARE_BAK,
						HOME_CARE_BAB,HOME_CARE_BERPAKAIAN,HOME_CARE_ALATBANTU_TONGKAT,HOME_CARE_ALATBANTU_KURSI,HOME_CARE_ALATBANTU_WALKER,
						HOME_CARE_ALATMEDIS_KATETERURINE,HOME_CARE_ALATMEDIS_NGT,HOME_CARE_ALATMEDIS_OKSIGEN,HOME_CARE_ALATMEDIS_LAINNYA,
						HOME_CARE_ALATMEDIS_LAINNYA_KET,EDUKASI_OBAT,EDUKASI_NYERI,EDUKASI_DIET,EDUKASI_CARITOLONG,EDUKASI_PERAWATAN,
						EDUKASI_LAINNYA,EDUKASI_LAINNYA_KET,FASKES_PUSKESMAS,FASKES_RS,FASKES_KLINIK,FASKES_DOKTER_KELUARGA,FASKES_RUMAH_RAWAT,
						FASKES_BIDAN_PRAKTEK,FASKES_LAINNYA,FASKES_LAINNYA_KET,DIET_JENIS,DIET_JUMLAH,DIET_WAKTU,TRANSPORTASI_AMBULANCE,
						TRANSPORTASI_PRIBADI,TRANSPORTASI_UMUM,YAYASAN_JANTUNG,YAYASAN_STROKE,YAYASAN_LAINNYA,YAYASAN_LAINNYA_KET,
						RENCANA_TINDAK_LANJUT) VALUES ("'.$irja_id.'","'.$obat_lanjut_nama.'","'.$obat_lanjut_jumlah.'","'.$obat_lanjut_waktu.'",
						"'.$obat_lanjut_cara.'","'.$lingkungan_air_bersih.'","'.$lingkungan_ventilasi.'","'.$lingkungan_fasilitas.'",
						"'.$lingkungan_keterampilan_rawat_luka.'","'.$lingkungan_keterampilan_injeksi.'","'.$lingkungan_keterampilan_perawatan_bayi.'",
						"'.$lingkungan_keterampilan_lainnya.'","'.$lingkungan_keterampilan_lainnya_ket.'","'.$lingkungan_faskes.'",
						"'.$home_care_makan.'","'.$home_care_minum.'","'.$home_care_mandi.'","'.$home_care_bak.'","'.$home_care_bab.'",
						"'.$home_care_berpakaian.'","'.$home_care_alatbantu_tongkat.'","'.$home_care_alatbantu_kursi.'","'.$home_care_alatbantu_walker.'",
						"'.$home_care_alatmedis_kateterurine.'","'.$home_care_alatmedis_ngt.'","'.$home_care_alatmedis_oksigen.'",
						"'.$home_care_alatmedis_lainnya.'","'.$home_care_alatmedis_lainnya_ket.'","'.$edukasi_obat.'","'.$edukasi_nyeri.'",
						"'.$edukasi_diet.'","'.$edukasi_caritolong.'","'.$edukasi_perawatan.'","'.$edukasi_lainnya.'","'.$edukasi_lainnya_ket.'",
						"'.$faskes_puskesmas.'","'.$faskes_rs.'","'.$faskes_klinik.'","'.$faskes_dokter_keluarga.'","'.$faskes_rumah_rawat.'",
						"'.$faskes_bidan_praktek.'","'.$faskes_lainnya.'","'.$faskes_lainnya_ket.'","'.$diet_jenis.'","'.$diet_jumlah.'",
						"'.$diet_waktu.'","'.$transportasi_ambulance.'","'.$transportasi_pribadi.'","'.$transportasi_umum.'","'.$yayasan_jantung.'",
						"'.$yayasan_stroke.'","'.$yayasan_lainnya.'","'.$yayasan_lainnya_ket.'","'.$rencana_tindak_lanjut.'")') or die(mysql_error());	
			}else{
				mysql_query('UPDATE t_hemodialisa_rencana_pulang SET OBAT_LANJUT_NAMA = "'.$obat_lanjut_nama.'",OBAT_LANJUT_JUMLAH = "'.$obat_lanjut_jumlah.'",
						OBAT_LANJUT_WAKTU = "'.$obat_lanjut_waktu.'",OBAT_LANJUT_CARA = "'.$obat_lanjut_cara.'",
						LINGKUNGAN_AIR_BERSIH = "'.$lingkungan_air_bersih.'",LINGKUNGAN_VENTILASI = "'.$lingkungan_ventilasi.'",
						LINGKUNGAN_FASILITAS = "'.$lingkungan_fasilitas.'",LINGKUNGAN_KETERAMPILAN_RAWAT_LUKA = "'.$lingkungan_keterampilan_rawat_luka.'",
						LINGKUNGAN_KETERAMPILAN_INJEKSI = "'.$lingkungan_keterampilan_injeksi.'",
						LINGKUNGAN_KETERAMPILAN_PERAWATAN_BAYI = "'.$lingkungan_keterampilan_perawatan_bayi.'",
						LINGKUNGAN_KETERAMPILAN_LAINNYA = "'.$lingkungan_keterampilan_lainnya.'",
						LINGKUNGAN_KETERAMPILAN_LAINNYA_KET = "'.$lingkungan_keterampilan_lainnya_ket.'",LINGKUNGAN_FASKES = "'.$lingkungan_faskes.'",
						HOME_CARE_MAKAN = "'.$home_care_makan.'",HOME_CARE_MINUM = "'.$home_care_minum.'",HOME_CARE_MANDI = "'.$home_care_mandi.'",
						HOME_CARE_BAK = "'.$home_care_bak.'",HOME_CARE_BAB = "'.$home_care_bab.'",HOME_CARE_BERPAKAIAN = "'.$home_care_berpakaian.'",
						HOME_CARE_ALATBANTU_TONGKAT = "'.$home_care_alatbantu_tongkat.'",HOME_CARE_ALATBANTU_KURSI = "'.$home_care_alatbantu_kursi.'",
						HOME_CARE_ALATBANTU_WALKER = "'.$home_care_alatbantu_walker.'",
						HOME_CARE_ALATMEDIS_KATETERURINE = "'.$home_care_alatmedis_kateterurine.'",HOME_CARE_ALATMEDIS_NGT = "'.$home_care_alatmedis_ngt.'",
						HOME_CARE_ALATMEDIS_OKSIGEN = "'.$home_care_alatmedis_oksigen.'",HOME_CARE_ALATMEDIS_LAINNYA = "'.$home_care_alatmedis_lainnya.'",
						HOME_CARE_ALATMEDIS_LAINNYA_KET = "'.$home_care_alatmedis_lainnya_ket.'",EDUKASI_OBAT = "'.$edukasi_obat.'",
						EDUKASI_NYERI = "'.$edukasi_nyeri.'",EDUKASI_DIET = "'.$edukasi_diet.'",EDUKASI_CARITOLONG = "'.$edukasi_caritolong.'",
						EDUKASI_PERAWATAN = "'.$edukasi_perawatan.'",EDUKASI_LAINNYA = "'.$edukasi_lainnya.'",
						EDUKASI_LAINNYA_KET = "'.$edukasi_lainnya_ket.'",FASKES_PUSKESMAS = "'.$faskes_puskesmas.'",FASKES_RS = "'.$faskes_rs.'",
						FASKES_KLINIK = "'.$faskes_klinik.'",FASKES_DOKTER_KELUARGA = "'.$faskes_dokter_keluarga.'",
						FASKES_RUMAH_RAWAT = "'.$faskes_rumah_rawat.'",FASKES_BIDAN_PRAKTEK = "'.$faskes_bidan_praktek.'",
						FASKES_LAINNYA = "'.$faskes_lainnya.'",FASKES_LAINNYA_KET = "'.$faskes_lainnya_ket.'",DIET_JENIS = "'.$diet_jenis.'",
						DIET_JUMLAH = "'.$diet_jumlah.'",DIET_WAKTU = "'.$diet_waktu.'",TRANSPORTASI_AMBULANCE = "'.$transportasi_ambulance.'",
						TRANSPORTASI_PRIBADI = "'.$transportasi_pribadi.'",TRANSPORTASI_UMUM = "'.$transportasi_umum.'",
						YAYASAN_JANTUNG = "'.$yayasan_jantung.'",YAYASAN_STROKE = "'.$yayasan_stroke.'",YAYASAN_LAINNYA = "'.$yayasan_lainnya.'",
						YAYASAN_LAINNYA_KET = "'.$yayasan_lainnya_ket.'",RENCANA_TINDAK_LANJUT = "'.$rencana_tindak_lanjut.'"	
						WHERE HEMODIALISA_RENCANA_PULANG_ID = "'.$irja_rencana_pulang_id.'"') or die(mysql_error());
			}	
		}
	}	
    ?>
    <script language="JavaScript" >
        alert('Simpan Data Rencana Pulang Berhasil.');
		window.location = "<?php echo currentUrl(); ?>";
    </script>
    <?php
} else {
    $msg_info = $_err;
}
?>