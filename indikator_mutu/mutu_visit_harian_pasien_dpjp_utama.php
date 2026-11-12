<style>
.list_isi{
	height:550px;
}
</style>
<?php 
if (isset($_GET['idi'])){
	if (!isset($_GET['hapus'])) {
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $_GET['nmi']; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_GET['link']; ?>&idi=<?php echo $_GET['idi']; ?>&hapus=1";
        }else{
			window.location = "index.php?link=<?php echo $_GET['link']; ?>";
		}
    </script>
    <?php
}

	if (isset($_GET['hapus'])) {
		mysql_query('DELETE FROM db_repository.mutu_kepatuhan_jam_visit_dokter WHERE VISIT_DOKTER_ID = "' . $_GET['idi'] . '"') or die(mysql_error());
		
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>";
    </script>
    <?php
	}
}
include('shared/array_filter_report_tarif.php');
$arr_visite = getStringArrayFilter('visite');

$tgl_1 = '';
if (isset($_SESSION['visithariandpjp_tgl_1']))
    $tgl_1 = $_SESSION['visithariandpjp_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['visithariandpjp_tgl_1']))
    $tgl_2 = $_SESSION['visithariandpjp_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['visithariandpjp_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['visithariandpjp_tgl_2'] = $_GET['tgl_2'];
}

$ruang_id = '';
if (isset($_SESSION['visithariandpjp_ruang_id']))
		$ruang_id = $_SESSION['visithariandpjp_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['visithariandpjp_ruang_id'] = $ruang_id;
}

$dokter_id = '';
if (isset($_SESSION['visithariandpjp_dokter_id']))
		$dokter_id = $_SESSION['visithariandpjp_dokter_id'];

if (isset($_GET['dokter_id'])) {
    $dokter_id = $_GET['dokter_id'];
	$_SESSION['visithariandpjp_dokter_id'] = $dokter_id;
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
    <table class="tableform" border="0">
		<tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Ruang Rawat</td>
            <td><select name="ruang_id" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php echo getBangsal($ruang_id); ?>
			</select></td>	
			<td></td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
			<td>Dokter</td>
			<td><select name="dokter_id" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php echo getDokterRanap($dokter_id); ?>
			</select></td>
			<td><input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=8539cfc3e5c90973532cccd9455a664f" >
			<input type="button" value="pemantauan baru" class="myButton1" /></a>
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>	
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT vst.VISIT_DOKTER_ID, 
				DATE_FORMAT(vst.TANGGAL,"%d/%m/%Y") AS TANGGAL,
				DATE_FORMAT(vst.TANGGAL,"%H:%i") AS JAM,
				pgw.NAMA_PEGAWAI AS NAMA_DOKTER,
				rng.NAMA_RUANG,
				vst.KETERANGAN
				FROM db_repository.mutu_kepatuhan_jam_visit_dokter vst
				INNER JOIN db_simrs.m_pegawai pgw ON (vst.PEGAWAI_ID = pgw.PEGAWAI_ID)
				INNER JOIN db_simrs.m_ruang rng ON (vst.RUANG_ID = rng.RUANG_ID)
				WHERE STR_TO_DATE(DATE_FORMAT(vst.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
				AND STR_TO_DATE(DATE_FORMAT(vst.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2;	
if (!empty($ruang_id)) {
    $qry_pasien = $qry_pasien . ' AND rng.BANGSAL = "' . $ruang_id . '" ';
}
if (!empty($dokter_id)) {
    $qry_pasien = $qry_pasien . ' AND vst.PEGAWAI_ID = "' . $dokter_id . '" ';
}

$qry_pasien = $qry_pasien . ' ORDER BY vst.TANGGAL';			

$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&ruang_id=' . $ruang_id;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tanggal</th>
        <th rowspan="2">Unit - Ruang</th>
		<th rowspan="2">Nama Dokter</th>
		<th colspan="2">Waktu Visite</th>
		<th rowspan="2">Keterangan</th>
		<th rowspan="2">Action</th>
    </tr>
	  <tr>
      <th>< 11.00</th>
	  <th>> 11.00</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pasien, 20, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        ?>
        <tr>
            <td align="center"><?
    $no = ($no + 1);
    if (isset($_GET['page'])) {
        if ($_GET['page'] == 0) {
            $hal = 0;
        } else {
            $hal = $_GET['page'] - 1;
        }
    } else {
        $hal = 0;
    }
    echo ($hal * 20) + $no;
        ?></td>
            <td align="center"><?php echo $data['TANGGAL']; ?></td>
            <td><?php echo $data['NAMA_RUANG']; ?></td>
			<td><?php echo $data['NAMA_DOKTER']; ?></td>
			<?php
			$jam_visite_1 = '';
			$jam_visite_2 = '';
			$arr_waktu_visite = explode(':',$data['JAM']);
			if(sizeof($arr_waktu_visite) == 2){
				$waktu_visite = ($arr_waktu_visite[0] * 60) + $arr_waktu_visite[1];
				if($waktu_visite <= 660) $jam_visite_1 =  $data['JAM'];	
				if($waktu_visite > 660) $jam_visite_2 =  $data['JAM'];	
			}	
		?>	
        <td align="center"><?php echo $jam_visite_1; ?></td>
		<td align="center"><?php echo $jam_visite_2; ?></td>
        <td><?php echo $data['KETERANGAN']; ?></td>
		<td>
				<a href="<?php echo currentUrl(); ?>&idi=<?php echo $data['VISIT_DOKTER_ID']; ?>&nmi=<?php echo $data['NAMA_DOKTER']; ?>" >hapus</a>
			</td>
        </tr>
        <?
    }
    ?>
</table>
<table width="100%" border="0" height="50%" class="tableNav" >
            <tr >
                <td align="right" valign="middle" >
                    <div style="background-color:#fff; height:80%; width:30%">
                        <table width="100%" align="center" height="100%" class="tableNavSub">
                            <tr>
								<td align="center">
                                    <?php
                                    echo $pager->renderSummary();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?php
                                    echo $pager->renderFirst();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderPrev();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNav();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNext();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderLast();
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>
        </table>
<form id="xls_export" name="xls_export" method="post">
                    <input type="hidden" name="page_to_excel" value="1" />
                    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
                    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
					<input type="hidden" name="ruang_id" value="<?php echo $ruang_id; ?>" />
                    <input type="hidden" name="dokter_id" value="<?php echo $dokter_id; ?>" />
                    <input type="hidden" name="xlsfile" value="indikator_mutu/xls_mutu_visit_dokter_spesialis.php" />
                    <input type="hidden" name="xlsname" value="rpt_mutu_visit_dokter_spesialis.xls" />            
        </form>				