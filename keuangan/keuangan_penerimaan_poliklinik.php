<?php
$report_id = '2';
	
$arr_karcis = '';
$arr_konsul_dokter_umum = '';
$arr_konsul_dokter_spesialis = '';
$arr_tindakan = '';
$arr_operasi = '';	 	

$qry = 'SELECT t_filter_report_tarif.KODE_TARIF_GROUP,t_filter_report_tarif.NAMA_TARIF_FILTER,
		t_filter_report_tarif.LEVEL_DT
		FROM t_filter_report_tarif
		WHERE t_filter_report_tarif.REPORT_ID = "' . $report_id . '"';
$get = mysql_query($qry) or die(mysql_error());
while($dat = mysql_fetch_array($get)){
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'karcis' and $dat['LEVEL_DT'] == '1') $arr_karcis .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'konsul dokter umum' and $dat['LEVEL_DT'] == '2') $arr_konsul_dokter_umum .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'konsul dokter spesialis' and $dat['LEVEL_DT'] == '2') $arr_konsul_dokter_spesialis .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'tindakan rawat jalan - igd' and $dat['LEVEL_DT'] == '1') $arr_tindakan .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'operasi' and $dat['LEVEL_DT'] == '1') $arr_operasi .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
} 	

$arr_karcis .= '"00"';
$arr_konsul_dokter_umum .= '"00"';
$arr_konsul_dokter_spesialis .= '"00"';
$arr_tindakan .= '"00"';
$arr_operasi .= '"00"';

$tgl_1 = '';
if (isset($_SESSION['pembayaranreportrekapbayar_tgl_1']))
    $tgl_1 = $_SESSION['pembayaranreportrekapbayar_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaranreportrekapbayar_tgl_2']))
    $tgl_2 = $_SESSION['pembayaranreportrekapbayar_tgl_2'];
	
$jns_bayar = '1';
if (isset($_SESSION['pembayaranreportrekapbayar_jns_bayar']))
    $jns_bayar = $_SESSION['pembayaranreportrekapbayar_jns_bayar'];	
	
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaranreportrekapbayar_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaranreportrekapbayar_tgl_2'] = $_GET['tgl_2'];
}

if (isset($_GET['jns_bayar'])) {
    $jns_bayar = $_GET['jns_bayar'];
    $_SESSION['pembayaranreportrekapbayar_jns_bayar'] = $_GET['jns_bayar'];
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}


$arr_igd = '0,';
foreach(getArrUnitIGD() as $row){
	$arr_igd .= $row . ',';
}
$arr_igd = substr($arr_igd,0,strlen($arr_igd) - 1);	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
         <tr>
            <td>Jenis Pembayaran</td>
            <td>
			<select name="jns_bayar" class="text_dt" style="width:160px;" >
			<?php echo getJnsBayar($jns_bayar,'1');?>
			</select></td>
       </tr>
		<tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
       </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
	<input type="hidden" name="kasir" value="<?php echo $_REQUEST['kasir']; ?>" />
</form>
<br />
<table width="100%" border="1" class="tableData" id="tfhover">
   <tr>
    <th rowspan="2">No</th>
	<th rowspan="2">Jenis Bayar</th>
	<th rowspan="2">NOMR</th>
    <th rowspan="2">Nama Pasien</th>
	<th rowspan="2">Nama Unit/ Ruang </th>
    <th rowspan="2">Tgl Masuk </th>
    <th rowspan="2">Tgl Keluar</th>
	<th colspan="2"><div onclick="open_def_report('karcis','1');">Karcis</div></th>
	<th colspan="3"><div onclick="open_def_report('konsul dokter umum','2');">Konsul<br />Dokter Umum</div></th>
	<th colspan="3"><div onclick="open_def_report('konsul dokter spesialis','2');">Konsul<br />Dokter Spesialis</div></th>
	<th colspan="2"><div onclick="open_def_report('tindakan rawat jalan - igd','1');">Tindakan</div></th>
	<th colspan="2"><div onclick="open_def_report('operasi','1');">Operasi</div></th>
	<th rowspan="2">Jumlah</th>
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
   </tr>
