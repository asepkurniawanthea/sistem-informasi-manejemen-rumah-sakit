<?php
$report_id = '1';

$arr_karcis = '';

$arr_konsul_dokter_umum_rj = '';
$arr_konsul_dokter_spesialis_rj = '';
$arr_tindakan_rj = '';

$arr_konsul_dokter_umum_igd = '';
$arr_konsul_dokter_spesialis_igd = '';
$arr_tindakan_igd = '';

$arr_akomodasi = '';
$arr_visit_dokter_umum = '';
$arr_visit_dokter_spesialis = '';
$arr_tindakan_ri = '';

$arr_operasi = '';
$arr_konsul_dokter_umum_opr = '';
$arr_konsul_dokter_spesialis_opr = '';

$arr_laboratorium = '';
$arr_radiologi = '';
$arr_fisioterapi = '';
$arr_okupasi_terapi = '';
$arr_prothese = '';
$arr_psikologi = '';
$arr_terapi_wicara = '';
$arr_perawatan_luka = '';

$arr_askep = '';
$arr_skrining_gizi = '';
$arr_peml_jenazah = '';

$arr_pmi = '';
$arr_sewalahan = '';
$arr_diklat = '';
$arr_ambulance = '';
$arr_londry = '';

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

$cash = '';
if (isset($_SESSION['pembayaranreportgabungan_cash']))
    $cash = $_SESSION['pembayaranreportgabungan_cash'];

if (isset($_GET['cash'])) {
    $cash = $_GET['cash'];
    $_SESSION['pembayaranreportgabungan_cash'] = $_GET['cash'];
}

$rekening = '';
if (isset($_SESSION['pembayaranreportgabungan_rekening']))
    $rekening = $_SESSION['pembayaranreportgabungan_rekening'];

if (isset($_GET['rekening'])) {
    $rekening = $_GET['rekening'];
    $_SESSION['pembayaranreportgabungan_rekening'] = $_GET['rekening'];
}

$arr_cash = getCash();
$arr_rekening = getRekening();

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
            <td align="right">&nbsp;</td>
		</tr>
		<tr>
			<td>Umum</td>
            <td>
            	<?php
            		echo '<select name="cash" class="text_dt" style="width:140px;" >';
					echo '<option value=""> - </option>';
					foreach ($arr_cash as $row) {
						echo '<option value="' . $row['kode'] . '" ' . (($cash == $row['kode']) ? 'selected' : '') . '>' . $row['deskripsi'] . '</option>';
					}
					echo '</select>';
            	?>
            </td>	
			<td>&nbsp;</td>
            <td align="right">&nbsp;</td>
		</tr>
		<tr>
			<td>Rekening</td>
            <td>
            	<?php
            		echo '<select name="rekening" class="text_dt" style="width:140px;" >';
					echo '<option value=""> - </option>';
					foreach ($arr_rekening as $row) {
						echo '<option value="' . $row['kode'] . '" ' . (($rekening == $row['kode']) ? 'selected' : '') .  '>' . $row['kode'] . '</option>';
					}
					echo '</select>';
            	?>
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
    <th>No</th>
	<th>Uraian Penerimaan</th>
	<th>Jumlah</th>
    <th>Biaya</th>
  </tr>
<?php $no = 1; 
$arr_konsul_di_rj = $arr_konsul_dokter_umum_rj . ',' . $arr_konsul_dokter_spesialis_rj;
$arr_konsul_di_igd = $arr_konsul_dokter_umum_igd . ',' . $arr_konsul_dokter_spesialis_igd . ',' . $arr_konsul_dokter_umum_rj . ',' . $arr_konsul_dokter_spesialis_rj;;

include('keuangan/keuangan_uraian_penerimaan_qry_rj_umum.php');
include('keuangan/keuangan_uraian_penerimaan_qry_igd.php');
include('keuangan/keuangan_uraian_penerimaan_qry_ri_umum.php');
include('keuangan/keuangan_uraian_penerimaan_qry_ok_umum.php');
include('keuangan/keuangan_uraian_penerimaan_qry_rj_kusta.php');
include('keuangan/keuangan_uraian_penerimaan_qry_ri_kusta.php');
include('keuangan/keuangan_uraian_penerimaan_qry_ok_kusta.php');

