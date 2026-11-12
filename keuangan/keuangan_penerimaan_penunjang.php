<?php
$report_id = '4';

$arr_laboratorium = '';
$arr_radiologi = '';
$arr_fisioterapi = '';
$arr_okupasi_terapi = '';
$arr_prothese = '';
$arr_psikologi = '';
$arr_terapi_wicara = '';
$arr_perawatan_luka = '';

$qry = 'SELECT t_filter_report_tarif.KODE_TARIF_GROUP,t_filter_report_tarif.NAMA_TARIF_FILTER,
		t_filter_report_tarif.LEVEL_DT
		FROM t_filter_report_tarif
		WHERE t_filter_report_tarif.REPORT_ID = "' . $report_id . '"';
$get = mysql_query($qry) or die(mysql_error());
while($dat = mysql_fetch_array($get)){
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'laboratorium' and $dat['LEVEL_DT'] == '1') $arr_laboratorium .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'radiologi' and $dat['LEVEL_DT'] == '1') $arr_radiologi .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'fisioterapi' and $dat['LEVEL_DT'] == '1') $arr_fisioterapi .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'okupasi terapi' and $dat['LEVEL_DT'] == '1') $arr_okupasi_terapi .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'prothese' and $dat['LEVEL_DT'] == '1') $arr_prothese .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'psikologi' and $dat['LEVEL_DT'] == '1') $arr_psikologi .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'terapi wicara' and $dat['LEVEL_DT'] == '1') $arr_terapi_wicara .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'perawatan luka' and $dat['LEVEL_DT'] == '1') $arr_perawatan_luka .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
}

$arr_laboratorium .= '"00"';
$arr_radiologi .= '"00"';
$arr_fisioterapi .= '"00"';
$arr_okupasi_terapi .= '"00"';
$arr_prothese .= '"00"';
$arr_psikologi .= '"00"';
$arr_terapi_wicara .= '"00"';
$arr_perawatan_luka .= '"00"';

$tgl_1 = '';
if (isset($_SESSION['pembayaranreportpenunjang_tgl_1']))
    $tgl_1 = $_SESSION['pembayaranreportpenunjang_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaranreportpenunjang_tgl_2']))
    $tgl_2 = $_SESSION['pembayaranreportpenunjang_tgl_2'];
	
$jns_bayar = '1';
if (isset($_SESSION['pembayaranreportpenunjang_jns_bayar']))
    $jns_bayar = $_SESSION['pembayaranreportpenunjang_jns_bayar'];	
	
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaranreportpenunjang_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaranreportpenunjang_tgl_2'] = $_GET['tgl_2'];
}

