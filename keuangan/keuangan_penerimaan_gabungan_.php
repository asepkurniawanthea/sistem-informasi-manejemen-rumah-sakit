<?php
$report_id = '1';

$arr_akomodasi = '';
$arr_visit_dokter_umum = '';
$arr_visit_dokter_spesialis = '';
$arr_tindakan_ri = '';

$arr_karcis = '';

$arr_konsul_dokter_umum_igd = '';
$arr_konsul_dokter_spesialis_igd = '';
$arr_tindakan_igd = '';

$arr_konsul_dokter_umum_rj = '';
$arr_konsul_dokter_spesialis_rj = '';
$arr_tindakan_rj = '';

$arr_konsul_dokter_umum_opr = '';
$arr_konsul_dokter_spesialis_opr = '';

$arr_laboratorium = '';
$arr_radiologi = '';
$arr_fisioterapi = '';
$arr_okupasi_terapi = '';
$arr_prothese = '';
$arr_psikologi = '';

$arr_pmi = '';
$arr_askep = '';
$arr_sewalahan = '';
$arr_diklat = '';

$arr_peml_jenazah = '';
$arr_ambulance = '';
$arr_londry = '';

$arr_operasi = '';
$arr_skrining_gizi = '';
$arr_terapi_wicara = '';
$arr_perawatan_luka = '';

$qry = 'SELECT t_filter_report_tarif.KODE_TARIF_GROUP,t_filter_report_tarif.NAMA_TARIF_FILTER,
		t_filter_report_tarif.LEVEL_DT
		FROM t_filter_report_tarif
		WHERE t_filter_report_tarif.REPORT_ID = "' . $report_id . '"';
$get = mysql_query($qry) or die(mysql_error());
while($dat = mysql_fetch_array($get)){
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'akomodasi' and $dat['LEVEL_DT'] == '1') $arr_akomodasi .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'visit dokter umum' and $dat['LEVEL_DT'] == '2') $arr_visit_dokter_umum .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'visit dokter spesialis' and $dat['LEVEL_DT'] == '2') $arr_visit_dokter_spesialis .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'tindakan rawat inap' and $dat['LEVEL_DT'] == '1') $arr_tindakan_ri .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'karcis' and $dat['LEVEL_DT'] == '1') $arr_karcis .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'konsul dokter umum igd' and $dat['LEVEL_DT'] == '2') $arr_konsul_dokter_umum_igd .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'konsul dokter spesialis igd' and $dat['LEVEL_DT'] == '2') $arr_konsul_dokter_spesialis_igd .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'tindakan igd' and $dat['LEVEL_DT'] == '1') $arr_tindakan_igd .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'konsul dokter umum rawat jalan' and $dat['LEVEL_DT'] == '2') $arr_konsul_dokter_umum_rj .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'konsul dokter spesialis rawat jalan' and $dat['LEVEL_DT'] == '2') $arr_konsul_dokter_spesialis_rj .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'tindakan rawat jalan' and $dat['LEVEL_DT'] == '1') $arr_tindakan_rj .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'konsul dokter umum operasi' and $dat['LEVEL_DT'] == '2') $arr_konsul_dokter_umum_opr .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'konsul dokter spesialis operasi' and $dat['LEVEL_DT'] == '2') $arr_konsul_dokter_spesialis_opr .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'laboratorium' and $dat['LEVEL_DT'] == '1') $arr_laboratorium .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'radiologi' and $dat['LEVEL_DT'] == '1') $arr_radiologi .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'fisioterapi' and $dat['LEVEL_DT'] == '1') $arr_fisioterapi .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'okupasi terapi' and $dat['LEVEL_DT'] == '1') $arr_okupasi_terapi .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'prothese' and $dat['LEVEL_DT'] == '1') $arr_prothese .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'psikologi' and $dat['LEVEL_DT'] == '1') $arr_psikologi .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'pmi' and $dat['LEVEL_DT'] == '1') $arr_pmi .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'askep' and $dat['LEVEL_DT'] == '1') $arr_askep .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'sewa lahan' and $dat['LEVEL_DT'] == '1') $arr_sewalahan .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'diklat' and $dat['LEVEL_DT'] == '1') $arr_diklat .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'jenazah' and $dat['LEVEL_DT'] == '1') $arr_peml_jenazah .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'ambulance' and $dat['LEVEL_DT'] == '1') $arr_ambulance .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'londry' and $dat['LEVEL_DT'] == '1') $arr_londry .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'operasi' and $dat['LEVEL_DT'] == '1') $arr_operasi .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'skrining gizi' and $dat['LEVEL_DT'] == '1') $arr_skrining_gizi .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'terapi wicara' and $dat['LEVEL_DT'] == '1') $arr_terapi_wicara .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
	if(strtolower($dat['NAMA_TARIF_FILTER']) == 'perawatan luka' and $dat['LEVEL_DT'] == '1') $arr_perawatan_luka .= '"' . $dat['KODE_TARIF_GROUP'] . '",';
}
		
$arr_akomodasi .= '"00"';
$arr_visit_dokter_umum .= '"00"';
$arr_visit_dokter_spesialis .= '"00"';

$arr_tindakan_ri .= '"00"';

$arr_karcis .= '"00"';

$arr_konsul_dokter_umum_igd .= '"00"';
$arr_konsul_dokter_spesialis_igd .= '"00"';
$arr_tindakan_igd .= '"00"';

$arr_konsul_dokter_umum_rj .= '"00"';
$arr_konsul_dokter_spesialis_rj .= '"00"';
$arr_tindakan_rj .= '"00"';

$arr_konsul_dokter_umum_opr .= '"00"';
$arr_konsul_dokter_spesialis_opr .= '"00"';

$arr_laboratorium .= '"00"';
$arr_radiologi .= '"00"';
$arr_fisioterapi .= '"00"';
$arr_okupasi_terapi .= '"00"';
$arr_prothese .= '"00"';
$arr_psikologi .= '"00"';

$arr_pmi .= '"00"';
$arr_askep .= '"00"';
$arr_sewalahan .= '"00"';
$arr_diklat .= '"00"';

$arr_peml_jenazah .= '"00"';
$arr_ambulance .= '"00"';
$arr_londry .= '"00"';

$arr_operasi .= '"00"';
$arr_skrining_gizi .= '"00"';
$arr_terapi_wicara .= '"00"';
$arr_perawatan_luka .= '"00"';

$tgl_1 = '';
if (isset($_SESSION['pembayaranreportgabungan_tgl_1']))
    $tgl_1 = $_SESSION['pembayaranreportgabungan_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaranreportgabungan_tgl_2']))
    $tgl_2 = $_SESSION['pembayaranreportgabungan_tgl_2'];
	
$jns_bayar = '1';
if (isset($_SESSION['pembayaranreportgabungan_jns_bayar']))
    $jns_bayar = $_SESSION['pembayaranreportgabungan_jns_bayar'];	
	
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaranreportgabungan_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaranreportgabungan_tgl_2'] = $_GET['tgl_2'];
}