<?php $no = 1; 
$qry_pembayaran = 'SELECT t_bayar_main.RAWAT_ID,t_bayar_main.NAMA_JAMINAN,
				t_bayar_main.NOMR,t_bayar_main.NAMA_PASIEN,t_bayar_main.NAMA_UNIT,
				t_bayar_main.NAMA_RUANG,t_bayar_main.TGL_MASUK,t_bayar_main.TGL_KELUAR,
				SUM(t_bayar_main.JML_KARCIS) AS JML_KARCIS,
				SUM(t_bayar_main.HARGA_KARCIS) AS HARGA_KARCIS,
				GROUP_CONCAT(t_bayar_main.KONSUL_DOKTER_UMUM,"|",CAST(t_bayar_main.JML_KONSUL_DOKTER_UMUM AS CHAR) SEPARATOR "||") AS KONSUL_DOKTER_UMUM,
				SUM(t_bayar_main.JML_KONSUL_DOKTER_UMUM) AS JML_KONSUL_DOKTER_UMUM,
				SUM(t_bayar_main.HARGA_KONSUL_DOKTER_UMUM) AS HARGA_KONSUL_DOKTER_UMUM,
				GROUP_CONCAT(t_bayar_main.KONSUL_DOKTER_SPESIALIS,"|",CAST(t_bayar_main.JML_KONSUL_DOKTER_SPESIALIS AS CHAR) SEPARATOR "||") AS KONSUL_DOKTER_SPESIALIS,
				SUM(t_bayar_main.JML_KONSUL_DOKTER_SPESIALIS) AS JML_KONSUL_DOKTER_SPESIALIS,
				SUM(t_bayar_main.HARGA_KONSUL_DOKTER_SPESIALIS) AS HARGA_KONSUL_DOKTER_SPESIALIS,
				SUM(t_bayar_main.JML_TINDAKAN) AS JML_TINDAKAN,
				SUM(t_bayar_main.HARGA_TINDAKAN) AS HARGA_TINDAKAN,
				SUM(t_bayar_main.JML_OPERASI) AS JML_OPERASI,
				SUM(t_bayar_main.HARGA_OPERASI) AS HARGA_OPERASI,
				t_bayar_main.TGL_BAYAR,t_bayar_main.SHIFT
				FROM (
					SELECT t_bayar_l1.RAWAT_ID,jmn.NAMA_JAMINAN,
					t_bayar_l1.NOMR,psn.NAMA_PASIEN,unt.NAMA_UNIT,
					rng.NAMA_RUANG,t_bayar_l1.TGL_MASUK,t_bayar_l1.TGL_KELUAR,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_karcis . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_KARCIS,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_karcis . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_KARCIS,
					CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_umum . ') THEN
						CASE WHEN pgw2.NAMA_PEGAWAI IS NOT NULL THEN pgw2.NAMA_PEGAWAI 
						ELSE pgw.NAMA_PEGAWAI END							
					END AS KONSUL_DOKTER_UMUM,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_umum . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_KONSUL_DOKTER_UMUM,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_umum . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_KONSUL_DOKTER_UMUM,
					CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_spesialis . ') THEN
						CASE WHEN pgw2.NAMA_PEGAWAI IS NOT NULL THEN pgw2.NAMA_PEGAWAI 
						ELSE pgw.NAMA_PEGAWAI END							
					END AS KONSUL_DOKTER_SPESIALIS,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_spesialis . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_KONSUL_DOKTER_SPESIALIS,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_spesialis . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_KONSUL_DOKTER_SPESIALIS,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_tindakan . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_TINDAKAN,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_tindakan . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_TINDAKAN,
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
					t_bayar_l1.KASIR,
					t_bayar_l1.TGL_BAYAR,
					t_bayar_l1.SHIFT
					FROM (';
					
if($_GET['kasir'] == 'igd'){
	$qry_pembayaran .= 'SELECT "IGD" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							igd.PEGAWAI_ID,trf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(trf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(trf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							trf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (igd.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							' . (($jns_bayar != '1') ? 'AND DATE(igd.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(igd.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
								AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND trf.ST_BAYAR = "Lunas"' : 'AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
								AND trf.JENIS_BAYAR_ID = "1"
								AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
							UNION ALL
							SELECT "PNJ" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							pnjtf.PEGAWAI_DIAGNOSA_ID AS PEGAWAI_ID,
							pnjtf.PEGAWAI_PERIKSA_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							pnjtf.SHIFT_KASIR AS SHIFT
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (igd.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							' . (($jns_bayar != '1') ? 'AND DATE(igd.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(igd.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
								AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND pnjtf.ST_BAYAR = "Lunas"' : 'AND DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
								AND pnjtf.JENIS_BAYAR_ID = "1"
								AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")') . '
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ")		
							UNION ALL
							SELECT "AMB" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							NULL AS PEGAWAI_ID,tfamb.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(tfamb.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							tfamb.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (igd.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							' . (($jns_bayar != '1') ? 'AND DATE(igd.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(igd.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
								AND tfamb.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND tfamb.ST_BAYAR = "Lunas"' : 'AND DATE(tfamb.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(tfamb.TGL_BAYAR) <= ' . $tgl_filter_2 . '
								AND tfamb.JENIS_BAYAR_ID = "1"
								AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")') . ' 
							AND tfamb.JNS_ORDER = "IRJ"	
							UNION ALL
							SELECT "HMD" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							hmd.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,hmdtf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(hmdtf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							hmdtf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (igd.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							' . (($jns_bayar != '1') ? 'AND DATE(igd.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(igd.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
								AND hmdtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND hmdtf.ST_BAYAR = "Lunas"' : 'AND DATE(hmdtf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(hmdtf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
								AND hmdtf.JENIS_BAYAR_ID = "1"
								AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")') . '
							AND hmd.JNS_ORDER = "IRJ"	
							UNION ALL
							SELECT "OPR" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							opr.PEGAWAI_PELAKSANA_ID AS PEGAWAI_ID,
							optf.PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(optf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							optf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_operasi opr
							ON (igd.IRJA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND opr.NO_PENDAFTARAN IS NOT NULL
							' . (($jns_bayar != '1') ? 'AND DATE(igd.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(igd.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
								AND optf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND optf.ST_BAYAR = "Lunas"' : 'AND DATE(optf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(optf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
								AND optf.JENIS_BAYAR_ID = "1"
								AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")') . '
							AND opr.ST_MASUK = "1"';
							
	//igd tidak diklaim
	if($jns_bayar == '1'){
		$qry_pembayaran .= 'UNION ALL
							SELECT "IGD" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							igd.PEGAWAI_ID,trf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(trf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							trf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (igd.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (trf.TARIF_ID = klm.TARIF_ID)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND trf.JENIS_BAYAR_ID <> "1"
							AND DATE(trf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")
							AND klm.TDK_KLAIM = "1"	
							UNION ALL
							SELECT "PNJ" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							pnjtf.PEGAWAI_DIAGNOSA_ID AS PEGAWAI_ID,
							pnjtf.PEGAWAI_PERIKSA_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(pnjtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (igd.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (pnjtf.TARIF_ID = klm.TARIF_ID)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND pnjtf.JENIS_BAYAR_ID <> "1"
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ")
							AND klm.TDK_KLAIM = "1"		
							UNION ALL
							SELECT "AMB" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							NULL AS PEGAWAI_ID,tfamb.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(tfamb.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							tfamb.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (igd.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (tfamb.TARIF_ID = klm.TARIF_ID)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND tfamb.JENIS_BAYAR_ID <> "1"
							AND DATE(tfamb.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(tfamb.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")
							AND tfamb.JNS_ORDER = "IRJ"
							AND klm.TDK_KLAIM = "1"		
							UNION ALL
							SELECT "HMD" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							hmd.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,hmdtf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(hmdtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							hmdtf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (igd.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (hmdtf.TARIF_ID = klm.TARIF_ID)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND hmdtf.JENIS_BAYAR_ID <> "1"
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")
							AND hmd.JNS_ORDER = "IRJ"
							AND klm.TDK_KLAIM = "1"		
							UNION ALL
							SELECT "OPR" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
							igd.JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							opr.PEGAWAI_PELAKSANA_ID AS PEGAWAI_ID,
							optf.PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(optf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							optf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja igd
							INNER JOIN db_simrs.t_operasi opr
							ON (igd.IRJA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (optf.TARIF_ID = klm.TARIF_ID)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID IN (' . $arr_igd . ')
							AND opr.NO_PENDAFTARAN IS NOT NULL
							AND optf.JENIS_BAYAR_ID <> "1"
							AND DATE(optf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(optf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")
							AND opr.ST_MASUK = "1"
							AND klm.TDK_KLAIM = "1"	';
	}						
	//end igd tidak diklaim
							
}else if($_GET['kasir'] == 'umum'){							
	$qry_pembayaran .= 'SELECT "IRJ" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							irj.PEGAWAI_ID,trf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(trf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(trf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							trf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (irj.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35 
							' . (($jns_bayar != '1') ? 'AND DATE(irj.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(irj.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
								AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND trf.ST_BAYAR = "Lunas"' : 'AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
								AND trf.JENIS_BAYAR_ID = "1"
								AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
							UNION ALL
							SELECT "PNJ" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							pnjtf.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							pnjtf.PEGAWAI_DIAGNOSA_ID AS PEGAWAI_ID,
							pnjtf.PEGAWAI_PERIKSA_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(pnjtf.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							pnjtf.SHIFT_KASIR AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irj.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35
							' . (($jns_bayar != '1') ? 'AND DATE(pnjtf.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(pnjtf.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
								AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND pnjtf.ST_BAYAR = "Lunas"' : 'AND DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
								AND pnjtf.JENIS_BAYAR_ID = "1"
								AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")') . '
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ")		
							UNION ALL
							SELECT "AMB" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							NULL AS PEGAWAI_ID,tfamb.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(tfamb.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							tfamb.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irj.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35
							' . (($jns_bayar != '1') ? 'AND DATE(irj.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(irj.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
								AND tfamb.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND tfamb.ST_BAYAR = "Lunas"' : 'AND DATE(tfamb.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(tfamb.TGL_BAYAR) <= ' . $tgl_filter_2 . '
								AND tfamb.JENIS_BAYAR_ID = "1"
								AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")') . ' 
							AND tfamb.JNS_ORDER = "IRJ"	
							UNION ALL
							SELECT "HMD" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							hmdtf.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							hmd.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,hmdtf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(hmd.TANGGAL_ORDER,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(hmdtf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							hmdtf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irj.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35
							' . (($jns_bayar != '1') ? 'AND DATE(hmd.TANGGAL_ORDER) >= ' . $tgl_filter_1 . ' 
								AND DATE(hmd.TANGGAL_ORDER) <= ' . $tgl_filter_2 . '
								AND hmdtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND hmdtf.ST_BAYAR = "Lunas"' : 'AND DATE(hmdtf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(hmdtf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
								AND hmdtf.JENIS_BAYAR_ID = "1"
								AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")') . '
							AND hmd.JNS_ORDER = "IRJ"	
							UNION ALL
							SELECT "OPR" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							optf.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							opr.PEGAWAI_PELAKSANA_ID AS PEGAWAI_ID,
							optf.PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(opr.TANGGAL_OPERASI,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(optf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							optf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_operasi opr
							ON (irj.IRJA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35
							AND opr.NO_PENDAFTARAN IS NOT NULL
							' . (($jns_bayar != '1') ? 'AND DATE(opr.TANGGAL_OPERASI) >= ' . $tgl_filter_1 . ' 
								AND DATE(opr.TANGGAL_OPERASI) <= ' . $tgl_filter_2 . '
								AND optf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND optf.ST_BAYAR = "Lunas"' : 'AND DATE(optf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(optf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
								AND optf.JENIS_BAYAR_ID = "1"
								AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")') . '
							AND opr.ST_MASUK = "1"';
							
	//rj tidak diklaim
	if($jns_bayar == '1'){
		$qry_pembayaran .= 'UNION ALL
							SELECT "IRJ" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							irj.PEGAWAI_ID,trf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(trf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							trf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (irj.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (trf.TARIF_ID = klm.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35 
							AND trf.JENIS_BAYAR_ID <> "1"
							AND DATE(trf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")
							AND klm.TDK_KLAIM = "1"
							UNION ALL
							SELECT "PNJ" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							pnjtf.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							pnjtf.PEGAWAI_DIAGNOSA_ID AS PEGAWAI_ID,
							pnjtf.PEGAWAI_PERIKSA_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(pnjtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irj.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (pnjtf.TARIF_ID = klm.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35
							AND pnjtf.JENIS_BAYAR_ID <> "1"
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ")
							AND klm.TDK_KLAIM = "1"	
							UNION ALL
							SELECT "AMB" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							NULL AS PEGAWAI_ID,tfamb.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(tfamb.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							tfamb.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irj.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (tfamb.TARIF_ID = klm.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35
							AND tfamb.JENIS_BAYAR_ID <> "1"
							AND DATE(tfamb.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(tfamb.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")
							AND tfamb.JNS_ORDER = "IRJ"
							AND klm.TDK_KLAIM = "1"	
							UNION ALL
							SELECT "HMD" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							hmdtf.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							hmd.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,hmdtf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(hmdtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							hmdtf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irj.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (hmdtf.TARIF_ID = klm.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35
							AND hmdtf.JENIS_BAYAR_ID <> "1"
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")
							AND hmd.JNS_ORDER = "IRJ"
							AND klm.TDK_KLAIM = "1"	
							UNION ALL
							SELECT "OPR" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							optf.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							opr.PEGAWAI_PELAKSANA_ID AS PEGAWAI_ID,
							optf.PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(optf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							optf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_operasi opr
							ON (irj.IRJA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (optf.TARIF_ID = klm.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35
							AND opr.NO_PENDAFTARAN IS NOT NULL
							AND optf.JENIS_BAYAR_ID <> "1"
							AND DATE(optf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(optf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")
							AND opr.ST_MASUK = "1"
							AND klm.TDK_KLAIM = "1"';
	}
	//end rj tidak diklaim						
}else if($_GET['kasir'] == 'kusta'){
	$qry_pembayaran .= 'SELECT "IRJ" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							irj.PEGAWAI_ID,trf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(trf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(trf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							trf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (irj.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID = 35 
							' . (($jns_bayar != '1') ? 'AND DATE(irj.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(irj.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
								AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND trf.ST_BAYAR = "Lunas"' : 'AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
								AND trf.JENIS_BAYAR_ID = "1"
								AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
							UNION ALL
							SELECT "PNJ" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							pnjtf.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							pnjtf.PEGAWAI_DIAGNOSA_ID AS PEGAWAI_ID,
							pnjtf.PEGAWAI_PERIKSA_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(pnjtf.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							pnjtf.SHIFT_KASIR AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irj.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID = 35
							' . (($jns_bayar != '1') ? 'AND DATE(pnjtf.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(pnjtf.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
								AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND pnjtf.ST_BAYAR = "Lunas"' : 'AND DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
								AND pnjtf.JENIS_BAYAR_ID = "1"
								AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")') . '
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ")		
							UNION ALL
							SELECT "AMB" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							NULL AS PEGAWAI_ID,tfamb.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(tfamb.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							tfamb.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irj.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID = 35
							' . (($jns_bayar != '1') ? 'AND DATE(irj.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(irj.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
								AND tfamb.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND tfamb.ST_BAYAR = "Lunas"' : 'AND DATE(tfamb.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(tfamb.TGL_BAYAR) <= ' . $tgl_filter_2 . '
								AND tfamb.JENIS_BAYAR_ID = "1"
								AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")') . ' 
							AND tfamb.JNS_ORDER = "IRJ"	
							UNION ALL
							SELECT "HMD" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							hmdtf.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							hmd.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,hmdtf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(hmd.TANGGAL_ORDER,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(hmdtf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							hmdtf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irj.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID = 35
							' . (($jns_bayar != '1') ? 'AND DATE(hmd.TANGGAL_ORDER) >= ' . $tgl_filter_1 . ' 
								AND DATE(hmd.TANGGAL_ORDER) <= ' . $tgl_filter_2 . '
								AND hmdtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND hmdtf.ST_BAYAR = "Lunas"' : 'AND DATE(hmdtf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(hmdtf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
								AND hmdtf.JENIS_BAYAR_ID = "1"
								AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")') . '
							AND hmd.JNS_ORDER = "IRJ"	
							UNION ALL
							SELECT "OPR" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							optf.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							opr.PEGAWAI_PELAKSANA_ID AS PEGAWAI_ID,
							optf.PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(opr.TANGGAL_OPERASI,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(optf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							optf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_operasi opr
							ON (irj.IRJA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID = 35
							AND opr.NO_PENDAFTARAN IS NOT NULL
							' . (($jns_bayar != '1') ? 'AND DATE(opr.TANGGAL_OPERASI) >= ' . $tgl_filter_1 . ' 
								AND DATE(opr.TANGGAL_OPERASI) <= ' . $tgl_filter_2 . '
								AND optf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND optf.ST_BAYAR = "Lunas"' : 'AND DATE(optf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(optf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
								AND optf.JENIS_BAYAR_ID = "1"
								AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")') . '
							AND opr.ST_MASUK = "1"';
							
	//kusta tidak diklaim
	if($jns_bayar == '1'){
		$qry_pembayaran .= 'UNION ALL
							SELECT "IRJ" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							irj.PEGAWAI_ID,trf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(trf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							trf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (irj.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (trf.TARIF_ID = klm.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID = 35 
							AND trf.JENIS_BAYAR_ID <> "1"
							AND DATE(trf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")
							AND klm.TDK_KLAIM = "1"
							UNION ALL
							SELECT "PNJ" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							pnjtf.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							pnjtf.PEGAWAI_DIAGNOSA_ID AS PEGAWAI_ID,
							pnjtf.PEGAWAI_PERIKSA_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(pnjtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irj.IRJA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (pnjtf.TARIF_ID = klm.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID = 35 
							AND pnjtf.JENIS_BAYAR_ID <> "1"
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ")
							AND klm.TDK_KLAIM = "1"	
							UNION ALL
							SELECT "AMB" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							NULL AS PEGAWAI_ID,tfamb.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(tfamb.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							tfamb.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irj.IRJA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (tfamb.TARIF_ID = klm.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID = 35 
							AND tfamb.JENIS_BAYAR_ID <> "1"
							AND DATE(tfamb.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(tfamb.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")
							AND tfamb.JNS_ORDER = "IRJ"
							AND klm.TDK_KLAIM = "1"	
							UNION ALL
							SELECT "HMD" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							hmdtf.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							hmd.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,hmdtf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(hmdtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							hmdtf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irj.IRJA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (hmdtf.TARIF_ID = klm.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID = 35 
							AND hmdtf.JENIS_BAYAR_ID <> "1"
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(hmdtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")
							AND hmd.JNS_ORDER = "IRJ"
							AND klm.TDK_KLAIM = "1"	
							UNION ALL
							SELECT "OPR" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							optf.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							opr.PEGAWAI_PELAKSANA_ID AS PEGAWAI_ID,
							optf.PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(optf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							optf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irja irj
							INNER JOIN db_simrs.t_operasi opr
							ON (irj.IRJA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (optf.TARIF_ID = klm.TARIF_ID)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID = 35 
							AND opr.NO_PENDAFTARAN IS NOT NULL
							AND optf.JENIS_BAYAR_ID <> "1"
							AND DATE(optf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(optf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")
							AND opr.ST_MASUK = "1"
							AND klm.TDK_KLAIM = "1"';
	}
	//end kusta tidak diklaim						
}							
							
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
					KONSUL_DOKTER_UMUM,KONSUL_DOKTER_SPESIALIS
				) t_bayar_main
				GROUP BY t_bayar_main.RAWAT_ID,t_bayar_main.NAMA_JAMINAN,
				t_bayar_main.NOMR,t_bayar_main.NAMA_PASIEN,t_bayar_main.NAMA_UNIT,
				t_bayar_main.NAMA_RUANG,t_bayar_main.TGL_MASUK,t_bayar_main.TGL_KELUAR,
				t_bayar_main.TGL_BAYAR,t_bayar_main.SHIFT
				ORDER BY t_bayar_main.RAWAT_ID';
$get_pembayaran = mysql_query($qry_pembayaran) or die(mysql_error());	
$karcis = 0;
$dokter_umum = 0;
$dokter_spesialis = 0;
$tindakan = 0;
$operasi = 0;
$total = 0;
while($dat_pembayaran = mysql_fetch_array($get_pembayaran)){ 
	$str_konsul_dokter_umum = '|';
	$jml_konsul_dokter_umum = '|';
	if($dat_pembayaran['KONSUL_DOKTER_UMUM'] != ''){
		$str_konsul_dokter_umum = '';
		$jml_konsul_dokter_umum = '';
		$arr_str_konsul_dokter_umum = explode('||',$dat_pembayaran['KONSUL_DOKTER_UMUM']);
		foreach($arr_str_konsul_dokter_umum as $row){
			$arr_row = explode('|',$row);
			$str_konsul_dokter_umum .= $arr_row[0] . '|';
			$jml_konsul_dokter_umum .= $arr_row[1] . '|';
		}
	}
	
	$str_konsul_dokter_spesialis = '|';
	$jml_konsul_dokter_spesialis = '|';
	if($dat_pembayaran['KONSUL_DOKTER_SPESIALIS'] != ''){
		$str_konsul_dokter_spesialis = '';
		$jml_konsul_dokter_spesialis = '';
		$arr_str_konsul_dokter_spesialis = explode('||',$dat_pembayaran['KONSUL_DOKTER_SPESIALIS']);
		foreach($arr_str_konsul_dokter_spesialis as $row){
			$arr_row = explode('|',$row);
			$str_konsul_dokter_spesialis .= $arr_row[0] . '|';
			$jml_konsul_dokter_spesialis .= $arr_row[1] . '|';
		}
	}
	
	$karcis += $dat_pembayaran['HARGA_KARCIS'];
	$dokter_umum += $dat_pembayaran['HARGA_KONSUL_DOKTER_UMUM'];
	$dokter_spesialis += $dat_pembayaran['HARGA_KONSUL_DOKTER_SPESIALIS'];
	$tindakan += $dat_pembayaran['HARGA_TINDAKAN'];
	$operasi += $dat_pembayaran['HARGA_OPERASI'];
	$subtotal = $dat_pembayaran['HARGA_KARCIS'] + $dat_pembayaran['HARGA_KONSUL_DOKTER_UMUM'] + $dat_pembayaran['HARGA_KONSUL_DOKTER_SPESIALIS'] +
		$dat_pembayaran['HARGA_TINDAKAN'] + $dat_pembayaran['HARGA_OPERASI'];
	$total += $subtotal;
	if($subtotal > 0){	
?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
	<td><?php echo $dat_pembayaran['NAMA_JAMINAN']; ?></td>
	<td><?php echo formatNomr($dat_pembayaran['NOMR']); ?></td>
	<td><?php echo $dat_pembayaran['NAMA_PASIEN']; ?></td>
    <td><?php echo $dat_pembayaran['NAMA_UNIT']; ?></td>
	<td><?php echo $dat_pembayaran['TGL_MASUK']; ?></td>
	<td><?php echo $dat_pembayaran['TGL_KELUAR']; ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_KARCIS']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_KARCIS']); ?></td>
	<td><?php echo substr($str_konsul_dokter_umum,0,strlen($str_konsul_dokter_umum)-1); ?></td>
	<td align="right"><?php echo substr($jml_konsul_dokter_umum,0,strlen($jml_konsul_dokter_umum)-1); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_KONSUL_DOKTER_UMUM']); ?></td>
	<td><?php echo substr($str_konsul_dokter_spesialis,0,strlen($str_konsul_dokter_spesialis)-1); ?></td>
	<td align="right"><?php echo substr($jml_konsul_dokter_spesialis,0,strlen($jml_konsul_dokter_spesialis)-1); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_KONSUL_DOKTER_SPESIALIS']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_TINDAKAN']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_TINDAKAN']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_OPERASI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_OPERASI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_KARCIS'] + $dat_pembayaran['HARGA_KONSUL_DOKTER_UMUM'] + 
	$dat_pembayaran['HARGA_KONSUL_DOKTER_SPESIALIS'] + $dat_pembayaran['HARGA_TINDAKAN'] + $dat_pembayaran['HARGA_OPERASI']); ?></td>
	<td align="center"><?php $jam_kerja = $dat_pembayaran['TGL_BAYAR'];
					if($dat_pembayaran['SHIFT'] != '') $jam_kerja .= ' ['.$dat_pembayaran['SHIFT'] . ']'; 
					echo $jam_kerja; ?></td>
  </tr>
 <?php 
$no++; } 
} ?> 
 <tr>
	<td colspan="7" align="center">TOTAL</td>
    <td align="right" colspan="2"><?php echo currFormat($karcis); ?></td>
	<td align="right" colspan="3"><?php echo currFormat($dokter_umum); ?></td>
	<td align="right" colspan="3"><?php echo currFormat($dokter_spesialis); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($tindakan); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($operasi); ?></td>
	<td align="right"><?php echo currFormat($total); ?></td>
	<td align="center">&nbsp;</td>
  </tr>
</table>
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
	<input type="hidden" name="kasir" value="<?php echo $_GET['kasir']; ?>" />
	<input type="hidden" name="jns_bayar" value="<?php echo $jns_bayar; ?>" />
	<input type="hidden" name="arr_karcis" value="<?php echo str_replace('"','`',$arr_karcis); ?>" />
	<input type="hidden" name="arr_konsul_dokter_umum" value="<?php echo str_replace('"','`',$arr_konsul_dokter_umum); ?>" />
	<input type="hidden" name="arr_konsul_dokter_spesialis" value="<?php echo str_replace('"','`',$arr_konsul_dokter_spesialis); ?>" />
	<input type="hidden" name="arr_operasi" value="<?php echo str_replace('"','`',$arr_operasi); ?>" />
	<input type="hidden" name="arr_tindakan" value="<?php echo str_replace('"','`',$arr_tindakan); ?>" />
    <input type="hidden" name="xlsfile" value="keuangan/xls_report_penerimaan_poliklinik.php" />
    <input type="hidden" name="xlsname" value="rpt_rekap_penerimaan_rajal_igd.xls" />            
</form>
<script>
function open_def_report(filter,lvl){
	var win = window.open('index.php?link=cf4b9acb3a3f9ce0bac95e7606adda05&repid=<?php echo $report_id; ?>&repname=<?php echo $header_page; ?>&nmfilter=' + filter + '&lvl=' + lvl, '_blank');
  win.focus();
}
</script>