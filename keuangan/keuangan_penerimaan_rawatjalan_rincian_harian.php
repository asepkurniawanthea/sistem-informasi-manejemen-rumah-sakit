<?php
//kode tarif group
$arr_karcis = '"01","92"';
$arr_konsul_dokter = '"02","09","93"';
$arr_operasi = '"58","59","60","61","62","63","64","65","66","67","68","69","70","71","72","73","74",
				"75","76","77","78","80","81","82","83","84","85","86","87","88","89","90","91","107",
				"108","109","110","111"';
$arr_tindakan_rj = '"03","04","10","11","12","07","14","38","94","95","08"';
$arr_hemodialisa = '"95"';
$arr_ambulace = '"49"';
$arr_jenazah = '"50"';

$arr_no['PENERIMAAN RAWAT JALAN'] = 'I';			
$arr_no['PENERIMAAN IGD'] = 'II';						
$arr_no['PENERIMAAN RAWAT JALAN KUSTA'] = 'III';

$bulan = '';
if (isset($_SESSION['pembayaranreportrincianharian_bulan']))
    $bulan = $_SESSION['pembayaranreportrincianharian_bulan'];
$tahun = '';
if (isset($_SESSION['pembayaranreportrincianharian_tahun']))
    $tahun = $_SESSION['pembayaranreportrincianharian_tahun'];
	
$jns_bayar = '';
if (isset($_SESSION['pembayaranreportrincianharian_jns_bayar']))
    $jns_bayar = $_SESSION['pembayaranreportrincianharian_jns_bayar'];	
	
