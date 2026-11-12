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
		mysql_query('DELETE FROM db_repository.mutu_kepatuhan_identifikasi_iri WHERE KEPATUHAN_IDENTIFIKASI_ID = "' . $_GET['idi'] . '"') or die(mysql_error());
		
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=<?php echo $_GET['link']; ?>";
    </script>
    <?php
	}
}
$tgl_1 = '';
if (isset($_SESSION['kepatuhanidentifikasiiri_tgl_1']))
    $tgl_1 = $_SESSION['kepatuhanidentifikasiiri_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['kepatuhanidentifikasiiri_tgl_1']))
    $tgl_2 = $_SESSION['kepatuhanidentifikasiiri_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['kepatuhanidentifikasiiri_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['kepatuhanidentifikasiiri_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['kepatuhanidentifikasiiri_searchkey']))
		$searchkey = $_SESSION['kepatuhanidentifikasiiri_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['kepatuhanidentifikasiiri_searchkey'] = $searchkey;
}

$ruang_id = '';
if (isset($_SESSION['kepatuhanidentifikasiiri_ruang_id']))
		$ruang_id = $_SESSION['kepatuhanidentifikasiiri_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['kepatuhanidentifikasiiri_ruang_id'] = $ruang_id;
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
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt" style="width:200px;"/></td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')" /></td>
			<td>Ruang Rawat</td>
			<td><select name="ruang_id" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<?php echo getBangsal($ruang_id); ?>
			</select></td>		
			<td align="right" colspan="2"><input type="submit" value="cari" class="myButton" />
			<a href="index.php?link=d1fd8d0f045fab0932b4bcd0128bdd5b" >
			<input type="button" value="pemantauan baru" class="myButton1" /></a>
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_pasien = 'SELECT mki.KEPATUHAN_IDENTIFIKASI_ID, 
				DATE_FORMAT(mki.TGL_OBSERVASI,"%d/%m/%Y") AS TANGGAL,
				CASE WHEN mki.SEBELUM_TINDAKAN = "1" THEN "Ya"
					WHEN mki.SEBELUM_TINDAKAN = "2" THEN "Tdk"
					WHEN mki.SEBELUM_TINDAKAN = "3" THEN "NA" END AS SEBELUM_TINDAKAN,
				CASE WHEN mki.SEBELUM_PEMBERIAN_OBAT = "1" THEN "Ya"
					WHEN mki.SEBELUM_PEMBERIAN_OBAT = "2" THEN "Tdk"
					WHEN mki.SEBELUM_PEMBERIAN_OBAT = "3" THEN "NA" END AS SEBELUM_PEMBERIAN_OBAT,
				CASE WHEN mki.SEBELUM_PENGAMBILAN_SAMPLE = "1" THEN "Ya"
					WHEN mki.SEBELUM_PENGAMBILAN_SAMPLE = "2" THEN "Tdk"
					WHEN mki.SEBELUM_PENGAMBILAN_SAMPLE = "3" THEN "NA" END AS SEBELUM_PENGAMBILAN_SAMPLE,
				CASE WHEN mki.SEBELUM_PEMBERIAN_NUTRISI = "1" THEN "Ya"
					WHEN mki.SEBELUM_PEMBERIAN_NUTRISI = "2" THEN "Tdk"
					WHEN mki.SEBELUM_PEMBERIAN_NUTRISI = "3" THEN "NA" END AS SEBELUM_PEMBERIAN_NUTRISI,
				CASE WHEN mki.SEBELUM_TRANSFUSI = "1" THEN "Ya"
					WHEN mki.SEBELUM_TRANSFUSI = "2" THEN "Tdk"
					WHEN mki.SEBELUM_TRANSFUSI = "3" THEN "NA" END AS SEBELUM_TRANSFUSI,
				mki.PENGUMPUL_DATA,
				irn.IRNA_ID,irn.NOMR, 
				CONCAT(un.NAMA_RUANG,"-",un.KELAS_RAWAT) AS NAMA_RUANG,
				un.RUANG_ID,psn.NAMA_PASIEN,
				DATE_FORMAT(psn.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR
				FROM db_repository.mutu_kepatuhan_identifikasi_iri mki
				INNER JOIN db_simrs.t_irna irn ON (irn.IRNA_ID = mki.RAWAT_ID) 
				INNER JOIN db_simrs.m_pasien psn ON (irn.NOMR = psn.NOMR) 
				LEFT JOIN db_simrs.m_ruang un ON (irn.RUANG_ID = un.RUANG_ID)	
				WHERE STR_TO_DATE(DATE_FORMAT(mki.TGL_OBSERVASI,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
				AND STR_TO_DATE(DATE_FORMAT(mki.TGL_OBSERVASI,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2;

if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_pasien = $qry_pasien . ' AND CONCAT(psn.NOMR,psn.NAMA_PASIEN) LIKE "%' . $searchkey . '%" ';
}
if (!empty($ruang_id)) {
    $qry_pasien = $qry_pasien . ' AND un.BANGSAL = "' . $ruang_id . '" ';
}	
$qry_pasien = $qry_pasien . 'ORDER BY mki.KEPATUHAN_IDENTIFIKASI_ID';

$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&ruang_id=' . $ruang_id;
?>
<form name="formedukasi">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Tanggal</th>
        <th rowspan="2">Nomor MR</th>
        <th rowspan="2">Nama Pasien</th>
        <th rowspan="2">Tanggal Lahir</th>
        <th rowspan="2">Ruang Rawat</th>
        <th colspan="5">Dilakukan Identifikasi</th>
		<th rowspan="2">Action</th>
		<!--<th rowspan="2" width="100px">Register</th>-->
    </tr>
    <tr>
      <th>Sebelum<br />Tindakan</th>
      <th>Sebelum<br />Pemberian Obat</th>
	  <th>Sebelum<br />Pengambilan Sample</th>
	  <th>Sebelum<br />Pemberian Nutrisi</th>
      <th>Sebelum<br />Pemberian Transfusi</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pasien, 20, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['IRNA_ID'];
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
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
            <td><?php echo $data['NAMA_RUANG']; ?></td>
			<td align="center">
				<?php echo $data['SEBELUM_TINDAKAN']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['SEBELUM_PEMBERIAN_OBAT']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['SEBELUM_PENGAMBILAN_SAMPLE']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['SEBELUM_PEMBERIAN_NUTRISI']; ?></td>
			</td>
			<td align="center">
				<?php echo $data['SEBELUM_TRANSFUSI']; ?></td>
			</td>
			<td>
				<a href="<?php echo currentUrl(); ?>&idi=<?php echo $data['KEPATUHAN_IDENTIFIKASI_ID']; ?>&nmi=<?php echo $data['NAMA_PASIEN']; ?>" >hapus</a>
			</td>
			<!--<td><?php echo $data['PENGUMPUL_DATA']; ?></td>-->
        </tr>
        <?
    }
    ?>
</table>
</form>
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
                    <input type="hidden" name="searchkey" value="<?php echo $searchkey; ?>" />
                    <input type="hidden" name="xlsfile" value="indikator_mutu/xls_mutu_kepatuhan_identifikasi_pasien.php" />
                    <input type="hidden" name="xlsname" value="rpt_mutu_kepatuhan_identifikasi_pasien.xls" />            
        </form>		