<?php
function create_pdf_rencana_pemulangan($idx,$perawatan){
global $rmfile_path;
global $user_name;	
global $edoc_logo;
global $paper_width;
global $paper_height;
$jenis_document = 'Rencana Pemulangan Pasien';
$id_document = '11';	

if($perawatan == 'RJ'){
	$jns_rawat = '1';
	$qry_pasien = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,t_irja.UNIT_ID,m_unit.NAMA_UNIT,
					m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID
					FROM t_irja
					INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_irja.IRJA_ID = "' . $idx . '"';
	$qry_pemulangan = 'SELECT IRJA_RENCANA_PULANG_ID,OBAT_LANJUT_NAMA,OBAT_LANJUT_JUMLAH,OBAT_LANJUT_WAKTU,OBAT_LANJUT_CARA,LINGKUNGAN_AIR_BERSIH,
					LINGKUNGAN_VENTILASI,LINGKUNGAN_FASILITAS,LINGKUNGAN_KETERAMPILAN_RAWAT_LUKA,LINGKUNGAN_KETERAMPILAN_INJEKSI,
					LINGKUNGAN_KETERAMPILAN_PERAWATAN_BAYI,LINGKUNGAN_KETERAMPILAN_LAINNYA,LINGKUNGAN_KETERAMPILAN_LAINNYA_KET,LINGKUNGAN_FASKES,
					HOME_CARE_MAKAN,HOME_CARE_MINUM,HOME_CARE_MANDI,HOME_CARE_BAK,HOME_CARE_BAB,HOME_CARE_BERPAKAIAN,HOME_CARE_ALATBANTU_TONGKAT,
					HOME_CARE_ALATBANTU_KURSI,HOME_CARE_ALATBANTU_WALKER,HOME_CARE_ALATMEDIS_KATETERURINE,HOME_CARE_ALATMEDIS_NGT,
					HOME_CARE_ALATMEDIS_OKSIGEN,HOME_CARE_ALATMEDIS_LAINNYA,HOME_CARE_ALATMEDIS_LAINNYA_KET,EDUKASI_OBAT,EDUKASI_NYERI,EDUKASI_DIET,
					EDUKASI_CARITOLONG,EDUKASI_PERAWATAN,EDUKASI_LAINNYA,EDUKASI_LAINNYA_KET,FASKES_PUSKESMAS,FASKES_RS,FASKES_KLINIK,
					FASKES_DOKTER_KELUARGA,FASKES_RUMAH_RAWAT,FASKES_BIDAN_PRAKTEK,FASKES_LAINNYA,FASKES_LAINNYA_KET,DIET_JENIS,DIET_JUMLAH,
					DIET_WAKTU,TRANSPORTASI_AMBULANCE,TRANSPORTASI_PRIBADI,TRANSPORTASI_UMUM,YAYASAN_JANTUNG,YAYASAN_STROKE,YAYASAN_LAINNYA,
					YAYASAN_LAINNYA_KET,RENCANA_TINDAK_LANJUT
					FROM t_irja_rencana_pulang
					WHERE IRJA_RENCANA_PULANG_ID = "' . $idx . '"';				
}else if($perawatan == 'RI'){
	$jns_rawat = '2';
	$qry_pasien = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,t_irna.RUANG_ID AS UNIT_ID,
					CONCAT(m_ruang.NAMA_RUANG," ",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
					m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID
					FROM t_irna
					INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
					INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
					LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_irna.IRNA_ID = "' . $idx . '"';
	$qry_pemulangan = 'SELECT IRNA_RENCANA_PULANG_ID,OBAT_LANJUT_NAMA,OBAT_LANJUT_JUMLAH,OBAT_LANJUT_WAKTU,OBAT_LANJUT_CARA,LINGKUNGAN_AIR_BERSIH,
					LINGKUNGAN_VENTILASI,LINGKUNGAN_FASILITAS,LINGKUNGAN_KETERAMPILAN_RAWAT_LUKA,LINGKUNGAN_KETERAMPILAN_INJEKSI,
					LINGKUNGAN_KETERAMPILAN_PERAWATAN_BAYI,LINGKUNGAN_KETERAMPILAN_LAINNYA,LINGKUNGAN_KETERAMPILAN_LAINNYA_KET,LINGKUNGAN_FASKES,
					HOME_CARE_MAKAN,HOME_CARE_MINUM,HOME_CARE_MANDI,HOME_CARE_BAK,HOME_CARE_BAB,HOME_CARE_BERPAKAIAN,HOME_CARE_ALATBANTU_TONGKAT,
					HOME_CARE_ALATBANTU_KURSI,HOME_CARE_ALATBANTU_WALKER,HOME_CARE_ALATMEDIS_KATETERURINE,HOME_CARE_ALATMEDIS_NGT,
					HOME_CARE_ALATMEDIS_OKSIGEN,HOME_CARE_ALATMEDIS_LAINNYA,HOME_CARE_ALATMEDIS_LAINNYA_KET,EDUKASI_OBAT,EDUKASI_NYERI,EDUKASI_DIET,
					EDUKASI_CARITOLONG,EDUKASI_PERAWATAN,EDUKASI_LAINNYA,EDUKASI_LAINNYA_KET,FASKES_PUSKESMAS,FASKES_RS,FASKES_KLINIK,
					FASKES_DOKTER_KELUARGA,FASKES_RUMAH_RAWAT,FASKES_BIDAN_PRAKTEK,FASKES_LAINNYA,FASKES_LAINNYA_KET,DIET_JENIS,DIET_JUMLAH,
					DIET_WAKTU,TRANSPORTASI_AMBULANCE,TRANSPORTASI_PRIBADI,TRANSPORTASI_UMUM,YAYASAN_JANTUNG,YAYASAN_STROKE,YAYASAN_LAINNYA,
					YAYASAN_LAINNYA_KET,RENCANA_TINDAK_LANJUT
					FROM t_irna_rencana_pulang
					WHERE IRNA_RENCANA_PULANG_ID = "' . $idx . '"';				
}

$get_pemulangan = mysql_query($qry_pemulangan) or die(mysql_error());
if(mysql_num_rows($get_pemulangan) > 0){
	$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
	$dat_pasien = mysql_fetch_assoc($get_pasien);
	
	$dat_pemulangan = mysql_fetch_assoc($get_pemulangan);

	$nomr = $dat_pasien['NOMR'];
	$nama_pasien = $dat_pasien['NAMA_PASIEN'];
	$tgl_lahir = $dat_pasien['TGL_LAHIR'];
	$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
	$unit_id = $dat_pasien['NAMA_UNIT'];
	$dokter = $dat_pasien['NAMA_PEGAWAI'];

	$edoc_norm = formatNoMR($nomr);
	$edoc_nama_pasien = $nama_pasien;
	$edoc_tanggal_lahir = changeDateFormat($tgl_lahir);
	$edoc_jenis_kelamin = jenisKelamin($jns_kelamin);
	$edoc_unit = $unit_id;
	$edoc_nama_documen = strtoupper($jenis_document);
	
	$obat_lanjut_nama = $dat_pemulangan['OBAT_LANJUT_NAMA'];
	$obat_lanjut_jumlah = $dat_pemulangan['OBAT_LANJUT_JUMLAH'];
	$obat_lanjut_waktu = $dat_pemulangan['OBAT_LANJUT_WAKTU'];
	$obat_lanjut_cara = $dat_pemulangan['OBAT_LANJUT_CARA'];
	$lingkungan_air_bersih = $dat_pemulangan['LINGKUNGAN_AIR_BERSIH'];
	$lingkungan_ventilasi = $dat_pemulangan['LINGKUNGAN_VENTILASI'];
	$lingkungan_fasilitas = $dat_pemulangan['LINGKUNGAN_FASILITAS'];
	$lingkungan_keterampilan_rawat_luka = $dat_pemulangan['LINGKUNGAN_KETERAMPILAN_RAWAT_LUKA'];
	$lingkungan_keterampilan_injeksi = $dat_pemulangan['LINGKUNGAN_KETERAMPILAN_INJEKSI'];
	$lingkungan_keterampilan_perawatan_bayi = $dat_pemulangan['LINGKUNGAN_KETERAMPILAN_PERAWATAN_BAYI'];
	$lingkungan_keterampilan_lainnya = $dat_pemulangan['LINGKUNGAN_KETERAMPILAN_LAINNYA'];
	$lingkungan_keterampilan_lainnya_ket = $dat_pemulangan['LINGKUNGAN_KETERAMPILAN_LAINNYA_KET'];
	$lingkungan_faskes = $dat_pemulangan['LINGKUNGAN_FASKES'];
	$home_care_makan = $dat_pemulangan['HOME_CARE_MAKAN'];
	$home_care_minum = $dat_pemulangan['HOME_CARE_MINUM'];
	$home_care_mandi = $dat_pemulangan['HOME_CARE_MANDI'];
	$home_care_bak = $dat_pemulangan['HOME_CARE_BAK'];
	$home_care_bab = $dat_pemulangan['HOME_CARE_BAB'];
	$home_care_berpakaian = $dat_pemulangan['HOME_CARE_BERPAKAIAN'];
	$home_care_alatbantu_tongkat = $dat_pemulangan['HOME_CARE_ALATBANTU_TONGKAT'];
	$home_care_alatbantu_kursi = $dat_pemulangan['HOME_CARE_ALATBANTU_KURSI'];
	$home_care_alatbantu_walker = $dat_pemulangan['HOME_CARE_ALATBANTU_WALKER'];
	$home_care_alatmedis_kateterurine = $dat_pemulangan['HOME_CARE_ALATMEDIS_KATETERURINE'];
	$home_care_alatmedis_ngt = $dat_pemulangan['HOME_CARE_ALATMEDIS_NGT'];
	$home_care_alatmedis_oksigen = $dat_pemulangan['HOME_CARE_ALATMEDIS_OKSIGEN'];
	$home_care_alatmedis_lainnya = $dat_pemulangan['HOME_CARE_ALATMEDIS_LAINNYA'];
	$home_care_alatmedis_lainnya_ket = $dat_pemulangan['HOME_CARE_ALATMEDIS_LAINNYA_KET'];
	$edukasi_obat = $dat_pemulangan['EDUKASI_OBAT'];
	$edukasi_nyeri = $dat_pemulangan['EDUKASI_NYERI'];
	$edukasi_diet = $dat_pemulangan['EDUKASI_DIET'];
	$edukasi_caritolong = $dat_pemulangan['EDUKASI_CARITOLONG'];
	$edukasi_perawatan = $dat_pemulangan['EDUKASI_PERAWATAN'];
	$edukasi_lainnya = $dat_pemulangan['EDUKASI_LAINNYA'];
	$edukasi_lainnya_ket = $dat_pemulangan['EDUKASI_LAINNYA_KET'];
	$faskes_puskesmas = $dat_pemulangan['FASKES_PUSKESMAS'];
	$faskes_rs = $dat_pemulangan['FASKES_RS'];
	$faskes_klinik = $dat_pemulangan['FASKES_KLINIK'];
	$faskes_dokter_keluarga = $dat_pemulangan['FASKES_DOKTER_KELUARGA'];
	$faskes_rumah_rawat = $dat_pemulangan['FASKES_RUMAH_RAWAT'];
	$faskes_bidan_praktek = $dat_pemulangan['FASKES_BIDAN_PRAKTEK'];
	$faskes_lainnya = $dat_pemulangan['FASKES_LAINNYA'];
	$faskes_lainnya_ket = $dat_pemulangan['FASKES_LAINNYA_KET'];
	$diet_jenis = $dat_pemulangan['DIET_JENIS'];
	$diet_jumlah = $dat_pemulangan['DIET_JUMLAH'];
	$diet_waktu = $dat_pemulangan['DIET_WAKTU'];
	$transportasi_ambulance = $dat_pemulangan['TRANSPORTASI_AMBULANCE'];
	$transportasi_pribadi = $dat_pemulangan['TRANSPORTASI_PRIBADI'];
	$transportasi_umum = $dat_pemulangan['TRANSPORTASI_UMUM'];
	$yayasan_jantung = $dat_pemulangan['YAYASAN_JANTUNG'];
	$yayasan_stroke = $dat_pemulangan['YAYASAN_STROKE'];
	$yayasan_lainnya = $dat_pemulangan['YAYASAN_LAINNYA'];
	$yayasan_lainnya_ket = $dat_pemulangan['YAYASAN_LAINNYA_KET'];
	$rencana_tindak_lanjut = $dat_pemulangan['RENCANA_TINDAK_LANJUT'];

	$edoc_content = '<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >
		<tr>
			<td colspan="4">&nbsp;</td>
			<td align="center" width="75px">&nbsp;</td>
			<td align="center" width="75px">&nbsp;</td>
			</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
			<td align="center" >Ya</td>
			<td align="center" >Tidak</td>
		</tr>
		<tr>
			<td colspan="6">1. Bagaimana pasien dan keluarga mengetahui tentang obat yang harus dilanjutkan di rumah ?</td>
		</tr>
		<tr>
			<td width="80px">&nbsp;</td>
			<td colspan="3">a. Nama obatnya</td>
			<td align="center"><input type="radio" name="obat_lanjut_nama" id="obat_lanjut_nama" value="1" ' . (($obat_lanjut_nama=='1') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="radio" name="obat_lanjut_nama" id="obat_lanjut_nama2" value="2" ' . (($obat_lanjut_nama=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">b. Jumlahnya</td>
		<td align="center"><input type="radio" name="obat_lanjut_jumlah" id="obat_lanjut_jumlah" value="1" ' . (($obat_lanjut_jumlah=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="obat_lanjut_jumlah" id="obat_lanjut_jumlah2" value="2" ' . (($obat_lanjut_jumlah=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">c. Waktu pemberiannya</td>
		<td align="center"><input type="radio" name="obat_lanjut_waktu" id="obat_lanjut_waktu" value="1" ' . (($obat_lanjut_waktu=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="obat_lanjut_waktu" id="obat_lanjut_waktu2" value="2" ' . (($obat_lanjut_waktu=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">d. Cara pemberiannya</td>
		<td align="center"><input type="radio" name="obat_lanjut_cara" id="obat_lanjut_cara" value="1" ' . (($obat_lanjut_cara=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="obat_lanjut_cara" id="obat_lanjut_cara2" value="2" ' . (($obat_lanjut_cara=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td colspan="6">2. Bagaimana pasien mengetahui tentang lingkungan yang aman dan nyaman di rumah setelah keluar dari rumah sakit ?</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">a. Air bersih</td>
		<td align="center"><input type="radio" name="lingkungan_air_bersih" id="lingkungan_air_bersih" value="1" ' . (($lingkungan_air_bersih=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="lingkungan_air_bersih" id="lingkungan_air_bersih2" value="2" ' . (($lingkungan_air_bersih=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">b. Ventilasi udara yang cukup</td>
		<td align="center"><input type="radio" name="lingkungan_ventilasi" id="lingkungan_ventilasi" value="1" ' . (($lingkungan_ventilasi=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="lingkungan_ventilasi" id="lingkungan_ventilasi2" value="2" ' . (($lingkungan_ventilasi=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">c. Fasilitas dan peralatan yang dibutuhkan sesuai dengan kondisi pasien</td>
		<td align="center"><input type="radio" name="lingkungan_fasilitas" id="lingkungan_fasilitas" value="1" ' . (($lingkungan_fasilitas=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="lingkungan_fasilitas" id="lingkungan_fasilitas2" value="2" ' . (($lingkungan_fasilitas=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="5">d. Keterampilan Khusus</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">1. Perawatan Luka</td>
		<td align="center"><input type="radio" name="lingkungan_keterampilan_rawat_luka" id="lingkungan_keterampilan_rawat_luka" value="1" ' . (($lingkungan_keterampilan_rawat_luka=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="lingkungan_keterampilan_rawat_luka" id="lingkungan_keterampilan_rawat_luka2" value="2" ' . (($lingkungan_keterampilan_rawat_luka=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">2. Injeksi</td>
		<td align="center"><input type="radio" name="lingkungan_keterampilan_injeksi" id="lingkungan_keterampilan_injeksi" value="1" ' . (($lingkungan_keterampilan_injeksi=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="lingkungan_keterampilan_injeksi" id="lingkungan_keterampilan_injeksi2" value="2" ' . (($lingkungan_keterampilan_injeksi=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">3. Perawatan bayi</td>
		<td align="center"><input type="radio" name="lingkungan_keterampilan_perawatan_bayi" id="lingkungan_keterampilan_perawatan_bayi" value="1" ' . (($lingkungan_keterampilan_perawatan_bayi=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="lingkungan_keterampilan_perawatan_bayi" id="lingkungan_keterampilan_perawatan_bayi2" value="2" ' . (($lingkungan_keterampilan_perawatan_bayi=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">4. Lainnya ' . setGarisIfNull($lingkungan_keterampilan_lainnya_ket) . '</td>
		<td align="center"><input type="radio" name="lingkungan_keterampilan_lainnya" id="lingkungan_keterampilan_lainnya" value="1" ' . (($lingkungan_keterampilan_lainnya=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="lingkungan_keterampilan_lainnya" id="lingkungan_keterampilan_lainnya2" value="2" ' . (($lingkungan_keterampilan_lainnya=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">e. Fasilitas kesehatan yang dekat dari rumah</td>
		<td align="center">
		<input type="radio" name="lingkungan_faskes" id="lingkungan_faskes" value="1" ' . (($lingkungan_faskes=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center">
		<input type="radio" name="lingkungan_faskes" id="lingkungan_faskes2" value="2" ' . (($lingkungan_faskes=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td colspan="6">3. Bagaimana pasien dan keluarga memerlukan bantuan/ perawatn khusus di rumah setelah keluar<br />dari rumah sakit (home care/ home visite) ?</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">a. Makan</td>
		<td align="center"><input type="radio" name="home_care_makan" id="home_care_makan" value="1" ' . (($home_care_makan=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_makan" id="home_care_makan2" value="2" ' . (($home_care_makan=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">b. Minum</td>
		<td align="center"><input type="radio" name="home_care_minum" id="home_care_minum" value="1" ' . (($home_care_minum=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_minum" id="home_care_minum2" value="2" ' . (($home_care_minum=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">c. Mandi</td>
		<td align="center"><input type="radio" name="home_care_mandi" id="home_care_mandi" value="1" ' . (($home_care_mandi=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_mandi" id="home_care_mandi2" value="2" ' . (($home_care_mandi=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">d. BAK</td>
		<td align="center"><input type="radio" name="home_care_bak" id="home_care_bak" value="1" ' . (($home_care_bak=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_bak" id="home_care_bak2" value="2" ' . (($home_care_bak=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">e. BAB</td>
		<td align="center"><input type="radio" name="home_care_bab" id="home_care_bab" value="1" ' . (($home_care_bab=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_bab" id="home_care_bab2" value="2" ' . (($home_care_bab=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">f. Berpakaian</td>
		<td align="center"><input type="radio" name="home_care_berpakaian" id="home_care_berpakaian" value="1" ' . (($home_care_berpakaian=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_berpakaian" id="home_care_berpakaian2" value="2" ' . (($home_care_berpakaian=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="5">g. Alat Bantu</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">1. Tongkat</td>
		<td align="center"><input type="radio" name="home_care_alatbantu_tongkat" id="home_care_alatbantu_tongkat" value="1" ' . (($home_care_alatbantu_tongkat=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_alatbantu_tongkat" id="home_care_alatbantu_tongkat2" value="2" ' . (($home_care_alatbantu_tongkat=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">2. Kursi</td>
		<td align="center"><input type="radio" name="home_care_alatbantu_kursi" id="home_care_alatbantu_kursi" value="1" ' . (($home_care_alatbantu_kursi=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_alatbantu_kursi" id="home_care_alatbantu_kursi2" value="2" ' . (($home_care_alatbantu_kursi=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">3. Walker</td>
		<td align="center"><input type="radio" name="home_care_alatbantu_walker" id="home_care_alatbantu_walker" value="1" ' . (($home_care_alatbantu_walker=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_alatbantu_walker" id="home_care_alatbantu_walker2" value="2" ' . (($home_care_alatbantu_walker=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="5">h. Peralatan Medis</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">1. Kateter Urine</td>
		<td align="center"><input type="radio" name="home_care_alatmedis_kateterurine" id="home_care_alatmedis_kateterurine" value="1" ' . (($home_care_alatmedis_kateterurine=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_alatmedis_kateterurine" id="home_care_alatmedis_kateterurine2" value="2" ' . (($home_care_alatmedis_kateterurine=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		 <td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">2. NGT</td>
		<td align="center"><input type="radio" name="home_care_alatmedis_ngt" id="home_care_alatmedis_ngt" value="1" ' . (($home_care_alatmedis_ngt=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_alatmedis_ngt" id="home_care_alatmedis_ngt2" value="2" ' . (($home_care_alatmedis_ngt=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		 <td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">3. Oksigen</td>
		<td align="center"><input type="radio" name="home_care_alatmedis_oksigen" id="home_care_alatmedis_oksigen" value="1" ' . (($home_care_alatmedis_oksigen=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_alatmedis_oksigen" id="home_care_alatmedis_oksigen2" value="2" ' . (($home_care_alatmedis_oksigen=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		 <td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">4. Lainnya ' . setGarisIfNull($home_care_alatmedis_lainnya_ket) . '</td>
		<td align="center"><input type="radio" name="home_care_alatmedis_lainnya" id="home_care_alatmedis_lainnya" value="1" ' . (($home_care_alatmedis_lainnya=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_alatmedis_lainnya" id="home_care_alatmedis_lainnya2" value="2" ' . (($home_care_alatmedis_lainnya=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td colspan="6">4. Bagaimana pasien dan keluarga memerlukan edukasi kesehatan setelah keluar dari rumah sakit dalam hal :</td>
	</tr>
	<tr>
		 <td>&nbsp;</td>
		<td colspan="3">a. Obat-obatan</td>
		<td align="center"><input type="radio" name="edukasi_obat" id="edukasi_obat" value="1" ' . (($edukasi_obat=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="edukasi_obat" id="edukasi_obat2" value="2" ' . (($edukasi_obat=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		 <td>&nbsp;</td>
		<td colspan="3">b. Nyeri</td>
		<td align="center"><input type="radio" name="edukasi_nyeri" id="edukasi_nyeri" value="1" ' . (($edukasi_nyeri=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="edukasi_nyeri" id="edukasi_nyeri2" value="2" ' . (($edukasi_nyeri=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		 <td>&nbsp;</td>
		<td colspan="3">c. Diet</td>
		<td align="center"><input type="radio" name="edukasi_diet" id="edukasi_diet" value="1" ' . (($edukasi_diet=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="edukasi_diet" id="edukasi_diet2" value="2" ' . (($edukasi_diet=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">d. Mencari Pertolongan</td>
		<td align="center"><input type="radio" name="edukasi_caritolong" id="edukasi_caritolong" value="1" ' . (($edukasi_caritolong=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="edukasi_caritolong" id="edukasi_caritolong2" value="2" ' . (($edukasi_caritolong=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">e. Tindak lanjut pengobatan/ perawatan</td>
		<td align="center"><input type="radio" name="edukasi_perawatan" id="edukasi_perawatan" value="1" ' . (($edukasi_perawatan=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="edukasi_perawatan" id="edukasi_perawatan2" value="2" ' . (($edukasi_perawatan=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">f. Lainnya ' . setGarisIfNull($edukasi_lainnya_ket) . '</td>
		<td align="center"><input type="radio" name="edukasi_lainnya" id="edukasi_lainnya" value="1" ' . (($edukasi_lainnya=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="edukasi_lainnya" id="edukasi_lainnya2" value="2" ' . (($edukasi_lainnya=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td colspan="6">5. Bagaimana pasien dan keluarga mengetahui fasilitas pelayanan kesehatan yang dapat digunakan :</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">a. Puskesmas</td>
		<td align="center"><input type="radio" name="faskes_puskesmas" id="faskes_puskesmas" value="1" ' . (($faskes_puskesmas=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="faskes_puskesmas" id="faskes_puskesmas2" value="2" ' . (($faskes_puskesmas=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">b. Rumah Sakit</td>
		<td align="center"><input type="radio" name="faskes_rs" id="faskes_rs" value="1" ' . (($faskes_rs=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="faskes_rs" id="faskes_rs2" value="2" ' . (($faskes_rs=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">c. Klinik</td>
		<td align="center"><input type="radio" name="faskes_klinik" id="faskes_klinik" value="1" ' . (($faskes_klinik=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="faskes_klinik" id="faskes_klinik2" value="2" ' . (($faskes_klinik=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">d. Dokter keluarga</td>
		<td align="center"><input type="radio" name="faskes_dokter_keluarga" id="faskes_dokter_keluarga" value="1" ' . (($faskes_dokter_keluarga=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="faskes_dokter_keluarga" id="faskes_dokter_keluarga2" value="2" ' . (($faskes_dokter_keluarga=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">e. Rumah perawatan</td>
		<td align="center"><input type="radio" name="faskes_rumah_rawat" id="faskes_rumah_rawat" value="1" ' . (($faskes_rumah_rawat=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="faskes_rumah_rawat" id="faskes_rumah_rawat2" value="2" ' . (($faskes_rumah_rawat=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">f. Bidan praktek</td>
		<td align="center"><input type="radio" name="faskes_bidan_praktek" id="faskes_bidan_praktek" value="1" ' . (($faskes_bidan_praktek=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="faskes_bidan_praktek" id="faskes_bidan_praktek2" value="2" ' . (($faskes_bidan_praktek=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">g. Lainnya ' . setGarisIfNull($faskes_lainnya_ket) . '</td>
		<td align="center"><input type="radio" name="faskes_lainnya" id="faskes_lainnya" value="1" ' . (($faskes_lainnya=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="faskes_lainnya" id="faskes_lainnya2" value="2" ' . (($faskes_lainnya=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td colspan="6">6. Bagaimana pasien dan keluarga mengetahui tentang diet yang diperbolehkan untuk pasien ?</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">a. Jenisnya</td>
		<td align="center"><input type="radio" name="diet_jenis" id="diet_jenis" value="1" ' . (($diet_jenis=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="diet_jenis" id="diet_jenis2" value="2" ' . (($diet_jenis=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">b. Jumlahnya</td>
		<td align="center"><input type="radio" name="diet_jumlah" id="diet_jumlah" value="1" ' . (($diet_jumlah=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="diet_jumlah" id="diet_jumlah2" value="2" ' . (($diet_jumlah=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">c. Waktunya</td>
		<td align="center"><input type="radio" name="diet_waktu" id="diet_waktu" value="1" ' . (($diet_waktu=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="diet_waktu" id="diet_waktu2" value="2" ' . (($diet_waktu=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	</table>';
	
	$edoc_content_2 = '<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >
		<tr>
			<td colspan="4">&nbsp;</td>
			<td align="center" width="75px">&nbsp;</td>
			<td align="center" width="75px">&nbsp;</td>
			</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
			<td align="center" >Ya</td>
			<td align="center" >Tidak</td>
		</tr>
	<tr>
		<td colspan="6">7. Bagaimana pasien dan keluarga mengetahui tentang transportasi yang dapat digunakan ?</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">a. Ambulance</td>
		<td align="center"><input type="radio" name="transportasi_ambulance" id="transportasi_ambulance" value="1" ' . (($transportasi_ambulance=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="transportasi_ambulance" id="transportasi_ambulance2" value="2" ' . (($transportasi_ambulance=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">b. Kendaraan pribadi</td>
		<td align="center"><input type="radio" name="transportasi_pribadi" id="transportasi_pribadi" value="1" ' . (($transportasi_pribadi=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="transportasi_pribadi" id="transportasi_pribadi2" value="2" ' . (($transportasi_pribadi=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">c. Kendaraan umum</td>
		<td align="center"><input type="radio" name="transportasi_umum" id="transportasi_umum" value="1" ' . (($transportasi_umum=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="transportasi_umum" id="transportasi_umum2" value="2" ' . (($transportasi_umum=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>	
	<tr>
		<td colspan="6">8. Bagaimana pasien dan keluarga mengetahui tentang yayasan penyakit sejenis yang ada di lingkungannya ?</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">a. Yayasan jantung sehat</td>
		<td align="center"><input type="radio" name="yayasan_jantung" id="yayasan_jantung" value="1" ' . (($yayasan_jantung=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="yayasan_jantung" id="yayasan_jantung2" value="2" ' . (($yayasan_jantung=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">b. Yayasan stroke</td>
		<td align="center"><input type="radio" name="yayasan_stroke" id="yayasan_stroke" value="1" ' . (($yayasan_stroke=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="yayasan_stroke" id="yayasan_stroke2" value="2" ' . (($yayasan_stroke=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">c. Lainnya ' . setGarisIfNull($yayasan_lainnya_ket) . '</td>
		<td align="center"><input type="radio" name="yayasan_lainnya" id="yayasan_lainnya" value="1" ' . (($yayasan_lainnya=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="yayasan_lainnya" id="yayasan_lainnya2" value="2" ' . (($yayasan_lainnya=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td colspan="6">9. Rencana tindak lanjut setelah perawatan di Rumah Sakit :</td>
	</tr>
	<tr>
		<td>&nbsp;</td><td colspan="5">' . setGarisIfNull($rencana_tindak_lanjut) . '</td>
	</tr>
	<tr>
		<td colspan="6" align="right">&nbsp;</td>
	</tr>
	</table>'; 		  

	ob_start();
	include('edoc_rekammedik/edoc_frame_main.php');
	$html = ob_get_contents();
	ob_end_clean();
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_add.php');
	$html_2 = ob_get_contents();
	ob_end_clean();

	createFolder($nomr);
	$filename = $nomr . '_' . $perawatan . $idx . '_' . $id_document . '.pdf' ;

	$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
	$mpdf->autoPageBreak = false;
	$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
	$mpdf->SetHTMLFooter(setFooter($jenis_document));
	$mpdf->WriteHTML($html);
	$mpdf->AddPage('P');
	$mpdf->WriteHTML($html_2);
	$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	

	saveData($nomr,$idx,$jns_rawat,$id_document,$filename,$user_name,'','');
	}
}
?>