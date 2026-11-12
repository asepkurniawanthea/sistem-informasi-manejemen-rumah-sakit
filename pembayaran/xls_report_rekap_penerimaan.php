<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');
include('./shared/enum_function.php');
 
$tgl_1 = '';
if (isset($_POST['tgl_1']))
    $tgl_1 = $_POST['tgl_1'];
$penyetor = '';
if (isset($_POST['penyetor']))
    $penyetor = $_POST['penyetor'];

$shift = '';
if (isset($_POST['shift']))
    $shift = $_POST['shift'];

$jns_bayar = '';
if (isset($_POST['jns_bayar']))
    $jns_bayar = $_POST['jns_bayar'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}

$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}

$cash = '';
if (isset($_POST['cash']))
    $cash = $_POST['cash'];

$rekening = '';
if (isset($_POST['rekening']))
    $rekening = $_POST['rekening'];	

$arr_total_cash = array();		
$arr_total_jenis = array();	



$arr_igd = '';
foreach(getArrUnitIGD() as $row){
	$arr_igd .= $row . ',';
}
$arr_igd = substr($arr_igd,0,strlen($arr_igd)-1);

$arr_nonjaminan = '';
foreach(getArrNonJaminan() as $row){
	$arr_nonjaminan .= $row . ',';
}
$arr_nonjaminan = substr($arr_nonjaminan,0,strlen($arr_nonjaminan)-1);	