if (isset($_GET['jns_bayar'])) {
    $jns_bayar = $_GET['jns_bayar'];
    $_SESSION['pembayaranreportpenunjang_jns_bayar'] = $_GET['jns_bayar'];
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
	<th colspan="2"><div onclick="open_def_report('laboratorium','1');">Laboratorium</div></th>
	<th colspan="2"><div onclick="open_def_report('radiologi','1');">Radiologi</div></th>
	<th colspan="2"><div onclick="open_def_report('fisioterapi','1');">Fisioterapi</div></th>
	<th colspan="2"><div onclick="open_def_report('okupasi terapi','1');">Okupasi Terapi</div></th>
	<th colspan="2"><div onclick="open_def_report('prothese','1');">Prothesa</div></th>
	<th colspan="2"><div onclick="open_def_report('psikologi','1');">Psikologi</div></th>
	<th colspan="2"><div onclick="open_def_report('terapi wicara','1');">Terapi Wicara</div></th>
	<th colspan="2"><div onclick="open_def_report('perawatan luka','1');">Perawatan Luka</div></th>
	<th rowspan="2">Jumlah</th>
	<th rowspan="2">Jam Kerja</th>
  </tr>
   <tr>
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
	 <th>Jumlah</th>
     <th>Biaya</th>
	 <th>Jumlah</th>
     <th>Biaya</th>
   </tr>
<?php $no = 1; 
$qry_pembayaran = 'SELECT t_bayar_main.RAWAT_ID,t_bayar_main.NAMA_JAMINAN,
				t_bayar_main.NOMR,t_bayar_main.NAMA_PASIEN,t_bayar_main.NAMA_UNIT,
				t_bayar_main.NAMA_RUANG,t_bayar_main.TGL_MASUK,t_bayar_main.TGL_KELUAR,
				SUM(t_bayar_main.JML_LABORATORIUM) AS JML_LABORATORIUM,
				SUM(t_bayar_main.HARGA_LABORATORIUM) AS HARGA_LABORATORIUM,
				SUM(t_bayar_main.JML_RADIOLOGI) AS JML_RADIOLOGI,
				SUM(t_bayar_main.HARGA_RADIOLOGI) AS HARGA_RADIOLOGI,
				SUM(t_bayar_main.JML_FISIOTERAPI) AS JML_FISIOTERAPI,
				SUM(t_bayar_main.HARGA_FISIOTERAPI) AS HARGA_FISIOTERAPI,
				SUM(t_bayar_main.JML_OKUPASI_TERAPI) AS JML_OKUPASI_TERAPI,
				SUM(t_bayar_main.HARGA_OKUPASI_TERAPI) AS HARGA_OKUPASI_TERAPI,
				SUM(t_bayar_main.JML_PROTESE) AS JML_PROTESE,
				SUM(t_bayar_main.HARGA_PROTESE) AS HARGA_PROTESE,
				SUM(t_bayar_main.JML_PSIKOLOGI) AS JML_PSIKOLOGI,
				SUM(t_bayar_main.HARGA_PSIKOLOGI) AS HARGA_PSIKOLOGI,
				SUM(t_bayar_main.JML_TERAPI_WICARA) AS JML_TERAPI_WICARA,
				SUM(t_bayar_main.HARGA_TERAPI_WICARA) AS HARGA_TERAPI_WICARA,
				SUM(t_bayar_main.JML_PERAWATAN_LUKA) AS JML_PERAWATAN_LUKA,
				SUM(t_bayar_main.HARGA_PERAWATAN_LUKA) AS HARGA_PERAWATAN_LUKA,
				t_bayar_main.TGL_BAYAR,
				t_bayar_main.SHIFT
				FROM (
					SELECT t_bayar_l1.RAWAT_ID,jmn.NAMA_JAMINAN,
					t_bayar_l1.NOMR,psn.NAMA_PASIEN,unt.NAMA_UNIT,
					rng.NAMA_RUANG,t_bayar_l1.TGL_MASUK,t_bayar_l1.TGL_KELUAR,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_laboratorium . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_LABORATORIUM,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_laboratorium . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_LABORATORIUM,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_radiologi . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_RADIOLOGI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_radiologi . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_RADIOLOGI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_fisioterapi . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_FISIOTERAPI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_fisioterapi . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_FISIOTERAPI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_okupasi_terapi . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_OKUPASI_TERAPI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_okupasi_terapi . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_OKUPASI_TERAPI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_prothese . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_PROTESE,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_prothese . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_PROTESE,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_psikologi . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_PSIKOLOGI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_psikologi . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_PSIKOLOGI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_terapi_wicara . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_TERAPI_WICARA,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_terapi_wicara . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_TERAPI_WICARA,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_perawatan_luka . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_PERAWATAN_LUKA,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_perawatan_luka . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_PERAWATAN_LUKA,
					t_bayar_l1.KASIR,
					t_bayar_l1.TGL_BAYAR,
					t_bayar_l1.SHIFT
					FROM (
							-- igd
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
							-- poliklinik
							UNION ALL
							SELECT "PNJ" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
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
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							' . (($jns_bayar != '1') ? 'AND DATE(pnjtf.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(pnjtf.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
								AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND pnjtf.ST_BAYAR = "Lunas"' : 'AND DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
								AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
								AND pnjtf.JENIS_BAYAR_ID = "1"
								AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")') . '
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ")
							-- rawat inap
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
							pnjtf.SHIFT_KASIR AS SHIFT
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
							AND (pnj.JNS_ORDER = "IRN" OR pnj.JNS_ORDER = "HRI" OR pnj.JNS_ORDER = "ORI")';
	//tdk klaim
	if($jns_bayar == '1'){
		$qry_pembayaran .= '-- igd
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
							-- poliklinik
							UNION ALL
							SELECT "PNJ" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
							irj.JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
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
							AND irj.UNIT_ID NOT IN (' . $arr_igd . ')
							AND pnjtf.JENIS_BAYAR_ID <> "1"
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(pnjtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")
							AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "HRJ" OR pnj.JNS_ORDER = "ORJ")
							AND klm.TDK_KLAIM = "1"
							-- rawat inap
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
							pnjtf.SHIFT_KASIR AS SHIFT
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
					t_bayar_l1.KASIR,t_bayar_l1.TGL_BAYAR,t_bayar_l1.SHIFT
					UNION ALL
					SELECT CONCAT("x",pnj.PENUNJANG_ID) AS RAWAT_ID,jmn.NAMA_JAMINAN,
					pnj.NO_PASIEN_PENUNJANG AS NOMR,pnj.NAMA_PASIEN,"APS" AS NAMA_UNIT,
					NULL AS NAMA_RUANG,DATE_FORMAT(pnjtf.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
					DATE_FORMAT(pnjtf.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_laboratorium . ') THEN pnjtf.KUANTITI ELSE 0 END) AS JML_LABORATORIUM,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_laboratorium . ') THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_LABORATORIUM,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_radiologi . ') THEN pnjtf.KUANTITI ELSE 0 END) AS JML_RADIOLOGI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_radiologi . ') THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_RADIOLOGI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_fisioterapi . ') THEN pnjtf.KUANTITI ELSE 0 END) AS JML_FISIOTERAPI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_fisioterapi . ') THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_FISIOTERAPI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_okupasi_terapi . ') THEN pnjtf.KUANTITI ELSE 0 END) AS JML_OKUPASI_TERAPI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_okupasi_terapi . ') THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_OKUPASI_TERAPI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_prothese . ') THEN pnjtf.KUANTITI ELSE 0 END) AS JML_PROTESE,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_prothese . ') THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_PROTESE,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_psikologi . ') THEN pnjtf.KUANTITI ELSE 0 END) AS JML_PSIKOLOGI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_psikologi . ') THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_PSIKOLOGI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_terapi_wicara . ') THEN pnjtf.KUANTITI ELSE 0 END) AS JML_TERAPI_WICARA,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_terapi_wicara . ') THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_TERAPI_WICARA,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_perawatan_luka . ') THEN pnjtf.KUANTITI ELSE 0 END) AS JML_PERAWATAN_LUKA,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_perawatan_luka . ') THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_PERAWATAN_LUKA,
					SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
					' . (($jns_bayar != '1') ? 'DATE_FORMAT(pnjtf.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
					pnjtf.SHIFT_KASIR AS SHIFT
					FROM db_simrs.t_ipenunjang pnj
					INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
					ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID)
					INNER JOIN db_simrs.m_tarif mtr
					ON (pnjtf.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg
					ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					INNER JOIN db_simrs.m_jaminan jmn
					ON (pnj.JENIS_BAYAR_ID = jmn.JAMINAN_ID)
					WHERE pnj.JNS_ORDER = "APS"
					' . (($jns_bayar != '1') ? 'AND DATE(pnjtf.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(pnjtf.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
						AND pnj.JENIS_BAYAR_ID = "' . $jns_bayar . '"
						AND pnjtf.ST_BAYAR = "Lunas"' : 'AND DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
						AND pnj.JENIS_BAYAR_ID = "1"
						AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")') . '
					AND pnjtf.NO_TARIF IS NOT NULL
					AND pnjtf.ST_BATAL IS NULL
					GROUP BY pnj.PENUNJANG_ID
				) t_bayar_main
				GROUP BY t_bayar_main.RAWAT_ID,t_bayar_main.NAMA_JAMINAN,
				t_bayar_main.NOMR,t_bayar_main.NAMA_PASIEN,t_bayar_main.NAMA_UNIT,
				t_bayar_main.NAMA_RUANG,t_bayar_main.TGL_MASUK,t_bayar_main.TGL_KELUAR,
				t_bayar_main.TGL_BAYAR,t_bayar_main.SHIFT
				ORDER BY t_bayar_main.RAWAT_ID';
$get_pembayaran = mysql_query($qry_pembayaran) or die(mysql_error());	
$laboratorium = 0;
$jml_laboratorium = 0;
$radiologi = 0;
$jml_radiologi = 0;
$fisioterapi = 0;
$jml_fisioterapi = 0;
$okupasi_terapi = 0;
$jml_okupasi_terapi = 0;
$prothesa = 0;
$jml_prothesa = 0;
$psikologi = 0;
$jml_psikologi = 0;
$terapi_wicara = 0;
$jml_terapi_wicara = 0;
$perawatan_luka = 0;
$jml_perawatan_luka = 0;
$total = 0;
$jml_total = 0;
while($dat_pembayaran = mysql_fetch_array($get_pembayaran)){ 
$nama_unit = '';
if($dat_pembayaran['NAMA_UNIT'] != '') $nama_unit = $dat_pembayaran['NAMA_UNIT'];
if($dat_pembayaran['NAMA_RUANG'] != '') $nama_unit = $dat_pembayaran['NAMA_RUANG'];

$laboratorium += $dat_pembayaran['HARGA_LABORATORIUM'];
$jml_laboratorium += $dat_pembayaran['JML_LABORATORIUM'];
$radiologi += $dat_pembayaran['HARGA_RADIOLOGI'];
$jml_radiologi += $dat_pembayaran['JML_RADIOLOGI'];
$fisioterapi += $dat_pembayaran['HARGA_FISIOTERAPI'];
$jml_fisioterapi += $dat_pembayaran['JML_FISIOTERAPI'];
$okupasi_terapi += $dat_pembayaran['HARGA_OKUPASI_TERAPI'];
$jml_okupasi_terapi += $dat_pembayaran['JML_OKUPASI_TERAPI'];
$prothesa += $dat_pembayaran['HARGA_PROTESE'];
$jml_prothesa += $dat_pembayaran['JML_PROTESE'];
$psikologi += $dat_pembayaran['HARGA_PSIKOLOGI'];
$jml_psikologi += $dat_pembayaran['JML_PSIKOLOGI'];
$terapi_wicara += $dat_pembayaran['HARGA_TERAPI_WICARA'];
$jml_terapi_wicara += $dat_pembayaran['JML_TERAPI_WICARA'];
$perawatan_luka += $dat_pembayaran['HARGA_PERAWATAN_LUKA'];
$jml_perawatan_luka += $dat_pembayaran['JML_PERAWATAN_LUKA'];
$subtotal = $dat_pembayaran['HARGA_LABORATORIUM'] + $dat_pembayaran['HARGA_RADIOLOGI'] + $dat_pembayaran['HARGA_FISIOTERAPI'] +
		$dat_pembayaran['HARGA_OKUPASI_TERAPI'] + $dat_pembayaran['HARGA_PROTESE'] + $dat_pembayaran['HARGA_PSIKOLOGI'] + 
		$dat_pembayaran['HARGA_TERAPI_WICARA'] + $dat_pembayaran['HARGA_PERAWATAN_LUKA'];
$total += $subtotal;
if($subtotal > 0){		
?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
	<td><?php echo $dat_pembayaran['NAMA_JAMINAN']; ?></td>
    <td><?php echo ((strlen($dat_pembayaran['NOMR']) == 6) ? formatNomr($dat_pembayaran['NOMR']) : $dat_pembayaran['NOMR']); ?></td>
	<td><?php echo $dat_pembayaran['NAMA_PASIEN']; ?></td>
    <td><?php echo $nama_unit; ?></td>
	<td><?php echo $dat_pembayaran['TGL_MASUK']; ?></td>
	<td><?php echo $dat_pembayaran['TGL_KELUAR']; ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_LABORATORIUM']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_LABORATORIUM']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_RADIOLOGI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_RADIOLOGI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_FISIOTERAPI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_FISIOTERAPI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_OKUPASI_TERAPI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_OKUPASI_TERAPI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_PROTESE']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_PROTESE']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_PSIKOLOGI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_PSIKOLOGI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_TERAPI_WICARA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_TERAPI_WICARA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_PERAWATAN_LUKA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_PERAWATAN_LUKA']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_LABORATORIUM'] + $dat_pembayaran['HARGA_RADIOLOGI'] +
			$dat_pembayaran['HARGA_FISIOTERAPI'] + $dat_pembayaran['HARGA_OKUPASI_TERAPI'] +
			$dat_pembayaran['HARGA_PROTESE'] + $dat_pembayaran['HARGA_PSIKOLOGI'] + $dat_pembayaran['HARGA_TERAPI_WICARA'] +
			$dat_pembayaran['HARGA_PERAWATAN_LUKA']); ?></td>
	<td align="center"><?php $jam_kerja = $dat_pembayaran['TGL_BAYAR'];
					if($dat_pembayaran['SHIFT'] != '') $jam_kerja .= ' ['.$dat_pembayaran['SHIFT'] . ']'; 
					echo $jam_kerja; ?></td>
  </tr>
 <?php $no++; } } ?> 
 <tr>
	<td colspan="7" align="center">TOTAL</td>
    <td align="right" colspan="2"><?php echo currFormat($laboratorium); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($radiologi); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($fisioterapi); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($okupasi_terapi); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($prothesa); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($psikologi); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($terapi_wicara); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($perawatan_luka); ?></td>
	<td align="right"><?php echo currFormat($total); ?></td>
	<td align="center">&nbsp;</td>
  </tr>
