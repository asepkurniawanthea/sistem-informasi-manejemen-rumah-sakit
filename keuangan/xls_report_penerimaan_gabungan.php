<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');
include('./shared/enum_function.php');

foreach(getArrJnsBayar() as $row){
	$arr_jaminan[$row['id']] = $row['nama'];
}

$tgl_1 = $_POST['tgl_1'];
$tgl_2 = $_POST['tgl_2'];
$jns_bayar = $_POST['jns_bayar'];		


$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

if($tgl_1 == '') $tgl_1 = date('d-m-Y');
if($tgl_2 == '') $tgl_2 = date('d-m-Y');

$cash = '';
if (isset($_POST['cash']))
    $cash = $_POST['cash'];

$rekening = '';
if (isset($_POST['rekening']))
    $rekening = $_POST['rekening'];	
?>
<table border="1">
	<tr>
        <th colspan="76">Report Penerimaan Gabungan Jenis Pembayaran <?php 
			if($jns_bayar == ''){ 
				echo '-';
			}else{
				$sql_jaminan = 'SELECT NAMA_JAMINAN FROM m_jaminan WHERE JAMINAN_ID = "' . $jns_bayar . '"';
				$get_jaminan = mysql_query($sql_jaminan) or die(mysql_error());
				$dat_jaminan = mysql_fetch_assoc($get_jaminan);
				echo $dat_jaminan['NAMA_JAMINAN'];
			}	
		?>
		Tanggal <?php echo $tgl_1; ?> S/d <?php echo $tgl_2; ?></th>
   </tr>
   <tr>
    <th rowspan="2">No</th>
	<th rowspan="2">Jenis Bayar</th>
	<th rowspan="2">No MR</th>
	<th rowspan="2">Nama Pasien/ Nama Penyewa </th>
	<th rowspan="2">Nama Unit/ Ruang </th>
    <th rowspan="2">Tgl Masuk </th>
    <th rowspan="2">Tgl Keluar</th>
	<th colspan="2"><div onclick="open_def_report('akomodasi','1');">Akomodasi</div></th>
	<th colspan="3"><div onclick="open_def_report('visit dokter umum','2');">Visit<br />Dokter Umum</div></th>
	<th colspan="3"><div onclick="open_def_report('visit dokter spesialis','2');">Visit Dokter<br />Spesialis</div></th>
	<th colspan="2"><div onclick="open_def_report('tindakan rawat inap','1');">Tindakan<br />Rawat Inap</div></th>
	<th colspan="2"><div onclick="open_def_report('karcis','1');">Karcis IGD</div></th>
	<th colspan="3"><div onclick="open_def_report('konsul dokter umum igd','2');">Konsul Dokter Umum IGD</div></th>
	<th colspan="3"><div onclick="open_def_report('konsul dokter spesialis igd','2');">Konsul Dokter Spesialis IGD</div></th>
	<th colspan="2"><div onclick="open_def_report('tindakan igd','1');">Tindakan IGD</div></th>
	<th colspan="2">Karcis Poli </th>
	<th colspan="3"><div onclick="open_def_report('konsul dokter umum rawat jalan','2');">Konsul Dokter Umum Poli</div></th>
	<th colspan="3"><div onclick="open_def_report('konsul dokter spesialis rawat jalan','2');">Konsul Dokter Spesialis Poli</div></th>
	<th colspan="2"><div onclick="open_def_report('tindakan rawat jalan','1');">Tindakan Poli</div></th>
	<th colspan="3"><div onclick="open_def_report('konsul dokter umum operasi','2');">Konsul Dokter Umum Bedah OK</div></th>
	<th colspan="3"><div onclick="open_def_report('konsul dokter spesialis operasi','2');">Konsul Dokter Spesialis Bedah OK</div></th>
	
	<th colspan="2"><div onclick="open_def_report('operasi','1');">Operasi</div></th>
	
	<th colspan="2"><div onclick="open_def_report('laboratorium','1');">Laboratorium</div></th>
	<th colspan="2"><div onclick="open_def_report('radiologi','1');">Radiologi</div></th>
	<th colspan="2"><div onclick="open_def_report('fisioterapi','1');">Fisioterapi</div></th>
	<th colspan="2"><div onclick="open_def_report('okupasi terapi','1');">Okupasi Terapi</div></th>
	<th colspan="2"><div onclick="open_def_report('prothese','1');">Prothese</div></th>
	<th colspan="2"><div onclick="open_def_report('psikologi','1');">Psikologi</div></th>
	
	<th colspan="2"><div onclick="open_def_report('terapi wicara','1');">Terapi Wicara</div></th>
	<th colspan="2"><div onclick="open_def_report('perawatan luka','1');">Perawatan Luka</div></th>
	
	<th colspan="2">Farmasi</th>
	<th colspan="2"><div onclick="open_def_report('pmi','1');">PMI</div></th>
	
	<th colspan="2"><div onclick="open_def_report('skrining gizi','1');">Skrining<br />Gizi</div></th>
	
	<th colspan="2"><div onclick="open_def_report('askep','1');">Askep</div></th>
	<th colspan="2"><div onclick="open_def_report('sewa lahan','1');">Sewa Lahan/ Gedung</div></th>
	<th colspan="2"><div onclick="open_def_report('diklat','1');">Diklat</div></th>
	<th colspan="2"><div onclick="open_def_report('jenazah','1');">Pemulasaraan Jenazah</div></th>
	<th colspan="2"><div onclick="open_def_report('ambulance','1');">Ambulance</div></th>
	<th colspan="2"><div onclick="open_def_report('londry','1');">Jasa Laundry</div></th>
	<th colspan="2">Return Farmasi</th>
	<th rowspan="2">Total</th>
	<th colspan="3">Pembayaran Umum</th>
  </tr>
   <tr>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Nama </th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Nama</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
	 <th>Nama</th>
     <th>Jml</th>
     <th>Biaya</th>
	 <th>Nama</th>
     <th>Jml</th>
     <th>Biaya</th>
	 <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Nama</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Nama</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Nama</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Nama</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
     <th>Jml</th>
     <th>Biaya</th>
	 <th>Jml</th>
     <th>Biaya</th>
	 <th>Jml</th>
     <th>Biaya</th>
	 <th>Jml</th>
     <th>Biaya</th>
	 <th>Jml</th>
     <th>Biaya</th>
	 <th>Jml</th>
     <th>Biaya</th>
     <th>Jenis</th>
     <th>Potongan</th>
     <th>Rekening</th>	
   </tr>
