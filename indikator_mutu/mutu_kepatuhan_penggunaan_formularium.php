<style>
.list_isi{
	height:550px;
}
</style>
<?php
$connect = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect) or die(mysql_error());

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
		mysql_query('DELETE FROM db_repository.mutu_kepatuhan_formularium WHERE KEPATUHAN_FORMULARIUM_ID = "' . $_GET['idi'] . '"') or die(mysql_error());
		
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>";
    </script>
    <?php
	}
}

$tgl_1 = '';
if (isset($_SESSION['formularium_tgl_1']))
    $tgl_1 = $_SESSION['formularium_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['formularium_tgl_1']))
    $tgl_2 = $_SESSION['formularium_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['formularium_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['formularium_tgl_2'] = $_GET['tgl_2'];
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
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>	
			<td align="right" colspan="2"><input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=5d99a940d297be9ebc8f2607abc3a8c8" >
			<input type="button" value="pemantauan baru" class="myButton1" /></a>
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT mkf.KEPATUHAN_FORMULARIUM_ID,
				mkf.RAWAT_ID,mkf.NOMR,
				mkf.FORMULARIUM,mkf.NON_FORMULARIUM,
				DATE_FORMAT(mkf.TANGGAL,"%d/%m/%Y") AS TANGGAL,
				mkf.KETERANGAN,mkf.PENGUMPUL_DATA
				FROM db_repository.mutu_kepatuhan_formularium mkf
				WHERE STR_TO_DATE(DATE_FORMAT(mkf.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
				AND STR_TO_DATE(DATE_FORMAT(mkf.TANGGAL,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2;
$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
?>
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tanggal</th>
		<th rowspan="2">Nomor MR</th>
        <th colspan="2">Kepatuhan Formularium Nas/ RS</th>
		<th rowspan="2">Keterangan</th> 
		<th rowspan="2">Action</th>
	</tr>
    <tr>
      <th>Sesuai Formularium Nas/ RS</th>
      <th>Tidak Sesuai Formularium Nas/ RS</th>
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
			<td><?php echo formatNomr($data['NOMR']); ?></td>
			<td align="right"><?php echo currFormat($data['FORMULARIUM']); ?></td>
			<td align="right"><?php echo currFormat($data['NON_FORMULARIUM']); ?></td>
			<td><?php echo $data['KETERANGAN']; ?></td>
			<td>
				<a href="<?php echo currentUrl(); ?>&idi=<?php echo $data['KEPATUHAN_FORMULARIUM_ID']; ?>&nmi=<?php echo $data['NOMR']; ?>" >hapus</a>
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
					<input type="hidden" name="xlsfile" value="indikator_mutu/xls_mutu_kepatuhan_penggunaan_formularium.php" />
                    <input type="hidden" name="xlsname" value="rpt_mutu_kepatuhan_penggunaan_formularium.xls" />            
        </form>		