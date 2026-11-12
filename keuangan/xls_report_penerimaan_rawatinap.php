<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = $_POST['tgl_1'];
$tgl_2 = $_POST['tgl_2'];
$jns_bayar = $_POST['jns_bayar'];		

$arr_akomodasi = str_replace('`','"',$_POST['arr_akomodasi']);
$arr_visit_dokter_umum = str_replace('`','"',$_POST['arr_visit_dokter_umum']);
$arr_visit_dokter_spesialis = str_replace('`','"',$_POST['arr_visit_dokter_spesialis']);
$arr_operasi = str_replace('`','"',$_POST['arr_operasi']);
$arr_pmi = str_replace('`','"',$_POST['arr_pmi']);
$arr_skrining_gizi = str_replace('`','"',$_POST['arr_skrining_gizi']);
$arr_askep = str_replace('`','"',$_POST['arr_askep']);
$arr_tindakan_ri = str_replace('`','"',$_POST['arr_tindakan_ri']);

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
?>
<table border="1">
	<tr>
        <th colspan="28">Report Penerimaan Rawat Inap Jenis Pembayaran <?php 
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
	<th rowspan="2">NOMR</th>
    <th rowspan="2">Nama Pasien</th>
	<th rowspan="2">Nama Unit/ Ruang </th>
    <th rowspan="2">Tgl Masuk </th>
    <th rowspan="2">Tgl Keluar</th>
	<th colspan="2">Akomodasi</th>
	<th colspan="3">Visit<br />Dokter Umum</th>
	<th colspan="3">Dokter<br />Spesialis</th>
	<th colspan="2">Tindakan<br />Rawat Inap</th>
	<th colspan="2">Operasi</th>
	<th colspan="2">PMI</th>
	<th colspan="2">Skrining<br />Gizi</th>
	<th colspan="2">Askep</th>
	<th rowspan="2">Jumlah</th>
	<th rowspan="2">Cost Sharing</th>
	<th rowspan="2">Jam Kerja</th>
  </tr>
   <tr>
     <th>Jumlah</th>
     <th>Biaya</th>
     <th>Nama </th>
     <th>Jumlah</th>
     <th>Biaya</th>
     <th>Nama</th>
     <th>Jumlah</th>
     <th>Biaya</th>
     <th>Jumlah</th>
     <th>Biaya</th>
     <th>Jumlah</th>
     <th>Biaya</th>
	 <th>Jumlah</th>
     <th>Biaya</th>
	 <th>Jumlah</th>
     <th>Biaya</th>
	 <th>Jumlah</th>
     <th>Biaya</th>
   </tr>
