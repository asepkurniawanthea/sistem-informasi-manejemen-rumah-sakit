<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$pengkajian_awal_id = $_POST['pengkajian_awal_id'];
$tanggal = $_POST['tanggal'] . ' ' . $_POST['jam'] . ':' . $_POST['menit'];
$tanggal_pelengkap = $_POST['tanggal_pelengkap'] . ' ' . $_POST['jam_pelengkap'] . ':' . $_POST['menit_pelengkap'];
$perawat = $_POST['perawat'];
$perawat_pelengkap = $_POST['perawat_pelengkap'];
$user_name = currentUser();

if (empty($_err)) {
$nama_panggilan = $_POST['nama_panggilan'];
$status_kawin = '';
if(isset($_POST['status_kawin'])) $status_kawin = $_POST['status_kawin'];
$status_kawin_ket = $_POST['status_kawin_ket'];
$jumlah_anak = $_POST['jumlah_anak'];
$agama = '';
if(isset($_POST['agama'])) $agama = $_POST['agama'];
$pendidikan = '';
if(isset($_POST['pendidikan'])) $pendidikan = $_POST['pendidikan'];
$pendidikan_ket = $_POST['pendidikan_ket'];
$pekerjaan = '';
if(isset($_POST['pekerjaan'])) $pekerjaan = $_POST['pekerjaan'];
$pekerjaan_ket = $_POST['pekerjaan_ket'];
$alamat = $_POST['alamat'];
$no_telepon = $_POST['no_telepon'];
$tanggal_masuk = $_POST['tanggal_masuk'] . ' ' . $_POST['jam_masuk'] . ':' . $_POST['menit_masuk'];
$cara_masuk = '';
if(isset($_POST['cara_masuk'])) $cara_masuk = $_POST['cara_masuk'];
$tidak_ada_alergi = '';
if(isset($_POST['tidak_ada_alergi'])) $tidak_ada_alergi = $_POST['tidak_ada_alergi'];
$alergi_obat = '';
if(isset($_POST['alergi_obat'])) $alergi_obat = $_POST['alergi_obat'];
$alergi_obat_ket = $_POST['alergi_obat_ket'];
$alergi_obat_reaksi = $_POST['alergi_obat_reaksi'];
$alergi_makanan = '';
if(isset($_POST['alergi_makanan'])) $alergi_makanan = $_POST['alergi_makanan'];
$alergi_makanan_ket = $_POST['alergi_makanan_ket'];
$alergi_makanan_reaksi = $_POST['alergi_makanan_reaksi'];
$alergi_lainnya = '';
if(isset($_POST['alergi_lainnya'])) $alergi_lainnya = $_POST['alergi_lainnya'];
$alergi_lainnya_ket = $_POST['alergi_lainnya_ket'];
$alergi_lainnya_reaksi = $_POST['alergi_lainnya_reaksi'];
$gelang_tanda_alergi = '';
if(isset($_POST['gelang_tanda_alergi'])) $gelang_tanda_alergi = $_POST['gelang_tanda_alergi'];
$alergi_tidak_diketahui = '';
if(isset($_POST['alergi_tidak_diketahui'])) $alergi_tidak_diketahui = $_POST['alergi_tidak_diketahui'];
$alasan_masuk_rs = $_POST['alasan_masuk_rs'];
$pernah_dirawat = '';
if(isset($_POST['pernah_dirawat'])) $pernah_dirawat = $_POST['pernah_dirawat'];
$pernah_dirawat_kapan = $_POST['pernah_dirawat_kapan'];
$pernah_dirawat_dimana = $_POST['pernah_dirawat_dimana'];
$diagnosis = $_POST['diagnosis'];
$tanda_vital = '';
for($x=1;$x < 8; $x++){
	if(isset($_POST['tanda_vital_' . $x])) {
		$tanda_vital = $tanda_vital . $_POST['tanda_vital_' . $x] . '||';
	}else{
		$tanda_vital = $tanda_vital . '||';
	}
}
$terpasang_alat_implan = '';
if(isset($_POST['terpasang_alat_implan'])) $terpasang_alat_implan = $_POST['terpasang_alat_implan'];
$terpasang_alat_implan_ket = $_POST['terpasang_alat_implan_ket'];
$penyakit_riwayat_keluarga = '';
for($x=1;$x < 5; $x++){
	if(isset($_POST['penyakit_riwayat_keluarga_' . $x])) {
		$penyakit_riwayat_keluarga = $penyakit_riwayat_keluarga . $_POST['penyakit_riwayat_keluarga_' . $x] . '||';
	}else{
		$penyakit_riwayat_keluarga = $penyakit_riwayat_keluarga . '||';
	}
}
$penyakit_riwayat_penyakit = '';
for($x=1;$x < 7; $x++){
	if(isset($_POST['penyakit_riwayat_penyakit_' . $x])) {
		$penyakit_riwayat_penyakit = $penyakit_riwayat_penyakit . $_POST['penyakit_riwayat_penyakit_' . $x] . '||';
	}else{
		$penyakit_riwayat_penyakit = $penyakit_riwayat_penyakit . '||';
	}
}
$penyakit_riwayat_ket = $_POST['penyakit_riwayat_ket'];
$status_psikologis = '';
for($x=1;$x < 10; $x++){
	if(isset($_POST['status_psikologis_' . $x])) {
		$status_psikologis = $status_psikologis . $_POST['status_psikologis_' . $x] . '||';
	}else{
		$status_psikologis = $status_psikologis . '||';
	}
}
$status_psikologis_ket = $_POST['status_psikologis_ket'];
$status_mental = '';
for($x=1;$x < 4; $x++){
	if(isset($_POST['status_mental_' . $x])) {
		$status_mental = $status_mental . $_POST['status_mental_' . $x] . '||';
	}else{
		$status_mental = $status_mental . '||';
	}
}
$status_mental_ket_1 = $_POST['status_mental_ket_1'];
$status_mental_ket_2 = $_POST['status_mental_ket_2'];
$status_sosial = '';
for($x=1;$x < 3; $x++){
	if(isset($_POST['status_sosial_' . $x])) {
		$status_sosial = $status_sosial . $_POST['status_sosial_' . $x] . '||';
	}else{
		$status_sosial = $status_sosial . '||';
	}
}
$status_sosial_ket = $_POST['status_sosial_ket'];
$status_sosial_kerabat = '';
for($x=1;$x < 4; $x++){
	if(isset($_POST['status_sosial_kerabat_' . $x])) {
		$status_sosial_kerabat = $status_sosial_kerabat . $_POST['status_sosial_kerabat_' . $x] . '||';
	}else{
		$status_sosial_kerabat = $status_sosial_kerabat . '||';
	}
}
$pemeriksaan_fisik_kepala = '';
for($x=1;$x < 3; $x++){
	if(isset($_POST['pemeriksaan_fisik_kepala_' . $x])) {
		$pemeriksaan_fisik_kepala = $pemeriksaan_fisik_kepala . $_POST['pemeriksaan_fisik_kepala_' . $x] . '||';
	}else{
		$pemeriksaan_fisik_kepala = $pemeriksaan_fisik_kepala . '||';
	}
}
$pemeriksaan_fisik_mata = '';
for($x=1;$x < 12; $x++){
	if(isset($_POST['pemeriksaan_fisik_mata_' . $x])) {
		$pemeriksaan_fisik_mata = $pemeriksaan_fisik_mata . $_POST['pemeriksaan_fisik_mata_' . $x] . '||';
	}else{
		$pemeriksaan_fisik_mata = $pemeriksaan_fisik_mata . '||';
	}
}
$pemeriksaan_fisik_telinga = '';
for($x=1;$x < 10; $x++){
	if(isset($_POST['pemeriksaan_fisik_telinga_' . $x])) {
		$pemeriksaan_fisik_telinga = $pemeriksaan_fisik_telinga . $_POST['pemeriksaan_fisik_telinga_' . $x] . '||';
	}else{
		$pemeriksaan_fisik_telinga = $pemeriksaan_fisik_telinga . '||';
	}
}
$pemeriksaan_fisik_hidung = '';
for($x=1;$x < 7; $x++){
	if(isset($_POST['pemeriksaan_fisik_hidung_' . $x])) {
		$pemeriksaan_fisik_hidung = $pemeriksaan_fisik_hidung . $_POST['pemeriksaan_fisik_hidung_' . $x] . '||';
	}else{
		$pemeriksaan_fisik_hidung = $pemeriksaan_fisik_hidung . '||';
	}
}
$pemeriksaan_fisik_mulut = '';
for($x=1;$x < 13; $x++){
	if(isset($_POST['pemeriksaan_fisik_mulut_' . $x])) {
		$pemeriksaan_fisik_mulut = $pemeriksaan_fisik_mulut . $_POST['pemeriksaan_fisik_mulut_' . $x] . '||';
	}else{
		$pemeriksaan_fisik_mulut = $pemeriksaan_fisik_mulut . '||';
	}
}
$pemeriksaan_fisik_leher = '';
for($x=1;$x < 10; $x++){
	if(isset($_POST['pemeriksaan_fisik_leher_' . $x])) {
		$pemeriksaan_fisik_leher = $pemeriksaan_fisik_leher . $_POST['pemeriksaan_fisik_leher_' . $x] . '||';
	}else{
		$pemeriksaan_fisik_leher = $pemeriksaan_fisik_leher . '||';
	}
}
$pemeriksaan_fisik_thorax = '';
for($x=1;$x < 16; $x++){
	if(isset($_POST['pemeriksaan_fisik_thorax_' . $x])) {
		$pemeriksaan_fisik_thorax = $pemeriksaan_fisik_thorax . $_POST['pemeriksaan_fisik_thorax_' . $x] . '||';
	}else{
		$pemeriksaan_fisik_thorax = $pemeriksaan_fisik_thorax . '||';
	}
}
$pemeriksaan_fisik_abdomen = '';
for($x=1;$x < 41; $x++){
	if(isset($_POST['pemeriksaan_fisik_abdomen_' . $x])) {
		$pemeriksaan_fisik_abdomen = $pemeriksaan_fisik_abdomen . $_POST['pemeriksaan_fisik_abdomen_' . $x] . '||';
	}else{
		$pemeriksaan_fisik_abdomen = $pemeriksaan_fisik_abdomen . '||';
	}
}
$pemeriksaan_fisik_kulit = '';
for($x=1;$x < 8; $x++){
	if(isset($_POST['pemeriksaan_fisik_kulit_' . $x])) {
		$pemeriksaan_fisik_kulit = $pemeriksaan_fisik_kulit . $_POST['pemeriksaan_fisik_kulit_' . $x] . '||';
	}else{
		$pemeriksaan_fisik_kulit = $pemeriksaan_fisik_kulit . '||';
	}
}
$pemeriksaan_fisik_terkait_penyakit = $_POST['pemeriksaan_fisik_terkait_penyakit'];
$skrining_gizi = '';
for($x=1;$x < 9; $x++){
	if(isset($_POST['skrining_gizi_' . $x])) {
		$skrining_gizi = $skrining_gizi . $_POST['skrining_gizi_' . $x] . '||';
	}else{
		$skrining_gizi = $skrining_gizi . '||';
	}
}
$status_fungsional = '';
if(isset($_POST['status_fungsional'])) $status_fungsional = $_POST['status_fungsional'];
$status_fungsional_ket = $_POST['status_fungsional_ket'];
$risiko_cedera = '';
for($x=1;$x < 5; $x++){
	if(isset($_POST['risiko_cedera_' . $x])) {
		$risiko_cedera = $risiko_cedera . $_POST['risiko_cedera_' . $x] . '||';
	}else{
		$risiko_cedera = $risiko_cedera . '||';
	}
}
$skrining_nyeri = '';
for($x=1;$x < 15; $x++){
	if(isset($_POST['skrining_nyeri_' . $x])) {
		$skrining_nyeri = $skrining_nyeri . $_POST['skrining_nyeri_' . $x] . '||';
	}else{
		$skrining_nyeri = $skrining_nyeri . '||';
	}
}
$pemeriksaan_penunjang = $_POST['pemeriksaan_penunjang'];
$kebutuhan_edukasi = '';
for($x=1;$x < 22; $x++){
	if(isset($_POST['kebutuhan_edukasi_' . $x])) {
		$kebutuhan_edukasi = $kebutuhan_edukasi . $_POST['kebutuhan_edukasi_' . $x] . '||';
	}else{
		$kebutuhan_edukasi = $kebutuhan_edukasi . '||';
	}
}

if(empty($pengkajian_awal_id)){
	mysql_query('INSERT INTO t_irna_askep_pengkajian_awal (PENGKAJIAN_AWAL_ID,NAMA_PANGGILAN,STATUS_KAWIN,STATUS_KAWIN_KET,JUMLAH_ANAK,
				AGAMA,PENDIDIKAN,PENDIDIKAN_KET,PEKERJAAN,PEKERJAAN_KET,ALAMAT,NO_TELEPON,TANGGAL_MASUK,CARA_MASUK,TIDAK_ADA_ALERGI,
				ALERGI_OBAT,ALERGI_OBAT_KET,ALERGI_OBAT_REAKSI,ALERGI_MAKANAN,ALERGI_MAKANAN_KET,ALERGI_MAKANAN_REAKSI,ALERGI_LAINNYA,
				ALERGI_LAINNYA_KET,ALERGI_LAINNYA_REAKSI,GELANG_TANDA_ALERGI,ALERGI_TIDAK_DIKETAHUI,ALASAN_MASUK_RS,PERNAH_DIRAWAT,
				PERNAH_DIRAWAT_KAPAN,PERNAH_DIRAWAT_DIMANA,DIAGNOSIS,TANDA_VITAL,TERPASANG_ALAT_IMPLAN,TERPASANG_ALAT_IMPLAN_KET,
				PENYAKIT_RIWAYAT_KELUARGA,PENYAKIT_RIWAYAT_PENYAKIT,PENYAKIT_RIWAYAT_KET,STATUS_PSIKOLOGIS,STATUS_PSIKOLOGIS_KET,
				STATUS_MENTAL,STATUS_MENTAL_KET_1,STATUS_MENTAL_KET_2,STATUS_SOSIAL,STATUS_SOSIAL_KET,STATUS_SOSIAL_KERABAT,
				PEMERIKSAAN_FISIK_KEPALA,PEMERIKSAAN_FISIK_MATA,PEMERIKSAAN_FISIK_TELINGA,PEMERIKSAAN_FISIK_HIDUNG,
				PEMERIKSAAN_FISIK_MULUT,PEMERIKSAAN_FISIK_LEHER,PEMERIKSAAN_FISIK_THORAX,PEMERIKSAAN_FISIK_ABDOMEN,
				PEMERIKSAAN_FISIK_KULIT,PEMERIKSAAN_FISIK_TERKAIT_PENYAKIT,SKRINING_GIZI,STATUS_FUNGSIONAL,STATUS_FUNGSIONAL_KET,
				RISIKO_CEDERA,SKRINING_NYERI,PEMERIKSAAN_PENUNJANG,KEBUTUHAN_EDUKASI,TANGGAL,PERAWAT,TANGGAL_PELENGKAP,
				PERAWAT_PELENGKAP,USER_ASKEP) VALUES 
				("'.$irna_id.'","'.$nama_panggilan.'","'.$status_kawin.'","'.$status_kawin_ket.'","'.$jumlah_anak.'","'.$agama.'",
				"'.$pendidikan.'","'.$pendidikan_ket.'","'.$pekerjaan.'","'.$pekerjaan_ket.'","'.$alamat.'","'.$no_telepon.'",
				STR_TO_DATE("'.$tanggal_masuk.'","%d/%m/%Y %H:%i"),"'.$cara_masuk.'","'.$tidak_ada_alergi.'","'.$alergi_obat.'",
				"'.$alergi_obat_ket.'",
				"'.$alergi_obat_reaksi.'","'.$alergi_makanan.'","'.$alergi_makanan_ket.'","'.$alergi_makanan_reaksi.'",
				"'.$alergi_lainnya.'","'.$alergi_lainnya_ket.'","'.$alergi_lainnya_reaksi.'","'.$gelang_tanda_alergi.'",
				"'.$alergi_tidak_diketahui.'","'.$alasan_masuk_rs.'","'.$pernah_dirawat.'","'.$pernah_dirawat_kapan.'",
				"'.$pernah_dirawat_dimana.'","'.$diagnosis.'","'.$tanda_vital.'","'.$terpasang_alat_implan.'",
				"'.$terpasang_alat_implan_ket.'","'.$penyakit_riwayat_keluarga.'","'.$penyakit_riwayat_penyakit.'",
				"'.$penyakit_riwayat_ket.'","'.$status_psikologis.'","'.$status_psikologis_ket.'","'.$status_mental.'",
				"'.$status_mental_ket_1.'","'.$status_mental_ket_2.'","'.$status_sosial.'","'.$status_sosial_ket.'",
				"'.$status_sosial_kerabat.'","'.$pemeriksaan_fisik_kepala.'","'.$pemeriksaan_fisik_mata.'",
				"'.$pemeriksaan_fisik_telinga.'","'.$pemeriksaan_fisik_hidung.'","'.$pemeriksaan_fisik_mulut.'",
				"'.$pemeriksaan_fisik_leher.'","'.$pemeriksaan_fisik_thorax.'","'.$pemeriksaan_fisik_abdomen.'",
				"'.$pemeriksaan_fisik_kulit.'","'.$pemeriksaan_fisik_terkait_penyakit.'","'.$skrining_gizi.'",
				"'.$status_fungsional.'","'.$status_fungsional_ket.'","'.$risiko_cedera.'","'.$skrining_nyeri.'",
				"'.$pemeriksaan_penunjang.'","'.$kebutuhan_edukasi.'",STR_TO_DATE("'.$tanggal.'","%d/%m/%Y %H:%i"),"'.$perawat.'",
				STR_TO_DATE("'.$tanggal_pelengkap.'","%d/%m/%Y %H:%i"),"'.$perawat_pelengkap.'","'.$user_name.'")') or die(mysql_error());
}else{
	mysql_query('UPDATE t_irna_askep_pengkajian_awal SET NAMA_PANGGILAN = "'.$nama_panggilan.'",STATUS_KAWIN = "'.$status_kawin.'",
			STATUS_KAWIN_KET = "'.$status_kawin_ket.'",JUMLAH_ANAK = "'.$jumlah_anak.'",AGAMA = "'.$agama.'",PENDIDIKAN = "'.$pendidikan.'",
			PENDIDIKAN_KET = "'.$pendidikan_ket.'",PEKERJAAN = "'.$pekerjaan.'",PEKERJAAN_KET = "'.$pekerjaan_ket.'",ALAMAT = "'.$alamat.'",
			NO_TELEPON = "'.$no_telepon.'",TANGGAL_MASUK = STR_TO_DATE("'.$tanggal_masuk.'","%d/%m/%Y %H:%i"),CARA_MASUK = "'.$cara_masuk.'",
			TIDAK_ADA_ALERGI = "'.$tidak_ada_alergi.'",ALERGI_OBAT = "'.$alergi_obat.'",ALERGI_OBAT_KET = "'.$alergi_obat_ket.'",
			ALERGI_OBAT_REAKSI = "'.$alergi_obat_reaksi.'",ALERGI_MAKANAN = "'.$alergi_makanan.'",
			ALERGI_MAKANAN_KET = "'.$alergi_makanan_ket.'",ALERGI_MAKANAN_REAKSI = "'.$alergi_makanan_reaksi.'",
			ALERGI_LAINNYA = "'.$alergi_lainnya.'",ALERGI_LAINNYA_KET = "'.$alergi_lainnya_ket.'",
			ALERGI_LAINNYA_REAKSI = "'.$alergi_lainnya_reaksi.'",GELANG_TANDA_ALERGI = "'.$gelang_tanda_alergi.'",
			ALERGI_TIDAK_DIKETAHUI = "'.$alergi_tidak_diketahui.'",ALASAN_MASUK_RS = "'.$alasan_masuk_rs.'",
			PERNAH_DIRAWAT = "'.$pernah_dirawat.'",PERNAH_DIRAWAT_KAPAN = "'.$pernah_dirawat_kapan.'",
			PERNAH_DIRAWAT_DIMANA = "'.$pernah_dirawat_dimana.'",DIAGNOSIS = "'.$diagnosis.'",TANDA_VITAL = "'.$tanda_vital.'",
			TERPASANG_ALAT_IMPLAN = "'.$terpasang_alat_implan.'",TERPASANG_ALAT_IMPLAN_KET = "'.$terpasang_alat_implan_ket.'",
			PENYAKIT_RIWAYAT_KELUARGA = "'.$penyakit_riwayat_keluarga.'",PENYAKIT_RIWAYAT_PENYAKIT = "'.$penyakit_riwayat_penyakit.'",
			PENYAKIT_RIWAYAT_KET = "'.$penyakit_riwayat_ket.'",STATUS_PSIKOLOGIS = "'.$status_psikologis.'",
			STATUS_PSIKOLOGIS_KET = "'.$status_psikologis_ket.'",STATUS_MENTAL = "'.$status_mental.'",
			STATUS_MENTAL_KET_1 = "'.$status_mental_ket_1.'",STATUS_MENTAL_KET_2 = "'.$status_mental_ket_2.'",
			STATUS_SOSIAL = "'.$status_sosial.'",STATUS_SOSIAL_KET = "'.$status_sosial_ket.'",
			STATUS_SOSIAL_KERABAT = "'.$status_sosial_kerabat.'",PEMERIKSAAN_FISIK_KEPALA = "'.$pemeriksaan_fisik_kepala.'",
			PEMERIKSAAN_FISIK_MATA = "'.$pemeriksaan_fisik_mata.'",PEMERIKSAAN_FISIK_TELINGA = "'.$pemeriksaan_fisik_telinga.'",
			PEMERIKSAAN_FISIK_HIDUNG = "'.$pemeriksaan_fisik_hidung.'",PEMERIKSAAN_FISIK_MULUT = "'.$pemeriksaan_fisik_mulut.'",
			PEMERIKSAAN_FISIK_LEHER = "'.$pemeriksaan_fisik_leher.'",PEMERIKSAAN_FISIK_THORAX = "'.$pemeriksaan_fisik_thorax.'",
			PEMERIKSAAN_FISIK_ABDOMEN = "'.$pemeriksaan_fisik_abdomen.'",PEMERIKSAAN_FISIK_KULIT = "'.$pemeriksaan_fisik_kulit.'",
			PEMERIKSAAN_FISIK_TERKAIT_PENYAKIT = "'.$pemeriksaan_fisik_terkait_penyakit.'",SKRINING_GIZI = "'.$skrining_gizi.'",
			STATUS_FUNGSIONAL = "'.$status_fungsional.'",STATUS_FUNGSIONAL_KET = "'.$status_fungsional_ket.'",
			RISIKO_CEDERA = "'.$risiko_cedera.'",SKRINING_NYERI = "'.$skrining_nyeri.'",PEMERIKSAAN_PENUNJANG = "'.$pemeriksaan_penunjang.'",
			KEBUTUHAN_EDUKASI = "'.$kebutuhan_edukasi.'",TANGGAL = STR_TO_DATE("'.$tanggal.'","%d/%m/%Y %H:%i"),PERAWAT = "'.$perawat.'",
			TANGGAL_PELENGKAP = STR_TO_DATE("'.$tanggal_pelengkap.'","%d/%m/%Y %H:%i"),PERAWAT_PELENGKAP = "'.$perawat_pelengkap.'",
			USER_ASKEP = "'.$user_name.'",ST_CREATE_ERM = NULL 
			WHERE PENGKAJIAN_AWAL_ID = "'.$pengkajian_awal_id.'"') or die(mysql_error());
}

$masalah_diagnosa = $_POST['masalah_diagnosa'];
if(trim($masalah_diagnosa) != ''){
	mysql_query('INSERT INTO t_irna_askep_masalah_diagnosa(PENGKAJIAN_AWAL_ID,MASALAH_DIAGNOSA)
			VALUES("' . $irna_id . '","' . $masalah_diagnosa . '")') or die(mysql_error());
}	

$cn_diagnosa = $_POST['cn_diagnosa'];
if($cn_diagnosa > 0){
	$c = 0;
	while($c < $cn_diagnosa){
		$m_diagnosa = $_POST['masalah_diagnosa_' . $c];
		$i_diagnosa = $_POST['id_diagnosa_' . $c];
		if(trim($m_diagnosa) == ''){
			mysql_query('DELETE FROM t_irna_askep_masalah_diagnosa 
						WHERE MASALAH_DIAGNOSA_ID = "' . $i_diagnosa . '"') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irna_askep_masalah_diagnosa SET MASALAH_DIAGNOSA = "' . $m_diagnosa . '"
						WHERE MASALAH_DIAGNOSA_ID = "' . $i_diagnosa . '"') or die(mysql_error());
		}
	$c++; }
}

$diagnosa_perencanaan = $_POST['diagnosa_perencanaan'];
$tujuan_perencanaan = $_POST['tujuan_perencanaan'];
$kriteria_perencanaan = $_POST['kriteria_perencanaan'];
$intervensi_perencanaan = $_POST['intervensi_perencanaan'];
if(trim($diagnosa_perencanaan) != '' or trim($tujuan_perencanaan) != '' or trim($kriteria_perencanaan) != '' or trim($intervensi_perencanaan) != ''){
	mysql_query('INSERT INTO t_irna_askep_perencanaan_keperawatan(PENGKAJIAN_AWAL_ID,DIAGNOSA,TUJUAN,KRITERIA_HASIL,INTERVENSI)
			VALUES("' . $irna_id . '","' . $diagnosa_perencanaan . '","' . $tujuan_perencanaan . '","' . $kriteria_perencanaan . '",
			"' . $intervensi_perencanaan . '")') or die(mysql_error());
}	

$cn_perencanaan = $_POST['cn_perencanaan'];
if($cn_perencanaan > 0){
	$c = 0;
	while($c < $cn_perencanaan){
		$i_perencanaan = $_POST['id_perencanaan_' . $c];
		$m_diagnosa = $_POST['diagnosa_perencanaan_' . $c];
		$m_tujuan = $_POST['tujuan_perencanaan_' . $c];
		$m_kriteria = $_POST['kriteria_perencanaan_' . $c];
		$m_intervensi = $_POST['intervensi_perencanaan_' . $c];
		if(trim($m_diagnosa) == '' and trim($m_tujuan) == '' and trim($m_kriteria) == '' and trim($m_intervensi) == ''){
			mysql_query('DELETE FROM t_irna_askep_perencanaan_keperawatan 
						WHERE PERENCANAAN_KEPERAWATAN_ID = "' . $i_perencanaan . '"') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irna_askep_perencanaan_keperawatan SET 
						DIAGNOSA = "' . $m_diagnosa . '",TUJUAN = "' . $m_tujuan . '",KRITERIA_HASIL = "' . $m_kriteria . '",
						INTERVENSI = "' . $m_intervensi . '" WHERE PERENCANAAN_KEPERAWATAN_ID = "' . $i_perencanaan . '"') or die(mysql_error());
		}
	$c++; }
}
?>
<script language="JavaScript" >
	alert('Simpan Data Pengkajian Awal Keperawatan Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
?>