$qry_kunjungan = 'SELECT RAWAT_ID,
				NOMR,
				NAMA_PASIEN,
				NAMA_UNIT,
				SUM(HARGA_KARCIS) AS HARGA_KARCIS,
				GROUP_CONCAT(DOKTER_KONSUL_IRJA,"|",CAST(JML_KONSUL_IRJA AS CHAR) SEPARATOR "||") AS DOKTER_KONSUL_IRJA,
				GROUP_CONCAT(DOKTER_KONSUL_MCU,"|",CAST(JML_KONSUL_MCU AS CHAR) SEPARATOR "||") AS DOKTER_KONSUL_MCU,
				SUM(JML_KONSUL_IRJA) AS JML_KONSUL_IRJA,
				SUM(JML_KONSUL_MCU) AS JML_KONSUL_MCU,
				SUM(HARGA_KONSUL_IRJA) AS HARGA_KONSUL_IRJA,
				SUM(HARGA_KONSUL_MCU) AS HARGA_KONSUL_MCU,
				SUM(HARGA_LAB) AS HARGA_LAB,
				SUM(HARGA_RAD) AS HARGA_RAD,
				SUM(HARGA_TINDAKAN_IRJA) AS HARGA_TINDAKAN_IRJA,
				SUM(HARGA_TINDAKAN_IRNA) AS HARGA_TINDAKAN_IRNA,
				SUM(HARGA_PENDAPATAN_LAIN) AS HARGA_PENDAPATAN_LAIN,
				SUM(HARGA_APOTIK) AS HARGA_APOTIK,
				KODE_CASH,
				PERC_POTONGAN,
				KODE_REKENING
				FROM (
				SELECT t_bayar_l1.RAWAT_ID,
				t_bayar_l1.NOMR,
				psn.NAMA_PASIEN,
				t_bayar_l1.TGL_MASUK,
				t_bayar_l1.TGL_KELUAR,
				CASE WHEN t_bayar_l1.UNIT_ID IS NOT NULL THEN unt.NAMA_UNIT	
					WHEN t_bayar_l1.RUANG_ID IS NOT NULL THEN rng.NAMA_RUANG
				ELSE "" END AS NAMA_UNIT,	
				SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN ("01","92") 
					THEN
						CASE WHEN mtrg.NON_KELAS = "1" OR t_bayar_l1.KELAS_RAWAT = ""
						THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS
						ELSE	
							CASE WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "3" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_3 
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "1" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_1
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA 2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VVIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "HCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_HCU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "NICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_NICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICCU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PERINA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PERINA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SEHAT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SAKIT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
							END
						END		
				END) AS HARGA_KARCIS,
				CASE WHEN mtrg.KODE_TARIF_GROUP IN ("02","09","93") 
					THEN mpg.NAMA_PEGAWAI END AS DOKTER_KONSUL_IRJA,
				CASE WHEN mtrg.KODE_TARIF_GROUP IN ("120") 
					THEN mpg.NAMA_PEGAWAI END AS DOKTER_KONSUL_MCU,
				SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN ("02","09","93") 
					THEN t_bayar_l1.KUANTITI END) AS JML_KONSUL_IRJA,
				SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN ("120") 
					THEN t_bayar_l1.KUANTITI END) AS JML_KONSUL_MCU,
				SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN ("02","09","93") 
					THEN
						CASE WHEN mtrg.NON_KELAS = "1" OR t_bayar_l1.KELAS_RAWAT = ""
						THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS
						ELSE	
							CASE WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "3" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_3 
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "1" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_1
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA 2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VVIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "HCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_HCU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "NICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_NICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICCU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PERINA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PERINA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SEHAT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SAKIT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
							END
						END		
				END) AS HARGA_KONSUL_IRJA,	
				SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN ("120") 
					THEN
						CASE WHEN mtrg.NON_KELAS = "1" OR t_bayar_l1.KELAS_RAWAT = ""
						THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS
						ELSE	
							CASE WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "3" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_3 
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "1" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_1
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA 2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VVIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "HCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_HCU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "NICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_NICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICCU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PERINA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PERINA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SEHAT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SAKIT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
							END
						END		
				END) AS HARGA_KONSUL_MCU,
				SUM(CASE WHEN mtrg.LABORATORIUM = "1" OR mtrg.LABORATORIUM_CITO = "1"
					THEN
						CASE WHEN mtrg.NON_KELAS = "1" OR t_bayar_l1.KELAS_RAWAT = ""
						THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS
						ELSE	
							CASE WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "3" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_3 
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "1" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_1
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA 2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VVIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "HCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_HCU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "NICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_NICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICCU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PERINA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PERINA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SEHAT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SAKIT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
							END
						END		
				END) AS HARGA_LAB,
				SUM(CASE WHEN mtrg.RADIOLOGI = "1" OR mtrg.RADIOLOGI_CITO = "1"
					THEN
						CASE WHEN mtrg.NON_KELAS = "1" OR t_bayar_l1.KELAS_RAWAT = ""
						THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS
						ELSE	
							CASE WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "3" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_3 
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "1" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_1
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA 2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VVIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "HCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_HCU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "NICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_NICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICCU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PERINA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PERINA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SEHAT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SAKIT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
							END
						END		
				END) AS HARGA_RAD,
				SUM(CASE WHEN t_bayar_l1.UNIT_ID IS NOT NULL 
					AND mtrg.KODE_TARIF_GROUP NOT IN ("01","92","02","09","93","120")
					AND (mtrg.LABORATORIUM = "" OR mtrg.LABORATORIUM IS NULL)
					AND (mtrg.LABORATORIUM_CITO = "" OR mtrg.LABORATORIUM_CITO IS NULL)
					AND (mtrg.RADIOLOGI = "" OR mtrg.RADIOLOGI IS NULL)
					AND (mtrg.RADIOLOGI_CITO = "" OR mtrg.RADIOLOGI_CITO IS NULL)
					THEN
						CASE WHEN mtrg.NON_KELAS = "1" OR t_bayar_l1.KELAS_RAWAT = ""
						THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS
						ELSE	
							CASE WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "3" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_3 
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "1" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_1
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA 2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VVIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "HCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_HCU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "NICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_NICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICCU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PERINA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PERINA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SEHAT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SAKIT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
							END
						END		
				END) AS HARGA_TINDAKAN_IRJA,
				SUM(CASE WHEN t_bayar_l1.RUANG_ID IS NOT NULL 
					AND (mtrg.LABORATORIUM = "" OR mtrg.LABORATORIUM IS NULL)
					AND (mtrg.LABORATORIUM_CITO = "" OR mtrg.LABORATORIUM_CITO IS NULL)
					AND (mtrg.RADIOLOGI = "" OR mtrg.RADIOLOGI IS NULL)
					AND (mtrg.RADIOLOGI_CITO = "" OR mtrg.RADIOLOGI_CITO IS NULL)
					THEN
						CASE WHEN mtrg.NON_KELAS = "1" OR t_bayar_l1.KELAS_RAWAT = ""
						THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS
						ELSE	
							CASE WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "3" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_3 
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "1" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_1
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "UTAMA 2" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "VVIP" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "HCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_HCU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "NICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_NICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PICU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PICU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "ICCU" THEN t_bayar_l1.KUANTITI * mtr.TARIF_ICCU
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "PERINA" THEN t_bayar_l1.KUANTITI * mtr.TARIF_PERINA
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SEHAT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
								WHEN UPPER(t_bayar_l1.KELAS_RAWAT) = "BAYI SAKIT" THEN t_bayar_l1.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
							END
						END		
				END) AS HARGA_TINDAKAN_IRNA,
				0 AS HARGA_PENDAPATAN_LAIN,
				0 AS HARGA_APOTIK,
				t_bayar_l1.KODE_CASH,
				t_bayar_l1.PERC_POTONGAN,
				t_bayar_l1.KODE_REKENING
				FROM (
							-- igd
							SELECT "TND" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(trf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							trf.SHIFT_ID AS SHIFT,
							CASE WHEN trf.PEGAWAI_ID IS NOT NULL THEN trf.PEGAWAI_ID
								ELSE igd.PEGAWAI_ID END AS PEGAWAI_ID,
							trf.KODE_CASH,
							trf.PERC_POTONGAN,
							trf.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (igd.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL 
							AND trf.ST_BAYAR = "Lunas")
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . ' 
							AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "PNJ" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT,
							NULL AS PEGAWAI_ID,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (igd.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL
							AND pnjtf.ST_BAYAR = "Lunas")
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ") 
							AND DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . ' 
							AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "AMB" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TGL_BAYAR,"%H") AS TGL_BAYAR,
							tfamb.SHIFT_ID AS SHIFT,
							NULL AS PEGAWAI_ID,
							tfamb.KODE_CASH,
							tfamb.PERC_POTONGAN,
							tfamb.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (igd.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL 
							AND tfamb.ST_BAYAR = "Lunas")
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND DATE(tfamb.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(tfamb.TGL_BAYAR) <= ' . $tgl_filter_2 . ' 
							AND tfamb.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND tfamb.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND tfamb.KODE_REKENING = "' . $rekening . '" ' : '') . '
							AND tfamb.JNS_ORDER = "IRJ"
							UNION ALL
							SELECT "HMD" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							hmdtf.SHIFT_ID AS SHIFT,
							NULL AS PEGAWAI_ID,
							hmdtf.KODE_CASH,
							hmdtf.PERC_POTONGAN,
							hmdtf.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (igd.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL
							AND hmdtf.ST_BAYAR = "Lunas")
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND DATE(hmdtf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(hmdtf.TGL_BAYAR) <= ' . $tgl_filter_2 . ' 
							AND hmdtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND hmdtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND hmdtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							AND hmd.JNS_ORDER = "IRJ"	
							UNION ALL
							SELECT "OPR" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							optf.SHIFT_ID AS SHIFT,
							NULL AS PEGAWAI_ID,
							optf.KODE_CASH,
							optf.PERC_POTONGAN,
							optf.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_operasi opr
							ON (igd.IRJA_ID = opr.RAWAT_ID
							AND opr.ST_MASUK = "1"
							AND opr.JNS_ORDER = "IRJ")
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL
							AND optf.ST_BAYAR = "Lunas")
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND DATE(optf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(optf.TGL_BAYAR) <= ' . $tgl_filter_2 . ' 
							AND optf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND optf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND optf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							-- end igd
							
							-- igd tdk klaim
							UNION ALL
							SELECT "KLM" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(trf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							trf.TDK_KLAIM_SHIFT AS SHIFT,
							CASE WHEN trf.PEGAWAI_ID IS NOT NULL THEN trf.PEGAWAI_ID
								ELSE igd.PEGAWAI_ID END AS PEGAWAI_ID,
							trf.KODE_CASH,
							trf.PERC_POTONGAN,
							trf.KODE_REKENING	
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (igd.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (trf.TARIF_ID = xtr.TARIF_ID)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND DATE(trf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . ' 
							' . (($jns_bayar == '1') ? 'AND trf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND trf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (trf.ST_BATAL = "" OR trf.ST_BATAL IS NULL)
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.TDK_KLAIM_SHIFT AS SHIFT,
							NULL AS PEGAWAI_ID,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (igd.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (pnjtf.TARIF_ID = xtr.TARIF_ID)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ") 
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . ' 
							' . (($jns_bayar == '1') ? 'AND pnjtf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND pnjtf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (pnjtf.ST_BATAL_BAYAR = "" OR pnjtf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(tfamb.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							tfamb.TDK_KLAIM_SHIFT AS SHIFT,
							NULL AS PEGAWAI_ID,
							tfamb.KODE_CASH,
							tfamb.PERC_POTONGAN,
							tfamb.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (igd.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (tfamb.TARIF_ID = xtr.TARIF_ID)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND DATE(tfamb.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(tfamb.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . ' 
							' . (($jns_bayar == '1') ? 'AND tfamb.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND tfamb.JENIS_BAYAR_ID = "xyz"') . '
							AND tfamb.JNS_ORDER = "IRJ"
							AND xtr.TDK_KLAIM = "1"
							AND (tfamb.ST_BATAL = "" OR tfamb.ST_BATAL IS NULL)
							' . (($cash != '') ? ' AND tfamb.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND tfamb.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(hmdtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							hmdtf.TDK_KLAIM_SHIFT AS SHIFT,
							NULL AS PEGAWAI_ID,
							hmdtf.KODE_CASH,
							hmdtf.PERC_POTONGAN,
							hmdtf.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (igd.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (hmdtf.TARIF_ID = xtr.TARIF_ID)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . ' 
							' . (($jns_bayar == '1') ? 'AND hmdtf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND hmdtf.JENIS_BAYAR_ID = "xyz"') . '
							AND hmd.JNS_ORDER = "IRJ"	
							AND xtr.TDK_KLAIM = "1"
							AND (hmdtf.ST_BATAL_BAYAR = "" OR hmdtf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND hmdtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND hmdtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							SUBSTRING_INDEX(optf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							optf.TDK_KLAIM_SHIFT AS SHIFT,
							NULL AS PEGAWAI_ID,
							optf.KODE_CASH,
							optf.PERC_POTONGAN,
							optf.KODE_REKENING
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_operasi opr
							ON (igd.IRJA_ID = opr.RAWAT_ID
							AND opr.ST_MASUK = "1"
							AND opr.JNS_ORDER = "IRJ")
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (optf.TARIF_ID = xtr.TARIF_ID)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND DATE(optf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(optf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . ' 
							' . (($jns_bayar == '1') ? 'AND optf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND optf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (optf.ST_BATAL_BAYAR = "" OR optf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND optf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND optf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							-- end igd tdk klaim
							
							-- rawat jalan
							UNION ALL
							SELECT "TND" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(trf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							trf.SHIFT_ID AS SHIFT,
							CASE WHEN trf.PEGAWAI_ID IS NOT NULL THEN trf.PEGAWAI_ID
								ELSE irj.PEGAWAI_ID END AS PEGAWAI_ID,
							trf.KODE_CASH,
							trf.PERC_POTONGAN,
							trf.KODE_REKENING	
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (irj.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL 
							AND trf.ST_BAYAR = "Lunas")
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . ' 
							AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "PNJ" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT,
							NULL AS PEGAWAI_ID,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irj.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL
							AND pnjtf.ST_BAYAR = "Lunas")
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ") 
							AND DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . ' 
							AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "AMB" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TGL_BAYAR,"%H") AS TGL_BAYAR,
							tfamb.SHIFT_ID AS SHIFT,
							NULL AS PEGAWAI_ID,
							tfamb.KODE_CASH,
							tfamb.PERC_POTONGAN,
							tfamb.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irj.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL 
							AND tfamb.ST_BAYAR = "Lunas")
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND DATE(tfamb.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(tfamb.TGL_BAYAR) <= ' . $tgl_filter_2 . ' 
							AND tfamb.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							AND tfamb.JNS_ORDER = "IRJ"
							' . (($cash != '') ? ' AND tfamb.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND tfamb.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "HMD" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							hmdtf.SHIFT_ID AS SHIFT,
							NULL AS PEGAWAI_ID,
							hmdtf.KODE_CASH,
							hmdtf.PERC_POTONGAN,
							hmdtf.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irj.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL
							AND hmdtf.ST_BAYAR = "Lunas")
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND hmd.JNS_ORDER = "IRJ"
							AND DATE(hmdtf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(hmdtf.TGL_BAYAR) <= ' . $tgl_filter_2 . ' 
							AND hmdtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND hmdtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND hmdtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "OPR" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							optf.SHIFT_ID AS SHIFT,
							NULL AS PEGAWAI_ID,
							optf.KODE_CASH,
							optf.PERC_POTONGAN,
							optf.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_operasi opr
							ON (irj.IRJA_ID = opr.RAWAT_ID
							AND opr.ST_MASUK = "1")
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL
							AND optf.ST_BAYAR = "Lunas")
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND DATE(optf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(optf.TGL_BAYAR) <= ' . $tgl_filter_2 . ' 
							AND optf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND optf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND optf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							-- end rawat jalan
							
							-- rawat jalan tdk klaim
							UNION ALL
							SELECT "KLM" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(trf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							trf.TDK_KLAIM_SHIFT AS SHIFT,
							CASE WHEN trf.PEGAWAI_ID IS NOT NULL THEN trf.PEGAWAI_ID
								ELSE irj.PEGAWAI_ID END AS PEGAWAI_ID,
							trf.KODE_CASH,
							trf.PERC_POTONGAN,
							trf.KODE_REKENING	
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (irj.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (trf.TARIF_ID = xtr.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND DATE(trf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . ' 
							' . (($jns_bayar == '1') ? 'AND trf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND trf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (trf.ST_BATAL = "" OR trf.ST_BATAL IS NULL)
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.TDK_KLAIM_SHIFT AS SHIFT,
							NULL AS PEGAWAI_ID,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irj.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (pnjtf.TARIF_ID = xtr.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ") 
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . ' 
							' . (($jns_bayar == '1') ? 'AND pnjtf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND pnjtf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (pnjtf.ST_BATAL_BAYAR = "" OR pnjtf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(tfamb.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							tfamb.TDK_KLAIM_SHIFT AS SHIFT,
							NULL AS PEGAWAI_ID,
							tfamb.KODE_CASH,
							tfamb.PERC_POTONGAN,
							tfamb.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irj.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (tfamb.TARIF_ID = xtr.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND DATE(tfamb.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(tfamb.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . ' 
							' . (($jns_bayar == '1') ? 'AND tfamb.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND tfamb.JENIS_BAYAR_ID = "xyz"') . '
							AND tfamb.JNS_ORDER = "IRJ"
							AND xtr.TDK_KLAIM = "1"
							AND (tfamb.ST_BATAL = "" OR tfamb.ST_BATAL IS NULL)
							' . (($cash != '') ? ' AND tfamb.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND tfamb.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(hmdtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							hmdtf.TDK_KLAIM_SHIFT AS SHIFT,
							NULL AS PEGAWAI_ID,
							hmdtf.KODE_CASH,
							hmdtf.PERC_POTONGAN,
							hmdtf.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irj.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (hmdtf.TARIF_ID = xtr.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND hmd.JNS_ORDER = "IRJ"
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . ' 
							' . (($jns_bayar == '1') ? 'AND hmdtf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND hmdtf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (hmdtf.ST_BATAL_BAYAR = "" OR hmdtf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND hmdtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND hmdtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							SUBSTRING_INDEX(optf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							optf.TDK_KLAIM_SHIFT AS SHIFT,
							NULL AS PEGAWAI_ID,
							optf.KODE_CASH,
							optf.PERC_POTONGAN,
							optf.KODE_REKENING
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_operasi opr
							ON (irj.IRJA_ID = opr.RAWAT_ID
							AND opr.ST_MASUK = "1")
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (optf.TARIF_ID = xtr.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND DATE(optf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(optf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . ' 
							' . (($jns_bayar == '1') ? 'AND optf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND optf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (optf.ST_BATAL_BAYAR = "" OR optf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND optf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND optf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							-- end rawat jalan tdk klaim
							
							-- rawat inap
							UNION ALL
							SELECT "TND" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,trf.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,trf.KELAS_RAWAT,
							SUBSTRING_INDEX(trf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							trf.SHIFT_ID AS SHIFT,
							CASE WHEN trf.PEGAWAI_ID IS NOT NULL THEN trf.PEGAWAI_ID
								ELSE irn.PEGAWAI_ID END AS PEGAWAI_ID,
							trf.KODE_CASH,
							trf.PERC_POTONGAN,
							trf.KODE_REKENING	
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irna_tarif trf
							ON (irn.IRNA_ID = trf.IRNA_ID
							AND trf.NO_TARIF IS NOT NULL 
							AND trf.ST_BAYAR = "Lunas")
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . ' 
							AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "PNJ" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,pnj.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT,
							NULL AS PEGAWAI_ID,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING	
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irn.IRNA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL
							AND pnjtf.ST_BAYAR = "Lunas")
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . ' 
							AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							AND (pnj.JNS_ORDER = "IRN" OR pnj.JNS_ORDER = "HRI" OR pnj.JNS_ORDER = "ORI")
							UNION ALL
							SELECT "AMB" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,tfamb.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TGL_BAYAR,"%H") AS TGL_BAYAR,
							tfamb.SHIFT_ID AS SHIFT,
							NULL AS PEGAWAI_ID,
							tfamb.KODE_CASH,
							tfamb.PERC_POTONGAN,
							tfamb.KODE_REKENING	
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irn.IRNA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL 
							AND tfamb.ST_BAYAR = "Lunas")
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(tfamb.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(tfamb.TGL_BAYAR) <= ' . $tgl_filter_2 . ' 
							AND tfamb.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND tfamb.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND tfamb.KODE_REKENING = "' . $rekening . '" ' : '') . '
							AND tfamb.JNS_ORDER = "IRN"
							UNION ALL
							SELECT "HMD" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,hmd.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							hmdtf.SHIFT_ID AS SHIFT,
							NULL AS PEGAWAI_ID,
							hmdtf.KODE_CASH,
							hmdtf.PERC_POTONGAN,
							hmdtf.KODE_REKENING	
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irn.IRNA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL
							AND hmdtf.ST_BAYAR = "Lunas")
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(hmdtf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(hmdtf.TGL_BAYAR) <= ' . $tgl_filter_2 . ' 
							AND hmdtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND hmdtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND hmdtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							AND hmd.JNS_ORDER = "IRN"
							UNION ALL
							SELECT "OPR" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,opr.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,optf.KELAS_RAWAT,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TGL_BAYAR,"%H") AS TGL_BAYAR,
							optf.SHIFT_ID AS SHIFT,
							NULL AS PEGAWAI_ID,
							optf.KODE_CASH,
							optf.PERC_POTONGAN,
							optf.KODE_REKENING	
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_operasi opr
							ON (irn.IRNA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL
							AND optf.ST_BAYAR = "Lunas"
							AND (opr.ST_MASUK = "2" OR opr.JNS_ORDER = "IRN"))
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(optf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(optf.TGL_BAYAR) <= ' . $tgl_filter_2 . ' 
							AND optf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							' . (($cash != '') ? ' AND optf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND optf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							-- end rawat inap
							
							-- rawat inap tdk diklaim
							UNION ALL
							SELECT "KLM" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,trf.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,trf.KELAS_RAWAT,
							SUBSTRING_INDEX(trf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							trf.TDK_KLAIM_SHIFT AS SHIFT,
							CASE WHEN trf.PEGAWAI_ID IS NOT NULL THEN trf.PEGAWAI_ID
								ELSE irn.PEGAWAI_ID END AS PEGAWAI_ID,
							trf.KODE_CASH,
							trf.PERC_POTONGAN,
							trf.KODE_REKENING	
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irna_tarif trf
							ON (irn.IRNA_ID = trf.IRNA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (trf.TARIF_ID = xtr.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(trf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . ' 
							' . (($jns_bayar == '1') ? 'AND trf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND trf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (trf.ST_BATAL = "" OR trf.ST_BATAL IS NULL)
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,pnj.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(pnjtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							pnjtf.TDK_KLAIM_SHIFT AS SHIFT,
							NULL AS PEGAWAI_ID,
							pnjtf.KODE_CASH,
							pnjtf.PERC_POTONGAN,
							pnjtf.KODE_REKENING
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irn.IRNA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (pnjtf.TARIF_ID = xtr.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . ' 
							' . (($jns_bayar == '1') ? 'AND pnjtf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND pnjtf.JENIS_BAYAR_ID = "xyz"') . '
							AND (pnj.JNS_ORDER = "IRN" OR pnj.JNS_ORDER = "HRI" OR pnj.JNS_ORDER = "ORI")
							AND xtr.TDK_KLAIM = "1"
							AND (pnjtf.ST_BATAL_BAYAR = "" OR pnjtf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,tfamb.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(tfamb.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							tfamb.TDK_KLAIM_SHIFT AS SHIFT,
							NULL AS PEGAWAI_ID,
							tfamb.KODE_CASH,
							tfamb.PERC_POTONGAN,
							tfamb.KODE_REKENING
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irn.IRNA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (tfamb.TARIF_ID = xtr.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(tfamb.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(tfamb.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . ' 
							' . (($jns_bayar == '1') ? 'AND tfamb.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND tfamb.JENIS_BAYAR_ID = "xyz"') . '
							AND tfamb.JNS_ORDER = "IRN"
							AND xtr.TDK_KLAIM = "1"
							AND (tfamb.ST_BATAL = "" OR tfamb.ST_BATAL IS NULL)
							' . (($cash != '') ? ' AND tfamb.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND tfamb.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,hmd.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							SUBSTRING_INDEX(hmdtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							hmdtf.TDK_KLAIM_SHIFT AS SHIFT,
							NULL AS PEGAWAI_ID,
							hmdtf.KODE_CASH,
							hmdtf.PERC_POTONGAN,
							hmdtf.KODE_REKENING
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irn.IRNA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif xtr 
							ON (hmdtf.TARIF_ID = xtr.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . ' 
							' . (($jns_bayar == '1') ? 'AND hmdtf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND hmdtf.JENIS_BAYAR_ID = "xyz"') . '
							AND hmd.JNS_ORDER = "IRN"
							AND xtr.TDK_KLAIM = "1"
							AND (hmdtf.ST_BATAL_BAYAR = "" OR hmdtf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND hmdtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND hmdtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "KLM" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							irn.JENIS_BAYAR_ID,NULL AS UNIT_ID,opr.RUANG_ID,
							DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,optf.KELAS_RAWAT,
							SUBSTRING_INDEX(optf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%H") AS TGL_BAYAR,
							optf.TDK_KLAIM_SHIFT AS SHIFT,
							NULL AS PEGAWAI_ID,
							optf.KODE_CASH,
							optf.PERC_POTONGAN,
							optf.KODE_REKENING
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_operasi opr
							ON (irn.IRNA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL
							AND (opr.ST_MASUK = "2" OR opr.JNS_ORDER = "IRN"))
							INNER JOIN db_simrs.m_tarif xtr 
							ON (optf.TARIF_ID = xtr.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(optf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(optf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . ' 
							' . (($jns_bayar == '1') ? 'AND optf.JENIS_BAYAR_ID NOT IN (' . $arr_nonjaminan . ')' :  
							'AND optf.JENIS_BAYAR_ID = "xyz"') . '
							AND xtr.TDK_KLAIM = "1"
							AND (optf.ST_BATAL_BAYAR = "" OR optf.ST_BATAL_BAYAR IS NULL)
							' . (($cash != '') ? ' AND optf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND optf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							-- end rawat inap tdk klaim
					) t_bayar_l1
					INNER JOIN db_simrs.m_tarif mtr
					ON (t_bayar_l1.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg
					ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					INNER JOIN db_simrs.m_pasien psn
					ON (t_bayar_l1.NOMR = psn.NOMR)
					LEFT JOIN db_simrs.m_unit unt
					ON (t_bayar_l1.UNIT_ID = unt.UNIT_ID)
					LEFT JOIN db_simrs.m_ruang rng
					ON (t_bayar_l1.RUANG_ID = rng.RUANG_ID)
					LEFT JOIN m_pegawai mpg
					ON (t_bayar_l1.PEGAWAI_ID = mpg.PEGAWAI_ID)
					' . (($penyetor == '') ? ' WHERE 1 ' : ' WHERE UPPER(t_bayar_l1.KASIR) = "' . strtoupper($penyetor) . '"') . '
					' . (($shift == '') ? ' ' : ' AND t_bayar_l1.SHIFT = "' . $shift . '"') . '
					AND (mtr.MCU IS NULL OR mtr.MCU = "")
					GROUP BY t_bayar_l1.RAWAT_ID,
					t_bayar_l1.UNIT_ID,
					t_bayar_l1.RUANG_ID,
					t_bayar_l1.TARIF_ID,
					t_bayar_l1.PEGAWAI_ID,
					t_bayar_l1.KODE_CASH,
					t_bayar_l1.PERC_POTONGAN,
					t_bayar_l1.KODE_REKENING
					
					-- farmasi
					UNION ALL
					SELECT t_bayar_l0.RAWAT_ID,
					t_bayar_l0.NOMR,
					t_bayar_l0.NAMA_PASIEN,
					t_bayar_l0.TGL_MASUK,
					t_bayar_l0.TGL_KELUAR,
					t_bayar_l0.NAMA_UNIT,	
					0 AS HARGA_KARCIS,
					NULL AS DOKTER_KONSUL_IRJA,
					NULL AS DOKTER_KONSUL_MCU,
					0 AS JML_KONSUL_IRJA,
					0 AS JML_KONSUL_MCU,
					0 AS HARGA_KONSUL_IRJA,	
					0 AS HARGA_KONSUL_MCU,
					0 AS HARGA_LAB,
					0 AS HARGA_RAD,
					0 AS HARGA_TINDAKAN_IRJA,
					0 AS HARGA_TINDAKAN_IRNA,
					0 AS HARGA_PENDAPATAN_LAIN,
					SUM(t_bayar_l0.HARGA) AS HARGA_APOTIK,
					t_bayar_l0.KODE_CASH,
					t_bayar_l0.PERC_POTONGAN,
					t_bayar_l0.KODE_REKENING
					FROM (
						SELECT igd.IRJA_ID AS RAWAT_ID,
						igd.NOMR,
						psn2.NAMA_PASIEN,
						DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						unt2.NAMA_UNIT,
						"FMS" AS PASIEN,
						CAST(DATE_FORMAT(fms.TANGGAL_BAYAR,"%H") AS UNSIGNED) AS TGL_BAYAR,
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) AS USER_KASIR,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS KUANTITI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING
						FROM db_simrs.t_irja igd
						INNER JOIN m_pasien psn2
						ON (igd.NOMR = psn2.NOMR)
						INNER JOIN m_unit unt2
						ON (igd.UNIT_ID = unt2.UNIT_ID)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
						ON (igd.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGELUARAN IS NOT NULL
						AND fms.JENIS_PENGELUARAN = "1"
						AND fms.ST_BATAL IS NULL)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						WHERE igd.NO_PENDAFTARAN IS NOT NULL 
						AND igd.ST_BATAL IS NULL
						AND igd.UNIT_ID IN (' . $arr_igd . ')
						AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . ' 
						AND fms.JAMINAN_ID = "' . $jns_bayar . '"
						' . (($cash != '') ? ' AND fms.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND fms.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY igd.IRJA_ID,
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%H"),
						fms.SHIFT_PEMBAYARAN,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING
						-- end farmasi igd
							
						-- farmasi rawat jalan
						UNION ALL
						SELECT igd.IRJA_ID AS RAWAT_ID,
						igd.NOMR,
						psn2.NAMA_PASIEN,
						DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
						unt2.NAMA_UNIT,
						"FMS" AS PASIEN,
						CAST(DATE_FORMAT(fms.TANGGAL_BAYAR,"%H") AS UNSIGNED) AS TGL_BAYAR,
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) AS USER_KASIR,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS KUANTITI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING
						FROM db_simrs.t_irja igd
						INNER JOIN m_pasien psn2
						ON (igd.NOMR = psn2.NOMR)
						INNER JOIN m_unit unt2
						ON (igd.UNIT_ID = unt2.UNIT_ID)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
						ON (igd.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGELUARAN IS NOT NULL
						AND fms.JENIS_PENGELUARAN = "1"
						AND fms.ST_BATAL IS NULL)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						WHERE igd.NO_PENDAFTARAN IS NOT NULL 
						AND igd.ST_BATAL IS NULL
						AND igd.UNIT_ID NOT IN (' . $arr_igd . ')
						AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . ' 
						AND fms.JAMINAN_ID = "' . $jns_bayar . '"
						' . (($cash != '') ? ' AND fms.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND fms.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY igd.IRJA_ID,
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%H"),
						fms.SHIFT_PEMBAYARAN,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING
						-- end farmasi rawat jalan
						
						-- farmasi rawat inap
						UNION ALL
						SELECT irn.IRNA_ID AS RAWAT_ID,
						irn.NOMR,
						psn2.NAMA_PASIEN,
						DATE_FORMAT(irn.PASIEN_MASUK,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						rng2.NAMA_RUANG AS NAMA_UNIT,
						"FMS" AS PASIEN,
						CAST(DATE_FORMAT(fms.TANGGAL_BAYAR,"%H") AS UNSIGNED) AS TGL_BAYAR,
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) AS USER_KASIR,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS KUANTITI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING
						FROM db_simrs.t_irna irn
						INNER JOIN m_pasien psn2
						ON (irn.NOMR = psn2.NOMR)
						INNER JOIN m_ruang rng2
						ON (irn.RUANG_ID = rng2.RUANG_ID)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
						ON (irn.IRNA_ID = fms.RANAP_ID AND fms.NO_PENGELUARAN IS NOT NULL
						AND fms.JENIS_PENGELUARAN = "2"
						AND fms.ST_BATAL IS NULL)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						WHERE irn.NO_PENDAFTARAN IS NOT NULL 
						AND irn.ST_BATAL IS NULL
						AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . ' 
						AND fms.JAMINAN_ID = "' . $jns_bayar . '"
						' . (($cash != '') ? ' AND fms.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND fms.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY irn.IRNA_ID,
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%H"),
						fms.SHIFT_PEMBAYARAN,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING
						-- end farmasi rawat inap
						
						-- farmasi aps
						UNION ALL
						SELECT CONCAT("y",fms.FARMASI_PENGELUARAN_APOTIK_ID) AS RAWAT_ID,
						"-" AS NOMR,
						fms.NAMA_PELANGGAN AS NAMA_PASIEN,
						DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						"APS" AS NAMA_UNIT,
						"APS" AS PASIEN,
						CAST(DATE_FORMAT(fms.TANGGAL_BAYAR,"%H") AS UNSIGNED) AS TGL_BAYAR,
						fms.SHIFT_PEMBAYARAN AS SHIFT,
						UPPER(SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1)) AS USER_KASIR,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS KUANTITI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING
						FROM db_inventorirs.t_farmasi_apotik_pengeluaran fms
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						WHERE fms.NO_PENGELUARAN IS NOT NULL
						' . (($jns_bayar == '1') ? 'AND fms.JENIS_PENGELUARAN = "3"' : 'AND fms.JENIS_PENGELUARAN = "123"') . '
						AND fms.ST_BATAL IS NULL
						AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . ' 
						' . (($cash != '') ? ' AND fms.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND fms.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY fms.FARMASI_PENGELUARAN_APOTIK_ID,
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%H"),
						fms.SHIFT_PEMBAYARAN,
						fms.KODE_CASH,
						fms.PERC_POTONGAN,
						fms.KODE_REKENING
						-- end farmasi aps
						) t_bayar_l0
						' . (($penyetor == '') ? ' WHERE 1 ' : ' WHERE UPPER(t_bayar_l0.USER_KASIR) = "' . strtoupper($penyetor) . '"') . '
						' . (($shift == '') ? ' ' : ' AND t_bayar_l0.SHIFT = "' . $shift . '"') . '
						GROUP BY RAWAT_ID,NAMA_UNIT,
						t_bayar_l0.KODE_CASH,
						t_bayar_l0.PERC_POTONGAN,
						t_bayar_l0.KODE_REKENING
						
						UNION ALL
						SELECT CONCAT("x",pnj.PENUNJANG_ID) AS RAWAT_ID,
						pnj.NO_PASIEN_PENUNJANG AS NOMR,
						pnj.NAMA_PASIEN,
						NULL AS TGL_MASUK,
						NULL AS TGL_KELUAR,
						"APS" AS NAMA_UNIT,
						SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN ("01","92") 
								THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS
								ELSE 0
							END) AS HARGA_KARCIS,
						"" AS DOKTER_KONSUL_IRJA,
						"" AS DOKTER_KONSUL_MCU,
						0 AS JML_KONSUL_IRJA,
						0 AS JML_KONSUL_MCU,
						0 AS HARGA_KONSUL_IRJA,
						0 AS HARGA_KONSUL_MCU,
						SUM(CASE WHEN mtrg.LABORATORIUM = "1" OR mtrg.LABORATORIUM_CITO = "1" 
							THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS
							ELSE 0	
						END) AS HARGA_LAB,
						SUM(CASE WHEN mtrg.RADIOLOGI = "1" OR mtrg.RADIOLOGI_CITO = "1" 
								THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS
							ELSE 0	
						END) AS HARGA_RAD,
						SUM(CASE WHEN (mtrg.RADIOLOGI = "" OR mtrg.RADIOLOGI IS NULL)
							AND (mtrg.RADIOLOGI_CITO = "" OR mtrg.RADIOLOGI_CITO IS NULL)
							AND (mtrg.LABORATORIUM = "" OR mtrg.LABORATORIUM IS NULL) 
							AND (mtrg.LABORATORIUM_CITO = "" OR mtrg.LABORATORIUM_CITO IS NULL)
							AND mtrg.KODE_TARIF_GROUP NOT IN ("01","92")	
							THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS
							ELSE 0		
						END) AS HARGA_TINDAKAN_IRJA,
						0 AS HARGA_TINDAKAN_IRNA,
						0 AS HARGA_PENDAPATAN_LAIN,
						0 AS HARGA_APOTIK,
						pnjtf.KODE_CASH,
						pnjtf.PERC_POTONGAN,
						pnjtf.KODE_REKENING
						FROM db_simrs.t_ipenunjang pnj
						INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
						ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
						AND pnjtf.NO_TARIF IS NOT NULL
						AND pnjtf.ST_BATAL IS NULL
						AND pnjtf.ST_BAYAR = "Lunas")
						INNER JOIN m_tarif mtr ON (pnjtf.TARIF_ID = mtr.TARIF_ID)
						INNER JOIN m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
						WHERE DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . ' 
						AND pnj.JNS_ORDER = "APS"
						AND pnj.JENIS_BAYAR_ID = "' . $jns_bayar . '"
						' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
						' . (($penyetor == '') ? ' ' : ' AND UPPER(SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1)) = "' . strtoupper($penyetor) . '"') . '
						' . (($shift == '') ? ' ' : ' AND pnjtf.SHIFT_KASIR = "' . $shift . '"') . '
						GROUP BY pnj.PENUNJANG_ID,
						pnjtf.KODE_CASH,
						pnjtf.PERC_POTONGAN,
						pnjtf.KODE_REKENING
						
						UNION ALL
						SELECT CONCAT("z",pnm.PENERIMAAN_LAINLAIN_ID) AS RAWAT_ID,
						pnm.NAMA_INSTANSI AS NOMR,
						pnm.PIC AS NAMA_PASIEN,
						NULL AS TGL_MASUK,
						NULL AS TGL_KELUAR,
						pnm.JENIS_INSTANSI AS NAMA_UNIT,
						0 AS HARGA_KARCIS,
						"" AS DOKTER_KONSUL_IRJA,
						"" AS DOKTER_KONSUL_MCU,
						0 AS JML_KONSUL_IRJA,
						0 AS JML_KONSUL_MCU,
						0 AS HARGA_KONSUL_IRJA,
						0 AS HARGA_KONSUL_MCU,
						0 AS HARGA_LAB,
						0 AS HARGA_RAD,
						0 AS HARGA_TINDAKAN_IRJA,
						0 AS HARGA_TINDAKAN_IRNA,
						SUM(pnmtf.KUANTITI * mtr.TARIF_NON_KELAS) AS HARGA_PENDAPATAN_LAIN,
						0 AS HARGA_APOTIK,
						pnm.KODE_CASH,
						pnm.PERC_POTONGAN,
						pnm.KODE_REKENING
						FROM db_simkeu.r_penerimaan_lainlain pnm
						INNER JOIN db_simkeu.r_penerimaan_lainlain_tarif pnmtf
						ON (pnm.PENERIMAAN_LAINLAIN_ID = pnmtf.PENERIMAAN_LAINLAIN_ID)
						INNER JOIN m_tarif mtr ON (pnmtf.TARIF_ID = mtr.TARIF_ID)
						INNER JOIN m_tarif_group mtrg ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
						WHERE DATE(pnm.TANGGAL) >= ' . $tgl_filter_1 . ' 
						AND DATE(pnm.TANGGAL) <= ' . $tgl_filter_2 . ' 
						' . (($cash != '') ? ' AND pnm.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND pnm.KODE_REKENING = "' . $rekening . '" ' : '') . '
						' . (($jns_bayar == '1') ? 'AND pnm.NO_TARIF IS NOT NULL' : 'AND pnm.NO_TARIF = "xyz"') . '
						' . (($penyetor == '') ? ' ' : ' AND UPPER(SUBSTRING_INDEX(pnm.REGISTER,"|",-1)) = "' . strtoupper($penyetor) . '"') . '
						AND pnm.NO_PEMBAYARAN IS NOT NULL
						GROUP BY pnm.PENERIMAAN_LAINLAIN_ID,
						pnm.KODE_CASH,
						pnm.PERC_POTONGAN,
						pnm.KODE_REKENING
					) t_bayar_l2
					GROUP BY RAWAT_ID,NAMA_UNIT,
					KODE_CASH,PERC_POTONGAN,KODE_REKENING
					ORDER BY NAMA_PASIEN,NAMA_UNIT';
?>
<table border="1" >
	<tr>
		<th colspan="22">Laporan rekap Penerimaan Tanggal <?php echo $tgl_1; ?></th>
	</tr>
	<tr>
		<th align="center" colspan="22">Penyetor : <?php echo $penyetor; ?></th>
	</tr>
   <tr>
     <th rowspan="2">No</th>
     <th rowspan="2">NOMR</th>
     <th rowspan="2">Nama Pasien </th>
     <th rowspan="2">Unit/ Ruang</th>
     <th rowspan="2">Karcis</th>
     <th colspan="3">Konsultasi Dokter</th>
	 <th colspan="3">Tindakan Medik</th>
     <th colspan="3">MCU</th>
     <th rowspan="2">Pendapatan<br/>Lain-lain</th>
	 <th rowspan="2">Rawat Inap</th>
	 <th rowspan="2">Apotik</th>
	 <th rowspan="2">Total</th>
	 <th colspan="4">Pembayaran Umum</th>
   </tr>
  <tr>
    <th>Nama Dokter</th>
    <th>Jml</th>
    <th>Jml Rp</th>
	<th>Laboratorium</th>
	<th>Radiologi</th>
    <th>Tindakan</th>
    <th>Nama Dokter</th>
    <th>Jml</th>
    <th>Jml Rp</th>
	<th>Jenis</th>
	<th>Potongan %</th>
	<th>Potongan Rp</th>
	<th>Rekening</th>
  </tr>
    <?
   $no = 1; 
   $total = 0;
$total_karcis = 0;
$total_jml_konsul_irja = 0;
$total_hrg_konsul_irja = 0;
$total_lab = 0;
$total_rad = 0;
$total_tindakan_irja = 0;
$total_jml_konsul_mcu = 0;
$total_hrg_konsul_mcu = 0;
$total_pendapatan_lain = 0;
$total_tindakan_irna = 0;
$total_apotik = 0;
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
		$str_konsul_dokter_irja = '|';
	$jml_konsul_dokter_irja = '|';
	if($data['DOKTER_KONSUL_IRJA'] != ''){
		$str_konsul_dokter_irja = '';
		$jml_konsul_dokter_irja = '';
		$arr_str_konsul_dokter_irja = explode('||',$data['DOKTER_KONSUL_IRJA']);
		foreach($arr_str_konsul_dokter_irja as $row){
			$arr_row = explode('|',$row);
			$str_konsul_dokter_irja .= $arr_row[0] . '|';
			$jml_konsul_dokter_irja .= $arr_row[1] . '|';
		}
	}
	
	$str_konsul_dokter_mcu = '|';
	$jml_konsul_dokter_mcu = '|';
	if($data['DOKTER_KONSUL_MCU'] != ''){
		$str_konsul_dokter_mcu = '';
		$jml_konsul_dokter_mcu = '';
		$arr_str_konsul_dokter_mcu = explode('||',$data['DOKTER_KONSUL_MCU']);
		foreach($arr_str_konsul_dokter_mcu as $row){
			$arr_row = explode('|',$row);
			$str_konsul_dokter_mcu .= $arr_row[0] . '|';
			$jml_konsul_dokter_mcu .= $arr_row[1] . '|';
		}
	}
	?>
	<tr>
	 <td scope="row" align="center"><?php echo $no; ?></td>
	<td><?php echo ((strlen($data['NOMR']) == 6) ? formatNomr($data['NOMR']) : $data['NOMR']); ?></td>
    <td><?php echo $data['NAMA_PASIEN']; ?></td>
	<td><?php echo $data['NAMA_UNIT']; ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_KARCIS']); ?></td>
	<td><?php echo substr($str_konsul_dokter_irja,0,strlen($str_konsul_dokter_irja)-1); ?></td>
	<td align="right"><?php echo substr($jml_konsul_dokter_irja,0,strlen($jml_konsul_dokter_irja)-1); ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_KONSUL_IRJA']); ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_LAB']); ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_RAD']); ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_TINDAKAN_IRJA']); ?></td>
	<td><?php echo substr($str_konsul_dokter_mcu,0,strlen($str_konsul_dokter_mcu)-1); ?></td>
	<td align="right"><?php echo substr($jml_konsul_dokter_mcu,0,strlen($jml_konsul_dokter_mcu)-1); ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_KONSUL_MCU']); ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_PENDAPATAN_LAIN']); ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_TINDAKAN_IRNA']); ?></td>
	<td align="right"><?php echo currFormat($data['HARGA_APOTIK']); ?></td>
		<td align="right"><?php $subtotal = $data['HARGA_KARCIS'] + $data['HARGA_KONSUL_IRJA'] + $data['HARGA_LAB'] + $data['HARGA_RAD'] + $data['HARGA_TINDAKAN_IRJA'] + $data['HARGA_KONSUL_MCU'] + $data['HARGA_PENDAPATAN_LAIN'] + $data['HARGA_TINDAKAN_IRNA'] + $data['HARGA_APOTIK']; 
	$total += $subtotal;
	$total_karcis += $data['HARGA_KARCIS'];
	$total_jml_konsul_irja += $data['JML_KONSUL_IRJA'];
	$total_hrg_konsul_irja += $data['HARGA_KONSUL_IRJA'];
	$total_lab += $data['HARGA_LAB'];
	$total_rad += $data['HARGA_RAD'];
	$total_tindakan_irja += $data['HARGA_TINDAKAN_IRJA'];
	$total_jml_konsul_mcu += $data['JML_KONSUL_MCU'];
	$total_hrg_konsul_mcu += $data['HARGA_KONSUL_MCU'];
	$total_pendapatan_lain += $data['HARGA_PENDAPATAN_LAIN'];
	$total_tindakan_irna += $data['HARGA_TINDAKAN_IRNA'];
	$total_apotik += $data['HARGA_APOTIK'];
	echo currFormat($subtotal); ?></td>
	<td><?php echo $data['KODE_CASH']; ?></td>
	<td align="right"><?php echo $data['PERC_POTONGAN']; ?></td>
	<td align="right"><?php $potongan = ($data['PERC_POTONGAN'] / 100) * $subtotal;
		echo currFormat($potongan); ?></td>
	<td><?php echo $data['KODE_REKENING']; ?></td>
  </tr> 
	<?php 
		$arr_total_cash[$data['KODE_CASH']] = 0;
		$arr_total_jenis[$data['NAMA_UNIT'] . ' - ' . $data['KODE_CASH']] = 0;
	} ?> 
<tr>
		<td colspan = "4" align="center">Total</td>
		<td align="right"><?php echo currFormat($total_karcis); ?></td>
		<td colspan="2" align="right"><?php echo currFormat($total_jml_konsul_irja); ?></td>
		<td align="right"><?php echo currFormat($total_hrg_konsul_irja); ?></td>
		<td align="right"><?php echo currFormat($total_lab); ?></td>
		<td align="right"><?php echo currFormat($total_rad); ?></td>
		<td align="right"><?php echo currFormat($total_tindakan_irja); ?></td>
		<td colspan="2" align="right"><?php echo currFormat($total_jml_konsul_mcu); ?></td>
		<td align="right"><?php echo currFormat($total_hrg_konsul_mcu); ?></td>
		<td align="right"><?php echo currFormat($total_pendapatan_lain); ?></td>
		<td align="right"><?php echo currFormat($total_tindakan_irna); ?></td>
		<td align="right"><?php echo currFormat($total_apotik); ?></td>
		<td align="right"><?php echo currFormat($total); ?></td>
	</tr>
<tr>
			<td colspan="15">&nbsp;</td>
			<td colspan="3">&nbsp;</td>
			<td align="right" colspan="4">&nbsp;</td>
	</tr>
<?php
	mysql_data_seek($rs,0);
	while($data = mysql_fetch_array($rs)){
		$subtotal_per_jenis = $data['HARGA_KARCIS'] + $data['HARGA_KONSUL_IRJA'] + $data['HARGA_LAB'] + $data['HARGA_RAD'] + $data['HARGA_TINDAKAN_IRJA'] + $data['HARGA_KONSUL_MCU'] + $data['HARGA_PENDAPATAN_LAIN'] + $data['HARGA_TINDAKAN_IRNA'] + $data['HARGA_APOTIK'];
		$arr_total_jenis[$data['NAMA_UNIT'] . ' - ' . $data['KODE_CASH']] += $subtotal_per_jenis;
	}
	
	foreach($arr_total_jenis as $key => $value){ ?>
		<tr>
			<td colspan="15">&nbsp;</td>
			<td colspan="3"><?php echo $key; ?></td>
			<td align="right" colspan="4"><?php echo currFormat($value); ?></td>
		</tr>		
<?php } ?>
	
	<tr>
			<td colspan="15">&nbsp;</td>
			<td colspan="3">&nbsp;</td>
			<td align="right" colspan="4">&nbsp;</td>
	</tr>	
	
<?php 
	mysql_data_seek($rs,0);
	while($data = mysql_fetch_array($rs)){
		$subtotal_per_cash = $data['HARGA_KARCIS'] + $data['HARGA_KONSUL_IRJA'] + $data['HARGA_LAB'] + $data['HARGA_RAD'] + $data['HARGA_TINDAKAN_IRJA'] + $data['HARGA_KONSUL_MCU'] + $data['HARGA_PENDAPATAN_LAIN'] + $data['HARGA_TINDAKAN_IRNA'] + $data['HARGA_APOTIK'];
		$arr_total_cash[$data['KODE_CASH']] += $subtotal_per_cash;
	}
	
	foreach($arr_total_cash as $key => $value){ ?>
		<tr>
			<td colspan="15">&nbsp;</td>
			<td colspan="3"><?php echo $key; ?></td>
			<td align="right" colspan="4"><?php echo currFormat($value); ?></td>
		</tr>		
<?php } ?>
</table>