<?php $no = 1; 
$qry_pembayaran = 'SELECT TANGGAL,JENIS_BAYAR,METODE_BAYAR,METODE_BAYAR_POTONGAN,METODE_BAYAR_REKENING,KODE_AKUN,
		RAWAT_ID,NOMR,NAMA_PASIEN,UNIT,TGL_MASUK,TGL_KELUAR,
		SUM(AKOMODASI_JML) AS AKOMODASI_JML,
		SUM(AKOMODASI_BIAYA) AS AKOMODASI_BIAYA,
		GROUP_CONCAT(VISIT_DOKTER_UMUM_NAMA SEPARATOR "|") AS VISIT_DOKTER_UMUM_NAMA,
		GROUP_CONCAT(VISIT_DOKTER_UMUM_JML SEPARATOR "|") AS VISIT_DOKTER_UMUM_JML,
		SUM(VISIT_DOKTER_UMUM_BIAYA) AS VISIT_DOKTER_UMUM_BIAYA,
		GROUP_CONCAT(VISIT_DOKTER_SPESIALIS_NAMA SEPARATOR "|") AS VISIT_DOKTER_SPESIALIS_NAMA,
		GROUP_CONCAT(VISIT_DOKTER_SPESIALIS_JML SEPARATOR "|") AS VISIT_DOKTER_SPESIALIS_JML,
		SUM(VISIT_DOKTER_SPESIALIS_BIAYA) AS VISIT_DOKTER_SPESIALIS_BIAYA,
		SUM(TINDAKAN_RANAP_JML) AS TINDAKAN_RANAP_JML,SUM(TINDAKAN_RANAP_BIAYA) AS TINDAKAN_RANAP_BIAYA,
		SUM(KARCIS_IGD_JML) AS KARCIS_IGD_JML,SUM(KARCIS_IGD_BIAYA) AS KARCIS_IGD_BIAYA,
		GROUP_CONCAT(KONSUL_DOKTER_UMUM_IGD_NAMA SEPARATOR "|") AS KONSUL_DOKTER_UMUM_IGD_NAMA,
		GROUP_CONCAT(KONSUL_DOKTER_UMUM_IGD_JML SEPARATOR "|") AS KONSUL_DOKTER_UMUM_IGD_JML,
		SUM(KONSUL_DOKTER_UMUM_IGD_BIAYA) AS KONSUL_DOKTER_UMUM_IGD_BIAYA,
		GROUP_CONCAT(KONSUL_DOKTER_SPESIALIS_IGD_NAMA SEPARATOR "|") AS KONSUL_DOKTER_SPESIALIS_IGD_NAMA,
		GROUP_CONCAT(KONSUL_DOKTER_SPESIALIS_IGD_JML SEPARATOR "|") AS KONSUL_DOKTER_SPESIALIS_IGD_JML,
		SUM(KONSUL_DOKTER_SPESIALIS_IGD_BIAYA) AS KONSUL_DOKTER_SPESIALIS_IGD_BIAYA,
		SUM(TINDAKAN_IGD_JML) AS TINDAKAN_IGD_JML,SUM(TINDAKAN_IGD_BIAYA) AS TINDAKAN_IGD_BIAYA,
		SUM(KARCIS_POLI_JML) AS KARCIS_POLI_JML,SUM(KARCIS_POLI_BIAYA) KARCIS_POLI_BIAYA,
		GROUP_CONCAT(KONSUL_DOKTER_UMUM_POLI_NAMA SEPARATOR "|") AS KONSUL_DOKTER_UMUM_POLI_NAMA,
		GROUP_CONCAT(KONSUL_DOKTER_UMUM_POLI_JML SEPARATOR "|") AS KONSUL_DOKTER_UMUM_POLI_JML,
		SUM(KONSUL_DOKTER_UMUM_POLI_BIAYA) AS KONSUL_DOKTER_UMUM_POLI_BIAYA,
		GROUP_CONCAT(KONSUL_DOKTER_SPESIALIS_POLI_NAMA SEPARATOR "|") AS KONSUL_DOKTER_SPESIALIS_POLI_NAMA,
		GROUP_CONCAT(KONSUL_DOKTER_SPESIALIS_POLI_JML SEPARATOR "|") AS KONSUL_DOKTER_SPESIALIS_POLI_JML,
		SUM(KONSUL_DOKTER_SPESIALIS_POLI_BIAYA) AS KONSUL_DOKTER_SPESIALIS_POLI_BIAYA,
		SUM(TINDAKAN_POLI_JML) AS TINDAKAN_POLI_JML,SUM(TINDAKAN_POLI_BIAYA) AS TINDAKAN_POLI_BIAYA,
		GROUP_CONCAT(KONSUL_DOKTER_UMUM_BEDAH_NAMA SEPARATOR "|") AS KONSUL_DOKTER_UMUM_BEDAH_NAMA,
		GROUP_CONCAT(KONSUL_DOKTER_UMUM_BEDAH_JML SEPARATOR "|") AS KONSUL_DOKTER_UMUM_BEDAH_JML,
		SUM(KONSUL_DOKTER_UMUM_BEDAH_BIAYA) AS KONSUL_DOKTER_UMUM_BEDAH_BIAYA,
		GROUP_CONCAT(KONSUL_DOKTER_SPESIALIS_BEDAH_NAMA SEPARATOR "|") AS KONSUL_DOKTER_SPESIALIS_BEDAH_NAMA,
		GROUP_CONCAT(KONSUL_DOKTER_SPESIALIS_BEDAH_JML SEPARATOR "|") AS KONSUL_DOKTER_SPESIALIS_BEDAH_JML,
		SUM(KONSUL_DOKTER_SPESIALIS_BEDAH_BIAYA) AS KONSUL_DOKTER_SPESIALIS_BEDAH_BIAYA,
		SUM(OPERASI_JML) AS OPERASI_JML,SUM(OPERASI_BIAYA) AS OPERASI_BIAYA,
		SUM(LABORATORIUM_JML) AS LABORATORIUM_JML,SUM(LABORATORIUM_BIAYA) AS LABORATORIUM_BIAYA,
		SUM(RADIOLOGI_JML) AS RADIOLOGI_JML,SUM(RADIOLOGI_BIAYA) AS RADIOLOGI_BIAYA,
		SUM(FISIOTERAPI_JML) AS FISIOTERAPI_JML,SUM(FISIOTERAPI_BIAYA) AS FISIOTERAPI_BIAYA,
		SUM(OKUPASI_JML) AS OKUPASI_JML,SUM(OKUPASI_BIAYA) AS OKUPASI_BIAYA,
		SUM(PROTHESE_JML) AS PROTHESE_JML,SUM(PROTHESE_BIAYA) AS PROTHESE_BIAYA,
		SUM(PSIKOLOGI_JML) AS PSIKOLOGI_JML,SUM(PSIKOLOGI_BIAYA) AS PSIKOLOGI_BIAYA,
		SUM(TERAPI_WICARA_JML) AS TERAPI_WICARA_JML,SUM(TERAPI_WICARA_BIAYA) AS TERAPI_WICARA_BIAYA,
		SUM(PERAWATAN_LUKA_JML) AS PERAWATAN_LUKA_JML,SUM(PERAWATAN_LUKA_BIAYA) AS PERAWATAN_LUKA_BIAYA,
		SUM(FARMASI_JML) AS FARMASI_JML,SUM(FARMASI_BIAYA) AS FARMASI_BIAYA,
		SUM(PMI_JML) AS PMI_JML,SUM(PMI_BIAYA) AS PMI_BIAYA,
		SUM(SKRINING_GIZI_JML) AS SKRINING_GIZI_JML,SUM(SKRINING_GIZI_BIAYA) AS SKRINING_GIZI_BIAYA,
		SUM(ASKEP_JML) AS ASKEP_JML,SUM(ASKEP_BIAYA) AS ASKEP_BIAYA,
		SUM(SEWA_LAHAN_JML) AS SEWA_LAHAN_JML,SUM(SEWA_LAHAN_BIAYA) AS SEWA_LAHAN_BIAYA,
		SUM(DIKLAT_JML) AS DIKLAT_JML,SUM(DIKLAT_BIAYA) AS DIKLAT_BIAYA,
		SUM(PEMULASARAAN_JENAZAH_JML) AS PEMULASARAAN_JENAZAH_JML,SUM(PEMULASARAAN_JENAZAH_BIAYA) AS PEMULASARAAN_JENAZAH_BIAYA,
		SUM(AMBULANCE_JML) AS AMBULANCE_JML,SUM(AMBULANCE_BIAYA) AS AMBULANCE_BIAYA,
		SUM(JASA_LAUNDRY_JML) AS JASA_LAUNDRY_JML,SUM(JASA_LAUNDRY_BIAYA) AS JASA_LAUNDRY_BIAYA,
		SUM(RETURN_FARMASI_JML) AS RETURN_FARMASI_JML,SUM(RETURN_FARMASI_BIAYA) AS RETURN_FARMASI_BIAYA
		FROM db_simkeu.r_lap_gabungan
		WHERE TANGGAL >= ' . $tgl_filter_1 . ' AND TANGGAL <= ' . $tgl_filter_2 . '
		' . (($jns_bayar != '') ? 'AND JENIS_BAYAR = "' . $jns_bayar . '"' : '') . '
		' . (($cash != '') ? 'AND METODE_BAYAR = "' . $cash . '"' : '') . '
		' . (($rekening != '') ? 'AND METODE_BAYAR_REKENING = "' . $rekening . '"' : '') . '
		GROUP BY TANGGAL,JENIS_BAYAR,METODE_BAYAR,METODE_BAYAR_POTONGAN,METODE_BAYAR_REKENING,KODE_AKUN,
		RAWAT_ID,NOMR,NAMA_PASIEN,UNIT,TGL_MASUK,TGL_KELUAR
		ORDER BY RAWAT_ID';	