</table>
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
	<input type="hidden" name="arr_laboratorium" value="<?php echo str_replace('"','',$arr_laboratorium); ?>" />
	<input type="hidden" name="arr_radiologi" value="<?php echo str_replace('"','',$arr_radiologi); ?>" />
	<input type="hidden" name="arr_fisioterapi" value="<?php echo str_replace('"','',$arr_fisioterapi); ?>" />
	<input type="hidden" name="arr_okupasi_terapi" value="<?php echo str_replace('"','',$arr_okupasi_terapi); ?>" />
	<input type="hidden" name="arr_prothese" value="<?php echo str_replace('"','',$arr_prothese); ?>" />
	<input type="hidden" name="arr_psikologi" value="<?php echo str_replace('"','',$arr_psikologi); ?>" />
	<input type="hidden" name="arr_terapi_wicara" value="<?php echo str_replace('"','',$arr_terapi_wicara); ?>" />
	<input type="hidden" name="arr_perawatan_luka" value="<?php echo str_replace('"','',$arr_perawatan_luka); ?>" />
	<input type="hidden" name="jns_bayar" value="<?php echo $jns_bayar; ?>" />
    <input type="hidden" name="xlsfile" value="keuangan/xls_report_penerimaan_penunjang.php" />
    <input type="hidden" name="xlsname" value="rpt_rekap_penerimaan_penunjang.xls" />            
</form>
<script>
function open_def_report(filter,lvl){
	var win = window.open('index.php?link=cf4b9acb3a3f9ce0bac95e7606adda05&repid=<?php echo $report_id; ?>&repname=<?php echo $header_page; ?>&nmfilter=' + filter + '&lvl=' + lvl, '_blank');
  win.focus();
}
</script>