$qry_pembayaran .= '
					-- lain-lain
					UNION ALL
					SELECT "PENERIMAAN LAIN-LAIN" AS JENIS_PENERIMAAN,	
					UPPER(mtrg.NAMA_TARIF_GROUP) AS JNS_URAIAN,
					"" AS NAMA_UNIT,
					pnm.PIC AS URAIAN,	
					SUM(pnmt.KUANTITI) AS JUMLAH,
					SUM(pnmt.KUANTITI * mtr.TARIF_NON_KELAS) AS BIAYA
					FROM db_simkeu.r_penerimaan_lainlain pnm
					INNER JOIN db_simkeu.r_penerimaan_lainlain_tarif pnmt 
					ON (pnm.PENERIMAAN_LAINLAIN_ID = pnmt.PENERIMAAN_LAINLAIN_ID)
					INNER JOIN db_simrs.m_tarif mtr 
					ON (pnmt.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_tarif_group mtrg
					ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					WHERE 1
					' . (($jns_bayar != '1') ? 'AND pnm.PENERIMAAN_LAINLAIN_ID = "xyz"' : 'AND DATE(pnm.TANGGAL) >= ' . $tgl_filter_1 . ' 
						AND DATE(pnm.TANGGAL) <= ' . $tgl_filter_2) . '
					' . (($cash != '') ? ' AND pnm.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND pnm.KODE_REKENING = "' . $rekening . '" ' : '') . '
					AND pnm.NO_PEMBAYARAN IS NOT NULL
					GROUP BY mtrg.NAMA_TARIF_GROUP,pnm.PIC';
$no = 1;					
$jenis_penerimaan = '';
$jenis_uraian = '';
$nama_unit = '';
$total_per_penerimaan = 0;
$total_per_uraian = 0;
$total = 0;
$get_pembayaran = mysql_query($qry_pembayaran) or die(mysql_error());
while($dat_pembayaran = mysql_fetch_array($get_pembayaran)){
	if($dat_pembayaran['JNS_URAIAN'] != $jenis_uraian
		and $jenis_uraian != ''){
		?>
			<tr>
				<td scope="row" align="center">&nbsp;</td>
				<td><strong>TOTAL <?php echo $jenis_uraian; ?></strong></td>
				<td colspan="2" align="right"><?php echo currFormat($total_per_uraian); ?></td>
			</tr>
	<?php $total_per_uraian = 0;
	}
	
	if($dat_pembayaran['JENIS_PENERIMAAN'] != $jenis_penerimaan
		and $jenis_penerimaan != ''){
		?>
			<tr>
				<td scope="row" align="center">&nbsp;</td>
				<td><strong>TOTAL <?php echo $jenis_penerimaan; ?></strong></td>
				<td colspan="2" align="right"><?php echo currFormat($total_per_penerimaan); ?></td>
			</tr>
	<?php $total_per_penerimaan = 0; 
	}		
	
	if($dat_pembayaran['JENIS_PENERIMAAN'] != $jenis_penerimaan){
		$jenis_penerimaan = $dat_pembayaran['JENIS_PENERIMAAN'];
		?>
			<tr>
				<td scope="row" align="center">&nbsp;</td>
				<td colspan="3"><strong><?php echo $jenis_penerimaan; ?></strong></td>
			</tr>
		<?php	
	}

			
	
	if($dat_pembayaran['JNS_URAIAN'] != $jenis_uraian){
		$jenis_uraian = $dat_pembayaran['JNS_URAIAN'];
		$no = 1;
		?>
			<tr>
				<td scope="row" align="center">&nbsp;</td>
				<td colspan="3"><strong><?php echo $jenis_uraian; ?></strong></td>
			</tr>
		<?php	
	}	
	
	if($dat_pembayaran['NAMA_UNIT'] != $nama_unit){
		$nama_unit = $dat_pembayaran['NAMA_UNIT'];
		if($nama_unit != ''){
		?>
			<tr>
				<td scope="row" align="center">&nbsp;</td>
				<td><strong><?php echo strtoupper($nama_unit); ?></strong></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		<?php }	
	}
?>  
  <tr>
    <td scope="row" align="center"><?php echo $no; ?></td>
	<td><?php echo $dat_pembayaran['URAIAN']; ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['JUMLAH']); ?></td>
	<td align="right"><?php echo currFormat($dat_pembayaran['BIAYA']); ?></td>
  </tr>
 <?php 
	if($dat_pembayaran['URAIAN'] != 'RETURN OBAT'){
		$total_per_penerimaan = $total_per_penerimaan + $dat_pembayaran['BIAYA'];
		$total_per_uraian = $total_per_uraian + $dat_pembayaran['BIAYA'];
		$total = $total + $dat_pembayaran['BIAYA'];
	}else{
		$total_per_penerimaan = $total_per_penerimaan - $dat_pembayaran['BIAYA'];
		$total_per_uraian = $total_per_uraian - $dat_pembayaran['BIAYA'];
		$total = $total - $dat_pembayaran['BIAYA'];
	}
	
	$no++;  
} ?>
	<tr>
		<td scope="row" align="center">&nbsp;</td>
		<td><strong>TOTAL <?php echo $jenis_uraian; ?></strong></td>
		<td colspan="2" align="right"><?php echo currFormat($total_per_uraian); ?></td>
	</tr> 
	<tr>
		<td scope="row" align="center">&nbsp;</td>
		<td><strong>TOTAL <?php echo $jenis_penerimaan; ?></strong></td>
		<td colspan="2" align="right"><?php echo currFormat($total_per_penerimaan); ?></td>
	</tr>
	<tr>
		<td scope="row" align="center">&nbsp;</td>
		<td><strong>TOTAL PENERIMAAN</strong></td>
		<td colspan="2" align="right"><?php echo currFormat($total); ?></td>
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
	<input type="hidden" name="arr_psikologi" value="<?php echo str_replace('"','',$arr_psikologi); ?>" />
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
    <input type="hidden" name="xlsfile" value="keuangan/xls_report_uraian_penerimaan.php" />
    <input type="hidden" name="xlsname" value="rpt_uraian_penerimaan.xls" />            
</form>