$get_pembayaran = mysql_query($qry_pembayaran) or die(mysql_error());	
$jml_akomodasi = 0;
$jml_visit_dokter_umum = 0;
$jml_visit_dokter_spesialis = 0;
$jml_tindakan_ri = 0;
$jml_karcis_igd = 0;
$jml_konsul_dokter_umum_igd = 0;
$jml_konsul_dokter_spesialis_igd = 0;
$jml_tindakan_igd = 0;
$jml_karcis_poli = 0;
$jml_konsul_dokter_umum_poli = 0;
$jml_konsul_dokter_spesialis_poli = 0;
$jml_tindakan_poli = 0;
$jml_konsul_dokter_umum_bedahok = 0;
$jml_konsul_dokter_spesialis_bedahok = 0;
$jml_operasi = 0;
$jml_laboratorium = 0;
$jml_radiologi = 0;
$jml_fisioterapi = 0;
$jml_okupasi_terapi = 0;
$jml_protese = 0;
$jml_psikologi = 0;
$jml_terapi_wicara = 0;
$jml_perawatan_luka = 0;
$jml_farmasi = 0;
$jml_pmi = 0;
$jml_skrining_gizi = 0;
$jml_askep = 0;
$jml_sewa_lahan = 0;
$jml_diklat = 0;
$jml_peml_jenazah = 0;
$jml_ambulance = 0;
$jml_londry = 0;
$jml_return_farmasi = 0;