if (isset($_GET['jns_bayar'])) {
    $jns_bayar = $_GET['jns_bayar'];
    $_SESSION['pembayaranreportgabungan_jns_bayar'] = $_GET['jns_bayar'];
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}
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
	<th rowspan="2">Total</th>
	<th colspan="2">Return Farmasi</th>
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
				SUM(t_bayar_main.JML_KARCIS_IGD) AS JML_KARCIS_IGD,
				SUM(t_bayar_main.HARGA_KARCIS_IGD) AS HARGA_KARCIS_IGD,
				GROUP_CONCAT(t_bayar_main.KONSUL_DOKTER_UMUM_IGD,"|",CAST(t_bayar_main.JML_KONSUL_DOKTER_UMUM_IGD AS CHAR) SEPARATOR "||") AS KONSUL_DOKTER_UMUM_IGD,
				SUM(t_bayar_main.JML_KONSUL_DOKTER_UMUM_IGD) AS JML_KONSUL_DOKTER_UMUM_IGD,
				SUM(t_bayar_main.HARGA_KONSUL_DOKTER_UMUM_IGD) AS HARGA_KONSUL_DOKTER_UMUM_IGD,
				GROUP_CONCAT(t_bayar_main.KONSUL_DOKTER_SPESIALIS_IGD,"|",CAST(t_bayar_main.JML_KONSUL_DOKTER_SPESIALIS_IGD AS CHAR) SEPARATOR "||") AS KONSUL_DOKTER_SPESIALIS_IGD,
				SUM(t_bayar_main.JML_KONSUL_DOKTER_SPESIALIS_IGD) AS JML_KONSUL_DOKTER_SPESIALIS_IGD,
				SUM(t_bayar_main.HARGA_KONSUL_DOKTER_SPESIALIS_IGD) AS HARGA_KONSUL_DOKTER_SPESIALIS_IGD,
				SUM(t_bayar_main.JML_TINDAKAN_IGD) AS JML_TINDAKAN_IGD,
				SUM(t_bayar_main.HARGA_TINDAKAN_IGD) AS HARGA_TINDAKAN_IGD,
				SUM(t_bayar_main.JML_KARCIS_POLI) AS JML_KARCIS_POLI,
				SUM(t_bayar_main.HARGA_KARCIS_POLI) AS HARGA_KARCIS_POLI,
				GROUP_CONCAT(t_bayar_main.KONSUL_DOKTER_UMUM_POLI,"|",CAST(t_bayar_main.JML_KONSUL_DOKTER_UMUM_POLI AS CHAR) SEPARATOR "||") AS KONSUL_DOKTER_UMUM_POLI,
				SUM(t_bayar_main.JML_KONSUL_DOKTER_UMUM_POLI) AS JML_KONSUL_DOKTER_UMUM_POLI,
				SUM(t_bayar_main.HARGA_KONSUL_DOKTER_UMUM_POLI) AS HARGA_KONSUL_DOKTER_UMUM_POLI,
				GROUP_CONCAT(t_bayar_main.KONSUL_DOKTER_SPESIALIS_POLI,"|",CAST(t_bayar_main.JML_KONSUL_DOKTER_SPESIALIS_POLI AS CHAR) SEPARATOR "||") AS KONSUL_DOKTER_SPESIALIS_POLI,
				SUM(t_bayar_main.JML_KONSUL_DOKTER_SPESIALIS_POLI) AS JML_KONSUL_DOKTER_SPESIALIS_POLI,
				SUM(t_bayar_main.HARGA_KONSUL_DOKTER_SPESIALIS_POLI) AS HARGA_KONSUL_DOKTER_SPESIALIS_POLI,
				SUM(t_bayar_main.JML_TINDAKAN_POLI) AS JML_TINDAKAN_POLI,
				SUM(t_bayar_main.HARGA_TINDAKAN_POLI) AS HARGA_TINDAKAN_POLI,
				GROUP_CONCAT(t_bayar_main.KONSUL_DOKTER_UMUM_BEDAHOK,"|",CAST(t_bayar_main.JML_KONSUL_DOKTER_UMUM_BEDAHOK AS CHAR) SEPARATOR "||") AS KONSUL_DOKTER_UMUM_BEDAHOK,
				SUM(t_bayar_main.JML_KONSUL_DOKTER_UMUM_BEDAHOK) AS JML_KONSUL_DOKTER_UMUM_BEDAHOK,
				SUM(t_bayar_main.HARGA_KONSUL_DOKTER_UMUM_BEDAHOK) AS HARGA_KONSUL_DOKTER_UMUM_BEDAHOK,
				GROUP_CONCAT(t_bayar_main.KONSUL_DOKTER_SPESIALIS_BEDAHOK,"|",CAST(t_bayar_main.JML_KONSUL_DOKTER_SPESIALIS_BEDAHOK AS CHAR) SEPARATOR "||") AS KONSUL_DOKTER_SPESIALIS_BEDAHOK,
				SUM(t_bayar_main.JML_KONSUL_DOKTER_SPESIALIS_BEDAHOK) AS JML_KONSUL_DOKTER_SPESIALIS_BEDAHOK,
				SUM(t_bayar_main.HARGA_KONSUL_DOKTER_SPESIALIS_BEDAHOK) AS HARGA_KONSUL_DOKTER_SPESIALIS_BEDAHOK,
				SUM(t_bayar_main.JML_OPERASI) AS JML_OPERASI,
				SUM(t_bayar_main.HARGA_OPERASI) AS HARGA_OPERASI,
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
				SUM(t_bayar_main.JML_FARMASI) AS JML_FARMASI,
				SUM(t_bayar_main.HARGA_FARMASI) AS HARGA_FARMASI,
				SUM(t_bayar_main.JML_PMI) AS JML_PMI,
				SUM(t_bayar_main.HARGA_PMI) AS HARGA_PMI,
				SUM(t_bayar_main.JML_SKRINING_GIZI) AS JML_SKRINING_GIZI,
				SUM(t_bayar_main.HARGA_SKRINING_GIZI) AS HARGA_SKRINING_GIZI,
				SUM(t_bayar_main.JML_ASKEP) AS JML_ASKEP,
				SUM(t_bayar_main.HARGA_ASKEP) AS HARGA_ASKEP,
				SUM(t_bayar_main.JML_SEWALAHAN) AS JML_SEWALAHAN,
				SUM(t_bayar_main.HARGA_SEWALAHAN) AS HARGA_SEWALAHAN,
				SUM(t_bayar_main.JML_DIKLAT) AS JML_DIKLAT,
				SUM(t_bayar_main.HARGA_DIKLAT) AS HARGA_DIKLAT,
				SUM(t_bayar_main.JML_PEMULASARAAN_JENAZAH) AS JML_PEMULASARAAN_JENAZAH,
				SUM(t_bayar_main.HARGA_PEMULASARAAN_JENAZAH) AS HARGA_PEMULASARAAN_JENAZAH,
				SUM(t_bayar_main.JML_AMBULANCE) AS JML_AMBULANCE,
				SUM(t_bayar_main.HARGA_AMBULANCE) AS HARGA_AMBULANCE,
				SUM(t_bayar_main.JML_LONDRY) AS JML_LONDRY,
				SUM(t_bayar_main.HARGA_LONDRY) AS HARGA_LONDRY,
				SUM(t_bayar_main.JML_RETURN_FARMASI) AS JML_RETURN_FARMASI,
				SUM(t_bayar_main.HARGA_RETURN_FARMASI) AS HARGA_RETURN_FARMASI
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
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_karcis . ') AND t_bayar_l1.UNIT_ID = 9 THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_KARCIS_IGD,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_karcis . ') AND t_bayar_l1.UNIT_ID = 9 THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_KARCIS_IGD,
					CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_umum_igd . ') THEN
						CASE WHEN pgw2.NAMA_PEGAWAI IS NOT NULL THEN pgw2.NAMA_PEGAWAI 
						ELSE pgw.NAMA_PEGAWAI END							
					END AS KONSUL_DOKTER_UMUM_IGD,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_umum_igd . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_KONSUL_DOKTER_UMUM_IGD,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_umum_igd . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_KONSUL_DOKTER_UMUM_IGD,
					CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_spesialis_igd . ') THEN
						CASE WHEN pgw2.NAMA_PEGAWAI IS NOT NULL THEN pgw2.NAMA_PEGAWAI 
						ELSE pgw.NAMA_PEGAWAI END							
					END AS KONSUL_DOKTER_SPESIALIS_IGD,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_spesialis_igd . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_KONSUL_DOKTER_SPESIALIS_IGD,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_spesialis_igd . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_KONSUL_DOKTER_SPESIALIS_IGD,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_tindakan_igd . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_TINDAKAN_IGD,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_tindakan_igd . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_TINDAKAN_IGD,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_karcis . ') AND t_bayar_l1.UNIT_ID <> 9 THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_KARCIS_POLI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_karcis . ') AND t_bayar_l1.UNIT_ID <> 9 THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_KARCIS_POLI,
					CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_umum_rj . ') THEN
						CASE WHEN pgw2.NAMA_PEGAWAI IS NOT NULL THEN pgw2.NAMA_PEGAWAI 
						ELSE pgw.NAMA_PEGAWAI END							
					END AS KONSUL_DOKTER_UMUM_POLI,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_umum_rj . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_KONSUL_DOKTER_UMUM_POLI,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_umum_rj . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_KONSUL_DOKTER_UMUM_POLI,
					CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_spesialis_rj . ') THEN
						CASE WHEN pgw2.NAMA_PEGAWAI IS NOT NULL THEN pgw2.NAMA_PEGAWAI 
						ELSE pgw.NAMA_PEGAWAI END							
					END AS KONSUL_DOKTER_SPESIALIS_POLI,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_spesialis_rj . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_KONSUL_DOKTER_SPESIALIS_POLI,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_spesialis_rj . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_KONSUL_DOKTER_SPESIALIS_POLI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_tindakan_rj . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_TINDAKAN_POLI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_tindakan_rj . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_TINDAKAN_POLI,
					CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_umum_opr . ') THEN
						CASE WHEN pgw2.NAMA_PEGAWAI IS NOT NULL THEN pgw2.NAMA_PEGAWAI 
						ELSE pgw.NAMA_PEGAWAI END							
					END AS KONSUL_DOKTER_UMUM_BEDAHOK,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_umum_opr . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_KONSUL_DOKTER_UMUM_BEDAHOK,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_umum_opr . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_KONSUL_DOKTER_UMUM_BEDAHOK,
					CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_spesialis_opr . ') THEN
						CASE WHEN pgw2.NAMA_PEGAWAI IS NOT NULL THEN pgw2.NAMA_PEGAWAI 
						ELSE pgw.NAMA_PEGAWAI END							
					END AS KONSUL_DOKTER_SPESIALIS_BEDAHOK,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_spesialis_opr . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_KONSUL_DOKTER_SPESIALIS_BEDAHOK,
					SUM(CASE WHEN mtr.KODE_TARIF IN (' . $arr_konsul_dokter_spesialis_opr . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_KONSUL_DOKTER_SPESIALIS_BEDAHOK,
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
					0 AS JML_FARMASI,
					0 AS HARGA_FARMASI,
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
					0 AS JML_SEWALAHAN,
					0 AS HARGA_SEWALAHAN,
					0 AS JML_DIKLAT,
					0 AS HARGA_DIKLAT,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_peml_jenazah . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_PEMULASARAAN_JENAZAH,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_peml_jenazah . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_PEMULASARAAN_JENAZAH,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_ambulance . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_AMBULANCE,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_ambulance . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_AMBULANCE,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_londry . ') THEN t_bayar_l1.KUANTITI ELSE 0 END) AS JML_LONDRY,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_londry . ') THEN t_bayar_l1.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_LONDRY,
					0 AS JML_RETURN_FARMASI,
					0 AS HARGA_RETURN_FARMASI,
					t_bayar_l1.KASIR,
					t_bayar_l1.TGL_BAYAR,
					t_bayar_l1.SHIFT
					FROM (
							-- igd
							SELECT "IGD" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
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
							LEFT JOIN db_simrs.t_irna irn
							ON (igd.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID = 9
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND trf.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(trf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(trf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND trf.JENIS_BAYAR_ID = "1"
								AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
							AND irn.IRNA_ID IS NULL
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
							LEFT JOIN db_simrs.t_irna irn
							ON (igd.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID = 9
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND pnjtf.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND pnjtf.JENIS_BAYAR_ID = "1"
								AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")') . ' 
							AND irn.IRNA_ID IS NULL
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
							LEFT JOIN db_simrs.t_irna irn
							ON (igd.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID = 9
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND tfamb.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND tfamb.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(tfamb.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(tfamb.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND tfamb.JENIS_BAYAR_ID = "1"
								AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")') . ' 
							AND irn.IRNA_ID IS NULL
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
							LEFT JOIN db_simrs.t_irna irn
							ON (igd.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID = 9
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND hmdtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND hmdtf.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(hmdtf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(hmdtf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND hmdtf.JENIS_BAYAR_ID = "1"
								AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")') . '
							AND irn.IRNA_ID IS NULL	
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
							LEFT JOIN db_simrs.t_irna irn
							ON (igd.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID = 9
							AND opr.NO_PENDAFTARAN IS NOT NULL
							AND opr.ST_MASUK = "1"
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND optf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND optf.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(optf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(optf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND optf.JENIS_BAYAR_ID = "1"
								AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")') . '
							AND irn.IRNA_ID IS NULL
							-- end igd
							
							-- rawat jalan
							UNION ALL
							SELECT "IRJ" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
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
							LEFT JOIN db_simrs.t_irna irn
							ON (irj.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID <> 9
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND trf.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(trf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(trf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND trf.JENIS_BAYAR_ID = "1"
								AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
							AND irn.IRNA_ID IS NULL
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
							LEFT JOIN db_simrs.t_irna irn
							ON (irj.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID <> 9
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(pnjtf.TANGGAL_DAFTAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(pnjtf.TANGGAL_DAFTAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND pnjtf.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND pnjtf.JENIS_BAYAR_ID = "1"
								AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")') . '
							AND irn.IRNA_ID IS NULL
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
							LEFT JOIN db_simrs.t_irna irn
							ON (irj.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID <> 9
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND tfamb.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND tfamb.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(tfamb.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(tfamb.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND tfamb.JENIS_BAYAR_ID = "1"
								AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")') . '
							AND irn.IRNA_ID IS NULL
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
							LEFT JOIN db_simrs.t_irna irn
							ON (irj.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID <> 9
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(hmd.TANGGAL_ORDER,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(hmd.TANGGAL_ORDER,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND hmdtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND hmdtf.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(hmdtf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(hmdtf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND hmdtf.JENIS_BAYAR_ID = "1"
								AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")') . '
							AND irn.IRNA_ID IS NULL	
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
							LEFT JOIN db_simrs.t_irna irn
							ON (irj.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID <> 9
							AND opr.NO_PENDAFTARAN IS NOT NULL
							AND opr.ST_MASUK = "1"
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(opr.TANGGAL_OPERASI,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(opr.TANGGAL_OPERASI,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND optf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND optf.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(optf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(optf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND optf.JENIS_BAYAR_ID = "1"
								AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")') . '
							AND irn.IRNA_ID IS NULL
							-- end rawat jalan
							
							-- rawat inap
							UNION ALL
							SELECT "IRI" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							trf.JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							irj.PEGAWAI_ID,trf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(trf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(trf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							trf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irja irj 
							ON (irn.IRNA_ID = irj.IRJA_ID)
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (irj.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND trf.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(trf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(trf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND trf.JENIS_BAYAR_ID = "1"
								AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
							UNION ALL
							SELECT "IRI" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							trf.JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,trf.KELAS_RAWAT,
							irn.PEGAWAI_ID,trf.PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(trf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(trf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							trf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irja irj 
							ON (irn.IRNA_ID = irj.IRJA_ID)
							INNER JOIN db_simrs.t_irna_tarif trf
							ON (irn.IRNA_ID = trf.IRNA_ID
							AND trf.NO_TARIF IS NOT NULL)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND trf.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(trf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(trf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND trf.JENIS_BAYAR_ID = "1"
								AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
							UNION ALL
							SELECT "PNJ" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							pnjtf.JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							pnjtf.PEGAWAI_DIAGNOSA_ID AS PEGAWAI_ID,
							pnjtf.PEGAWAI_PERIKSA_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(pnjtf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							pnjtf.SHIFT_KASIR AS SHIFT
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irja irj 
							ON (irn.IRNA_ID = irj.IRJA_ID)
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irn.IRNA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND pnjtf.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND pnjtf.JENIS_BAYAR_ID = "1"
								AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")') . '
							UNION ALL
							SELECT "AMB" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							tfamb.JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							NULL AS PEGAWAI_ID,tfamb.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(tfamb.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(tfamb.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							tfamb.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irja irj 
							ON (irn.IRNA_ID = irj.IRJA_ID)
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irn.IRNA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND tfamb.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND tfamb.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(tfamb.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(tfamb.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND tfamb.JENIS_BAYAR_ID = "1"
								AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")') . '
							UNION ALL
							SELECT "HMD" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							hmdtf.JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							hmd.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,hmdtf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(hmdtf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(hmdtf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							hmdtf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irja irj 
							ON (irn.IRNA_ID = irj.IRJA_ID)
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irn.IRNA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND hmdtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND hmdtf.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(hmdtf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(hmdtf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND hmdtf.JENIS_BAYAR_ID = "1"
								AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")') . '
							UNION ALL
							SELECT "OPR" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							optf.JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,optf.KELAS_RAWAT,
							opr.PEGAWAI_PELAKSANA_ID AS PEGAWAI_ID,
							optf.PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(optf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							optf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irja irj 
							ON (irn.IRNA_ID = irj.IRJA_ID)
							INNER JOIN db_simrs.t_operasi opr
							ON (irn.IRNA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL
							AND opr.ST_MASUK = "2")
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND optf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND optf.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(optf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(optf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND optf.JENIS_BAYAR_ID = "1"
								AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")') . '
							UNION ALL
							SELECT "OPR" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							optf.JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							opr.PEGAWAI_PELAKSANA_ID AS PEGAWAI_ID,
							optf.PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(optf.USER_KASIR,"|",-1) AS KASIR,
							' . (($jns_bayar != '1') ? 'DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
							'DATE_FORMAT(optf.TGL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
							optf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irja irj 
							ON (irn.IRNA_ID = irj.IRJA_ID)
							INNER JOIN db_simrs.t_operasi opr
							ON (irn.IRNA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL
							AND opr.ST_MASUK = "1")
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND optf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
								AND optf.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(optf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
								AND STR_TO_DATE(DATE_FORMAT(optf.TGL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
								AND optf.JENIS_BAYAR_ID = "1"
								AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")') . '
							-- end rawat inap
							';
	//tdk klaim						
	if($jns_bayar == '1'){
		$qry_pembayaran .= '-- igd
							UNION ALL
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
							LEFT JOIN db_simrs.t_irna irn
							ON (igd.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID = 9
							AND trf.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")
							AND irn.IRNA_ID IS NULL
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
							LEFT JOIN db_simrs.t_irna irn
							ON (igd.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID = 9
							AND pnjtf.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")
							AND irn.IRNA_ID IS NULL
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
							LEFT JOIN db_simrs.t_irna irn
							ON (igd.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID = 9
							AND tfamb.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")
							AND irn.IRNA_ID IS NULL
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
							LEFT JOIN db_simrs.t_irna irn
							ON (igd.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID = 9
							AND hmdtf.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")
							AND irn.IRNA_ID IS NULL	
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
							LEFT JOIN db_simrs.t_irna irn
							ON (igd.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE igd.NO_PENDAFTARAN IS NOT NULL 
							AND igd.ST_BATAL IS NULL
							AND igd.UNIT_ID = 9
							AND opr.NO_PENDAFTARAN IS NOT NULL
							AND opr.ST_MASUK = "1"
							AND optf.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")
							AND irn.IRNA_ID IS NULL
							AND klm.TDK_KLAIM = "1"
							-- end igd
							
							-- rawat jalan
							UNION ALL
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
							LEFT JOIN db_simrs.t_irna irn
							ON (irj.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID <> 9
							AND trf.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")
							AND irn.IRNA_ID IS NULL
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
							LEFT JOIN db_simrs.t_irna irn
							ON (irj.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID <> 9
							AND pnjtf.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")
							AND irn.IRNA_ID IS NULL
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
							LEFT JOIN db_simrs.t_irna irn
							ON (irj.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID <> 9
							AND tfamb.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")
							AND irn.IRNA_ID IS NULL
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
							LEFT JOIN db_simrs.t_irna irn
							ON (irj.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID <> 9
							AND hmdtf.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")
							AND irn.IRNA_ID IS NULL	
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
							LEFT JOIN db_simrs.t_irna irn
							ON (irj.IRJA_ID = irn.IRNA_ID
							AND irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL)
							WHERE irj.NO_PENDAFTARAN IS NOT NULL 
							AND irj.ST_BATAL IS NULL
							AND irj.UNIT_ID <> 9
							AND opr.NO_PENDAFTARAN IS NOT NULL
							AND opr.ST_MASUK = "1"
							AND optf.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")
							AND irn.IRNA_ID IS NULL
							AND klm.TDK_KLAIM = "1"
							-- end rawat jalan
							
							-- rawat inap
							UNION ALL
							SELECT "IRI" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							trf.JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,"" AS KELAS_RAWAT,
							irj.PEGAWAI_ID,trf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(trf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							trf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irja irj 
							ON (irn.IRNA_ID = irj.IRJA_ID)
							INNER JOIN db_simrs.t_irja_tarif trf
							ON (irj.IRJA_ID = trf.IRJA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (trf.TARIF_ID = klm.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND trf.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")
							AND klm.TDK_KLAIM = "1"
							UNION ALL
							SELECT "IRI" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							trf.JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							trf.TARIF_ID,trf.KUANTITI,trf.KELAS_RAWAT,
							irn.PEGAWAI_ID,trf.PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(trf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							trf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irja irj 
							ON (irn.IRNA_ID = irj.IRJA_ID)
							INNER JOIN db_simrs.t_irna_tarif trf
							ON (irn.IRNA_ID = trf.IRNA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (trf.TARIF_ID = klm.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND trf.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(trf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")
							AND klm.TDK_KLAIM = "1"
							UNION ALL
							SELECT "PNJ" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							pnjtf.JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							pnjtf.TARIF_ID,pnjtf.KUANTITI,"" AS KELAS_RAWAT,
							pnjtf.PEGAWAI_DIAGNOSA_ID AS PEGAWAI_ID,
							pnjtf.PEGAWAI_PERIKSA_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(pnjtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							pnjtf.SHIFT_KASIR AS SHIFT
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irja irj 
							ON (irn.IRNA_ID = irj.IRJA_ID)
							INNER JOIN db_simrs.t_ipenunjang pnj
							ON (irn.IRNA_ID = pnj.RAWAT_ID)
							INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
							ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
							AND pnjtf.NO_TARIF IS NOT NULL
							AND pnjtf.ST_BATAL IS NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (pnjtf.TARIF_ID = klm.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND pnjtf.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(pnjtf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")
							AND klm.TDK_KLAIM = "1"
							UNION ALL
							SELECT "AMB" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							tfamb.JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							tfamb.TARIF_ID,tfamb.KUANTITI,"" AS KELAS_RAWAT,
							NULL AS PEGAWAI_ID,tfamb.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(tfamb.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							tfamb.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irja irj 
							ON (irn.IRNA_ID = irj.IRJA_ID)
							INNER JOIN db_simrs.t_ambulance_tarif tfamb
							ON (irn.IRNA_ID = tfamb.RAWAT_ID
							AND tfamb.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (tfamb.TARIF_ID = klm.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND tfamb.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(tfamb.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")
							AND klm.TDK_KLAIM = "1"
							UNION ALL
							SELECT "HMD" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							hmdtf.JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							hmdtf.TARIF_ID,hmdtf.KUANTITI,"" AS KELAS_RAWAT,
							hmd.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,hmdtf.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(hmdtf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							hmdtf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irja irj 
							ON (irn.IRNA_ID = irj.IRJA_ID)
							INNER JOIN db_simrs.t_hemodialisa hmd
							ON (irn.IRNA_ID = hmd.RAWAT_ID)
							INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
							ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
							AND hmdtf.NO_TARIF IS NOT NULL)
							INNER JOIN db_simrs.m_tarif klm
							ON (hmdtf.TARIF_ID = klm.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND hmdtf.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(hmdtf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")
							AND klm.TDK_KLAIM = "1"
							UNION ALL
							SELECT "OPR" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							optf.JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,optf.KELAS_RAWAT,
							opr.PEGAWAI_PELAKSANA_ID AS PEGAWAI_ID,
							optf.PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(optf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							optf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irja irj 
							ON (irn.IRNA_ID = irj.IRJA_ID)
							INNER JOIN db_simrs.t_operasi opr
							ON (irn.IRNA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL
							AND opr.ST_MASUK = "2")
							INNER JOIN db_simrs.m_tarif klm
							ON (optf.TARIF_ID = klm.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND optf.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")
							AND klm.TDK_KLAIM = "1"
							UNION ALL
							SELECT "OPR" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
							optf.JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
							DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
							DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
							optf.TARIF_ID,optf.KUANTITI,"3" AS KELAS_RAWAT,
							opr.PEGAWAI_PELAKSANA_ID AS PEGAWAI_ID,
							optf.PEGAWAI_PELAKSANA_ID,
							SUBSTRING_INDEX(optf.TDK_KLAIM_USER,"|",-1) AS KASIR,
							DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,
							optf.SHIFT_ID AS SHIFT
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irja irj 
							ON (irn.IRNA_ID = irj.IRJA_ID)
							INNER JOIN db_simrs.t_operasi opr
							ON (irn.IRNA_ID = opr.RAWAT_ID)
							INNER JOIN db_simrs.t_operasi_tarif optf
							ON (opr.OPERASI_ID = optf.OPERASI_ID
							AND optf.NO_TARIF IS NOT NULL
							AND opr.ST_MASUK = "1")
							INNER JOIN db_simrs.m_tarif klm
							ON (optf.TARIF_ID = klm.TARIF_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND optf.JENIS_BAYAR_ID <> "1"
							AND STR_TO_DATE(DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(optf.TDK_KLAIM_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")
							AND klm.TDK_KLAIM = "1"	
							-- end rawat inap
							';
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
					VISIT_DOKTER_UMUM,VISIT_DOKTER_SPESIALIS,
					KONSUL_DOKTER_UMUM_IGD,KONSUL_DOKTER_SPESIALIS_IGD,
					KONSUL_DOKTER_UMUM_POLI,KONSUL_DOKTER_SPESIALIS_POLI,
					KONSUL_DOKTER_UMUM_BEDAHOK,KONSUL_DOKTER_SPESIALIS_BEDAHOK
					UNION ALL
					SELECT t_bayar_l2.RAWAT_ID,jmn.NAMA_JAMINAN,
					t_bayar_l2.NOMR,psn.NAMA_PASIEN,unt.NAMA_UNIT,
					rng.NAMA_RUANG,t_bayar_l2.TGL_MASUK,t_bayar_l2.TGL_KELUAR,
					0 AS JML_AKOMODASI,
					0 AS HARGA_AKOMODASI,
					NULL AS VISIT_DOKTER_UMUM,
					0 AS JML_VISIT_DOKTER_UMUM,
					0 AS HARGA_VISIT_DOKTER_UMUM,
					NULL AS VISIT_DOKTER_SPESIALIS, 
					0 AS JML_VISIT_DOKTER_SPESIALIS,
					0 AS HARGA_VISIT_DOKTER_SPESIALIS,
					0 AS JML_TINDAKAN_RI,
					0 AS HARGA_TINDAKAN_RI,
					0 AS JML_KARCIS_IGD,
					0 AS HARGA_KARCIS_IGD,
					NULL AS KONSUL_DOKTER_UMUM_IGD,
					0 AS JML_KONSUL_DOKTER_UMUM_IGD,
					0 AS HARGA_KONSUL_DOKTER_UMUM_IGD,
					NULL AS KONSUL_DOKTER_SPESIALIS_IGD,
					0 AS JML_KONSUL_DOKTER_SPESIALIS_IGD,
					0 AS HARGA_KONSUL_DOKTER_SPESIALIS_IGD,
					0 AS JML_TINDAKAN_IGD,
					0 AS HARGA_TINDAKAN_IGD,
					0 AS JML_KARCIS_POLI,
					0 AS HARGA_KARCIS_POLI,
					NULL AS KONSUL_DOKTER_UMUM_POLI,
					0 AS JML_KONSUL_DOKTER_UMUM_POLI,
					0 AS HARGA_KONSUL_DOKTER_UMUM_POLI,
					NULL AS KONSUL_DOKTER_SPESIALIS_POLI,
					0 AS JML_KONSUL_DOKTER_SPESIALIS_POLI,
					0 AS HARGA_KONSUL_DOKTER_SPESIALIS_POLI,
					0 AS JML_TINDAKAN_POLI,
					0 AS HARGA_TINDAKAN_POLI,
					NULL AS KONSUL_DOKTER_UMUM_BEDAHOK,
					0 AS JML_KONSUL_DOKTER_UMUM_BEDAHOK,
					0 AS HARGA_KONSUL_DOKTER_UMUM_BEDAHOK,
					NULL AS KONSUL_DOKTER_SPESIALIS_BEDAHOK,
					0 AS JML_KONSUL_DOKTER_SPESIALIS_BEDAHOK,
					0 AS HARGA_KONSUL_DOKTER_SPESIALIS_BEDAHOK,
					0 AS JML_OPERASI,
					0 AS HARGA_OPERASI,
					0 AS JML_LABORATORIUM,
					0 AS HARGA_LABORATORIUM,
					0 AS JML_RADIOLOGI,
					0 AS HARGA_RADIOLOGI,
					0 AS JML_FISIOTERAPI,
					0 AS HARGA_FISIOTERAPI,
					0 AS JML_OKUPASI_TERAPI,
					0 AS HARGA_OKUPASI_TERAPI,
					0 AS JML_PROTESE,
					0 AS HARGA_PROTESE,
					0 AS JML_PSIKOLOGI,
					0 AS HARGA_PSIKOLOGI,
					0 AS JML_TERAPI_WICARA,
					0 AS HARGA_TERAPI_WICARA,
					0 AS JML_PERAWATAN_LUKA,
					0 AS HARGA_PERAWATAN_LUKA,
					SUM(t_bayar_l2.JML_FARMASI) AS JML_FARMASI,
					SUM(t_bayar_l2.HARGA_FARMASI) AS HARGA_FARMASI,
					0 AS JML_PMI,
					0 AS HARGA_PMI,
					0 AS JML_SKRINING_GIZI,
					0 AS HARGA_SKRINING_GIZI,
					0 AS JML_ASKEP,
					0 AS HARGA_ASKEP,
					0 AS JML_SEWALAHAN,
					0 AS HARGA_SEWALAHAN,
					0 AS JML_DIKLAT,
					0 AS HARGA_DIKLAT,
					0 AS JML_PEMULASARAAN_JENAZAH,
					0 AS HARGA_PEMULASARAAN_JENAZAH,
					0 AS JML_AMBULANCE,
					0 AS HARGA_AMBULANCE,
					0 AS JML_LONDRY,
					0 AS HARGA_LONDRY,
					SUM(t_bayar_l2.JML_RETURN_FARMASI) AS JML_RETURN_FARMASI,
					SUM(t_bayar_l2.HARGA_RETURN_FARMASI) AS HARGA_RETURN_FARMASI,
					t_bayar_l2.KASIR,
					t_bayar_l2.TGL_BAYAR,
					t_bayar_l2.SHIFT
					FROM (
						-- farmasi igd
						SELECT "FMS" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
						DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS JML_FARMASI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA_FARMASI,
						0 AS JML_RETURN_FARMASI,
						0 AS HARGA_RETURN_FARMASI,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1) AS KASIR,
						' . (($jns_bayar != '1') ? 'DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
						'DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
						fms.SHIFT_PEMBAYARAN AS SHIFT
						FROM db_simrs.t_irja igd
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
						ON (igd.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGELUARAN IS NOT NULL
						AND fms.JENIS_PENGELUARAN = "1"
						AND fms.ST_BATAL IS NULL)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						LEFT JOIN db_simrs.t_irna irn
						ON (igd.IRJA_ID = irn.IRNA_ID
						AND irn.NO_PENDAFTARAN IS NOT NULL 
						AND irn.ST_BATAL IS NULL)
						WHERE igd.NO_PENDAFTARAN IS NOT NULL 
						AND igd.ST_BATAL IS NULL
						AND igd.UNIT_ID = 9
						' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "1"
							AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
						AND irn.IRNA_ID IS NULL
						GROUP BY igd.IRJA_ID,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1),
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),
						fms.SHIFT_PEMBAYARAN
						
						UNION ALL
						SELECT "FMS" AS PASIEN,igd.IRJA_ID AS RAWAT_ID,igd.NOMR,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,igd.UNIT_ID,NULL AS RUANG_ID,
						DATE_FORMAT(igd.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						0 AS JML_FARMASI,
						0 AS HARGA_FARMASI,
						COUNT(DISTINCT fms.NO_PENGEMBALIAN) AS JML_RETURN_FARMASI,
						SUM(fmsd.HARGA_JUAL * fmsd.JUMLAH_KEMBALI) AS HARGA_RETURN_FARMASI,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1) AS KASIR,
						' . (($jns_bayar != '1') ? 'DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
						'DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
						fms.SHIFT_PEMBAYARAN AS SHIFT
						FROM db_simrs.t_irja igd
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep fms
						ON (igd.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGEMBALIAN IS NOT NULL
						AND fms.JENIS_PENGEMBALIAN = "1")
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep_detail fmsd
						ON (fms.FARMASI_PENGEMBALIAN_APOTIK_ID = fmsd.FARMASI_PENGEMBALIAN_ID)
						LEFT JOIN db_simrs.t_irna irn
						ON (igd.IRJA_ID = irn.IRNA_ID
						AND irn.NO_PENDAFTARAN IS NOT NULL 
						AND irn.ST_BATAL IS NULL)
						WHERE igd.NO_PENDAFTARAN IS NOT NULL 
						AND igd.ST_BATAL IS NULL
						AND igd.UNIT_ID = 9
						' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(igd.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "1"
							AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
						AND irn.IRNA_ID IS NULL
						GROUP BY igd.IRJA_ID,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1),
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),
						fms.SHIFT_PEMBAYARAN
						-- end farmasi igd
						
						-- farmasi rawat jalan
						UNION ALL
						SELECT "FMS" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
						DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS JML_FARMASI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA_FARMASI,
						0 AS JML_RETURN_FARMASI,
						0 AS HARGA_RETURN_FARMASI,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1) AS KASIR,
						' . (($jns_bayar != '1') ? 'DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
						'DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
						fms.SHIFT_PEMBAYARAN AS SHIFT
						FROM db_simrs.t_irja irj
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
						ON (irj.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGELUARAN IS NOT NULL
						AND fms.JENIS_PENGELUARAN = "1"
						AND fms.ST_BATAL IS NULL)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						LEFT JOIN db_simrs.t_irna irn
						ON (irj.IRJA_ID = irn.IRNA_ID
						AND irn.NO_PENDAFTARAN IS NOT NULL 
						AND irn.ST_BATAL IS NULL)
						WHERE irj.NO_PENDAFTARAN IS NOT NULL 
						AND irj.ST_BATAL IS NULL
						AND irj.UNIT_ID <> 9
						' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "1"
							AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
						AND irn.IRNA_ID IS NULL
						GROUP BY irj.IRJA_ID,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1),
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),
						fms.SHIFT_PEMBAYARAN
						
						UNION ALL
						SELECT "FMS" AS PASIEN,irj.IRJA_ID AS RAWAT_ID,irj.NOMR,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,irj.UNIT_ID,NULL AS RUANG_ID,
						DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
						0 AS JML_FARMASI,
						0 AS HARGA_FARMASI,
						COUNT(DISTINCT fms.NO_PENGEMBALIAN) AS JML_RETURN_FARMASI,
						SUM(fmsd.HARGA_JUAL * fmsd.JUMLAH_KEMBALI) AS HARGA_RETURN_FARMASI,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1) AS KASIR,
						' . (($jns_bayar != '1') ? 'DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
						'DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
						fms.SHIFT_PEMBAYARAN AS SHIFT
						FROM db_simrs.t_irja irj
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep fms
						ON (irj.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGEMBALIAN IS NOT NULL
						AND fms.JENIS_PENGEMBALIAN = "1")
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep_detail fmsd
						ON (fms.FARMASI_PENGEMBALIAN_APOTIK_ID = fmsd.FARMASI_PENGEMBALIAN_ID)
						LEFT JOIN db_simrs.t_irna irn
						ON (irj.IRJA_ID = irn.IRNA_ID
						AND irn.NO_PENDAFTARAN IS NOT NULL 
						AND irn.ST_BATAL IS NULL)
						WHERE irj.NO_PENDAFTARAN IS NOT NULL 
						AND irj.ST_BATAL IS NULL
						AND irj.UNIT_ID <> 9
						' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "1"
							AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
						AND irn.IRNA_ID IS NULL
						GROUP BY irj.IRJA_ID,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1),
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),
						fms.SHIFT_PEMBAYARAN
						-- end farmasi rawat jalan
						
						-- farmasi rawat inap
						UNION ALL
						SELECT "FMS" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
						DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS JML_FARMASI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA_FARMASI,
						0 AS JML_RETURN_FARMASI,
						0 AS HARGA_RETURN_FARMASI,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1) AS KASIR,
						' . (($jns_bayar != '1') ? 'DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
						'DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
						fms.SHIFT_PEMBAYARAN AS SHIFT
						FROM db_simrs.t_irna irn
						INNER JOIN db_simrs.t_irja irj 
						ON (irn.IRNA_ID = irj.IRJA_ID)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
						ON (irj.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGELUARAN IS NOT NULL
						AND fms.JENIS_PENGELUARAN = "1"
						AND fms.ST_BATAL IS NULL)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						WHERE irn.NO_PENDAFTARAN IS NOT NULL 
						AND irn.ST_BATAL IS NULL
						' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "1"
							AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
						GROUP BY irn.IRNA_ID,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1),
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),
						fms.SHIFT_PEMBAYARAN
						UNION ALL
						SELECT "FMS" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
						DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						COUNT(DISTINCT fms.NO_PENGELUARAN) AS JML_FARMASI,
						SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA_FARMASI,
						0 AS JML_RETURN_FARMASI,
						0 AS HARGA_RETURN_FARMASI,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1) AS KASIR,
						' . (($jns_bayar != '1') ? 'DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
						'DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
						fms.SHIFT_PEMBAYARAN AS SHIFT
						FROM db_simrs.t_irna irn
						INNER JOIN db_simrs.t_irja irj 
						ON (irn.IRNA_ID = irj.IRJA_ID)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
						ON (irn.IRNA_ID = fms.RANAP_ID AND fms.NO_PENGELUARAN IS NOT NULL
						AND fms.JENIS_PENGELUARAN = "2"
						AND fms.ST_BATAL IS NULL)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
						ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
						WHERE irn.NO_PENDAFTARAN IS NOT NULL 
						AND irn.ST_BATAL IS NULL
						' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "1"
							AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
						GROUP BY irn.IRNA_ID,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1),
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),
						fms.SHIFT_PEMBAYARAN
						
						UNION ALL
						SELECT "FMS" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
						DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						0 AS JML_FARMASI,
						0 AS HARGA_FARMASI,
						COUNT(DISTINCT fms.NO_PENGEMBALIAN) AS JML_RETURN_FARMASI,
						SUM(fmsd.HARGA_JUAL * fmsd.JUMLAH_KEMBALI) AS HARGA_RETURN_FARMASI,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1) AS KASIR,
						' . (($jns_bayar != '1') ? 'DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
						'DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
						fms.SHIFT_PEMBAYARAN AS SHIFT
						FROM db_simrs.t_irna irn
						INNER JOIN db_simrs.t_irja irj 
						ON (irn.IRNA_ID = irj.IRJA_ID)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep fms
						ON (irj.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGEMBALIAN IS NOT NULL
						AND fms.JENIS_PENGEMBALIAN = "1")
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep_detail fmsd
						ON (fms.FARMASI_PENGEMBALIAN_APOTIK_ID = fmsd.FARMASI_PENGEMBALIAN_ID)
						WHERE irn.NO_PENDAFTARAN IS NOT NULL 
						AND irn.ST_BATAL IS NULL
						' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "1"
							AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
						GROUP BY irn.IRNA_ID,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1),
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),
						fms.SHIFT_PEMBAYARAN
						UNION ALL
						SELECT "FMS" AS PASIEN,irn.IRNA_ID AS RAWAT_ID,irn.NOMR,
						fms.JAMINAN_ID AS JENIS_BAYAR_ID,irj.UNIT_ID,irn.RUANG_ID,
						DATE_FORMAT(irj.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
						DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
						0 AS JML_FARMASI,
						0 AS HARGA_FARMASI,
						COUNT(DISTINCT fms.NO_PENGEMBALIAN) AS JML_RETURN_FARMASI,
						SUM(fmsd.HARGA_JUAL * fmsd.JUMLAH_KEMBALI) AS HARGA_RETURN_FARMASI,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1) AS KASIR,
						' . (($jns_bayar != '1') ? 'DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
						'DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
						fms.SHIFT_PEMBAYARAN AS SHIFT
						FROM db_simrs.t_irna irn
						INNER JOIN db_simrs.t_irja irj 
						ON (irn.IRNA_ID = irj.IRJA_ID)
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep fms
						ON (irn.IRNA_ID = fms.RANAP_ID AND fms.NO_PENGEMBALIAN IS NOT NULL
						AND fms.JENIS_PENGEMBALIAN = "2")
						INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep_detail fmsd
						ON (fms.FARMASI_PENGEMBALIAN_APOTIK_ID = fmsd.FARMASI_PENGEMBALIAN_ID)
						WHERE irn.NO_PENDAFTARAN IS NOT NULL 
						AND irn.ST_BATAL IS NULL
						' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(irn.PASIEN_KELUAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
							AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
							AND fms.JAMINAN_ID = "1"
							AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
						GROUP BY irn.IRNA_ID,
						SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1),
						DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),
						fms.SHIFT_PEMBAYARAN
						-- end farmasi rawat inap
					) t_bayar_l2
					INNER JOIN db_simrs.m_jaminan jmn
					ON (t_bayar_l2.JENIS_BAYAR_ID = jmn.JAMINAN_ID)
					INNER JOIN db_simrs.m_pasien psn
					ON (t_bayar_l2.NOMR = psn.NOMR)
					INNER JOIN db_simrs.m_unit unt
					ON (t_bayar_l2.UNIT_ID = unt.UNIT_ID)
					LEFT JOIN db_simrs.m_ruang rng
					ON (t_bayar_l2.RUANG_ID = rng.RUANG_ID)	
					GROUP BY t_bayar_l2.RAWAT_ID,jmn.NAMA_JAMINAN,
					t_bayar_l2.NOMR,psn.NAMA_PASIEN,unt.NAMA_UNIT,
					rng.NAMA_RUANG,t_bayar_l2.TGL_MASUK,t_bayar_l2.TGL_KELUAR,
					t_bayar_l2.KASIR,t_bayar_l2.TGL_BAYAR,t_bayar_l2.SHIFT
					UNION ALL
					SELECT CONCAT("x",pnj.PENUNJANG_ID) AS RAWAT_ID,jmn.NAMA_JAMINAN,
					pnj.NO_PASIEN_PENUNJANG AS NOMR,pnj.NAMA_PASIEN,"APS" AS NAMA_UNIT,
					NULL AS NAMA_RUANG,DATE_FORMAT(pnjtf.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_MASUK,
					DATE_FORMAT(pnjtf.TANGGAL_DAFTAR,"%d-%m-%Y") AS TGL_KELUAR,
					0 AS JML_AKOMODASI,
					0 AS HARGA_AKOMODASI,
					NULL AS VISIT_DOKTER_UMUM,
					0 AS JML_VISIT_DOKTER_UMUM,
					0 AS HARGA_VISIT_DOKTER_UMUM,
					NULL AS VISIT_DOKTER_SPESIALIS, 
					0 AS JML_VISIT_DOKTER_SPESIALIS,
					0 AS HARGA_VISIT_DOKTER_SPESIALIS,
					0 AS JML_TINDAKAN_RI,
					0 AS HARGA_TINDAKAN_RI,
					0 AS JML_KARCIS_IGD,
					0 AS HARGA_KARCIS_IGD,
					NULL AS KONSUL_DOKTER_UMUM_IGD,
					0 AS JML_KONSUL_DOKTER_UMUM_IGD,
					0 AS HARGA_KONSUL_DOKTER_UMUM_IGD,
					NULL AS KONSUL_DOKTER_SPESIALIS_IGD,
					0 AS JML_KONSUL_DOKTER_SPESIALIS_IGD,
					0 AS HARGA_KONSUL_DOKTER_SPESIALIS_IGD,
					0 AS JML_TINDAKAN_IGD,
					0 AS HARGA_TINDAKAN_IGD,
					0 AS JML_KARCIS_POLI,
					0 AS HARGA_KARCIS_POLI,
					NULL AS KONSUL_DOKTER_UMUM_POLI,
					0 AS JML_KONSUL_DOKTER_UMUM_POLI,
					0 AS HARGA_KONSUL_DOKTER_UMUM_POLI,
					NULL AS KONSUL_DOKTER_SPESIALIS_POLI,
					0 AS JML_KONSUL_DOKTER_SPESIALIS_POLI,
					0 AS HARGA_KONSUL_DOKTER_SPESIALIS_POLI,
					0 AS JML_TINDAKAN_POLI,
					0 AS HARGA_TINDAKAN_POLI,
					NULL AS KONSUL_DOKTER_UMUM_BEDAHOK,
					0 AS JML_KONSUL_DOKTER_UMUM_BEDAHOK,
					0 AS HARGA_KONSUL_DOKTER_UMUM_BEDAHOK,
					NULL AS KONSUL_DOKTER_SPESIALIS_BEDAHOK,
					0 AS JML_KONSUL_DOKTER_SPESIALIS_BEDAHOK,
					0 AS HARGA_KONSUL_DOKTER_SPESIALIS_BEDAHOK,
					0 AS JML_OPERASI,
					0 AS HARGA_OPERASI,
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
					0 AS JML_FARMASI,
					0 AS HARGA_FARMASI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_pmi . ') THEN pnjtf.KUANTITI ELSE 0 END) AS JML_PMI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_pmi . ') THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_PMI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_skrining_gizi . ') THEN pnjtf.KUANTITI ELSE 0 END) AS JML_SKRINING_GIZI,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_skrining_gizi . ') THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_SKRINING_GIZI,
					0 AS JML_ASKEP,
					0 AS HARGA_ASKEP,
					0 AS JML_SEWALAHAN,
					0 AS HARGA_SEWALAHAN,
					0 AS JML_DIKLAT,
					0 AS HARGA_DIKLAT,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_peml_jenazah . ') THEN pnjtf.KUANTITI ELSE 0 END) AS JML_PEMULASARAAN_JENAZAH,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_peml_jenazah . ') THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_PEMULASARAAN_JENAZAH,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_ambulance . ') THEN pnjtf.KUANTITI ELSE 0 END) AS JML_AMBULANCE,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_ambulance . ') THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_AMBULANCE,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_londry . ') THEN pnjtf.KUANTITI ELSE 0 END) AS JML_LONDRY,
					SUM(CASE WHEN mtrg.KODE_TARIF_GROUP IN (' . $arr_londry . ') THEN pnjtf.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_LONDRY,
					0 AS JML_RETURN_FARMASI,
					0 AS HARGA_RETURN_FARMASI,
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
					' . (($jns_bayar != '1') ? 'AND STR_TO_DATE(DATE_FORMAT(pnjtf.TANGGAL_DAFTAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
						AND STR_TO_DATE(DATE_FORMAT(pnjtf.TANGGAL_DAFTAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
						AND pnj.JENIS_BAYAR_ID = "' . $jns_bayar . '"
						AND pnjtf.ST_BAYAR = "Lunas"' : 'AND STR_TO_DATE(DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
						AND STR_TO_DATE(DATE_FORMAT(pnjtf.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
						AND pnj.JENIS_BAYAR_ID = "1"
						AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")') . '
					AND pnjtf.NO_TARIF IS NOT NULL
					AND pnjtf.ST_BATAL IS NULL
					GROUP BY pnj.PENUNJANG_ID
					UNION ALL
					SELECT CONCAT("y",fms.FARMASI_PENGELUARAN_APOTIK_ID) AS RAWAT_ID,jmn.NAMA_JAMINAN,
					fms.NIK AS NOMR,fms.NAMA_PELANGGAN AS NAMA_PASIEN,"APS" AS NAMA_UNIT,
					NULL AS NAMA_RUANG,DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_MASUK,
					DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_KELUAR,
					0 AS JML_AKOMODASI,
					0 AS HARGA_AKOMODASI,
					NULL AS VISIT_DOKTER_UMUM,
					0 AS JML_VISIT_DOKTER_UMUM,
					0 AS HARGA_VISIT_DOKTER_UMUM,
					NULL AS VISIT_DOKTER_SPESIALIS, 
					0 AS JML_VISIT_DOKTER_SPESIALIS,
					0 AS HARGA_VISIT_DOKTER_SPESIALIS,
					0 AS JML_TINDAKAN_RI,
					0 AS HARGA_TINDAKAN_RI,
					0 AS JML_KARCIS_IGD,
					0 AS HARGA_KARCIS_IGD,
					NULL AS KONSUL_DOKTER_UMUM_IGD,
					0 AS JML_KONSUL_DOKTER_UMUM_IGD,
					0 AS HARGA_KONSUL_DOKTER_UMUM_IGD,
					NULL AS KONSUL_DOKTER_SPESIALIS_IGD,
					0 AS JML_KONSUL_DOKTER_SPESIALIS_IGD,
					0 AS HARGA_KONSUL_DOKTER_SPESIALIS_IGD,
					0 AS JML_TINDAKAN_IGD,
					0 AS HARGA_TINDAKAN_IGD,
					0 AS JML_KARCIS_POLI,
					0 AS HARGA_KARCIS_POLI,
					NULL AS KONSUL_DOKTER_UMUM_POLI,
					0 AS JML_KONSUL_DOKTER_UMUM_POLI,
					0 AS HARGA_KONSUL_DOKTER_UMUM_POLI,
					NULL AS KONSUL_DOKTER_SPESIALIS_POLI,
					0 AS JML_KONSUL_DOKTER_SPESIALIS_POLI,
					0 AS HARGA_KONSUL_DOKTER_SPESIALIS_POLI,
					0 AS JML_TINDAKAN_POLI,
					0 AS HARGA_TINDAKAN_POLI,
					NULL AS KONSUL_DOKTER_UMUM_BEDAHOK,
					0 AS JML_KONSUL_DOKTER_UMUM_BEDAHOK,
					0 AS HARGA_KONSUL_DOKTER_UMUM_BEDAHOK,
					NULL AS KONSUL_DOKTER_SPESIALIS_BEDAHOK,
					0 AS JML_KONSUL_DOKTER_SPESIALIS_BEDAHOK,
					0 AS HARGA_KONSUL_DOKTER_SPESIALIS_BEDAHOK,
					0 AS JML_OPERASI,
					0 AS HARGA_OPERASI,
					0 AS JML_LABORATORIUM,
					0 AS HARGA_LABORATORIUM,
					0 AS JML_RADIOLOGI,
					0 AS HARGA_RADIOLOGI,
					0 AS JML_FISIOTERAPI,
					0 AS HARGA_FISIOTERAPI,
					0 AS JML_OKUPASI_TERAPI,
					0 AS HARGA_OKUPASI_TERAPI,
					0 AS JML_PROTESE,
					0 AS HARGA_PROTESE,
					0 AS JML_PSIKOLOGI,
					0 AS HARGA_PSIKOLOGI,
					0 AS JML_TERAPI_WICARA,
					0 AS HARGA_TERAPI_WICARA,
					0 AS JML_PERAWATAN_LUKA,
					0 AS HARGA_PERAWATAN_LUKA,
					COUNT(DISTINCT fms.NO_PENGELUARAN) AS JML_FARMASI,
					SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS HARGA_FARMASI,
					0 AS JML_PMI,
					0 AS HARGA_PMI,
					0 AS JML_SKRINING_GIZI,
					0 AS HARGA_SKRINING_GIZI,
					0 AS JML_ASKEP,
					0 AS HARGA_ASKEP,
					0 AS JML_SEWALAHAN,
					0 AS HARGA_SEWALAHAN,
					0 AS JML_DIKLAT,
					0 AS HARGA_DIKLAT,
					0 AS JML_PEMULASARAAN_JENAZAH,
					0 AS HARGA_PEMULASARAAN_JENAZAH,
					0 AS JML_AMBULANCE,
					0 AS HARGA_AMBULANCE,
					0 AS JML_LONDRY,
					0 AS HARGA_LONDRY,
					0 AS JML_RETURN_FARMASI,
					0 AS HARGA_RETURN_FARMASI,
					SUBSTRING_INDEX(fms.USER_PEMBAYARAN,"|",-1) AS KASIR,
					' . (($jns_bayar != '1') ? 'DATE_FORMAT(fms.TANGGAL_KELUAR,"%d-%m-%Y") AS TGL_BAYAR,' : 
						'DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y") AS TGL_BAYAR,') . '
					fms.SHIFT_PEMBAYARAN AS SHIFT
					FROM db_inventorirs.t_farmasi_apotik_pengeluaran fms
					INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
					ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
					INNER JOIN db_simrs.m_jaminan jmn
					ON (1 = jmn.JAMINAN_ID)
					WHERE fms.NO_PENGELUARAN IS NOT NULL 
					AND fms.JENIS_PENGELUARAN = "3"
					AND fms.ST_BATAL IS NULL
					' . (($jns_bayar != '1') ? 'AND fms.JAMINAN_ID = "xyz"' : 'AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
						AND STR_TO_DATE(DATE_FORMAT(fms.TANGGAL_BAYAR,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2 . '
						AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
					GROUP BY fms.FARMASI_PENGELUARAN_APOTIK_ID
					UNION ALL
					SELECT CONCAT("z",pnm.PENERIMAAN_LAINLAIN_ID) AS RAWAT_ID,jmn.NAMA_JAMINAN,
					pnm.NO_TARIF AS NOMR,pnm.PIC AS NAMA_PASIEN,"Lain-lain" AS NAMA_UNIT,
					NULL AS NAMA_RUANG,DATE_FORMAT(pnm.TANGGAL,"%d-%m-%Y") AS TGL_MASUK,
					DATE_FORMAT(pnm.TANGGAL,"%d-%m-%Y") AS TGL_KELUAR,
					0 AS JML_AKOMODASI,
					0 AS HARGA_AKOMODASI,
					NULL AS VISIT_DOKTER_UMUM,
					0 AS JML_VISIT_DOKTER_UMUM,
					0 AS HARGA_VISIT_DOKTER_UMUM,
					NULL AS VISIT_DOKTER_SPESIALIS, 
					0 AS JML_VISIT_DOKTER_SPESIALIS,
					0 AS HARGA_VISIT_DOKTER_SPESIALIS,
					0 AS JML_TINDAKAN_RI,
					0 AS HARGA_TINDAKAN_RI,
					0 AS JML_KARCIS_IGD,
					0 AS HARGA_KARCIS_IGD,
					NULL AS KONSUL_DOKTER_UMUM_IGD,
					0 AS JML_KONSUL_DOKTER_UMUM_IGD,
					0 AS HARGA_KONSUL_DOKTER_UMUM_IGD,
					NULL AS KONSUL_DOKTER_SPESIALIS_IGD,
					0 AS JML_KONSUL_DOKTER_SPESIALIS_IGD,
					0 AS HARGA_KONSUL_DOKTER_SPESIALIS_IGD,
					0 AS JML_TINDAKAN_IGD,
					0 AS HARGA_TINDAKAN_IGD,
					0 AS JML_KARCIS_POLI,
					0 AS HARGA_KARCIS_POLI,
					NULL AS KONSUL_DOKTER_UMUM_POLI,
					0 AS JML_KONSUL_DOKTER_UMUM_POLI,
					0 AS HARGA_KONSUL_DOKTER_UMUM_POLI,
					NULL AS KONSUL_DOKTER_SPESIALIS_POLI,
					0 AS JML_KONSUL_DOKTER_SPESIALIS_POLI,
					0 AS HARGA_KONSUL_DOKTER_SPESIALIS_POLI,
					0 AS JML_TINDAKAN_POLI,
					0 AS HARGA_TINDAKAN_POLI,
					NULL AS KONSUL_DOKTER_UMUM_BEDAHOK,
					0 AS JML_KONSUL_DOKTER_UMUM_BEDAHOK,
					0 AS HARGA_KONSUL_DOKTER_UMUM_BEDAHOK,
					NULL AS KONSUL_DOKTER_SPESIALIS_BEDAHOK,
					0 AS JML_KONSUL_DOKTER_SPESIALIS_BEDAHOK,
					0 AS HARGA_KONSUL_DOKTER_SPESIALIS_BEDAHOK,
					0 AS JML_OPERASI,
					0 AS HARGA_OPERASI,
					0 AS JML_LABORATORIUM,
					0 AS HARGA_LABORATORIUM,
					0 AS JML_RADIOLOGI,
					0 AS HARGA_RADIOLOGI,
					0 AS JML_FISIOTERAPI,
					0 AS HARGA_FISIOTERAPI,
					0 AS JML_OKUPASI_TERAPI,
					0 AS HARGA_OKUPASI_TERAPI,
					0 AS JML_PROTESE,
					0 AS HARGA_PROTESE,
					0 AS JML_PSIKOLOGI,
					0 AS HARGA_PSIKOLOGI,
					0 AS JML_TERAPI_WICARA,
					0 AS HARGA_TERAPI_WICARAI,
					0 AS JML_PERAWATAN_LUKA,
					0 AS HARGA_PERAWATAN_LUKA,
					0 AS JML_FARMASI,
					0 AS HARGA_FARMASI,
					SUM(CASE WHEN mtr.KODE_TARIF_GROUP IN (' . $arr_pmi . ') THEN pnmt.KUANTITI ELSE 0 END) AS JML_PMI,
					SUM(CASE WHEN mtr.KODE_TARIF_GROUP IN (' . $arr_pmi . ') THEN pnmt.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_PMI,
					0 AS JML_SKRINING_GIZI,
					0 AS HARGA_SKRINING_GIZI,
					0 AS JML_ASKEP,
					0 AS HARGA_ASKEP,
					SUM(CASE WHEN mtr.KODE_TARIF_GROUP IN (' . $arr_sewalahan . ') THEN pnmt.KUANTITI ELSE 0 END) AS JML_SEWALAHAN,
					SUM(CASE WHEN mtr.KODE_TARIF_GROUP IN (' . $arr_sewalahan . ') THEN pnmt.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_SEWALAHAN,
					SUM(CASE WHEN mtr.KODE_TARIF_GROUP IN (' . $arr_diklat . ') THEN pnmt.KUANTITI ELSE 0 END) AS JML_DIKLAT,
					SUM(CASE WHEN mtr.KODE_TARIF_GROUP IN (' . $arr_diklat . ') THEN pnmt.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_DIKLAT,
					SUM(CASE WHEN mtr.KODE_TARIF_GROUP IN (' . $arr_peml_jenazah . ') THEN pnmt.KUANTITI ELSE 0 END)  AS JML_PEMULASARAAN_JENAZAH,
					SUM(CASE WHEN mtr.KODE_TARIF_GROUP IN (' . $arr_peml_jenazah . ') THEN pnmt.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_PEMULASARAAN_JENAZAH,
					SUM(CASE WHEN mtr.KODE_TARIF_GROUP IN (' . $arr_ambulance . ') THEN pnmt.KUANTITI ELSE 0 END) AS JML_AMBULANCE,
					SUM(CASE WHEN mtr.KODE_TARIF_GROUP IN (' . $arr_ambulance . ') THEN pnmt.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_AMBULANCE,
					SUM(CASE WHEN mtr.KODE_TARIF_GROUP IN (' . $arr_londry . ') THEN pnmt.KUANTITI ELSE 0 END) AS JML_LONDRY,
					SUM(CASE WHEN mtr.KODE_TARIF_GROUP IN (' . $arr_londry . ') THEN pnmt.KUANTITI * mtr.TARIF_NON_KELAS ELSE 0 END) AS HARGA_LONDRY,
					0 AS JML_RETURN_FARMASI,
					0 AS HARGA_RETURN_FARMASI,
					SUBSTRING_INDEX(pnm.REGISTER,"|",-1) AS KASIR,
					DATE_FORMAT(pnm.TANGGAL,"%d-%m-%Y") AS TGL_BAYAR,
					"" AS SHIFT
					FROM db_simkeu.r_penerimaan_lainlain pnm
					INNER JOIN db_simkeu.r_penerimaan_lainlain_tarif pnmt 
					ON (pnm.PENERIMAAN_LAINLAIN_ID = pnmt.PENERIMAAN_LAINLAIN_ID)
					INNER JOIN db_simrs.m_tarif mtr 
					ON (pnmt.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_jaminan jmn
					ON (1 = jmn.JAMINAN_ID)
					WHERE 1
					' . (($jns_bayar != '1') ? 'AND pnm.PENERIMAAN_LAINLAIN_ID = "xyz"' : 'AND STR_TO_DATE(DATE_FORMAT(pnm.TANGGAL,"%d-%m-%Y"),"%d-%m-%Y") >= ' . $tgl_filter_1 . ' 
						AND STR_TO_DATE(DATE_FORMAT(pnm.TANGGAL,"%d-%m-%Y"),"%d-%m-%Y") <= ' . $tgl_filter_2) . '
					GROUP BY pnm.PENERIMAAN_LAINLAIN_ID
				) t_bayar_main
				GROUP BY t_bayar_main.RAWAT_ID,t_bayar_main.NAMA_JAMINAN,
				t_bayar_main.NOMR,t_bayar_main.NAMA_PASIEN,t_bayar_main.NAMA_UNIT,
				t_bayar_main.NAMA_RUANG,t_bayar_main.TGL_MASUK,t_bayar_main.TGL_KELUAR
				ORDER BY t_bayar_main.RAWAT_ID';					
$get_pembayaran = mysql_query($qry_pembayaran) or die(mysql_error());
$akomodasi = 0;
$visit_dokter_umum = 0;
$visit_dokter_spesialis = 0;
$tindakan_ri = 0;
$karcis_igd = 0;
$konsul_dokter_umum_igd = 0;
$konsul_dokter_spesialisa_igd = 0;
$tindakan_igd = 0;
$karcis_poli = 0;
$konsul_dokter_umum_poli = 0;
$konsul_dokter_spesialisa_poli = 0;
$tindakan_poli = 0;
$konsul_dokter_umum_bedahok = 0;
$konsul_dokter_spesialisa_bedahok = 0;
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

	$str_konsul_dokter_umum_igd = '|';
	$jml_konsul_dokter_umum_igd = '|';
	if($dat_pembayaran['KONSUL_DOKTER_UMUM_IGD'] != ''){
		$str_konsul_dokter_umum_igd = '';
		$jml_konsul_dokter_umum_igd = '';
		$arr_str_konsul_dokter_umum_igd = explode('||',$dat_pembayaran['KONSUL_DOKTER_UMUM_IGD']);
		foreach($arr_str_konsul_dokter_umum_igd as $row){
			$arr_row = explode('|',$row);
			$str_konsul_dokter_umum_igd .= $arr_row[0] . '|';
			$jml_konsul_dokter_umum_igd .= $arr_row[1] . '|';
		}
	}

	$str_konsul_dokter_spesialis_igd = '|';
	$jml_konsul_dokter_spesialis_igd = '|';
	if($dat_pembayaran['KONSUL_DOKTER_SPESIALIS_IGD'] != ''){
		$str_konsul_dokter_spesialis_igd = '';
		$jml_konsul_dokter_spesialis_igd = '';
		$arr_str_konsul_dokter_spesialis_igd = explode('||',$dat_pembayaran['KONSUL_DOKTER_SPESIALIS_IGD']);
		foreach($arr_str_konsul_dokter_spesialis_igd as $row){
			$arr_row = explode('|',$row);
			$str_konsul_dokter_spesialis_igd .= $arr_row[0] . '|';
			$jml_konsul_dokter_spesialis_igd .= $arr_row[1] . '|';
		}
	}

	$str_konsul_dokter_umum_poli = '|';
	$jml_konsul_dokter_umum_poli = '|';
	if($dat_pembayaran['KONSUL_DOKTER_UMUM_POLI'] != ''){
		$str_konsul_dokter_umum_poli = '';
		$jml_konsul_dokter_umum_poli = '';
		$arr_str_konsul_dokter_umum_poli = explode('||',$dat_pembayaran['KONSUL_DOKTER_UMUM_POLI']);
		foreach($arr_str_konsul_dokter_umum_poli as $row){
			$arr_row = explode('|',$row);
			$str_konsul_dokter_umum_poli .= $arr_row[0] . '|';
			$jml_konsul_dokter_umum_poli .= $arr_row[1] . '|';
		}
	}

	$str_konsul_dokter_spesialis_poli = '|';
	$jml_konsul_dokter_spesialis_poli = '|';
	if($dat_pembayaran['KONSUL_DOKTER_SPESIALIS_POLI'] != ''){
		$str_konsul_dokter_spesialis_poli = '';
		$jml_konsul_dokter_spesialis_poli = '';
		$arr_str_konsul_dokter_spesialis_poli = explode('||',$dat_pembayaran['KONSUL_DOKTER_SPESIALIS_POLI']);
		foreach($arr_str_konsul_dokter_spesialis_poli as $row){
			$arr_row = explode('|',$row);
			$str_konsul_dokter_spesialis_poli .= $arr_row[0] . '|';
			$jml_konsul_dokter_spesialis_poli .= $arr_row[1] . '|';
		}
	}

	$str_konsul_dokter_umum_bedahok = '|';
	$jml_konsul_dokter_umum_bedahok = '|';
	if($dat_pembayaran['KONSUL_DOKTER_UMUM_BEDAHOK'] != ''){
		$str_konsul_dokter_umum_bedahok = '';
		$jml_konsul_dokter_umum_bedahok = '';
		$arr_str_konsul_dokter_umum_bedahok = explode('||',$dat_pembayaran['KONSUL_DOKTER_UMUM_BEDAHOK']);
		foreach($arr_str_konsul_dokter_umum_bedahok as $row){
			$arr_row = explode('|',$row);
			$str_konsul_dokter_umum_bedahok .= $arr_row[0] . '|';
			$jml_konsul_dokter_umum_bedahok .= $arr_row[1] . '|';
		}
	}

	$str_konsul_dokter_spesialis_bedahok = '|';
	$jml_konsul_dokter_spesialis_bedahok = '|';
	if($dat_pembayaran['KONSUL_DOKTER_SPESIALIS_BEDAHOK'] != ''){
		$str_konsul_dokter_spesialis_bedahok = '';
		$jml_konsul_dokter_spesialis_bedahok = '';
		$arr_str_konsul_dokter_spesialis_bedahok = explode('||',$dat_pembayaran['KONSUL_DOKTER_SPESIALIS_BEDAHOK']);
		foreach($arr_str_konsul_dokter_spesialis_bedahok as $row){
			$arr_row = explode('|',$row);
			$str_konsul_dokter_spesialis_bedahok .= $arr_row[0] . '|';
			$jml_konsul_dokter_spesialis_bedahok .= $arr_row[1] . '|';
		}
	}
$nama_unit = '';
if($dat_pembayaran['NAMA_UNIT'] != '' and $dat_pembayaran['NAMA_RUANG'] == '') $nama_unit = $dat_pembayaran['NAMA_UNIT'];
if($dat_pembayaran['NAMA_UNIT'] == '' and $dat_pembayaran['NAMA_RUANG'] != '') $nama_unit = $dat_pembayaran['NAMA_RUANG'];
if($dat_pembayaran['NAMA_UNIT'] != '' and $dat_pembayaran['NAMA_RUANG'] != '') $nama_unit = $dat_pembayaran['NAMA_RUANG'];
$akomodasi += $dat_pembayaran['HARGA_AKOMODASI'];
$visit_dokter_umum += $dat_pembayaran['HARGA_VISIT_DOKTER_UMUM'];
$visit_dokter_spesialis += $dat_pembayaran['HARGA_VISIT_DOKTER_SPESIALIS'];
$tindakan_ri += $dat_pembayaran['HARGA_TINDAKAN_RI'];
$karcis_igd += $dat_pembayaran['HARGA_KARCIS_IGD'];
$konsul_dokter_umum_igd += $dat_pembayaran['HARGA_KONSUL_DOKTER_UMUM_IGD'];
$konsul_dokter_spesialisa_igd += $dat_pembayaran['HARGA_KONSUL_DOKTER_SPESIALIS_IGD'];
$tindakan_igd += $dat_pembayaran['HARGA_TINDAKAN_IGD'];
$karcis_poli += $dat_pembayaran['HARGA_KARCIS_POLI'];
$konsul_dokter_umum_poli += $dat_pembayaran['HARGA_KONSUL_DOKTER_UMUM_POLI'];
$konsul_dokter_spesialisa_poli += $dat_pembayaran['HARGA_KONSUL_DOKTER_SPESIALIS_POLI'];
$tindakan_poli += $dat_pembayaran['HARGA_TINDAKAN_POLI'];
$konsul_dokter_umum_bedahok += $dat_pembayaran['HARGA_KONSUL_DOKTER_UMUM_BEDAHOK'];
$konsul_dokter_spesialisa_bedahok += $dat_pembayaran['HARGA_KONSUL_DOKTER_SPESIALIS_BEDAHOK'];
$operasi += $dat_pembayaran['HARGA_OPERASI'];
$laboratorium += $dat_pembayaran['HARGA_LABORATORIUM'];
$radiologi += $dat_pembayaran['HARGA_RADIOLOGI'];
$fisioterapi += $dat_pembayaran['HARGA_FISIOTERAPI'];
$okupasi_terapi += $dat_pembayaran['HARGA_OKUPASI_TERAPI'];
$protese += $dat_pembayaran['HARGA_PROTESE'];
$psikologi += $dat_pembayaran['HARGA_PSIKOLOGI'];
$terapi_wicara += $dat_pembayaran['HARGA_TERAPI_WICARA'];
$perawatan_luka += $dat_pembayaran['HARGA_PERAWATAN_LUKA'];
$farmasi += $dat_pembayaran['HARGA_FARMASI'];
$pmi += $dat_pembayaran['HARGA_PMI'];
$skrining_gizi += $dat_pembayaran['HARGA_SKRINING_GIZI'];
$askep += $dat_pembayaran['HARGA_ASKEP'];
$sewa_lahan += $dat_pembayaran['HARGA_SEWALAHAN'];
$diklat += $dat_pembayaran['HARGA_DIKLAT'];
$peml_jenazah += $dat_pembayaran['HARGA_PEMULASARAAN_JENAZAH'];
$ambulance += $dat_pembayaran['HARGA_AMBULANCE'];
$londry += $dat_pembayaran['HARGA_LONDRY'];
$return_farmasi += $dat_pembayaran['HARGA_RETURN_FARMASI'];
$subtotal = $dat_pembayaran['HARGA_AKOMODASI'] + $dat_pembayaran['HARGA_VISIT_DOKTER_UMUM'] + 
			$dat_pembayaran['HARGA_VISIT_DOKTER_SPESIALIS'] + $dat_pembayaran['HARGA_TINDAKAN_RI'] + 
			$dat_pembayaran['HARGA_KARCIS_IGD'] + $dat_pembayaran['HARGA_KONSUL_DOKTER_UMUM_IGD'] + 
			$dat_pembayaran['HARGA_KONSUL_DOKTER_SPESIALIS_IGD'] + $dat_pembayaran['HARGA_TINDAKAN_IGD'] +
			$dat_pembayaran['HARGA_KARCIS_POLI'] + $dat_pembayaran['HARGA_KONSUL_DOKTER_UMUM_POLI'] +
			$dat_pembayaran['HARGA_KONSUL_DOKTER_SPESIALIS_POLI'] + $dat_pembayaran['HARGA_TINDAKAN_POLI'] + 
			$dat_pembayaran['HARGA_KONSUL_DOKTER_UMUM_BEDAHOK'] + $dat_pembayaran['HARGA_KONSUL_DOKTER_SPESIALIS_BEDAHOK'] +
			$dat_pembayaran['HARGA_OPERASI'] + 
			$dat_pembayaran['HARGA_LABORATORIUM'] + $dat_pembayaran['HARGA_RADIOLOGI'] + $dat_pembayaran['HARGA_FISIOTERAPI'] +
			$dat_pembayaran['HARGA_OKUPASI_TERAPI'] + $dat_pembayaran['HARGA_PROTESE'] + $dat_pembayaran['HARGA_PSIKOLOGI'] +
			$dat_pembayaran['HARGA_TERAPI_WICARA'] +
			$dat_pembayaran['HARGA_PERAWATAN_LUKA'] + 			
			$dat_pembayaran['HARGA_FARMASI'] + $dat_pembayaran['HARGA_PMI'] + 
			$dat_pembayaran['HARGA_SKRINING_GIZI'] + 
			$dat_pembayaran['HARGA_ASKEP'] +
			$dat_pembayaran['HARGA_SEWALAHAN'] + $dat_pembayaran['HARGA_DIKLAT'] + $dat_pembayaran['HARGA_PEMULASARAAN_JENAZAH'] +
			$dat_pembayaran['HARGA_AMBULANCE'] + $dat_pembayaran['HARGA_LONDRY'];
$total += $subtotal;
if($subtotal > 0 or $dat_pembayaran['JML_RETURN_FARMASI'] > 0){
?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
	<td><?php echo $dat_pembayaran['NAMA_JAMINAN']; ?></td>
	<td><?php echo ((strlen($dat_pembayaran['NOMR']) == 6) ? formatNomr($dat_pembayaran['NOMR']) : $dat_pembayaran['NOMR']); ?></td>
	<td><?php echo $dat_pembayaran['NAMA_PASIEN']; ?></td>
	<td><?php echo $nama_unit; ?></td>
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
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_KARCIS_IGD']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_KARCIS_IGD']); ?></td>
	<td><?php echo substr($str_konsul_dokter_umum_igd,0,strlen($str_konsul_dokter_umum_igd)-1); ?></td>
	<td align="right"><?php echo substr($jml_konsul_dokter_umum_igd,0,strlen($jml_konsul_dokter_umum_igd)-1); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_KONSUL_DOKTER_UMUM_IGD']); ?></td>
	<td><?php echo substr($str_konsul_dokter_spesialis_igd,0,strlen($str_konsul_dokter_spesialis_igd)-1); ?></td>
	<td align="right"><?php echo substr($jml_konsul_dokter_spesialis_igd,0,strlen($jml_konsul_dokter_spesialis_igd)-1); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_KONSUL_DOKTER_SPESIALIS_IGD']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_TINDAKAN_IGD']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_TINDAKAN_IGD']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_KARCIS_POLI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_KARCIS_POLI']); ?></td>
	<td><?php echo substr($str_konsul_dokter_umum_poli,0,strlen($str_konsul_dokter_umum_poli)-1); ?></td>
	<td align="right"><?php echo substr($jml_konsul_dokter_umum_poli,0,strlen($jml_konsul_dokter_umum_poli)-1); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_KONSUL_DOKTER_UMUM_POLI']); ?></td>
	<td><?php echo substr($str_konsul_dokter_spesialis_poli,0,strlen($str_konsul_dokter_spesialis_poli)-1); ?></td>
	<td align="right"><?php echo substr($jml_konsul_dokter_spesialis_poli,0,strlen($jml_konsul_dokter_spesialis_poli)-1); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_KONSUL_DOKTER_SPESIALIS_POLI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_TINDAKAN_POLI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_TINDAKAN_POLI']); ?></td>
	<td><?php echo substr($str_konsul_dokter_umum_bedahok,0,strlen($str_konsul_dokter_umum_bedahok)-1); ?></td>
	<td align="right"><?php echo substr($jml_konsul_dokter_umum_bedahok,0,strlen($jml_konsul_dokter_umum_bedahok)-1); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_KONSUL_DOKTER_UMUM_BEDAHOK']); ?></td>
	<td><?php echo substr($str_konsul_dokter_spesialis_bedahok,0,strlen($str_konsul_dokter_spesialis_bedahok)-1); ?></td>
	<td align="right"><?php echo substr($jml_konsul_dokter_spesialis_bedahok,0,strlen($jml_konsul_dokter_spesialis_bedahok)-1); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_KONSUL_DOKTER_SPESIALIS_BEDAHOK']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_OPERASI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_OPERASI']); ?></td>
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
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_FARMASI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_FARMASI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_PMI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_PMI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_SKRINING_GIZI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_SKRINING_GIZI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_ASKEP']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_ASKEP']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_SEWALAHAN']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_SEWALAHAN']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_DIKLAT']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_DIKLAT']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_PEMULASARAAN_JENAZAH']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_PEMULASARAAN_JENAZAH']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_AMBULANCE']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_AMBULANCE']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_LONDRY']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_LONDRY']); ?></td>
	<td align="right"><?php echo currFormat($subtotal); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JML_RETURN_FARMASI']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['HARGA_RETURN_FARMASI']); ?></td>
  </tr>
<?php
$no++; } } ?> 
 <tr>
	<td colspan="7" align="center">TOTAL</td>
    <td align="right" colspan="2"><?php echo currFormat($akomodasi); ?></td>
	<td align="right" colspan="3"><?php echo currFormat($visit_dokter_umum); ?></td>
	<td align="right" colspan="3"><?php echo currFormat($visit_dokter_spesialis); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($tindakan_ri); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($karcis_igd); ?></td>
	<td align="right" colspan="3"><?php echo currFormat($konsul_dokter_umum_igd); ?></td>
	<td align="right" colspan="3"><?php echo currFormat($konsul_dokter_spesialisa_igd); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($tindakan_igd); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($karcis_poli); ?></td>
	<td align="right" colspan="3"><?php echo currFormat($konsul_dokter_umum_poli); ?></td>
	<td align="right" colspan="3"><?php echo currFormat($konsul_dokter_spesialisa_poli); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($tindakan_poli); ?></td>
	<td align="right" colspan="3"><?php echo currFormat($konsul_dokter_umum_bedahok); ?></td>
	<td align="right" colspan="3"><?php echo currFormat($konsul_dokter_spesialisa_bedahok); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($operasi); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($laboratorium); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($radiologi); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($fisioterapi); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($okupasi_terapi); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($protese); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($psikologi); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($terapi_wicara); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($perawatan_luka); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($farmasi); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($pmi); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($skrining_gizi); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($askep); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($sewa_lahan); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($diklat); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($peml_jenazah); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($ambulance); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($londry); ?></td>
	<td align="right" ><?php echo currFormat($total); ?></td>
	<td align="right" colspan="2"><?php echo currFormat($return_farmasi); ?></td>
  </tr>
</table>
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
	<input type="hidden" name="jns_bayar" value="<?php echo $jns_bayar; ?>" />
	<input type="hidden" name="arr_akomodasi" value="<?php echo str_replace('"','',$arr_akomodasi); ?>" />
	<input type="hidden" name="arr_visit_dokter_umum" value="<?php echo str_replace('"','',$arr_visit_dokter_umum); ?>" />
	<input type="hidden" name="arr_visit_dokter_spesialis" value="<?php echo str_replace('"','',$arr_visit_dokter_spesialis); ?>" />
	<input type="hidden" name="arr_tindakan_ri" value="<?php echo str_replace('"','',$arr_tindakan_ri); ?>" />
	<input type="hidden" name="arr_karcis" value="<?php echo str_replace('"','',$arr_karcis); ?>" />
	<input type="hidden" name="arr_konsul_dokter_umum_igd" value="<?php echo str_replace('"','',$arr_konsul_dokter_umum_igd); ?>" />
	<input type="hidden" name="arr_konsul_dokter_spesialis_igd" value="<?php echo str_replace('"','',$arr_konsul_dokter_spesialis_igd); ?>" />
	<input type="hidden" name="arr_tindakan_igd" value="<?php echo str_replace('"','',$arr_tindakan_igd); ?>" />
	<input type="hidden" name="arr_konsul_dokter_umum_rj" value="<?php echo str_replace('"','',$arr_konsul_dokter_umum_rj); ?>" />
	<input type="hidden" name="arr_konsul_dokter_spesialis_rj" value="<?php echo str_replace('"','',$arr_konsul_dokter_spesialis_rj); ?>" />
	<input type="hidden" name="arr_tindakan_rj" value="<?php echo str_replace('"','',$arr_tindakan_rj); ?>" />
	<input type="hidden" name="arr_konsul_dokter_umum_opr" value="<?php echo str_replace('"','',$arr_konsul_dokter_umum_opr); ?>" />
	<input type="hidden" name="arr_konsul_dokter_spesialis_opr" value="<?php echo str_replace('"','',$arr_konsul_dokter_spesialis_opr); ?>" />
	<input type="hidden" name="arr_operasi" value="<?php echo str_replace('"','',$arr_operasi); ?>" />
	<input type="hidden" name="arr_laboratorium" value="<?php echo str_replace('"','',$arr_laboratorium); ?>" />
	<input type="hidden" name="arr_radiologi" value="<?php echo str_replace('"','',$arr_radiologi); ?>" />
	<input type="hidden" name="arr_fisioterapi" value="<?php echo str_replace('"','',$arr_fisioterapi); ?>" />
	<input type="hidden" name="arr_okupasi_terapi" value="<?php echo str_replace('"','',$arr_okupasi_terapi); ?>" />
	<input type="hidden" name="arr_prothese" value="<?php echo str_replace('"','',$arr_prothese); ?>" />
	<input type="hidden" name="arr_psikologi" value="<?php echo str_replace('"','',$arr_laboratorium); ?>" />
	<input type="hidden" name="arr_terapi_wicara" value="<?php echo str_replace('"','',$arr_terapi_wicara); ?>" />
	<input type="hidden" name="arr_perawatan_luka" value="<?php echo str_replace('"','',$arr_perawatan_luka); ?>" />
	<input type="hidden" name="arr_pmi" value="<?php echo str_replace('"','',$arr_pmi); ?>" />
	<input type="hidden" name="arr_skrining_gizi" value="<?php echo str_replace('"','',$arr_skrining_gizi); ?>" />
	<input type="hidden" name="arr_askep" value="<?php echo str_replace('"','',$arr_askep); ?>" />
	<input type="hidden" name="arr_sewalahan" value="<?php echo str_replace('"','',$arr_sewalahan); ?>" />
	<input type="hidden" name="arr_diklat" value="<?php echo str_replace('"','',$arr_diklat); ?>" />
	<input type="hidden" name="arr_peml_jenazah" value="<?php echo str_replace('"','',$arr_peml_jenazah); ?>" />
	<input type="hidden" name="arr_ambulance" value="<?php echo str_replace('"','',$arr_ambulance); ?>" />
	<input type="hidden" name="arr_londry" value="<?php echo str_replace('"','',$arr_londry); ?>" />
	<input type="hidden" name="xlsfile" value="keuangan/xls_report_penerimaan_gabungan.php" />
    <input type="hidden" name="xlsname" value="rpt_rekap_penerimaan_gabungan.xls" />            
</form>
<script>
function open_def_report(filter,lvl){
	var win = window.open('index.php?link=cf4b9acb3a3f9ce0bac95e7606adda05&repid=<?php echo $report_id; ?>&repname=<?php echo $header_page; ?>&nmfilter=' + filter + '&lvl=' + lvl, '_blank');
  win.focus();
}
</script>