<?php $no = 1; 
$qry_pembayaran = 'SELECT t_bayar_main.RAWAT_ID,t_bayar_main.NAMA_JAMINAN,
				t_bayar_main.NOMR,t_bayar_main.NAMA_PASIEN,t_bayar_main.NAMA_UNIT,
				t_bayar_main.NAMA_RUANG,t_bayar_main.TGL_MASUK,t_bayar_main.TGL_KELUAR,
				SUM(t_bayar_main.JML_AKOMODASI) AS JML_AKOMODASI,
				SUM(t_bayar_main.HARGA_AKOMODASI) AS HARGA_AKOMODASI,
				GROUP_CONCAT(t_bayar_main.VISIT_DOKTER_UMUM,"|",CAST(t_bayar_main.JML_VISIT_DOKTER_UMUM AS CHAR) SEPARATOR "||") AS VISIT_DOKTER_UMUM,
				SUM(t_bayar_main.JML_VISIT_DOKTER_UMUM) AS JML_VISIT_DOKTER_UMUM,
				SUM(t_bayar_main.HARGA_VISIT_DOKTER_UMUM) AS HARGA_VISIT_DOKTER_UMUM,
				GROUP_CONCAT(t_bayar_main.VISIT_DOKTER_SPESIALIS,"|",CAST(t_bayar_main.JML_VISIT_DOKTER_SPESIALIS AS CHAR) SEPARATOR "||") AS VISIT_DOKTER_SPESIALIS, 
				SUM(t_bayar_main.JML_VISIT_DOKTER_SPESIALIS) AS JML_VISIT_DOKTER_SPESIALIS,
				SUM(t_bayar_main.HARGA_VISIT_DOKTER_SPESIALIS) AS HARGA_VISIT_DOKTER_SPESIALIS,
				SUM(t_bayar_main.JML_TINDAKAN_RI) AS JML_TINDAKAN_RI,
				SUM(t_bayar_main.HARGA_TINDAKAN_RI) AS HARGA_TINDAKAN_RI,
				SUM(t_bayar_main.JML_OPERASI) AS JML_OPERASI,
				SUM(t_bayar_main.HARGA_OPERASI) AS HARGA_OPERASI,
				SUM(t_bayar_main.JML_PMI) AS JML_PMI,
				SUM(t_bayar_main.HARGA_PMI) AS HARGA_PMI,
				SUM(t_bayar_main.JML_SKRINING_GIZI) AS JML_SKRINING_GIZI,
				SUM(t_bayar_main.HARGA_SKRINING_GIZI) AS HARGA_SKRINING_GIZI,
				SUM(t_bayar_main.JML_ASKEP) AS JML_ASKEP,
				SUM(t_bayar_main.HARGA_ASKEP) AS HARGA_ASKEP,
				t_bayar_main.TGL_BAYAR,t_bayar_main.SHIFT,
				MAX(t_bayar_main.COST_SHARING) AS COST_SHARING
				FROM (
					SELECT t_bayar_l1.RAWAT_ID,jmn.NAMA_JAMINAN,
					t_bayar_l1.NOMR,psn.NAMA_PASIEN,unt.NAMA_UNIT,
					rng.NAMA_RUANG,t_bayar_l1.TGL_MASUK,t_bayar_l1.TGL_KELUAR,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_akomodasi . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_AKOMODASI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_akomodasi . ') THEN  
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
						ELSE 0 END) AS HARGA_AKOMODASI,
					CASE WHEN mtr.KODE_TARIF IN (' . $arr_visit_dokter_umum . ') THEN
						CASE WHEN pgw2.NAMA_PEGAWAI IS NOT NULL THEN pgw2.NAMA_PEGAWAI
						ELSE pgw.NAMA_PEGAWAI END							
					END AS VISIT_DOKTER_UMUM,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_visit_dokter_umum . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_VISIT_DOKTER_UMUM,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_visit_dokter_umum . ') THEN  
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
						ELSE 0 END) AS HARGA_VISIT_DOKTER_UMUM,
					CASE WHEN mtr.KODE_TARIF IN (' . $arr_visit_dokter_spesialis . ') THEN
						CASE WHEN pgw2.NAMA_PEGAWAI IS NOT NULL THEN pgw2.NAMA_PEGAWAI
						ELSE pgw.NAMA_PEGAWAI END							
					END AS VISIT_DOKTER_SPESIALIS, 
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_visit_dokter_spesialis . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_VISIT_DOKTER_SPESIALIS,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_visit_dokter_spesialis . ') THEN  
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
						ELSE 0 END) AS HARGA_VISIT_DOKTER_SPESIALIS,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_tindakan_ri . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_TINDAKAN_RI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_tindakan_ri . ') THEN  
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
						ELSE 0 END) AS HARGA_TINDAKAN_RI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_operasi . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_OPERASI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_operasi . ') THEN  
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
						ELSE 0 END) AS HARGA_OPERASI,	
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_pmi . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_PMI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_pmi . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_PMI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_skrining_gizi . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_SKRINING_GIZI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_skrining_gizi . ') THEN  
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
						ELSE 0 END) AS HARGA_SKRINING_GIZI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_askep . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_ASKEP,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_askep . ') THEN  
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
						ELSE 0 END) AS HARGA_ASKEP,
					t_bayar_l1.KASIR,
					t_bayar_l1.TGL_BAYAR,
					t_bayar_l1.SHIFT,
					MAX(t_bayar_l1.COST_SHARING) AS COST_SHARING
					FROM (
							SELECT "IRI" AS PASIEN,iri.IRNA_ID AS RAWAT_ID,iri.NOMR,
							trf.JENIS_BAYAR_ID,NULL AS UNIT_ID,trf.RUANG_ID,
							DATE_FORMAT(iri.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(iri.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,trf.KELAS_RAWAT AS KELAS_RAWAT,
							NULL AS PEGAWAI_ID,trf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(trf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(iri.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(trf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							trf.SHIFT_ID AS SHIFT,
							iri.COST_SHARING
							FROM db_simrs.t_irna iri
							INNER JOIN db_simrs.t_irna_tarif trf
							ON (iri.IRNA_ID = trf.IRNA_ID
							AND trf.NO_TARIF IS NOT NULL)
							WHERE iri.NO_PENDAFTARAN IS NOT NULL 
							AND iri.ST_BATAL IS NULL
							' . (($jns_bayar != '1') ? 'AND DATE(iri.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(iri.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
								AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND trf.ST_BAYAR = "Lunas"' : 'AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
								AND trf.JENIS_BAYAR_ID = "1"
								AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
							UNION ALL
							SELECT "PNJ" AS PASIEN,iri.IRNA_ID AS RAWAT_ID,iri.NOMR,
							pnjtf.JENIS_BAYAR_ID,NULL AS UNIT_ID,pnj.RUANG_ID,
							DATE_FORMAT(iri.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(iri.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							pnjtf.PEGAWAI_DIAGNOSA_ID AS PEGAWAI_ID,
							pnjtf.PEGAWAI_PERIKSA_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(iri.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							pnjtf.SHIFT_KASIR AS SHIFT,
							NULL AS COST_SHARING
							FROM db_simrs.t_irna iri
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (iri.IRNA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							WHERE iri.NO_PENDAFTARAN IS NOT NULL 
							AND iri.ST_BATAL IS NULL
							' . (($jns_bayar != '1') ? 'AND DATE(iri.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(iri.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
								AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND pnjtf.ST_BAYAR = "Lunas"' : 'AND DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
								AND pnjtf.JENIS_BAYAR_ID = "1"
								AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")') . '
							AND (pnj.JNS_ORDER = "IRN" OR pnj.JNS_ORDER = "HRI" OR pnj.JNS_ORDER = "ORI")		
							UNION ALL
							SELECT "AMB" AS PASIEN,iri.IRNA_ID AS RAWAT_ID,iri.NOMR,
							tfamb.JENIS_BAYAR_ID,NULL AS UNIT_ID,tfamb.RUANG_ID,
							DATE_FORMAT(iri.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(iri.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							NULL AS PEGAWAI_ID,tfamb.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(iri.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(tfamb.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							tfamb.SHIFT_ID AS SHIFT,
							NULL AS COST_SHARING
							FROM db_simrs.t_irna iri
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (iri.IRNA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							WHERE iri.NO_PENDAFTARAN IS NOT NULL 
							AND iri.ST_BATAL IS NULL
							' . (($jns_bayar != '1') ? 'AND DATE(iri.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(iri.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
								AND tfamb.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND tfamb.ST_BAYAR = "Lunas"' : 'AND DATE(tfamb.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(tfamb.TGL_BAYAR) <= ' . $tgl_filter_2 . '
								AND tfamb.JENIS_BAYAR_ID = "1"
								AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")') . ' 
							AND tfamb.JNS_ORDER = "IRN"	
							UNION ALL
							SELECT "HMD" AS PASIEN,iri.IRNA_ID AS RAWAT_ID,iri.NOMR,
							hmdtf.JENIS_BAYAR_ID,NULL AS UNIT_ID,hmd.RUANG_ID,
							DATE_FORMAT(iri.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(iri.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							hmd.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,hmdtf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(iri.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(hmdtf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							hmdtf.SHIFT_ID AS SHIFT,
							NULL AS COST_SHARING
							FROM db_simrs.t_irna iri
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (iri.IRNA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							WHERE iri.NO_PENDAFTARAN IS NOT NULL 
							AND iri.ST_BATAL IS NULL
							' . (($jns_bayar != '1') ? 'AND DATE(iri.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(iri.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
								AND hmdtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND hmdtf.ST_BAYAR = "Lunas"' : 'AND DATE(hmdtf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(hmdtf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
								AND hmdtf.JENIS_BAYAR_ID = "1"
								AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")') . '
							AND hmd.JNS_ORDER = "IRN"	
							UNION ALL
							SELECT "OPR" AS PASIEN,iri.IRNA_ID AS RAWAT_ID,iri.NOMR,
							optf.JENIS_BAYAR_ID,NULL AS UNIT_ID,opr.RUANG_ID,
							DATE_FORMAT(iri.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(iri.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,optf.KELAS_RAWAT,
							opr.PEGAWAI_PELAKSANA_ID AS PEGAWAI_ID,
							optf.PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(iri.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(optf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							optf.SHIFT_ID AS SHIFT,
							NULL AS COST_SHARING
							FROM db_simrs.t_irna iri
							INNER JOIN db_simrs.t_operasi opr
							ON (iri.IRNA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL)
							WHERE iri.NO_PENDAFTARAN IS NOT NULL 
							AND iri.ST_BATAL IS NULL
							AND opr.NO_PENDAFTARAN IS NOT NULL
							' . (($jns_bayar != '1') ? 'AND DATE(iri.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(iri.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
								AND optf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND optf.ST_BAYAR = "Lunas"' : 'AND DATE(optf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(optf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
								AND optf.JENIS_BAYAR_ID = "1"
								AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")') . '
							AND opr.ST_MASUK = "2"';
							
	//tdk klaim						
	if($jns_bayar == '1'){
		$qry_pembayaran .= 'UNION ALL
							SELECT "IRI" AS PASIEN,iri.IRNA_ID AS RAWAT_ID,iri.NOMR,
							trf.JENIS_BAYAR_ID,NULL AS UNIT_ID,trf.RUANG_ID,
							DATE_FORMAT(iri.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(iri.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,trf.KELAS_RAWAT AS KELAS_RAWAT,
							NULL AS PEGAWAI_ID,trf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(trf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							trf.SHIFT_ID AS SHIFT,
							iri.COST_SHARING
							FROM db_simrs.t_irna iri
							INNER JOIN db_simrs.t_irna_tarif trf
							ON (iri.IRNA_ID = trf.IRNA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (trf.TARIF_ID = klm.TARIF_ID)
							WHERE iri.NO_PENDAFTARAN IS NOT NULL 
							AND iri.ST_BATAL IS NULL
							AND trf.JENIS_BAYAR_ID <> "1"
							AND DATE(trf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")
							AND klm.TDK_KLAIM = "1"	
							UNION ALL
							SELECT "PNJ" AS PASIEN,iri.IRNA_ID AS RAWAT_ID,iri.NOMR,
							pnjtf.JENIS_BAYAR_ID,NULL AS UNIT_ID,pnj.RUANG_ID,
							DATE_FORMAT(iri.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(iri.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							pnjtf.PEGAWAI_DIAGNOSA_ID AS PEGAWAI_ID,
							pnjtf.PEGAWAI_PERIKSA_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(pnjtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT,
							NULL AS COST_SHARING
							FROM db_simrs.t_irna iri
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (iri.IRNA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (pnjtf.TARIF_ID = klm.TARIF_ID)
							WHERE iri.NO_PENDAFTARAN IS NOT NULL 
							AND iri.ST_BATAL IS NULL
							AND pnjtf.JENIS_BAYAR_ID <> "1"
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")
							AND (pnj.JNS_ORDER = "IRN" OR pnj.JNS_ORDER = "HRI" OR pnj.JNS_ORDER = "ORI")
							AND klm.TDK_KLAIM = "1"		
							UNION ALL
							SELECT "AMB" AS PASIEN,iri.IRNA_ID AS RAWAT_ID,iri.NOMR,
							tfamb.JENIS_BAYAR_ID,NULL AS UNIT_ID,tfamb.RUANG_ID,
							DATE_FORMAT(iri.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(iri.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							NULL AS PEGAWAI_ID,tfamb.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(tfamb.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							tfamb.SHIFT_ID AS SHIFT,
							NULL AS COST_SHARING
							FROM db_simrs.t_irna iri
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (iri.IRNA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (tfamb.TARIF_ID = klm.TARIF_ID)
							WHERE iri.NO_PENDAFTARAN IS NOT NULL 
							AND iri.ST_BATAL IS NULL
							AND tfamb.JENIS_BAYAR_ID <> "1"
							AND DATE(tfamb.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(tfamb.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")
							AND tfamb.JNS_ORDER = "IRN"
							AND klm.TDK_KLAIM = "1"	
							UNION ALL
							SELECT "HMD" AS PASIEN,iri.IRNA_ID AS RAWAT_ID,iri.NOMR,
							hmdtf.JENIS_BAYAR_ID,NULL AS UNIT_ID,hmd.RUANG_ID,
							DATE_FORMAT(iri.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(iri.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							hmd.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,hmdtf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(hmdtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							hmdtf.SHIFT_ID AS SHIFT,
							NULL AS COST_SHARING
							FROM db_simrs.t_irna iri
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (iri.IRNA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (hmdtf.TARIF_ID = klm.TARIF_ID)
							WHERE iri.NO_PENDAFTARAN IS NOT NULL 
							AND iri.ST_BATAL IS NULL
							AND hmdtf.JENIS_BAYAR_ID <> "1"
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")
							AND hmd.JNS_ORDER = "IRN"	
							AND klm.TDK_KLAIM = "1"
							UNION ALL
							SELECT "OPR" AS PASIEN,iri.IRNA_ID AS RAWAT_ID,iri.NOMR,
							optf.JENIS_BAYAR_ID,NULL AS UNIT_ID,opr.RUANG_ID,
							DATE_FORMAT(iri.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(iri.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,optf.KELAS_RAWAT,
							opr.PEGAWAI_PELAKSANA_ID AS PEGAWAI_ID,
							optf.PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(optf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							optf.SHIFT_ID AS SHIFT,
							NULL AS COST_SHARING
							FROM db_simrs.t_irna iri
							INNER JOIN db_simrs.t_operasi opr
							ON (iri.IRNA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (optf.TARIF_ID = klm.TARIF_ID)
							WHERE iri.NO_PENDAFTARAN IS NOT NULL 
							AND iri.ST_BATAL IS NULL
							AND opr.NO_PENDAFTARAN IS NOT NULL
							AND optf.JENIS_BAYAR_ID <> "1"
							AND DATE(optf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(optf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")
							AND opr.ST_MASUK = "2"
							AND klm.TDK_KLAIM = "1"';	
	}	
	//end tdk klaim
	
	$qry_pembayaran .= ') t_bayar_l1
					INNER JOIN db_simrs.m_tarif mtr
					ON (t_bayar_l1.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg
					ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					INNER JOIN db_simrs.m_jaminan jmn
					ON (t_bayar_l1.JENIS_BAYAR_ID = jmn.JAMINAN_ID)
					INNER JOIN db_simrs.m_pasien psn
					ON (t_bayar_l1.NOMR = psn.NOMR)
					LEFT JOIN db_simrs.m_unit unt
					ON (t_bayar_l1.UNIT_ID = unt.UNIT_ID)
					LEFT JOIN db_simrs.m_ruang rng
					ON (t_bayar_l1.RUANG_ID = rng.RUANG_ID)	
					LEFT JOIN db_simrs.m_pegawai pgw ON (t_bayar_l1.PEGAWAI_ID = pgw.PEGAWAI_ID)
					LEFT JOIN db_simrs.m_pegawai pgw2 ON (t_bayar_l1.PEGAWAI_PELAKSANA_ID = pgw2.PEGAWAI_ID)
					GROUP BY t_bayar_l1.RAWAT_ID,jmn.NAMA_JAMINAN,
					t_bayar_l1.NOMR,psn.NAMA_PASIEN,unt.NAMA_UNIT,
					rng.NAMA_RUANG,t_bayar_l1.TGL_MASUK,t_bayar_l1.TGL_KELUAR,
					t_bayar_l1.KASIR,t_bayar_l1.TGL_BAYAR,t_bayar_l1.SHIFT,
					VISIT_DOKTER_UMUM,VISIT_DOKTER_SPESIALIS
				) t_bayar_main
				GROUP BY t_bayar_main.RAWAT_ID,t_bayar_main.NAMA_JAMINAN,
				t_bayar_main.NOMR,t_bayar_main.NAMA_PASIEN,t_bayar_main.NAMA_UNIT,
				t_bayar_main.NAMA_RUANG,t_bayar_main.TGL_MASUK,t_bayar_main.TGL_KELUAR,
				t_bayar_main.TGL_BAYAR,t_bayar_main.SHIFT
				ORDER BY t_bayar_main.RAWAT_ID';
$get_pembayaran = mysql_query($qry_pembayaran) or die(mysql_error());	
$akomodasi = 0;
$dokter_umum = 0;
$dokter_spesialis = 0;
$tindakan = 0;
$operasi = 0;
$pmi = 0;
$gizi = 0;
$askep = 0;
$total = 0;
$cost_sharing = 0;
while($dat_pembayaran = mysql_fetch_array($get_pembayaran)){ 
	$str_visit_dokter_umum = '|';
	$jml_visit_dokter_umum = '|';
	if($dat_pembayaran['VISIT_DOKTER_UMUM'] != ''){
		$str_visit_dokter_umum = '';
		$jml_visit_dokter_umum = '';
		$arr_str_visit_dokter_umum = explode('||',$dat_pembayaran['VISIT_DOKTER_UMUM']);
		foreach($arr_str_visit_dokter_umum as $row){
			$arr_row = explode('|',$row);
			$str_visit_dokter_umum .= $arr_row[0] . '|';
			$jml_visit_dokter_umum .= $arr_row[1] . '|';
		}
	}
	
	$str_visit_dokter_spesialis = '|';
	$jml_visit_dokter_spesialis = '|';
	if($dat_pembayaran['VISIT_DOKTER_SPESIALIS'] != ''){
		$str_visit_dokter_spesialis = '';
		$jml_visit_dokter_spesialis = '';
		$arr_str_visit_dokter_spesialis = explode('||',$dat_pembayaran['VISIT_DOKTER_SPESIALIS']);
		foreach($arr_str_visit_dokter_spesialis as $row){
			$arr_row = explode('|',$row);
			$str_visit_dokter_spesialis .= $arr_row[0] . '|';
			$jml_visit_dokter_spesialis .= $arr_row[1] . '|';
		}
	}
	
	$akomodasi += $dat_pembayaran['HARGA_AKOMODASI'];
	$dokter_umum += $dat_pembayaran['HARGA_VISIT_DOKTER_UMUM'];
	$dokter_spesialis += $dat_pembayaran['HARGA_VISIT_DOKTER_SPESIALIS'];
	$tindakan += $dat_pembayaran['HARGA_TINDAKAN_RI'];
	$operasi += $dat_pembayaran['HARGA_OPERASI'];
	$pmi += $dat_pembayaran['HARGA_PMI'];
	$gizi += $dat_pembayaran['HARGA_SKRINING_GIZI'];
	$askep += $dat_pembayaran['HARGA_ASKEP'];
	$subtotal = $dat_pembayaran['HARGA_AKOMODASI'] + $dat_pembayaran['HARGA_VISIT_DOKTER_UMUM'] + $dat_pembayaran['HARGA_VISIT_DOKTER_SPESIALIS'] +
			$dat_pembayaran['HARGA_TINDAKAN_RI'] + $dat_pembayaran['HARGA_OPERASI'] + $dat_pembayaran['HARGA_PMI'] + $dat_pembayaran['HARGA_SKRINING_GIZI'] +
			$dat_pembayaran['HARGA_ASKEP'];
	$total += $subtotal;
	$cost_sharing += $dat_pembayaran['COST_SHARING'];
	if($subtotal > 0){
?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
	<td><?php echo $dat_pembayaran['NAMA_JAMINAN']; ?></td>
	<td><?php echo formatNomr($dat_pembayaran['NOMR']); ?></td>
	<td><?php echo $dat_pembayaran['NAMA_PASIEN']; ?></td>
    <td><?php echo $dat_pembayaran['NAMA_RUANG']; ?></td>
	<td><?php echo $dat_pembayaran['TGL_MASUK']; ?></td>
	<td><?php echo $dat_pembayaran['TGL_KELUAR']; ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_AKOMODASI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_AKOMODASI']); ?></td>
	<td><?php echo substr($str_visit_dokter_umum,0,strlen($str_visit_dokter_umum)-1); ?></td>
	<td align="right"><?php echo substr($jml_visit_dokter_umum,0,strlen($jml_visit_dokter_umum)-1); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_VISIT_DOKTER_UMUM']); ?></td>
	<td><?php echo substr($str_visit_dokter_spesialis,0,strlen($str_visit_dokter_spesialis)-1); ?></td>
	<td align="right"><?php echo substr($jml_visit_dokter_spesialis,0,strlen($jml_visit_dokter_spesialis)-1); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_VISIT_DOKTER_SPESIALIS']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_TINDAKAN_RI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_TINDAKAN_RI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_OPERASI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_OPERASI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_PMI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_PMI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_SKRINING_GIZI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_SKRINING_GIZI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_ASKEP']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_ASKEP']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_AKOMODASI'] + $dat_pembayaran['HARGA_VISIT_DOKTER_UMUM'] + 
	$dat_pembayaran['HARGA_VISIT_DOKTER_SPESIALIS'] + $dat_pembayaran['HARGA_TINDAKAN_RI'] + $dat_pembayaran['HARGA_OPERASI'] +
	$dat_pembayaran['HARGA_PMI'] + $dat_pembayaran['HARGA_SKRINING_GIZI'] + $dat_pembayaran['HARGA_ASKEP']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['COST_SHARING']); ?></td>
	<td align="center"><?php $jam_kerja = $dat_pembayaran['TGL_BAYAR'];
					if($dat_pembayaran['SHIFT'] != '') $jam_kerja .= ' ['.$dat_pembayaran['SHIFT'] . ']'; 
					echo $jam_kerja; ?></td>
  </tr>
<?php $no++; } } ?> 
 <tr>
	<td colspan="7" align="center">TOTAL</td>
    <td align="right" colspan="2"><?php echo currFormat($akomodasi); ?></td>
	<td align="right" colspan="3"><?php echo currFormat($dokter_umum); ?></td>
	<td align="right" colspan="3"><?php echo currFormat($dokter_spesialis); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($tindakan); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($operasi); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($pmi); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($gizi); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($askep); ?></td>
	<td align="right"><?php echo currFormat($total); ?></td>
	<td align="right"><?php echo currFormat($cost_sharing); ?></td>
	<td align="center">&nbsp;</td>
  </tr>
</table>