$akomodasi = 0;
$visit_dokter_umum = 0;
$visit_dokter_spesialis = 0;
$tindakan_ri = 0;
$karcis_igd = 0;
$konsul_dokter_umum_igd = 0;
$konsul_dokter_spesialis_igd = 0;
$tindakan_igd = 0;
$karcis_poli = 0;
$konsul_dokter_umum_poli = 0;
$konsul_dokter_spesialis_poli = 0;
$tindakan_poli = 0;
$konsul_dokter_umum_bedahok = 0;
$konsul_dokter_spesialis_bedahok = 0;
$operasi = 0;
$laboratorium = 0;
$radiologi = 0;
$fisioterapi = 0;
$okupasi_terapi = 0;
$protese = 0;
$psikologi = 0;
$terapi_wicara = 0;
$perawatan_luka = 0;
$farmasi = 0;
$pmi = 0;
$skrining_gizi = 0;
$askep = 0;
$sewa_lahan = 0;
$diklat = 0;
$peml_jenazah = 0;
$ambulance = 0;
$londry = 0;
$return_farmasi = 0;

$total = 0;
$no = 1;
while($dat_pembayaran = mysql_fetch_array($get_pembayaran)){ 
	$jml_akomodasi += $dat_pembayaran['AKOMODASI_JML'];
	
	$a_visit_dokter_umum = explode('|',$dat_pembayaran['VISIT_DOKTER_UMUM_JML']);
	if(sizeof($a_visit_dokter_umum) >= 2){
		foreach($a_visit_dokter_umum as $val){
			$jml_visit_dokter_umum += $val + 0;
		}
	}else{
		$jml_visit_dokter_umum += $dat_pembayaran['VISIT_DOKTER_UMUM_JML'] + 0;
	}
		
	$a_visit_dokter_spesialis = explode('|',$dat_pembayaran['VISIT_DOKTER_SPESIALIS_JML']);
	if(sizeof($a_visit_dokter_spesialis) >= 2){
		foreach($a_visit_dokter_spesialis as $val){
			$jml_visit_dokter_spesialis += $val + 0;
		}
	}else{
		$jml_visit_dokter_spesialis += $dat_pembayaran['VISIT_DOKTER_SPESIALIS_JML'] + 0;
	}	
	
	$jml_tindakan_ri += $dat_pembayaran['TINDAKAN_RANAP_JML'];
	$jml_karcis_igd += $dat_pembayaran['KARCIS_IGD_JML'];
	
	$a_konsul_dokter_umum_igd = explode('|',$dat_pembayaran['KONSUL_DOKTER_UMUM_IGD_JML']);
	if(sizeof($a_konsul_dokter_umum_igd) >= 2){
		foreach($a_konsul_dokter_umum_igd as $val){
			$jml_konsul_dokter_umum_igd += $val + 0;
		}
	}else{
		$jml_konsul_dokter_umum_igd += $dat_pembayaran['KONSUL_DOKTER_UMUM_IGD_JML'] + 0;
	}
	
	$a_konsul_dokter_spesialis_igd = explode('|',$dat_pembayaran['KONSUL_DOKTER_SPESIALIS_IGD_JML']);
	if(sizeof($a_konsul_dokter_spesialis_igd) >= 2){
		foreach($a_konsul_dokter_spesialis_igd as $val){
			$jml_konsul_dokter_spesialis_igd += $val + 0;
		}
	}else{
		$jml_konsul_dokter_spesialis_igd += $dat_pembayaran['KONSUL_DOKTER_SPESIALIS_IGD_JML'] + 0;
	}
	
	$jml_tindakan_igd += $dat_pembayaran['TINDAKAN_IGD_JML'];
	$jml_karcis_poli += $dat_pembayaran['KARCIS_POLI_JML'];
	
	$a_konsul_dokter_umum_poli = explode('|',$dat_pembayaran['KONSUL_DOKTER_UMUM_POLI_JML']);
	if(sizeof($a_konsul_dokter_umum_poli) >= 2){
		foreach($a_konsul_dokter_umum_poli as $val){
			$jml_konsul_dokter_umum_poli += $val + 0;
		}
	}else{
		$jml_konsul_dokter_umum_poli += $dat_pembayaran['KONSUL_DOKTER_UMUM_POLI_JML'] + 0;
	}
	
	$a_konsul_dokter_spesialis_poli = explode('|',$dat_pembayaran['KONSUL_DOKTER_SPESIALIS_POLI_JML']);
	if(sizeof($a_konsul_dokter_spesialis_poli) >= 2){
		foreach($a_konsul_dokter_spesialis_poli as $val){
			$jml_konsul_dokter_spesialis_poli += $val + 0;
		}
	}else{
		$jml_konsul_dokter_spesialis_poli += $dat_pembayaran['KONSUL_DOKTER_SPESIALIS_POLI_JML'] + 0;
	}
	
	$jml_tindakan_poli += $dat_pembayaran['TINDAKAN_POLI_JML'];
	
	$a_konsul_dokter_umum_bedahok = explode('|',$dat_pembayaran['KONSUL_DOKTER_UMUM_BEDAH_JML']);
	if(sizeof($a_konsul_dokter_umum_bedahok) >= 2){
		foreach($a_konsul_dokter_umum_bedahok as $val){
			$jml_konsul_dokter_umum_bedahok += $val + 0;
		}
	}else{
		$jml_konsul_dokter_umum_bedahok += $dat_pembayaran['KONSUL_DOKTER_UMUM_BEDAH_JML'] + 0;
	}
	
	$a_konsul_dokter_spesialis_bedahok = explode('|',$dat_pembayaran['KONSUL_DOKTER_SPESIALIS_BEDAH_JML']);
	if(sizeof($a_konsul_dokter_spesialis_bedahok) >= 2){
		foreach($a_konsul_dokter_spesialis_bedahok as $val){
			$jml_konsul_dokter_spesialis_bedahok += $val + 0;
		}
	}else{
		$jml_konsul_dokter_spesialis_bedahok += $dat_pembayaran['KONSUL_DOKTER_SPESIALIS_BEDAH_JML'] + 0;
	}
	
	$jml_operasi += $dat_pembayaran['OPERASI_JML'];
	$jml_laboratorium += $dat_pembayaran['LABORATORIUM_JML'];
	$jml_radiologi += $dat_pembayaran['RADIOLOGI_JML'];
	$jml_fisioterapi += $dat_pembayaran['FISIOTERAPI_JML'];
	$jml_okupasi_terapi += $dat_pembayaran['OKUPASI_JML'];
	$jml_protese += $dat_pembayaran['PROTHESE_JML'];
	$jml_psikologi += $dat_pembayaran['PSIKOLOGI_JML'];
	$jml_terapi_wicara += $dat_pembayaran['TERAPI_WICARA_JML'];
	$jml_perawatan_luka += $dat_pembayaran['PERAWATAN_LUKA_JML'];
	$jml_farmasi += $dat_pembayaran['FARMASI_JML'];
	$jml_pmi += $dat_pembayaran['PMI_JML'];
	$jml_skrining_gizi += $dat_pembayaran['SKRINING_GIZI_JML'];
	$jml_askep += $dat_pembayaran['ASKEP_JML'];
	$jml_sewa_lahan += $dat_pembayaran['SEWA_LAHAN_JML'];
	$jml_diklat += $dat_pembayaran['DIKLAT_JML'];
	$jml_peml_jenazah += $dat_pembayaran['PEMULASARAAN_JENAZAH_JML'];
	$jml_ambulance += $dat_pembayaran['AMBULANCE_JML'];
	$jml_londry += $dat_pembayaran['JASA_LAUNDRY_JML'];
	$jml_return_farmasi += $dat_pembayaran['RETURN_FARMASI_JML'];
	
	$akomodasi += $dat_pembayaran['AKOMODASI_BIAYA'];
	$visit_dokter_umum += $dat_pembayaran['VISIT_DOKTER_UMUM_BIAYA'];
	$visit_dokter_spesialis += $dat_pembayaran['VISIT_DOKTER_SPESIALIS_BIAYA'];
	$tindakan_ri += $dat_pembayaran['TINDAKAN_RANAP_BIAYA'];
	$karcis_igd += $dat_pembayaran['KARCIS_IGD_BIAYA'];
	$konsul_dokter_umum_igd += $dat_pembayaran['KONSUL_DOKTER_UMUM_IGD_BIAYA'];
	$konsul_dokter_spesialis_igd += $dat_pembayaran['KONSUL_DOKTER_SPESIALIS_IGD_BIAYA'];
	$tindakan_igd += $dat_pembayaran['TINDAKAN_IGD_BIAYA'];
	$karcis_poli += $dat_pembayaran['KARCIS_POLI_BIAYA'];
	$konsul_dokter_umum_poli += $dat_pembayaran['KONSUL_DOKTER_UMUM_POLI_BIAYA'];
	$konsul_dokter_spesialis_poli  += $dat_pembayaran['KONSUL_DOKTER_SPESIALIS_POLI_BIAYA'];
	$tindakan_poli += $dat_pembayaran['TINDAKAN_POLI_BIAYA'];
	$konsul_dokter_umum_bedahok += $dat_pembayaran['KONSUL_DOKTER_UMUM_BEDAH_BIAYA'];
	$konsul_dokter_spesialis_bedahok += $dat_pembayaran['KONSUL_DOKTER_SPESIALIS_BEDAH_BIAYA'];
	$operasi += $dat_pembayaran['OPERASI_BIAYA'];
	$laboratorium += $dat_pembayaran['LABORATORIUM_BIAYA'];
	$radiologi += $dat_pembayaran['RADIOLOGI_BIAYA'];
	$fisioterapi += $dat_pembayaran['FISIOTERAPI_BIAYA'];
	$okupasi_terapi += $dat_pembayaran['OKUPASI_BIAYA'];
	$protese += $dat_pembayaran['PROTHESE_BIAYA'];
	$psikologi += $dat_pembayaran['PSIKOLOGI_BIAYA'];
	$terapi_wicara += $dat_pembayaran['TERAPI_WICARA_BIAYA'];
	$perawatan_luka += $dat_pembayaran['PERAWATAN_LUKA_BIAYA'];
	$farmasi += $dat_pembayaran['FARMASI_BIAYA'];
	$pmi += $dat_pembayaran['PMI_BIAYA'];
	$skrining_gizi += $dat_pembayaran['SKRINING_GIZI_BIAYA'];
	$askep += $dat_pembayaran['ASKEP_BIAYA'];
	$sewa_lahan += $dat_pembayaran['SEWA_LAHAN_BIAYA'];
	$diklat += $dat_pembayaran['DIKLAT_BIAYA'];
	$peml_jenazah += $dat_pembayaran['PEMULASARAAN_JENAZAH_BIAYA'];
	$ambulance += $dat_pembayaran['AMBULANCE_BIAYA'];
	$londry += $dat_pembayaran['JASA_LAUNDRY_BIAYA'];
	$return_farmasi += $dat_pembayaran['RETURN_FARMASI_BIAYA'];
	
	$subtotal = $dat_pembayaran['AKOMODASI_BIAYA'] + $dat_pembayaran['VISIT_DOKTER_UMUM_BIAYA']
			+ $dat_pembayaran['VISIT_DOKTER_SPESIALIS_BIAYA'] + $dat_pembayaran['TINDAKAN_RANAP_BIAYA']
			+ $dat_pembayaran['KARCIS_IGD_BIAYA'] + $dat_pembayaran['KONSUL_DOKTER_UMUM_IGD_BIAYA']
			+ $dat_pembayaran['KONSUL_DOKTER_SPESIALIS_IGD_BIAYA'] + $dat_pembayaran['TINDAKAN_IGD_BIAYA']
			+ $dat_pembayaran['KARCIS_POLI_BIAYA'] + $dat_pembayaran['KONSUL_DOKTER_UMUM_POLI_BIAYA']
			+ $dat_pembayaran['KONSUL_DOKTER_SPESIALIS_POLI_BIAYA'] + $dat_pembayaran['TINDAKAN_POLI_BIAYA']
			+ $dat_pembayaran['KONSUL_DOKTER_UMUM_BEDAH_BIAYA']
			+ $dat_pembayaran['KONSUL_DOKTER_SPESIALIS_BEDAH_BIAYA'] + $dat_pembayaran['OPERASI_BIAYA']
			+ $dat_pembayaran['LABORATORIUM_BIAYA'] + $dat_pembayaran['RADIOLOGI_BIAYA']
			+ $dat_pembayaran['FISIOTERAPI_BIAYA'] + $dat_pembayaran['OKUPASI_BIAYA']  
			+ $dat_pembayaran['PROTHESE_BIAYA'] + $dat_pembayaran['PSIKOLOGI_BIAYA']
			+ $dat_pembayaran['TERAPI_WICARA_BIAYA'] + $dat_pembayaran['PERAWATAN_LUKA_BIAYA']
			+ $dat_pembayaran['FARMASI_BIAYA'] + $dat_pembayaran['PMI_BIAYA']
			+ $dat_pembayaran['SKRINING_GIZI_BIAYA'] + $dat_pembayaran['ASKEP_BIAYA']
			+ $dat_pembayaran['SEWA_LAHAN_BIAYA'] + $dat_pembayaran['DIKLAT_BIAYA'] 
			+ $dat_pembayaran['PEMULASARAAN_JENAZAH_BIAYA'] + $dat_pembayaran['AMBULANCE_BIAYA']
			+ $dat_pembayaran['JASA_LAUNDRY_BIAYA'] - $dat_pembayaran['RETURN_FARMASI_BIAYA'];			
	$total += $subtotal;
if($subtotal != 0){
?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
	<td><?php echo $arr_jaminan[$dat_pembayaran['JENIS_BAYAR']]; ?></td>
	<td>`<?php echo ((strlen($dat_pembayaran['NOMR']) == 6) ? formatNomr($dat_pembayaran['NOMR']) : $dat_pembayaran['NOMR']); ?></td>
	<td><?php echo $dat_pembayaran['NAMA_PASIEN']; ?></td>
	<td><?php echo $dat_pembayaran['UNIT']; ?></td>
	<td><?php echo $dat_pembayaran['TGL_MASUK']; ?></td>
	<td><?php echo $dat_pembayaran['TGL_KELUAR']; ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['AKOMODASI_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['AKOMODASI_BIAYA']); ?></td>
	<td><?php echo $dat_pembayaran['VISIT_DOKTER_UMUM_NAMA']; ?></td>
	<td><?php echo $dat_pembayaran['VISIT_DOKTER_UMUM_JML']; ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['VISIT_DOKTER_UMUM_BIAYA']); ?></td>
	<td><?php echo $dat_pembayaran['VISIT_DOKTER_SPESIALIS_NAMA']; ?></td>
	<td><?php echo $dat_pembayaran['VISIT_DOKTER_SPESIALIS_JML']; ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['VISIT_DOKTER_SPESIALIS_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['TINDAKAN_RANAP_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['TINDAKAN_RANAP_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['KARCIS_IGD_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['KARCIS_IGD_BIAYA']); ?></td>
	<td><?php echo $dat_pembayaran['KONSUL_DOKTER_UMUM_IGD_NAMA']; ?></td>
	<td><?php echo $dat_pembayaran['KONSUL_DOKTER_UMUM_IGD_JML']; ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['KONSUL_DOKTER_UMUM_IGD_BIAYA']); ?></td>
	<td><?php echo $dat_pembayaran['KONSUL_DOKTER_SPESIALIS_IGD_NAMA']; ?></td>
	<td><?php echo $dat_pembayaran['KONSUL_DOKTER_SPESIALIS_IGD_JML']; ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['KONSUL_DOKTER_SPESIALIS_IGD_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['TINDAKAN_IGD_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['TINDAKAN_IGD_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['KARCIS_POLI_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['KARCIS_POLI_BIAYA']); ?></td>
	<td><?php echo $dat_pembayaran['KONSUL_DOKTER_UMUM_POLI_NAMA']; ?></td>
	<td><?php echo $dat_pembayaran['KONSUL_DOKTER_UMUM_POLI_JML']; ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['KONSUL_DOKTER_UMUM_POLI_BIAYA']); ?></td>
	<td><?php echo $dat_pembayaran['KONSUL_DOKTER_SPESIALIS_POLI_NAMA']; ?></td>
	<td><?php echo $dat_pembayaran['KONSUL_DOKTER_SPESIALIS_POLI_JML']; ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['KONSUL_DOKTER_SPESIALIS_POLI_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['TINDAKAN_POLI_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['TINDAKAN_POLI_BIAYA']); ?></td>
	<td><?php echo $dat_pembayaran['KONSUL_DOKTER_UMUM_BEDAH_NAMA']; ?></td>
	<td><?php echo $dat_pembayaran['KONSUL_DOKTER_UMUM_BEDAH_JML']; ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['KONSUL_DOKTER_UMUM_BEDAH_BIAYA']); ?></td>
	<td><?php echo $dat_pembayaran['KONSUL_DOKTER_SPESIALIS_BEDAH_NAMA']; ?></td>
	<td><?php echo $dat_pembayaran['KONSUL_DOKTER_SPESIALIS_BEDAH_JML']; ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['KONSUL_DOKTER_SPESIALIS_BEDAH_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['OPERASI_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['OPERASI_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['LABORATORIUM_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['LABORATORIUM_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['RADIOLOGI_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['RADIOLOGI_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['FISIOTERAPI_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['FISIOTERAPI_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['OKUPASI_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['OKUPASI_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['PROTHESE_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['PROTHESE_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['PSIKOLOGI_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['PSIKOLOGI_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['TERAPI_WICARA_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['TERAPI_WICARA_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['PERAWATAN_LUKA_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['PERAWATAN_LUKA_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['FARMASI_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['FARMASI_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['PMI_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['PMI_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['SKRINING_GIZI_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['SKRINING_GIZI_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['ASKEP_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['ASKEP_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['SEWA_LAHAN_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['SEWA_LAHAN_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['DIKLAT_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['DIKLAT_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['PEMULASARAAN_JENAZAH_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['PEMULASARAAN_JENAZAH_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['AMBULANCE_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['AMBULANCE_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JASA_LAUNDRY_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JASA_LAUNDRY_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['RETURN_FARMASI_JML']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['RETURN_FARMASI_BIAYA']); ?></td>
	<td align="right"><?php echo currFormat($subtotal); ?></td>
	<td><?php echo $dat_pembayaran['METODE_BAYAR']; ?></td>
	<td><?php echo $dat_pembayaran['METODE_BAYAR_POTONGAN']; ?></td>
	<td><?php echo $dat_pembayaran['METODE_BAYAR_REKENING']; ?></td>
  </tr>
<?php
$no++; } } ?> 
 <tr>
	<td colspan="7" align="center">TOTAL</td>
    <td align="right" ><?php echo currFormat($jml_akomodasi); ?></td>
	<td align="right" ><?php echo currFormat($akomodasi); ?></td>
	<td></td>
	<td align="right" ><?php echo currFormat($jml_visit_dokter_umum); ?></td>
	<td align="right" ><?php echo currFormat($visit_dokter_umum); ?></td>
	<td></td>
	<td align="right" ><?php echo currFormat($jml_visit_dokter_spesialis); ?></td>
	<td align="right" ><?php echo currFormat($visit_dokter_spesialis); ?></td>
	<td align="right" ><?php echo currFormat($jml_tindakan_ri); ?></td>
	<td align="right" ><?php echo currFormat($tindakan_ri); ?></td>
	<td align="right" ><?php echo currFormat($jml_karcis_igd); ?></td>
	<td align="right" ><?php echo currFormat($karcis_igd); ?></td>
	<td></td>
	<td align="right" ><?php echo currFormat($jml_konsul_dokter_umum_igd); ?></td>
	<td align="right" ><?php echo currFormat($konsul_dokter_umum_igd); ?></td>
	<td></td>
	<td align="right" ><?php echo currFormat($jml_konsul_dokter_spesialis_igd); ?></td>
	<td align="right" ><?php echo currFormat($konsul_dokter_spesialis_igd); ?></td>
	<td align="right" ><?php echo currFormat($jml_tindakan_igd); ?></td>
	<td align="right" ><?php echo currFormat($tindakan_igd); ?></td>
	<td align="right" ><?php echo currFormat($jml_karcis_poli); ?></td>
	<td align="right" ><?php echo currFormat($karcis_poli); ?></td>
	<td></td>
	<td align="right" ><?php echo currFormat($jml_konsul_dokter_umum_poli); ?></td>
	<td align="right" ><?php echo currFormat($konsul_dokter_umum_poli); ?></td>
	<td></td>
	<td align="right" ><?php echo currFormat($jml_konsul_dokter_spesialis_poli); ?></td>
	<td align="right" ><?php echo currFormat($konsul_dokter_spesialis_poli ); ?></td>
	<td align="right" ><?php echo currFormat($jml_tindakan_poli); ?></td>
	<td align="right" ><?php echo currFormat($tindakan_poli); ?></td>
	<td></td>
	<td align="right" ><?php echo currFormat($jml_konsul_dokter_umum_bedahok); ?></td>
	<td align="right" ><?php echo currFormat($konsul_dokter_umum_bedahok); ?></td>
	<td></td>
	<td align="right" ><?php echo currFormat($jml_konsul_dokter_spesialis_bedahok); ?></td>
	<td align="right" ><?php echo currFormat($konsul_dokter_spesialis_bedahok); ?></td>
	<td align="right" ><?php echo currFormat($jml_operasi); ?></td>
	<td align="right" ><?php echo currFormat($operasi); ?></td>
	<td align="right" ><?php echo currFormat($jml_laboratorium); ?></td>
	<td align="right" ><?php echo currFormat($laboratorium); ?></td>
	<td align="right" ><?php echo currFormat($jml_radiologi); ?></td>
	<td align="right" ><?php echo currFormat($radiologi); ?></td>
	<td align="right" ><?php echo currFormat($jml_fisioterapi); ?></td>
	<td align="right" ><?php echo currFormat($fisioterapi); ?></td>
	<td align="right" ><?php echo currFormat($jml_okupasi_terapi); ?></td>
	<td align="right" ><?php echo currFormat($okupasi_terapi); ?></td>
	<td align="right" ><?php echo currFormat($jml_protese); ?></td>
	<td align="right" ><?php echo currFormat($protese); ?></td>
	<td align="right" ><?php echo currFormat($jml_psikologi); ?></td>
	<td align="right" ><?php echo currFormat($psikologi); ?></td>
	<td align="right" ><?php echo currFormat($jml_terapi_wicara); ?></td>
	<td align="right" ><?php echo currFormat($terapi_wicara); ?></td>
	<td align="right" ><?php echo currFormat($jml_perawatan_luka); ?></td>
	<td align="right" ><?php echo currFormat($perawatan_luka); ?></td>
	<td align="right" ><?php echo currFormat($jml_farmasi); ?></td>
	<td align="right" ><?php echo currFormat($farmasi); ?></td>
	<td align="right" ><?php echo currFormat($jml_pmi); ?></td>
	<td align="right" ><?php echo currFormat($pmi); ?></td>
	<td align="right" ><?php echo currFormat($jml_skrining_gizi); ?></td>
	<td align="right" ><?php echo currFormat($skrining_gizi); ?></td>
	<td align="right" ><?php echo currFormat($jml_askep); ?></td>
	<td align="right" ><?php echo currFormat($askep); ?></td>
	<td align="right" ><?php echo currFormat($jml_sewa_lahan); ?></td>
	<td align="right" ><?php echo currFormat($sewa_lahan); ?></td>
	<td align="right" ><?php echo currFormat($jml_diklat); ?></td>
	<td align="right" ><?php echo currFormat($diklat); ?></td>
	<td align="right" ><?php echo currFormat($jml_peml_jenazah); ?></td>
	<td align="right" ><?php echo currFormat($peml_jenazah); ?></td>
	<td align="right" ><?php echo currFormat($jml_ambulance); ?></td>
	<td align="right" ><?php echo currFormat($ambulance); ?></td>
	<td align="right" ><?php echo currFormat($jml_londry); ?></td>
	<td align="right" ><?php echo currFormat($londry); ?></td>
	<td align="right" ><?php echo currFormat($jml_return_farmasi); ?></td>
	<td align="right" ><?php echo currFormat($return_farmasi); ?></td>
	<td align="right" ><?php echo currFormat($total); ?></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
</table>