if (isset($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
    $_SESSION['pembayaranreportrincianharian_bulan'] = $_GET['bulan'];
}
if (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $_SESSION['pembayaranreportrincianharian_tahun'] = $_GET['tahun'];
}

if (isset($_GET['jns_bayar'])) {
    $jns_bayar = $_GET['jns_bayar'];
    $_SESSION['pembayaranreportrincianharian_jns_bayar'] = $_GET['jns_bayar'];
}

if($bulan=='') $bulan = substr('00',0,2-strlen(date('m'))) . date('m');
if($tahun=='') $tahun = date('Y');

$jns_bayar_filter = '';
$jns_bayar_filter_2 = '';
$jns_bayar_filter_3 = '';
$jns_bayar_filter_4 = '';
if($jns_bayar!= ''){
	$jns_bayar_filter = 'AND t_irja.JENIS_BAYAR_ID = "' . $jns_bayar . '"'; 
	$jns_bayar_filter_2 = 'AND t_ipenunjang_tarif.JENIS_BAYAR_ID = "' . $jns_bayar . '"'; 
	$jns_bayar_filter_3 = 'AND t_hemodialisa.JENIS_BAYAR_ID = "' . $jns_bayar . '"'; 
	$jns_bayar_filter_4 = 'AND irj.JENIS_BAYAR_ID = "' . $jns_bayar . '"'; 
}
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
         <tr>
            <td>Jenis Pembayaran</td>
            <td>
			<select name="jns_bayar" class="text_dt" style="width:160px;" >
			<option value="" > - </option>
			<?php echo getJnsBayar($jns_bayar,'1');?>
			</select></td>
       </tr>
		<tr>
            <td>Bulan</td>
            <td><select name="bulan" class="text_dt" style="width:160px;" >
			<option value="" > - </option>
			<option value="01" <?php if($bulan=='01') echo 'selected="selected"'; ?> >Januari</option>
			<option value="02" <?php if($bulan=='02') echo 'selected="selected"'; ?> >Pebruari</option>
			<option value="03" <?php if($bulan=='03') echo 'selected="selected"'; ?> >Maret</option>
			<option value="04" <?php if($bulan=='04') echo 'selected="selected"'; ?> >April</option>
			<option value="05" <?php if($bulan=='05') echo 'selected="selected"'; ?> >Mei</option>
			<option value="06" <?php if($bulan=='06') echo 'selected="selected"'; ?> >Juni</option>
			<option value="07" <?php if($bulan=='07') echo 'selected="selected"'; ?> >Juli</option>
			<option value="08" <?php if($bulan=='08') echo 'selected="selected"'; ?> >Agustus</option>
			<option value="09" <?php if($bulan=='09') echo 'selected="selected"'; ?> >September</option>
			<option value="10" <?php if($bulan=='10') echo 'selected="selected"'; ?> >Oktober</option>
			<option value="11" <?php if($bulan=='11') echo 'selected="selected"'; ?> >Nopember</option>
			<option value="12" <?php if($bulan=='12') echo 'selected="selected"'; ?> >Desember</option>
			</select></td>
       </tr>
		<tr>
			<td>Tahun</td>
            <td><select name="tahun" class="text_dt" style="width:160px;" >
			<option value="" > - </option>
			<option value="2017" <?php if($tahun=='2017') echo 'selected="selected"'; ?> >2017</option>
			<option value="2018" <?php if($tahun=='2018') echo 'selected="selected"'; ?> >2018</option>
			<option value="2019" <?php if($tahun=='2019') echo 'selected="selected"'; ?> >2019</option>
			<option value="2020" <?php if($tahun=='2020') echo 'selected="selected"'; ?> >2020</option>
			<option value="2021" <?php if($tahun=='2021') echo 'selected="selected"'; ?> >2021</option>
			<option value="2022" <?php if($tahun=='2022') echo 'selected="selected"'; ?> >2022</option>
			</select></td>	
			<td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php 
$sql_lastday = 'SELECT DATE_FORMAT(LAST_DAY(STR_TO_DATE("01' . $bulan . $tahun . '","%d%m%Y")),"%d") AS LD FROM DUAL';
$get_lastday = mysql_query($sql_lastday) or die(mysql_error());
$dat_lastday = mysql_fetch_assoc($get_lastday);
$hari = $dat_lastday['LD'];
$sql_lastweek = 'SELECT WEEK(STR_TO_DATE("' . $hari . $bulan . $tahun . '","%d%m%Y"),5) - 
				WEEK(DATE_SUB(STR_TO_DATE("' . $hari . $bulan . $tahun . '","%d%m%Y"), 
				INTERVAL DAYOFMONTH(STR_TO_DATE("' . $hari . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS LW FROM DUAL';
$get_lastweek = mysql_query($sql_lastweek) or die(mysql_error());
$dat_lastweek = mysql_fetch_assoc($get_lastweek);
$minggu = $dat_lastweek['LW'];

$arr_wom = array();
$sql_wom = 'SELECT WEEK(STR_TO_DATE("01' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("01' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("01' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_01, 
					WEEK(STR_TO_DATE("02' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("02' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("02' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_02, 
					WEEK(STR_TO_DATE("03' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("03' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("03' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_03, 
					WEEK(STR_TO_DATE("04' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("04' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("04' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_04, 
					WEEK(STR_TO_DATE("05' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("05' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("05' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_05, 
					WEEK(STR_TO_DATE("06' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("06' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("06' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_06, 
					WEEK(STR_TO_DATE("07' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("07' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("07' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_07, 
					WEEK(STR_TO_DATE("08' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("08' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("08' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_08, 
					WEEK(STR_TO_DATE("09' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("09' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("09' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_09, 
					WEEK(STR_TO_DATE("10' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("10' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("10' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_10, 
					WEEK(STR_TO_DATE("11' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("11' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("11' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_11, 
					WEEK(STR_TO_DATE("12' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("12' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("12' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_12, 
					WEEK(STR_TO_DATE("13' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("13' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("13' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_13, 
					WEEK(STR_TO_DATE("14' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("14' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("14' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_14, 
					WEEK(STR_TO_DATE("15' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("15' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("15' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_15, 
					WEEK(STR_TO_DATE("16' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("16' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("16' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_16, 
					WEEK(STR_TO_DATE("17' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("17' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("17' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_17, 
					WEEK(STR_TO_DATE("18' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("18' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("18' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_18, 
					WEEK(STR_TO_DATE("19' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("19' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("19' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_19, 
					WEEK(STR_TO_DATE("20' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("20' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("20' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_20, 
					WEEK(STR_TO_DATE("21' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("21' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("21' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_21, 
					WEEK(STR_TO_DATE("22' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("22' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("22' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_22, 
					WEEK(STR_TO_DATE("23' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("23' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("23' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_23, 
					WEEK(STR_TO_DATE("24' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("24' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("24' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_24, 
					WEEK(STR_TO_DATE("25' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("25' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("25' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_25, 
					WEEK(STR_TO_DATE("26' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("26' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("26' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_26, 
					WEEK(STR_TO_DATE("27' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("27' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("27' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_27, 
					WEEK(STR_TO_DATE("28' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("28' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("28' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_28, 
					WEEK(STR_TO_DATE("29' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("29' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("29' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_29, 
					WEEK(STR_TO_DATE("30' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("30' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("30' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_30, 
					WEEK(STR_TO_DATE("31' . $bulan . $tahun . '","%d%m%Y"),5) - WEEK(DATE_SUB(STR_TO_DATE("31' . $bulan . $tahun . '","%d%m%Y"), 
					INTERVAL DAYOFMONTH(STR_TO_DATE("31' . $bulan . $tahun . '","%d%m%Y"))-1 DAY),5)+1 AS WOM_31
			FROM DUAL';
$get_wom = mysql_query($sql_wom) or die(mysql_error());	
$dat_wom = mysql_fetch_assoc($get_wom);		
$x = 1;
while($x <= $hari){
	$xf = substr('00',0,2 - strlen($x)) . $x;
	$arr_wom[$x] = $dat_wom['WOM_' . $xf]; 
$x++;
}

$cn_fh = $hari * 2;
$cn_field = ($hari * 2) + ($minggu * 2) + (1 * 2);
?>
<table width="100%" border="1" class="tableData" id="tfhover">
  <tr>
    <th rowspan="2">No</th>
	<th colspan="4" rowspan="2">URAIAN PENERIMAAN </th>
	<?php
   $wm = 0;
   for($f=1;$f<=$hari;$f++){ 
	   if($wm != 0 and ($wm != $arr_wom[$f])){
		   echo  '<th colspan="2">PEKAN ' . substr('00',0,2 - strlen($wm)) . $wm . '</th>';
	   }		
	   if($wm != $arr_wom[$f]) $wm = $arr_wom[$f];
	   echo '<th colspan="2">' . substr('00',0,2 - strlen($f)) . $f . '</th>';
   } ?>
   <th colspan="2">PEKAN 0<?php echo $minggu; ?></th>
   <th colspan="2">PER BULAN</th>
  </tr><tr>
  <?php
	$wm = 0;
    for($f=1;$f<=$hari;$f++){
		if($wm != 0 and ($wm != $arr_wom[$f])){
		   echo  '<th>Jml</th>
		<th>Biaya</th>';
		}		
		if($wm != $arr_wom[$f]) $wm = $arr_wom[$f];
		echo  '<th>Jml</th>
		<th>Biaya</th>';
	} ?>
		<th>Jml</th>
		<th>Biaya</th>
		<th>Jml</th>
		<th>Biaya</th>
   </tr>
  <tr>
     <td>&nbsp;</td>
     <td colspan="4">PASIEN <?php $sql_jaminan = 'SELECT NAMA_JAMINAN FROM m_jaminan WHERE JAMINAN_ID = "' . $jns_bayar . '"';
				$get_jaminan = mysql_query($sql_jaminan) or die(mysql_error());
				$dat_jaminan = mysql_fetch_assoc($get_jaminan);
				echo strtoupper($dat_jaminan['NAMA_JAMINAN']); ?></td>
	<td colspan="<?php echo $cn_field; ?>">&nbsp;</td>			
   </tr>
<?php 
$qry_pembayaran = 'SELECT tp_main.URUT,tp_main.NAMA_PERNERIMAAN,
					tp_main.NAMA_TARIF_GROUP,tp_main.NAMA_TARIF,
					tp_main.NAMA_UNIT,tp_main.NAMA_RUANG,tp_main.NAMA_DOKTER,
					tp_main.KTY_01,tp_main.KTY_02,tp_main.KTY_03,tp_main.KTY_04,
					tp_main.KTY_05,tp_main.KTY_06,tp_main.KTY_07,tp_main.KTY_08,
					tp_main.KTY_09,tp_main.KTY_10,tp_main.KTY_11,tp_main.KTY_12,
					tp_main.KTY_13,tp_main.KTY_14,tp_main.KTY_15,tp_main.KTY_15,
					tp_main.KTY_16,tp_main.KTY_17,tp_main.KTY_18,tp_main.KTY_19,
					tp_main.KTY_20,tp_main.KTY_21,tp_main.KTY_22,tp_main.KTY_23,
					tp_main.KTY_24,tp_main.KTY_25,tp_main.KTY_26,tp_main.KTY_27,
					tp_main.KTY_28,tp_main.KTY_29,tp_main.KTY_30,tp_main.KTY_31,
					tp_main.HRG_01,tp_main.HRG_02,tp_main.HRG_03,tp_main.HRG_04,
					tp_main.HRG_05,tp_main.HRG_06,tp_main.HRG_07,tp_main.HRG_08,
					tp_main.HRG_09,tp_main.HRG_10,tp_main.HRG_11,tp_main.HRG_12,
					tp_main.HRG_13,tp_main.HRG_14,tp_main.HRG_15,tp_main.HRG_15,
					tp_main.HRG_16,tp_main.HRG_17,tp_main.HRG_18,tp_main.HRG_19,
					tp_main.HRG_20,tp_main.HRG_21,tp_main.HRG_22,tp_main.HRG_23,
					tp_main.HRG_24,tp_main.HRG_25,tp_main.HRG_26,tp_main.HRG_27,
					tp_main.HRG_28,tp_main.HRG_29,tp_main.HRG_30,tp_main.HRG_31,
					tp_main.KTW_01,tp_main.KTW_02,tp_main.KTW_03,tp_main.KTW_04,
					tp_main.KTW_05,tp_main.HRW_01,tp_main.HRW_02,tp_main.HRW_03,
					tp_main.HRW_04,tp_main.HRW_05,tp_main.SBL,tp_main.HBL
					FROM (
					SELECT tp.URUT,tp.NAMA_PERNERIMAAN,
					tp.NAMA_TARIF_GROUP,tp.NAMA_TARIF,m_unit.NAMA_UNIT,
					CONCAT(m_ruang.NAMA_RUANG," Kls ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
					CASE WHEN m_pegawai2.NAMA_PEGAWAI IS NOT NULL OR m_pegawai.NAMA_PEGAWAI IS NOT NULL THEN
						CASE WHEN m_pegawai2.NAMA_PEGAWAI IS NULL THEN m_pegawai.NAMA_PEGAWAI
							ELSE m_pegawai2.NAMA_PEGAWAI END 
					ELSE "-" END AS NAMA_DOKTER,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "01" THEN tp.KUANTITI ELSE 0 END) AS KTY_01,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "02" THEN tp.KUANTITI ELSE 0 END) AS KTY_02,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "03" THEN tp.KUANTITI ELSE 0 END) AS KTY_03,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "04" THEN tp.KUANTITI ELSE 0 END) AS KTY_04,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "05" THEN tp.KUANTITI ELSE 0 END) AS KTY_05,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "06" THEN tp.KUANTITI ELSE 0 END) AS KTY_06,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "07" THEN tp.KUANTITI ELSE 0 END) AS KTY_07,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "08" THEN tp.KUANTITI ELSE 0 END) AS KTY_08,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "09" THEN tp.KUANTITI ELSE 0 END) AS KTY_09,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "10" THEN tp.KUANTITI ELSE 0 END) AS KTY_10,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "11" THEN tp.KUANTITI ELSE 0 END) AS KTY_11,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "12" THEN tp.KUANTITI ELSE 0 END) AS KTY_12,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "13" THEN tp.KUANTITI ELSE 0 END) AS KTY_13,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "14" THEN tp.KUANTITI ELSE 0 END) AS KTY_14,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "15" THEN tp.KUANTITI ELSE 0 END) AS KTY_15,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "16" THEN tp.KUANTITI ELSE 0 END) AS KTY_16,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "17" THEN tp.KUANTITI ELSE 0 END) AS KTY_17,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "18" THEN tp.KUANTITI ELSE 0 END) AS KTY_18,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "19" THEN tp.KUANTITI ELSE 0 END) AS KTY_19,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "20" THEN tp.KUANTITI ELSE 0 END) AS KTY_20,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "21" THEN tp.KUANTITI ELSE 0 END) AS KTY_21,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "22" THEN tp.KUANTITI ELSE 0 END) AS KTY_22,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "23" THEN tp.KUANTITI ELSE 0 END) AS KTY_23,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "24" THEN tp.KUANTITI ELSE 0 END) AS KTY_24,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "25" THEN tp.KUANTITI ELSE 0 END) AS KTY_25,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "26" THEN tp.KUANTITI ELSE 0 END) AS KTY_26,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "27" THEN tp.KUANTITI ELSE 0 END) AS KTY_27,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "28" THEN tp.KUANTITI ELSE 0 END) AS KTY_28,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "29" THEN tp.KUANTITI ELSE 0 END) AS KTY_29,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "30" THEN tp.KUANTITI ELSE 0 END) AS KTY_30,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "31" THEN tp.KUANTITI ELSE 0 END) AS KTY_31,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "01" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_01,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "02" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_02,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "03" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_03,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "04" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_04,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "05" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_05,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "06" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_06,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "07" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_07,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "08" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_08,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "09" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_09,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "10" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_10,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "11" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_11,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "12" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_12,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "13" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_13,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "14" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_14,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "15" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_15,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "16" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_16,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "17" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_17,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "18" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_18,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "19" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_19,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "20" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_20,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "21" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_21,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "22" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_22,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "23" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_23,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "24" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_24,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "25" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_25,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "26" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_26,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "27" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_27,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "28" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_28,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "29" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_29,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "30" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_30,
					SUM(CASE WHEN DATE_FORMAT(tp.TGL_MASUK,"%d") = "31" THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRG_31,
					SUM(CASE WHEN WEEK(tp.TGL_MASUK,5) - WEEK(DATE_SUB(tp.TGL_MASUK, INTERVAL DAYOFMONTH(tp.TGL_MASUK)-1 DAY),5)+1  = 1 
					THEN tp.KUANTITI ELSE 0 END) AS KTW_01,
					SUM(CASE WHEN WEEK(tp.TGL_MASUK,5) - WEEK(DATE_SUB(tp.TGL_MASUK, INTERVAL DAYOFMONTH(tp.TGL_MASUK)-1 DAY),5)+1  = 2 
					THEN tp.KUANTITI ELSE 0 END) AS KTW_02,
					SUM(CASE WHEN WEEK(tp.TGL_MASUK,5) - WEEK(DATE_SUB(tp.TGL_MASUK, INTERVAL DAYOFMONTH(tp.TGL_MASUK)-1 DAY),5)+1  = 3
					THEN tp.KUANTITI ELSE 0 END) AS KTW_03,
					SUM(CASE WHEN WEEK(tp.TGL_MASUK,5) - WEEK(DATE_SUB(tp.TGL_MASUK, INTERVAL DAYOFMONTH(tp.TGL_MASUK)-1 DAY),5)+1  = 4
					THEN tp.KUANTITI ELSE 0 END) AS KTW_04,
					SUM(CASE WHEN WEEK(tp.TGL_MASUK,5) - WEEK(DATE_SUB(tp.TGL_MASUK, INTERVAL DAYOFMONTH(tp.TGL_MASUK)-1 DAY),5)+1  = 5
					THEN tp.KUANTITI ELSE 0 END) AS KTW_05,
					SUM(CASE WHEN WEEK(tp.TGL_MASUK,5) - WEEK(DATE_SUB(tp.TGL_MASUK, INTERVAL DAYOFMONTH(tp.TGL_MASUK)-1 DAY),5)+1  = 1 THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRW_01,
					SUM(CASE WHEN WEEK(tp.TGL_MASUK,5) - WEEK(DATE_SUB(tp.TGL_MASUK, INTERVAL DAYOFMONTH(tp.TGL_MASUK)-1 DAY),5)+1  = 2 THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRW_02,
					SUM(CASE WHEN WEEK(tp.TGL_MASUK,5) - WEEK(DATE_SUB(tp.TGL_MASUK, INTERVAL DAYOFMONTH(tp.TGL_MASUK)-1 DAY),5)+1  = 3 THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRW_03,
					SUM(CASE WHEN WEEK(tp.TGL_MASUK,5) - WEEK(DATE_SUB(tp.TGL_MASUK, INTERVAL DAYOFMONTH(tp.TGL_MASUK)-1 DAY),5)+1  = 4 THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRW_04,
					SUM(CASE WHEN WEEK(tp.TGL_MASUK,5) - WEEK(DATE_SUB(tp.TGL_MASUK, INTERVAL DAYOFMONTH(tp.TGL_MASUK)-1 DAY),5)+1  = 5 THEN 
						CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END 
					ELSE 0 END) AS HRW_05,
					SUM(tp.KUANTITI) AS SBL,
					SUM(CASE WHEN tp.KELAS IS NULL THEN tp.KUANTITI * tp.TARIF_NON_KELAS 
						ELSE 
							CASE WHEN tp.NON_KELAS IS NULL OR tp.NON_KELAS = "" THEN
								CASE WHEN tp.KELAS = "3" THEN tp.KUANTITI * tp.TARIF_KELAS_3
									WHEN tp.KELAS = "2" THEN tp.KUANTITI * tp.TARIF_KELAS_2
									WHEN tp.KELAS = "1" THEN tp.KUANTITI * tp.TARIF_KELAS_1
									WHEN (UPPER(tp.KELAS) = "UTAMA" OR UPPER(tp.KELAS) = "VIP") 
										THEN tp.KUANTITI * tp.TARIF_KELAS_UTAMA
									WHEN UPPER(tp.KELAS) = "HCU" THEN tp.KUANTITI * tp.TARIF_HCU	
									WHEN UPPER(tp.KELAS) = "BAYI SEHAT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SEHAT
									WHEN UPPER(tp.KELAS) = "BAYI SAKIT" THEN tp.KUANTITI * tp.TARIF_KELAS_PERINA_SAKIT
								END 
							ELSE tp.KUANTITI * tp.TARIF_NON_KELAS END	
						END) AS HBL
					FROM (SELECT "01" AS URUT,"PENERIMAAN RAWAT JALAN" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					t_irja.TANGGAL_DAFTAR AS TGL_MASUK,NULL AS PEGAWAI_PELAKSANA_ID,
					t_irja_tarif.KUANTITI,m_tarif_group.NAMA_TARIF_GROUP,
					m_tarif_group.NON_KELAS,m_tarif.NAMA_TARIF,
					m_tarif.TARIF_NON_KELAS,m_tarif.TARIF_KELAS_3,m_tarif.TARIF_KELAS_2,
					m_tarif.TARIF_KELAS_1,m_tarif.TARIF_KELAS_UTAMA,m_tarif.TARIF_KELAS_PERINA_SEHAT,
					m_tarif.TARIF_KELAS_PERINA_SAKIT,m_tarif.TARIF_HCU
					FROM t_irja
					INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
					AND (t_irja.MCU IS NULL OR t_irja.MCU = "")
					AND t_irja.UNIT_ID <> 9 AND t_irja.UNIT_ID <> 35 ' . $jns_bayar_filter . '
					AND t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BATAL IS NULL
					AND m_tarif_group.KODE_TARIF_GROUP IN (' . $arr_karcis . ')
					UNION ALL
					SELECT "02" AS URUT,"PENERIMAAN RAWAT JALAN" AS NAMA_PERNERIMAAN,
					t_irja.UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,t_irja.PEGAWAI_ID,
					t_irja.TANGGAL_DAFTAR AS TGL_MASUK,t_irja_tarif.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
					t_irja_tarif.KUANTITI,m_tarif_group.NAMA_TARIF_GROUP,
					m_tarif_group.NON_KELAS,"" AS NAMA_TARIF,
					m_tarif.TARIF_NON_KELAS,m_tarif.TARIF_KELAS_3,m_tarif.TARIF_KELAS_2,
					m_tarif.TARIF_KELAS_1,m_tarif.TARIF_KELAS_UTAMA,m_tarif.TARIF_KELAS_PERINA_SEHAT,
					m_tarif.TARIF_KELAS_PERINA_SAKIT,m_tarif.TARIF_HCU
					FROM t_irja
					INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
					AND (t_irja.MCU IS NULL OR t_irja.MCU = "")
					AND t_irja.UNIT_ID <> 9 AND t_irja.UNIT_ID <> 35 ' . $jns_bayar_filter . '
					AND t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BATAL IS NULL
					AND m_tarif.KODE_TARIF_GROUP IN (' . $arr_konsul_dokter . ')
					UNION ALL
					SELECT "03" AS URUT,"PENERIMAAN RAWAT JALAN" AS NAMA_PERNERIMAAN,
					t_irja.UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					t_irja.TANGGAL_DAFTAR AS TGL_MASUK,t_irja_tarif.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
					t_irja_tarif.KUANTITI,"TINDAKAN RAWAT JALAN" AS NAMA_TARIF_GROUP,
					m_tarif_group.NON_KELAS,"" AS NAMA_TARIF,
					m_tarif.TARIF_NON_KELAS,m_tarif.TARIF_KELAS_3,m_tarif.TARIF_KELAS_2,
					m_tarif.TARIF_KELAS_1,m_tarif.TARIF_KELAS_UTAMA,m_tarif.TARIF_KELAS_PERINA_SEHAT,
					m_tarif.TARIF_KELAS_PERINA_SAKIT,m_tarif.TARIF_HCU
					FROM t_irja
					INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
					AND (t_irja.MCU IS NULL OR t_irja.MCU = "")
					AND t_irja.UNIT_ID <> 9 AND t_irja.UNIT_ID <> 35 ' . $jns_bayar_filter . '
					AND t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BATAL IS NULL
					AND m_tarif.KODE_TARIF_GROUP IN (' . $arr_tindakan_rj . ')
					UNION ALL
					SELECT "04" AS URUT,"PENERIMAAN RAWAT JALAN" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					irj.TANGGAL_DAFTAR AS TGL_MASUK,NULL AS PEGAWAI_PELAKSANA_ID,
					1 AS KUANTITI,"MEDICAL CHECKUP" AS NAMA_TARIF_GROUP,
					m_tarif_group.NON_KELAS,irj.NAMA_TARIF,
					SUM(m_tarif.TARIF_NON_KELAS) AS TARIF_NON_KELAS,SUM(m_tarif.TARIF_KELAS_3) AS TARIF_KELAS_3,
					SUM(m_tarif.TARIF_KELAS_2) AS TARIF_KELAS_2,SUM(m_tarif.TARIF_KELAS_1) AS TARIF_KELAS_1,
					SUM(m_tarif.TARIF_KELAS_UTAMA) AS TARIF_KELAS_UTAMA,SUM(m_tarif.TARIF_KELAS_PERINA_SEHAT) AS TARIF_KELAS_PERINA_SEHAT,
					SUM(m_tarif.TARIF_KELAS_PERINA_SAKIT) AS TARIF_KELAS_PERINA_SAKIT,SUM(m_tarif.TARIF_HCU) AS TARIF_HCU
					FROM (
						SELECT MIN(t_irja.IRJA_ID) AS IRJA_ID,
						t_irja.TANGGAL_DAFTAR,"102" COLLATE utf8_general_ci AS KODE_TARIF_GROUP,
						"MEDICAL CHECKUP PAKET A" AS NAMA_TARIF
 						FROM t_irja
						WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
						AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
						AND t_irja.MCU = "mcu1" ' . $jns_bayar_filter . '
						GROUP BY t_irja.NOMR,t_irja.TANGGAL_DAFTAR
						UNION ALL
						SELECT MIN(t_irja.IRJA_ID) AS IRJA_ID,
						t_irja.TANGGAL_DAFTAR,"103" COLLATE utf8_general_ci AS KODE_TARIF_GROUP,
						"MEDICAL CHECKUP PAKET B" AS NAMA_TARIF
						FROM t_irja
						WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
						AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
						AND t_irja.MCU = "mcu2" ' . $jns_bayar_filter . '
						GROUP BY t_irja.NOMR,t_irja.TANGGAL_DAFTAR
					) irj
					INNER JOIN m_tarif_group ON (irj.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					INNER JOIN m_tarif ON (m_tarif_group.KODE_TARIF_GROUP = m_tarif.KODE_TARIF_GROUP
					AND m_tarif.ST_AKTIF = "1")
					GROUP BY irj.IRJA_ID
					UNION ALL
					SELECT "05" AS URUT,"PENERIMAAN RAWAT JALAN" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					irj.TANGGAL_DAFTAR AS TGL_MASUK,NULL AS PEGAWAI_PELAKSANA_ID,
					1 AS KUANTITI,"APOTIK RAWAT JALAN" AS NAMA_TARIF_GROUP,
					1 AS NON_KELAS,"PENERIMAAN RESEP" AS NAMA_TARIF,
					SUM(aptk_detail.HARGA_JUAL * aptk_detail.JUMLAH_KELUAR) AS TARIF_NON_KELAS,
					0 AS TARIF_KELAS_3,0 AS TARIF_KELAS_2,
					0 AS TARIF_KELAS_1,0 AS TARIF_KELAS_UTAMA,0 AS TARIF_KELAS_PERINA_SEHAT,
					0 AS TARIF_KELAS_PERINA_SAKIT,0 AS TARIF_HCU
					FROM db_inventorirs.t_farmasi_apotik_pengeluaran aptk  
					INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail aptk_detail 
					ON (aptk.FARMASI_PENGELUARAN_APOTIK_ID = aptk_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN db_inventorirs.t_rajal_resep_detail rsp_detail 
					ON (aptk_detail.RAJAL_RESEP_DETAIL_ID = rsp_detail.RAJAL_RESEP_DETAIL_ID)
					INNER JOIN db_inventorirs.t_rajal_resep rsp 
					ON (rsp_detail.RAJAL_RESEP_ID = rsp.RAJAL_RESEP_ID)
					INNER JOIN db_simrs.t_irja irj
					ON (aptk.RAJAL_ID = irj.IRJA_ID)
					WHERE aptk.NO_PENGELUARAN IS NOT NULL 
					AND aptk.JENIS_PENGELUARAN = "1"
					AND DATE_FORMAT(irj.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					' . $jns_bayar_filter_4 . '
					AND irj.UNIT_ID <> 9 AND irj.UNIT_ID <> 35
					GROUP BY irj.IRJA_ID,aptk.FARMASI_PENGELUARAN_APOTIK_ID,aptk.NO_RESEP
					UNION ALL
					SELECT "05" AS URUT,"PENERIMAAN RAWAT JALAN" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					irj.TANGGAL_DAFTAR AS TGL_MASUK,NULL AS PEGAWAI_PELAKSANA_ID,
					1 AS KUANTITI,"APOTIK RAWAT JALAN" AS NAMA_TARIF_GROUP,
					1 AS NON_KELAS,"RETURN RESEP" AS NAMA_TARIF,
					SUM(pgml_detail.HARGA_JUAL * pgml_detail.JUMLAH_KEMBALI) AS TARIF_NON_KELAS,
					0 AS TARIF_KELAS_3,0 AS TARIF_KELAS_2,
					0 AS TARIF_KELAS_1,0 AS TARIF_KELAS_UTAMA,0 AS TARIF_KELAS_PERINA_SEHAT,
					0 AS TARIF_KELAS_PERINA_SAKIT,0 AS TARIF_HCU
					FROM db_inventorirs.t_farmasi_apotik_pengembalian_resep pgml 
					INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep_detail pgml_detail
					ON (pgml.FARMASI_PENGEMBALIAN_APOTIK_ID = pgml_detail.FARMASI_PENGEMBALIAN_ID)
					INNER JOIN db_simrs.t_irja irj
					ON (pgml.RAJAL_ID = irj.IRJA_ID)
					WHERE pgml.NO_PENGEMBALIAN IS NOT NULL 
					AND pgml.JENIS_PENGEMBALIAN = "1"
					AND DATE_FORMAT(irj.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					' . $jns_bayar_filter_4 . '
					AND irj.UNIT_ID <> 9 AND irj.UNIT_ID <> 35
					GROUP BY irj.IRJA_ID,pgml.FARMASI_PENGEMBALIAN_APOTIK_ID
					UNION ALL
					SELECT "06" AS URUT,"PENERIMAAN RAWAT JALAN" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d%m%Y"),"%d%m%Y") AS TGL_MASUK,
					NULL AS PEGAWAI_PELAKSANA_ID,1 AS KUANTITI,
					"PENUNJANG RAWAT JALAN" AS NAMA_TARIF_GROUP,m_tarif_group.NON_KELAS,
					"LABORATORIUM" AS NAMA_TARIF,
					SUM(m_tarif.TARIF_NON_KELAS) AS NON_KELAS,SUM(m_tarif.TARIF_KELAS_3) AS TARIF_KELAS_3,
					SUM(m_tarif.TARIF_KELAS_2) AS TARIF_KELAS_2,SUM(m_tarif.TARIF_KELAS_1) AS TARIF_KELAS_1,
					SUM(m_tarif.TARIF_KELAS_UTAMA) AS TARIF_KELAS_UTAMA,SUM(m_tarif.TARIF_KELAS_PERINA_SEHAT) TARIF_KELAS_PERINA_SEHAT,
					SUM(m_tarif.TARIF_KELAS_PERINA_SAKIT) AS TARIF_KELAS_PERINA_SAKIT,SUM(m_tarif.TARIF_HCU) AS TARIF_HCU
					FROM t_irja 
					INNER JOIN t_ipenunjang ON (t_irja.IRJA_ID = t_ipenunjang.RAWAT_ID)
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '"  
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
					' . $jns_bayar_filter_2 . '
					AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ") 
					AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1")
					AND (t_irja.MCU IS NULL OR t_irja.MCU = "") 
					AND t_irja.UNIT_ID <> 9 AND t_irja.UNIT_ID <> 35
					GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF
					UNION ALL
					SELECT "06" AS URUT,"PENERIMAAN RAWAT JALAN" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d%m%Y"),"%d%m%Y") AS TGL_MASUK,
					NULL AS PEGAWAI_PELAKSANA_ID,1 AS KUANTITI,
					"PENUNJANG RAWAT JALAN" AS NAMA_TARIF_GROUP,m_tarif_group.NON_KELAS,
					"RADIOLOGI" AS NAMA_TARIF,
					SUM(m_tarif.TARIF_NON_KELAS) AS NON_KELAS,SUM(m_tarif.TARIF_KELAS_3) AS TARIF_KELAS_3,
					SUM(m_tarif.TARIF_KELAS_2) AS TARIF_KELAS_2,SUM(m_tarif.TARIF_KELAS_1) AS TARIF_KELAS_1,
					SUM(m_tarif.TARIF_KELAS_UTAMA) AS TARIF_KELAS_UTAMA,SUM(m_tarif.TARIF_KELAS_PERINA_SEHAT) TARIF_KELAS_PERINA_SEHAT,
					SUM(m_tarif.TARIF_KELAS_PERINA_SAKIT) AS TARIF_KELAS_PERINA_SAKIT,SUM(m_tarif.TARIF_HCU) AS TARIF_HCU
					FROM t_irja 
					INNER JOIN t_ipenunjang ON (t_irja.IRJA_ID = t_ipenunjang.RAWAT_ID)
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '"  
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
					' . $jns_bayar_filter_2 . '
					AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ") 
					AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1")
					AND (t_irja.MCU IS NULL OR t_irja.MCU = "") 
					AND t_irja.UNIT_ID <> 9 AND t_irja.UNIT_ID <> 35
					GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF
					UNION ALL
					SELECT "06" AS URUT,"PENERIMAAN RAWAT JALAN" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d%m%Y"),"%d%m%Y") AS TGL_MASUK,
					NULL AS PEGAWAI_PELAKSANA_ID,1 AS KUANTITI,
					"PENUNJANG RAWAT JALAN" AS NAMA_TARIF_GROUP,m_tarif_group.NON_KELAS,
					m_unit.NAMA_UNIT AS NAMA_TARIF,
					SUM(m_tarif.TARIF_NON_KELAS) AS NON_KELAS,SUM(m_tarif.TARIF_KELAS_3) AS TARIF_KELAS_3,
					SUM(m_tarif.TARIF_KELAS_2) AS TARIF_KELAS_2,SUM(m_tarif.TARIF_KELAS_1) AS TARIF_KELAS_1,
					SUM(m_tarif.TARIF_KELAS_UTAMA) AS TARIF_KELAS_UTAMA,SUM(m_tarif.TARIF_KELAS_PERINA_SEHAT) TARIF_KELAS_PERINA_SEHAT,
					SUM(m_tarif.TARIF_KELAS_PERINA_SAKIT) AS TARIF_KELAS_PERINA_SAKIT,SUM(m_tarif.TARIF_HCU) AS TARIF_HCU
					FROM t_irja 
					INNER JOIN t_ipenunjang ON (t_irja.IRJA_ID = t_ipenunjang.RAWAT_ID)
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					INNER JOIN m_unit ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
					WHERE DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '"  
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
					' . $jns_bayar_filter_2 . '
					AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ") 
					AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (52,31,41,42,47,40,51)
					AND (t_irja.MCU IS NULL OR t_irja.MCU = "") 
					AND t_irja.UNIT_ID <> 9 AND t_irja.UNIT_ID <> 35
					GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
					UNION ALL
					SELECT "06" AS URUT,"PENERIMAAN RAWAT JALAN" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					t_irja.TANGGAL_DAFTAR AS TGL_MASUK,NULL AS PEGAWAI_PELAKSANA_ID,
					t_irja_tarif.KUANTITI,"PENUNJANG RAWAT JALAN" AS NAMA_TARIF_GROUP,
					m_tarif_group.NON_KELAS,"Hemodialisa" AS NAMA_TARIF,
					m_tarif.TARIF_NON_KELAS,m_tarif.TARIF_KELAS_3,m_tarif.TARIF_KELAS_2,
					m_tarif.TARIF_KELAS_1,m_tarif.TARIF_KELAS_UTAMA,m_tarif.TARIF_KELAS_PERINA_SEHAT,
					m_tarif.TARIF_KELAS_PERINA_SAKIT,m_tarif.TARIF_HCU
					FROM t_irja
					INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
					AND (t_irja.MCU IS NULL OR t_irja.MCU = "")
					AND t_irja.UNIT_ID <> 9 AND t_irja.UNIT_ID <> 35 ' . $jns_bayar_filter . '
					AND t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BATAL IS NULL
					AND m_tarif.KODE_TARIF_GROUP IN (' . $arr_hemodialisa . ')
					UNION ALL
					SELECT "06" AS URUT,"PENERIMAAN RAWAT JALAN" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d%m%Y"),"%d%m%Y") AS TGL_MASUK,
					NULL AS PEGAWAI_PELAKSANA_ID,
					t_hemodialisa_tarif.KUANTITI,"PENUNJANG RAWAT JALAN" AS NAMA_TARIF_GROUP,
					m_tarif_group.NON_KELAS,"Hemodialisa" AS NAMA_TARIF,
					m_tarif.TARIF_NON_KELAS,m_tarif.TARIF_KELAS_3,m_tarif.TARIF_KELAS_2,
					m_tarif.TARIF_KELAS_1,m_tarif.TARIF_KELAS_UTAMA,m_tarif.TARIF_KELAS_PERINA_SEHAT,
					m_tarif.TARIF_KELAS_PERINA_SAKIT,m_tarif.TARIF_HCU
					FROM t_hemodialisa
					INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
					INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%m%Y") = "' . $bulan . $tahun . '" 
					AND t_hemodialisa.NO_ORDER IS NOT NULL AND t_hemodialisa.ST_BATAL IS NULL
					' . $jns_bayar_filter_3 . '
					AND t_hemodialisa.JNS_ORDER = "IRJ" 
					AND t_hemodialisa.UNIT_ID <> 9 AND t_hemodialisa.UNIT_ID <> 35
					AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL AND t_hemodialisa_tarif.ST_BATAL IS NULL
					
					UNION ALL
					SELECT "07" AS URUT,"PENERIMAAN IGD" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					t_irja.TANGGAL_DAFTAR AS TGL_MASUK,NULL AS PEGAWAI_PELAKSANA_ID,
					t_irja_tarif.KUANTITI,m_tarif_group.NAMA_TARIF_GROUP,
					m_tarif_group.NON_KELAS,m_tarif.NAMA_TARIF,
					m_tarif.TARIF_NON_KELAS,m_tarif.TARIF_KELAS_3,m_tarif.TARIF_KELAS_2,
					m_tarif.TARIF_KELAS_1,m_tarif.TARIF_KELAS_UTAMA,m_tarif.TARIF_KELAS_PERINA_SEHAT,
					m_tarif.TARIF_KELAS_PERINA_SAKIT,m_tarif.TARIF_HCU
					FROM t_irja
					INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
					AND t_irja.UNIT_ID = 9 ' . $jns_bayar_filter . '
					AND t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BATAL IS NULL
					AND m_tarif_group.KODE_TARIF_GROUP IN (' . $arr_karcis . ')
					UNION ALL
					SELECT "08" AS URUT,"PENERIMAAN IGD" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					t_irja.TANGGAL_DAFTAR AS TGL_MASUK,t_irja_tarif.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
					t_irja_tarif.KUANTITI,m_tarif_group.NAMA_TARIF_GROUP,
					m_tarif_group.NON_KELAS,"" AS NAMA_TARIF,
					m_tarif.TARIF_NON_KELAS,m_tarif.TARIF_KELAS_3,m_tarif.TARIF_KELAS_2,
					m_tarif.TARIF_KELAS_1,m_tarif.TARIF_KELAS_UTAMA,m_tarif.TARIF_KELAS_PERINA_SEHAT,
					m_tarif.TARIF_KELAS_PERINA_SAKIT,m_tarif.TARIF_HCU
					FROM t_irja
					INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
					AND t_irja.UNIT_ID = 9 ' . $jns_bayar_filter . '
					AND t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BATAL IS NULL
					AND m_tarif.KODE_TARIF_GROUP IN (' . $arr_konsul_dokter . ')
					UNION ALL
					SELECT "09" AS URUT,"PENERIMAAN IGD" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					t_irja.TANGGAL_DAFTAR AS TGL_MASUK,t_irja_tarif.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
					t_irja_tarif.KUANTITI,"TINDAKAN IGD" AS NAMA_TARIF_GROUP,
					m_tarif_group.NON_KELAS,"" AS NAMA_TARIF,
					m_tarif.TARIF_NON_KELAS,m_tarif.TARIF_KELAS_3,m_tarif.TARIF_KELAS_2,
					m_tarif.TARIF_KELAS_1,m_tarif.TARIF_KELAS_UTAMA,m_tarif.TARIF_KELAS_PERINA_SEHAT,
					m_tarif.TARIF_KELAS_PERINA_SAKIT,m_tarif.TARIF_HCU
					FROM t_irja
					INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
					AND t_irja.UNIT_ID = 9 ' . $jns_bayar_filter . '
					AND t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BATAL IS NULL
					AND m_tarif.KODE_TARIF_GROUP IN (' . $arr_tindakan_rj . ')
					UNION ALL
					SELECT "10" AS URUT,"PENERIMAAN IGD" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					irj.TANGGAL_DAFTAR AS TGL_MASUK,NULL AS PEGAWAI_PELAKSANA_ID,
					1 AS KUANTITI,"APOTIK IGD" AS NAMA_TARIF_GROUP,
					1 AS NON_KELAS,"PENERIMAAN RESEP" AS NAMA_TARIF,
					SUM(aptk_detail.HARGA_JUAL * aptk_detail.JUMLAH_KELUAR) AS TARIF_NON_KELAS,
					0 AS TARIF_KELAS_3,0 AS TARIF_KELAS_2,
					0 AS TARIF_KELAS_1,0 AS TARIF_KELAS_UTAMA,0 AS TARIF_KELAS_PERINA_SEHAT,
					0 AS TARIF_KELAS_PERINA_SAKIT,0 AS TARIF_HCU
					FROM db_inventorirs.t_farmasi_apotik_pengeluaran aptk  
					INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail aptk_detail 
					ON (aptk.FARMASI_PENGELUARAN_APOTIK_ID = aptk_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN db_inventorirs.t_rajal_resep_detail rsp_detail 
					ON (aptk_detail.RAJAL_RESEP_DETAIL_ID = rsp_detail.RAJAL_RESEP_DETAIL_ID)
					INNER JOIN db_inventorirs.t_rajal_resep rsp 
					ON (rsp_detail.RAJAL_RESEP_ID = rsp.RAJAL_RESEP_ID)
					INNER JOIN db_simrs.t_irja irj
					ON (aptk.RAJAL_ID = irj.IRJA_ID)
					WHERE aptk.NO_PENGELUARAN IS NOT NULL 
					AND aptk.JENIS_PENGELUARAN = "1"
					AND DATE_FORMAT(irj.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					' . $jns_bayar_filter_4 . '
					AND irj.UNIT_ID = 9
					GROUP BY irj.IRJA_ID,aptk.FARMASI_PENGELUARAN_APOTIK_ID,aptk.NO_RESEP
					UNION ALL
					SELECT "10" AS URUT,"PENERIMAAN IGD" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					irj.TANGGAL_DAFTAR AS TGL_MASUK,NULL AS PEGAWAI_PELAKSANA_ID,
					1 AS KUANTITI,"APOTIK IGD" AS NAMA_TARIF_GROUP,
					1 AS NON_KELAS,"RETURN RESEP" AS NAMA_TARIF,
					SUM(pgml_detail.HARGA_JUAL * pgml_detail.JUMLAH_KEMBALI) AS TARIF_NON_KELAS,
					0 AS TARIF_KELAS_3,0 AS TARIF_KELAS_2,
					0 AS TARIF_KELAS_1,0 AS TARIF_KELAS_UTAMA,0 AS TARIF_KELAS_PERINA_SEHAT,
					0 AS TARIF_KELAS_PERINA_SAKIT,0 AS TARIF_HCU
					FROM db_inventorirs.t_farmasi_apotik_pengembalian_resep pgml 
					INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep_detail pgml_detail
					ON (pgml.FARMASI_PENGEMBALIAN_APOTIK_ID = pgml_detail.FARMASI_PENGEMBALIAN_ID)
					INNER JOIN db_simrs.t_irja irj
					ON (pgml.RAJAL_ID = irj.IRJA_ID)
					WHERE pgml.NO_PENGEMBALIAN IS NOT NULL 
					AND pgml.JENIS_PENGEMBALIAN = "1"
					AND DATE_FORMAT(irj.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					' . $jns_bayar_filter_4 . '
					AND irj.UNIT_ID = 9
					GROUP BY irj.IRJA_ID,pgml.FARMASI_PENGEMBALIAN_APOTIK_ID
					UNION ALL
					SELECT "11" AS URUT,"PENERIMAAN IGD" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d%m%Y"),"%d%m%Y") AS TGL_MASUK,
					NULL AS PEGAWAI_PELAKSANA_ID,1 AS KUANTITI,
					"PENUNJANG IGD" AS NAMA_TARIF_GROUP,m_tarif_group.NON_KELAS,
					"LABORATORIUM" AS NAMA_TARIF,
					SUM(m_tarif.TARIF_NON_KELAS) AS NON_KELAS,SUM(m_tarif.TARIF_KELAS_3) AS TARIF_KELAS_3,
					SUM(m_tarif.TARIF_KELAS_2) AS TARIF_KELAS_2,SUM(m_tarif.TARIF_KELAS_1) AS TARIF_KELAS_1,
					SUM(m_tarif.TARIF_KELAS_UTAMA) AS TARIF_KELAS_UTAMA,SUM(m_tarif.TARIF_KELAS_PERINA_SEHAT) TARIF_KELAS_PERINA_SEHAT,
					SUM(m_tarif.TARIF_KELAS_PERINA_SAKIT) AS TARIF_KELAS_PERINA_SAKIT,SUM(m_tarif.TARIF_HCU) AS TARIF_HCU
					FROM t_irja 
					INNER JOIN t_ipenunjang ON (t_irja.IRJA_ID = t_ipenunjang.RAWAT_ID)
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '"  
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
					' . $jns_bayar_filter_2 . '
					AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ") 
					AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1")
					AND t_irja.UNIT_ID = 9
					GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF
					UNION ALL
					SELECT "11" AS URUT,"PENERIMAAN IGD" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d%m%Y"),"%d%m%Y") AS TGL_MASUK,
					NULL AS PEGAWAI_PELAKSANA_ID,1 AS KUANTITI,
					"PENUNJANG IGD" AS NAMA_TARIF_GROUP,m_tarif_group.NON_KELAS,
					"RADIOLOGI" AS NAMA_TARIF,
					SUM(m_tarif.TARIF_NON_KELAS) AS NON_KELAS,SUM(m_tarif.TARIF_KELAS_3) AS TARIF_KELAS_3,
					SUM(m_tarif.TARIF_KELAS_2) AS TARIF_KELAS_2,SUM(m_tarif.TARIF_KELAS_1) AS TARIF_KELAS_1,
					SUM(m_tarif.TARIF_KELAS_UTAMA) AS TARIF_KELAS_UTAMA,SUM(m_tarif.TARIF_KELAS_PERINA_SEHAT) TARIF_KELAS_PERINA_SEHAT,
					SUM(m_tarif.TARIF_KELAS_PERINA_SAKIT) AS TARIF_KELAS_PERINA_SAKIT,SUM(m_tarif.TARIF_HCU) AS TARIF_HCU
					FROM t_irja 
					INNER JOIN t_ipenunjang ON (t_irja.IRJA_ID = t_ipenunjang.RAWAT_ID)
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '"  
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
					' . $jns_bayar_filter_2 . '
					AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ") 
					AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1")
					AND t_irja.UNIT_ID = 9
					GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF
					UNION ALL
					SELECT "11" AS URUT,"PENERIMAAN IGD" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d%m%Y"),"%d%m%Y") AS TGL_MASUK,
					NULL AS PEGAWAI_PELAKSANA_ID,1 AS KUANTITI,
					"PENUNJANG IGD" AS NAMA_TARIF_GROUP,m_tarif_group.NON_KELAS,
					m_unit.NAMA_UNIT AS NAMA_TARIF,
					SUM(m_tarif.TARIF_NON_KELAS) AS NON_KELAS,SUM(m_tarif.TARIF_KELAS_3) AS TARIF_KELAS_3,
					SUM(m_tarif.TARIF_KELAS_2) AS TARIF_KELAS_2,SUM(m_tarif.TARIF_KELAS_1) AS TARIF_KELAS_1,
					SUM(m_tarif.TARIF_KELAS_UTAMA) AS TARIF_KELAS_UTAMA,SUM(m_tarif.TARIF_KELAS_PERINA_SEHAT) TARIF_KELAS_PERINA_SEHAT,
					SUM(m_tarif.TARIF_KELAS_PERINA_SAKIT) AS TARIF_KELAS_PERINA_SAKIT,SUM(m_tarif.TARIF_HCU) AS TARIF_HCU
					FROM t_irja 
					INNER JOIN t_ipenunjang ON (t_irja.IRJA_ID = t_ipenunjang.RAWAT_ID)
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					INNER JOIN m_unit ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
					WHERE DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '"  
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
					' . $jns_bayar_filter_2 . '
					AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ") 
					AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (52,31,41,42,47,40,51)
					AND t_irja.UNIT_ID = 9
					GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
					UNION ALL
					SELECT "11" AS URUT,"PENERIMAAN IGD" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d%m%Y"),"%d%m%Y") AS TGL_MASUK,
					NULL AS PEGAWAI_PELAKSANA_ID,
					t_hemodialisa_tarif.KUANTITI,"PENUNJANG IGD" AS NAMA_TARIF_GROUP,
					m_tarif_group.NON_KELAS,"Hemodialisa" AS NAMA_TARIF,
					m_tarif.TARIF_NON_KELAS,m_tarif.TARIF_KELAS_3,m_tarif.TARIF_KELAS_2,
					m_tarif.TARIF_KELAS_1,m_tarif.TARIF_KELAS_UTAMA,m_tarif.TARIF_KELAS_PERINA_SEHAT,
					m_tarif.TARIF_KELAS_PERINA_SAKIT,m_tarif.TARIF_HCU
					FROM t_hemodialisa
					INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
					INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%m%Y") = "' . $bulan . $tahun . '" 
					AND t_hemodialisa.NO_ORDER IS NOT NULL AND t_hemodialisa.ST_BATAL IS NULL
					' . $jns_bayar_filter_3 . '
					AND t_hemodialisa.JNS_ORDER = "IRJ" 
					AND t_hemodialisa.UNIT_ID = 9
					AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL AND t_hemodialisa_tarif.ST_BATAL IS NULL
					UNION ALL
					SELECT "11" AS URUT,"PENERIMAAN IGD" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d%m%Y"),"%d%m%Y") AS TGL_MASUK,
					NULL AS PEGAWAI_PELAKSANA_ID,1 AS KUANTITI,
					"PENUNJANG IGD" AS NAMA_TARIF_GROUP,m_tarif_group.NON_KELAS,
					"AMBULANCE RS" AS NAMA_TARIF,
					SUM(m_tarif.TARIF_NON_KELAS) AS NON_KELAS,SUM(m_tarif.TARIF_KELAS_3) AS TARIF_KELAS_3,
					SUM(m_tarif.TARIF_KELAS_2) AS TARIF_KELAS_2,SUM(m_tarif.TARIF_KELAS_1) AS TARIF_KELAS_1,
					SUM(m_tarif.TARIF_KELAS_UTAMA) AS TARIF_KELAS_UTAMA,SUM(m_tarif.TARIF_KELAS_PERINA_SEHAT) TARIF_KELAS_PERINA_SEHAT,
					SUM(m_tarif.TARIF_KELAS_PERINA_SAKIT) AS TARIF_KELAS_PERINA_SAKIT,SUM(m_tarif.TARIF_HCU) AS TARIF_HCU
					FROM t_irja 
					INNER JOIN t_ambulance_tarif ON (t_irja.IRJA_ID = t_ambulance_tarif.RAWAT_ID)
					INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%m%Y") = "' . $bulan . $tahun . '"  
					AND t_ambulance_tarif.NO_TARIF IS NOT NULL 
					AND (t_ambulance_tarif.ST_BAYAR = "" OR t_ambulance_tarif.ST_BAYAR = "Lunas")
					' . $jns_bayar_filter . '
					AND t_ambulance_tarif.JNS_ORDER = "IRJ" AND t_irja.UNIT_ID = 9
					AND m_tarif.KODE_TARIF_GROUP IN (' . $arr_ambulace . ')
					GROUP BY t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_TARIF
					UNION ALL
					SELECT "11" AS URUT,"PENERIMAAN IGD" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					STR_TO_DATE(DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%d%m%Y"),"%d%m%Y") AS TGL_MASUK,
					NULL AS PEGAWAI_PELAKSANA_ID,1 AS KUANTITI,
					"PENUNJANG IGD" AS NAMA_TARIF_GROUP,m_tarif_group.NON_KELAS,
					"AMBULANCE JENAZAH RS" AS NAMA_TARIF,
					SUM(m_tarif.TARIF_NON_KELAS) AS NON_KELAS,SUM(m_tarif.TARIF_KELAS_3) AS TARIF_KELAS_3,
					SUM(m_tarif.TARIF_KELAS_2) AS TARIF_KELAS_2,SUM(m_tarif.TARIF_KELAS_1) AS TARIF_KELAS_1,
					SUM(m_tarif.TARIF_KELAS_UTAMA) AS TARIF_KELAS_UTAMA,SUM(m_tarif.TARIF_KELAS_PERINA_SEHAT) TARIF_KELAS_PERINA_SEHAT,
					SUM(m_tarif.TARIF_KELAS_PERINA_SAKIT) AS TARIF_KELAS_PERINA_SAKIT,SUM(m_tarif.TARIF_HCU) AS TARIF_HCU
					FROM t_irja 
					INNER JOIN t_ambulance_tarif ON (t_irja.IRJA_ID = t_ambulance_tarif.RAWAT_ID)
					INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_ambulance_tarif.TGL_TARIF,"%m%Y") = "' . $bulan . $tahun . '"  
					AND t_ambulance_tarif.NO_TARIF IS NOT NULL 
					AND (t_ambulance_tarif.ST_BAYAR = "" OR t_ambulance_tarif.ST_BAYAR = "Lunas")
					' . $jns_bayar_filter . '
					AND t_ambulance_tarif.JNS_ORDER = "IRJ" AND t_irja.UNIT_ID = 9
					AND m_tarif.KODE_TARIF_GROUP IN (' . $arr_jenazah . ')
					GROUP BY t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.NO_TARIF
					
					UNION ALL
					SELECT "12" AS URUT,"PENERIMAAN RAWAT JALAN KUSTA" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					t_irja.TANGGAL_DAFTAR AS TGL_MASUK,NULL AS PEGAWAI_PELAKSANA_ID,
					t_irja_tarif.KUANTITI,m_tarif_group.NAMA_TARIF_GROUP,
					m_tarif_group.NON_KELAS,m_tarif.NAMA_TARIF,
					m_tarif.TARIF_NON_KELAS,m_tarif.TARIF_KELAS_3,m_tarif.TARIF_KELAS_2,
					m_tarif.TARIF_KELAS_1,m_tarif.TARIF_KELAS_UTAMA,m_tarif.TARIF_KELAS_PERINA_SEHAT,
					m_tarif.TARIF_KELAS_PERINA_SAKIT,m_tarif.TARIF_HCU
					FROM t_irja
					INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
					AND t_irja.UNIT_ID = 35 ' . $jns_bayar_filter . '
					AND t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BATAL IS NULL
					AND m_tarif_group.KODE_TARIF_GROUP IN (' . $arr_karcis . ')
					UNION ALL
					SELECT "13" AS URUT,"PENERIMAAN RAWAT JALAN KUSTA" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,t_irja.PEGAWAI_ID,
					t_irja.TANGGAL_DAFTAR AS TGL_MASUK,t_irja_tarif.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
					t_irja_tarif.KUANTITI,m_tarif_group.NAMA_TARIF_GROUP,
					m_tarif_group.NON_KELAS,"" AS NAMA_TARIF,
					m_tarif.TARIF_NON_KELAS,m_tarif.TARIF_KELAS_3,m_tarif.TARIF_KELAS_2,
					m_tarif.TARIF_KELAS_1,m_tarif.TARIF_KELAS_UTAMA,m_tarif.TARIF_KELAS_PERINA_SEHAT,
					m_tarif.TARIF_KELAS_PERINA_SAKIT,m_tarif.TARIF_HCU
					FROM t_irja
					INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
					AND t_irja.UNIT_ID = 35 ' . $jns_bayar_filter . '
					AND t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BATAL IS NULL
					AND m_tarif.KODE_TARIF_GROUP IN (' . $arr_konsul_dokter . ')
					UNION ALL
					SELECT "14" AS URUT,"PENERIMAAN RAWAT JALAN KUSTA" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,t_irja.PEGAWAI_ID,
					t_irja.TANGGAL_DAFTAR AS TGL_MASUK,t_irja_tarif.PEGAWAI_ID AS PEGAWAI_PELAKSANA_ID,
					t_irja_tarif.KUANTITI,"TINDAKAN RAWAT JALAN KUSTA" AS NAMA_TARIF_GROUP,
					m_tarif_group.NON_KELAS,"" AS NAMA_TARIF,
					m_tarif.TARIF_NON_KELAS,m_tarif.TARIF_KELAS_3,m_tarif.TARIF_KELAS_2,
					m_tarif.TARIF_KELAS_1,m_tarif.TARIF_KELAS_UTAMA,m_tarif.TARIF_KELAS_PERINA_SEHAT,
					m_tarif.TARIF_KELAS_PERINA_SAKIT,m_tarif.TARIF_HCU
					FROM t_irja
					INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
					AND t_irja.UNIT_ID = 35 ' . $jns_bayar_filter . '
					AND t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BATAL IS NULL
					AND m_tarif.KODE_TARIF_GROUP IN (' . $arr_tindakan_rj . ')
					UNION ALL
					SELECT "15" AS URUT,"PENERIMAAN RAWAT JALAN KUSTA" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					irj.TANGGAL_DAFTAR AS TGL_MASUK,NULL AS PEGAWAI_PELAKSANA_ID,
					1 AS KUANTITI,"APOTIK RAWAT JALAN KUSTA" AS NAMA_TARIF_GROUP,
					1 AS NON_KELAS,"PENERIMAAN RESEP" AS NAMA_TARIF,
					SUM(aptk_detail.HARGA_JUAL * aptk_detail.JUMLAH_KELUAR) AS TARIF_NON_KELAS,
					0 AS TARIF_KELAS_3,0 AS TARIF_KELAS_2,
					0 AS TARIF_KELAS_1,0 AS TARIF_KELAS_UTAMA,0 AS TARIF_KELAS_PERINA_SEHAT,
					0 AS TARIF_KELAS_PERINA_SAKIT,0 AS TARIF_HCU
					FROM db_inventorirs.t_farmasi_apotik_pengeluaran aptk  
					INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail aptk_detail 
					ON (aptk.FARMASI_PENGELUARAN_APOTIK_ID = aptk_detail.FARMASI_PENGELUARAN_ID)
					INNER JOIN db_inventorirs.t_rajal_resep_detail rsp_detail 
					ON (aptk_detail.RAJAL_RESEP_DETAIL_ID = rsp_detail.RAJAL_RESEP_DETAIL_ID)
					INNER JOIN db_inventorirs.t_rajal_resep rsp 
					ON (rsp_detail.RAJAL_RESEP_ID = rsp.RAJAL_RESEP_ID)
					INNER JOIN db_simrs.t_irja irj
					ON (aptk.RAJAL_ID = irj.IRJA_ID)
					WHERE aptk.NO_PENGELUARAN IS NOT NULL 
					AND aptk.JENIS_PENGELUARAN = "1"
					AND DATE_FORMAT(irj.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					' . $jns_bayar_filter_4 . '
					AND irj.UNIT_ID = 35
					GROUP BY irj.IRJA_ID,aptk.FARMASI_PENGELUARAN_APOTIK_ID,aptk.NO_RESEP
					UNION ALL
					SELECT "15" AS URUT,"PENERIMAAN RAWAT JALAN KUSTA" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					irj.TANGGAL_DAFTAR AS TGL_MASUK,NULL AS PEGAWAI_PELAKSANA_ID,
					1 AS KUANTITI,"APOTIK RAWAT JALAN KUSTA" AS NAMA_TARIF_GROUP,
					1 AS NON_KELAS,"RETURN RESEP" AS NAMA_TARIF,
					SUM(pgml_detail.HARGA_JUAL * pgml_detail.JUMLAH_KEMBALI) AS TARIF_NON_KELAS,
					0 AS TARIF_KELAS_3,0 AS TARIF_KELAS_2,
					0 AS TARIF_KELAS_1,0 AS TARIF_KELAS_UTAMA,0 AS TARIF_KELAS_PERINA_SEHAT,
					0 AS TARIF_KELAS_PERINA_SAKIT,0 AS TARIF_HCU
					FROM db_inventorirs.t_farmasi_apotik_pengembalian_resep pgml 
					INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep_detail pgml_detail
					ON (pgml.FARMASI_PENGEMBALIAN_APOTIK_ID = pgml_detail.FARMASI_PENGEMBALIAN_ID)
					INNER JOIN db_simrs.t_irja irj
					ON (pgml.RAJAL_ID = irj.IRJA_ID)
					WHERE pgml.NO_PENGEMBALIAN IS NOT NULL 
					AND pgml.JENIS_PENGEMBALIAN = "1"
					AND DATE_FORMAT(irj.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					' . $jns_bayar_filter_4 . '
					AND irj.UNIT_ID = 35
					GROUP BY irj.IRJA_ID,pgml.FARMASI_PENGEMBALIAN_APOTIK_ID
					UNION ALL
					SELECT "16" AS URUT,"PENERIMAAN RAWAT JALAN KUSTA" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d%m%Y"),"%d%m%Y") AS TGL_MASUK,
					NULL AS PEGAWAI_PELAKSANA_ID,1 AS KUANTITI,
					"PENUNJANG RAWAT JALAN KUSTA" AS NAMA_TARIF_GROUP,m_tarif_group.NON_KELAS,
					"LABORATORIUM" AS NAMA_TARIF,
					SUM(m_tarif.TARIF_NON_KELAS) AS NON_KELAS,SUM(m_tarif.TARIF_KELAS_3) AS TARIF_KELAS_3,
					SUM(m_tarif.TARIF_KELAS_2) AS TARIF_KELAS_2,SUM(m_tarif.TARIF_KELAS_1) AS TARIF_KELAS_1,
					SUM(m_tarif.TARIF_KELAS_UTAMA) AS TARIF_KELAS_UTAMA,SUM(m_tarif.TARIF_KELAS_PERINA_SEHAT) TARIF_KELAS_PERINA_SEHAT,
					SUM(m_tarif.TARIF_KELAS_PERINA_SAKIT) AS TARIF_KELAS_PERINA_SAKIT,SUM(m_tarif.TARIF_HCU) AS TARIF_HCU
					FROM t_irja 
					INNER JOIN t_ipenunjang ON (t_irja.IRJA_ID = t_ipenunjang.RAWAT_ID)
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '"  
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
					' . $jns_bayar_filter_2 . '
					AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ") 
					AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1")
					AND t_irja.UNIT_ID = 35
					GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF
					UNION ALL
					SELECT "16" AS URUT,"PENERIMAAN RAWAT JALAN KUSTA" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d%m%Y"),"%d%m%Y") AS TGL_MASUK,
					NULL AS PEGAWAI_PELAKSANA_ID,1 AS KUANTITI,
					"PENUNJANG RAWAT JALAN KUSTA" AS NAMA_TARIF_GROUP,m_tarif_group.NON_KELAS,
					"RADIOLOGI" AS NAMA_TARIF,
					SUM(m_tarif.TARIF_NON_KELAS) AS NON_KELAS,SUM(m_tarif.TARIF_KELAS_3) AS TARIF_KELAS_3,
					SUM(m_tarif.TARIF_KELAS_2) AS TARIF_KELAS_2,SUM(m_tarif.TARIF_KELAS_1) AS TARIF_KELAS_1,
					SUM(m_tarif.TARIF_KELAS_UTAMA) AS TARIF_KELAS_UTAMA,SUM(m_tarif.TARIF_KELAS_PERINA_SEHAT) TARIF_KELAS_PERINA_SEHAT,
					SUM(m_tarif.TARIF_KELAS_PERINA_SAKIT) AS TARIF_KELAS_PERINA_SAKIT,SUM(m_tarif.TARIF_HCU) AS TARIF_HCU
					FROM t_irja 
					INNER JOIN t_ipenunjang ON (t_irja.IRJA_ID = t_ipenunjang.RAWAT_ID)
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '"  
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
					' . $jns_bayar_filter_2 . '
					AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ") 
					AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1")
					AND t_irja.UNIT_ID = 35
					GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF
					UNION ALL
					SELECT "16" AS URUT,"PENERIMAAN RAWAT JALAN KUSTA" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d%m%Y"),"%d%m%Y") AS TGL_MASUK,
					NULL AS PEGAWAI_PELAKSANA_ID,1 AS KUANTITI,
					"PENUNJANG RAWAT JALAN KUSTA" AS NAMA_TARIF_GROUP,m_tarif_group.NON_KELAS,
					m_unit.NAMA_UNIT AS NAMA_TARIF,
					SUM(m_tarif.TARIF_NON_KELAS) AS NON_KELAS,SUM(m_tarif.TARIF_KELAS_3) AS TARIF_KELAS_3,
					SUM(m_tarif.TARIF_KELAS_2) AS TARIF_KELAS_2,SUM(m_tarif.TARIF_KELAS_1) AS TARIF_KELAS_1,
					SUM(m_tarif.TARIF_KELAS_UTAMA) AS TARIF_KELAS_UTAMA,SUM(m_tarif.TARIF_KELAS_PERINA_SEHAT) TARIF_KELAS_PERINA_SEHAT,
					SUM(m_tarif.TARIF_KELAS_PERINA_SAKIT) AS TARIF_KELAS_PERINA_SAKIT,SUM(m_tarif.TARIF_HCU) AS TARIF_HCU
					FROM t_irja 
					INNER JOIN t_ipenunjang ON (t_irja.IRJA_ID = t_ipenunjang.RAWAT_ID)
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					INNER JOIN m_unit ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
					WHERE DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '"  
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL AND t_ipenunjang_tarif.ST_BATAL IS NULL
					' . $jns_bayar_filter_2 . '
					AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ") 
					AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (52,31,41,42,47,40,51)
					AND t_irja.UNIT_ID = 35
					GROUP BY t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_SJP
					UNION ALL
					SELECT "16" AS URUT,"PENERIMAAN RAWAT JALAN KUSTA" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					t_irja.TANGGAL_DAFTAR AS TGL_MASUK,NULL AS PEGAWAI_PELAKSANA_ID,
					t_irja_tarif.KUANTITI,"PENUNJANG RAWAT JALAN KUSTA" AS NAMA_TARIF_GROUP,
					m_tarif_group.NON_KELAS,"Hemodialisa" AS NAMA_TARIF,
					m_tarif.TARIF_NON_KELAS,m_tarif.TARIF_KELAS_3,m_tarif.TARIF_KELAS_2,
					m_tarif.TARIF_KELAS_1,m_tarif.TARIF_KELAS_UTAMA,m_tarif.TARIF_KELAS_PERINA_SEHAT,
					m_tarif.TARIF_KELAS_PERINA_SAKIT,m_tarif.TARIF_HCU
					FROM t_irja
					INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m%Y") = "' . $bulan . $tahun . '" 
					AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
					AND t_irja.UNIT_ID = 35 ' . $jns_bayar_filter . '
					AND t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BATAL IS NULL
					AND m_tarif.KODE_TARIF_GROUP IN (' . $arr_hemodialisa . ')
					UNION ALL
					SELECT "16" AS URUT,"PENERIMAAN RAWAT JALAN KUSTA" AS NAMA_PERNERIMAAN,
					NULL AS UNIT_ID,NULL AS RUANG_ID,NULL AS KELAS,NULL AS PEGAWAI_ID,
					STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d%m%Y"),"%d%m%Y") AS TGL_MASUK,
					NULL AS PEGAWAI_PELAKSANA_ID,
					t_hemodialisa_tarif.KUANTITI,"PENUNJANG RAWAT JALAN KUSTA" AS NAMA_TARIF_GROUP,
					m_tarif_group.NON_KELAS,"Hemodialisa" AS NAMA_TARIF,
					m_tarif.TARIF_NON_KELAS,m_tarif.TARIF_KELAS_3,m_tarif.TARIF_KELAS_2,
					m_tarif.TARIF_KELAS_1,m_tarif.TARIF_KELAS_UTAMA,m_tarif.TARIF_KELAS_PERINA_SEHAT,
					m_tarif.TARIF_KELAS_PERINA_SAKIT,m_tarif.TARIF_HCU
					FROM t_hemodialisa
					INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
					INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%m%Y") = "' . $bulan . $tahun . '" 
					AND t_hemodialisa.NO_ORDER IS NOT NULL AND t_hemodialisa.ST_BATAL IS NULL
					' . $jns_bayar_filter_3 . '
					AND t_hemodialisa.JNS_ORDER = "IRJ" 
					AND t_hemodialisa.UNIT_ID = 35
					AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL AND t_hemodialisa_tarif.ST_BATAL IS NULL
					) tp
					LEFT JOIN m_unit ON (tp.UNIT_ID = m_unit.UNIT_ID)
					LEFT JOIN m_ruang ON (tp.RUANG_ID = m_ruang.RUANG_ID)
					LEFT JOIN m_pegawai ON (tp.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					LEFT JOIN m_pegawai m_pegawai2 ON (tp.PEGAWAI_PELAKSANA_ID = m_pegawai2.PEGAWAI_ID)
					GROUP BY tp.URUT,tp.NAMA_PERNERIMAAN,
					tp.NAMA_TARIF_GROUP,tp.NAMA_TARIF,m_unit.NAMA_UNIT,
					CONCAT(m_ruang.NAMA_RUANG," Kls ",m_ruang.KELAS_RAWAT),
					NAMA_DOKTER
					) tp_main
					ORDER BY tp_main.URUT,tp_main.NAMA_TARIF_GROUP,tp_main.NAMA_TARIF,
					tp_main.NAMA_UNIT,tp_main.NAMA_RUANG,tp_main.NAMA_DOKTER';
$get_pembayaran = mysql_query($qry_pembayaran) or die(mysql_error());	
$nama_penerimaan = '';
$urut = '';
$nama_tarif_group = '';
$nama_unit = '';
$no = 0;

$arr_total_k = array();
$arr_total_h = array();

$arr_total_k_view = array();
$arr_total_h_view = array();

$arr_total_k_week = array();
$arr_total_h_week = array();

$arr_total_k_view_week = array();
$arr_total_h_view_week = array();

$arr_total_k_month = 0;
$arr_total_h_month = 0;

$arr_total_k_view_month = 0;
$arr_total_h_view_month = 0;

$arr_sub_total_k = array();
$arr_sub_total_h = array();

$arr_sub_total_k_view = array();
$arr_sub_total_h_view = array();

$arr_sub_total_k_week = array();
$arr_sub_total_h_week = array();

$arr_sub_total_k_view_week = array();
$arr_sub_total_h_view_week = array();

$arr_sub_total_k_month = 0;
$arr_sub_total_h_month = 0;

$arr_sub_total_k_view_month = 0;
$arr_sub_total_h_view_month = 0;

$arr_sub_total_1_k = array();
$arr_sub_total_1_h = array();

$arr_sub_total_1_k_view = array();
$arr_sub_total_1_h_view = array();

$arr_sub_total_1_k_week = array();
$arr_sub_total_1_h_week = array();

$arr_sub_total_1_k_view_week = array();
$arr_sub_total_1_h_view_week = array();

$arr_sub_total_1_k_month = 0;
$arr_sub_total_1_h_month = 0;

$arr_sub_total_1_k_view_month = 0;
$arr_sub_total_1_h_view_month = 0;

for($h=1;$h<=$hari;$h++){
	$arr_total_k[$h] = 0;
	$arr_total_h[$h] = 0;
	
	$arr_total_k_view[$h] = 0;
	$arr_total_h_view[$h] = 0;
	
	$arr_total_k_week[$h] = 0;
	$arr_total_h_week[$h] = 0;
	
	$arr_total_k_view_week[$h] = 0;
	$arr_total_h_view_week[$h] = 0;
	
	$arr_sub_total_k[$h] = 0;
	$arr_sub_total_h[$h] = 0;
	
	$arr_sub_total_k_view[$h] = 0;
	$arr_sub_total_h_view[$h] = 0;
	
	$arr_sub_total_k_week[$h] = 0;
	$arr_sub_total_h_week[$h] = 0;
	
	$arr_sub_total_k_view_week[$h] = 0;
	$arr_sub_total_h_view_week[$h] = 0;
	
	$arr_sub_total_1_k[$h] = 0;
	$arr_sub_total_1_h[$h] = 0;
	
	$arr_sub_total_1_k_view[$h] = 0;
	$arr_sub_total_1_h_view[$h] = 0;
	
	$arr_sub_total_1_k_week[$h] = 0;
	$arr_sub_total_1_h_week[$h] = 0;
	
	$arr_sub_total_1_k_view_week[$h] = 0;
	$arr_sub_total_1_h_view_week[$h] = 0;
}

while($dat_pembayaran = mysql_fetch_array($get_pembayaran)){
	if($nama_penerimaan != '' and $nama_penerimaan != $dat_pembayaran['NAMA_PERNERIMAAN']){
		$wm = 0;
		for($f=1;$f<=$hari;$f++){
			$arr_sub_total_k_view[$f] = $arr_sub_total_k[$f];
			$arr_sub_total_h_view[$f] = $arr_sub_total_h[$f];
			
			$arr_sub_total_k[$f] = 0;
			$arr_sub_total_h[$f] = 0;
			
			if($wm != 0 and ($wm != $arr_wom[$f])){
				$arr_sub_total_k_view_week[$wm] = $arr_sub_total_k_week[$wm];
				$arr_sub_total_h_view_week[$wm] = $arr_sub_total_h_week[$wm];
				
				$arr_sub_total_k_week[$wm] = 0;
				$arr_sub_total_h_week[$wm] = 0;
			}
			if($wm != $arr_wom[$f]) $wm = $arr_wom[$f];		
		}
		$arr_sub_total_k_view_month = $arr_sub_total_k_month; 	
		$arr_sub_total_h_view_month = $arr_sub_total_h_month; 	
		
		$arr_sub_total_k_month = 0; 	
		$arr_sub_total_h_month = 0;
	}	
	
	if($nama_penerimaan != '' and $urut != $dat_pembayaran['URUT']){
		$wm = 0;
		for($f=1;$f<=$hari;$f++){
			$arr_sub_total_1_k_view[$f] = $arr_sub_total_1_k[$f];
			$arr_sub_total_1_h_view[$f] = $arr_sub_total_1_h[$f];
			
			$arr_sub_total_1_k[$f] = 0;
			$arr_sub_total_1_h[$f] = 0;
			
			if($wm != 0 and ($wm != $arr_wom[$f])){
				$arr_sub_total_1_k_view_week[$wm] = $arr_sub_total_1_k_week[$wm];
				$arr_sub_total_1_h_view_week[$wm] = $arr_sub_total_1_h_week[$wm];
				
				$arr_sub_total_1_k_week[$wm] = 0;
				$arr_sub_total_1_h_week[$wm] = 0;
			}
			if($wm != $arr_wom[$f]) $wm = $arr_wom[$f];		
		}
		$arr_sub_total_1_k_view_month = $arr_sub_total_1_k_month; 	
		$arr_sub_total_1_h_view_month = $arr_sub_total_1_h_month; 	
		
		$arr_sub_total_1_k_month = 0; 	
		$arr_sub_total_1_h_month = 0; 	
	}
	
	$pr_value = '';
	$wm = 0;
	for($f=1;$f<=$hari;$f++){ 
	   if($wm != 0 and ($wm != $arr_wom[$f])){
		   $wf = substr('00',0,2 - strlen($wm)) . $wm;
		   $pr_value .= '<td align="right">' . currFormat($dat_pembayaran['KTW_' . $wf]) . '</td>
						<td align="right">' . currFormat($dat_pembayaran['HRW_' . $wf]) . '</td>';
			$arr_total_k_week[$wm] += $dat_pembayaran['KTW_' . $wf];
			$arr_total_h_week[$wm] += $dat_pembayaran['HRW_' . $wf];			
			
			$arr_sub_total_k_week[$wm] += $dat_pembayaran['KTW_' . $wf];
			$arr_sub_total_h_week[$wm] += $dat_pembayaran['HRW_' . $wf];			
			
			$arr_sub_total_1_k_week[$wm] += $dat_pembayaran['KTW_' . $wf];
			$arr_sub_total_1_h_week[$wm] += $dat_pembayaran['HRW_' . $wf];			
	   }		
	   if($wm != $arr_wom[$f]) $wm = $arr_wom[$f];
		$yf = substr('00',0,2 - strlen($f)) . $f;
		$pr_value .= '<td align="right">' . currFormat($dat_pembayaran['KTY_' . $yf]) . '</td>
					<td align="right">' . currFormat($dat_pembayaran['HRG_' . $yf]) . '</td>';
		$arr_total_k[$f] += $dat_pembayaran['KTY_' . $yf];
		$arr_total_h[$f] += $dat_pembayaran['HRG_' . $yf];
		
		$arr_sub_total_k[$f] += $dat_pembayaran['KTY_' . $yf];
		$arr_sub_total_h[$f] += $dat_pembayaran['HRG_' . $yf];
		
		$arr_sub_total_1_k[$f] += $dat_pembayaran['KTY_' . $yf];
		$arr_sub_total_1_h[$f] += $dat_pembayaran['HRG_' . $yf];
	}
	
	$pr_value_end = '<td align="right">' . currFormat($dat_pembayaran['KTW_0' . $minggu]) . '</td>
			<td align="right">' . currFormat($dat_pembayaran['HRW_0' . $minggu]) . '</td>
			<td align="right">' . currFormat($dat_pembayaran['SBL']) . '</td>
			<td align="right">' . currFormat($dat_pembayaran['HBL']) . '</td>';
	$arr_total_k_month += $dat_pembayaran['SBL'];
	$arr_total_h_month += $dat_pembayaran['HBL'];
	
	$arr_sub_total_k_month += $dat_pembayaran['SBL'];
	$arr_sub_total_h_month += $dat_pembayaran['HBL'];
	
	$arr_sub_total_1_k_month += $dat_pembayaran['SBL'];
	$arr_sub_total_1_h_month += $dat_pembayaran['HBL'];
	
	if($nama_penerimaan != '' and $urut != $dat_pembayaran['URUT']){ 
	$urut = $dat_pembayaran['URUT']; ?>
	<tr>
     <td>&nbsp;</td>
	 <td width="10px">&nbsp;</td>
	 <td width="30px">&nbsp;</td>
     <td colspan="2"><?php echo $no . '. TOTAL PENERIMAAN ' . strtoupper($nama_tarif_group); ?></td>
	 <?php
		$wm = 0;
		for($f=1;$f<=$hari;$f++){ 
			if($wm != 0 and ($wm != $arr_wom[$f])){
				$wf = substr('00',0,2 - strlen($wm)) . $wm;
				echo '<td align="right">' . currFormat($arr_sub_total_1_k_view_week[$wm]) . '</td>
						<td align="right">' . currFormat($arr_sub_total_1_h_view_week[$wm]) . '</td>';
			}		
			if($wm != $arr_wom[$f]) $wm = $arr_wom[$f];
				echo '<td align="right">' . currFormat($arr_sub_total_1_k_view[$f]) . '</td>
					<td align="right">' . currFormat($arr_sub_total_1_h_view[$f]) . '</td>';
		}
		echo '<td align="right">' . currFormat($arr_sub_total_1_k_view_week[$minggu]) . '</td>
			<td align="right">' . currFormat($arr_sub_total_1_h_view_week[$minggu]) . '</td>
			<td align="right">' . currFormat($arr_sub_total_1_k_view_month) . '</td>
			<td align="right">' . currFormat($arr_sub_total_1_h_view_month) . '</td>';	
	?> 
    </tr>
	<?php 
	} 
	if($nama_penerimaan != '' and $nama_penerimaan != $dat_pembayaran['NAMA_PERNERIMAAN']){
		?>
		<tr>
		 <td>&nbsp;</td>
		 <td width="10px">&nbsp;</td>
		 <td width="30px">&nbsp;</td>
		 <td colspan="2"><?php echo $arr_no[$nama_penerimaan] . '. TOTAL ' . strtoupper($nama_penerimaan); ?></td>
		<?php
		$wm = 0;
		for($f=1;$f<=$hari;$f++){ 
			if($wm != 0 and ($wm != $arr_wom[$f])){
				$wf = substr('00',0,2 - strlen($wm)) . $wm;
				echo '<td align="right">' . currFormat($arr_sub_total_k_view_week[$wm]) . '</td>
						<td align="right">' . currFormat($arr_sub_total_h_view_week[$wm]) . '</td>';
			}		
			if($wm != $arr_wom[$f]) $wm = $arr_wom[$f];
				echo '<td align="right">' . currFormat($arr_sub_total_k_view[$f]) . '</td>
					<td align="right">' . currFormat($arr_sub_total_h_view[$f]) . '</td>';
		}
		echo '<td align="right">' . currFormat($arr_sub_total_k_view_week[$minggu]) . '</td>
			<td align="right">' . currFormat($arr_sub_total_h_view_week[$minggu]) . '</td>
			<td align="right">' . currFormat($arr_sub_total_k_view_month) . '</td>
			<td align="right">' . currFormat($arr_sub_total_h_view_month) . '</td>';	
		?>
		</tr>
		<?php
	}
	if($dat_pembayaran['NAMA_PERNERIMAAN'] != $nama_penerimaan){
	$nama_penerimaan = $dat_pembayaran['NAMA_PERNERIMAAN']; 
	$no = 0; ?>  
   <tr>
     <td width="20px" align="center"><?php echo $arr_no[$dat_pembayaran['NAMA_PERNERIMAAN']] . '.'; ?></td>
     <td colspan="4"><?php echo $dat_pembayaran['NAMA_PERNERIMAAN']; ?></td>
	 <td colspan="<?php echo $cn_field; ?>">&nbsp;</td>
   </tr>
	<?php } 
	if($dat_pembayaran['NAMA_TARIF_GROUP'] != $nama_tarif_group){
	$nama_tarif_group = $dat_pembayaran['NAMA_TARIF_GROUP'];
	$no++;
	?>
	<tr>
     <td align="center"><?php echo $no . '.'; ?></td>
	 <td colspan="4"><?php echo strtoupper($nama_tarif_group); ?></td>
	 <td colspan="<?php echo $cn_field; ?>">&nbsp;</td>
    </tr>
	<?php }
	if($dat_pembayaran['NAMA_TARIF'] != '' and ($dat_pembayaran['NAMA_UNIT'] == '' or $dat_pembayaran['NAMA_RUANG'] == '')){ ?>
		<tr>
			<td align="center">&nbsp;</td>
			<td colspan="4"><?php echo strtoupper($dat_pembayaran['NAMA_TARIF']); ?></td>
			<?php echo $pr_value; 
			echo $pr_value_end; ?>
		</tr>
	<?php }	
	if($dat_pembayaran['NAMA_TARIF'] == '' and ($dat_pembayaran['NAMA_UNIT'] != '' or $dat_pembayaran['NAMA_RUANG'] != '')){ 
	if($dat_pembayaran['NAMA_UNIT'] != '') $xnama_unit = $dat_pembayaran['NAMA_UNIT']; 
	if($dat_pembayaran['NAMA_RUANG'] != '') $xnama_unit = $dat_pembayaran['NAMA_RUANG'];
	if($xnama_unit != $nama_unit){	
		$nama_unit = $xnama_unit;
	?>
		<tr>
			<td align="center">&nbsp;</td>
			<td colspan="4"><?php echo strtoupper($nama_unit); ?></td>
			<?php if($dat_pembayaran['NAMA_DOKTER'] != ''){ ?>
			<td colspan="<?php echo $cn_field; ?>">&nbsp;</td>
			<?php } ?>
		</tr>
	<?php }
	}
	if($dat_pembayaran['NAMA_DOKTER'] != '' and ($dat_pembayaran['NAMA_UNIT'] != '' or $dat_pembayaran['NAMA_RUANG'] != '')){
	?>
	<tr>
     <td>&nbsp;</td>
	 <td width="10px">&nbsp;</td>
     <td colspan="3"><?php echo strtoupper($dat_pembayaran['NAMA_DOKTER']); ?></td>
	 <?php echo $pr_value; 
	echo $pr_value_end; ?>
    </tr>
	<?php }
	if($dat_pembayaran['NAMA_DOKTER'] != '' and $dat_pembayaran['NAMA_UNIT'] == '' and $dat_pembayaran['NAMA_RUANG'] == ''
		and $dat_pembayaran['NAMA_TARIF'] == ''){
	?>
	<tr>
			<td align="center">&nbsp;</td>
			<td colspan="4"><?php echo strtoupper($dat_pembayaran['NAMA_DOKTER']); ?></td>
			<?php echo $pr_value; 
			echo $pr_value_end; ?>
		</tr>
	<?php }
}?> 
<tr>
     <td>&nbsp;</td>
	 <td width="10px">&nbsp;</td>
	 <td width="30px">&nbsp;</td>
     <td colspan="2"><?php echo $no . '. TOTAL PENERIMAAN ' . strtoupper($nama_tarif_group); ?></td>
	 <?php
		$wm = 0;
		for($f=1;$f<=$hari;$f++){ 
			if($wm != 0 and ($wm != $arr_wom[$f])){
				$wf = substr('00',0,2 - strlen($wm)) . $wm;
				echo '<td align="right">' . currFormat($arr_sub_total_1_k_week[$wm]) . '</td>
						<td align="right">' . currFormat($arr_sub_total_1_h_week[$wm]) . '</td>';
			}		
			if($wm != $arr_wom[$f]) $wm = $arr_wom[$f];
				echo '<td align="right">' . currFormat($arr_sub_total_1_k[$f]) . '</td>
					<td align="right">' . currFormat($arr_sub_total_1_h[$f]) . '</td>';
		}
		echo '<td align="right">' . currFormat($arr_sub_total_1_k_week[$minggu]) . '</td>
			<td align="right">' . currFormat($arr_sub_total_1_h_week[$minggu]) . '</td>
			<td align="right">' . currFormat($arr_sub_total_1_k_month) . '</td>
			<td align="right">' . currFormat($arr_sub_total_1_h_month) . '</td>';	
	?> 
</tr>
<tr>
		 <td>&nbsp;</td>
		 <td width="10px">&nbsp;</td>
		 <td width="30px">&nbsp;</td>
		 <td colspan="2"><?php echo $arr_no[$nama_penerimaan] . '. TOTAL ' . strtoupper($nama_penerimaan); ?></td>
		<?php
		$wm = 0;
		for($f=1;$f<=$hari;$f++){ 
			if($wm != 0 and ($wm != $arr_wom[$f])){
				$wf = substr('00',0,2 - strlen($wm)) . $wm;
				echo '<td align="right">' . currFormat($arr_sub_total_k_week[$wm]) . '</td>
						<td align="right">' . currFormat($arr_sub_total_h_week[$wm]) . '</td>';
			}		
			if($wm != $arr_wom[$f]) $wm = $arr_wom[$f];
				echo '<td align="right">' . currFormat($arr_sub_total_k[$f]) . '</td>
					<td align="right">' . currFormat($arr_sub_total_h[$f]) . '</td>';
		}
		echo '<td align="right">' . currFormat($arr_sub_total_k_week[$minggu]) . '</td>
			<td align="right">' . currFormat($arr_sub_total_h_week[$minggu]) . '</td>
			<td align="right">' . currFormat($arr_sub_total_k_month) . '</td>
			<td align="right">' . currFormat($arr_sub_total_h_month) . '</td>';	
		?>
</tr>
<tr>
     <td colspan="5" align="center">TOTAL PENERIMAAN</td>
	 <?php
		$wm = 0;
		for($f=1;$f<=$hari;$f++){ 
			if($wm != 0 and ($wm != $arr_wom[$f])){
				$wf = substr('00',0,2 - strlen($wm)) . $wm;
				echo '<td align="right">' . currFormat($arr_total_k_week[$wm]) . '</td>
						<td align="right">' . currFormat($arr_total_h_week[$wm]) . '</td>';
			}		
			if($wm != $arr_wom[$f]) $wm = $arr_wom[$f];
				echo '<td align="right">' . currFormat($arr_total_k[$f]) . '</td>
					<td align="right">' . currFormat($arr_total_h[$f]) . '</td>';
		}
		echo '<td align="right">' . currFormat($arr_total_k_week[$minggu]) . '</td>
			<td align="right">' . currFormat($arr_total_h_week[$minggu]) . '</td>
			<td align="right">' . currFormat($arr_total_k_month) . '</td>
			<td align="right">' . currFormat($arr_total_h_month) . '</td>';	
	?> 
</tr>
</table>
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="bulan" value="<?php echo $bulan; ?>" />
    <input type="hidden" name="tahun" value="<?php echo $tahun; ?>" />
	<input type="hidden" name="jns_bayar" value="<?php echo $jns_bayar; ?>" />
	<input type="hidden" name="arr_karcis" value="<?php echo str_replace('"','`',$arr_karcis); ?>" />
	<input type="hidden" name="arr_konsul_dokter" value="<?php echo str_replace('"','`',$arr_konsul_dokter); ?>" />
	<input type="hidden" name="arr_operasi" value="<?php echo str_replace('"','`',$arr_operasi); ?>" />
	<input type="hidden" name="arr_tindakan_rj" value="<?php echo str_replace('"','`',$arr_tindakan_rj); ?>" />
	<input type="hidden" name="arr_hemodialisa" value="<?php echo str_replace('"','`',$arr_hemodialisa); ?>" />
	<input type="hidden" name="arr_ambulace" value="<?php echo str_replace('"','`',$arr_ambulace); ?>" />
	<input type="hidden" name="arr_jenazah" value="<?php echo str_replace('"','`',$arr_jenazah); ?>" />
    <input type="hidden" name="xlsfile" value="keuangan/xls_report_penerimaan_rawatjalan_rincian_harian.php" />
    <input type="hidden" name="xlsname" value="rpt_rekap_penerimaan_rawatjalan_rincian_harian.xls" />            
</form>
