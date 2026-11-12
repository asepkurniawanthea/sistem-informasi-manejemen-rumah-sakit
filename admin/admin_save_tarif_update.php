<?php
$cnr = $_POST['cnr'];
$tahun = $_POST['tahun'];
$group_id = $_POST['group_id'];
$z = 1;
while($z < $cnr){
	$tarif_id = $_POST['tarif_id' . $z];
	$kode_tarif = $_POST['kode_tarif' . $z];
	$nama_tarif = $_POST['nama_tarif' . $z];
	$kode_tarif_group = $_POST['kode_tarif_group' . $z];
	
	$jasa_sarana = $_POST['jasa_sarana' . $z];
	$jasa_pelayanan = $_POST['jasa_pelayanan' . $z];
	$tarif_non_kelas = $_POST['tarif_non_kelas' . $z];
	
	$jasa_sarana_kls3 = $_POST['jasa_sarana_kls3' . $z];
	$jasa_pelayanan_kls3 = $_POST['jasa_pelayanan_kls3' . $z];
	$tarif_kelas_3 = $_POST['tarif_kelas_3' . $z];
	
	$jasa_sarana_kls2 = $_POST['jasa_sarana_kls2' . $z];
	$jasa_pelayanan_kls2 = $_POST['jasa_pelayanan_kls2' . $z];
	$tarif_kelas_2 = $_POST['tarif_kelas_2' . $z];
	
	$jasa_sarana_kls1 = $_POST['jasa_sarana_kls1' . $z];
	$jasa_pelayanan_kls1 = $_POST['jasa_pelayanan_kls1' . $z];
	$tarif_kelas_1 = $_POST['tarif_kelas_1' . $z];
	
	$jasa_sarana_klsutama = $_POST['jasa_sarana_klsutama' . $z];
	$jasa_pelayanan_klsutama = $_POST['jasa_pelayanan_klsutama' . $z];
	$tarif_kelas_utama = $_POST['tarif_kelas_utama' . $z];
	
	$jasa_sarana_hcu = $_POST['jasa_sarana_hcu' . $z];
	$jasa_pelayanan_hcu = $_POST['jasa_pelayanan_hcu' . $z];
	$tarif_hcu = $_POST['tarif_hcu' . $z];
	
	$jasa_sarana_perina_sehat = $_POST['jasa_sarana_perina_sehat' . $z];
	$jasa_pelayanan_perina_sehat = $_POST['jasa_pelayanan_perina_sehat' . $z];
	$tarif_perina_sehat = $_POST['tarif_perina_sehat' . $z];
	
	$jasa_sarana_perina_sakit = $_POST['jasa_sarana_perina_sakit' . $z];
	$jasa_pelayanan_perina_sakit = $_POST['jasa_pelayanan_perina_sakit' . $z];
	$tarif_perina_sakit = $_POST['tarif_perina_sakit' . $z];
	
	if(isset($_POST['st_aktif' . $z])){
		$st_aktif = '"1"';
	}else{
		$st_aktif = 'NULL';
	}
	$kode_tarif_group = $_POST['kode_tarif_group' . $z];
		mysql_query('UPDATE m_tarif SET NAMA_TARIF = "' . $nama_tarif . '",
					KODE_TARIF_GROUP = "' . $kode_tarif_group . '",
					JASA_SARANA = "' . $jasa_sarana . '",
					JASA_PELAYANAN = "' . $jasa_pelayanan . '",
					TARIF_NON_KELAS = "' . $tarif_non_kelas . '",
					JASA_SARANA_KELAS_3 = "' . $jasa_sarana_kls3 . '",
					JASA_PELAYANAN_KELAS_3 = "' . $jasa_pelayanan_kls3 . '",
					TARIF_KELAS_3 = "' . $tarif_kelas_3 . '",
					JASA_SARANA_KELAS_2 = "' . $jasa_sarana_kls2 . '",
					JASA_PELAYANAN_KELAS_2 = "' . $jasa_pelayanan_kls2 . '",
					TARIF_KELAS_2 = "' . $tarif_kelas_2 . '",
					JASA_SARANA_KELAS_1 = "' . $jasa_sarana_kls1 . '",
					JASA_PELAYANAN_KELAS_1 = "' . $jasa_pelayanan_kls1 . '",
					TARIF_KELAS_1 = "' . $tarif_kelas_1 . '",
					JASA_SARANA_KELAS_UTAMA = "' . $jasa_sarana_klsutama . '",
					JASA_PELAYANAN_KELAS_UTAMA = "' . $jasa_pelayanan_klsutama . '",
					TARIF_KELAS_UTAMA = "' . $tarif_kelas_utama . '",
					JASA_SARANA_KELAS_PERINA_SEHAT = "' . $jasa_sarana_perina_sehat . '",
					JASA_PELAYANAN_KELAS_PERINA_SEHAT = "' . $jasa_pelayanan_perina_sehat . '",
					TARIF_KELAS_PERINA_SEHAT = "' . $tarif_perina_sehat . '",
					JASA_SARANA_KELAS_PERINA_SAKIT = "' . $jasa_sarana_perina_sakit . '",
					JASA_PELAYANAN_KELAS_PERINA_SAKIT = "' . $jasa_pelayanan_perina_sakit . '",
					TARIF_KELAS_PERINA_SAKIT = "' . $tarif_perina_sakit . '",
					JASA_SARANA_HCU = "' . $jasa_sarana_hcu . '",
					JASA_PELAYANAN_HCU = "' . $jasa_pelayanan_hcu . '",
					TARIF_HCU = "' . $tarif_hcu . '",
					USER_ADMIN = "' . $user_name . '",
					ST_AKTIF = ' . $st_aktif . ',
					KODE_TARIF_GROUP = "' . $kode_tarif_group . '"
					WHERE TARIF_ID = "' . $tarif_id . '"') or die(mysql_error());
$z++;	
}
if(isset($_POST['tarif_new'])){
	$kode_tarif_new = $_POST['kode_tarif_new'];
	$nama_tarif_new = $_POST['nama_tarif_new'];
	$kode_tarif_group_new = $_POST['kode_tarif_group_new'];
	
	$jasa_sarana_new = $_POST['jasa_sarana_new'];
	$jasa_pelayanan_new = $_POST['jasa_pelayanan_new'];
	$tarif_non_kelas_new = $_POST['tarif_non_kelas_new'];
	$jasa_sarana_kls3_new = $_POST['jasa_sarana_kls3_new'];
	$jasa_pelayanan_kls3_new = $_POST['jasa_pelayanan_kls3_new'];
	$tarif_kelas_3_new = $_POST['tarif_kelas_3_new'];
	$jasa_sarana_kls2_new = $_POST['jasa_sarana_kls2_new'];
	$jasa_pelayanan_kls2_new = $_POST['jasa_pelayanan_kls2_new'];
	$tarif_kelas_2_new = $_POST['tarif_kelas_2_new'];
	$jasa_sarana_kls1_new = $_POST['jasa_sarana_kls1_new'];
	$jasa_pelayanan_kls1_new = $_POST['jasa_pelayanan_kls1_new'];
	$tarif_kelas_1_new = $_POST['tarif_kelas_1_new'];
	$jasa_sarana_klsutama_new = $_POST['jasa_sarana_klsutama_new'];
	$jasa_pelayanan_klsutama_new = $_POST['jasa_pelayanan_klsutama_new'];
	$tarif_kelas_utama_new = $_POST['tarif_kelas_utama_new'];
	$jasa_sarana_hcu_new = $_POST['jasa_sarana_hcu_new'];
	$jasa_pelayanan_hcu_new = $_POST['jasa_pelayanan_hcu_new'];
	$tarif_hcu_new = $_POST['tarif_hcu_new'];
	$jasa_sarana_perina_sehat_new = $_POST['jasa_sarana_perina_sehat_new'];
	$jasa_pelayanan_perina_sehat_new = $_POST['jasa_pelayanan_perina_sehat_new'];
	$tarif_perina_sehat_new = $_POST['tarif_perina_sehat_new'];
	$jasa_sarana_perina_sakit_new = $_POST['jasa_sarana_perina_sakit_new'];
	$jasa_pelayanan_perina_sakit_new = $_POST['jasa_pelayanan_perina_sakit_new'];
	$tarif_perina_sakit_new = $_POST['tarif_perina_sakit_new'];
		
	mysql_query('INSERT INTO m_tarif(KODE_TARIF,NAMA_TARIF,KODE_TARIF_GROUP,
				JASA_SARANA,JASA_PELAYANAN,TARIF_NON_KELAS,
				JASA_SARANA_KELAS_3,JASA_PELAYANAN_KELAS_3,TARIF_KELAS_3,
				JASA_SARANA_KELAS_2,JASA_PELAYANAN_KELAS_2,TARIF_KELAS_2,
				JASA_SARANA_KELAS_1,JASA_PELAYANAN_KELAS_1,TARIF_KELAS_1,
				JASA_SARANA_KELAS_UTAMA,JASA_PELAYANAN_KELAS_UTAMA,TARIF_KELAS_UTAMA,
				JASA_SARANA_KELAS_PERINA_SEHAT,JASA_PELAYANAN_KELAS_PERINA_SEHAT,TARIF_KELAS_PERINA_SEHAT,
				JASA_SARANA_KELAS_PERINA_SAKIT,JASA_PELAYANAN_KELAS_PERINA_SAKIT,TARIF_KELAS_PERINA_SAKIT,
				JASA_SARANA_HCU,JASA_PELAYANAN_HCU,TARIF_HCU,
				TAHUN_UPDATE,USER_ADMIN,ST_AKTIF)
				VALUES("' . $kode_tarif_new . '","' . $nama_tarif_new . '","' . $kode_tarif_group_new . '",
				"' . $jasa_sarana_new . '","' . $jasa_pelayanan_new . '","' . $tarif_non_kelas_new . '",
				"' . $jasa_sarana_kls3_new . '","' . $jasa_pelayanan_kls3_new . '","' . $tarif_kelas_3_new . '",
				"' . $jasa_sarana_kls2_new . '","' . $jasa_pelayanan_kls2_new . '","' . $tarif_kelas_2_new . '",
				"' . $jasa_sarana_kls1_new . '","' . $jasa_pelayanan_kls1_new . '","' . $tarif_kelas_1_new . '",
				"' . $jasa_sarana_klsutama_new . '","' . $jasa_pelayanan_klsutama_new . '","' . $tarif_kelas_utama_new . '",
				"' . $jasa_sarana_perina_sehat_new . '","' . $jasa_pelayanan_perina_sehat_new . '","' . $tarif_perina_sehat_new . '",
				"' . $jasa_sarana_perina_sakit_new . '","' . $jasa_pelayanan_perina_sakit_new . '","' . $tarif_perina_sakit_new . '",
				"' . $jasa_sarana_hcu_new . '","' . $jasa_pelayanan_hcu_new . '","' . $tarif_hcu_new . '",
				"' . $tahun . '","' . $user_name . '","1")') or die(mysql_error());
}
?>