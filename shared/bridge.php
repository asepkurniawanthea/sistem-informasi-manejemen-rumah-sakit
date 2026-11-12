<?php

function simrs_update_pasien($opt,$nomr,$nama,$tempat,$tgllahir,$jnskel,$alamat,
						$kelurahan,$kecamatan,$kota,$propinsi,$telp,$nik,$suami,$pekerjaan,
						$status,$agama,$pendidikan,$ibu){
	
	/*if($opt == 'ins'){
			mysql_query('INSERT INTO m_pasien(NOMR,NAMA,TEMPAT,TGLLAHIR,JENISKELAMIN,ALAMAT,
						KELURAHAN,KDKECAMATAN,KOTA,KDPROVINSI,NOTELP,NOKTP,SUAMI_ORTU,PEKERJAAN,
						STATUS,AGAMA,PENDIDIKAN,IBUKANDUNG)
						VALUES("' . $nomr . '","' . $nama . '","' . $tempat . '",' . fieldDate($tgllahir) . ',"' . $jnskel . '",
						"' . $alamat . '","' . $kelurahan . '","' . $kecamatan . '","' . $kota . '","' . $propinsi . '","' . $telp . '",
						"' . $nik . '","' . $suami . '","' . $pekerjaan . '","' . $status . '","' . $agama . '","' . $pendidikan . '",
						"' . $ibu . '")');
	}else if($opt == 'upd'){
			mysql_query('UPDATE m_pasien
						SET NAMA = "' . $nama . '",TEMPAT = "' . $tempat . '",
						TGLLAHIR = ' . fieldDate($tgllahir) . ',JENISKELAMIN = "' . $jnskel . '",
						ALAMAT = "' . $alamat . '",KELURAHAN = "' . $kelurahan . '",KDKECAMATAN = "' . $kecamatan . '",
						KOTA = "' . $kota . '",KDPROVINSI = "' . $propinsi . '",NOTELP = "' . $telp . '",
						NOKTP = "' . $nik . '",SUAMI_ORTU = "' . $suami . '",PEKERJAAN = "' . $pekerjaan . '",
						STATUS = "' . $status . '",AGAMA = "' . $agama . '",PENDIDIKAN = "' . $pendidikan . '",
						IBUKANDUNG = "' . $ibu . '"
						WHERE NOMR = "' . $nomr . '"');
	}*/
	
}

function simrs_update_irja($opt,$idx,$nomr,$tglreg,$dokter,
							$unit,$rujuk,$bayar,$shift,$pasienbaru,
							$mintarujukan,$batal,$nosjp,$noskp,$nopeserta){
	 
	/*if($opt == 'ins'){
			mysql_query('INSERT INTO t_pendaftaran(IDXDAFTAR,NOMR,TGLREG,KDDOKTER,
							KDPOLY,KDRUJUK,KDCARABAYAR,SHIFT,PASIENBARU,
							MINTA_RUJUKAN,BATAL,NO_SJP,NO_SKP,NOKARTU)
							VALUES(
							"' . $idx . '","' . $nomr . '",NOW(),"' . $dokter . '",
							"' . $unit . '","' . $rujuk . '","' . $bayar . '","' . $shift . '",
							"' . $pasienbaru . '","' . $mintarujukan . '","' . $batal . '","' . $nosjp . '",
							"' . $noskp . '","' . $nopeserta . '")');
	}else if($opt == 'upd'){
			mysql_query('UPDATE t_pendaftaran
						SET KDDOKTER = "' . $dokter . '",KDPOLY = "' . $unit . '",KDRUJUK = "' . $rujuk . '",
						KDCARABAYAR = "' . $bayar . '",MINTA_RUJUKAN = "' . $mintarujukan . '",
						BATAL = "' . $batal . '",NO_SJP = "' . $nosjp . '",
						NO_SKP = "' . $noskp . '",NOKARTU = "' . $nopeserta . '"
						WHERE IDXDAFTAR = "' . $idx . '"');
	}*/ 
	
}

function simrs_update_pasien_masuk($idx,$dokter){
		
		/*mysql_query('UPDATE t_pendaftaran
						SET KDDOKTER = "' . $dokter . '",MASUKPOLY = CURTIME()
						WHERE IDXDAFTAR = "' . $idx . '"');*/
						
}

function simrs_insert_tarif_x($nomr,$idx,$unit,$bayar){
	
	//mysql_query('INSERT INTO t_billrajal(KODETARIF, NOMR, TANGGAL, IDXDAFTAR, KDPOLY,CARABAYAR) VALUES ("x", "'.$nomr.'", CURDATE(), "'.$idx.'", "'.$unit.'", "'.$bayar.'")');
	//mysql_query('INSERT INTO t_bayarrajal(IDXDAFTAR, PRINT_ST) VALUES ("'.$idx.'", "x")');
	
}

function simrs_update_irna($opt,$idx,$nomr,$bayar,$noruang,$nott,
							$icd,$dokter,$nopeserta){
	 
	/*if($opt == 'ins'){
			mysql_query('INSERT INTO t_admission(id_admission,nomr,statusbayar,kirimdari,
						noruang,nott,icd_masuk,dokter_penanggungjawab,NOKARTU,masukrs)
						VALUES("' . $idx . '","' . $nomr . '","' . $bayar . '","' . $idx . '","' . $noruang . '",
						"' . $nott . '","' . $icd . '","' . $dokter . '","' . $nopeserta . '",NOW())');
	}else if($opt == 'upd'){
			mysql_query('UPDATE t_admission SET statusbayar = "' . $bayar . '",
						noruang = "' . $noruang . '",nott = "' . $nott . '",dokter_penanggungjawab = "' . $dokter . '",NOKARTU = "' . $nopeserta . '"
						WHERE id_admission = "' . $idx . '"');
	}*/ 
	
}

?>